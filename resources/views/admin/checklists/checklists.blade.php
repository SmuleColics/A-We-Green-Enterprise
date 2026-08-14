@extends('layouts.admin')

@section('title', 'Checklists')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/checklists/checklists.css') }}">
@endsection

@section('page-title', 'Checklists')

@section('topbar-actions')
    <a href="{{ route('archive-checklists') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">checklist</span>
                    <div>
                        <p class="summary-label">Total Checklists</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">task_alt</span>
                    <div>
                        <p class="summary-label">Completed</p>
                        <p class="summary-value">{{ $completed }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">pending_actions</span>
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
        </div>

        <!-- Checklists Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="btn-group filter-btn-group mb-3" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Completed">Completed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In
                        Progress</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                </div>

                <div class="table-responsive">
                    <table id="checklistsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Checklist</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Progress</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                @php
                                    $progress = $project->checklistProgress();
                                    $checklistStatus = $project->status === 'On Hold' ? 'On Hold' : ($progress === 100 ? 'Completed' : 'In Progress');
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $project->project_title }}
                                        @if ($project->returnedItems()->isNotEmpty())
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle fs-11"
                                                title="{{ $project->returnedItems()->count() }} item(s) returned">
                                                <span class="material-symbols-outlined" style="font-size:11px;vertical-align:middle;">assignment_return</span>
                                                {{ $project->returnedItems()->count() }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $project->quotation->assessment->client->user->full_name }}</td>
                                    <td>{{ $project->service_type }}</td>
                                    <td data-order="{{ $project->start_date->format('Y-m-d') }}">{{ $project->start_date->format('M j, Y') }}</td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress hpx-6">
                                                <div class="progress-bar {{ $progress === 100 ? 'bg-success' : 'bg-primary' }}" style="width:{{ $progress }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $progress }}%</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill
                                            @if ($checklistStatus === 'Completed') bg-success
                                            @elseif ($checklistStatus === 'On Hold') bg-warning text-dark
                                            @else bg-primary
                                            @endif">{{ $checklistStatus }}</span>
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <a href="{{ route('checklists.edit', $project) }}" class="btn btn-sm btn-outline-success action-btn" title="View / Edit Checklist">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                        <a target="_blank" href="{{ route('checklists.print', $project) }}" class="btn btn-sm btn-outline-secondary action-btn" title="Preview PDF">
                                            <span class="material-symbols-outlined icon-action">print</span>
                                        </a>
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                            onclick="archiveChecklistConfirm({{ $project->id }})">
                                            <span class="material-symbols-outlined icon-action">archive</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No checklists yet. A checklist is
                                        generated automatically for every new project.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <!-- ── Archive Confirm Modal ── -->
    <div class="modal fade" id="archiveChecklistConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Archive Checklist?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">This will archive the checklist's project. You can restore it
                        anytime from <strong>Archived Projects</strong>.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        id="confirmArchiveChecklistBtn" onclick="confirmArchiveChecklist()">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let currentArchiveChecklistProjectId = null;

        function archiveChecklistConfirm(projectId) {
            currentArchiveChecklistProjectId = projectId;
            new bootstrap.Modal(document.getElementById('archiveChecklistConfirmModal')).show();
        }

        function confirmArchiveChecklist() {
            if (!currentArchiveChecklistProjectId) return;
            fetch(`/projects/${currentArchiveChecklistProjectId}/archive`, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(res => res.json())
                .then(data => {
                    bootstrap.Modal.getInstance(document.getElementById('archiveChecklistConfirmModal')).hide();
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        }

        $(document).ready(function() {
            const table = $('#checklistsTable').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: 6
                }]
            });

            document.getElementById('statusFilterGroup').addEventListener('click', function(event) {
                const btn = event.target.closest('[data-filter]');
                if (!btn) return;
                this.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                table.column(5).search(filter === 'all' ? '' : filter, false, false).draw();
            });
        });
    </script>
@endsection
