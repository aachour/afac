<?php

namespace App\Livewire\Projects;

use App\Models\ProjectCategories;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectCategoryView extends Component
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
        $this->authorize('projectCategory-list');

        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = ProjectCategories::all();
    }

    public function openModal($categoryId = null)
    {
        if ($categoryId) {
            $category = ProjectCategories::find($categoryId);
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
            $this->authorize('projectCategory-edit');
            $category = ProjectCategories::find($this->editingId);
            $category->update(['name' => $this->name,'name_arabic' => $this->name_arabic]);
            $message = 'Category updated successfully!';
        } else {
            $this->authorize('projectCategory-create');
            ProjectCategories::create(['name' => $this->name,'name_arabic' => $this->name_arabic]);
            $message = 'Category added successfully!';
        }

        $this->closeModal();
        $this->loadCategories();
        return to_route('project.categories')->with('success', $message);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'name', 'name_arabic']);
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('projectCategory-delete');

        $category = ProjectCategories::find($id);

        $category->delete();

        return to_route('project.categories')->with('success', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.projects.project-category-view');
    }
}
