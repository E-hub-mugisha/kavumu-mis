@extends('layouts.app')
@section('title', 'Flight Details: ' . $flight->flight_number)
@section('content')
<div class="container">
    <h2 class="mb-4">Flight Details: {{ $flight->flight_number }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Airline: {{ $flight->airline->name ?? '-' }}</h5>
            <p>
                <strong>Origin:</strong> {{ $flight->origin }} <br>
                <strong>Destination:</strong> {{ $flight->destination }} <br>
                <strong>Departure:</strong> {{ \Carbon\Carbon::parse($flight->departure_time)->format('D, d M Y h:i A') }} <br>
                <strong>Arrival:</strong> {{ \Carbon\Carbon::parse($flight->arrival_time)->format('D, d M Y h:i A') }} <br>
                <strong>Status:</strong> {{ $flight->status }} <br>
                <strong>Gate:</strong> {{ $flight->gate ?? 'Not Assigned' }} <br>
                <strong>Boarding Status:</strong> {{ $flight->boarding_status }}
            </p>
        </div>
    </div>

    <h4>Passengers & Baggage</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Passenger Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Passport #</th>
                <th>Seat Number</th>
                <th>Special Requests</th>
                <th>Baggage Tag(s)</th>
                <th>Baggage Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flight->passengers as $passenger)
            <tr>
                <td>{{ $passenger->name }}</td>
                <td>{{ $passenger->email }}</td>
                <td>{{ $passenger->phone ?? '-' }}</td>
                <td>{{ $passenger->passport_number }}</td>
                <td>{{ $passenger->seat_number ?? '-' }}</td>
                <td>{{ $passenger->special_requests ?? '-' }}</td>
                <td>
                    @foreach($passenger->baggage as $bag)
                        <span class="badge bg-info">{{ $bag->tag_number }}</span>
                    @endforeach
                </td>
                <td>
                    @foreach($passenger->baggage as $bag)
                        <span class="badge bg-secondary">{{ $bag->status }}</span>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('flights.history') }}" class="btn btn-secondary mt-3">Back to Flight History</a>
</div>
@endsection
