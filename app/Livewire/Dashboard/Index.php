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

    public $dailyIncome;
    public $dailyExpense;
    public $dailyBalance;

    public $monthlyIncome;
    public $monthlyExpense;
    public $monthlyBalance;

    public $yearlyIncome;
    public $yearlyExpense;
    public $yearlyBalance;

    public $incomeData = [];
    public $expenseData = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $userId = auth()->id();
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // **Daily**
        $this->dailyIncome = Income::where('user_id', $userId)->whereDate('income_date', $today)->sum('amount');
        $this->dailyExpense = Expense::where('user_id', $userId)->whereDate('expense_date', $today)->sum('amount');
        $this->dailyBalance = $this->dailyIncome - $this->dailyExpense;

        // **Monthly**
        $this->monthlyIncome = Income::where('user_id', $userId)
            ->whereBetween('income_date', [$thisMonth, Carbon::now()])
            ->sum('amount');

        $this->monthlyExpense = Expense::where('user_id', $userId)
            ->whereBetween('expense_date', [$thisMonth, Carbon::now()])
            ->sum('amount');

        $this->monthlyBalance = $this->monthlyIncome - $this->monthlyExpense;

        // **Yearly**
        $this->yearlyIncome = Income::where('user_id', $userId)
            ->whereYear('income_date', Carbon::now()->year)
            ->sum('amount');

        $this->yearlyExpense = Expense::where('user_id', $userId)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');

        $this->yearlyBalance = $this->yearlyIncome - $this->yearlyExpense;

        // **Total**
        $this->totalIncome = Income::where('user_id', $userId)->sum('amount');
        $this->totalExpense = Expense::where('user_id', $userId)->sum('amount');
        $this->netBalance = $this->totalIncome - $this->totalExpense;

        // Data for charts (income and expense grouped by day)
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
            'dailyIncome' => $this->dailyIncome,
            'dailyExpense' => $this->dailyExpense,
            'dailyBalance' => $this->dailyBalance,

            'monthlyIncome' => $this->monthlyIncome,
            'monthlyExpense' => $this->monthlyExpense,
            'monthlyBalance' => $this->monthlyBalance,

            'yearlyIncome' => $this->yearlyIncome,
            'yearlyExpense' => $this->yearlyExpense,
            'yearlyBalance' => $this->yearlyBalance,

            'totalIncome' => $this->totalIncome,
            'totalExpense' => $this->totalExpense,
            'netBalance' => $this->netBalance,

            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
    }
}
