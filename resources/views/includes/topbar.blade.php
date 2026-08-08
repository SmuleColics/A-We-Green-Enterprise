<!-- Header -->
<header class="top-header sticky-top border-bottom bg-awg-primary">
    <div class="container-fluid px-4 th-body">
        <div class="d-flex align-items-center justify-content-between">

            <!-- LEFT SIDE -->
            <div class="d-flex align-items-center gap-3 topbar-content">
                <button id="sidebarToggle"
                    class="btn btn-sm d-flex align-items-center justify-content-center text-white border-0 bg-transparent">
                    <span class="material-symbols-outlined fs-5">menu</span>
                </button>
                <div>
                    <h1 class="text-white mb-0 h4 fw-semibold">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-white text-opacity-75 mb-0 small">March 15, 2026</p>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="d-flex align-items-center gap-2">

                @yield('topbar-actions')

                <!-- Notifications (global — same on every admin page, always rightmost) -->
                <div class="dropdown">
                    <div class="topbar-bell" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        title="Notifications">
                        <span class="material-symbols-outlined">notifications</span>
                        @if (($unreadCount ?? 0) > 0)
                            <span class="notif-badge">{{ $unreadCount }}</span>
                        @endif
                    </div>
                    <div class="dropdown-menu dropdown-menu-end topbar-notif-menu">
                        <div class="notif-header">
                            <span>Notifications</span>
                            <a href="#" id="notif-mark-all-read" class="notif-mark-read">Mark all as read</a>
                        </div>
                        <div class="notif-list">
                            @forelse(($notifications ?? []) as $notif)
                                <a href="#" class="notif-item {{ $notif->is_read ? '' : 'unread' }}">
                                    <span class="notif-icon"><span class="material-symbols-outlined">
                                            @switch($notif->module)
                                                @case('Assessment')
                                                    event_available
                                                @break

                                                @case('Quotation')
                                                    request_quote
                                                @break

                                                @case('Project')
                                                    folder
                                                @break

                                                @default
                                                    inbox
                                            @endswitch
                                        </span></span>
                                    <div class="flex-1">
                                        <p class="notif-title">{{ $notif->title }}</p>
                                        <p class="notif-detail">{{ $notif->message }}</p>
                                        <p class="notif-time">{{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                                @empty
                                    <div class="text-center text-muted small py-3">No notifications yet.</div>
                                @endforelse
                            </div>
                            <a href="{{ route('admin-activity-logs') }}" class="notif-view-all">View all activity</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>
