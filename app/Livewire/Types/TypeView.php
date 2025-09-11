<?php

namespace App\Livewire\Types;

use App\Models\Types;
use Livewire\Attributes\On;
use Livewire\Component;

class TypeView extends Component
{

    public $types = [];
    public $showModal = false;
    public $modalTitle = 'Add Type';
    public $name = '';
    public $editingId = null;

    public function mount()
    {
        $this->loadTypes();
    }

    public function loadTypes()
    {
        $this->types = Types::all();
    }

    public function openModal($typeId = null)
    {
        if ($typeId) {
            $type = Types::find($typeId);
            $this->editingId = $typeId;
            $this->name = $type->name;
            $this->modalTitle = 'Edit Type';
        } else {
            $this->reset(['editingId', 'name']);
            $this->modalTitle = 'Add Type';
        }
        $this->showModal = true;
    }

    public function saveType()
    {
        $rules = [
            'name' => 'required',
        ];

        $this->validate($rules);

        if ($this->editingId) {
            $type = Types::find($this->editingId);
            $type->update(['name' => $this->name]);
            $message = 'Type updated successfully!';
        } else {
            Types::create(['name' => $this->name]);
            $message = 'Type added successfully!';
        }

        $this->closeModal();
        $this->loadTypes();
        return to_route('types')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'name']);
    }

    #[On('delete')]
    public function delete($id)
    {
        $type = Types::find($id);

        $type->delete();

        return to_route('types')->with('success', 'Type deleted successfully!');
    }

    public function render()
    {
        return view('livewire.types.type-view');
    }
}
