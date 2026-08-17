<!-- ============================================================
     CLIENT NAV (logo + nav links + profile menu — no sidebar)
     ============================================================ -->
<nav class="client-topnav">
    <a class="topnav-brand" href="#">
        <div><img class="w-40" src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt=""></div>
        <div class="topnav-brand-text">
            <span>A We Green Enterprise</span>
            <small>Client Portal</small>
        </div>
    </a>

    <div class="topnav-links">
        <a href="{{ route('portal') }}" class="@if (Request::routeIs('portal')) active @endif">
            <span class="material-symbols-outlined">account_circle</span> Client Portal
        </a>
        <a href="{{ route('client-assessment') }}" class="@if (Request::routeIs('client-assessment*')) active @endif">
            <span class="material-symbols-outlined">calendar_month</span> Assessment
        </a>
        <a href="{{ route('client-quotation') }}" class="@if (Request::routeIs('client-quotation*') || Request::routeIs('quotation-view')) active @endif">
            <span class="material-symbols-outlined">receipt_long</span> Quotations
        </a>
        <a href="{{ route('client-project') }}" class="@if (Request::routeIs('client-project')) active @endif">
            <span class="material-symbols-outlined">folder_open</span> Projects
        </a>
    </div>

    <div class="topnav-right">
        <span class="topnav-name">{{ auth()->user()->full_name }}</span>

        <!-- Notifications -->
        <div class="dropdown">
            <div class="topnav-bell" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                title="Notifications">
                <span class="material-symbols-outlined">notifications</span>
                @if (($unreadCount ?? 0) > 0)
                    <span class="notif-badge">{{ $unreadCount }}</span>
                @endif
            </div>
            <div class="dropdown-menu dropdown-menu-end topnav-notif-menu">
                <div class="notif-header">
                    <span>Notifications</span>
                    <a href="#" class="notif-mark-read js-mark-all-read"
                        data-url="{{ route('notifications.read-all') }}">Mark all as read</a>
                </div>
                <div class="notif-list">
                    @forelse (($notifications ?? []) as $notif)
                        @php
                            $notifHref = route('client-notifications');

                            if ($notif->module === 'Assessment') {
                                $sub = 'active';
                                if (
                                    $notif->notifiable &&
                                    in_array($notif->notifiable->status, ['Declined', 'Cancelled'])
                                ) {
                                    $sub = 'history';
                                }
                                $notifHref = route('client-assessment', ['tab' => 'history', 'sub' => $sub]);
                            } elseif ($notif->module === 'Quotation') {
                                $notifHref = route('client-quotation');
                            } elseif ($notif->module === 'Project') {
                                $notifHref = route('client-project');
                            }
                        @endphp
                        <a href="{{ $notifHref }}"
                            class="notif-item js-notif-item {{ $notif->is_read ? '' : 'unread' }}"
                            data-notif-id="{{ $notif->id }}"
                            data-mark-read-url="{{ route('notifications.read', $notif->id) }}">
                            <span class="notif-icon">
                                <span class="material-symbols-outlined">
                                    @switch($notif->module)
                                        @case('Assessment')
                                            calendar_month
                                        @break

                                        @case('Quotation')
                                            receipt_long
                                        @break

                                        @case('Project')
                                            folder_open
                                        @break

                                        @default
                                            inbox
                                    @endswitch
                                </span>
                            </span>
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
                    <a href="{{ route('client-notifications') }}" class="notif-view-all">View all notifications</a>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="dropdown">
                <div class="topnav-avatar" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                    title="Account menu">
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                </div>
                <ul class="dropdown-menu dropdown-menu-end topnav-avatar-menu">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile') }}">
                            <span class="material-symbols-outlined fs-6">person</span> View Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('settings') }}">
                            <span class="material-symbols-outlined fs-6">settings</span> Settings
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('activity-logs') }}">
                            <span class="material-symbols-outlined fs-6">history</span> View Activity Logs
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <span class="material-symbols-outlined fs-6">logout</span> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <button id="mobileNavToggle" class="topnav-toggler" type="button" aria-expanded="false"
                aria-controls="mobileDrawer">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>


    </nav>

    <div class="mobile-nav-drawer" id="mobileDrawer">
        <a href="{{ route('portal') }}" class="@if (Request::routeIs('portal')) active @endif">
            <span class="material-symbols-outlined">account_circle</span> Client Portal
        </a>
        <a href="{{ route('client-assessment') }}" class="@if (Request::routeIs('client-assessment*')) active @endif">
            <span class="material-symbols-outlined">calendar_month</span> Assessment
        </a>
        <a href="{{ route('client-quotation') }}" class="@if (Request::routeIs('client-quotation*') || Request::routeIs('quotation-view')) active @endif">
            <span class="material-symbols-outlined">receipt_long</span> Quotations
        </a>
        <a href="{{ route('client-project') }}" class="@if (Request::routeIs('client-project')) active @endif">
            <span class="material-symbols-outlined">folder_open</span> Projects
        </a>
    </div>
