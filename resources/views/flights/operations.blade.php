@extends('layouts.app')
@section('title', 'Flight Operations')
@section('content')
<div class="container">
    <h2 class="mb-4">Flight Operations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Flight #</th>
                <th>Airline</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Gate</th>
                <th>Boarding Status</th>
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
                <td>{{ $flight->gate ?? 'Not Assigned' }}</td>
                <td>{{ $flight->boarding_status }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="flightActions{{ $flight->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="flightActions{{ $flight->id }}">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#showFlightModal{{ $flight->id }}">Show</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editFlightModal{{ $flight->id }}">Edit</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignGateModal{{ $flight->id }}" data-flight="{{ $flight->id }}" data-gate="{{ $flight->gate }}">Assign Gate</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateBoardingModal{{ $flight->id }}" data-flight="{{ $flight->id }}" data-status="{{ $flight->boarding_status }}">Update Boarding Status</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteFlightModal{{ $flight->id }}">Delete</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>

            <!-- Assign Gate Modal -->
            <div class="modal fade" id="assignGateModal{{ $flight->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('flights.assignGate', $flight->id) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign Gate - {{ $flight->flight_number }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label>Gate Number</label>
                                <input type="text" name="gate" class="form-control" value="{{ $flight->gate }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Assign</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Boarding Status Modal -->
            <div class="modal fade" id="updateBoardingModal{{ $flight->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('flights.updateBoardingStatus', $flight->id) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Boarding Status - {{ $flight->flight_number }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label>Boarding Status</label>
                                <select name="boarding_status" class="form-control">
                                    <option value="Not Boarded" {{ $flight->boarding_status == 'Not Boarded' ? 'selected' : '' }}>Not Boarded</option>
                                    <option value="Boarding" {{ $flight->boarding_status == 'Boarding' ? 'selected' : '' }}>Boarding</option>
                                    <option value="Closed" {{ $flight->boarding_status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>
@endsection
