@extends('layouts.admin')

@section('title', 'Archived Checklists')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/checklists/checklists.css') }}">
@endsection

@section('page-title', 'Archived Checklists')

@section('topbar-actions')
    <a href="{{ route('checklists') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Checklists
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">task_alt</span>
                    <div>
                        <p class="summary-label">Completed</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">pending_actions</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value">0</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
                        <p class="summary-value">5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Checklists Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Completed">Completed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In Progress</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveChecklistsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Checklist</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Progress</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Torres CCTV Installation</td>
                                <td>Miguel Torres</td>
                                <td>CCTV Setup</td>
                                <td>Feb 18, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-awg-primary wp-100"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-awg-primary rounded-pill" data-status="1">Completed</span></td>
                                <td class="text-muted small">Feb 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalTorres">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Dela Peña Solar Setup</td>
                                <td>Rosario Dela Peña</td>
                                <td>Solar Setup</td>
                                <td>Jan 22, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-awg-primary wp-100"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-awg-primary rounded-pill" data-status="1">Completed</span></td>
                                <td class="text-muted small">Jan 25, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalDelaPena">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Villareal PA System</td>
                                <td>Noel Villareal</td>
                                <td>Public Address System</td>
                                <td>Dec 30, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-awg-primary wp-100"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-awg-primary rounded-pill" data-status="1">Completed</span></td>
                                <td class="text-muted small">Jan 03, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalVillareal">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Aquino Street Lights</td>
                                <td>Ferdinand Aquino</td>
                                <td>Solar Street Light</td>
                                <td>Dec 05, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-warning wp-45"></div>
                                        </div>
                                        <small class="text-muted">45%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark rounded-pill" data-status="3">On Hold</span></td>
                                <td class="text-muted small">Dec 12, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalAquino">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Mendoza CCTV Setup</td>
                                <td>Grace Mendoza</td>
                                <td>CCTV Setup</td>
                                <td>Nov 14, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-warning wp-20"></div>
                                        </div>
                                        <small class="text-muted">20%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark rounded-pill" data-status="3">On Hold</span></td>
                                <td class="text-muted small">Nov 20, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalMendoza">
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

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            jQuery.fn.dataTable.ext.type.order['status-priority-pre'] = function(data) {
                return $(data).data('status') || 0;
            };

            $('#archiveChecklistsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[6, 'desc']],
                columnDefs: [
                    { orderable: false, targets: 7 },
                    { type: 'status-priority', targets: 5 }
                ]
            });
        });
    </script>
@endsection