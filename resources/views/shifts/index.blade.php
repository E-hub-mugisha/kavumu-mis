@extends('layouts.app')
@section('title','Staff Shifts')
@section('content')
<div class="container">
    <h4 class="mb-3">Shift Scheduling</h4>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addShiftModal">Add Shift</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shifts as $shift)
            <tr>
                <td>{{ $shift->staff->name }}</td>
                <td>{{ $shift->date }}</td>
                <td>{{ $shift->start_time }}</td>
                <td>{{ $shift->end_time }}</td>
                <td>{{ $shift->status }}</td>
                <td>
                    <form action="{{ route('shifts.update',$shift) }}" method="POST">
                        @csrf @method('PUT')
                        <select name="status" class="form-select d-inline w-auto">
                            <option {{ $shift->status=='Scheduled'?'selected':'' }}>Scheduled</option>
                            <option {{ $shift->status=='Completed'?'selected':'' }}>Completed</option>
                            <option {{ $shift->status=='Missed'?'selected':'' }}>Missed</option>
                        </select>
                        <button class="btn btn-sm btn-success">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $shifts->links() }}
</div>

<!-- Add Shift Modal -->
<div class="modal fade" id="addShiftModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('shifts.store') }}">
            @csrf
            <div class="modal-header">
                <h5>Add Shift</h5>
            </div>
            <div class="modal-body">
                <select name="staff_id" class="form-select mb-2" required>
                    <option value="">Select Staff</option>
                    @foreach($staff as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="date" class="form-control mb-2" required>
                <input type="time" name="start_time" class="form-control mb-2" required>
                <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="modal-footer"><button class="btn btn-primary">Save</button></div>
        </form>
    </div>
</div>
@endsection