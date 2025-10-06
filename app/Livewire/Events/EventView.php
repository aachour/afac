<?php

namespace App\Livewire\Events;

use App\Models\EventCategories;
use App\Models\Events;
use Livewire\Attributes\On;

use Livewire\Component;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class EventView extends Component
{

    use AuthorizesRequests; 
        
    public $events;

    public function mount(){

        $this->authorize('event-list');

        $this->events=Events::all();

    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('event-delete');

        $event = Events::find($id);

        $event->delete();

        return to_route('pages')->with('success', 'Event deleted successfully!');
    }

    public function render()
    {
        return view('livewire.events.event-view');
    }
}
