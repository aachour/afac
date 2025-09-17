<?php

namespace App\Livewire\Colors;

use App\Models\Colors;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ColorView extends Component
{

    use AuthorizesRequests; 

    public $colors = [];
    public $showModal = false;
    public $modalTitle = 'Add Type';
    public $name = '';
    public $code = '';
    public $editingId = null;

    public function mount()
    {
        $this->authorize('color-list');
        $this->loadColors();
    }

    public function loadColors()
    {
        $this->colors = Colors::all();
    }

    public function openModal($typeId = null)
    {
        if ($typeId) {
            $color = Colors::find($typeId);
            $this->editingId = $typeId;
            $this->name = $color->name;
            $this->code = $color->code;
            $this->modalTitle = 'Edit Color';
        } else {
            $this->reset(['editingId', 'name']);
            $this->modalTitle = 'Add Color';
        }
        $this->showModal = true;
    }

    public function saveColor()
    {
        
        $rules = [
            'name' => 'required',
            'code' => 'required',
        ];

        $this->validate($rules);

        if ($this->editingId) {
            $this->authorize('color-edit');
            $color = Colors::find($this->editingId);
            $color->update(['name' => $this->name , 'code' => $this->code]);
            $message = 'Color updated successfully!';
        } else {
            $this->authorize('color-create');
            Colors::create(['name' => $this->name , 'code' => $this->code]);
            $message = 'Color added successfully!';
        }

        $this->closeModal();
        $this->loadColors();
        return to_route('colors')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'name' , 'code']);
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('color-delete');

        $color = Colors::find($id);

        $color->delete();

        return to_route('colors')->with('success', 'Color deleted successfully!');
    }

    public function render()
    {
        return view('livewire.colors.color-view');
    }
}
