@extends('new_layouts.app')

@section('title', 'Admin dashbored')

@section('content')
    <div class="row row-card-no-pd">
        <div style="font-size: 20px">
            Admin Page
        </div>
    </div>

    


<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-box"></i> <!-- Example icon -->
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Materials</p>
                            <h4 class="card-title">{{ $materialsCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Subscribers</p>
                            <h4 class="card-title">{{ $usersCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Data Tables -->


<!--
<h1>Users Table</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
-->







<!-- Users Activity -->


<html>
<head>
    <title>Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- For AJAX requests -->
</head>
<body>
    <div>
        <label for="period">Select Period:</label>
        <select id="period">
            <option value="1hour">1 Hour</option>
            <option value="1day">1 Day</option>
            <option value="1month">1 Month</option>
            <option value="3months">3 Months</option>
            <option value="1year">1 Year</option>
        </select>
    </div>

    <div id="chart-container">
        <canvas id="LineChart"></canvas>
    </div>

    <script>
        // Initialize Chart.js
        var ctx = document.getElementById('LineChart').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Will be updated dynamically
                datasets: [{
                    label: "Active Users",
                    borderColor: "#1d7af3",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#1d7af3",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: 'transparent',
                    fill: true,
                    borderWidth: 2,
                    data: [] // Will be updated dynamically
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 10,
                        fontColor: '#1d7af3',
                    }
                },
                tooltips: {
                    bodySpacing: 4,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest",
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                layout: {
                    padding: {left: 15, right: 15, top: 15, bottom: 15}
                }
            }
        });

        // Function to update chart data
        function updateChart(period) {
            axios.get('/data', { params: { period: period } })
                .then(response => {
                    const data = response.data;
                    myLineChart.data.labels = data.labels;
                    myLineChart.data.datasets[0].data = data.data;
                    myLineChart.update();
                })
                .catch(error => console.error(error));
        }

        // Event listener for dropdown menu
        document.getElementById('period').addEventListener('change', function () {
            updateChart(this.value);
        });

        // Initial load
        updateChart(document.getElementById('period').value);
    </script>
</body>
</html>




@endsection
