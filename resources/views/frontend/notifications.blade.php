@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Notifications</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            @if ($notifications->isEmpty())
                <p class="text-center">No notifications available.</p>
            @else
                <ul class="list-group list-group-flush">
                    @foreach ($notifications as $notification)
                        <li class="list-group-item {{ $notification->read_at ? '' : 'bg-light' }}">
                            <a href="{{ $notification->data['action_url'] }}"
                               class="text-decoration-none"
                               onclick="markAsRead('{{ $notification->id }}')">
                                {{ $notification->data['message'] }}
                                <br>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                    @endforeach
                </ul>
                {{ $notifications->links() }}
            @endif
        </div>
    </div>
</div>

<script>
    function markAsRead(notificationId) {
        fetch('/notifications/mark-as-read/' + notificationId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optionally reload the page or update UI
                location.reload();
            }
        });
    }
</script>
@endsection
