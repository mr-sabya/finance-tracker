<?php

namespace App\Livewire\Report;

use App\Models\Income;
use Carbon\Carbon;
use Livewire\Component;

class IncomeReport extends Component
{
    public $userId;
    public $dailyIncome;
    public $monthlyIncome;
    public $yearlyIncome;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->fetchReports();
    }

    public function fetchReports()
    {
        // Daily Income
        $this->dailyIncome = Income::where('user_id', $this->userId)
            ->whereDate('income_date', today())
            ->sum('amount');

        // Monthly Income
        $this->monthlyIncome = Income::where('user_id', $this->userId)
            ->whereMonth('income_date', Carbon::now()->month)
            ->sum('amount');

        // Yearly Income
        $this->yearlyIncome = Income::where('user_id', $this->userId)
            ->whereYear('income_date', Carbon::now()->year)
            ->sum('amount');
    }
    
    public function render()
    {
        return view('livewire.report.income-report');
    }
}
