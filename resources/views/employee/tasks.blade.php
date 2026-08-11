@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/employee/tasks.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

@section('topbar-actions')
    <div class="btn-group filter-btn-group" role="group">
        <button type="button" class="btn btn-sm btn-outline-light active" data-filter="all">All Tasks</button>
        <button type="button" class="btn btn-sm btn-outline-light" data-filter="Pending">Pending</button>
        <button type="button" class="btn btn-sm btn-outline-light" data-filter="In Progress">In Progress</button>
        <button type="button" class="btn btn-sm btn-outline-light" data-filter="Completed">Completed</button>
    </div>
@endsection

<div class="container-fluid px-4 py-4">

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="summary-card">
                <span class="material-symbols-outlined summary-icon green-text">task_alt</span>
                <div>
                    <p class="summary-label">Total Tasks</p>
                    <p class="summary-value">{{ $total ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="summary-card">
                <span class="material-symbols-outlined summary-icon" style="color:#f59e0b;">pending_actions</span>
                <div>
                    <p class="summary-label">Pending</p>
                    <p class="summary-value">{{ $pending ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="summary-card">
                <span class="material-symbols-outlined summary-icon" style="color:#3b82f6;">schedule</span>
                <div>
                    <p class="summary-label">In Progress</p>
                    <p class="summary-value">{{ $inProgress ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="summary-card">
                <span class="material-symbols-outlined summary-icon" style="color:#10b981;">check_circle</span>
                <div>
                    <p class="summary-label">Completed</p>
                    <p class="summary-value">{{ $completed ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if (($tasks ?? []) && count($tasks) > 0)
                <div class="table-responsive">
                    <table id="tasksTable" class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Task ID</th>
                                <th class="border-0">Client / Assessment</th>
                                <th class="border-0">Description</th>
                                <th class="border-0">Due Date</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr data-status="{{ $task->status }}" data-task-id="{{ $task->id }}">
                                    <td class="fw-semibold">#{{ str_pad($task->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div>
                                            <p class="mb-0 fw-semibold">
                                                {{ $task->assessment->client->user->full_name ?? 'N/A' }}</p>
                                            <p class="mb-0 small text-muted">Assessment #{{ $task->assessment->id }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="task-desc-preview" title="{{ $task->description }}">
                                            {{ Str::limit($task->description, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                class="material-symbols-outlined fs-18 @if ($task->is_overdue) text-danger @endif">event</span>
                                            <div>
                                                <p class="mb-0">{{ $task->due_date->format('M j, Y') }}</p>
                                                @if ($task->is_overdue && !$task->isCompleted())
                                                    <p class="mb-0 small text-danger fw-semibold">
                                                        {{ $task->days_until_due }} days overdue</p>
                                                @elseif (!$task->isCompleted())
                                                    <p class="mb-0 small text-muted">{{ $task->days_until_due }} days
                                                        remaining</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $task->status_badge }}">
                                            <span class="material-symbols-outlined"
                                                style="font-size: 14px;">{{ $task->status_icon }}</span>
                                            {{ $task->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-view-task"
                                                data-task-id="{{ $task->id }}" title="View Details">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </button>

                                            @if ($task->isPending())
                                                <button type="button" class="btn btn-outline-info btn-start-task"
                                                    data-task-id="{{ $task->id }}" title="Start Task">
                                                    <span class="material-symbols-outlined">play_arrow</span>
                                                </button>
                                            @endif

                                            @if ($task->isInProgress())
                                                <button type="button" class="btn btn-outline-success btn-complete-task"
                                                    data-task-id="{{ $task->id }}" title="Mark as Complete">
                                                    <span class="material-symbols-outlined">check</span>
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-pause-task"
                                                    data-task-id="{{ $task->id }}" title="Pause Task">
                                                    <span class="material-symbols-outlined">pause</span>
                                                </button>
                                            @endif

                                            @if ($task->isPending() || $task->isInProgress())
                                                <button type="button" class="btn btn-outline-danger btn-decline-task"
                                                    data-task-id="{{ $task->id }}" title="Decline Task">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <span class="material-symbols-outlined" style="font-size: 48px; color: #d1d5db;">inbox</span>
                    <p class="text-muted mt-3">No tasks assigned yet</p>
                </div>
            @endif

        </div>
    </div>

</div>

<!-- Modal: View Task Details -->
<div class="modal fade" id="viewTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="taskDetailsContent">
                    <!-- Loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Update Task Status -->
<div class="modal fade" id="updateTaskStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Update Task Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateTaskStatusForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="taskIdInput" name="task_id">

                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">Status</label>
                        <select id="taskStatus" name="status" class="form-select" required>
                            <option value="">-- Select Status --</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Declined">Declined</option>
                        </select>
                    </div>

                    <div class="mb-3" id="completionNoteContainer" style="display: none;">
                        <label for="completionNote" class="form-label">Completion Notes</label>
                        <textarea id="completionNote" name="notes" class="form-control" rows="3"
                            placeholder="Add any notes about task completion..."></textarea>
                    </div>

                    <div class="mb-3" id="declineReasonContainer" style="display: none;">
                        <label for="declineReason" class="form-label">Reason for Decline</label>
                        <textarea id="declineReason" name="decline_reason" class="form-control" rows="3"
                            placeholder="Why are you declining this task?" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#tasksTable').DataTable({
            responsive: true,
            order: [
                [3, 'asc']
            ], // Sort by due date
            columnDefs: [{
                    orderable: false,
                    targets: [5]
                } // Disable ordering on actions column
            ]
        });

        // Filter by status
        document.querySelectorAll('[data-filter]').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove(
                    'active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                table.column(4).search(filter === 'all' ? '' : filter).draw();
            });
        });

        // View Task Details
        document.querySelectorAll('.btn-view-task').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                loadTaskDetails(taskId);
            });
        });

        // Start Task
        document.querySelectorAll('.btn-start-task').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                updateTaskStatus(taskId, 'In Progress');
            });
        });

        // Complete Task
        document.querySelectorAll('.btn-complete-task').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                updateTaskStatus(taskId, 'Completed');
            });
        });

        // Pause Task
        document.querySelectorAll('.btn-pause-task').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                updateTaskStatus(taskId, 'Pending');
            });
        });

        // Decline Task
        document.querySelectorAll('.btn-decline-task').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                showDeclineModal(taskId);
            });
        });

        // Update status form submission
        document.getElementById('updateTaskStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const taskId = document.getElementById('taskIdInput').value;
            const status = document.getElementById('taskStatus').value;
            const notes = document.getElementById('completionNote').value || null;
            const declineReason = document.getElementById('declineReason').value || null;

            submitTaskStatusUpdate(taskId, status, notes, declineReason);
        });

        // Show/hide fields based on status selection
        document.getElementById('taskStatus').addEventListener('change', function() {
            const status = this.value;
            document.getElementById('completionNoteContainer').style.display =
                status === 'Completed' ? 'block' : 'none';
            document.getElementById('declineReasonContainer').style.display =
                status === 'Declined' ? 'block' : 'none';
        });
    });

    function loadTaskDetails(taskId) {
        fetch(`/tasks/${taskId}/details`)
            .then(response => response.json())
            .then(data => {
                const content = `
                        <div class="task-details-section">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Client Name</p>
                                    <p class="fw-semibold">${data.task.assessment.client.user.full_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Assessment ID</p>
                                    <p class="fw-semibold">#${data.task.assessment.id}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Due Date</p>
                                    <p class="fw-semibold">${new Date(data.task.due_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Status</p>
                                    <span class="badge ${data.task.status_badge}">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">${data.task.status_icon}</span>
                                        ${data.task.status}
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <p class="text-muted small mb-1">Title</p>
                                <p class="fw-semibold">${data.task.title}</p>
                            </div>

                            <div class="mb-3">
                                <p class="text-muted small mb-1">Description</p>
                                <p>${data.task.description || 'No description provided'}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Services</p>
                                    <p>${Array.isArray(data.task.assessment.services) ? data.task.assessment.services.join(', ') : data.task.assessment.services}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Assessment Date</p>
                                    <p>${new Date(data.task.assessment.preferred_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</p>
                                </div>
                            </div>
                        </div>
                    `;
                document.getElementById('taskDetailsContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
            })
            .catch(err => {
                console.error('Error loading task details:', err);
                alert('Failed to load task details');
            });
    }

    function updateTaskStatus(taskId, status) {
        document.getElementById('taskIdInput').value = taskId;
        document.getElementById('taskStatus').value = status;
        document.getElementById('taskStatus').dispatchEvent(new Event('change'));
        new bootstrap.Modal(document.getElementById('updateTaskStatusModal')).show();
    }

    function showDeclineModal(taskId) {
        document.getElementById('taskIdInput').value = taskId;
        document.getElementById('taskStatus').value = 'Declined';
        document.getElementById('taskStatus').dispatchEvent(new Event('change'));
        new bootstrap.Modal(document.getElementById('updateTaskStatusModal')).show();
    }

    function submitTaskStatusUpdate(taskId, status, notes, declineReason) {
        const payload = {
            status: status,
            notes: notes,
            decline_reason: declineReason
        };

        fetch(`/tasks/${taskId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('updateTaskStatusModal')).hide();
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to update task'));
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('An error occurred while updating the task');
            });
    }
</script>
@endsection
