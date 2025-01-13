<div>
    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">{{ $isEditMode ? 'Edit Expense' : 'Add New Expense' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'create' }}">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" wire:model="amount" class="form-control" id="amount" placeholder="Enter amount">
                            @error('amount') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Expense Date</label>
                            <input type="date" wire:model="expense_date" class="form-control" id="expense_date">
                            @error('expense_date') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" wire:model="description" class="form-control" id="description" placeholder="Enter description">
                            @error('description') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select wire:model="category_id" class="form-select" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @foreach($category->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">-- {{ $subcategory->name }}</option>
                                @endforeach
                                @endforeach
                            </select>
                            @error('category_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ $isEditMode ? 'Update' : 'Create' }}
                        </button>
                        <button type="button" wire:click="resetInput" class="btn btn-secondary ms-2">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Expense List Section -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Expense Management</h5>
                </div>
                <div class="card-body">
                    <!-- Search and Sorting -->
                    <div class="table-action">
                        <div class="short">
                            <label for="sort" class="form-label">Sort By</label>
                            <div class="fields">
                                <select wire:model="sortField" class="form-select">
                                    <option value="expense_date">Date</option>
                                    <option value="amount">Amount</option>
                                </select>
                                <select wire:model="sortDirection" class="form-select">
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="search">
                            <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Search..." />
                        </div>
                    </div>

                    <!-- Expense Table -->
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th class="cursor-pointer" wire:click="sortBy('expense_date')">
                                    Expense Date
                                    @if($sortField === 'expense_date')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th class="cursor-pointer" wire:click="sortBy('amount')">
                                    Amount
                                    @if($sortField === 'amount')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $expense->expense_date }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->category ? $expense->category->name : 'N/A' }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>
                                    <button wire:click="edit({{ $expense->id }})" class="btn btn-primary btn-sm">
                                        <i class="ri-pencil-line"></i> Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $expense->id }})" class="btn btn-danger btn-sm">
                                        <i class="ri-delete-bin-line"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No expenses found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $expenses->links() }}
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
                    Are you sure you want to delete this expense? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteExpense" data-bs-dismiss="modal">Delete</button>
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