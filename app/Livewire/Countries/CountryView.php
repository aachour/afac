<?php

namespace App\Livewire\Countries;

use App\Models\Countries;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CountryView extends Component
{

    use AuthorizesRequests; 

    public $countries = [];

    public function mount()
    {
        $this->authorize('country-list');
        $this->countries=Countries::all();
    }

    
    public function activate($id)
    {
        Countries::where('id', $id)->update(['active' => 1]);
        return to_route('countries')->with('success', 'Country activated successfully');
    }

    public function deactivate($id)
    {
        Countries::where('id', $id)->update(['active' => 0]);
        return to_route('countries')->with('success', 'Country deactivated successfully');
    }


    public function render()
    {
        return view('livewire.countries.country-view');
    }
}
