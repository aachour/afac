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

    public $page_id;
    public $section_id;

    public $columns;
    public $columnTypes;
    public $alignmentTypes;
    public $columns_num;
    public $columns_max=2;


    public function mount($pageId='',$id=''){
        
        $this->page_id=$pageId;

        if($id==''){

            $this->authorize('section-create');

            $this->columns_num=1;
            $this->columns[] = ['type_id' => '','alignment_id'=>''];
        }
        else{

            $this->authorize('section-edit');

            $this->section_id=$id;

            $this->section=Sections::find($this->section_id);

            $this->name=$this->section->name;

            $sectionColumns=SectionColumns::WHERE('section_id',$this->section_id)->get();

            foreach($sectionColumns as $sectionColumn){
                $obj=[
                    'type_id'=>$sectionColumn->type_id,
                    'alignment_id'=>$sectionColumn->alignment_id,
                ];
                $this->columns[]=$obj;
            }

        }
        
        $this->columnTypes=ColumnTypes::ORDERBY('name','ASC')->get();
        $this->alignmentTypes=AlignmentTypes::ORDERBY('name','ASC')->get();
        
    }

    public function AddColumn(){
        
        $this->columns[] = ['type_id' => '','alignment_id'=>''];

        $this->columns_num++;

    }


    public function DeleteColumn($index){
        unset($this->columns[$index]);
        $this->columns = array_values($this->columns);
        $this->columns_num--;
    }


    public function rules()
    {
        $data = [
            'page_id' => 'required',
            'name' => 'required',
            'columns' => 'required|array|min:1',
            'columns.*.type_id' => 'required|integer|exists:column_types,id',
            'columns.*.alignment_id' => 'required|integer|exists:alignment_types,id',
        ];

        return $data;
    }

    public function store()
    {

        $this->validate();

        if($this->section_id==''){
            
            //create new section
            $section=Sections::create([
                'page_id' => $this->page_id,
                'name' => $this->name,
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
                    'type_id' => $column['type_id'],
                    'alignment_id' => $column['alignment_id'],
                ]);
            }

            return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Section created successfully!');

        }
        else if($this->section_id!=''){

            

            return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Section edited successfully!');
   
        }
        
    }
    

    public function render()
    {
        return view('livewire.sections.section-form');
    }
}
