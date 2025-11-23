<?php

namespace App\Livewire\Columns;

use App\Models\Shapes;
use App\Models\ColumnTimeline;
use App\Models\ColumnTimelinePercentages;
use App\Models\PageSections;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TimelineView extends Component
{

    use AuthorizesRequests; 

    public $modalId = null;

    public $page_id;
    public $entry_id;
    public $return_route;
    
    public $section_id;
    public $section_column_id;
    
    public $shapes;
    public $timelines;
    public $date;
    public $entries;
    
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
            $this->return_route="timeline.view";
        }else if($this->entry_id!=null){
            $this->return_route="entry.timeline.view";
        }
        
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->shapes=Shapes::ORDERBY('name','ASC')->get();

        $this->loadEntries();

    }

    public function loadEntries()
    {
        $this->timelines=ColumnTimeline::WITH('percentages')->WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
        
        $this->entries=[];
    }


    public function addEntry(){
        $this->entries[] = ['id'=>'','text' => '','text_arabic'=>'','shape_id'=>'','percentage'=>''];
        $this->dispatch('activateCkeditor');
    }


    public function deleteEntry($index){
        unset($this->entries[$index]);
        $this->entries = array_values($this->entries);
    }


    public function editEntry($id){
        $columnTimeline=ColumnTimeline::with('percentages')->find($id);
        $this->date=$columnTimeline->date;

        foreach($columnTimeline->percentages as $percentage){
            $this->entries[] = ['id'=>$percentage->id , 'text' => $percentage->text , 'text_arabic'=>$percentage->text_arabic , 'shape_id'=>$percentage->shape_id , 'percentage'=>$percentage->percentage];

            $this->dispatch('activateCkeditor');
        }
            
        $this->modalId=$id;
    }


    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnTimeline::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            $timeline=ColumnTimeline::create([
                'section_column_id'=>$this->section_column_id,
                'date'=>$this->date,
                'list_order'=> $highestOrder+1
            ]);

            foreach($this->entries as $entry){
                ColumnTimelinePercentages::create([
                    'timeline_id'=>$timeline->id,
                    'text'=>$entry["text"] ?? '',
                    'text_arabic'=>$entry["text_arabic"] ?? '',
                    'shape_id'=> $entry['shape_id'] !== '' ? $entry['shape_id'] : null,
                    'percentage'=>(int) ($entry["percentage"] ?? 0),
                ]);
            }

            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Update Date
            $columnTimeline=ColumnTimeline::with('percentages')->find($this->modalId);
            $columnTimeline->date=$this->date;
            $columnTimeline->save();

            // Collect IDs of the submitted columns
            $entriesId = [];
            foreach($this->entries as $entry){
                $entriesId[]=$entry["id"];
            }

            // Delete columns that were removed
            ColumnTimelinePercentages::where('timeline_id', $this->modalId)
                ->whereNotIn('id', $entriesId)
                ->delete();

            // Loop through submitted columns
            foreach($this->entries as $entry){
                if (!empty($entry['id'])) {
                    // Update existing
                    ColumnTimelinePercentages::where('id', $entry['id'])->update([
                        'timeline_id'=>$this->modalId,
                        'text'=>$entry["text"] ?? '',
                        'text_arabic'=>$entry["text_arabic"] ?? '',
                        'shape_id'=>$entry['shape_id'] !== '' ? $entry['shape_id'] : null,
                        'percentage'=>(int) ($entry["percentage"] ?? 0),
                    ]);
                } else {
                    // Create new
                    ColumnTimelinePercentages::create([
                        'timeline_id'=>$this->modalId,
                        'text'=>$entry["text"] ?? '',
                        'text_arabic'=>$entry["text_arabic"] ?? '',
                        'shape_id'=>$entry['shape_id'] !== '' ? $entry['shape_id'] : null,
                        'percentage'=>(int) ($entry["percentage"] ?? 0),
                    ]);
                }
            }
            
            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }

    }


    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnTimeline::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }

    
    #[On('delete')]
    public function delete($id)
    {
        $columnTimeline = ColumnTimeline::find($id);

        $columnTimeline->delete();

        return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }


    public function render()
    {
        return view('livewire.columns.timeline-view');
    }
}
