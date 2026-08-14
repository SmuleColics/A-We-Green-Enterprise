@extends('layouts.admin')

@section('title', 'Archived Projects')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/projects/projects.css') }}">
@endsection

@section('page-title', 'Archived Projects')

@section('topbar-actions')
    <a href="{{ route('projects') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Projects
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">autorenew</span>
                    <div>
                        <p class="summary-label">Active</p>
                        <p class="summary-value">0</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Completed</p>
                        <p class="summary-value">5</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Cancelled</p>
                        <p class="summary-value">2</p>
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

        <!-- Archived Projects Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Active">Active</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Completed">Completed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Cancelled">Cancelled</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveProjectsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Project</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Amount</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Progress</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">PA System – Quezon City</td>
                                <td>Lisa Tan</td>
                                <td>Public Address System</td>
                                <td class="fw-semibold text-success">₱55,000.00</td>
                                <td>Jan 15, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-success" style="width:100%;"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge rounded-pill bg-success" data-status="1">Completed</span></td>
                                <td class="text-muted small">Feb 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('projects') }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Solar Setup – Cavite</td>
                                <td>Ramon Dela Cruz</td>
                                <td>Solar Setup</td>
                                <td class="fw-semibold text-success">₱210,000.00</td>
                                <td>Dec 30, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-danger" style="width:40%;"></div>
                                        </div>
                                        <small class="text-muted">40%</small>
                                    </div>
                                </td>
                                <td><span class="badge rounded-pill bg-danger" data-status="2">Cancelled</span></td>
                                <td class="text-muted small">Jan 05, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('projects') }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">CCTV System – Dasmariñas</td>
                                <td>Elena Cruz</td>
                                <td>CCTV Setup</td>
                                <td class="fw-semibold text-success">₱38,500.00</td>
                                <td>Nov 20, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-success" style="width:100%;"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge rounded-pill bg-success" data-status="1">Completed</span></td>
                                <td class="text-muted small">Dec 10, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('projects') }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Street Lights – Imus</td>
                                <td>Ben Soriano</td>
                                <td>Solar Street Light</td>
                                <td class="fw-semibold text-success">₱480,000.00</td>
                                <td>Oct 15, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-warning" style="width:60%;"></div>
                                        </div>
                                        <small class="text-muted">60%</small>
                                    </div>
                                </td>
                                <td><span class="badge rounded-pill bg-warning text-dark" data-status="3">On Hold</span></td>
                                <td class="text-muted small">Nov 01, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('projects') }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">PA System – Bacoor</td>
                                <td>Grace Villanueva</td>
                                <td>Public Address System</td>
                                <td class="fw-semibold text-success">₱72,000.00</td>
                                <td>Sep 30, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-success" style="width:100%;"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge rounded-pill bg-success" data-status="1">Completed</span></td>
                                <td class="text-muted small">Oct 10, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('projects') }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Solar Panel – Silang</td>
                                <td>Carla Bautista</td>
                                <td>Solar Setup</td>
                                <td class="fw-semibold text-success">₱320,000.00</td>
                                <td>Aug 20, 2025</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-danger" style="width:25%;"></div>
                                        </div>
                                        <small class="text-muted">25%</small>
                                    </div>
                                </td>
                                <td><span class="badge rounded-pill bg-danger" data-status="2">Cancelled</span></td>
                                <td class="text-muted small">Sep 01, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('projects') }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
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

            $('#archiveProjectsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[7, 'desc']],
                columnDefs: [
                    { orderable: false, targets: 8 },
                    { type: 'status-priority', targets: 6 }
                ]
            });
        });
    </script>
@endsection