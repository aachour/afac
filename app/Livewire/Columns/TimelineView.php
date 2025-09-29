<?php

namespace App\Livewire\Columns;

use App\Models\ColumnTimeline;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TimelineView extends Component
{

    use AuthorizesRequests; 

    public $modalId = null;
    
    public $page_id;
    public $section_id;
    public $section_column_id;
    
    public $timelines;
    public $date;
    public $title;
    public $text;
    public $percentage;
    
    public function mount($pageId,$sectionId,$id)
    {

        $this->authorize('section-list');

        $this->modalId=null;
        
        $this->page_id=$pageId;
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->loadEntries();

    }

    public function loadEntries()
    {
        $this->timelines=ColumnTimeline::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
   
    }

    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnTimeline::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route('timeline.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }

    public function editEntry($id){
        $columnTimeline=ColumnTimeline::find($id);
        $this->date=$columnTimeline->date;
        $this->title=$columnTimeline->title;
        $this->text=$columnTimeline->text;
        $this->percentage=$columnTimeline->percentage;
        $this->modalId=$id;
    }

    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnTimeline::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            ColumnTimeline::create([
                'section_column_id'=>$this->section_column_id,
                'date'=>$this->date,
                'title'=>$this->title,
                'text'=>$this->text,
                'percentage'=>$this->percentage,
                'list_order'=> $highestOrder+1
            ]);

            return to_route('timeline.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Edit Collection
            ColumnTimeline::where('id', $this->modalId)
            ->update([
                'date' => $this->date,
                'title' => $this->title,
                'text' => $this->text,
                'percentage' => $this->percentage,
            ]);
            
            return to_route('timeline.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }

    #[On('delete')]
    public function delete($id)
    {
        $columnTimeline = ColumnTimeline::find($id);

        $columnTimeline->delete();

        return to_route('timeline.view', ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.columns.timeline-view');
    }
}
