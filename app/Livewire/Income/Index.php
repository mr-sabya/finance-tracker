<?php

namespace App\Livewire\Income;

use App\Models\Income;
use App\Models\Resource;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $amount, $income_date, $resource_id, $incomeId;
    public $isEditMode = false;
    public $search = '';
    public $sortField = 'income_date';
    public $sortDirection = 'desc';

    protected $rules = [
        'amount' => 'required|numeric',
        'income_date' => 'required|date',
        'resource_id' => 'required|exists:resources,id',
    ];

    public function render()
    {
        $incomes = Income::query()
            ->when($this->search, function ($query) {
                $query->where('amount', 'like', '%' . $this->search . '%')
                    ->orWhere('income_date', 'like', '%' . $this->search . '%');
            })
            ->where('user_id', Auth::id())
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        $resources = Resource::with('subresources')
            ->where('parent_id', null)
            ->where('user_id', Auth::id())
            ->get();

        return view('livewire.income.index', [
            'incomes' => $incomes,
            'resources' => $resources,
        ]);
    }

    public function create()
    {
        $this->validate();

        Income::create([
            'amount' => $this->amount,
            'income_date' => $this->income_date,
            'user_id' => Auth::id(), // Set the user_id to authenticated user
            'resource_id' => $this->resource_id,
        ]);

        session()->flash('message', 'Income created successfully.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $income = Income::find($id);
        $this->incomeId = $income->id;
        $this->amount = $income->amount;
        $this->income_date = $income->income_date;
        $this->resource_id = $income->resource_id;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $income = Income::find($this->incomeId);
        $income->update([
            'amount' => $this->amount,
            'income_date' => $this->income_date,
            'resource_id' => $this->resource_id,
        ]);

        session()->flash('message', 'Income updated successfully.');
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->amount = '';
        $this->income_date = '';
        $this->resource_id = '';
        $this->isEditMode = false;
    }

    public function confirmDelete($id)
    {
        $this->incomeId = $id;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteIncome()
    {
        $income = Income::find($this->incomeId);
        $income->delete();

        session()->flash('message', 'Income deleted successfully.');
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
}
