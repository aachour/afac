<?php

namespace App\Livewire\Columns;

use App\Models\InputTypes;
use App\Models\Colors;
use App\Models\ColumnGeneral;
use App\Models\Gallery;
use App\Models\GalleryImages;

use Livewire\WithFileUploads;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GeneralInputsView extends Component
{

    use WithFileUploads;
    use AuthorizesRequests; 

    public $modalId = null;
    
    public $page_id;
    public $section_id;
    public $section_column_id;

    public $inputTypes;
    public $colors;
    public $generalInputs;

    public $bg_color_id;
    public $input_type_id;
    public $title;
    public $text;
    public $gallery_id;
    public $gallery;
    public $gallery_images = [];
    
    public $video;
    public $percentage;
    public $button_value;
    public $button_shape;
    public $button_link;
    
    
    public function mount($pageId,$sectionId,$id)
    {

        $this->authorize('section-list');

        $this->modalId=null;
        
        $this->page_id=$pageId;
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->inputTypes=InputTypes::all();
        $this->colors=Colors::all();
        
        $this->loadEntries();

    }


    public function loadEntries()
    {
        $this->generalInputs=ColumnGeneral::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
    }


    public function editEntry($id)
    {
        $generalInput=ColumnGeneral::with('gallery','gallery.images')->find($id);
        $this->input_type_id=$generalInput->input_type_id;
        $this->bg_color_id=$generalInput->bg_color_id;
        $this->title=$generalInput->title;
        $this->text=$generalInput->text;
        $this->gallery_id=$generalInput->gallery_id;
        $this->video=$generalInput->video;
        $this->percentage=$generalInput->percentage;
        $this->button_value=$generalInput->button_value;
        $this->button_shape=$generalInput->button_shape;
        $this->button_link=$generalInput->button_link;
        $this->modalId=$id;

    }


    public function showGallery($id,$galleryId){
        $this->gallery_id=$galleryId;
        $generalInput=ColumnGeneral::with('gallery','gallery.images')->WHERE('gallery_id',$galleryId)->first();
        $this->gallery=$generalInput->gallery;
        $this->gallery_images=$this->gallery->images;
    }


    public function saveEntry()
    {

        if($this->modalId==null){

            if($this->input_type_id==3){

                //Create a gallery
                $this->gallery_id = Gallery::create()->id;

                foreach ($this->gallery_images as $key=>$image) {
                    // Save to storage/app/public/gallery
                    $path = $image->store('gallery', 'public');

                    GalleryImages::create([
                        'gallery_id' => $this->gallery_id,
                        'image_path' => $path,
                        'list_order' => $key+1,
                    ]);
                    
                }
            }

            //Add collection
            $highestOrder = ColumnGeneral::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            ColumnGeneral::create([
                'section_column_id' => $this->section_column_id,
                'input_type_id'     => $this->input_type_id,
                'bg_color_id'       => $this->bg_color_id,
                'title'             => $this->title,
                'text'              => $this->text,
                'gallery_id'        => $this->gallery_id,
                'video'             => $this->video,
                'percentage'        => $this->percentage,
                'button_value'      => $this->button_value,
                'button_shape'      => $this->button_shape,
                'button_link'       => $this->button_link,
                'list_order'        => $highestOrder + 1
            ]);


            return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Edit Collection

            if($this->input_type_id==3){
                $highestOrder = GalleryImages::WHERE('gallery_id',$this->gallery_id)->max('list_order');

                foreach ($this->gallery_images as $key=>$image) {
                    // Save to storage/app/public/gallery
                    $path = $image->store('gallery', 'public');

                    GalleryImages::create([
                        'gallery_id' => $this->gallery_id,
                        'image_path' => $path,
                        'list_order' => $highestOrder+$key+1,
                    ]);
                    
                }

            }
            else{
                ColumnGeneral::where('id', $this->modalId)
                    ->update([
                        'bg_color_id'       => $this->bg_color_id,
                        'title'             => $this->title,
                        'text'              => $this->text,
                        'gallery_id'        => $this->gallery_id,
                        'video'             => $this->video,
                        'percentage'        => $this->percentage,
                        'button_value'      => $this->button_value,
                        'button_shape'      => $this->button_shape,
                        'button_link'       => $this->button_link,
                    ]);
            }
            
            return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }


    #[On('delete')]
    public function delete($id)
    {
        $generalInput = ColumnGeneral::find($id);

        $generalInput->delete();

        return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }


    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnGeneral::where(['section_column_id'=>$this->section_column_id,'id'=>$id])->update(['list_order' => $index+1]);
        }

        return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }


    #[On('updateGalleryOrder')]
    public function updateGalleryOrder(array $order)
    {
        foreach ($order as $index => $id) {
            GalleryImages::where(['gallery_id'=> $this->gallery_id ,'id'=> $id])->update(['list_order' => $index+1]);
        }
        $this->gallery_images=[];
        $this->showGallery($this->section_column_id,$this->gallery_id);

    }


    public function render()
    {
        return view('livewire.columns.general-inputs-view');
    }

}
