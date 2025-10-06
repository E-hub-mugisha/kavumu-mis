@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')

<div class="container">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Key Metrics -->
    <div class="row mb-4">
        <!-- Total Flights -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Total Flights</h5>
                    <h3>{{ $totalFlights }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Passengers -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5>Total Passengers</h5>
                    <h3>{{ $totalPassengers }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Baggage -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5>Total Baggage</h5>
                    <h3>{{ $totalBaggage }}</h3>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h3>${{ number_format($totalRevenue,2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Occupancy -->
    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                <h5>Average Flight Occupancy</h5>
                <p>{{ number_format($averageOccupancy,2) }}%</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Flight Status Chart -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5>Flight Status</h5>
                    <canvas id="flightStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Baggage Status Chart -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5>Baggage Status</h5>
                    <canvas id="baggageStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Frequent Routes Chart -->
    <div class="mb-4">
        <div class="card">
            <div class="card-body">
                <h5>Top 5 Frequent Routes</h5>
                <canvas id="frequentRoutesChart" height="150"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Include Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Flight Status Doughnut Chart
    const flightStatusCtx = document.getElementById('flightStatusChart').getContext('2d');
    const flightStatusChart = new Chart(flightStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Scheduled', 'Delayed', 'Cancelled', 'Completed'],
            datasets: [{
                label: 'Flights',
                data: [{{ $scheduledFlights }}, {{ $delayedFlights }}, {{ $cancelledFlights }}, {{ $completedFlights }}],
                backgroundColor: ['#3490dc','#f6ad55','#e3342f','#38c172'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Frequent Routes Horizontal Bar Chart
    const frequentRoutesCtx = document.getElementById('frequentRoutesChart').getContext('2d');
    const frequentRoutesChart = new Chart(frequentRoutesCtx, {
        type: 'bar',
        data: {
            labels: [@foreach($frequentRoutes as $route) '{{ $route->origin }}→{{ $route->destination }}', @endforeach],
            datasets: [{
                label: 'Passengers',
                data: [@foreach($frequentRoutes as $route) {{ $route->count }}, @endforeach],
                backgroundColor: '#6c757d'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true } }
        }
    });

    // Baggage Status Pie Chart
    const baggageStatusCtx = document.getElementById('baggageStatusChart').getContext('2d');
    const baggageStatusChart = new Chart(baggageStatusCtx, {
        type: 'pie',
        data: {
            labels: ['Lost', 'In-Transit', 'Arrived'],
            datasets: [{
                label: 'Baggage Status',
                data: [{{ $lostBaggage }}, {{ $inTransitBaggage }}, {{ $arrivedBaggage }}],
                backgroundColor: ['#e3342f','#f6ad55','#38c172'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

@endsection
