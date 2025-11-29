@extends($layout)

@section('title', 'Mis Notificaciones')

@section('content')
<div class="content-header">
    <h1>Mis Notificaciones</h1>
</div>

<div class="content">
    <div class="notifications-list">
        @forelse($notifications as $notification)
            <div class="notification-card {{ $notification->status == 'read' ? 'read' : 'unread' }}">
                <div class="notification-content">
                    <h4>{{ $notification->title }}</h4>
                    <p>{{ $notification->message }}</p>
                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <div class="notification-actions">
                    @if($notification->status == 'pending')
                        <button class="btn-mark-read" onclick="markAsRead({{ $notification->id }})">Marcar como leída</button>
                    @else
                        <span class="status-read"><i class="fas fa-check"></i> Leída</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="no-notifications">
                <p>No tienes notificaciones.</p>
            </div>
        @endforelse

        {{ $notifications->links() }}
    </div>
</div>

<style>
    .notifications-list {
        padding: 20px;
    }
    .notification-card {
        background: white;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid #ccc;
    }
    .notification-card.unread {
        border-left: 4px solid #3498db;
        background: #f8f9fa;
    }
    .notification-card.read {
        opacity: 0.8;
        border-left: 4px solid #2ecc71;
    }
    .notification-content h4 {
        margin: 0 0 5px 0;
        color: #333;
    }
    .notification-content p {
        margin: 0 0 5px 0;
        color: #666;
    }
    .notification-content small {
        color: #999;
    }
    .btn-mark-read {
        background: #3498db;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-mark-read:hover {
        background: #2980b9;
    }
    .status-read {
        color: #2ecc71;
        font-weight: bold;
    }
    .no-notifications {
        text-align: center;
        padding: 40px;
        color: #666;
    }
</style>

<script>
    function markAsRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al marcar como leída');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
