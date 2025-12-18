<?php

namespace App\Livewire\Columns;

use App\Models\Shapes;
use App\Models\Colors;
use App\Models\ColumnPattern;
use App\Models\PageSections;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PatternView extends Component
{

    use AuthorizesRequests; 

    public $modalId = null;

    public $page_id;
    public $entry_id;
    public $return_route;
    
    public $section_id;
    public $section_column_id;

    public $button_shape_id;
    public $button_hover_shape_id;
    public $button_bg_color_id;
    public $button_hover_bg_color_id;
    public $button_text;
    public $button_text_arabic;
    public $button_link;
    public $button_link_arabic;
    
    public $shapes;
    public $colors;
    public $patterns;
    
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
            $this->return_route="pattern.view";
        }else if($this->entry_id!=null){
            $this->return_route="entry.pattern.view";
        }
        
        $this->section_id=$sectionId;
        $this->section_column_id=$id;

        $this->shapes=Shapes::ORDERBY('name','ASC')->get();
        $this->colors=Colors::ORDERBY('name','ASC')->get();

        $this->loadEntries();

    }

    #[On('reset-modal')]
    public function clearData()
    {
        $this->reset([
            'modalId',
            'button_shape_id',
            'button_hover_shape_id',
            'button_bg_color_id',
            'button_hover_bg_color_id',
            'button_text',
            'button_text_arabic',
            'button_link',
            'button_link_arabic',
        ]);
    }

    
    public function loadEntries()
    {
        $this->patterns=ColumnPattern::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
        
    }


    public function editEntry($id){

        $columnPattern=ColumnPattern::find($id);
        $this->modalId=$id;
        $this->button_shape_id=$columnPattern->button_shape_id;
        $this->button_hover_shape_id=$columnPattern->button_hover_shape_id;
        $this->button_bg_color_id=$columnPattern->button_bg_color_id;
        $this->button_hover_bg_color_id=$columnPattern->button_hover_bg_color_id;
        $this->button_text=$columnPattern->button_text;
        $this->button_text_arabic=$columnPattern->button_text_arabic;
        $this->button_link=$columnPattern->button_link;
        $this->button_link_arabic=$columnPattern->button_link_arabic;
        
    }


    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnPattern::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            $pattern=ColumnPattern::create([
                'section_column_id'=>$this->section_column_id,
                'button_shape_id'=>$this->button_shape_id,
                'button_hover_shape_id'=>$this->button_hover_shape_id,
                'button_bg_color_id'=>$this->button_bg_color_id,
                'button_hover_bg_color_id'=>$this->button_hover_bg_color_id,
                'button_text'=>$this->button_text,
                'button_text_arabic'=>$this->button_text_arabic,
                'button_link'=>$this->button_link,
                'button_link_arabic'=>$this->button_link_arabic,
                'list_order'=> $highestOrder+1
            ]);

            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Update Date
            $columnPattern=ColumnPattern::find($this->modalId);
            $columnPattern->button_shape_id=$this->button_shape_id;
            $columnPattern->button_shape_id=$this->button_shape_id;
            $columnPattern->button_bg_color_id=$this->button_bg_color_id;
            $columnPattern->button_hover_bg_color_id=$this->button_hover_bg_color_id;
            $columnPattern->button_text=$this->button_text;
            $columnPattern->button_text_arabic=$this->button_text_arabic;
            $columnPattern->button_link=$this->button_link;
            $columnPattern->button_link_arabic=$this->button_link_arabic;
            $columnPattern->save();
            
            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry edited successfully!');
        }

    }


    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ColumnPattern::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Order updated successfully!');

    }

    
    #[On('delete')]
    public function delete($id)
    {
        $columnPattern = ColumnPattern::find($id);

        $columnPattern->delete();

        return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.columns.pattern-view');
    }
}
