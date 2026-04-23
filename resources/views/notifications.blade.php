@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="container py-4">
        <div class="d-flex d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center mb-4">
            <h2 class="mb-0 d-flex align-items-center">
                <i class="fas fa-bell me-2" style="color:#fbc926;"></i>
                <span class="fw-bold">Notifications Stock</span>
            </h2>
            <div>
        <form method="POST" action="{{ route('notifications.markAsRead') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline-dark" id="btn-mark-all-read">
                <i class="fas fa-check-circle me-1"></i>Tout marquer comme lu
            </button>
        </form>
    </div>
</div>

    @if(isset($notifications) && count($notifications))
    <ul class="list-group my-4">
        @foreach($notifications as $notif)
        <li class="list-group-item d-flex justify-content-between align-items-start notif-item {{ $notif->vu ? 'd-none' : '' }}">
            <div class="d-flex flex-column flex-grow-1">
                <div class="d-flex align-items-center mb-1">
                    <span class="notif-dot me-2 {{ $notif->type === 'rupture' ? 'dot-danger' : 'dot-warning' }}"></span>
                    <span class="fw-semibold text-dark {{ $notif->vu ? 'text-muted' : '' }}">{{ $notif->message }}</span>
                </div>
                <small class="text-muted">
                    <i class="far fa-clock me-1"></i>
                    {{ optional($notif->created_at)->diffForHumans() ?? $notif->created_at }}
                </small>
            </div>

            <div class="d-flex align-items-center gap-2 ms-3">
                @if(!$notif->vu)
                <form method="POST" action="{{ route('notifications.markAsReadSingle', $notif->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success" title="Marquer comme lu">
                        <i class="fas fa-check"></i>
                    </button>
                </form>
                @endif
            </div>
        </li>
        @endforeach
    </ul>

    @if(method_exists($notifications, 'links'))
    <div class="mt-3">
        {{ $notifications->appends(request()->query())->links() }}
    </div>
    @endif

    @else
    <div class="text-center p-5 border" style="border-radius:8px; background:#FFFFFF;">
        <i class="fas fa-bell-slash mb-3" style="font-size:2rem; color:#fbc926;"></i>
        <div class="text-muted">Aucune notification</div>
    </div>
    @endif
</div>

<style>
    .list-group-item {
        background: #FFFFFF;
    }
    .notif-item {
        position: relative;
        padding-left: 0.75rem;
        border-left: 8px solid transparent !important;
    }
    .notification-read {
        opacity: 0.7;
        background: #f8f9fa !important;
    }
    .notif-item .dot-danger {
        background: #dc3545;
    }
    .notif-item .dot-warning {
        background: #fbc926;
    }
    .notif-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .list-group-item:hover {
        background: rgba(255, 222, 89, 0.10) !important;
    }
    .notification-read:hover {
        background: rgba(248, 249, 250, 0.8) !important;
    }
    .btn-outline-danger, .btn-outline-dark, .btn-outline-success {
        border-width: 2px;
    }
    .pagination .page-link {
        color: #000;
        border-color: #000;
    }
    .pagination .page-item.active .page-link {
        background-color: #fbc926;
        border-color: #000;
        color: #000;
        font-weight: 700;
    }
</style>

@endsection