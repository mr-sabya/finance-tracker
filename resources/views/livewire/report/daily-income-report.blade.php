<div>
    <h1>Daily Income Report</h1>

    <!-- Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Income</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyIncomeData as $income)
                <tr>
                    <td>{{ $income->date }}</td>
                    <td>{{ number_format($income->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Chart -->
    <canvas id="dailyIncomeChart" width="400" height="200"></canvas>

    <script>
        document.addEventListener('livewire:init', function () {
            const dailyIncomeData = @json($dailyIncomeData);

            const labels = dailyIncomeData.map(item => item.date);
            const data = dailyIncomeData.map(item => item.total);

            const ctx = document.getElementById('dailyIncomeChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Income',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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
        });
    </script>
</div>
