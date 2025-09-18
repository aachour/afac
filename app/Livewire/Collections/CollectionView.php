<?php

namespace App\Livewire\Collections;

use App\Models\Collections;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CollectionView extends Component
{

    use AuthorizesRequests; 

    public $collections;

    public function mount(){

        $this->authorize('collection-list');

        $this->collections=Collections::all();

    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('collection-delete');

        $collection = Collections::find($id);

        $collection->delete();

        return to_route('collections')->with('success', 'Collection deleted successfully!');
    }

    public function render()
    {
        return view('livewire.collections.collection-view');
    }
}
