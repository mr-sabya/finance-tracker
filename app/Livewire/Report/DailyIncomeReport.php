<?php

namespace App\Livewire\Report;

use DB;
use Livewire\Component;

class DailyIncomeReport extends Component
{
    public $dailyIncomeData = [];

    public function mount()
    {
        $this->loadDailyIncome();
    }

    public function loadDailyIncome()
    {
        // Query to calculate daily income for the authenticated user
        $this->dailyIncomeData = DB::table('incomes')
            ->select(DB::raw('DATE(income_date) as date'), DB::raw('SUM(amount) as total'))
            ->where('user_id', auth()->id()) // Filter by authenticated user
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }
    
    public function render()
    {
        return view('livewire.report.daily-income-report');
    }
}
