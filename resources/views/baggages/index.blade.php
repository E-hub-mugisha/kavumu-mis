@extends('layouts.app')
@section('title', 'Baggages')
@section('content')
<div class="container">
    <h1 class="mb-4">Baggage Management</h1>

    <!-- Add Baggage Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBaggageModal">
        Add Baggage
    </button>

    <!-- Baggage Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tag Number</th>
                <th>Passenger</th>
                <th>Flight</th>
                <th>Status</th>
                <th>Weight</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($baggages as $baggage)
            <tr>
                <td>{{ $baggage->id }}</td>
                <td>{{ $baggage->tag_number }}</td>
                <td>{{ $baggage->passenger->name ?? 'N/A' }}</td>
                <td>{{ $baggage->flight->flight_number ?? 'N/A' }}</td>
                <td>{{ $baggage->status }}</td>
                <td>{{ $baggage->weight ?? 'N/A' }}</td>
                <td>{{ $baggage->remarks ?? 'None' }}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showBaggageModal{{ $baggage->id }}">Show</button>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBaggageModal{{ $baggage->id }}">Edit</button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBaggageModal{{ $baggage->id }}">Delete</button>
                </td>
            </tr>

            <!-- Show Modal -->
            <div class="modal fade" id="showBaggageModal{{ $baggage->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Baggage Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Tag Number:</strong> {{ $baggage->tag_number }}</p>
                            <p><strong>Passenger:</strong> {{ $baggage->passenger->name ?? 'N/A' }}</p>
                            <p><strong>Flight:</strong> {{ $baggage->flight->flight_number ?? 'N/A' }}</p>
                            <p><strong>Status:</strong> {{ $baggage->status }}</p>
                            <p><strong>Weight:</strong> {{ $baggage->weight ?? 'N/A' }}</p>
                            <p><strong>Remarks:</strong> {{ $baggage->remarks ?? 'None' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editBaggageModal{{ $baggage->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('baggages.update', $baggage->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Baggage</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Passenger</label>
                                <select name="passenger_id" class="form-control" required>
                                    @foreach($passengers as $passenger)
                                    <option value="{{ $passenger->id }}" @if($baggage->passenger_id==$passenger->id) selected @endif>{{ $passenger->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Flight</label>
                                <select name="flight_id" class="form-control" required>
                                    @foreach($flights as $flight)
                                    <option value="{{ $flight->id }}" @if($baggage->flight_id==$flight->id) selected @endif>{{ $flight->flight_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Tag Number</label>
                                <input type="text" name="tag_number" class="form-control" value="{{ $baggage->tag_number }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    @foreach(['Checked-In','Loaded','In-Transit','Arrived','Lost'] as $status)
                                    <option value="{{ $status }}" @if($baggage->status==$status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Weight</label>
                                <input type="text" name="weight" class="form-control" value="{{ $baggage->weight }}">
                            </div>
                            <div class="mb-3">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control">{{ $baggage->remarks }}</textarea>
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
            <div class="modal fade" id="deleteBaggageModal{{ $baggage->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('baggages.destroy', $baggage->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Baggage</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete baggage <strong>{{ $baggage->tag_number }}</strong>?
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

<!-- Add Baggage Modal -->
<div class="modal fade" id="addBaggageModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('baggages.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Baggage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Passenger</label>
                    <select name="passenger_id" class="form-control" required>
                        @foreach($passengers as $passenger)
                        <option value="{{ $passenger->id }}">{{ $passenger->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Flight</label>
                    <select name="flight_id" class="form-control" required>
                        @foreach($flights as $flight)
                        <option value="{{ $flight->id }}">{{ $flight->flight_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        @foreach(['Checked-In','Loaded','In-Transit','Arrived','Lost'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Remarks</label>
                    <textarea name="remarks" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Add Baggage</button>
            </div>
        </form>
    </div>
</div>

@endsection
