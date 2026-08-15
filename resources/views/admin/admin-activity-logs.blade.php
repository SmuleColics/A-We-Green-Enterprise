@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/activity-logs/activity-logs.css') }}">
@endsection

@section('page-title', 'Activity Logs')

@section('topbar-actions')
    {{-- <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" onclick="window.print()">
        <span class="material-symbols-outlined fs-17">print</span>
        Print Logs
    </button> --}}
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archivedLogsModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
        data-bs-target="#archiveLogsModal">
        <span class="material-symbols-outlined fs-17">archive</span>
        Archive Old Logs
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">manage_history</span>
                    <div>
                        <p class="summary-label">Total Logs</p>
                        <p class="summary-value">284</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">today</span>
                    <div>
                        <p class="summary-label">Today</p>
                        <p class="summary-value">12</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">person</span>
                    <div>
                        <p class="summary-label">Active Users</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">warning</span>
                    <div>
                        <p class="summary-label">Failed Logins</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <!-- Row 1: Module Filters -->
                <div class="d-flex flex-wrap align-items-center mb-2">
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
                </div>

                <!-- Row 2: Date Range Filter -->
                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end mb-3">
                    <input type="date" class="form-control form-control-sm" id="dateFrom" style="width:120px;">
                    <span class="text-muted small">to</span>
                    <input type="date" class="form-control form-control-sm" id="dateTo" style="width:120px;">
                    <button class="btn btn-sm btn-outline-secondary" onclick="clearDateFilter()">
                        <span class="material-symbols-outlined fs-17">close</span>
                    </button>
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

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 15, 2026 · 8:00 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-auth">Auth</span></td>
                                <td><span class="action-badge action-login">Login</span></td>
                                <td>Admin logged in successfully.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 15, 2026 · 8:00 AM',user:'Michael Garcia',module:'Auth',action:'Login',description:'Admin logged in successfully.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 15, 2026 · 9:00 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-assessment">Assessment</span></td>
                                <td><span class="action-badge action-create">Created</span></td>
                                <td>Scheduled assessment for Maria Santos — CCTV Setup.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 15, 2026 · 9:00 AM',user:'Michael Garcia',module:'Assessment',action:'Created',description:'Scheduled assessment for Maria Santos — CCTV Setup.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 15, 2026 · 10:30 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-quotation">Quotation</span></td>
                                <td><span class="action-badge action-create">Created</span></td>
                                <td>Created quotation QT-2026-007 for John Reyes — Solar Setup.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 15, 2026 · 10:30 AM',user:'Michael Garcia',module:'Quotation',action:'Created',description:'Created quotation QT-2026-007 for John Reyes — Solar Setup.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 15, 2026 · 11:00 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-task">Task</span></td>
                                <td><span class="action-badge action-create">Assigned</span></td>
                                <td>Assigned task "Run CAT6 Cabling" to Jomar Tan.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 15, 2026 · 11:00 AM',user:'Michael Garcia',module:'Task',action:'Assigned',description:'Assigned task Run CAT6 Cabling to Jomar Tan.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 14, 2026 · 4:00 PM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-project">Project</span></td>
                                <td><span class="action-badge action-update">Updated</span></td>
                                <td>Posted update on CCTV Installation — Santos Residence.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 14, 2026 · 4:00 PM',user:'Michael Garcia',module:'Project',action:'Updated',description:'Posted update on CCTV Installation — Santos Residence.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 14, 2026 · 3:00 PM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-material">Material</span></td>
                                <td><span class="action-badge action-warning">Low Stock</span></td>
                                <td>Low stock alert triggered for Solar Panels (4 remaining).</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 14, 2026 · 3:00 PM',user:'Michael Garcia',module:'Material',action:'Low Stock',description:'Low stock alert triggered for Solar Panels (4 remaining).',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 13, 2026 · 9:00 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-employee">Employee</span></td>
                                <td><span class="action-badge action-create">Added</span></td>
                                <td>Added new staff — Patricia Lim (Secretary).</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 13, 2026 · 9:00 AM',user:'Michael Garcia',module:'Employee',action:'Added',description:'Added new staff — Patricia Lim (Secretary).',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 13, 2026 · 10:00 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-client">Client</span></td>
                                <td><span class="action-badge action-archive">Archived</span></td>
                                <td>Archived client — Elena Cruz (CLT-2025-018).</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 13, 2026 · 10:00 AM',user:'Michael Garcia',module:'Client',action:'Archived',description:'Archived client — Elena Cruz (CLT-2025-018).',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 12, 2026 · 2:00 PM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-settings">Settings</span></td>
                                <td><span class="action-badge action-update">Updated</span></td>
                                <td>Updated company Terms of Service.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 12, 2026 · 2:00 PM',user:'Michael Garcia',module:'Settings',action:'Updated',description:'Updated company Terms of Service.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 12, 2026 · 7:45 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar log-avatar-unknown">?</div>
                                        <span class="fw-semibold text-muted">Unknown</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-auth">Auth</span></td>
                                <td><span class="action-badge action-danger">Failed Login</span></td>
                                <td>Failed login attempt on admin account.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 12, 2026 · 7:45 AM',user:'Unknown',module:'Auth',action:'Failed Login',description:'Failed login attempt on admin account.',ip:'203.177.12.45',browser:'Unknown',device:'Unknown'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 12, 2026 · 11:00 AM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-quotation">Quotation</span></td>
                                <td><span class="action-badge action-approve">Approved</span></td>
                                <td>Quotation QT-2026-003 approved by Anna Garcia.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 12, 2026 · 11:00 AM',user:'Michael Garcia',module:'Quotation',action:'Approved',description:'Quotation QT-2026-003 approved by Anna Garcia.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted small text-nowrap">Mar 11, 2026 · 3:30 PM</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="log-avatar">MG</div>
                                        <span class="fw-semibold">Michael Garcia</span>
                                    </div>
                                </td>
                                <td><span class="module-badge module-assessment">Assessment</span></td>
                                <td><span class="action-badge action-danger">Cancelled</span></td>
                                <td>Cancelled assessment for Ben Soriano — Public Address System.</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                        onclick="loadLog({datetime:'Mar 11, 2026 · 3:30 PM',user:'Michael Garcia',module:'Assessment',action:'Cancelled',description:'Cancelled assessment for Ben Soriano — Public Address System.',ip:'192.168.1.1',browser:'Chrome 122',device:'Windows PC'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                </td>
                            </tr>

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
                        <div class="col-6">
                            <p class="detail-label small mb-0">IP Address</p>
                            <p class="detail-value small" id="vl-ip">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Browser</p>
                            <p class="detail-value small" id="vl-browser">—</p>
                        </div>
                        <div class="col-12">
                            <p class="detail-label small mb-0">Device</p>
                            <p class="detail-value small" id="vl-device">—</p>
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
                            <select class="form-select form-select-sm">
                                <option>30 days</option>
                                <option>60 days</option>
                                <option selected>90 days</option>
                                <option>6 months</option>
                                <option>1 year</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="policy-info-box">
                                <span class="material-symbols-outlined text-primary fs-18">info</span>
                                <p class="small mb-0">This will move <strong>48 logs</strong> older than 90 days to the
                                    archive. They can still be viewed under <strong>View Archives</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-16">archive</span>
                        Archive Logs
                    </button>
                </div>
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
                                    <th class="border-0 small green-text">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted small text-nowrap">Jan 10, 2026 · 9:00 AM</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="log-avatar">MG</div>
                                            <span class="fw-semibold">Michael Garcia</span>
                                        </div>
                                    </td>
                                    <td><span class="module-badge module-assessment">Assessment</span></td>
                                    <td><span class="action-badge action-create">Created</span></td>
                                    <td>Scheduled assessment for Roberto Lim — Solar Street Light.</td>
                                    <td class="text-muted small">Feb 10, 2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                            onclick="loadLog({datetime:'Jan 10, 2026 · 9:00 AM',user:'Michael Garcia',module:'Assessment',action:'Created',description:'Scheduled assessment for Roberto Lim — Solar Street Light.',ip:'192.168.1.1',browser:'Chrome 120',device:'Windows PC'})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted small text-nowrap">Jan 8, 2026 · 11:30 AM</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="log-avatar">MG</div>
                                            <span class="fw-semibold">Michael Garcia</span>
                                        </div>
                                    </td>
                                    <td><span class="module-badge module-quotation">Quotation</span></td>
                                    <td><span class="action-badge action-approve">Approved</span></td>
                                    <td>Quotation QT-2025-089 approved by Carlo Mendoza.</td>
                                    <td class="text-muted small">Feb 10, 2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                            onclick="loadLog({datetime:'Jan 8, 2026 · 11:30 AM',user:'Michael Garcia',module:'Quotation',action:'Approved',description:'Quotation QT-2025-089 approved by Carlo Mendoza.',ip:'192.168.1.1',browser:'Chrome 120',device:'Windows PC'})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted small text-nowrap">Jan 5, 2026 · 2:00 PM</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="log-avatar">MG</div>
                                            <span class="fw-semibold">Michael Garcia</span>
                                        </div>
                                    </td>
                                    <td><span class="module-badge module-client">Client</span></td>
                                    <td><span class="action-badge action-create">Added</span></td>
                                    <td>Added new client — Ramon Dela Cruz (Commercial).</td>
                                    <td class="text-muted small">Feb 10, 2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewLogModal"
                                            onclick="loadLog({datetime:'Jan 5, 2026 · 2:00 PM',user:'Michael Garcia',module:'Client',action:'Added',description:'Added new client — Ramon Dela Cruz (Commercial).',ip:'192.168.1.1',browser:'Chrome 120',device:'Windows PC'})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
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
            'Client': 'module-client',
            'Employee': 'module-employee',
            'Material': 'module-material',
            'Settings': 'module-settings',
            'Auth': 'module-auth',
        };

        const ACTION_BADGE_MAP = {
            'Login': 'action-login',
            'Failed Login': 'action-danger',
            'Created': 'action-create',
            'Assigned': 'action-create',
            'Added': 'action-create',
            'Updated': 'action-update',
            'Approved': 'action-approve',
            'Archived': 'action-archive',
            'Cancelled': 'action-danger',
            'Low Stock': 'action-warning',
        };

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
            document.getElementById('vl-browser').textContent = d.browser || '—';
            document.getElementById('vl-device').textContent = d.device || '—';

            document.getElementById('vl-module-badge').innerHTML =
                `<span class="module-badge ${MODULE_BADGE_MAP[d.module] || ''}">${d.module}</span>`;
            document.getElementById('vl-action-badge').innerHTML =
                `<span class="action-badge ${ACTION_BADGE_MAP[d.action] || ''}">${d.action}</span>`;
        }

        $(document).ready(function() {
            $('#activityLogsTable').DataTable({
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

            $('#archivedLogsModal').on('shown.bs.modal', function() {
                if (!$.fn.DataTable.isDataTable('#archivedLogsTable')) {
                    $('#archivedLogsTable').DataTable({
                        pageLength: 10,
                        order: [
                            [0, 'desc']
                        ],
                        columnDefs: [{
                            orderable: false,
                            targets: 6
                        }],
                        language: {
                            emptyTable: 'No archived activity logs yet.',
                            zeroRecords: 'No matching archived activity logs found.'
                        }
                    });
                }
            });
        });

        function clearDateFilter() {
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
        }
    </script>
@endsection
