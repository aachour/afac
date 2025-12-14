<?php

namespace App\Livewire\Logo;

use App\Models\Logo;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LogoView extends Component
{
    
    use AuthorizesRequests; 

    public $showModal = false;
    public $modalTitle = 'Edit Logo Element';
    public $logos;
    public $name = '';
    public $text = '';
    public $text_arabic = '';
    public $status = '';
    public $editingId = null;

    public function mount()
    {
        $this->authorize('logo-list');
        $this->loadLogo();
    }

    public function loadLogo()
    {
        $this->logos = Logo::all();
    }

    public function openModal($logoId = null)
    {
        if ($logoId) {
            $logo = Logo::find($logoId);
            $this->editingId = $logoId;
            $this->text = $logo->text;
            $this->text_arabic = $logo->text_arabic;
        } else {
            $this->reset(['editingId', 'text', 'text_arabic']);
        }
        $this->showModal = true;
    }

    public function saveLogo()
    {
        
        $rules = [
            'text' => 'nullable',
            'text_arabic' => 'nullable',
        ];

        $this->validate($rules);

        if ($this->editingId) {
            $this->authorize('logo-edit');
            $logo = Logo::find($this->editingId);
            $logo->update(['text' => $this->text , 'text_arabic' => $this->text_arabic ]);
            $message = 'Element updated successfully!';
        } 

        $this->closeModal();
        $this->loadLogo();
        return to_route('logo')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'text' , 'text_arabic' ]);
    }

    public function toggleActivate($id)
    {
        $logo = Logo::findOrFail($id);

        $logo->status = $logo->status == 0 ? 1 : 0;

        $text_action = $logo->status == 1 ? 'Activated' : 'deactivated';

        $logo->save();

        return to_route('logo')->with('success', 'Element '.$text_action.' successfully!');
    }

    public function render()
    {
        return view('livewire.logo.logo-view');
    }
}
