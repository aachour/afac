<?php

namespace App\Livewire\Resources;

use App\Models\ResourceCategories;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ResourceCategoryView extends Component
{

use AuthorizesRequests;

    public $categories = [];
    public $showModal = false;
    public $modalTitle = 'Add Category';
    public $name = '';
    public $name_arabic = '';
    public $editingId = null;

    public function mount()
    {
        $this->authorize('resourceCategory-list');

        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = ResourceCategories::all();
    }

    public function openModal($categoryId = null)
    {
        if ($categoryId) {
            $category = ResourceCategories::find($categoryId);
            $this->editingId = $categoryId;
            $this->name = $category->name;
            $this->name_arabic = $category->name_arabic;
            $this->modalTitle = 'Edit Category';
        } else {
            $this->reset(['editingId', 'name', 'name_arabic']);
            $this->modalTitle = 'Add Category';
        }
        $this->showModal = true;
    }

    public function saveCategory()
    {
        $rules = [
            'name' => 'required',
            'name_arabic' => 'required',
        ];

        $this->validate($rules);

        if ($this->editingId) {
            $this->authorize('resourceCategory-edit');
            $category = ResourceCategories::find($this->editingId);
            $category->update(['name' => $this->name,'name_arabic' => $this->name_arabic]);
            $message = 'Category updated successfully!';
        } else {
            $this->authorize('resourceCategory-create');
            ResourceCategories::create(['name' => $this->name,'name_arabic' => $this->name_arabic]);
            $message = 'Category added successfully!';
        }

        $this->closeModal();
        $this->loadCategories();
        return to_route('resource.categories')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'name', 'name_arabic']);
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('resourceCategory-delete');

        $category = ResourceCategories::find($id);

        $category->delete();

        return to_route('resource.categories')->with('success', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.resources.resource-category-view');
    }
}
