<div>
    <h1 class="mb-4">Income and Expense Dashboard</h1>

    <!-- KPI Cards -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Income</div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($totalIncome, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Expenses</div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($totalExpense, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Net Balance</div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($netBalance, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Income vs Expense Chart -->
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-5 chat-container">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-5 chat-container">
                <canvas id="expenseChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <!-- Recent Transactions -->
            <h2>Recent Transactions (Income)</h2>
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
                        <td>{{ number_format($income->amount, 2) }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="col-lg-6">
            <!-- Recent Transactions -->
            <h2>Recent Transactions (Expense)</h2>
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