@extends('layouts.app')
@section('title', 'Passengers')
@section('content')
<div class="container">
    <h1 class="mb-4">Passengers Management</h1>

    <!-- Add Passenger Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPassengerModal">
        Add Passenger
    </button>

    <!-- Passengers Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Passport No</th>
                <th>Seat</th>
                <th>Flight</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($passengers as $passenger)
            <tr>
                <td>{{ $passenger->id }}</td>
                <td>{{ $passenger->name }}</td>
                <td>{{ $passenger->email }}</td>
                <td>{{ $passenger->phone }}</td>
                <td>{{ $passenger->passport_number }}</td>
                <td>{{ $passenger->seat_number }}</td>
                <td>{{ $passenger->flight->flight_number ?? 'N/A' }}</td>
                <td>{{ $passenger->status }}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showPassengerModal{{ $passenger->id }}">Show</button>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPassengerModal{{ $passenger->id }}">Edit</button>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#checkinModal{{ $passenger->id }}">
                        Check-in
                    </button>
                    <a href="{{ route('passengers.boarding-pass', $passenger->id) }}" target="_blank" class="btn btn-primary btn-sm">
                        Boarding Pass
                    </a>

                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePassengerModal{{ $passenger->id }}">Delete</button>
                </td>
            </tr>

            <!-- Show Modal -->
            <div class="modal fade" id="showPassengerModal{{ $passenger->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Passenger Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Name:</strong> {{ $passenger->name }}</p>
                            <p><strong>Email:</strong> {{ $passenger->email }}</p>
                            <p><strong>Phone:</strong> {{ $passenger->phone }}</p>
                            <p><strong>Passport Number:</strong> {{ $passenger->passport_number }}</p>
                            <p><strong>Seat Number:</strong> {{ $passenger->seat_number }}</p>
                            <p><strong>Flight:</strong> {{ $passenger->flight->flight_number ?? 'N/A' }}</p>
                            <p><strong>Status:</strong> {{ $passenger->status }}</p>
                            <p><strong>Special Requests:</strong> {{ $passenger->special_requests ?? 'None' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editPassengerModal{{ $passenger->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('passengers.update', $passenger->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Passenger</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Flight</label>
                                <select name="flight_id" class="form-control" required>
                                    @foreach($flights as $flight)
                                    <option value="{{ $flight->id }}" @if($passenger->flight_id==$flight->id) selected @endif>{{ $flight->flight_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $passenger->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $passenger->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $passenger->phone }}">
                            </div>
                            <div class="mb-3">
                                <label>Passport Number</label>
                                <input type="text" name="passport_number" class="form-control" value="{{ $passenger->passport_number }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Seat Number</label>
                                <input type="text" name="seat_number" class="form-control" value="{{ $passenger->seat_number }}">
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    @foreach(['Booked','Checked-in','Boarded','Cancelled'] as $status)
                                    <option value="{{ $status }}" @if($passenger->status==$status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Special Requests</label>
                                <textarea name="special_requests" class="form-control">{{ $passenger->special_requests }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deletePassengerModal{{ $passenger->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('passengers.destroy', $passenger->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Passenger</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete <strong>{{ $passenger->name }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="checkinModal{{ $passenger->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('passengers.checkin', $passenger->id) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Check-in {{ $passenger->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to check-in this passenger?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Check-in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Passenger Modal -->
<div class="modal fade" id="addPassengerModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('passengers.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Passenger</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Flight</label>
                    <select name="flight_id" class="form-control" required>
                        @foreach($flights as $flight)
                        <option value="{{ $flight->id }}">{{ $flight->flight_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Passport Number</label>
                    <input type="text" name="passport_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Seat Number</label>
                    <input type="text" name="seat_number" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        @foreach(['Booked','Checked-in','Boarded','Cancelled'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Special Requests</label>
                    <textarea name="special_requests" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Add Passenger</button>
            </div>
        </form>
    </div>
</div>

@endsection