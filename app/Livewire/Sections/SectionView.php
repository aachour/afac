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

        $this->types=Types::ORDERBY('name','ASC')->get();

        $this->collections=[];
                
        $this->pageSections=PageSections::WHERE('page_id',$this->page_id)->WITH('sections','collections')->ORDERBY('list_order','ASC')->get();

    }


    public function setTypeId($typeId): void
    {
        $this->type_id = $typeId ?: null;
    }
    

    public function setCollectionId($collectionId): void
    {
        $this->collection_id = $collectionId ?: null;
    }

    public function saveCollection(){
        if($this->collection_id!=''){

            $highestOrder = PageSections::WHERE('page_id',$this->page_id)->max('list_order');

            PageSections::create([
                'page_id'=>$this->page_id,
                'collection_id'=>$this->collection_id,
                'list_order'=> $highestOrder+1
            ]);

            return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Collection added successfully!');
        }
    }

    public function render()
    {

        $this->collections=[];
        if($this->type_id!=''){
            $this->collections=Collections::WHERE('type_id',$this->type_id)->ORDERBY('id','DESC')->get();
        }

        return view('livewire.sections.section-view',[$this->collections]);
    }
}
