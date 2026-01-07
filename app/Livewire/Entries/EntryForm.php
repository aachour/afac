<?php

namespace App\Livewire\Entries;

use App\Models\EventCategories;
use App\Models\ProjectCategories;
use App\Models\GranteeCategories;
use App\Models\ExternalCategories;
use App\Models\Types;
use App\Models\Entries;
use App\Models\Colors;
use App\Models\Countries;
use App\Models\ProgramYears;
use App\Models\ProgramYearProjects;
use App\Models\Shapes;
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
    public $grantee_categories;
    public $external_categories;
    
    public $colors;
    public $shapes;
    public $countries;
    public $programs;
    public $programYears;
    public $image_width_options;
    
    //Common entries
    public $image;
    public $imagePreview;
    public $image_featured;
    public $imageFeaturedPreview;
    public $image_full;
    public $imageFullPreview;
    public $image_width;
    public $background_color_id ;
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
    public $header_color_id;
    public $footer_color_id;
    
 
    
    //1- Event
    public $event_category_id;
    public $event_title;
    public $event_title_arabic;
    public $event_text;
    public $event_text_arabic;
    public $event_date;
    public $event_start_time;
    public $event_end_time;
    

    //2- Program
    public $program_title;
    public $program_title_arabic;
    public $program_text;
    public $program_text_arabic;
    public $program_start_date;
    public $program_end_date;
    

    //3- Project
    public $project_categories_id;
    public $project_title;
    public $project_title_arabic;
    public $project_text;
    public $project_text_arabic;
    public $project_countries_id;
    public $project_program_year_id;
    public $program_id;
    public $program_year_id;
    
    //4- Grantee
    public $grantee_categories_id;
    public $grantee_name;
    public $grantee_name_arabic;
    public $grantee_text;
    public $grantee_text_arabic;
    public $grantee_country_id;

    //5- Jury
    public $jury_name;
    public $jury_name_arabic;
    public $jury_text;
    public $jury_text_arabic;
    public $jury_country_id;

    //6- Resource
    public $resource_title;
    public $resource_title_arabic;
    public $resource_text;
    public $resource_text_arabic;
    public $resource_date;
    public $resource_tags;
    public $resource_tags_arabic;

    //7- News
    public $news_title;
    public $news_title_arabic;
    public $news_text;
    public $news_text_arabic;
    public $news_date;
    public $news_tags;
    public $news_tags_arabic;

    //8- Externals
    public $external_category_id;
    public $external_title;
    public $external_title_arabic;
    public $external_link;
    public $external_link_arabic;
    public $external_image;

    //9- Team
    public $team_name;
    public $team_name_arabic;
    public $team_text;
    public $team_text_arabic;

    //10- Board
    public $board_name;
    public $board_name_arabic;
    public $board_text;
    public $board_text_arabic;
    

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
            $this->imageFeaturedPreview = asset('storage/' . $this->entry->image_featured);
            $this->imageFullPreview = asset('storage/' . $this->entry->image_full);

            $this->header_color_id=$this->entry->header_color_id;
            $this->footer_color_id=$this->entry->footer_color_id;
            $this->image_width=$this->entry->image_width;
            $this->background_color_id=$this->entry->background_color_id;
            $this->button_value=$this->entry->button_value;
            $this->button_value_arabic=$this->entry->button_value_arabic;
            $this->button_shape_id=$this->entry->button_shape_id;
            $this->button_hover_shape_id=$this->entry->button_hover_shape_id;
            $this->button_color_id=$this->entry->button_color_id;
            $this->button_hover_color_id=$this->entry->button_hover_color_id;
            $this->button_bg_color_id=$this->entry->button_bg_color_id;
            $this->button_hover_bg_color_id=$this->entry->button_hover_bg_color_id;
            $this->button_link=$this->entry->button_link;
            $this->button_link_arabic=$this->entry->button_link_arabic;
            
            //Event
            $this->event_category_id=$this->entry->event_category_id;
            $this->event_title=$this->entry->event_title;
            $this->event_title_arabic=$this->entry->event_title_arabic;
            $this->event_text=$this->entry->event_text;
            $this->event_text_arabic=$this->entry->event_text_arabic;
            $this->event_date=$this->entry->event_date;
            $this->event_start_time=$this->entry->event_start_time;
            $this->event_end_time=$this->entry->event_end_time;

            //Program
            $this->program_title=$this->entry->program_title;
            $this->program_title_arabic=$this->entry->program_title_arabic;
            $this->program_text=$this->entry->program_text;
            $this->program_text_arabic=$this->entry->program_text_arabic;
            $this->program_start_date=$this->entry->program_start_date;
            $this->program_end_date=$this->entry->program_end_date;
            

            //Project
            $this->project_categories_id=json_decode($this->entry->project_categories_id, true) ?? [];
            $this->project_title=$this->entry->project_title;
            $this->project_title_arabic=$this->entry->project_title_arabic;
            $this->project_text=$this->entry->project_text;
            $this->project_text_arabic=$this->entry->project_text_arabic; 
            $this->project_countries_id = json_decode($this->entry->project_countries_id, true) ?? [];
            $this->project_program_year_id=$this->entry->project_program_year_id;
            $programYearProject=ProgramYearProjects::find($this->project_program_year_id);
            if($programYearProject!=null){
                $this->program_id=$programYearProject->programYear->program->id;
                $this->program_year_id=$programYearProject->program_year_id;
            }

            //Grantee
            $this->grantee_categories_id=json_decode($this->entry->grantee_categories_id, true) ?? [];
            $this->grantee_name=$this->entry->grantee_name;
            $this->grantee_name_arabic=$this->entry->grantee_name_arabic;
            $this->grantee_text=$this->entry->grantee_text;
            $this->grantee_text_arabic=$this->entry->grantee_text_arabic;
            $this->grantee_country_id=$this->entry->grantee_country_id;

            //Jury
            $this->jury_name=$this->entry->jury_name;
            $this->jury_name_arabic=$this->entry->jury_name_arabic;
            $this->jury_text=$this->entry->jury_text;
            $this->jury_text_arabic=$this->entry->jury_text_arabic;
            $this->jury_country_id=$this->entry->jury_country_id;

            //Resource
            $this->resource_title=$this->entry->resource_title;
            $this->resource_title_arabic=$this->entry->resource_title_arabic;
            $this->resource_text=$this->entry->resource_text;
            $this->resource_text_arabic=$this->entry->resource_text_arabic;
            $this->resource_date=$this->entry->resource_date;
            $this->resource_tags=$this->entry->resource_tags;
            $this->resource_tags_arabic=$this->entry->resource_tags_arabic;

            //News
            $this->news_title=$this->entry->news_title;
            $this->news_title_arabic=$this->entry->news_title_arabic;
            $this->news_text=$this->entry->news_text;
            $this->news_text_arabic=$this->entry->news_text_arabic;
            $this->news_date=$this->entry->news_date;
            $this->news_tags=$this->entry->news_tags;
            $this->news_tags_arabic=$this->entry->news_tags_arabic;

            //Externals
            $this->external_category_id=$this->entry->external_category_id;
            $this->external_title=$this->entry->external_title;
            $this->external_title_arabic=$this->entry->external_title_arabic;
            $this->external_link=$this->entry->external_link;
            $this->external_link_arabic=$this->entry->external_link_arabic;

            //Team
            $this->team_name=$this->entry->team_name;
            $this->team_name_arabic=$this->entry->team_name_arabic;
            $this->team_text=$this->entry->team_text;
            $this->team_text_arabic=$this->entry->team_text_arabic;

            //Board
            $this->board_name=$this->entry->board_name;
            $this->board_name_arabic=$this->entry->board_name_arabic;
            $this->board_text=$this->entry->board_text;
            $this->board_text_arabic=$this->entry->board_text_arabic;
            
        }

        $this->event_categories=EventCategories::all();

        $this->project_categories=ProjectCategories::all();

        $this->grantee_categories=GranteeCategories::all();
        
        $this->external_categories=ExternalCategories::all();
        
        $this->colors=Colors::all();

        $this->shapes=Shapes::all();
        
        $this->countries=Countries::WHERE('active','1')->get();

        $this->programs=Entries::WHERE('type_id','2')->ORDERBY('id','desc')->get();

        $this->programYears=[];

        if($id!=''){
            $this->programYears=ProgramYears::WHERE('program_id',$this->program_id)->get();
        }
       
        $this->image_width_options=['1'=>'Full','2'=>'One-half'];

    }

    public function UpdateProgramYears(){
        $this->programYears=ProgramYears::WHERE('program_id',$this->program_id)->get();
    }


    public function rules()
    {
        $data = [
            'type_id' => ['required'],
            'header_color_id' => ['nullable'],
            'footer_color_id' => ['nullable'],
            'image' => ['nullable'],
            'image_featured' => ['nullable'],
            'image_full' => ['nullable'],
            'image_width' => ['nullable'],
            'background_color_id' => ['nullable'],
            'button_value' => ['nullable'],
            'button_value_arabic' => ['nullable'],
            'button_shape_id' => ['nullable'],
            'button_hover_shape_id' => ['nullable'],
            'button_color_id' => ['nullable'],
            'button_hover_color_id' => ['nullable'],
            'button_bg_color_id' => ['nullable'],
            'button_hover_bg_color_id' => ['nullable'],
            'button_link' => ['nullable'],
            'button_link_arabic' => ['nullable'],
            
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

            //Project
            'project_categories_id' => ['required_if:type_id,3|array|min:1'],
            'project_title' => ['required_if:type_id,3'],
            'project_title_arabic' => ['required_if:type_id,3'],
            'project_countries_id' => ['required_if:type_id,3|array|min:1'],
            'program_id' => ['required_if:type_id,3'],
            'program_year_id' => ['required_if:type_id,3'],
            

            //Grantee
            'grantee_categories_id' => ['required_if:type_id,4|array|min:1'],
            'grantee_name' => ['required_if:type_id,4'],
            'grantee_name_arabic' => ['required_if:type_id,4'],
            'grantee_country_id' => ['required_if:type_id,4'],

            //Jury
            'jury_name' => ['required_if:type_id,5'],
            'jury_name_arabic' => ['required_if:type_id,5'],
            'jury_country_id' => ['required_if:type_id,5'],

            //Resource
            'resource_title' => ['required_if:type_id,6'],
            'resource_title_arabic' => ['required_if:type_id,6'],
            'resource_date' => ['required_if:type_id,6'],
            
            
            //News
            'news_title' => ['required_if:type_id,7'],
            'news_title_arabic' => ['required_if:type_id,7'],
            'news_date' => ['required_if:type_id,7'],


            //Externals
            'external_category_id' => ['required_if:type_id,8'],
            'external_title' => ['required_if:type_id,8'],
            'external_title_arabic' => ['required_if:type_id,8'],
            'external_link' => ['required_if:type_id,8'],
            'external_link_arabic' => ['required_if:type_id,8'],


            //Team
            'team_name' => ['required_if:type_id,9'],
            'team_name_arabic' => ['required_if:type_id,9'],
            'team_text' => ['required_if:type_id,9'],
            'team_text_arabic' => ['required_if:type_id,9'],

            
            //Board
            'board_name' => ['required_if:type_id,10'],
            'board_name' => ['required_if:type_id,10'],
            'board_text' => ['required_if:type_id,10'],
            'board_text' => ['required_if:type_id,10'],
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

            if($this->image_featured!=''){
                $path_featured = $this->image_featured->store('entries', 'public');
            }

            if($this->image_full!=''){
                $path_full = $this->image_full->store('entries', 'public');
            }

            $entry=Entries::create([
                'type_id' => $this->type_id,
                'header_color_id' => $this->header_color_id,
                'footer_color_id' => $this->footer_color_id,
                'image' => @$path,
                'image_featured' => @$path_featured,
                'image_full' => @$path_full,
                'image_width' => $this->image_width,
                'background_color_id' => $this->background_color_id !== '' ? $this->background_color_id : null,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'button_shape_id' => $this->button_shape_id,
                'button_hover_shape_id' => $this->button_hover_shape_id,
                'button_color_id' => $this->button_color_id,
                'button_hover_color_id' => $this->button_hover_color_id,
                'button_bg_color_id' => $this->button_bg_color_id,
                'button_hover_bg_color_id' => $this->button_hover_bg_color_id,
                'button_link' => $this->button_link,
                'button_link_arabic' => $this->button_link_arabic,
                'event_category_id'=> $this->event_category_id !== '' ? $this->event_category_id : null,
                'event_title'=>$this->event_title ?? '',
                'event_title_arabic'=>$this->event_title_arabic ?? '',
                'event_text'=>$this->event_text ?? '',
                'event_text_arabic'=>$this->event_text_arabic ?? '',
                'event_date'=>$this->event_date ?? null,
                'event_start_time'=>$this->event_start_time ?? null,
                'event_end_time'=>$this->event_end_time ?? null,
                'program_title'=>$this->program_title ?? '',
                'program_title_arabic'=>$this->program_title_arabic ?? '',
                'program_text'=>$this->program_text ?? '',
                'program_text_arabic'=>$this->program_text_arabic ?? '',
                'program_start_date'=>$this->program_start_date ?? null,
                'program_end_date'=>$this->program_end_date ?? null,
                'project_categories_id'=> $this->project_categories_id !== '' ? json_encode($this->project_categories_id) : null,
                'project_title'=>$this->project_title ?? '',
                'project_title_arabic'=>$this->project_title_arabic ?? '',
                'project_text'=>$this->project_text ?? '',
                'project_text_arabic'=>$this->project_text_arabic ?? '',
                'project_countries_id'=> $this->project_countries_id !== '' ? json_encode($this->project_countries_id) : null,
                'grantee_categories_id'=> $this->grantee_categories_id !== '' ? json_encode($this->grantee_categories_id) : null,
                'grantee_name'=>$this->grantee_name ?? '',
                'grantee_name_arabic'=>$this->grantee_name_arabic ?? '',
                'grantee_text'=>$this->grantee_text ?? '',
                'grantee_text_arabic'=>$this->grantee_text_arabic ?? '',
                'grantee_country_id'=> $this->grantee_country_id !== '' ? $this->grantee_country_id : null, 
                'jury_name'=>$this->jury_name ?? '',
                'jury_name_arabic'=>$this->jury_name_arabic ?? '',
                'jury_text'=>$this->jury_text ?? '',
                'jury_text_arabic'=>$this->jury_text_arabic ?? '',
                'jury_country_id'=>$this->jury_country_id !== '' ? $this->jury_country_id : null, 
                'resource_title'=>$this->resource_title ?? '',
                'resource_title_arabic'=>$this->resource_title_arabic ?? '',
                'resource_text'=>$this->resource_text ?? '',
                'resource_text_arabic'=>$this->resource_text_arabic ?? '',
                'resource_date'=> $this->resource_date ?? null,
                'resource_tags'=>$this->resource_tags ?? '',
                'resource_tags_arabic'=>$this->resource_tags_arabic ?? '',
                'news_title'=>$this->news_title ?? '',
                'news_title_arabic'=>$this->news_title_arabic ?? '',
                'news_text'=>$this->news_text ?? '',
                'news_text_arabic'=>$this->news_text_arabic ?? '',
                'news_date'=>$this->news_date ?? null,
                'news_tags'=>$this->news_tags ?? '',
                'news_tags_arabic'=>$this->news_tags_arabic ?? '',
                'external_category_id'=> $this->external_category_id !== '' ? $this->external_category_id : null,
                'external_title'=>$this->external_title ?? '',
                'external_title_arabic'=>$this->external_title_arabic ?? '',
                'external_link'=>$this->external_link ?? '',
                'external_link_arabic'=>$this->external_link_arabic ?? '',
                'team_name'=>$this->team_name ?? '',
                'team_name_arabic'=>$this->team_name_arabic ?? '',
                'team_text'=>$this->team_text ?? '',
                'team_text_arabic'=>$this->team_text_arabic ?? '',
                'board_name'=>$this->board_name ?? '',
                'board_name_arabic'=>$this->board_name_arabic ?? '',
                'board_text'=>$this->board_text ?? '',
                'board_text_arabic'=>$this->board_text_arabic ?? '',
            ]);

            if($this->type_id==3){
                $project_id=$entry->id;
                $highestOrder = ProgramYearProjects::WHERE('program_year_id',$this->program_year_id)->max('list_order');
                $project_program_year=ProgramYearProjects::create(['program_year_id' => $this->program_year_id , 'project_id' => $project_id , 'list_order' =>$highestOrder+1]);

                $entry->update([
                    'project_program_year_id' => $project_program_year->id !== '' ? $project_program_year->id : null,
                ]);
                
            }

            return to_route('entries',['typeId'=>$this->type_id])->with('success', 'Entry created successfully!');
        }
        else if($this->id!=''){

            if($this->image!=''){
                $path = $this->image->store('entries', 'public');
            }

            if($this->image_featured!=''){
                $path_feautred = $this->image_featured->store('entries', 'public');
            }

            if($this->image_full!=''){
                $path_full = $this->image_full->store('entries', 'public');
            }

            $data = [
                'header_color_id' => $this->header_color_id,
                'footer_color_id' => $this->footer_color_id,
                'image' => @$path ?? $this->entry->image,
                'image_featured' => @$path_feautred ?? $this->entry->image_featured,
                'image_full' => @$path_full ?? $this->entry->image_full,
                'image_width' => $this->image_width,
                'background_color_id' => $this->background_color_id !== '' ? $this->background_color_id : null,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'button_shape_id' => $this->button_shape_id,
                'button_hover_shape_id' => $this->button_hover_shape_id,
                'button_color_id' => $this->button_color_id,
                'button_hover_color_id' => $this->button_hover_color_id,
                'button_bg_color_id' => $this->button_bg_color_id,
                'button_hover_bg_color_id' => $this->button_hover_bg_color_id,
                'button_link' => $this->button_link,
                'button_link_arabic' => $this->button_link_arabic,
                'event_category_id'=> $this->event_category_id !== '' ? $this->event_category_id : null,
                'event_title'=>$this->event_title ?? '',
                'event_title_arabic'=>$this->event_title_arabic ?? '',
                'event_text'=>$this->event_text ?? '',
                'event_text_arabic'=>$this->event_text_arabic ?? '',
                'event_date'=>$this->event_date ?? null,
                'event_start_time'=>$this->event_start_time ?? null,
                'event_end_time'=>$this->event_end_time ?? null,
                'program_title'=>$this->program_title ?? '',
                'program_title_arabic'=>$this->program_title_arabic ?? '',
                'program_text'=>$this->program_text ?? '',
                'program_text_arabic'=>$this->program_text_arabic ?? '',
                'program_start_date'=>$this->program_start_date ?? null,
                'program_end_date'=>$this->program_end_date ?? null,
                'project_categories_id'=> $this->project_categories_id !== '' ? json_encode($this->project_categories_id) : null, 
                'project_title'=>$this->project_title ?? '',
                'project_title_arabic'=>$this->project_title_arabic ?? '',
                'project_text'=>$this->project_text ?? '',
                'project_text_arabic'=>$this->project_text_arabic ?? '',
                'project_countries_id'=> $this->project_countries_id !== '' ? json_encode($this->project_countries_id) : null,
                'grantee_categories_id'=> $this->grantee_categories_id !== '' ? json_encode($this->grantee_categories_id) : null,
                'grantee_name'=>$this->grantee_name ?? '',
                'grantee_name_arabic'=>$this->grantee_name_arabic ?? '',
                'grantee_text'=>$this->grantee_text ?? '',
                'grantee_text_arabic'=>$this->grantee_text_arabic ?? '',
                'grantee_country_id'=> $this->grantee_country_id !== '' ? $this->grantee_country_id : null, 
                'jury_name'=>$this->jury_name ?? '',
                'jury_name_arabic'=>$this->jury_name_arabic ?? '',
                'jury_text'=>$this->jury_text ?? '',
                'jury_text_arabic'=>$this->jury_text_arabic ?? '',
                'jury_country_id'=>$this->jury_country_id !== '' ? $this->jury_country_id : null, 
                'resource_title'=>$this->resource_title ?? '',
                'resource_title_arabic'=>$this->resource_title_arabic ?? '',
                'resource_text'=>$this->resource_text ?? '',
                'resource_text_arabic'=>$this->resource_text_arabic ?? '',
                'resource_date'=> $this->resource_date ?? null,
                'resource_tags'=>$this->resource_tags ?? '',
                'resource_tags_arabic'=>$this->resource_tags_arabic ?? '',
                'news_title'=>$this->news_title ?? '',
                'news_title_arabic'=>$this->news_title_arabic ?? '',
                'news_text'=>$this->news_text ?? '',
                'news_text_arabic'=>$this->news_text_arabic ?? '',
                'news_date'=>$this->news_date ?? null,
                'news_tags'=>$this->news_tags ?? '',
                'news_tags_arabic'=>$this->news_tags_arabic ?? '',
                'external_category_id'=> $this->external_category_id !== '' ? $this->external_category_id : null,
                'external_title'=>$this->external_title ?? '',
                'external_title_arabic'=>$this->external_title_arabic ?? '',
                'external_link'=>$this->external_link ?? '',
                'external_link_arabic'=>$this->external_link_arabic ?? '',
                'team_name'=>$this->team_name ?? '',
                'team_name_arabic'=>$this->team_name_arabic ?? '',
                'team_text'=>$this->team_text ?? '',
                'team_text_arabic'=>$this->team_text_arabic ?? '',
                'board_name'=>$this->board_name ?? '',
                'board_name_arabic'=>$this->board_name_arabic ?? '',
                'board_text'=>$this->board_text ?? '',
                'board_text_arabic'=>$this->board_text_arabic ?? '',
            ];

            $this->entry->update($data);

            if($this->type_id==3){
                $project_id=$this->entry->id;

                ProgramYearProjects::where('project_id', $project_id)
                ->update([
                    'program_year_id' => $this->program_year_id,
                ]);
            }

            return to_route('entries',['typeId'=>$this->type_id])->with('success', 'Entry updated successfully!');
            
        }
        
    }

    public function render()
    {
        return view('livewire.entries.entry-form');
    }

}
