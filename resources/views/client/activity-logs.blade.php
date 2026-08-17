@extends('layouts.client')

@section('title', 'Activity Logs')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/activity-logs.css') }}">
@endsection

@section('content')

    @php
        $moduleIcons = [
            'Assessment' => 'calendar_month',
            'Quotation' => 'receipt_long',
            'Project' => 'folder_open',
            'Checklist' => 'checklist',
            'Client' => 'inbox',
        ];

        $actionBadges = [
            'Requested' => ['label' => 'UNDER REVIEW', 'class' => 'badge-review'],
            'Approved' => ['label' => 'CONFIRMED', 'class' => 'badge-confirmed'],
            'Rejected' => ['label' => 'DECLINED', 'class' => 'badge-awaiting'],
            'Created' => ['label' => 'SUBMITTED', 'class' => 'badge-review'],
            'Updated' => ['label' => 'IN PROGRESS', 'class' => 'badge-inprogress'],
            'Archived' => ['label' => 'ARCHIVED', 'class' => 'badge-review'],
        ];
    @endphp

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Activity Logs</h2>
            <p>A history of your requests, quotations, and project updates.</p>
        </div>

        <div class="main-content">
            <div class="activity-logs-wrap">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="mb-3 btn-group filter-btn-group" role="group" id="activityFilterGroup">
                            <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Assessment">Assessment</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Quotation">Quotation</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Project">Projects</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Client">Account</button>
                        </div>

                        @if ($logs->isEmpty())
                            <div class="text-center py-5">
                                <span class="material-symbols-outlined text-muted" style="font-size:40px;">inbox</span>
                                <p class="text-muted mt-2 mb-0">No activity yet. Your assessment, quotation, and project
                                    updates will show up here.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table id="activityTable" class="table table-hover mb-0 small w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 small green-text">Type</th>
                                            <th class="border-0 small green-text">Activity</th>
                                            <th class="border-0 small green-text">Status</th>
                                            <th class="border-0 small green-text">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $log)
                                            @php
                                                $badge = $actionBadges[$log->action] ?? [
                                                    'label' => strtoupper($log->action),
                                                    'class' => 'badge-review',
                                                ];
                                                $icon = $moduleIcons[$log->module] ?? 'inbox';
                                            @endphp
                                            <tr data-type="{{ $log->module }}">
                                                <td>
                                                    <span class="activity-type-icon">
                                                        <span class="material-symbols-outlined">{{ $icon }}</span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <p class="fw-semibold mb-0">{{ $log->module }} {{ strtolower($log->action) }}</p>
                                                    <p class="text-muted mb-0">{{ $log->description }}</p>
                                                </td>
                                                <td data-order="{{ $badge['label'] }}">
                                                    <span class="badge rounded-pill activity-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                                </td>
                                                <td data-order="{{ $log->created_at->timestamp }}">{{ $log->created_at->format('M j, Y · g:i A') }}</td>
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
    <script src="{{ asset('js/client/activity-logs.js') }}"></script>
@endsection
