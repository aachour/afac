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

    public $text;
    public $text_arabic;
    public $animation_style;
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

        $this->loadEntries();

    }

    #[On('reset-modal')]
    public function clearData()
    {
        $this->reset([
            'modalId',
            'text',
            'text_arabic',
            'animation_style',
        ]);
    }

    
    public function loadEntries()
    {
        $this->patterns=ColumnPattern::WHERE('section_column_id',$this->section_column_id)->ORDERBY('list_order','ASC')->get();
        
    }


    public function editEntry($id){

        $columnPattern=ColumnPattern::find($id);
        $this->modalId=$id;
        $this->text=$columnPattern->text;
        $this->text_arabic=$columnPattern->text_arabic;
        $this->animation_style=$columnPattern->animation_style;

        $this->dispatch('fill-editors', [
                'text' => $this->text ?? '',
                'text_arabic' => $this->text_arabic ?? '',
                'animation_style' => $this->animation_style ?? '',
                
            ]);

        $this->dispatch('open-general-input-modal');

    }


    public function saveEntry(){

        if($this->modalId==null){

            //Add collection
            $highestOrder = ColumnPattern::WHERE('section_column_id',$this->section_column_id)->max('list_order');

            $pattern=ColumnPattern::create([
                'section_column_id'=>$this->section_column_id,
                'text'=>$this->text,
                'text_arabic'=>$this->text_arabic,
                'animation_style'=>$this->animation_style,
                'list_order'=> $highestOrder+1
            ]);

            return to_route($this->return_route, ['sectionId' => $this->section_id , 'id' => $this->section_column_id])->with('success', 'Entry added successfully!');
        }
        else if($this->modalId!=null){

            //Update Date
            $columnPattern=ColumnPattern::find($this->modalId);
            $columnPattern->text=$this->text;
            $columnPattern->text_arabic=$this->text_arabic;
            $columnPattern->animation_style=$this->animation_style;
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
