<!-- Header -->
<header class="top-header sticky-top border-bottom bg-awg-primary">
    <div class="container-fluid px-4 th-body">
        <div class="d-flex align-items-center justify-content-between">

            <!-- LEFT SIDE -->
            <div class="d-flex align-items-center gap-3 topbar-content">
                <button id="sidebarToggle" class="btn btn-sm d-flex align-items-center justify-content-center text-white border-0 bg-transparent">
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
                    <div class="topbar-bell" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="notif-badge">5</span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end topbar-notif-menu">
                        <div class="notif-header">
                            <span>Notifications</span>
                            <a href="#" class="notif-mark-read">Mark all as read</a>
                        </div>
                        <div class="notif-list">
                            <a href="{{ route('assessments') }}" class="notif-item unread">
                                <span class="notif-icon"><span class="material-symbols-outlined">event_available</span></span>
                                <div class="flex-1">
                                    <p class="notif-title">New assessment request</p>
                                    <p class="notif-detail">Elena Cruz — CCTV Setup, Mar 19</p>
                                    <p class="notif-time">10 minutes ago</p>
                                </div>
                            </a>
                            <a href="{{ route('quotations') }}" class="notif-item unread">
                                <span class="notif-icon"><span class="material-symbols-outlined">request_quote</span></span>
                                <div class="flex-1">
                                    <p class="notif-title">Quotation approved</p>
                                    <p class="notif-detail">QT-2026-003 — Anna Garcia, ₱850,000.00</p>
                                    <p class="notif-time">1 hour ago</p>
                                </div>
                            </a>
                            <a href="{{ route('projects') }}" class="notif-item unread">
                                <span class="notif-icon"><span class="material-symbols-outlined">folder</span></span>
                                <div class="flex-1">
                                    <p class="notif-title">Project milestone reached</p>
                                    <p class="notif-detail">CCTV Installation — Makati Branch, 65%</p>
                                    <p class="notif-time">3 hours ago</p>
                                </div>
                            </a>
                            <a href="{{ route('tasks') }}" class="notif-item">
                                <span class="notif-icon"><span class="material-symbols-outlined">task_alt</span></span>
                                <div class="flex-1">
                                    <p class="notif-title">Task overdue</p>
                                    <p class="notif-detail">Access Card Programming — due yesterday</p>
                                    <p class="notif-time">1 day ago</p>
                                </div>
                            </a>
                        </div>
                        <a href="#" class="notif-view-all">View all activity</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>