@extends('layouts.app')
@section('title', 'Flights')
@section('content')
<div class="container">
    <h1 class="mb-4">Flights Management</h1>

    <!-- Add Flight Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addFlightModal">
        Add Flight
    </button>

    <!-- Flights Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Flight Number</th>
                <th>Airline</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Seats</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flights as $flight)
            <tr>
                <td>{{ $flight->id }}</td>
                <td>{{ $flight->flight_number }}</td>
                <td>{{ $flight->airline->name }}</td>
                <td>{{ $flight->origin }}</td>
                <td>{{ $flight->destination }}</td>
                <td>{{ $flight->departure_time }}</td>
                <td>{{ $flight->arrival_time }}</td>
                <td>{{ $flight->available_seats }}</td>
                <td>{{ $flight->status }}</td>
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

            <!-- Show Flight Modal -->
            <div class="modal fade" id="showFlightModal{{ $flight->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Flight Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Flight Number:</strong> {{ $flight->flight_number }}</p>
                            <p><strong>Airline:</strong> {{ $flight->airline->name }}</p>
                            <p><strong>Origin:</strong> {{ $flight->origin }}</p>
                            <p><strong>Destination:</strong> {{ $flight->destination }}</p>
                            <p><strong>Departure:</strong> {{ $flight->departure_time }}</p>
                            <p><strong>Arrival:</strong> {{ $flight->arrival_time }}</p>
                            <p><strong>Seats:</strong> {{ $flight->available_seats }}</p>
                            <p><strong>Status:</strong> {{ $flight->status }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Flight Modal -->
            <div class="modal fade" id="editFlightModal{{ $flight->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('flights.update', $flight->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Flight</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Airline</label>
                                <select name="airline_id" class="form-control" required>
                                    @foreach($airlines as $airline)
                                    <option value="{{ $airline->id }}" @if($flight->airline_id==$airline->id) selected @endif>{{ $airline->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Origin</label>
                                <input type="text" name="origin" class="form-control" value="{{ $flight->origin }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Destination</label>
                                <input type="text" name="destination" class="form-control" value="{{ $flight->destination }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Departure Time</label>
                                <input type="datetime-local" name="departure_time" class="form-control" value="{{ \Carbon\Carbon::parse($flight->departure_time)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Arrival Time</label>
                                <input type="datetime-local" name="arrival_time" class="form-control" value="{{ \Carbon\Carbon::parse($flight->arrival_time)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Available Seats</label>
                                <input type="number" name="available_seats" class="form-control" value="{{ $flight->available_seats }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    @foreach(['Scheduled','Delayed','Cancelled','Completed'] as $status)
                                    <option value="{{ $status }}" @if($flight->status==$status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Flight Modal -->
            <div class="modal fade" id="deleteFlightModal{{ $flight->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('flights.destroy', $flight->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Flight</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete flight <strong>{{ $flight->flight_number }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

@foreach($flights as $flight)
<!-- Assign Gate Modal -->
<div class="modal fade" id="assignGateModal{{ $flight->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('flights.assignGate', $flight->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Gate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Gate Number:</label>
                    <input type="text" name="gate" id="gateInput" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
<!-- Update Boarding Status Modal -->
@foreach($flights as $flight)
<div class="modal fade" id="updateBoardingModal{{ $flight->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('flights.updateBoardingStatus', $flight->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Boarding Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Boarding Status:</label>
                    <select name="boarding_status" id="statusSelect" class="form-control">
                        <option value="Not Boarded">Not Boarded</option>
                        <option value="Boarding">Boarding</option>
                        <option value="Closed">Closed</option>
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
<!-- Add Flight Modal -->
<div class="modal fade" id="addFlightModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('flights.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Flight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Airline</label>
                    <select name="airline_id" class="form-control" required>
                        @foreach($airlines as $airline)
                        <option value="{{ $airline->id }}">{{ $airline->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Origin</label>
                    <input type="text" name="origin" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Destination</label>
                    <input type="text" name="destination" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Departure Time</label>
                    <input type="datetime-local" name="departure_time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Arrival Time</label>
                    <input type="datetime-local" name="arrival_time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Available Seats</label>
                    <input type="number" name="available_seats" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        @foreach(['Scheduled','Delayed','Cancelled','Completed'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-muted">Flight Number will be auto-generated.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Add Flight</button>
            </div>
        </form>
    </div>
</div>

@endsection