<div class="card">
    <div class="card-header">
        <h4 class="card-title">Income Report</h4>
    </div>

    <div class="card-body">

        <canvas id="incomeChart"></canvas>
    </div>


</div>

<script>
    const incomeData = @json([
        'daily' => $dailyIncome,
        'monthly' => $monthlyIncome,
        'yearly' => $yearlyIncome
    ]);

    const ctx = document.getElementById('incomeChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Daily', 'Monthly', 'Yearly'],
            datasets: [{
                label: 'Income',
                data: [incomeData.daily, incomeData.monthly, incomeData.yearly],
                backgroundColor: ['#42a5f5', '#66bb6a', '#ff7043'],
                borderColor: ['#42a5f5', '#66bb6a', '#ff7043'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>