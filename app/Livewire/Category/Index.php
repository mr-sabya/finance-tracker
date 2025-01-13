<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $name, $parent_id, $category_id, $isEditMode = false, $categoryIdToDelete;
    public $search = ''; // For searching
    public $sortField = 'name'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction

    protected $rules = [
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:categories,id',
    ];

    public function resetInput()
    {
        $this->name = '';
        $this->parent_id = null;
        $this->category_id = null;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->validate();
        Category::create(['user_id' => Auth::id(), 'name' => $this->name, 'parent_id' => $this->parent_id]);
        session()->flash('message', 'Category created successfully.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->parent_id = $category->parent_id;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();
        $category = Category::findOrFail($this->category_id);
        $category->update(['name' => $this->name, 'parent_id' => $this->parent_id]);
        session()->flash('message', 'Category updated successfully.');
        $this->resetInput();
    }

    public function confirmDelete($categoryId)
    {
        $this->categoryIdToDelete = $categoryId;
        $this->dispatch('show-delete-modal');
    }

    public function deleteCategory()
    {
        if ($this->categoryIdToDelete) {
            $category = Category::find($this->categoryIdToDelete);
            if ($category) {
                $category->delete();
                session()->flash('message', 'Category deleted successfully!');
            }
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::with('subcategories')
            ->where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.category.index', ['categories' => $categories]);
    }
}
