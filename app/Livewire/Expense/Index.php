<?php

namespace App\Livewire\Expense;

use App\Models\Category;
use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $amount, $expense_date, $description, $category_id, $expense_id;
    public $search = '';
    public $sortField = 'expense_date';
    public $sortDirection = 'desc';
    public $isEditMode = false;

    protected $rules = [
        'amount' => 'required|numeric|min:1',
        'expense_date' => 'required|date',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string|max:255',
    ];

    public function resetInput()
    {
        $this->amount = '';
        $this->expense_date = '';
        $this->description = '';
        $this->category_id = null;
        $this->expense_id = null;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->validate();

        Expense::create([
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'expense_date' => $this->expense_date,
            'category_id' => $this->category_id,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Expense created successfully.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);

        $this->expense_id = $expense->id;
        $this->amount = $expense->amount;
        $this->expense_date = $expense->expense_date;
        $this->description = $expense->description;
        $this->category_id = $expense->category_id;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $expense = Expense::findOrFail($this->expense_id);
        $expense->update([
            'amount' => $this->amount,
            'expense_date' => $this->expense_date,
            'category_id' => $this->category_id,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Expense updated successfully.');
        $this->resetInput();
    }

    public function confirmDelete($id)
    {
        $this->expense_id = $id;
        $this->dispatch('show-delete-modal');
    }

    public function deleteExpense()
    {
        if ($this->expense_id) {
            $expense = Expense::find($this->expense_id);
            if ($expense) {
                $expense->delete();
                session()->flash('message', 'Expense deleted successfully!');
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
        // Fetch categories where parent_id is null (top-level categories) and related subcategories for the authenticated user
        $categories = Category::where('user_id', auth()->id())
            ->whereNull('parent_id')
            ->with('subcategories')
            ->get();

        $expenses = Expense::with('category')
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('amount', 'like', '%' . $this->search . '%')
                    ->orWhere('expense_date', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.expense.index', [
            'expenses' => $expenses,
            'categories' => $categories,  // Pass the categories with subcategories to the view
        ]);
    }
}
