<?php

namespace App\Livewire\Columns;

use App\Models\ColumnExpandTexts;
use App\Models\PageSections;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpandingTextView extends Component
{

    use AuthorizesRequests; 

    public $modalId = null;
    
    public $page_id;
    public $entry_id;
    public $return_route;

    public $section_id;
    public $section_column_id;
    
    public $shapes;
    public $colors;
    
    public $expandingTexts;
    public $text;
    public $text_arabic;
    public $visible;
            
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
            $this->return_route="expendingText.view";
        }else if($this->entry_id!=null){
            $this->return_route="entry.expendingText.view";
        }
        
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->loadEntries();
    }

    #[On('reset-modal')]
    public function clearData()
    {
        $this->reset(
            'text',
            'text_arabic',
            'visible',
        );
    }

    public function loadEntries()
    {
        $this->expandingTexts=ColumnExpandTexts::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
    }


    public function editEntry($id){
        $columnCountdown=ColumnExpandTexts::find($id);

        $this->text=$columnCountdown->text;
        $this->text_arabic=$columnCountdown->text_arabic;
        $this->visible=$columnCountdown->visible;
        
        $this->modalId=$id;
    }


    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnExpandTexts::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            ColumnExpandTexts::create([
                'section_column_id'=>$this->section_column_id,
                'text' => $this->text,
                'text_arabic' => $this->text_arabic,
                'visible' => $this->visible,
                'list_order'=> $highestOrder+1
            ]);

            return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Edit Collection
            ColumnExpandTexts::where('id', $this->modalId)
            ->update([
                'text' => $this->text,
                'text_arabic' => $this->text_arabic,
                'visible' => $this->visible,
            ]);
            
            return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }


    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnExpandTexts::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }


    #[On('delete')]
    public function delete($id)
    {
        $columnExpandText = ColumnExpandTexts::find($id);

        $columnExpandText->delete();

        return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.columns.expanding-text-view');
    }
}
