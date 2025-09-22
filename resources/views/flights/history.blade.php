@extends('layouts.app')
@section('title', 'Flight History')
@section('content')
<div class="container">
    <h2 class="mb-4">Flight History</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Flight #</th>
                <th>Airline</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Status</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Passengers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flights as $flight)
            <tr>
                <td>{{ $flight->flight_number }}</td>
                <td>{{ $flight->airline->name ?? '-' }}</td>
                <td>{{ $flight->origin }}</td>
                <td>{{ $flight->destination }}</td>
                <td>{{ $flight->status }}</td>
                <td>{{ $flight->departure_time }}</td>
                <td>{{ $flight->arrival_time }}</td>
                <td>{{ $flight->passengers->count() }}</td>
                <td>
                    <a href="{{ route('flights.history.show', $flight->id) }}" class="btn btn-sm btn-info">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
