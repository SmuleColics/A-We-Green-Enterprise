@extends('layouts.admin')

@section('title', 'Projects')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/projects/projects.css') }}">
@endsection

@section('page-title', 'Projects')

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-3 mb-4 project-summary-row">
            <div class="col">
                <div class="summary-card h-100">
                    <span class="material-symbols-outlined summary-icon muted-text">folder_open</span>
                    <div>
                        <p class="summary-label">Total Projects</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="summary-card h-100">
                    <span class="material-symbols-outlined summary-icon green-text">check_circle</span>
                    <div>
                        <p class="summary-label">Completed</p>
                        <p class="summary-value">{{ $completed }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="summary-card h-100">
                    <span class="material-symbols-outlined summary-icon text-primary">play_circle</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value">{{ $inProgress }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="summary-card h-100">
                    <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value">{{ $onHold }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="summary-card h-100">
                    <span class="material-symbols-outlined summary-icon muted-text">pending</span>
                    <div>
                        <p class="summary-label">Not Started</p>
                        <p class="summary-value">{{ $notStarted }}</p>
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
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Not Started">Not
                            Started</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In
                            Progress</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On
                            Hold</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Completed">Completed</button>
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
                            @forelse ($projects as $project)
                                <tr>
                                    <td class="fw-semibold small">{{ $project->reference_number }}</td>
                                    <td class="fw-semibold">{{ $project->project_title }}</td>
                                    <td>{{ $project->quotation->assessment->client->user->full_name }}</td>
                                    <td>{{ $project->service_type }}</td>
                                    <td class="text-success fw-semibold">₱{{ number_format($project->total_budget, 2) }}</td>
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
                                            @if ($project->status === 'Completed') bg-success
                                            @elseif ($project->status === 'On Hold') bg-warning text-dark
                                            @elseif ($project->status === 'In Progress') bg-primary
                                            @else bg-secondary
                                            @endif">{{ $project->status }}</span>
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <a href="{{ route('employee.projects.show', $project) }}" class="btn btn-sm btn-outline-success action-btn" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No projects yet. Projects are
                                        created automatically once a client's approved quotation has its contract
                                        confirmed.</td>
                                </tr>
                            @endforelse
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
            const table = $('#projectsTable').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [5, 7]
                }],
                language: {
                    emptyTable: 'No projects found.',
                    zeroRecords: 'No matching projects found.'
                }
            });

            document.getElementById('statusFilterGroup').addEventListener('click', function(event) {
                const btn = event.target.closest('[data-filter]');
                if (!btn) return;
                this.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                table.column(6).search(filter === 'all' ? '' : filter, false, false).draw();
            });
        });
    </script>
@endsection
