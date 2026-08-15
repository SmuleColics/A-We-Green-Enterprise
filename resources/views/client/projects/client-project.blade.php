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
                            <p class="summary-value">{{ $total }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-success">play_circle</span>
                        <div>
                            <p class="summary-label">In Progress</p>
                            <p class="summary-value">{{ $inProgress }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                        <div>
                            <p class="summary-label">On Hold</p>
                            <p class="summary-value">{{ $onHold }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-primary">check_circle</span>
                        <div>
                            <p class="summary-label">Completed</p>
                            <p class="summary-value">{{ $completed }}</p>
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
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Not Started">Not Started</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In Progress</button>
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
                                @forelse ($projects as $project)
                                    <tr data-status="{{ $project->status }}">
                                        <td class="fw-semibold small">{{ $project->reference_number }}</td>
                                        <td class="fw-semibold">{{ $project->project_title }}</td>
                                        <td>{{ $project->service_type }}</td>
                                        <td>
                                            <div class="progress-container">
                                                <div class="progress hpx-6">
                                                    <div class="progress-bar bg-success" style="width:{{ $project->taskProgress() }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $project->taskProgress() }}%</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill
                                                @if ($project->status === 'Completed') bg-primary
                                                @elseif ($project->status === 'On Hold') bg-warning text-dark
                                                @elseif ($project->status === 'In Progress') bg-success
                                                @else bg-secondary
                                                @endif">{{ $project->status }}</span>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('project-monitoring', $project) }}" class="btn btn-sm btn-outline-success" title="View">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No projects yet. Projects
                                            appear here once your approved quotation's contract is confirmed.</td>
                                    </tr>
                                @endforelse
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
                columnDefs: [{ orderable: false, targets: 5 }],
                language: {
                    emptyTable: 'No projects found.',
                    zeroRecords: 'No matching projects found.'
                }
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
