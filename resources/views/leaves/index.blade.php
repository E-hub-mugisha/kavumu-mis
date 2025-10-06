@extends('layouts.app')

@section('title', 'Leave')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Leave request</h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLeaveModal">
            <i class="mdi mdi-plus"></i> Add Leave
        </button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff</th>
                        <th>Leave RequestType</th>
                        <th>Dates</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $leave)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $leave->staff->name ?? 'N/A' }}</td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ $leave->start_date }} → {{ $leave->end_date }}</td>
                        <td>{{ Str::limit($leave->reason, 40) }}</td>
                        <td>
                            <span class="badge 
                                    @if($leave->status == 'Approved') bg-success
                                    @elseif($leave->status == 'Rejected') bg-danger
                                    @else bg-warning text-dark
                                    @endif">
                                {{ $leave->status }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#showLeaveModal{{ $leave->id }}">Show</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editLeaveModal{{ $leave->id }}">Edit</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteLeaveModal{{ $leave->id }}">Delete</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    {{-- Show Modal --}}
                    <div class="modal fade" id="showLeaveModal{{ $leave->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title">Leave RequestDetails</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Staff:</strong> {{ $leave->staff->name ?? 'N/A' }}</p>
                                    <p><strong>Leave RequestType:</strong> {{ $leave->leave_type }}</p>
                                    <p><strong>Start Date:</strong> {{ $leave->start_date }}</p>
                                    <p><strong>End Date:</strong> {{ $leave->end_date }}</p>
                                    <p><strong>Reason:</strong> {{ $leave->reason }}</p>
                                    <p><strong>Status:</strong> {{ $leave->status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editLeaveModal{{ $leave->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title">Edit Leave</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('leave-requests.update', $leave->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="leave_type" class="form-label">Leave RequestType</label>
                                            <select name="leave_type" id="leave_type" class="form-control" required>
                                                @php
                                                $types = ['Annual','Sick','Casual','Maternity','Paternity','Bereavement','Unpaid','Study','Compensatory'];
                                                @endphp
                                                @foreach($types as $type)
                                                <option value="{{ $type }}" {{ $leave->leave_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Start Date</label>
                                            <input type="date" name="start_date" value="{{ $leave->start_date }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>End Date</label>
                                            <input type="date" name="end_date" value="{{ $leave->end_date }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Reason</label>
                                            <textarea name="reason" class="form-control" required>{{ $leave->reason }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="Pending" {{ $leave->status=='Pending'?'selected':'' }}>Pending</option>
                                                <option value="Approved" {{ $leave->status=='Approved'?'selected':'' }}>Approved</option>
                                                <option value="Rejected" {{ $leave->status=='Rejected'?'selected':'' }}>Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div class="modal fade" id="deleteLeaveModal{{ $leave->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Delete Leave</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('leave-requests.destroy', $leave->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <div class="modal-body">
                                        Are you sure you want to delete this Leave Requestrequest?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No Leave Requestfound.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $leaveRequests->links() }}
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addLeaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Leave RequestRequest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('leave-requests.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Staff</label>
                        <select name="staff_id" class="form-control" required>
                            <option value="">-- Select Staff --</option>
                            @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="leave_type" class="form-label">Leave RequestType</label>
                        <select name="leave_type" id="leave_type" class="form-control" required>
                            <option value="Annual">Annual</option>
                            <option value="Sick">Sick</option>
                            <option value="Casual">Casual</option>
                            <option value="Maternity">Maternity</option>
                            <option value="Paternity">Paternity</option>
                            <option value="Bereavement">Bereavement</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Study">Study</option>
                            <option value="Compensatory">Compensatory</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Reason</label>
                        <textarea name="reason" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection