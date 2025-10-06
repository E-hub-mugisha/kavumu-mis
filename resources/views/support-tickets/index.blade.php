@extends('layouts.app')
@section('title', 'Support Tickets')
@section('content')

<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Support Tickets</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTicketModal">Add Ticket</button>
    </div>

    {{-- Tickets Table --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Passenger</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->passenger->name ?? 'N/A' }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->type }}</td>
                <td>{{ $ticket->status }}</td>
                <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showTicketModal{{ $ticket->id }}">Show</button>
                        @if(auth()->user()->role !== 'Passenger')
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTicketModal{{ $ticket->id }}">Edit</button>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#respondTicketModal{{ $ticket->id }}">Respond</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTicket({{ $ticket->id }})">Delete</button>
                        @endif
                    </div>
                </td>
            </tr>

            {{-- Show Modal --}}
            <div class="modal fade" id="showTicketModal{{ $ticket->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ticket #{{ $ticket->id }} Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Passenger:</strong> {{ $ticket->passenger->name ?? 'N/A' }}</p>
                            <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
                            <p><strong>Type:</strong> {{ $ticket->type }}</p>
                            <p><strong>Status:</strong> {{ $ticket->status }}</p>
                            <p><strong>Description:</strong> {{ $ticket->description }}</p>

                            <hr>
                            <h6>Responses:</h6>
                            @foreach($ticket->responses as $response)
                            <div class="border p-2 mb-2">
                                <strong>{{ $response->user->name ?? 'Staff' }}:</strong>
                                <p>{{ $response->message }}</p>
                                <small class="text-muted">{{ $response->created_at->format('d M Y H:i') }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editTicketModal{{ $ticket->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('support-tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Ticket #{{ $ticket->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" class="form-control" value="{{ $ticket->subject }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Type</label>
                                    <select name="type" class="form-control" required>
                                        <option value="Complaint" {{ $ticket->type=='Complaint'?'selected':'' }}>Complaint</option>
                                        <option value="Lost Baggage" {{ $ticket->type=='Lost Baggage'?'selected':'' }}>Lost Baggage</option>
                                        <option value="Special Assistance" {{ $ticket->type=='Special Assistance'?'selected':'' }}>Special Assistance</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="Open" {{ $ticket->status=='Open'?'selected':'' }}>Open</option>
                                        <option value="In Progress" {{ $ticket->status=='In Progress'?'selected':'' }}>In Progress</option>
                                        <option value="Resolved" {{ $ticket->status=='Resolved'?'selected':'' }}>Resolved</option>
                                        <option value="Closed" {{ $ticket->status=='Closed'?'selected':'' }}>Closed</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" required>{{ $ticket->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Respond Modal --}}
            <div class="modal fade" id="respondTicketModal{{ $ticket->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('support-tickets.respond', $ticket->id) }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Respond to Ticket #{{ $ticket->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Status (optional)</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- No Change --</option>
                                        <option value="Open">Open</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Send Response</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

{{-- Add Ticket Modal --}}
<div class="modal fade" id="addTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('support-tickets.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- passenger information  -->
                    <div class="mb-3">
                        <label>Passenger</label>
                        <select name="passenger_id" class="form-control" required>
                            @foreach($passengers as $passenger)
                                <option value="{{ $passenger->id }}">{{ $passenger->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control" required>
                            <option value="Complaint">Complaint</option>
                            <option value="Lost Baggage">Lost Baggage</option>
                            <option value="Special Assistance">Special Assistance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Ticket</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert Delete Script --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteTicket(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this ticket!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/support-tickets/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(res => location.reload());
            }
        })
    }
</script>

@endsection