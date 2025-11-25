<?php

namespace App\Livewire\Columns;

use App\Models\ColumnAccordion;
use App\Models\PageSections;


use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccordionView extends Component
{

    use AuthorizesRequests; 

    public $modalId = null;

    public $page_id;
    public $entry_id;
    public $return_route;

    public $section_id;
    public $section_column_id;
    
    public $accordions;
    public $title;
    public $text;
    public $title_arabic;
    public $text_arabic;
    
        
    public function mount($sectionId,$id)
    {

        $this->authorize('section-list');

        $this->modalId=null;

        $pageSection=PageSections::WHERE('section_id',$sectionId)->first();
        
        if($pageSection){
            $this->page_id=$pageSection->page_id;
            $this->entry_id=$pageSection->entry_id;
        }else{
            return to_route('dashboard');
        }

        if($this->page_id!=null){
            $this->return_route="accordion.view";
        }else if($this->entry_id!=null){
            $this->return_route="entry.accordion.view";
        }
        
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->loadEntries();

    }


    #[On('reset-modal')]
    public function clearData()
    {
        $this->reset([
            'modalId',
            'title',
            'text',
            'title_arabic',
            'text_arabic',
        ]);  
        
        $this->dispatch('set-editor-value', id: 'text', value: '');
        $this->dispatch('set-editor-value-arabic', id: 'text_arabic', value: '');

    }

    public function loadEntries()
    {
        $this->accordions=ColumnAccordion::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
   
    }

    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnAccordion::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route($this->return_route, [ 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }

    public function editEntry($id){
        $columnAccordion=ColumnAccordion::find($id);
        $this->title=$columnAccordion->title;
        $this->text=$columnAccordion->text;
        $this->title_arabic=$columnAccordion->title_arabic;
        $this->text_arabic=$columnAccordion->text_arabic;
        $this->modalId=$id;
        $this->dispatch('set-editor-value', id: 'text', value: $this->text);
        $this->dispatch('set-editor-value-arabic', id: 'text_arabic', value: $this->text_arabic);
    }

    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnAccordion::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            ColumnAccordion::create([
                'section_column_id'=>$this->section_column_id,
                'title'=>$this->title,
                'text'=>$this->text,
                'title_arabic'=>$this->title_arabic,
                'text_arabic'=>$this->text_arabic,
                'list_order'=> $highestOrder+1
            ]);

            return to_route($this->return_route, [ 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Edit Collection
            ColumnAccordion::where('id', $this->modalId)
            ->update([
                'title' => $this->title,
                'text' => $this->text,
                'title_arabic'=>$this->title_arabic,
                'text_arabic'=>$this->text_arabic,
            ]);
            
            return to_route($this->return_route, [ 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }

    #[On('delete')]
    public function delete($id)
    {
        $columnAccordion = ColumnAccordion::find($id);

        $columnAccordion->delete();

        return to_route($this->return_route, [ 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.columns.accordion-view');
    }
}
