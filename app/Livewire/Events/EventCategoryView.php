<?php

namespace App\Livewire\Events;

use App\Models\EventCategories;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventCategoryView extends Component
{

    use AuthorizesRequests;

    public $categories = [];
    public $showModal = false;
    public $modalTitle = 'Add Category';
    public $name = '';
    public $editingId = null;

    public function mount()
    {
        $this->authorize('eventCategory-list');

        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = EventCategories::all();
    }

    public function openModal($categoryId = null)
    {
        if ($categoryId) {
            $category = EventCategories::find($categoryId);
            $this->editingId = $categoryId;
            $this->name = $category->name;
            $this->modalTitle = 'Edit Category';
        } else {
            $this->reset(['editingId', 'name']);
            $this->modalTitle = 'Add Category';
        }
        $this->showModal = true;
    }

    public function saveCategory()
    {
        $rules = [
            'name' => 'required',
        ];

        $this->validate($rules);

        if ($this->editingId) {
            $this->authorize('eventCategory-edit');
            $category = EventCategories::find($this->editingId);
            $category->update(['name' => $this->name]);
            $message = 'Category updated successfully!';
        } else {
            $this->authorize('eventCategory-create');
            EventCategories::create(['name' => $this->name]);
            $message = 'Category added successfully!';
        }

        $this->closeModal();
        $this->loadCategories();
        return to_route('event.categories')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'name']);
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('eventCategory-delete');

        $category = EventCategories::find($id);

        $category->delete();

        return to_route('event.categories')->with('success', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.events.event-category-view');
    }
}
