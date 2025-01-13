<div>
    <div class="row">

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">{{ $isEditMode ? 'Edit' : 'Add New' }} Category</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'create' }}">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Name</label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="form-control"
                                placeholder="Enter category name">
                            @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label fw-medium">Parent Category</label>
                            <select id="parent_id" wire:model="parent_id" class="form-select">
                                <option value="">None</option>
                                @foreach(App\Models\Category::where('user_id', Auth::id())->whereNull('parent_id')->get() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ $isEditMode ? 'Update' : 'Create' }}
                        </button>
                        <button type="button" wire:click="resetInput" class="btn btn-secondary ms-2">Cancel</button>
                    </form>
                </div>

            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Category List</h5>
                </div>
                <div class="card-body">
                    <div class="table-action">
                        <div class="short">
                            <label for="sort" class="form-label fw-medium">Sort By</label>
                            <div class="fields">
                                <select wire:model="sortField" class="form-select">
                                    <option value="name">Name</option>
                                    <option value="parent_id">Parent</option>
                                </select>
                                <select wire:model="sortDirection" class="form-select">
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="search">
                            <input
                                type="text"
                                wire:model.debounce.300ms="search"
                                class="form-control"
                                placeholder="Search..." />
                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th class="cursor-pointer" wire:click="sortBy('name')">
                                    Name
                                    @if($sortField === 'name')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th class="cursor-pointer" wire:click="sortBy('parent_id')">
                                    Parent
                                    @if($sortField === 'parent_id')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; @endphp
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                                <td>
                                    <button wire:click="edit({{ $category->id }})" class="btn btn-primary btn-sm">
                                        <i class="ri-pencil-line"></i> Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $category->id }})" class="btn btn-danger btn-sm">
                                        <i class="ri-delete-bin-line"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Display Subcategories (children) -->
                            @foreach($category->subcategories as $subcategory)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>&nbsp;&nbsp;&nbsp;— {{ $subcategory->name }}</td>
                                <td>{{ $subcategory->parent ? $subcategory->parent->name : 'None' }}</td>
                                <td>
                                    <button wire:click="edit({{ $subcategory->id }})" class="btn btn-primary btn-sm">
                                        <i class="ri-pencil-line"></i>Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $subcategory->id }})" class="btn btn-danger btn-sm">
                                        <i class="ri-delete-bin-line"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteCategory" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('show-delete-modal', event => {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteModal.show();
    });
</script>