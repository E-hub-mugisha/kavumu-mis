@extends('layouts.app')
@section('title', 'Airlines')
@section('content')
<div class="container">
    <h1 class="mb-4">Airlines Management</h1>

    <!-- Add Airline Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAirlineModal">
        Add Airline
    </button>

    <!-- Airlines Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Country</th>
                <th>Contact Email</th>
                <th>Contact Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($airlines as $airline)
            <tr>
                <td>{{ $airline->id }}</td>
                <td>{{ $airline->name }}</td>
                <td>{{ $airline->code }}</td>
                <td>{{ $airline->country ?? '-' }}</td>
                <td>{{ $airline->contact_email ?? '-' }}</td>
                <td>{{ $airline->contact_phone ?? '-' }}</td>
                <td>
                    <!-- Show Button -->
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showAirlineModal{{ $airline->id }}">Show</button>

                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAirlineModal{{ $airline->id }}">Edit</button>

                    <!-- Delete Button -->
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAirlineModal{{ $airline->id }}">Delete</button>
                </td>
            </tr>

            <!-- Show Airline Modal -->
            <div class="modal fade" id="showAirlineModal{{ $airline->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Airline Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Name:</strong> {{ $airline->name }}</p>
                            <p><strong>Code:</strong> {{ $airline->code }}</p>
                            <p><strong>Country:</strong> {{ $airline->country ?? '-' }}</p>
                            <p><strong>Contact Email:</strong> {{ $airline->contact_email ?? '-' }}</p>
                            <p><strong>Contact Phone:</strong> {{ $airline->contact_phone ?? '-' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            @endforeach
        </tbody>
    </table>
</div>

@foreach($airlines as $airline)
<!-- Edit Airline Modal -->
<div class="modal fade" id="editAirlineModal{{ $airline->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('airlines.update', $airline->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Airline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $airline->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" value="{{ $airline->code }}" required>
                </div>
                <div class="mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="{{ $airline->country }}">
                </div>
                <div class="mb-3">
                    <label>Contact Email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ $airline->contact_email }}">
                </div>
                <div class="mb-3">
                    <label>Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ $airline->contact_phone }}">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@foreach($airlines as $airline)
<!-- Delete Airline Modal -->
<div class="modal fade" id="deleteAirlineModal{{ $airline->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('airlines.destroy', $airline->id) }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">Delete Airline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $airline->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>
@endforeach
<!-- Add Airline Modal -->
<div class="modal fade" id="addAirlineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('airlines.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Airline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Contact Email</label>
                    <input type="email" name="contact_email" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Add Airline</button>
            </div>
        </form>
    </div>
</div>

@endsection