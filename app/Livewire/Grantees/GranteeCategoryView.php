<?php

namespace App\Livewire\Grantees;

use App\Models\GranteeCategories;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class GranteeCategoryView extends Component
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
        $this->authorize('granteeCategory-list');

        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = GranteeCategories::all();
    }

    public function openModal($categoryId = null)
    {
        if ($categoryId) {
            $category = GranteeCategories::find($categoryId);
            $this->editingId = $categoryId;
            $this->name = $category->name;
            $this->name_arabic = $category->name_arabic;
            $this->modalTitle = 'Edit Category';
        } else {
            $this->reset(['editingId', 'name' , 'name_arabic']);
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
            $this->authorize('granteeCategory-edit');
            $category = GranteeCategories::find($this->editingId);
            $category->update(['name' => $this->name,'name_arabic' => $this->name_arabic]);
            $message = 'Category updated successfully!';
        } else {
            $this->authorize('granteeCategory-create');
            GranteeCategories::create(['name' => $this->name,'name_arabic' => $this->name_arabic]);
            $message = 'Category added successfully!';
        }

        $this->closeModal();
        $this->loadCategories();
        return to_route('grantee.categories')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'name', 'name_arabic']);
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('granteeCategory-delete');

        $category = GranteeCategories::find($id);

        $category->delete();

        return to_route('grantee.categories')->with('success', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.grantees.grantee-category-view');
    }
}
