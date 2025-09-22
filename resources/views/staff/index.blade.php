@extends('layouts.app')
@section('title', 'Staff')
@section('content')
<div class="container">
    <h1 class="mb-4">Staff Management</h1>

    <!-- Add Staff Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStaffModal">
        Add Staff
    </button>

    <!-- Staff Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Department</th>
                <th>Hire Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)
            <tr>
                <td>{{ $staff->id }}</td>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->phone ?? '-' }}</td>
                <td>{{ $staff->position }}</td>
                <td>{{ $staff->department ?? '-' }}</td>
                <td>{{ $staff->hire_date ?? '-' }}</td>
                <td>{{ $staff->status }}</td>
                <td>
                    <!-- Show Button -->
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showStaffModal{{ $staff->id }}">Show</button>

                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $staff->id }}">Edit</button>

                    <!-- Delete Button -->
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal{{ $staff->id }}">Delete</button>
                </td>
            </tr>

            <!-- Show Staff Modal -->
            <div class="modal fade" id="showStaffModal{{ $staff->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Staff Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Name:</strong> {{ $staff->name }}</p>
                            <p><strong>Email:</strong> {{ $staff->email }}</p>
                            <p><strong>Phone:</strong> {{ $staff->phone ?? '-' }}</p>
                            <p><strong>Position:</strong> {{ $staff->position }}</p>
                            <p><strong>Department:</strong> {{ $staff->department ?? '-' }}</p>
                            <p><strong>Hire Date:</strong> {{ $staff->hire_date ?? '-' }}</p>
                            <p><strong>Status:</strong> {{ $staff->status }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Staff Modal -->
            <div class="modal fade" id="editStaffModal{{ $staff->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('staff.update', $staff->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $staff->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $staff->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $staff->phone }}">
                            </div>
                            <div class="mb-3">
                                <label>Position</label>
                                <input type="text" name="position" class="form-control" value="{{ $staff->position }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Department</label>
                                <input type="text" name="department" class="form-control" value="{{ $staff->department }}">
                            </div>
                            <div class="mb-3">
                                <label>Hire Date</label>
                                <input type="date" name="hire_date" class="form-control" value="{{ $staff->hire_date }}">
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" {{ $staff->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $staff->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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

            <!-- Delete Staff Modal -->
            <div class="modal fade" id="deleteStaffModal{{ $staff->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete <strong>{{ $staff->name }}</strong>?
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

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('staff.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
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
                    <label>Position</label>
                    <input type="text" name="position" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Department</label>
                    <input type="text" name="department" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Hire Date</label>
                    <input type="date" name="hire_date" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Add Staff</button>
            </div>
        </form>
    </div>
</div>

@endsection
