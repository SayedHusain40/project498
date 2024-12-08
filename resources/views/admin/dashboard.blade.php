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
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-download"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total Downloads</p>
                            <h4 class="card-title">{{ $totalDownloads }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div id="chart-container" style="height: 400px; width: 100%; margin: 0 auto;">
    <div class="d-flex align-items-center mb-3">
        <label for="monthFilter" class="form-label mb-0 mr-2">Select Month:</label>
        <select id="monthFilter" class="form-select w-auto" aria-label="Select Month">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12" selected>December</option>
        </select>
    </div>
    <canvas id="multipleLineChart" style="max-width: 100%; max-height: 100%;"></canvas>
</div>




<!-- Display user data in Table -->

<div class="container mt-5">
    <h2>Users List</h2>
    <table class="table table-striped table-hover table-bordered" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <thead style="background-color: #4a90e2; color: white;">
            <tr>
                <th style="border-top-left-radius: 10px; padding: 15px;">Name</th>
                <th style="padding: 15px;">Email</th>
                <th style="padding: 15px;">Role</th>
                <th style="border-top-right-radius: 10px; padding: 15px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="transition: all 0.3s ease;">
                <td style="padding: 15px;">{{ $user->name }}</td>
                <td style="padding: 15px;">{{ $user->email }}</td>
                <td style="padding: 15px;">{{ $user->role }}</td>
                <td style="padding: 15px;">
                    <!-- Edit Button -->
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #f9f9f9;">
            <tr>
                <td colspan="4" class="text-center" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; padding: 15px;">
                    <small class="text-muted">Showing {{ count($users) }} users</small>
                </td>
            </tr>
        </tfoot>
    </table>
</div>









@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('multipleLineChart').getContext('2d');

    let myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Days of the month
            datasets: [
                { label: "Materials", borderColor: "#1d7af3", data: [], fill: false },
                { label: "Items", borderColor: "#59d05d", data: [], fill: false },
                { label: "Study Sessions", borderColor: "#f3545d", data: [], fill: false },
                { label: "Events", borderColor: "#f3a03d", data: [], fill: false }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    function fetchChartData(month) {
        fetch(`/fetch-chart-data?month=${month}`)
            .then(response => response.json())
            .then(data => {
                const labels = Array.from({ length: 31 }, (_, i) => i + 1); // Days of the month
                myChart.data.labels = labels;

                myChart.data.datasets[0].data = labels.map(day => data.materials[day] || 0);
                myChart.data.datasets[1].data = labels.map(day => data.items[day] || 0);
                myChart.data.datasets[2].data = labels.map(day => data.study_sessions[day] || 0);
                myChart.data.datasets[3].data = labels.map(day => data.events[day] || 0);

                myChart.update();
            });
    }

    document.getElementById('monthFilter').addEventListener('change', (e) => {
        const selectedMonth = e.target.value;
        fetchChartData(selectedMonth);
    });

    // Load data for the current month on page load
    fetchChartData(new Date().getMonth() + 1);
</script>
@endsection
