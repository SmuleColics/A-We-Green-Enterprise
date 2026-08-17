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
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-3 mb-4 project-summary-row">
            <div class="col">
                <div class="summary-card h-100">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
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

        <!-- Archived Projects Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Not Started">Not
                        Started</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In
                        Progress</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On
                        Hold</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Completed">Completed</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveProjectsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Project ID</th>
                                <th class="border-0 small green-text">Project</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Amount</th>
                                <th class="border-0 small green-text">Progress</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr data-status="{{ $project->status }}">
                                    <td class="fw-semibold small">{{ $project->reference_number }}</td>
                                    <td class="fw-semibold">{{ $project->project_title }}</td>
                                    <td>{{ $project->quotation->assessment->client->user->full_name }}</td>
                                    <td>{{ $project->service_type }}</td>
                                    <td class="fw-semibold text-success">₱{{ number_format($project->total_budget, 2) }}</td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress hpx-6">
                                                <div class="progress-bar bg-success"
                                                    style="width:{{ $project->taskProgress() }}%"></div>
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
                                    <td class="text-muted small"
                                        data-order="{{ optional($project->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $project->archived_at?->format('M j, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="btn btn-sm btn-outline-success action-btn" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm({{ $project->id }}, {{ Js::from($project->reference_number) }})">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this project?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        Project <strong id="rc-refNo">—</strong> will be moved back to <strong>Projects</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        id="rc-confirm-btn">
                        <span class="material-symbols-outlined fs-15">unarchive</span>
                        Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const ROUTES = {
            unarchive: {{ Js::from(route('projects.unarchive', ['project' => '__ID__'])) }},
        };

        let pendingRestoreId = null;

        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(id, refNo) {
            pendingRestoreId = id;
            document.getElementById('rc-refNo').textContent = refNo;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status,
                    data
                }) => {
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Unable to restore this project.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    restoreConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        $(document).ready(function() {
            const table = $('#archiveProjectsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [7, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 8
                }],
                language: {
                    emptyTable: 'No archived projects yet.',
                    zeroRecords: 'No matching archived projects found.'
                }
            });

            $('#statusFilterGroup button').on('click', function() {
                $('#statusFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                table.column(6).search(filter === 'all' ? '' : filter, false, false).draw();
            });
        });
    </script>
@endsection
