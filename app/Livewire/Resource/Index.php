<?php

namespace App\Livewire\Resource;

use App\Models\Resource;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $name, $parent_id, $resource_id, $isEditMode = false, $resourceIdToDelete;
    public $search = ''; // For searching
    public $sortField = 'id'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction

    protected $rules = [
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:resources,id',
    ];

    public function resetInput()
    {
        $this->name = '';
        $this->parent_id = null;
        $this->resource_id = null;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->validate();
        Resource::create(['name' => $this->name, 'parent_id' => $this->parent_id]);
        session()->flash('message', 'Resource created successfully.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        $this->resource_id = $resource->id;
        $this->name = $resource->name;
        $this->parent_id = $resource->parent_id;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();
        $resource = Resource::findOrFail($this->resource_id);
        $resource->update(['name' => $this->name, 'parent_id' => $this->parent_id]);
        session()->flash('message', 'Resource updated successfully.');
        $this->resetInput();
    }

    // To trigger the modal and confirm deletion
    public function confirmDelete($resourceId)
    {
        $this->resourceIdToDelete = $resourceId;
        $this->dispatch('show-delete-modal');
    }

    // To handle deletion
    public function deleteResource()
    {
        if ($this->resourceIdToDelete) {
            $resource = Resource::find($this->resourceIdToDelete);
            if ($resource) {
                $resource->delete();
                session()->flash('message', 'Resource deleted successfully!');
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
        $resources = Resource::with('parent')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.resource.index', ['resources' => $resources]);
    }
}
