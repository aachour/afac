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

    public $modalId = null;
    
    public $page_id;
    public $pageSections;

    public $entry_id;
    public $entrySections;

    public $types;
    public $type_id;
   
    public $collections;
    public $collection_id;        
        
    public function mount($pageId='',$entryId=''){

        $this->authorize('section-list');

        $this->modalId=null;
        
        if(isset($pageId) && $pageId!=''){
            $this->page_id=$pageId;
        }
        else if(isset($entryId) && $entryId!=''){
            $this->entry_id=$entryId;
        }

        $this->types=Types::ORDERBY('name','ASC')->get();

        $this->collections=[];

        $this->loadPageSections();

    }

    public function loadPageSections()
    {   
        if($this->page_id!=null){
            $this->pageSections=PageSections::WHERE('page_id',$this->page_id)->WITH('sections','collections')->ORDERBY('list_order','ASC')->get();    
        }else if($this->entry_id!=null){
            $this->pageSections=PageSections::WHERE('entry_id',$this->entry_id)->WITH('sections','collections')->ORDERBY('list_order','ASC')->get();    
        }
    }

    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            PageSections::where('id', $id)->update(['list_order' => $index+1]);
        }

        if($this->page_id!=null){
            return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Order updated successfully!');
        }
        else if($this->entry_id!=null){
            return to_route('entry.sections', ['entryId' => $this->entry_id])->with('success', 'Order updated successfully!');
        }

    }

    public function editCollection($pageSectionId,$collectionId){

        $this->modalId=$pageSectionId;
        $collection=Collections::WHERE('id',$collectionId)->first();
        if($collection){
            $this->type_id=$collection->type_id;
            $this->collection_id=$collectionId;
            $this->dispatch('EditCollection', collection_id:$this->collection_id);
        }
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

        if($this->modalId==null && $this->collection_id!=''){

            if($this->page_id!=null){
                //Add collection
                $highestOrder = PageSections::WHERE('page_id',$this->page_id)->max('list_order');

                PageSections::create([
                    'page_id'=>$this->page_id,
                    'collection_id'=>$this->collection_id,
                    'list_order'=> $highestOrder+1
                ]);

                return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Collection added successfully!');
            }
            else if($this->entry_id!=null){
                
                //Add collection
                $highestOrder = PageSections::WHERE('entry_id',$this->entry_id)->max('list_order');

                PageSections::create([
                    'entry_id'=>$this->entry_id,
                    'collection_id'=>$this->collection_id,
                    'list_order'=> $highestOrder+1
                ]);

                return to_route('entry.sections', ['entryId' => $this->entry_id])->with('success', 'Collection deleted successfully!');
            }
            
        }
        else if($this->modalId!=null && $this->collection_id!=''){

            //Edit Collection
            
            PageSections::where('id', $this->modalId)
            ->update([
                'collection_id' => $this->collection_id,
            ]);

            if($this->page_id!=null){
                return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Collection edited successfully!');
            }
            else if($this->entry_id!=null){
                return to_route('entry.sections', ['entryId' => $this->entry_id])->with('success', 'Collection edited successfully!');
            }
            
        }
    }

    #[On('delete')]
    public function delete($id)
    {
        $pageSection = PageSections::find($id);

        $pageSection->delete();

        if($this->page_id!=null){
            return to_route('sections', ['pageId' => $this->page_id])->with('success', 'Section deleted successfully!');
        }
        else if($this->entry_id!=null){
            return to_route('entry.sections', ['entryId' => $this->entry_id])->with('success', 'Section deleted successfully!');
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
