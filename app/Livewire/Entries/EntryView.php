<?php

namespace App\Livewire\Entries;

use App\Models\EventCategories;
use App\Models\ProjectCategories;
use App\Models\Entries;
use App\Models\Types;

use Livewire\Attributes\On;

use Livewire\Component;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EntryView extends Component
{

    use AuthorizesRequests; 

    public $types;
    public $type_name;
    
    public $event_categories;
    public $project_categories;
    
    public $type_id;
    public $entries;

    public function mount($typeId='')
    {

        $this->authorize('entry-list');

        if(!isset($typeId) || $typeId==''){
            return to_route('dashboard');
        }

        $this->types=Types::all();
        $this->event_categories=EventCategories::all();
        $this->project_categories=ProjectCategories::all();

        $this->type_id=$typeId;
        $this->type_name = Types::where('id', $this->type_id)->value('name');
        $this->entries=Entries::WHERE('type_id',$this->type_id)->get();

    }

    public function togglePublish($id)
    {
        $entry = Entries::findOrFail($id);

        $entry->published = $entry->published == 0 ? 1 : 0;

        $text_action = $entry->published == 1 ? 'published' : 'unpublished';

        $entry->save();

        return to_route('entries',['typeId'=>$this->type_id])->with('success', 'Entry '.$text_action.' successfully!');
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('entry-delete');

        $entry = Entries::find($id);

        $entry->delete();

        return to_route('entries',['typeId'=>$this->type_id])->with('success', 'Entry deleted successfully!');
    }

    public function render()
    {
        return view('livewire.entries.entry-view');
    }
}
