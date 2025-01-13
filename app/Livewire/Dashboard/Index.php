<?php

namespace App\Livewire\Dashboard;

use App\Models\Expense;
use App\Models\Income;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $totalIncome;
    public $totalExpense;
    public $netBalance;
    public $incomeData = [];
    public $expenseData = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $userId = auth()->id();
        $thisMonth = Carbon::now()->startOfMonth();

        // Calculate total income, expense, and net balance
        $this->totalIncome = Income::where('user_id', $userId)->sum('amount');
        $this->totalExpense = Expense::where('user_id', $userId)->sum('amount');
        $this->netBalance = $this->totalIncome - $this->totalExpense;

        // Group income and expense by day for charts
        $this->incomeData = Income::where('user_id', $userId)
            ->where('income_date', '>=', $thisMonth)
            ->selectRaw('DATE(income_date) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->expenseData = Expense::where('user_id', $userId)
            ->where('expense_date', '>=', $thisMonth)
            ->selectRaw('DATE(expense_date) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }


    public function render()
    {
        $incomes = Income::query()
            ->where('user_id', Auth::id())
            ->orderBy('income_date', 'desc')
            ->take(5)
            ->get();

        $expenses = Expense::query()
            ->where('user_id', Auth::id())
            ->orderBy('expense_date', 'desc')
            ->take(5)
            ->get();

        return view('livewire.dashboard.index', [
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
    }
}
