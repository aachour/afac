<?php

namespace App\Livewire\FormStack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackAssigns;

class ViewersView extends Component
{

    use AuthorizesRequests; 

    public $assigns = [];

    public function mount($formId,$submissionId='')
    {
        $this->authorize('formstack-viewAssignedViewers');
        
        $this->assigns = FormStackAssigns::where('form_id', $formId)
        ->whereHas('user.roles', function ($query) {
            $query->where('name', 'viewer');
        })
        ->select('user_id')
        ->distinct()
        ->get();

    }

    public function render()
    {
        return view('livewire.form-stack.viewers-view');
    }
}
