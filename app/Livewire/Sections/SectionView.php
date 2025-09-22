<?php

namespace App\Livewire\Sections;

use App\Models\Pages;
use App\Models\Types;
use App\Models\Collections;
use App\Models\Sections;
use App\Models\PageSections;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionView extends Component
{

    use AuthorizesRequests; 

    public $showModal = false;
    public $modalTitle = 'Add Collection';
    public $editingId = null;
   
    public $page_id;
    public $pageSections;

    public $types;
    public $type_id;
   
    public $collections;
    public $collection_id;    
        
    public function mount($pageId){

        $this->authorize('section-list');

        $this->page_id=$pageId;

        $this->collections=Collections::ORDERBY('id','DESC')->get();
        
        $this->types=Types::ORDERBY('name','DESC')->get();
        
        $this->pageSections=PageSections::WHERE('page_id',$this->page_id)->WITH('sections','collections')->ORDERBY('list_order','ASC')->get();

    }


    public function openModal($typeId = null)
    {
        // if ($typeId) {
        //     $type = Types::find($typeId);
        //     $this->editingId = $typeId;
        //     $this->name = $type->name;
        //     $this->modalTitle = 'Edit Type';
        // } else {
        //     $this->reset(['editingId', 'name']);
        //     $this->modalTitle = 'Add Type';
        // }
        $this->showModal = true;
         $this->dispatch('modalOpened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId' , 'type_id' , 'collection_id']);
    }

    #[On('setType')]
    public function setType($value)
    {
        $this->type_id = $value;
        dd("!");
    }

    #[On('setCollection')]
    public function setCollection($value)
    {
        $this->collection_id = $value;
        dd("!!!");
    }

    public function render()
    {
        return view('livewire.sections.section-view');
    }
}
