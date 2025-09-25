<?php

namespace App\Livewire\Sections;

use App\Models\Sections;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionForm extends Component
{

    use AuthorizesRequests; 

    public $editing = false;

    public $section;
    

    public function mount($id=''){

        if($id==''){
            $this->authorize('section-create');
        }
        else{

            $this->authorize('section-edit');
            
        }
        
    }

    public function render()
    {
        return view('livewire.sections.section-form');
    }
}
