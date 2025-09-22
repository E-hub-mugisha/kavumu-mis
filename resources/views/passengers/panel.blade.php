@extends('layouts.app')
@section('title', 'Passenger Panel')
@section('content')

<div class="container">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}</h2>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Upcoming Flights -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">My Upcoming Flights</h5>
        </div>
        <div class="card-body">
            @if($upcomingFlights->count())
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Flight</th>
                            <th>Route</th>
                            <th>Departure</th>
                            <th>Status</th>
                            <th>Seat</th>
                            <th>Check-In</th>
                            <th>Boarding Pass</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingFlights as $passenger)
                            <tr>
                                <td><strong>{{ $passenger->flight->flight_number }}</strong></td>
                                <td>{{ $passenger->flight->origin }} → {{ $passenger->flight->destination }}</td>
                                <td>{{ \Carbon\Carbon::parse($passenger->flight->departure_time)->format('d M Y, H:i') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($passenger->flight->status == 'Scheduled') bg-primary
                                        @elseif($passenger->flight->status == 'Delayed') bg-warning
                                        @elseif($passenger->flight->status == 'Cancelled') bg-danger
                                        @else bg-success @endif">
                                        {{ $passenger->flight->status }}
                                    </span>
                                </td>
                                <td>{{ $passenger->seat_number ?? 'Not Assigned' }}</td>
                                <td>
                                    @if($passenger->status === 'Booked')
                                        <form action="{{ route('passengers.checkin', $passenger->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Check-In</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">{{ $passenger->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($passenger->status !== 'Booked')
                                        <a href="{{ route('passengers.boarding-pass', $passenger->id) }}" 
                                           class="btn btn-sm btn-primary">Download</a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Pending</button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Baggage Details -->
                            @if($passenger->baggage->count())
                                <tr>
                                    <td colspan="7">
                                        <strong>Baggage:</strong>
                                        <ul class="mb-0">
                                            @foreach($passenger->baggage as $bag)
                                                <li>
                                                    Tag: <strong>{{ $bag->tag_number }}</strong>, 
                                                    Status: <span class="badge bg-info">{{ $bag->status }}</span>, 
                                                    Weight: {{ $bag->weight ?? 'N/A' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">You have no upcoming flights.</p>
            @endif
        </div>
    </div>

    <!-- Flight History -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Flight History</h5>
        </div>
        <div class="card-body">
            @if($pastFlights->count())
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Flight</th>
                            <th>Route</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Seat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pastFlights as $p)
                            <tr>
                                <td>{{ $p->flight->flight_number }}</td>
                                <td>{{ $p->flight->origin }} → {{ $p->flight->destination }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->flight->departure_time)->format('d M Y, H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->flight->arrival_time)->format('d M Y, H:i') }}</td>
                                <td>{{ $p->seat_number ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($p->flight->status == 'Completed') bg-success
                                        @else bg-secondary @endif">
                                        {{ $p->flight->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No past flights recorded.</p>
            @endif
        </div>
    </div>
</div>
@endsection
