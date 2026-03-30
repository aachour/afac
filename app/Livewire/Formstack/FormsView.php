<?php

namespace App\Livewire\Formstack;

use App\Models\FormStackForms;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FormsView extends Component
{

    use AuthorizesRequests; 

    public $forms = [];

    public function mount()
    {
        $this->authorize('formstack-forms');
        $this->forms=FormStackForms::all();
    }
    

    public function render()
    {
        return view('livewire.formstack.forms-view');
    }
}
