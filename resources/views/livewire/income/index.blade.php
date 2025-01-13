<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">{{ $isEditMode ? 'Edit' : 'Add New' }} Income</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'create' }}">
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-medium">Amount</label>
                            <input
                                type="number"
                                id="amount"
                                wire:model="amount"
                                class="form-control"
                                placeholder="Enter amount">
                            @error('amount')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="income_date" class="form-label fw-medium">Income Date</label>
                            <input
                                type="date"
                                id="income_date"
                                wire:model="income_date"
                                class="form-control">
                            @error('income_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resource_id" class="form-label fw-medium">Resource</label>
                            <select id="resource_id" wire:model="resource_id" class="form-select">
                                <option value="">Select Resource</option>
                                @foreach($resources as $resource)
                                <option value="{{ $resource->id }}">
                                    {{ $resource->name }}
                                </option>
                                @foreach($resource->subresources as $child)
                                <option value="{{ $child->id }}">
                                    &nbsp;&nbsp;&nbsp;— {{ $child->name }}
                                </option>
                                @endforeach
                                @endforeach
                            </select>

                            </select>
                            @error('resource_id')
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
                    <h5 class="card-title m-0">Income List</h5>
                </div>
                <div class="card-body">
                    <div class="table-action mb-3">
                        <div class="short">
                            <label for="sort" class="form-label fw-medium">Sort By</label>
                            <div class="fields">
                                <select wire:model="sortField" class="form-select">
                                    <option value="income_date">Income Date</option>
                                    <option value="amount">Amount</option>
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
                                <th class="cursor-pointer" wire:click="sortBy('income_date')">
                                    Income Date
                                    @if($sortField === 'income_date')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th class="cursor-pointer" wire:click="sortBy('amount')">
                                    Amount
                                    @if($sortField === 'amount')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th>Resource</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomes as $income)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $income->income_date }}</td>
                                <td>{{ $income->amount }}</td>
                                <td>{{ $income->resource->name }}</td>
                                <td>
                                    <button wire:click="edit({{ $income->id }})" class="btn btn-primary btn-sm">
                                        <i class="ri-pencil-line"></i> Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $income->id }})" class="btn btn-danger btn-sm">
                                        <i class="ri-delete-bin-line"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No income records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $incomes->links() }}
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
                    Are you sure you want to delete this income record? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteIncome" data-bs-dismiss="modal">Delete</button>
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