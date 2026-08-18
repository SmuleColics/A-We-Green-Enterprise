@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-activity-logs.css') }}">
@endsection

@section('page-title', 'Activity Logs')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archivedLogsModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    @if (auth()->user()->isSuperAdmin())
        <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
            data-bs-target="#archiveLogsModal">
            <span class="material-symbols-outlined fs-17">archive</span>
            Archive Old Logs
        </button>
    @endif
@endsection

@section('content')

    @php
        $rowInitials = function ($name) {
            if (!$name || $name === 'Unknown') {
                return '?';
            }
            $parts = array_filter(explode(' ', trim($name)));
            $initials = '';
            foreach (array_slice($parts, 0, 2) as $p) {
                $initials .= strtoupper($p[0]);
            }
            return $initials ?: '?';
        };

        $actionBadgeMap = [
            'Login' => 'action-login',
            'Logout' => 'action-login',
            'Failed Login' => 'action-danger',
            'Created' => 'action-create',
            'Updated' => 'action-update',
            'Archived' => 'action-archive',
            'Restored' => 'action-approve',
            'Deleted' => 'action-danger',
            'Requested' => 'action-warning',
            'Approved' => 'action-approve',
            'Rejected' => 'action-danger',
        ];
    @endphp

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">manage_history</span>
                    <div>
                        <p class="summary-label">Total Logs</p>
                        <p class="summary-value">{{ $totalLogs }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">today</span>
                    <div>
                        <p class="summary-label">Today</p>
                        <p class="summary-value">{{ $totalToday }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">person</span>
                    <div>
                        <p class="summary-label">Active Users</p>
                        <p class="summary-value">{{ $activeUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">warning</span>
                    <div>
                        <p class="summary-label">Failed Logins Today</p>
                        <p class="summary-value">{{ $failedLoginsToday }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <!-- Toolbar: module filters (left) + date range (right) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 activity-toolbar">
                    <div class="btn-group filter-btn-group" role="group" id="moduleFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active"
                            data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Assessment">Assessment</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Quotation">Quotation</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Project">Project</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Task">Task</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Client">Client</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Employee">Employee</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Material">Material</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Auth">Auth</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Settings">Settings</button>
                    </div>

                    <div class="date-range-group">
                        <input type="date" class="date-range-input" id="dateFrom">
                        <span class="text-muted small px-1">to</span>
                        <input type="date" class="date-range-input" id="dateTo">
                        <button type="button" class="date-range-clear" onclick="clearDateFilter()"
                            title="Clear date filter">
                            <span class="material-symbols-outlined fs-17">close</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="activityLogsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Date & Time</th>
                                <th class="border-0 small green-text">User</th>
                                <th class="border-0 small green-text">Module</th>
                                <th class="border-0 small green-text">Action</th>
                                <th class="border-0 small green-text">Description</th>
                                <th class="border-0 small green-text">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr data-date="{{ $log->created_at->format('Y-m-d') }}">
                                    <td class="text-muted small text-nowrap">
                                        {{ $log->created_at->format('M j, Y · g:i A') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                class="log-avatar {{ $log->user_name === 'Unknown' ? 'log-avatar-unknown' : '' }}">
                                                {{ $rowInitials($log->user_name) }}</div>
                                            <span
                                                class="fw-semibold {{ $log->user_name === 'Unknown' ? 'text-muted' : '' }}">{{ $log->user_name }}</span>
                                        </div>
                                    </td>
                                    <td><span
                                            class="module-badge module-{{ strtolower($log->module) }}">{{ $log->module }}</span>
                                    </td>
                                    <td><span
                                            class="action-badge {{ $actionBadgeMap[$log->action] ?? '' }}">{{ $log->action }}</span>
                                    </td>
                                    <td>{{ $log->description }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                            onclick="loadLog({datetime: @json($log->created_at->format('M j, Y · g:i A')), user: @json($log->user_name), module: @json($log->module), action: @json($log->action), description: @json($log->description), ip: @json($log->ip_address ?? '—')})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No activity logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <!-- ── View Log Modal ── -->
    <div class="modal fade" id="viewLogModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">manage_history</span>
                        Log Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="log-avatar log-avatar-lg" id="vl-avatar">?</div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vl-user">—</p>
                            <p class="text-muted small mb-1" id="vl-datetime">—</p>
                            <span id="vl-module-badge">—</span>
                            <span id="vl-action-badge" class="ms-1">—</span>
                        </div>
                    </div>

                    <p class="section-label">Activity</p>
                    <div class="row g-2 mb-2">
                        <div class="col-12">
                            <p class="detail-label small mb-0">Description</p>
                            <p class="detail-value small" id="vl-description">—</p>
                        </div>
                    </div>

                    <p class="section-label">Session Info</p>
                    <div class="row g-2">
                        <div class="col-12">
                            <p class="detail-label small mb-0">IP Address</p>
                            <p class="detail-value small" id="vl-ip">—</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archive Old Logs Modal ── -->
    <div class="modal fade" id="archiveLogsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin-activity-logs.archive-old') }}">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-semibold d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-20">archive</span>
                            Archive Old Logs
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-2">
                        <p class="small text-muted mb-3">Move old activity logs to the archive to keep the active log list
                            clean. Archived logs are never deleted and can be viewed anytime.</p>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small">Archive logs older than</label>
                                <select class="form-select form-select-sm" name="older_than" id="archive-older-than">
                                    <option value="30">30 days</option>
                                    <option value="60">60 days</option>
                                    <option value="90" selected>90 days</option>
                                    <option value="180">6 months</option>
                                    <option value="365">1 year</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="policy-info-box">
                                    <span class="material-symbols-outlined text-primary fs-18">info</span>
                                    <p class="small mb-0">This will move <strong
                                            id="archive-count-num">{{ $archivableCounts[90] }}</strong> log(s) older than
                                        <span id="archive-count-days">90</span> days to the archive. They can still be
                                        viewed under <strong>View Archives</strong>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">archive</span>
                            Archive Logs
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ── Archived Logs Modal ── -->
    <div class="modal fade" id="archivedLogsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">inventory_2</span>
                        <h5 class="modal-title mb-0">Archived Logs</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="archivedLogsTable" class="table table-hover mb-0 small w-100 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Date & Time</th>
                                    <th class="border-0 small green-text">User</th>
                                    <th class="border-0 small green-text">Module</th>
                                    <th class="border-0 small green-text">Action</th>
                                    <th class="border-0 small green-text">Description</th>
                                    <th class="border-0 small green-text">Archived On</th>
                                    <th class="border-0 small green-text">Archived By</th>
                                    <th class="border-0 small green-text">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($archivedLogs as $log)
                                    <tr>
                                        <td class="text-muted small text-nowrap">
                                            {{ $log->created_at->format('M j, Y · g:i A') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div
                                                    class="log-avatar {{ $log->user_name === 'Unknown' ? 'log-avatar-unknown' : '' }}">
                                                    {{ $rowInitials($log->user_name) }}</div>
                                                <span
                                                    class="fw-semibold {{ $log->user_name === 'Unknown' ? 'text-muted' : '' }}">{{ $log->user_name }}</span>
                                            </div>
                                        </td>
                                        <td><span
                                                class="module-badge module-{{ strtolower($log->module) }}">{{ $log->module }}</span>
                                        </td>
                                        <td><span
                                                class="action-badge {{ $actionBadgeMap[$log->action] ?? '' }}">{{ $log->action }}</span>
                                        </td>
                                        <td>{{ $log->description }}</td>
                                        <td class="text-muted small">{{ optional($log->archived_at)->format('M j, Y') }}
                                        </td>
                                        <td class="text-muted small">{{ $log->archivedBy->full_name ?? '—' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                                data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                                onclick="loadLog({datetime: @json($log->created_at->format('M j, Y · g:i A')), user: @json($log->user_name), module: @json($log->module), action: @json($log->action), description: @json($log->description), ip: @json($log->ip_address ?? '—')})">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No archived activity logs
                                            yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const MODULE_BADGE_MAP = {
            'Assessment': 'module-assessment',
            'Quotation': 'module-quotation',
            'Project': 'module-project',
            'Task': 'module-task',
            'Checklist': 'module-checklist',
            'Client': 'module-client',
            'Staff': 'module-staff',
            'Employee': 'module-employee',
            'Material': 'module-material',
            'Settings': 'module-settings',
            'Auth': 'module-auth',
        };

        const ACTION_BADGE_MAP = {
            'Login': 'action-login',
            'Logout': 'action-login',
            'Failed Login': 'action-danger',
            'Created': 'action-create',
            'Updated': 'action-update',
            'Archived': 'action-archive',
            'Restored': 'action-approve',
            'Deleted': 'action-danger',
            'Requested': 'action-warning',
            'Approved': 'action-approve',
            'Rejected': 'action-danger',
        };

        const ARCHIVABLE_COUNTS = @json($archivableCounts);

        function loadLog(d) {
            const initials = (d.user || '?').split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
            const avatar = document.getElementById('vl-avatar');
            avatar.textContent = d.user === 'Unknown' ? '?' : initials;
            avatar.className = d.user === 'Unknown' ?
                'log-avatar log-avatar-lg log-avatar-unknown' :
                'log-avatar log-avatar-lg';

            document.getElementById('vl-user').textContent = d.user || '—';
            document.getElementById('vl-datetime').textContent = d.datetime || '—';
            document.getElementById('vl-description').textContent = d.description || '—';
            document.getElementById('vl-ip').textContent = d.ip || '—';

            document.getElementById('vl-module-badge').innerHTML =
                `<span class="module-badge ${MODULE_BADGE_MAP[d.module] || ''}">${d.module}</span>`;
            document.getElementById('vl-action-badge').innerHTML =
                `<span class="action-badge ${ACTION_BADGE_MAP[d.action] || ''}">${d.action}</span>`;
        }

        let activityTable;

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'activityLogsTable') return true;

            const min = document.getElementById('dateFrom').value;
            const max = document.getElementById('dateTo').value;
            if (!min && !max) return true;

            const rowDate = $(activityTable.row(dataIndex).node()).data('date');
            if (!rowDate) return true;
            if (min && rowDate < min) return false;
            if (max && rowDate > max) return false;
            return true;
        });

        $(document).ready(function() {
            activityTable = $('#activityLogsTable').DataTable({
                pageLength: 25,
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 5
                }],
                language: {
                    emptyTable: 'No activity logs found.',
                    zeroRecords: 'No matching activity logs found.'
                }
            });

            document.getElementById('dateFrom').addEventListener('change', () => activityTable.draw());
            document.getElementById('dateTo').addEventListener('change', () => activityTable.draw());

            document.querySelectorAll('#moduleFilterGroup .btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('#moduleFilterGroup .btn').forEach(b => b.classList
                        .remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;
                    if (filter === 'all') {
                        activityTable.column(2).search('').draw();
                    } else {
                        activityTable.column(2).search('^' + filter + '$', true, false).draw();
                    }
                });
            });

            $('#archivedLogsModal').on('shown.bs.modal', function() {
                if (!$.fn.DataTable.isDataTable('#archivedLogsTable')) {
                    $('#archivedLogsTable').DataTable({
                        pageLength: 10,
                        order: [
                            [0, 'desc']
                        ],
                        columnDefs: [{
                            orderable: false,
                            targets: 7
                        }],
                        language: {
                            emptyTable: 'No archived activity logs yet.',
                            zeroRecords: 'No matching archived activity logs found.'
                        }
                    });
                }
            });

            document.getElementById('archive-older-than').addEventListener('change', function() {
                const days = this.value;
                document.getElementById('archive-count-num').textContent = ARCHIVABLE_COUNTS[days] ?? '0';
                document.getElementById('archive-count-days').textContent =
                    this.options[this.selectedIndex].text;
            });
        });

        function clearDateFilter() {
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            activityTable.draw();
        }
    </script>
@endsection
