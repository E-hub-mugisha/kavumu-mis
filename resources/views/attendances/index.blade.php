@extends('layouts.app')
@section('title', 'Attendances')
@section('content')
<div class="container">
    <h3 class="mb-3">Attendance Management</h3>

    <!-- Button to open Add Modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">Add Attendance</button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attendances as $att)
            <tr>
                <td>{{ $att->staff->name }}</td>
                <td>{{ $att->date }}</td>
                <td>{{ $att->check_in ?? '-' }}</td>
                <td>{{ $att->check_out ?? '-' }}</td>
                <td><span class="badge bg-info">{{ $att->status }}</span></td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editAttendanceModal{{ $att->id }}">Edit</button>

                    <!-- Delete -->
                    <form action="{{ route('attendances.destroy',$att->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editAttendanceModal{{ $att->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" method="POST" action="{{ route('attendances.update',$att->id) }}">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5>Edit Attendance</h5></div>
                        <div class="modal-body">
                            <select name="status" class="form-control mb-2">
                                @foreach(['Present','Absent','Late','On Leave'] as $s)
                                <option value="{{ $s }}" {{ $att->status==$s?'selected':'' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            <input type="time" name="check_in" value="{{ $att->check_in }}" class="form-control mb-2">
                            <input type="time" name="check_out" value="{{ $att->check_out }}" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>
    {{ $attendances->links() }}
</div>

<!-- Add Attendance Modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('attendances.store') }}">
            @csrf
            <div class="modal-header"><h5>Add Attendance</h5></div>
            <div class="modal-body">
                <select name="staff_id" class="form-control mb-2">
                    @foreach($staffs as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="date" class="form-control mb-2">
                <select name="status" class="form-control">
                    <option>Present</option><option>Absent</option>
                    <option>Late</option><option>On Leave</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
