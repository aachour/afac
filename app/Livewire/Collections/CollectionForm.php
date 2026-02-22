<?php

namespace App\Livewire\Collections;

use App\Models\Collections;
use App\Models\Colors;
use App\Models\Types;
use App\Models\Entries;
use App\Models\ProgramYears;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CollectionForm extends Component
{

    use AuthorizesRequests; 

    public $types;
    public $colors;
    public $programs;
    public $programYears;
    public $editing = false;
    public $collection;
    public $id;
    public $type_id;
    public $calendar_view;
    public $name;
    public $name_arabic;
    public $show_name;
    public $description;
    public $description_arabic;
    public $show_description;
    public $view_all_title;
    public $view_all_title_arabic;
    public $view_all_link;
    public $view_all_link_arabic;
    public $show_view_all;
    public $show_projects_grantees;
    public $background_color_id;
    public $button_text;
    public $button_text_arabic;
    public $button_background_color_id;
    public $with_border_bottom;
    public $with_filters;
    public $filter_fields;
    public $entries_selection;
    public $entries_number;
    public $show_all_entries;
    public $entries_with_expired;
    public $entries_order;
    public $entries_program_id;
    public $entries_program_year_id;
    public $title_position;
    public $with_label;
    public $entries_layout;
    public $entries_per_row;
    public $with_featured_image;
    public $all_featured;
    public $featured_image_width;
    public $featured_image_background_color_id;	
    public $featured_image_description_position;
    
    public $entries_order_options=[];

    public $featured_image_width_options=[];

    public function mount($id=''){  

        $this->entries_order_options=['1'=>'Name ASC','2'=>'Name DESC','3'=>'Date ASC','4'=>'Date DESC'];

        $this->entries_order_options=['1'=>'Name ASC','2'=>'Name DESC','3'=>'Date ASC','4'=>'Date DESC'];
        $this->featured_image_width_options=['1'=>'Full','2'=>'three-quarters']; //'3'=>'one-half' '4'=>'one-quarter'

        $this->programs=Entries::WHERE('type_id','2')->ORDERBY('id','DESC')->get();
        $this->programYears=[];
        
        if($id==''){
            $this->authorize('collection-create');
            $this->calendar_view=false;
            $this->show_name=true;
            $this->show_description=true;
            $this->show_view_all=false;
            $this->show_projects_grantees=false;
            $this->with_border_bottom=true;
            $this->with_filters=0;
            $this->show_all_entries=false;
            $this->with_label=1;
            $this->entries_selection=1;
            $this->entries_with_expired=0;
            $this->title_position=0;
            $this->entries_layout=1;
            $this->with_featured_image=0;
            $this->all_featured=false;
            $this->featured_image_description_position=0;
        }
        else{

            $this->authorize('collection-edit');

            $this->editing = true;

            $this->id=$id;

            $this->collection=Collections::find($id);
            $this->type_id=$this->collection->type_id;
            $this->calendar_view=$this->collection->calendar_view == 1 ? true : false;
            $this->name=$this->collection->name;
            $this->name_arabic=$this->collection->name_arabic;
            $this->show_name=$this->collection->show_name == 1 ? true : false;
            $this->description=$this->collection->description;
            $this->description_arabic=$this->collection->description_arabic;
            $this->show_description=$this->collection->show_description == 1 ? true : false;
            $this->view_all_title=$this->collection->view_all_title;
            $this->view_all_title_arabic=$this->collection->view_all_title_arabic;
            $this->view_all_link=$this->collection->view_all_link;
            $this->view_all_link_arabic=$this->collection->view_all_link_arabic;
            $this->show_view_all=$this->collection->show_view_all == 1 ? true : false;
            $this->show_projects_grantees=$this->collection->show_projects_grantees == 1 ? true : false;
            $this->background_color_id=$this->collection->background_color_id;
            $this->button_text=$this->collection->button_text;
            $this->button_text_arabic=$this->collection->button_text_arabic;
            $this->button_background_color_id=$this->collection->button_background_color_id;
            $this->with_border_bottom=$this->collection->with_border_bottom == 1 ? true : false;
            $this->with_filters=$this->collection->with_filters;
            $this->filter_fields=$this->collection->filter_fields;
            $this->entries_selection=$this->collection->entries_selection;
            $this->entries_number=$this->collection->entries_number;
            $this->show_all_entries=$this->collection->show_all_entries == 1 ? true : false;
            $this->entries_with_expired=$this->collection->entries_with_expired;
            $this->entries_order=$this->collection->entries_order;
            $this->entries_program_id=$this->collection->entries_program_id;
            $this->entries_program_year_id=$this->collection->entries_program_year_id;
            $this->title_position=$this->collection->title_position;
            $this->with_label=$this->collection->with_label;
            $this->entries_layout=$this->collection->entries_layout;
            $this->entries_per_row=$this->collection->entries_per_row;
            $this->with_featured_image=$this->collection->with_featured_image;
            $this->all_featured=$this->collection->all_featured == 1 ? true : false;
            $this->featured_image_width=$this->collection->featured_image_width;
            $this->featured_image_background_color_id=$this->collection->featured_image_background_color_id;
            $this->featured_image_description_position=$this->collection->featured_image_description_position;

            //get program Years
            $this->programYears=ProgramYears::WHERE('program_id',$this->entries_program_id)->get();
        }

        $this->types=Types::all();
        $this->colors=Colors::all();
        
    }

    public function updatedEntriesProgramId($value)
    {
        $this->programYears=ProgramYears::WHERE('program_id',$this->entries_program_id)->get();
    }

    public function rules()
    {
        $data = [
            'type_id' => ['required'],
            'calendar_view' => ['nullable'],
            'name' => ['required'],
            'name_arabic' => ['required'],
            'show_name' => ['nullable'],
            'description' => ['nullable'],
            'description_arabic' => ['nullable'],
            'show_description' => ['nullable'],
            'view_all_title' => ['nullable'],
            'view_all_title_arabic' => ['nullable'],
            'view_all_link' => ['nullable'],
            'view_all_link_arabic' => ['nullable'],
            'show_view_all' => ['nullable'],
            'show_projects_grantees' => ['nullable'],
            'background_color_id' => ['nullable'],
            'button_text' => ['nullable'],
            'button_text_arabic' => ['nullable'],
            'button_background_color_id' => ['nullable'],
            'with_border_bottom' => ['nullable'],
            'with_filters' => ['nullable'],
            'filter_fields' => ['nullable'],
            'entries_selection' => ['nullable'],
            'show_all_entries' => ['nullable'],
            'entries_number' => ['required_if:show_all_entries,0'],
            'entries_with_expired' => ['required_if:entries_selection,2'],
            'entries_order' => ['required_if:entries_selection,2'],
            'entries_program_id' => ['nullable'],
            'entries_program_year_id' => ['nullable'],
            'title_position' => ['required'],
            'with_label' => ['required'],
            'entries_layout' => ['required'],
            'entries_per_row' => ['required'],
            'with_featured_image' => ['nullable'],
            'all_featured' => ['nullable'],
            'featured_image_width' => ['required_if:with_featured_image,1'],
            'featured_image_background_color_id' => ['nullable'],	
            'featured_image_description_position' => ['nullable'],
        ];

        return $data;
    }

    public function store()
    {

        $this->validate();

        if($this->with_featured_image==0){
            $this->all_featured=0;
            $this->featured_image_width=0;
        }

        if (blank($this->entries_program_id)) {
            $this->entries_program_year_id='';
        }

        if($this->show_all_entries==1){
            $this->entries_number=0;
        }

        if($this->id==''){
            Collections::create([
                'type_id'=>$this->type_id,
                'calendar_view'=>$this->calendar_view == 1 ? true : false,
                'name'=>$this->name,
                'name_arabic'=>$this->name_arabic,
                'show_name'=> $this->show_name,
                'description'=>$this->description,
                'description_arabic'=>$this->description_arabic,
                'show_description'=> $this->show_description,
                'view_all_title'=>$this->view_all_title,
                'view_all_title_arabic'=>$this->view_all_title_arabic,
                'view_all_link'=>$this->view_all_link,
                'view_all_link_arabic'=>$this->view_all_link_arabic,
                'show_view_all'=>$this->show_view_all,
                'show_projects_grantees'=>$this->show_projects_grantees == 1 ? true : false,
                'background_color_id' => $this->background_color_id ?: null,
                'button_text'=>$this->button_text,
                'button_text_arabic'=>$this->button_text_arabic,
                'button_background_color_id' => $this->button_background_color_id ?: null,
                'with_border_bottom'=> $this->with_border_bottom,
                'with_filters'=>$this->with_filters,
                'filter_fields'=>$this->filter_fields,
                'entries_selection'=>$this->entries_selection,
                'entries_number'=>$this->entries_number,
                'show_all_entries'=>$this->show_all_entries,
                'entries_with_expired'=>$this->entries_with_expired,
                'entries_order'=>$this->entries_order,
                'entries_program_id' => $this->entries_program_id ?: null,
                'entries_program_year_id' => $this->entries_program_year_id ?: null,
                'title_position'=>$this->title_position,
                'with_label'=>$this->with_label,
                'entries_layout'=>$this->entries_layout,
                'entries_per_row'=>$this->entries_per_row,
                'with_featured_image'=>$this->with_featured_image,
                'all_featured'=> $this->all_featured,
                'featured_image_width'=>$this->featured_image_width,
                'featured_image_background_color_id'=>$this->featured_image_background_color_id,	
                'featured_image_description_position'=>$this->featured_image_description_position,
            ]);

            return to_route('collections')->with('success', 'Collection created successfully!');
        }
        else if($this->id!=''){
            $data = [
                'type_id'=>$this->type_id,
                'calendar_view'=>$this->calendar_view == 1 ? true : false,
                'name'=>$this->name,
                'name_arabic'=>$this->name_arabic,
                'show_name'=>$this->show_name,
                'description'=>$this->description,
                'description_arabic'=>$this->description_arabic,
                'show_description'=>$this->show_description,
                'view_all_title'=>$this->view_all_title,
                'view_all_title_arabic'=>$this->view_all_title_arabic,
                'view_all_link'=>$this->view_all_link,
                'view_all_link_arabic'=>$this->view_all_link_arabic,
                'show_view_all'=>$this->show_view_all,
                'show_projects_grantees'=>$this->show_projects_grantees == 1 ? true : false,
                'background_color_id' => $this->background_color_id ?: null,
                'button_text'=>$this->button_text,
                'button_text_arabic'=>$this->button_text_arabic,
                'button_background_color_id' => $this->button_background_color_id ?: null,
                'with_border_bottom'=>$this->with_border_bottom,
                'with_filters'=>$this->with_filters,
                'filter_fields'=>$this->filter_fields,
                'entries_selection'=>$this->entries_selection,
                'entries_number'=>$this->entries_number,
                'show_all_entries'=>$this->show_all_entries,
                'entries_with_expired'=>$this->entries_with_expired,
                'entries_order'=>$this->entries_order,
                'entries_program_id' => $this->entries_program_id ?: null,
                'entries_program_year_id' => $this->entries_program_year_id ?: null,
                'title_position'=>$this->title_position,
                'with_label'=>$this->with_label,
                'entries_layout'=>$this->entries_layout,
                'entries_per_row'=>$this->entries_per_row,
                'with_featured_image'=>$this->with_featured_image,
                'all_featured'=>$this->all_featured,
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
