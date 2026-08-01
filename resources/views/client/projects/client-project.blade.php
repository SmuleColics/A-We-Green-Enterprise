@extends('layouts.client')

@section('title', 'My Projects')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/projects.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>My Projects</h2>
            <p>Track the progress of your ongoing and completed projects.</p>
        </div>

        <div class="main-content">

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-primary">folder_open</span>
                        <div>
                            <p class="summary-label">Total Projects</p>
                            <p class="summary-value">3</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-success">play_circle</span>
                        <div>
                            <p class="summary-label">Active</p>
                            <p class="summary-value">1</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                        <div>
                            <p class="summary-label">On Hold</p>
                            <p class="summary-value">0</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-primary">check_circle</span>
                        <div>
                            <p class="summary-label">Completed</p>
                            <p class="summary-value">2</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                            <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Active">Active</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Completed">Completed</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="projectsTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Project ID</th>
                                    <th class="border-0 small green-text">Project</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Progress</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr data-status="Active">
                                    <td class="fw-semibold small">PRJ-2026-001</td>
                                    <td class="fw-semibold">CCTV Installation – Santos Residence</td>
                                    <td>CCTV Setup</td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress hpx-6">
                                                <div class="progress-bar bg-success wp-65"></div>
                                            </div>
                                            <small class="text-muted">65%</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success rounded-pill">Active</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('project-monitoring', 'PRJ-2026-001') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                                <tr data-status="Completed">
                                    <td class="fw-semibold small">PRJ-2025-089</td>
                                    <td class="fw-semibold">Solar Setup – Home Rooftop</td>
                                    <td>Solar Setup</td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress hpx-6">
                                                <div class="progress-bar bg-success wp-100"></div>
                                            </div>
                                            <small class="text-muted">100%</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary rounded-pill">Completed</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('project-monitoring', 'PRJ-2025-089') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                                <tr data-status="Completed">
                                    <td class="fw-semibold small">PRJ-2025-074</td>
                                    <td class="fw-semibold">Public Address System – Backyard Event Hall</td>
                                    <td>Public Address System</td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress hpx-6">
                                                <div class="progress-bar bg-success wp-100"></div>
                                            </div>
                                            <small class="text-muted">100%</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary rounded-pill">Completed</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('project-monitoring', 'PRJ-2025-074') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#projectsTable').DataTable({
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: 5 }]
            });

            $('#statusFilterGroup .btn').on('click', function() {
                $('#statusFilterGroup .btn').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                if (filter === 'all') {
                    $('#projectsTable tbody tr').show();
                } else {
                    $('#projectsTable tbody tr').each(function() {
                        $(this).toggle($(this).data('status') === filter);
                    });
                }
            });
        });
    </script>
@endsection