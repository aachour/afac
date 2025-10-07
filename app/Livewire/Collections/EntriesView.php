<?php

namespace App\Livewire\Collections;

use App\Models\Collections;
use App\Models\CollectionEntries;
use App\Models\Events;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EntriesView extends Component
{

    use AuthorizesRequests; 

    public $collection_id;
    public $collection;
    public $collection_type_id;
    public $collection_entries;
    public $entries;
    public $entry_id;
    public $modalId;

    public function mount($id){

        $this->collection_id=$id;
        
        $this->collection=Collections::find($this->collection_id);
        
        if($this->collection){
            $this->collection_type_id=$this->collection->type_id;
        }

        $this->entries=[];

        if($this->collection_type_id==1){//events
            $this->entries=Events::ORDERBY('id','DESC')->get();
        }

        $this->collection_entries=CollectionEntries::WHERE('collection_id',$this->collection_id)->ORDERBY('list_order','ASC')->GET();
        

        $this->authorize('collection-edit');

    }

    public function setEntryId($entryId): void
    {
        $this->entry_id = $entryId ?: null;
    }

    public function saveEntry(){
        if($this->modalId==null && $this->entry_id!=''){

            //Add collection
            $highestOrder = CollectionEntries::WHERE('collection_id',$this->collection_id)->max('list_order');

            if($this->collection_type_id==1){// add events
                CollectionEntries::create([
                    'collection_id'=>$this->collection_id,
                    'event_id'=>$this->entry_id,
                    'list_order'=> $highestOrder+1
                ]);
            }

            return to_route('entries.edit', ['id' => $this->collection_id])->with('success', 'Entry added successfully!');
        }
        
    }

    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        if($this->collection_type_id==1){ // update collection events
            foreach ($order as $index => $id) {
                CollectionEntries::where(['collection_id'=>$this->collection_id,'id'=>$id])->update(['list_order' => $index+1]);
            }
        }

        return to_route('entries.edit', ['id' => $this->collection_id])->with('success', 'Order updated successfully!');

    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('collection-delete');

        $entry = CollectionEntries::find($id);

        $entry->delete();

        return to_route('entries.edit', ['id' => $this->collection_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.collections.entries-view');
    }
}
