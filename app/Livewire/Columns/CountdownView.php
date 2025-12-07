<?php

namespace App\Livewire\Columns;

use App\Models\Shapes;
use App\Models\Colors;
use App\Models\ColumnCountdown;
use App\Models\PageSections;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CountdownView extends Component
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
    
    public $countdowns;
    public $title;
    public $title_arabic;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $button_value;
    public $button_value_arabic;
    public $button_shape_id;
    public $button_hover_shape_id;
    public $button_bg_color_id;
    public $button_hover_bg_color_id;
    public $button_link;
    public $button_link_arabic;
    
            
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
            $this->return_route="countdown.view";
        }else if($this->entry_id!=null){
            $this->return_route="entry.countdown.view";
        }
        
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->loadEntries();
    }

    #[On('reset-modal')]
    public function clearData()
    {
        $this->reset(
            'title',
            'title_arabic',
            'start_date',
            'end_date',
            'start_time',
            'end_time',
            'button_value',
            'button_value_arabic',
            'button_shape_id',
            'button_hover_shape_id',
            'button_bg_color_id',
            'button_hover_bg_color_id',
            'button_link',
            'button_link_arabic'
        );
    }

    public function loadEntries()
    {
        $this->shapes=Shapes::ORDERBY('name','ASC')->get();
        $this->colors=Colors::ORDERBY('name','ASC')->get();
        
        $this->countdowns=ColumnCountdown::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
    }


    public function editEntry($id){

        $columnCountdown=ColumnCountdown::find($id);

        $this->title=$columnCountdown->title;
        $this->title_arabic=$columnCountdown->title_arabic;
        $this->start_date=$columnCountdown->start_date;
        $this->end_date=$columnCountdown->end_date;
        $this->start_time=$columnCountdown->start_time;
        $this->end_time=$columnCountdown->end_time;
        $this->button_value=$columnCountdown->button_value;
        $this->button_value_arabic=$columnCountdown->button_value_arabic;
        $this->button_shape_id=$columnCountdown->button_shape_id;
        $this->button_hover_shape_id=$columnCountdown->button_hover_shape_id;
        $this->button_bg_color_id=$columnCountdown->button_bg_color_id;
        $this->button_hover_bg_color_id=$columnCountdown->button_hover_bg_color_id;
        $this->button_link=$columnCountdown->button_link;
        $this->button_link_arabic=$columnCountdown->button_link_arabic;
        
        $this->modalId=$id;
    }


    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnCountdown::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            ColumnCountdown::create([
                'section_column_id'=>$this->section_column_id,
                'title' => $this->title,
                'title_arabic' => $this->title_arabic,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'button_shape_id' => $this->button_shape_id,
                'button_hover_shape_id' => $this->button_hover_shape_id,
                'button_bg_color_id' => $this->button_bg_color_id,
                'button_hover_bg_color_id' => $this->button_hover_bg_color_id,
                'button_link' => $this->button_link,
                'button_link_arabic' => $this->button_link_arabic,
                'list_order'=> $highestOrder+1
            ]);

            return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Edit Collection
            ColumnCountdown::where('id', $this->modalId)
            ->update([
                'title' => $this->title,
                'title_arabic' => $this->title_arabic,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
                'button_shape_id' => $this->button_shape_id,
                'button_hover_shape_id' => $this->button_hover_shape_id,
                'button_bg_color_id' => $this->button_bg_color_id,
                'button_hover_bg_color_id' => $this->button_hover_bg_color_id,
                'button_link' => $this->button_link,
                'button_link_arabic' => $this->button_link_arabic,
            ]);
            
            return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }
    }


    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnCountdown::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }


    #[On('delete')]
    public function delete($id)
    {
        $columnCountdown = ColumnCountdown::find($id);

        $columnCountdown->delete();

        return to_route($this->return_route, ['pageId' => $this->page_id , 'sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }

    
    public function render()
    {
        return view('livewire.columns.countdown-view');
    }
}
