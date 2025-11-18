<?php

namespace App\Livewire\Collections;

use App\Models\Collections;
use App\Models\Colors;
use App\Models\Types;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CollectionForm extends Component
{

    use AuthorizesRequests; 

    public $types;
    public $colors;
    public $editing = false;
    public $collection;
    public $id;
    public $type_id;
    public $name;
    public $name_arabic;
    public $show_name;
    public $description;
    public $description_arabic;
    public $show_description;
    public $description_position;
    public $view_all_title;
    public $view_all_title_arabic;
    public $view_all_link;
    public $show_view_all;
    public $background_color_id;
    public $with_border_bottom;
    public $with_filters;
    public $filter_fields;
    public $entries_selection;
    public $entries_number;
    public $entries_with_expired;
    public $entries_order;
    public $title_position;
    public $with_label;
    public $entries_layout;
    public $entries_per_row;
    public $with_featured_image;
    public $featured_image_width;
    public $featured_image_background_color_id;	
    public $featured_image_description_position;
    

    public $entries_order_options=[];

    public $featured_image_width_options=[];

    public function mount($id=''){  

        $this->entries_order_options=['1'=>'Name ASC','2'=>'Name DESC','3'=>'Date ASC','4'=>'Date DESC'];

        $this->entries_order_options=['1'=>'Name ASC','2'=>'Name DESC','3'=>'Date ASC','4'=>'Date DESC'];
        $this->featured_image_width_options=['1'=>'Full','2'=>'three-quarters']; //'3'=>'one-half' '4'=>'one-quarter'
        
        if($id==''){
            $this->authorize('collection-create');
            $this->show_name=true;
            $this->show_description=true;
            $this->show_view_all=false;
            $this->with_border_bottom=true;
            $this->description_position=0;
            $this->with_filters=0;
            $this->with_label=1;
            $this->entries_selection=1;
            $this->entries_with_expired=0;
            $this->title_position=0;
            $this->entries_layout=1;
            $this->with_featured_image=0;
            $this->featured_image_description_position=0;
        }
        else{

            $this->authorize('collection-edit');

            $this->editing = true;

            $this->id=$id;

            $this->collection=Collections::find($id);
            $this->type_id=$this->collection->type_id;
            $this->name=$this->collection->name;
            $this->name_arabic=$this->collection->name_arabic;
            $this->show_name=$this->collection->show_name == 1 ? true : false;
            $this->description=$this->collection->description;
            $this->description_arabic=$this->collection->description_arabic;
            $this->show_description=$this->collection->show_description == 1 ? true : false;
            $this->description_position=$this->collection->description_position;
            $this->view_all_title=$this->collection->view_all_title;
            $this->view_all_title_arabic=$this->collection->view_all_title_arabic;
            $this->view_all_link=$this->collection->view_all_link;
            $this->show_view_all=$this->collection->show_view_all == 1 ? true : false;
            $this->background_color_id=$this->collection->background_color_id;
            $this->with_border_bottom=$this->collection->with_border_bottom == 1 ? true : false;
            $this->with_filters=$this->collection->with_filters;
            $this->filter_fields=$this->collection->filter_fields;
            $this->entries_selection=$this->collection->entries_selection;
            $this->entries_number=$this->collection->entries_number;
            $this->entries_with_expired=$this->collection->entries_with_expired;
            $this->entries_order=$this->collection->entries_order;
            $this->title_position=$this->collection->title_position;
            $this->with_label=$this->collection->with_label;
            $this->entries_layout=$this->collection->entries_layout;
            $this->entries_per_row=$this->collection->entries_per_row;
            $this->with_featured_image=$this->collection->with_featured_image;
            $this->featured_image_width=$this->collection->featured_image_width;
            $this->featured_image_background_color_id=$this->collection->featured_image_background_color_id;
            $this->featured_image_description_position=$this->collection->featured_image_description_position;
        }

        $this->types=Types::all();
        $this->colors=Colors::all();
        
    }


    public function rules()
    {
        $data = [
            'type_id' => ['required'],
            'name' => ['required'],
            'name_arabic' => ['required'],
            'show_name' => ['nullable'],
            'description' => ['nullable'],
            'description_arabic' => ['nullable'],
            'show_description' => ['nullable'],
            'description_position' => ['required'],
            'view_all_title' => ['nullable'],
            'view_all_title_arabic' => ['nullable'],
            'view_all_link' => ['nullable'],
            'show_view_all' => ['nullable'],
            'background_color_id' => ['nullable'],
            'with_border_bottom' => ['nullable'],
            'with_filters' => ['nullable'],
            'filter_fields' => ['nullable'],
            'entries_selection' => ['nullable'],
            'entries_number' => ['required_if:entries_selection,2'],
            'entries_with_expired' => ['required_if:entries_selection,2'],
            'entries_order' => ['required_if:entries_selection,2'],
            'title_position' => ['required'],
            'with_label' => ['required'],
            'entries_layout' => ['required'],
            'entries_per_row' => ['required'],
            'with_featured_image' => ['nullable'],
            'featured_image_width' => ['required_if:with_featured_image,1'],
            'featured_image_background_color_id' => ['nullable'],	
            'featured_image_description_position' => ['nullable'],
        ];

        return $data;
    }

    public function store()
    {

        $this->validate();

        if($this->id==''){
            Collections::create([
                'type_id'=>$this->type_id,
                'name'=>$this->name,
                'name_arabic'=>$this->name_arabic,
                'show_name'=> $this->show_name,
                'description'=>$this->description,
                'description_arabic'=>$this->description_arabic,
                'show_description'=> $this->show_description,
                'description_position'=>$this->description_position,
                'view_all_title'=>$this->view_all_title,
                'view_all_title_arabic'=>$this->view_all_title_arabic,
                'view_all_link'=>$this->view_all_link,
                'show_view_all'=>$this->show_view_all,
                'background_color_id'=>$this->background_color_id,
                'with_border_bottom'=> $this->with_border_bottom,
                'with_filters'=>$this->with_filters,
                'filter_fields'=>$this->filter_fields,
                'entries_selection'=>$this->entries_selection,
                'entries_number'=>$this->entries_number,
                'entries_with_expired'=>$this->entries_with_expired,
                'entries_order'=>$this->entries_order,
                'title_position'=>$this->title_position,
                'with_label'=>$this->with_label,
                'entries_layout'=>$this->entries_layout,
                'entries_per_row'=>$this->entries_per_row,
                'with_featured_image'=>$this->with_featured_image,
                'featured_image_width'=>$this->featured_image_width,
                'featured_image_background_color_id'=>$this->featured_image_background_color_id,	
                'featured_image_description_position'=>$this->featured_image_description_position,
            ]);

            return to_route('collections')->with('success', 'Collection created successfully!');
        }
        else if($this->id!=''){
            $data = [
                'type_id'=>$this->type_id,
                'name'=>$this->name,
                'name_arabic'=>$this->name_arabic,
                'show_name'=>$this->show_name,
                'description'=>$this->description,
                'description_arabic'=>$this->description_arabic,
                'show_description'=>$this->show_description,
                'description_position'=>$this->description_position,
                'view_all_title'=>$this->view_all_title,
                'view_all_title_arabic'=>$this->view_all_title_arabic,
                'view_all_link'=>$this->view_all_link,
                'show_view_all'=>$this->show_view_all,
                'background_color_id'=>$this->background_color_id,
                'with_border_bottom'=>$this->with_border_bottom,
                'with_filters'=>$this->with_filters,
                'filter_fields'=>$this->filter_fields,
                'entries_selection'=>$this->entries_selection,
                'entries_number'=>$this->entries_number,
                'entries_with_expired'=>$this->entries_with_expired,
                'entries_order'=>$this->entries_order,
                'title_position'=>$this->title_position,
                'with_label'=>$this->with_label,
                'entries_layout'=>$this->entries_layout,
                'entries_per_row'=>$this->entries_per_row,
                'with_featured_image'=>$this->with_featured_image,
                'featured_image_width'=>$this->featured_image_width,
                'featured_image_background_color_id'=>$this->featured_image_background_color_id,	
                'featured_image_description_position'=>$this->featured_image_description_position,
            ];

            $this->collection->update($data);

            return to_route('collections')->with('success', 'Collection updated successfully!');
            
        }
        
    }

    public function render()
    {
        return view('livewire.collections.collection-form');
    }

}
