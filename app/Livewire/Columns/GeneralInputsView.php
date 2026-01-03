<?php

namespace App\Livewire\Columns;

use App\Models\InputTypes;
use App\Models\Colors;
use App\Models\Shapes;
use App\Models\ColumnGeneral;
use App\Models\Gallery;
use App\Models\GalleryImages;
use App\Models\PageSections;


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
    public $entry_id;
    public $return_route;

    public $section_id;
    public $section_column_id;

    public $inputTypes;
    public $colors;
    public $shapes;
    public $generalInputs;

    public $input_type_id;
    public $title;
    public $title_arabic;
    public $text;
    public $text_arabic;
    public $gallery_id;
    public $gallery;
    public $gallery_images = [];
    public $gallery_image_inputs = [];
    
    public $video;
    public $btnImagePreview;
    public $button_value;
    public $button_value_arabic;
    public $button_shape_id;
    public $button_hover_shape_id;
    public $button_color_id;
    public $button_hover_color_id;
    public $button_bg_color_id;
    public $button_hover_bg_color_id;
    public $button_link;
    public $button_link_arabic;
        
    public function mount($sectionId,$id)
    {

        $this->authorize('section-list');

        $this->modalId=null;

        $pageSection=PageSections::WHERE('section_id',$sectionId)->first();
        
        if($pageSection){
            $this->page_id=$pageSection->page_id;
            $this->entry_id=$pageSection->entry_id;
        }else{
            return to_route('dashboard');
        }

        if($this->page_id!=null){
            $this->return_route="general.view";
        }else if($this->entry_id!=null){
            $this->return_route="entry.general.view";
        }

        // dd($this->return_route);

        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->inputTypes=InputTypes::all();
        $this->colors=Colors::all();
        $this->shapes=Shapes::all();
        
        
        $this->loadEntries();

    }

    #[On('reset-modal')]
    public function clearData()
    {
        $this->reset([
            'modalId',
            'input_type_id',
            'title',
            'title_arabic',
            'text',
            'text_arabic',
            'gallery_id',
            'gallery',
            'gallery_images',
            'gallery_image_inputs',
            'video',
            'btnImagePreview',
            'button_value',
            'button_value_arabic',
            'button_shape_id',
            'button_hover_shape_id',
            'button_color_id',
            'button_hover_color_id',
            'button_bg_color_id',
            'button_hover_bg_color_id',
            'button_link',
            'button_link_arabic',
        ]);
        
        $this->dispatch('activateCkeditor');
    }

    public function loadEntries()
    {
        $this->generalInputs=ColumnGeneral::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
    }

    public function updatedInputTypeId($value)
    {
        if($value==2){
            $this->dispatch('activateCkeditor');
        }
    }


    public function editEntry($id)
    {
        $generalInput=ColumnGeneral::with('gallery','gallery.images')->find($id);
        $this->input_type_id=$generalInput->input_type_id;
        
        $this->title=$generalInput->title;
        $this->title_arabic=$generalInput->title_arabic;
        $this->text=$generalInput->text;
        $this->text_arabic=$generalInput->text_arabic;
        $this->gallery_id=$generalInput->gallery_id;
        $this->video=$generalInput->video;
        $this->button_value=$generalInput->button_value;
        $this->button_value_arabic=$generalInput->button_value_arabic;
        $this->button_shape_id=$generalInput->button_shape_id;
        $this->button_hover_shape_id=$generalInput->button_hover_shape_id;
        $this->button_color_id=$generalInput->button_color_id;
        $this->button_hover_color_id=$generalInput->button_hover_color_id;
        $this->button_bg_color_id=$generalInput->button_bg_color_id;
        $this->button_hover_bg_color_id=$generalInput->button_hover_bg_color_id;
        $this->button_link=$generalInput->button_link;
        $this->button_link_arabic=$generalInput->button_link_arabic;
        $this->modalId=$id;
        if($this->input_type_id==2){
            $this->dispatch('activateCkeditor');
        }

    }


    public function saveEntry()
    {

        if($this->modalId==null){

            //Create a gallery
            if($this->input_type_id==3){

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
                'title'             => $this->title,
                'title_arabic'      => $this->title_arabic,
                'text'              => $this->text,
                'text_arabic'       => $this->text_arabic,
                'gallery_id'        => $this->gallery_id,
                'video'             => $this->video,
                'button_value'      => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'button_shape_id'      => $this->button_shape_id,
                'button_hover_shape_id'      => $this->button_hover_shape_id,
                'button_color_id'      => $this->button_color_id,
                'button_hover_color_id'      => $this->button_hover_color_id,
                'button_bg_color_id'      => $this->button_bg_color_id,
                'button_hover_bg_color_id'      => $this->button_hover_bg_color_id,
                'button_link'       => $this->button_link,
                'button_link_arabic'       => $this->button_link_arabic,
                'list_order'        => $highestOrder + 1
            ]);


            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
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
   
            ColumnGeneral::where('id', $this->modalId)->update(
                [
                    'title'             => $this->title,
                    'title_arabic'      => $this->title_arabic,
                    'text'              => $this->text,
                    'text_arabic'       => $this->text_arabic,
                    'gallery_id'        => $this->gallery_id,
                    'video'             => $this->video,
                    'button_value'      => $this->button_value,
                    'button_value_arabic'      => $this->button_value_arabic,
                    'button_shape_id'      => $this->button_shape_id,
                    'button_hover_shape_id'      => $this->button_hover_shape_id,
                    'button_color_id'      => $this->button_color_id,
                    'button_hover_color_id'      => $this->button_hover_color_id,
                    'button_bg_color_id'      => $this->button_bg_color_id,
                    'button_hover_bg_color_id'      => $this->button_hover_bg_color_id,
                    'button_link'       => $this->button_link,
                    'button_link_arabic'       => $this->button_link_arabic,
                ]
            );
            
            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }


    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnGeneral::where(['section_column_id'=>$this->section_column_id,'id'=>$id])->update(['list_order' => $index+1]);
        }

        return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }


    #[On('delete')]
    public function delete($id)
    {
        $generalInput = ColumnGeneral::find($id);

        $generalInput->delete();

        return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }


    public function showGallery($id,$galleryId){
        $this->gallery_id=$galleryId;
        $generalInput=ColumnGeneral::with('gallery','gallery.images')->WHERE('gallery_id',$galleryId)->first();
        $this->gallery=$generalInput->gallery;
        $this->gallery_images=$this->gallery->images;

        if($this->gallery_images){
            foreach($this->gallery_images as $gallery_image){
                $obj=[
                    'caption'         => $gallery_image->caption,
                    'caption_arabic'  => $gallery_image->caption_arabic,
                    'link'            => $gallery_image->link,
                ];
                $this->gallery_image_inputs []= $obj;
            }
        }

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


    public function deleteGalleryImage($id)
    {
        $galleryImage = GalleryImages::find($id);

        $galleryImage->delete();

        $this->gallery_images=[];
        $this->showGallery($this->section_column_id,$this->gallery_id);

    }

    public function editGalleryImage($id,$key){

        $galleryImage = GalleryImages::find($id);
        if (!$galleryImage) return;

        $galleryImage->update([
            'caption'         => $this->gallery_image_inputs[$key]['caption'],
            'caption_arabic'  => $this->gallery_image_inputs[$key]['caption_arabic'],
            'link'            => $this->gallery_image_inputs[$key]['link'],
        ]);

        $this->gallery_images=[];
        $this->showGallery($this->section_column_id,$this->gallery_id);
    }

    public function render()
    {
        return view('livewire.columns.general-inputs-view');
    }

}
