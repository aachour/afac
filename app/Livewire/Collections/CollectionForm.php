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
    public $description;
    public $description_arabic;
    public $description_position;
    public $background_color_id;
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
    public $featured_image_text;
 
    public function mount($id=''){

        if($id==''){
            $this->authorize('collection-create');
            $this->entries_selection=1;
        }
        else{

            $this->authorize('collection-edit');

            $this->editing = true;

            $this->id=$id;

            $this->collection=Collections::find($id);
            $this->type_id=$this->collection->type_id;
            $this->name=$this->collection->name;
            $this->name_arabic=$this->collection->name_arabic;
            $this->description=$this->collection->description;
            $this->description_arabic=$this->collection->description_arabic;
            $this->description_position=$this->collection->description_position;
            $this->background_color_id=$this->collection->background_color_id;
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
            $this->featured_image_text=$this->collection->featured_image_text;
            
        }

        $this->types=Types::all();
        $this->colors=Colors::all();
        
    }

    public function updatedEntries_selection($value)
    {
        dd($value);
    }


    public function rules()
    {
        $data = [
            'type_id' => ['required'],
            'name' => ['required'],
            'name_arabic' => ['required'],
            'description' => ['nullable'],
            'description_arabic' => ['nullable'],
            'description_position' => ['required'],
            'background_color_id' => ['nullable'],
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
            'featured_image_width' => ['required_with:with_featured_image'],
            'featured_image_background_color_id' => ['required_with:with_featured_image'],	
            'featured_image_text' => ['required_with:with_featured_image'],
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
                'description'=>$this->description,
                'description_arabic'=>$this->description_arabic,
                'description_position'=>$this->description_position,
                'background_color_id'=>$this->background_color_id,
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
                'featured_image_text'=>$this->featured_image_text,
            ]);

            return to_route('collections')->with('success', 'Collection created successfully!');
        }
        else if($this->id!=''){

            $data = [
                'type_id'=>$this->type_id,
                'name'=>$this->name,
                'name_arabic'=>$this->name_arabic,
                'description'=>$this->description,
                'description_arabic'=>$this->description_arabic,
                'description_position'=>$this->description_position,
                'background_color_id'=>$this->background_color_id,
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
                'featured_image_text'=>$this->featured_image_text,
            ];

            $this->page->update($data);

            return to_route('collections')->with('success', 'Collection updated successfully!');
            
        }
        
    }

    public function render()
    {
        return view('livewire.collections.collection-form');
    }
}
