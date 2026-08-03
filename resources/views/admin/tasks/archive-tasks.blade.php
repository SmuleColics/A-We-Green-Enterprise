@extends('layouts.admin')

@section('title', 'Archived Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tasks/tasks.css') }}">
@endsection

@section('page-title', 'Archived Tasks')

@section('topbar-actions')
    <a href="{{ route('tasks') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Tasks
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
                        <p class="summary-value">16</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Done</p>
                        <p class="summary-value">10</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">autorenew</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold / To Do</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Tasks Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Done">Done</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In Progress</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="To Do">To Do</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveTasksTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task</th>
                                <th class="border-0 small green-text">Project</th>
                                <th class="border-0 small green-text">Assignee</th>
                                <th class="border-0 small green-text">Priority</th>
                                <th class="border-0 small green-text">Start Date</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Install Smoke Detectors</td>
                                <td class="text-muted small">Fire Alarm System – Pasig</td>
                                <td>Ana Garcia</td>
                                <td><span class="badge rounded-pill bg-danger">High</span></td>
                                <td>Mar 05, 2026</td>
                                <td>Mar 08, 2026</td>
                                <td><span class="badge rounded-pill bg-success">Done</span></td>
                                <td class="text-muted small">Mar 10, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedTaskModal"
                                        onclick="loadArchivedTask({
                                            name:'Install Smoke Detectors',
                                            project:'Fire Alarm System – Pasig',
                                            assignee:'Ana Garcia',
                                            priority:'High', priorityClass:'danger',
                                            start:'Mar 05, 2026', due:'Mar 08, 2026',
                                            status:'Done', statusClass:'success',
                                            archivedOn:'Mar 10, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Site Survey & Documentation</td>
                                <td class="text-muted small">Network Setup – BGC Office</td>
                                <td>Marco Rivera</td>
                                <td><span class="badge rounded-pill bg-success">Low</span></td>
                                <td>Mar 15, 2026</td>
                                <td>Mar 18, 2026</td>
                                <td><span class="badge rounded-pill bg-success">Done</span></td>
                                <td class="text-muted small">Mar 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedTaskModal"
                                        onclick="loadArchivedTask({
                                            name:'Site Survey & Documentation',
                                            project:'Network Setup – BGC Office',
                                            assignee:'Marco Rivera',
                                            priority:'Low', priorityClass:'success',
                                            start:'Mar 15, 2026', due:'Mar 18, 2026',
                                            status:'Done', statusClass:'success',
                                            archivedOn:'Mar 20, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Cable Tray Installation</td>
                                <td class="text-muted small">CCTV Installation – Makati Branch</td>
                                <td>Carlo Mendoza</td>
                                <td><span class="badge rounded-pill bg-warning text-dark">Medium</span></td>
                                <td>Feb 20, 2026</td>
                                <td>Feb 25, 2026</td>
                                <td><span class="badge rounded-pill bg-primary">In Progress</span></td>
                                <td class="text-muted small">Mar 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedTaskModal"
                                        onclick="loadArchivedTask({
                                            name:'Cable Tray Installation',
                                            project:'CCTV Installation – Makati Branch',
                                            assignee:'Carlo Mendoza',
                                            priority:'Medium', priorityClass:'warning text-dark',
                                            start:'Feb 20, 2026', due:'Feb 25, 2026',
                                            status:'In Progress', statusClass:'primary',
                                            archivedOn:'Mar 01, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Conduit Pipe Layout</td>
                                <td class="text-muted small">Access Control – Alabang</td>
                                <td>Jomar Tan</td>
                                <td><span class="badge rounded-pill bg-danger">High</span></td>
                                <td>Feb 10, 2026</td>
                                <td>Feb 14, 2026</td>
                                <td><span class="badge rounded-pill bg-warning text-dark">On Hold</span></td>
                                <td class="text-muted small">Feb 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedTaskModal"
                                        onclick="loadArchivedTask({
                                            name:'Conduit Pipe Layout',
                                            project:'Access Control – Alabang',
                                            assignee:'Jomar Tan',
                                            priority:'High', priorityClass:'danger',
                                            start:'Feb 10, 2026', due:'Feb 14, 2026',
                                            status:'On Hold', statusClass:'warning text-dark',
                                            archivedOn:'Feb 20, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Ground Rod Installation</td>
                                <td class="text-muted small">Solar Street Lighting – Taguig</td>
                                <td>Marco Rivera</td>
                                <td><span class="badge rounded-pill bg-success">Low</span></td>
                                <td>Jan 20, 2026</td>
                                <td>Jan 22, 2026</td>
                                <td><span class="badge rounded-pill bg-success">Done</span></td>
                                <td class="text-muted small">Feb 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedTaskModal"
                                        onclick="loadArchivedTask({
                                            name:'Ground Rod Installation',
                                            project:'Solar Street Lighting – Taguig',
                                            assignee:'Marco Rivera',
                                            priority:'Low', priorityClass:'success',
                                            start:'Jan 20, 2026', due:'Jan 22, 2026',
                                            status:'Done', statusClass:'success',
                                            archivedOn:'Feb 01, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Wiring Diagram Preparation</td>
                                <td class="text-muted small">Fire Alarm System – Pasig</td>
                                <td>Carlo Mendoza</td>
                                <td><span class="badge rounded-pill bg-warning text-dark">Medium</span></td>
                                <td>Jan 10, 2026</td>
                                <td>Jan 12, 2026</td>
                                <td><span class="badge rounded-pill bg-success">Done</span></td>
                                <td class="text-muted small">Jan 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedTaskModal"
                                        onclick="loadArchivedTask({
                                            name:'Wiring Diagram Preparation',
                                            project:'Fire Alarm System – Pasig',
                                            assignee:'Carlo Mendoza',
                                            priority:'Medium', priorityClass:'warning text-dark',
                                            start:'Jan 10, 2026', due:'Jan 12, 2026',
                                            status:'Done', statusClass:'success',
                                            archivedOn:'Jan 20, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>


    <!-- ── View Archived Task Modal ── -->
    <div class="modal fade" id="viewArchivedTaskModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">task_alt</span>
                        Task Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <p class="section-label">Task Info</p>
                    <div class="row g-2 mb-2">
                        <div class="col-12">
                            <p class="detail-label small mb-0">Task Name</p>
                            <p class="detail-value small fw-semibold" id="vat-name">—</p>
                        </div>
                        <div class="col-12">
                            <p class="detail-label small mb-0">Project</p>
                            <p class="detail-value small" id="vat-project">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Assignee</p>
                            <p class="detail-value small" id="vat-assignee">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Priority</p>
                            <p class="detail-value small" id="vat-priority">—</p>
                        </div>
                    </div>

                    <p class="section-label">Schedule</p>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Start Date</p>
                            <p class="detail-value small" id="vat-start">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Due Date</p>
                            <p class="detail-value small" id="vat-due">—</p>
                        </div>
                    </div>

                    <p class="section-label">Status</p>
                    <div class="row g-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Task Status</p>
                            <p class="detail-value small" id="vat-status">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Archived On</p>
                            <p class="detail-value small" id="vat-archivedOn">—</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">unarchive</span>Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function loadArchivedTask(d) {
            document.getElementById('vat-name').textContent       = d.name       || '—';
            document.getElementById('vat-project').textContent    = d.project    || '—';
            document.getElementById('vat-assignee').textContent   = d.assignee   || '—';
            document.getElementById('vat-start').textContent      = d.start      || '—';
            document.getElementById('vat-due').textContent        = d.due        || '—';
            document.getElementById('vat-archivedOn').textContent = d.archivedOn || '—';
            document.getElementById('vat-priority').innerHTML =
                `<span class="badge rounded-pill bg-${d.priorityClass}">${d.priority}</span>`;
            document.getElementById('vat-status').innerHTML =
                `<span class="badge rounded-pill bg-${d.statusClass}">${d.status}</span>`;
        }

        $(document).ready(function() {
            $('#archiveTasksTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[7, 'desc']],
                columnDefs: [{ orderable: false, targets: 8 }]
            });
        });
    </script>
@endsection