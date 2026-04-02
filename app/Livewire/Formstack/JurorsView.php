<?php

namespace App\Livewire\FormStack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackAssigns;

use Spatie\Permission\Models\Role;

class JurorsView extends Component
{

    use AuthorizesRequests; 

    public $assigns = [];

    public function mount($formId,$submissionId='')
    {
        $this->authorize('formstack-viewAssignedJurors');
        
        $this->assigns = FormStackAssigns::where('form_id', $formId)
        ->whereHas('user.roles', function ($query) {
            $query->where('name', 'juror');
        })
        ->select('user_id')
        ->distinct()
        ->get();

    }

    public function render()
    {
        return view('livewire.form-stack.jurors-view');
    }
}
