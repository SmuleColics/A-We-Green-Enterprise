@extends('layouts.client')

@section('title', 'Notifications')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/notifications.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Notifications</h2>
            <p>Updates on your requests, quotations, and projects.</p>
        </div>

        <div class="main-content">
            <div class="notifications-wrap">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <div class="btn-group filter-btn-group" role="group" id="notificationsFilterGroup">
                                <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Assessment">Assessment</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Quotation">Quotation</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Project">Projects</button>
                            </div>

                            <a href="#" class="notif-mark-read js-mark-all-read"
                                data-url="{{ route('notifications.read-all') }}">Mark all as read</a>
                        </div>

                        @if ($notifications->isEmpty())
                            <div class="text-center text-muted small py-5">No notifications yet.</div>
                        @else
                            <div class="table-responsive">
                                <table id="notificationsTable" class="table table-hover mb-0 small w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 small green-text">Type</th>
                                            <th class="border-0 small green-text">Notification</th>
                                            <th class="border-0 small green-text">Status</th>
                                            <th class="border-0 small green-text">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notif)
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
                                            <tr data-type="{{ $notif->module }}">
                                                <td>
                                                    <span class="activity-type-icon">
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
                                                </td>
                                                <td>
                                                    <a href="{{ $notifHref }}"
                                                        class="notif-row-link js-notif-item {{ $notif->is_read ? '' : 'unread' }}"
                                                        data-mark-read-url="{{ route('notifications.read', $notif->id) }}">
                                                        <p class="fw-semibold mb-0">{{ $notif->title }}</p>
                                                        <p class="text-muted mb-0">{{ $notif->message }}</p>
                                                    </a>
                                                </td>
                                                <td data-order="{{ $notif->is_read ? 1 : 0 }}">
                                                    @if ($notif->is_read)
                                                        <span class="badge bg-secondary rounded-pill">Read</span>
                                                    @else
                                                        <span class="badge bg-success rounded-pill">Unread</span>
                                                    @endif
                                                </td>
                                                <td data-order="{{ $notif->created_at->timestamp }}">{{ $notif->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/client/notifications.js') }}"></script>
@endsection
