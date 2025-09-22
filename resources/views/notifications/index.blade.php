@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="container">
    <h2>Notifications</h2>
    <ul class="list-group">
        @forelse($notifications as $notification)
            <li class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-warning' }}">
                {{ $notification->data['message'] ?? 'No message' }}
                <span class="float-end">
                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button class="btn btn-sm btn-primary">Mark as read</button>
                        </form>
                    @endif
                </span>
            </li>
        @empty
            <li class="list-group-item">No notifications found.</li>
        @endforelse
    </ul>
</div>
@endsection
