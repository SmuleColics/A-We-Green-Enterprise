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
                    <span class="material-symbols-outlined text-success summary-icon">check_circle</span>
                    <div>
                        <p class="summary-label">Done</p>
                        <p class="summary-value">{{ $completed ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-warning summary-icon">schedule</span>
                    <div>
                        <p class="summary-label">To Do</p>
                        <p class="summary-value">{{ $pending ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-primary summary-icon">autorenew</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value">{{ $inProgress ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-secondary summary-icon">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value">{{ $onHold ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Tasks Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3">
                    <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active"
                            data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Completed">Done</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Pending">To Do</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In
                            Progress</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="On Hold">On Hold</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="archiveTasksTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task</th>
                                <th class="border-0 small green-text">Assigned To</th>
                                <th class="border-0 small green-text">Assessment</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks ?? [] as $task)
                                <tr data-status="{{ $task->status }}" data-task-id="{{ $task->id }}">
                                    <td class="fw-semibold">{{ $task->title }}</td>
                                    <td>{{ $task->employee->staff->user->full_name ?? 'N/A' }}</td>
                                    <td class="text-muted small">Assessment #{{ $task->assessment->id ?? 'N/A' }}</td>
                                    <td class="text-muted">{{ $task->due_date->format('M j, Y') }}</td>
                                    <td>{!! $task->status_badge !!}</td>
                                    <td class="text-muted small">{{ $task->archived_at?->format('M j, Y') ?? '—' }}</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            onclick="openView({{ $task->id }})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="restoreTaskConfirm({{ $task->id }})">
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


    <!-- ── View Archived Task Modal ── -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Task Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewTaskContent">
                    <!-- Loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1"
                        onclick="restoreTaskConfirm(currentTaskId)">
                        <span class="material-symbols-outlined fs-17">unarchive</span>Restore
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this task?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        This task will be moved back to the active <strong>Tasks</strong> list.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        id="confirmRestoreBtn" onclick="confirmRestore()">
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
        let dtTable = null;
        let currentTaskId = null;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function toastThenReload(message, type = 'success') {
            sessionStorage.setItem('pendingToast', JSON.stringify({
                message,
                type
            }));
            location.reload();
        }

        function initTable() {
            if (dtTable) dtTable.destroy();
            dtTable = $('#archiveTasksTable').DataTable({
                pageLength: 25,
                columnDefs: [{
                    orderable: false,
                    targets: 6
                }],
                order: [
                    [5, 'desc']
                ],
                searching: true
            });
        }

        document.getElementById('statusFilterGroup').addEventListener('click', function(event) {
            const btn = event.target.closest('[data-filter]');
            if (!btn || !dtTable) return;
            this.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            dtTable.column(4).search(filter === 'all' ? '' : filter, false, false).draw();
        });

        function openView(taskId) {
            currentTaskId = taskId;
            fetch(`/admin/tasks/${taskId}/details`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (!data.success || !data.task) throw new Error('Invalid response format');
                    const task = data.task;
                    const content = `
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Task Title</p>
                                <p class="fw-semibold mb-0">${task.title}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Assigned To</p>
                                <p class="mb-0">${task.employee?.staff?.user?.full_name || 'N/A'}</p>
                            </div>
                            <div class="col-sm-12">
                                <p class="text-muted small mb-1">Assessment</p>
                                <p class="mb-0">Assessment #${task.assessment?.id || 'N/A'} - ${task.assessment?.client?.user?.full_name || 'N/A'}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Due Date</p>
                                <p class="mb-0">${new Date(task.due_date).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Status</p>
                                <span class="badge bg-${getStatusBadgeClass(task.status)}">${task.status}</span>
                                ${task.is_auto_completed ? '<span class="badge bg-light text-muted ms-1">Auto-synced</span>' : ''}
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Archived On</p>
                                <p class="mb-0">${task.archived_at ? new Date(task.archived_at).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : '—'}</p>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="mb-3">
                            <p class="fw-semibold small text-uppercase section-label">Description</p>
                            <p class="small">${task.description || 'No description'}</p>
                        </div>
                    `;
                    document.getElementById('viewTaskContent').innerHTML = content;
                    new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToast('Failed to load task details: ' + err.message, 'danger');
                });
        }

        function restoreTaskConfirm(taskId) {
            currentTaskId = taskId;
            bootstrap.Modal.getInstance(document.getElementById('viewTaskModal'))?.hide();
            new bootstrap.Modal(document.getElementById('restoreConfirmModal')).show();
        }

        function confirmRestore() {
            if (!currentTaskId) return;
            fetch(`/admin/tasks/${currentTaskId}/unarchive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('restoreConfirmModal')).hide();
                        toastThenReload(data.message || 'Task restored.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to restore task'), 'danger');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToast('An error occurred', 'danger');
                });
        }

        function getStatusBadgeClass(status) {
            const map = {
                'Completed': 'success',
                'Pending': 'warning text-dark',
                'In Progress': 'primary',
                'On Hold': 'secondary'
            };
            return map[status] || 'secondary';
        }

        $(document).ready(() => {
            initTable();

            const pending = sessionStorage.getItem('pendingToast');
            if (pending) {
                sessionStorage.removeItem('pendingToast');
                try {
                    const {
                        message,
                        type
                    } = JSON.parse(pending);
                    showToast(message, type);
                } catch (e) {
                    console.error('Failed to parse pending toast', e);
                }
            }
        });
    </script>
@endsection
