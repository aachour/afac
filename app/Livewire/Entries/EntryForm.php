<?php

namespace App\Livewire\Entries;

use App\Models\EventCategories;
use App\Models\ProjectCategories;
use App\Models\Types;
use App\Models\Entries;
use App\Models\Colors;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;

class EntryForm extends Component
{

    use WithFileUploads;
    use AuthorizesRequests;    

    public $editing = false;
    public $type_id;
    public $type_name;
    public $id;
    public $entry;

    public $event_categories;
    public $project_categories;
    public $colors;
    public $image_width_options;

    //Common entries
    public $image;
    public $imagePreview;
    public $image_width;
    public $background_color_id ;
    public $button_link;
    public $button_value;
    public $button_value_arabic;

    //1- Event
    public $event_category_id;
    public $event_title;
    public $event_title_arabic;
    public $event_date;
    public $event_start_time;
    public $event_end_time;

    //2- Program
    public $program_title;
    public $program_title_arabic;
    public $program_status;

    //3- Project
    public $project_category_id;
    public $project_title;
    public $project_title_arabic;
    public $project_country_id;

    //4- Grantee
    public $grantee_name;
    public $grantee_name_arabic;
    public $grantee_country_id;
    public $grantee_image;

    //5- Jury
    public $jury_name;
    public $jury_name_arabic;
    public $jury_bio;
    public $jury_bio_arabic;
    public $jury_country_id;
    public $jury_image;

    //6- Resource
    public $resource_title;
    public $resource_title_arabic;
    public $resource_date;
    public $resource_tags;
    public $resource_tags_arabic;

    //7- News
    public $news_title;
    public $news_title_arabic;
    public $news_date;
    public $news_tags;
    public $news_tags_arabic;


    public function mount($typeId,$id=''){

        if(!isset($typeId) || $typeId==''){
            return to_route('dashboard');
        }

        $this->type_id=$typeId;
        $this->type_name = Types::where('id', $this->type_id)->value('name');

        if($id==''){
            $this->authorize('entry-create');
        }
        else{

            $this->authorize('entry-edit');
            
            $this->editing = true;

            $this->id=$id;

            $this->entry=Entries::find($this->id);

            $this->imagePreview = asset('storage/' . $this->entry->image);
            $this->image_width=$this->entry->image_width;
            $this->background_color_id=$this->entry->background_color_id;
            $this->button_link=$this->entry->button_link;
            $this->button_value=$this->entry->button_value;
            $this->button_value_arabic=$this->entry->button_value_arabic;
            
            //Event
            $this->event_category_id=$this->entry->event_category_id;
            $this->event_title=$this->entry->event_title;
            $this->event_title_arabic=$this->entry->event_title_arabic;
            $this->event_date=$this->entry->event_date;
            $this->event_start_time=$this->entry->event_start_time;
            $this->event_end_time=$this->entry->event_end_time;

            //Program
            $this->program_title=$this->entry->program_title;
            $this->program_title_arabic=$this->entry->program_title_arabic;
            $this->program_status=$this->entry->program_status;

            //Project
            $this->project_category_id=$this->entry->program_title;
            $this->project_title=$this->entry->program_title;
            $this->project_title_arabic=$this->entry->program_title;
            $this->project_country_id=$this->entry->program_title;

            //Grantee
            $this->grantee_name=$this->entry->grantee_name;
            $this->grantee_name_arabic=$this->entry->grantee_name_arabic;
            $this->grantee_country_id=$this->entry->grantee_country_id;
            $this->grantee_image=$this->entry->grantee_image;

            //Jury
            $this->jury_name=$this->entry->jury_name;
            $this->jury_name_arabic=$this->entry->jury_name_arabic;
            $this->jury_bio=$this->entry->jury_bio;
            $this->jury_bio_arabic=$this->entry->jury_bio_arabic;
            $this->jury_country_id=$this->entry->jury_country_id;
            $this->jury_image=$this->entry->jury_image;

            //Resource
            $this->resource_title=$this->entry->resource_title;
            $this->resource_title_arabic=$this->entry->resource_title_arabic;
            $this->resource_date=$this->entry->resource_date;
            $this->resource_tags=$this->entry->resource_tags;
            $this->resource_tags_arabic=$this->entry->resource_tags_arabic;

            //News
            $this->news_title=$this->entry->news_title;
            $this->news_title_arabic=$this->entry->news_title_arabic;
            $this->news_date=$this->entry->news_date;
            $this->news_tags=$this->entry->news_tags;
            $this->news_tags_arabic=$this->entry->news_tags_arabic;
        }

        $this->event_categories=EventCategories::all();

        $this->project_categories=ProjectCategories::all();
        
        $this->colors=Colors::all();

        $this->image_width_options=['1'=>'Full','2'=>'three-quarters','3'=>'one-half','4'=>'one-quarter'];
        
    }


    public function rules()
    {
        $data = [
            'type_id' => ['required'],
            'image' => ['nullable'],
            'image_width' => ['nullable'],
            'background_color_id' => ['nullable'],
            'button_link' => ['nullable'],
            'button_value' => ['nullable'],
            'button_value_arabic' => ['nullable'],

            //Event
            'event_category_id' => ['required_if:type_id,1'],
            'event_title' => ['required_if:type_id,1'],
            'event_title_arabic' => ['required_if:type_id,1'],
            'event_date' => ['required_if:type_id,1'],
            'event_start_time' => ['required_if:type_id,1'],
            'event_end_time' => ['required_if:type_id,1'],

            //Program
            'program_title' => ['required_if:type_id,2'],
            'program_title_arabic' => ['required_if:type_id,2'],
            'program_status' => ['required_if:type_id,2'],

            //Project
            'project_category_id' => ['required_if:type_id,3'],
            'project_title' => ['required_if:type_id,3'],
            'project_title_arabic' => ['required_if:type_id,3'],
            'project_country_id' => ['required_if:type_id,3'],

            //Grantee
            'grantee_name' => ['required_if:type_id,4'],
            'grantee_name_arabic' => ['required_if:type_id,4'],
            'grantee_country_id' => ['required_if:type_id,4'],
            'grantee_image' => ['required_if:type_id,4'],

            //Jury
            'jury_name' => ['required_if:type_id,5'],
            'jury_name_arabic' => ['required_if:type_id,5'],
            'jury_bio' => ['required_if:type_id,5'],
            'jury_bio_arabic' => ['required_if:type_id,5'],
            'jury_country_id' => ['required_if:type_id,5'],
            'jury_image' => ['required_if:type_id,5'],

            //Resource
            'resource_title' => ['required_if:type_id,6'],
            'resource_title_arabic' => ['required_if:type_id,6'],
            'resource_date' => ['required_if:type_id,6'],
            'resource_tags' => ['required_if:type_id,6'],
            'resource_tags_arabic' => ['required_if:type_id,6'],
            
            //News
            'news_title' => ['required_if:type_id,7'],
            'news_title_arabic' => ['required_if:type_id,7'],
            'news_date' => ['required_if:type_id,7'],
            'news_tags' => ['required_if:type_id,7'],
            'news_tags_arabic' => ['required_if:type_id,7'],
            
        ];

        return $data;
    }

    public function store()
    {
        $this->validate();

        if($this->id==''){

            // Save to storage/app/public/entries
            if($this->image!=''){
                $path = $this->image->store('entries', 'public');
            }

            Entries::create([
                'type_id' => $this->type_id,
                'image' => @$path,
                'image_width' => $this->image_width,
                'background_color_id' => $this->background_color_id !== '' ? $this->background_color_id : null,
                'button_link' => $this->button_link,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'event_category_id'=> $this->event_category_id !== '' ? $this->event_category_id : null,
                'event_title'=>$this->event_title ?? '',
                'event_title_arabic'=>$this->event_title_arabic ?? '',
                'event_date'=>$this->event_date ?? '',
                'event_start_time'=>$this->event_start_time ?? '',
                'event_end_time'=>$this->event_end_time ?? '',
                'program_title'=>$this->program_title ?? '',
                'program_title_arabic'=>$this->program_title_arabic ?? '',
                'program_status'=>$this->program_status ?? '0',
                'project_category_id'=> $this->project_category_id !== '' ? $this->project_category_id : null, 
                'project_title'=>$this->project_title ?? '',
                'project_title_arabic'=>$this->project_title_arabic ?? '',
                'project_country_id'=> $this->project_country_id !== '' ? $this->project_country_id : null,
                'grantee_name'=>$this->grantee_name ?? '',
                'grantee_name_arabic'=>$this->grantee_name_arabic ?? '',
                'grantee_country_id'=> $this->grantee_country_id !== '' ? $this->grantee_country_id : null, 
                'grantee_image'=>$this->grantee_image ?? '',
                'jury_name'=>$this->jury_name ?? '',
                'jury_name_arabic'=>$this->jury_name_arabic ?? '',
                'jury_bio'=>$this->jury_bio ?? '',
                'jury_bio_arabic'=>$this->jury_bio_arabic ?? '',
                'jury_country_id'=>$this->jury_country_id !== '' ? $this->jury_country_id : null, 
                'jury_image'=>$this->jury_image ?? '',
                'resource_title'=>$this->resource_title ?? '',
                'resource_title_arabic'=>$this->resource_title_arabic ?? '',
                'resource_date'=> $this->resource_date ?? null,
                'resource_tags'=>$this->resource_tags ?? '',
                'resource_tags_arabic'=>$this->resource_tags_arabic ?? '',
                'news_title'=>$this->news_title ?? '',
                'news_title_arabic'=>$this->news_title_arabic ?? '',
                'news_date'=>$this->news_date ?? null,
                'news_tags'=>$this->news_tags ?? '',
                'news_tags_arabic'=>$this->news_tags_arabic ?? '',
            ]);

            return to_route('entries',['typeId'=>$this->type_id])->with('success', 'Entry created successfully!');
        }
        else if($this->id!=''){

            if($this->image!=''){
                $path = $this->image->store('entries', 'public');
            }

            $data = [
                'image' => @$path ?? $this->entry->image,
                'image_width' => $this->image_width,
                'background_color_id' => $this->background_color_id !== '' ? $this->background_color_id : null,
                'button_link' => $this->button_link,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'event_category_id'=> $this->event_category_id !== '' ? $this->event_category_id : null,
                'event_title'=>$this->event_title ?? '',
                'event_title_arabic'=>$this->event_title_arabic ?? '',
                'event_date'=>$this->event_date ?? '',
                'event_start_time'=>$this->event_start_time ?? '',
                'event_end_time'=>$this->event_end_time ?? '',
                'program_title'=>$this->program_title ?? '',
                'program_title_arabic'=>$this->program_title_arabic ?? '',
                'program_status'=>$this->program_status ?? '0',
                'project_category_id'=> $this->project_category_id !== '' ? $this->project_category_id : null, 
                'project_title'=>$this->project_title ?? '',
                'project_title_arabic'=>$this->project_title_arabic ?? '',
                'project_country_id'=> $this->project_country_id !== '' ? $this->project_country_id : null,
                'grantee_name'=>$this->grantee_name ?? '',
                'grantee_name_arabic'=>$this->grantee_name_arabic ?? '',
                'grantee_country_id'=> $this->grantee_country_id !== '' ? $this->grantee_country_id : null, 
                'grantee_image'=>$this->grantee_image ?? '',
                'jury_name'=>$this->jury_name ?? '',
                'jury_name_arabic'=>$this->jury_name_arabic ?? '',
                'jury_bio'=>$this->jury_bio ?? '',
                'jury_bio_arabic'=>$this->jury_bio_arabic ?? '',
                'jury_country_id'=>$this->jury_country_id !== '' ? $this->jury_country_id : null, 
                'jury_image'=>$this->jury_image ?? '',
                'resource_title'=>$this->resource_title ?? '',
                'resource_title_arabic'=>$this->resource_title_arabic ?? '',
                'resource_date'=> $this->resource_date ?? null,
                'resource_tags'=>$this->resource_tags ?? '',
                'resource_tags_arabic'=>$this->resource_tags_arabic ?? '',
                'news_title'=>$this->news_title ?? '',
                'news_title_arabic'=>$this->news_title_arabic ?? '',
                'news_date'=>$this->news_date ?? null,
                'news_tags'=>$this->news_tags ?? '',
                'news_tags_arabic'=>$this->news_tags_arabic ?? '',
            ];

            $this->entry->update($data);

            return to_route('entries',['typeId'=>$this->type_id])->with('success', 'Entry updated successfully!');
            
        }
        
    }

    public function render()
    {
        return view('livewire.entries.entry-form');
    }

}
