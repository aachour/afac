<?php

namespace App\Livewire\Sections;

use App\Models\PageSections;
use App\Models\Sections;
use App\Models\ColumnTypes;
use App\Models\AlignmentTypes;
use App\Models\SectionColumns;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionForm extends Component
{

    use AuthorizesRequests; 

    public $editing = false;

    public $section;
    public $name;
    public $with_border_bottom;

    public $page_id;
    public $entry_id;
    public $section_id;

    public $columns;
    public $columnTypes;
    public $alignmentTypes;
    public $columns_num;
    public $columns_max=2;

    public $image_width_options=[];


    public function mount($pageId='',$entryId='',$id=''){
        
        $this->page_id=$pageId;

        $this->entry_id=$entryId;

        // dd($this->page_id,$this->entry_id);
        
        if($id==''){

            $this->authorize('section-create');

            $this->with_border_bottom=false;

            $this->columns_num=1;
            $this->columns[] = ['id'=>'','type_id' => '','alignment_id'=>'','width'=>''];
        }
        else{

            $this->authorize('section-edit');

            $this->section_id=$id;

            $this->section=Sections::find($this->section_id);

            $this->name=$this->section->name;

            $this->with_border_bottom=$this->section->with_border_bottom == 1 ? true : false;

            $sectionColumns=SectionColumns::WHERE('section_id',$this->section_id)->get();

            $this->columns_num=count($sectionColumns);

            foreach($sectionColumns as $sectionColumn){
                $obj=[
                    'id'=>$sectionColumn->id,
                    'type_id'=>$sectionColumn->type_id,
                    'alignment_id'=>$sectionColumn->alignment_id,
                    'width'=>$sectionColumn->width,
                ];
                $this->columns[]=$obj;
            }

        }
        
        $this->columnTypes=ColumnTypes::ORDERBY('id','ASC')->get();
        $this->alignmentTypes=AlignmentTypes::ORDERBY('id','ASC')->get();
        $this->image_width_options=['1'=>'Full','2'=>'three-quarters'];
        
    }

    public function AddColumn(){
        
        $this->columns[] = ['id'=>'','type_id' => '','alignment_id'=>'','width'=>''];

        $this->columns_num++;

    }


    public function DeleteColumn($index){
        unset($this->columns[$index]);
        $this->columns = array_values($this->columns);
        $this->columns_num-=1;
    }


    public function rules()
    {
        $data = [
            'name' => 'required',
            'with_border_bottom' => 'nullable',
            'columns' => 'required|array|min:1',
            'columns.*.type_id' => 'required|integer|exists:column_types,id',
            'columns.*.alignment_id' => 'required|integer|exists:alignment_types,id',
            'columns.*.width' => 'required',
        ];

        return $data;
    }

    public function store()
    {

        $this->validate();

        if($this->section_id==''){
            
            if($this->page_id!=null){

                //create new section
                $section=Sections::create([
                    'page_id' => $this->page_id,
                    'name' => $this->name,
                    'with_border_bottom' => $this->with_border_bottom,
                ]);

                $section_id=$section->id;

                //add section to page sections
                $highestOrder = PageSections::WHERE('page_id',$this->page_id)->max('list_order');

                PageSections::create([
                    'page_id'=>$this->page_id,
                    'section_id'=>$section_id,
                    'list_order'=> $highestOrder+1
                ]);

                //add columns to section
                foreach($this->columns as $column){
                    SectionColumns::create([
                        'section_id' => $section_id,
                        'type_id' => $column['type_id'],
                        'alignment_id' => $column['alignment_id'],
                        'width' => $column['width'],
                    ]);
                }

                return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Section created successfully!');
            }
            else if($this->entry_id!=null){
                //create new section
                $section=Sections::create([
                    'entry_id' => $this->entry_id,
                    'name' => $this->name,
                    'with_border_bottom' => $this->with_border_bottom,
                ]);

                $section_id=$section->id;

                //add section to page sections
                $highestOrder = PageSections::WHERE('entry_id',$this->entry_id)->max('list_order');

                PageSections::create([
                    'entry_id'=>$this->entry_id,
                    'section_id'=>$section_id,
                    'list_order'=> $highestOrder+1
                ]);

                //add columns to section
                foreach($this->columns as $column){
                    SectionColumns::create([
                        'section_id' => $section_id,
                        'type_id' => $column['type_id'],
                        'alignment_id' => $column['alignment_id'],
                        'width' => $column['width'],
                    ]);
                }

                return to_route('entry.sections', ['entryId' => $this->entry_id])->with('success', 'Section created successfully!');
            }

        }
        else if($this->section_id!=''){

            
            Sections::WHERE('id', $this->section_id)->update(['name'=>$this->name , 'with_border_bottom' => $this->with_border_bottom]);

            // Collect IDs of the submitted columns
            $sectionColumnsId = [];
            foreach($this->columns as $column){
                $sectionColumnsId[]=$column["id"];
            }

            // Delete columns that were removed
            SectionColumns::where('section_id', $this->section_id)
                ->whereNotIn('id', $sectionColumnsId)
                ->delete();

            // Loop through submitted columns
            foreach($this->columns as $column){
                if (!empty($column['id'])) {
                    // Update existing
                    SectionColumns::where('id', $column['id'])->update([
                        'type_id' => $column['type_id'],
                        'alignment_id' => $column['alignment_id'],
                        'width' => $column['width'],
                    ]);
                } else {
                    // Create new
                    SectionColumns::create([
                        'section_id' => $this->section_id,
                        'type_id' => $column['type_id'],
                        'alignment_id' => $column['alignment_id'],
                        'width' => $column['width'],
                    ]);
                }
            }

            if($this->page_id!=null){
                return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Section edited successfully!');
            }
            else if($this->entry_id!=null){

                return to_route('entry.sections', ['entryId' => $this->entry_id])->with('success', 'Section edited successfully!');
            }
   
        }
        
    }
    

    public function render()
    {
        return view('livewire.sections.section-form');
    }
}
