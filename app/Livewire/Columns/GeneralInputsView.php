<?php

namespace App\Livewire\Columns;

use App\Models\InputTypes;
use App\Models\ColumnGeneral;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GeneralInputsView extends Component
{

    use AuthorizesRequests; 

    public $modalId = null;
    
    public $page_id;
    public $section_id;
    public $section_column_id;

    public $inputTypes;
    public $generalInputs;
    public $title;
    public $text;
        
    public function mount($pageId,$sectionId,$id)
    {

        $this->authorize('section-list');

        $this->modalId=null;
        
        $this->page_id=$pageId;
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->inputTypes=InputTypes::all();

        dd($this->inputTypes);

        $this->loadEntries();

    }

    public function loadEntries()
    {
        $this->generalInputs=ColumnGeneral::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
   
    }

    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnGeneral::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route('accordion.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }

    public function editEntry($id){
        $generalInput=ColumnGeneral::find($id);
        $this->title=$generalInput->title;
        $this->text=$generalInput->text;
        $this->modalId=$id;
    }

    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnGeneral::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            ColumnGeneral::create([
                'section_column_id'=>$this->section_column_id,
                'title'=>$this->title,
                'text'=>$this->text,
                'list_order'=> $highestOrder+1
            ]);

            return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Edit Collection
            ColumnGeneral::where('id', $this->modalId)
            ->update([
                'title' => $this->title,
                'text' => $this->text,
            ]);
            
            return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }

    #[On('delete')]
    public function delete($id)
    {
        $generalInput = ColumnGeneral::find($id);

        $generalInput->delete();

        return to_route('general.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.columns.general-inputs-view');
    }
}
