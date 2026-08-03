@extends('layouts.admin')

@section('title', 'Projects')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/projects/projects.css') }}">
@endsection

@section('page-title', 'Projects')

@section('topbar-actions')
    <a href="{{ route('archive-projects') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        Archived Projects
    </a>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text" data-bs-toggle="modal"
        data-bs-target="#createProjectModal">
        <span class="material-symbols-outlined me-1 fs-18">add</span>
        Create Project
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">folder_open</span>
                    <div>
                        <p class="summary-label">Total Projects</p>
                        <p class="summary-value">5</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">check_circle</span>
                    <div>
                        <p class="summary-label">Completed</p>
                        <p class="summary-value">1</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">play_circle</span>
                    <div>
                        <p class="summary-label">Active</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value">1</p>
                    </div>
                </div>
            </div>
           
        </div>

        <!-- Projects Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active"
                            data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Completed">Completed</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Active">Active</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On
                            Hold</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="projectsTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Project ID</th>
                                <th class="border-0 small green-text">Project</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Amount</th>
                                <th class="border-0 small green-text">Progress</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Completed --}}
                            <tr>
                                <td class="fw-semibold small">PRJ-2026-004</td>
                                <td class="fw-semibold">Access Control – Alabang</td>
                                <td>Pedro Cruz</td>
                                <td>Public Address System</td>
                                <td class="text-success fw-semibold">₱95,000.00</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-success wp-100"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-success rounded-pill" data-status="1">Completed</span></td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('monitoring') }}" class="btn btn-sm btn-outline-success action-btn"
                                        title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveProjectConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- Active --}}
                            <tr>
                                <td class="fw-semibold small">PRJ-2026-001</td>
                                <td class="fw-semibold">CCTV Installation – Makati Branch</td>
                                <td>Maria Santos</td>
                                <td>CCTV Setup</td>
                                <td class="text-success fw-semibold">₱45,000.00</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-primary wp-65"></div>
                                        </div>
                                        <small class="text-muted">65%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary rounded-pill" data-status="2">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('monitoring') }}" class="btn btn-sm btn-outline-success action-btn"
                                        title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveProjectConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-semibold small">PRJ-2026-002</td>
                                <td class="fw-semibold">Network Setup – BGC Office</td>
                                <td>John Reyes</td>
                                <td>Street Light</td>
                                <td class="text-success fw-semibold">₱120,000.00</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-primary wp-40"></div>
                                        </div>
                                        <small class="text-muted">40%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary rounded-pill" data-status="2">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveProjectConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-semibold small">PRJ-2026-005</td>
                                <td class="fw-semibold">Solar Street Lighting – Taguig</td>
                                <td>Roberto Lim</td>
                                <td>Street Light</td>
                                <td class="text-success fw-semibold">₱750,000.00</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-primary wp-10"></div>
                                        </div>
                                        <small class="text-muted">10%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary rounded-pill" data-status="2">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveProjectConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- On Hold --}}
                            <tr>
                                <td class="fw-semibold small">PRJ-2026-003</td>
                                <td class="fw-semibold">Fire Alarm System – Pasig</td>
                                <td>Anna Garcia</td>
                                <td>Solar Setup</td>
                                <td class="text-success fw-semibold">₱85,000.00</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-warning wp-20"></div>
                                        </div>
                                        <small class="text-muted">20%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark rounded-pill" data-status="3">On Hold</span>
                                </td>
                                <td class="text-nowrap actions-col">
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveProjectConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <!-- ── Archived Projects Modal ── -->
    <div class="modal fade" id="archivedProjectsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">inventory_2</span>
                        <h5 class="modal-title mb-0">Archived Projects</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Project</th>
                                    <th class="border-0 small green-text">Client</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Amount</th>
                                    <th class="border-0 small green-text">Due Date</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Archived On</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">PA System – Quezon City</td>
                                    <td>Lisa Tan</td>
                                    <td><span class="service-badge badge-gray">Public Address System</span></td>
                                    <td class="text-success fw-semibold">₱55,000.00</td>
                                    <td>Jan 15, 2026</td>
                                    <td><span
                                            class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle">Completed</span>
                                    </td>
                                    <td class="text-muted small">Feb 1, 2026</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Solar Setup – Cavite</td>
                                    <td>Ramon Dela Cruz</td>
                                    <td><span class="service-badge badge-amber">Solar Setup</span></td>
                                    <td class="text-success fw-semibold">₱210,000.00</td>
                                    <td>Dec 30, 2025</td>
                                    <td><span
                                            class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle">Cancelled</span>
                                    </td>
                                    <td class="text-muted small">Jan 5, 2026</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
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


    <!-- ── Archive Confirm Modal ── -->
    <div class="modal fade" id="archiveProjectConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Archive Project?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">This project will be moved to the archive. You can restore it anytime
                        from <strong>Archived Projects</strong>.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Create Project Modal ── -->
    <div class="modal fade" id="createProjectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined fs-18">info</span>
                        <p class="mb-0 small">Fill in the project details below. All fields marked * are required.</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">Project Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"
                                placeholder="e.g. CCTV Installation – Makati Branch">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="e.g. Maria Santos">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select">
                                <option value="">Select service</option>
                                <option>CCTV Setup</option>
                                <option>Solar Street Light</option>
                                <option>Solar Setup</option>
                                <option>Public Address System</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="e.g. Makati City">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contract Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Initial Status</label>
                            <select class="form-select">
                                <option selected>Active</option>
                                <option>On Hold</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-18">save</span>
                        Create Project
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Project Modal ── -->
    <div class="modal fade" id="editProjectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">Project Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="CCTV Installation – Makati Branch">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="Maria Santos">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select">
                                <option selected>CCTV Setup</option>
                                <option>Solar Street Light</option>
                                <option>Solar Setup</option>
                                <option>Public Address System</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="Makati City">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contract Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" value="45000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Status</label>
                            <select class="form-select">
                                <option selected>Active</option>
                                <option>Completed</option>
                                <option>On Hold</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" value="2026-03-01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" value="2026-04-15">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-18">save</span>
                        Save Changes
                    </button>
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

            $('#projectsTable').DataTable({
                pageLength: 10,
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    },
                    {
                        type: 'status-priority',
                        targets: 6
                    }
                ],
                order: [
                    [6, 'asc']
                ]
            });
        });
    </script>
@endsection
