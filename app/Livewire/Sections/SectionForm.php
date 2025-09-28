<?php

namespace App\Livewire\Sections;

use App\Models\Sections;
use App\Models\ColumnTypes;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionForm extends Component
{

    use AuthorizesRequests; 

    public $editing = false;

    public $section;

    public $page_id;
    public $section_id;

    public $columns;
    public $columnTypes;
    public $columnAlignments = ['1'=>'left' , '2'=>'right' , '3'=>'center'];
    public $columns_num;
    public $columns_max=2;


    public function mount($pageId='',$sectionId=''){
        
        $this->page_id=$pageId;

        if($sectionId==''){

            $this->authorize('section-create');

            $this->columns_num=1;
            $this->columns[] = ['type_id' => '','alignment_id'=>''];
        }
        else{

            $this->authorize('section-edit');

            $this->section_id=$sectionId;
            
        }
        
        $this->columnTypes=ColumnTypes::ORDERBY('name','ASC')->get();
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
    

    public function render()
    {
        return view('livewire.sections.section-form');
    }
}
