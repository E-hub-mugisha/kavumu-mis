@extends('layouts.app')
@section('title', 'Baggages')
@section('content')
<div class="container">
    <h1 class="mb-4">Baggage Management</h1>


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

            @endforeach
        </tbody>
    </table>
</div>


@endsection
