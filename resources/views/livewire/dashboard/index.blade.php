<div>
    <h1 class="mb-4">Income and Expense Dashboard</h1>

    <!-- KPI Cards -->
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">
                    <h4 class="m-0">Total Income</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($totalIncome, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">
                    <h4 class="m-0">Total Expenses</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($totalExpense, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">
                    <h4 class="m-0">Net Balance</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($netBalance, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Periodic Summaries -->
    <div class="row mb-3">
        <!-- Daily Summary -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">Daily Summary</h4>
                </div>
                <div class="card-body">
                    <p><strong>Income:</strong> ${{ number_format($dailyIncome, 2) }}</p>
                    <p><strong>Expense: </strong> ${{ number_format($dailyExpense, 2) }}</p>
                    <p><strong>Balance: </strong> ${{ number_format($dailyBalance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Monthly Summary -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">Monthly Summary</h4>
                </div>
                <div class="card-body">
                    <p><strong>Income: </strong> ${{ number_format($monthlyIncome, 2) }}</p>
                    <p><strong>Expense: </strong> ${{ number_format($monthlyExpense, 2) }}</p>
                    <p><strong>Balance: </strong> ${{ number_format($monthlyBalance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Yearly Summary -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">Yearly Summary</h4>
                </div>
                <div class="card-body">
                    <p><strong>Income: </strong> ${{ number_format($yearlyIncome, 2) }}</p>
                    <p><strong>Expense: </strong> ${{ number_format($yearlyExpense, 2) }}</p>
                    <p><strong>Balance: </strong> ${{ number_format($yearlyBalance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Summary -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">Total Summary</h4>
                </div>
                <div class="card-body">
                    <p><strong>Income:</strong> ${{ number_format($totalIncome, 2) }}</p>
                    <p><strong>Expense:</strong> ${{ number_format($totalExpense, 2) }}</p>
                    <p><strong>Balance:</strong> ${{ number_format($netBalance, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Income vs Expense Chart -->
    <div class="row mb-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="chat-container">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="chat-container">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="m-0">Recent Transactions (Income)</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Resource</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomes as $income)
                            <tr>
                                <td>{{ $income->income_date }}</td>
                                <td>{{ $income->resource['name'] }}</td>
                                <td>${{ number_format($income->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="m-0">Recent Transactions (Expense)</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->expense_date }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->category['name'] }}</td>
                                <td>${{ number_format($expense->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', function() {
        const incomeData = @json($incomeData);
        const expenseData = @json($expenseData);

        // Process income data
        const incomeLabels = incomeData.map(item => item.date);
        const incomeValues = incomeData.map(item => item.total);

        // Process expense data
        const expenseLabels = expenseData.map(item => item.date);
        const expenseValues = expenseData.map(item => item.total);

        // Create income chart
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: incomeLabels,
                datasets: [{
                    label: 'Income',
                    data: incomeValues,
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 128, 0, 0.1)',
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            },
        });

        // Create expense chart
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        new Chart(expenseCtx, {
            type: 'bar',
            data: {
                labels: expenseLabels,
                datasets: [{
                    label: 'Expenses',
                    data: expenseValues,
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 0, 0, 0.1)',
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            },
        });
    });
</script>