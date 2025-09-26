<?php

namespace App\Livewire\Sections;

use App\Models\Sections;
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
    
    public function mount($pageId='',$sectionId=''){
        
        $this->page_id=$pageId;

        if($sectionId==''){
            $this->authorize('section-create');

            $this->columns[] = ['name' => ''];
        }
        else{

            $this->authorize('section-edit');

            $this->section_id=$sectionId;
            
        }
        
    }

    public function AddColumn(){
        
        $this->columns[] = ['name' => ''];

        // array_push($this->columns, 'New Column');

    }


    public function DeleteColumn($index){
        unset($this->columns[$index]);
        $this->columns = array_values($this->columns);
    }
    

    public function render()
    {
        return view('livewire.sections.section-form');
    }
}
