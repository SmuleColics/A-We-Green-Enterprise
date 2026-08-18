@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/employee/tasks.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Tasks')

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
                <span class="material-symbols-outlined text-warning summary-icon muted-text">schedule</span>
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
                <span class="material-symbols-outlined text-secondary summary-icon text-warning">pause_circle</span>
                <div>
                    <p class="summary-label">On Hold</p>
                    <p class="summary-value">{{ $onHold ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Table -->
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
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On
                        Hold</button>
                </div>
            </div>

            @if (($tasks ?? []) && count($tasks) > 0)
                <div class="table-responsive">
                    <table id="tasksTable" class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task ID</th>
                                <th class="border-0 small green-text">Client / Assessment</th>
                                <th class="border-0 small green-text">Description</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
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
                                                        {{ abs($task->days_until_due) }} days overdue</p>
                                                @elseif (!$task->isCompleted())
                                                    <p class="mb-0 small text-muted">{{ $task->days_until_due }} days
                                                        remaining</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{!! $task->status_badge !!}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-success btn-view-task"
                                                data-task-id="{{ $task->id }}" title="View Details">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </button>

                                            @if ($task->isPending())
                                                <button type="button" class="btn btn-outline-info btn-start-task"
                                                    data-task-id="{{ $task->id }}" title="Start Task">
                                                    <span class="material-symbols-outlined icon-action">play_arrow</span>
                                                </button>
                                            @endif

                                            @if ($task->isInProgress())
                                                <button type="button" class="btn btn-outline-success btn-complete-task"
                                                    data-task-id="{{ $task->id }}" title="Mark as Complete">
                                                    <span class="material-symbols-outlined icon-action">check</span>
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-pause-task"
                                                    data-task-id="{{ $task->id }}" title="Pause Task">
                                                    <span class="material-symbols-outlined icon-action">pause</span>
                                                </button>
                                            @endif

                                            @if ($task->isPending() || $task->isInProgress())
                                                <button type="button" class="btn btn-outline-secondary btn-hold-task"
                                                    data-task-id="{{ $task->id }}" title="Put Task On Hold">
                                                    <span class="material-symbols-outlined icon-action">pause_circle</span>
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
                            <option value="On Hold">On Hold</option>
                        </select>
                    </div>

                    <div class="mb-3" id="completionNoteContainer" style="display: none;">
                        <label for="completionNote" class="form-label">Completion Notes</label>
                        <textarea id="completionNote" name="notes" class="form-control" rows="3"
                            placeholder="Add any notes about task completion..."></textarea>
                    </div>

                    <div class="mb-3" id="holdReasonContainer" style="display: none;">
                        <label for="holdReason" class="form-label">Reason for Hold</label>
                        <textarea id="holdReason" name="hold_reason" class="form-control" rows="3"
                            placeholder="Why is this task being put on hold?" required></textarea>
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
    const taskDetailsUrlTemplate = "{{ route('employee.tasks.show', ['task' => '__ID__']) }}";
    const taskUpdateUrlTemplate = "{{ route('employee.tasks.update', ['task' => '__ID__']) }}";

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
            ],
            language: {
                emptyTable: 'No tasks found.',
                zeroRecords: 'No matching tasks found.'
            }
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

        // Put task on hold
        document.querySelectorAll('.btn-hold-task').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                showHoldModal(taskId);
            });
        });

        // Update status form submission
        document.getElementById('updateTaskStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const taskId = document.getElementById('taskIdInput').value;
            const status = document.getElementById('taskStatus').value;
            const notes = document.getElementById('completionNote').value || null;
            const holdReason = document.getElementById('holdReason').value || null;

            submitTaskStatusUpdate(taskId, status, notes, holdReason);
        });

        // Show/hide fields based on status selection
        document.getElementById('taskStatus').addEventListener('change', function() {
            const status = this.value;
            document.getElementById('completionNoteContainer').style.display =
                status === 'Completed' ? 'block' : 'none';

            const isOnHold = status === 'On Hold';
            document.getElementById('holdReasonContainer').style.display = isOnHold ? 'block' : 'none';
            document.getElementById('holdReason').required = isOnHold;
        });
    });

    function loadTaskDetails(taskId) {
        fetch(taskDetailsUrlTemplate.replace('__ID__', taskId))
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
                                    ${data.task.status_badge}
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

    function showHoldModal(taskId) {
        document.getElementById('taskIdInput').value = taskId;
        document.getElementById('taskStatus').value = 'On Hold';
        document.getElementById('taskStatus').dispatchEvent(new Event('change'));
        new bootstrap.Modal(document.getElementById('updateTaskStatusModal')).show();
    }

    function submitTaskStatusUpdate(taskId, status, notes, holdReason) {
        const payload = {
            status: status,
            notes: notes,
            hold_reason: holdReason
        };

        fetch(taskUpdateUrlTemplate.replace('__ID__', taskId), {
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
