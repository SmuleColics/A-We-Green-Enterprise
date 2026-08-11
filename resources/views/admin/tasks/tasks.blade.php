@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tasks/tasks.css') }}">
@endsection

@section('page-title', 'Tasks')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archivedModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        Archived Tasks
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text" data-bs-toggle="modal"
        data-bs-target="#assignModal">
        <span class="material-symbols-outlined me-1 fs-18">add</span>
        Assign Task
    </button>
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
                        <p class="summary-value" id="cnt-done">{{ $completed ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-secondary summary-icon">assignment</span>
                    <div>
                        <p class="summary-label">To Do</p>
                        <p class="summary-value" id="cnt-todo">{{ $pending ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-primary summary-icon">autorenew</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value" id="cnt-inprogress">{{ $inProgress ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-warning summary-icon">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value" id="cnt-onhold">0</p>
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
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tasksTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task</th>
                                <th class="border-0 small green-text">Assigned To</th>
                                <th class="border-0 small green-text">Assessment</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tasksBody">
                            @forelse($tasks ?? [] as $task)
                                <tr data-status="{{ $task->status }}" data-task-id="{{ $task->id }}">
                                    <td class="fw-semibold">{{ $task->title }}</td>
                                    <td>{{ $task->employee->staff->user->full_name ?? 'N/A' }}</td>
                                    <td class="text-muted small">Assessment #{{ $task->assessment->id }}</td>
                                    <td class="text-muted">{{ $task->due_date->format('M j, Y') }}</td>
                                    <td>{!! $task->status_badge !!}</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            onclick="openView({{ $task->id }})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                            onclick="openEdit({{ $task->id }})">
                                            <span class="material-symbols-outlined icon-action">edit</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Delete"
                                            onclick="deleteTaskConfirm({{ $task->id }})">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <span class="material-symbols-outlined d-block mb-2"
                                            style="font-size:48px;color:#d1d5db;">inbox</span>
                                        No tasks yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <!-- ── View Task Modal ── -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
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
                </div>
            </div>
        </div>
    </div>


    <!-- ── Assign Task Modal ── -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small">Employee <span class="text-danger">*</span></label>
                                <select class="form-select" name="employee_id" id="employeeSelect" required>
                                    <option value="">-- Select Employee --</option>
                                    @forelse($employees ?? [] as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->staff->user->full_name }}
                                            ({{ $employee->position }})
                                        </option>
                                    @empty
                                        <option disabled>No employees available</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Assessment <span class="text-danger">*</span></label>
                                <select class="form-select" name="assessment_id" id="assessmentSelect" disabled required>
                                    <option value="">-- Coming Soon (Projects Feature) --</option>
                                </select>
                                <small class="text-muted">Available once Projects feature is complete</small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="taskTitle"
                                    placeholder="e.g., Install DVR and HDD" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" id="taskDescription" rows="3" placeholder="Task details..."
                                    required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="due_date" id="taskDueDate" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitCreateTask()">
                        <span class="material-symbols-outlined me-1"
                            style="font-size:16px;vertical-align:middle;">assignment_ind</span>
                        Create Task
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Task Modal ── -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        @csrf
                        <input type="hidden" id="editTaskId">
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label class="form-label small">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editTaskTitle" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="editTaskDescription" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="editTaskDueDate" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitEditTask()">
                        <span class="material-symbols-outlined me-1"
                            style="font-size:16px;vertical-align:middle;">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Delete Confirm Modal ── -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Delete Task?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">This task will be permanently deleted. This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn"
                        onclick="confirmDelete()">
                        <span class="material-symbols-outlined me-1"
                            style="font-size:14px;vertical-align:middle;">delete</span>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archived Tasks Modal ── -->
    <div class="modal fade" id="archivedModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">inventory_2</span>
                        <h5 class="modal-title mb-0">Archived Tasks</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted text-center py-3 small">Archive feature coming soon</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let dtTable = null;
        let currentTaskId = null;

        function initTable() {
            if (dtTable) dtTable.destroy();
            dtTable = $('#tasksTable').DataTable({
                pageLength: 25,
                columnDefs: [{
                    orderable: false,
                    targets: 5
                }],
                order: [],
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
            fetch(`/admin/tasks/${taskId}/details`)
                .then(response => response.json())
                .then(data => {
                    const task = data.task;
                    const content = `
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Task Title</p>
                                <p class="fw-semibold mb-0">${task.title}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Assigned To</p>
                                <p class="mb-0">${task.employee.staff.user.full_name}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Assessment</p>
                                <p class="mb-0">Assessment #${task.assessment.id} - ${task.assessment.client.user.full_name}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted small mb-1">Due Date</p>
                                <p class="mb-0">${new Date(task.due_date).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted small mb-1">Status</p>
                                <span class="badge bg-${getStatusBadgeClass(task.status)}">${task.status}</span>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="mb-3">
                            <p class="fw-semibold small text-uppercase section-label">Description</p>
                            <p>${task.description}</p>
                        </div>
                    `;
                    document.getElementById('viewTaskContent').innerHTML = content;
                    new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Failed to load task details');
                });
        }

        function openEdit(taskId) {
            currentTaskId = taskId;
            fetch(`/admin/tasks/${taskId}/details`)
                .then(response => response.json())
                .then(data => {
                    const task = data.task;
                    document.getElementById('editTaskId').value = task.id;
                    document.getElementById('editTaskTitle').value = task.title;
                    document.getElementById('editTaskDescription').value = task.description;
                    document.getElementById('editTaskDueDate').value = task.due_date;
                    new bootstrap.Modal(document.getElementById('editTaskModal')).show();
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Failed to load task');
                });
        }

        function deleteTaskConfirm(taskId) {
            currentTaskId = taskId;
            new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
        }

        function confirmDelete() {
            if (!currentTaskId) return;
            fetch(`/admin/tasks/${currentTaskId}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to delete task'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred');
                });
        }

        function submitCreateTask() {
            const formData = {
                employee_id: document.getElementById('employeeSelect').value,
                assessment_id: document.getElementById('assessmentSelect').value || 1, // Temporary placeholder
                title: document.getElementById('taskTitle').value,
                description: document.getElementById('taskDescription').value,
                due_date: document.getElementById('taskDueDate').value,
            };

            if (!formData.employee_id || !formData.title || !formData.description || !formData.due_date) {
                alert('Please fill in all required fields');
                return;
            }

            fetch('/admin/tasks/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('assignModal')).hide();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to create task'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred');
                });
        }

        function submitEditTask() {
            const taskId = document.getElementById('editTaskId').value;
            const formData = {
                title: document.getElementById('editTaskTitle').value,
                description: document.getElementById('editTaskDescription').value,
                due_date: document.getElementById('editTaskDueDate').value,
            };

            if (!formData.title || !formData.description || !formData.due_date) {
                alert('Please fill in all required fields');
                return;
            }

            fetch(`/admin/tasks/${taskId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to update task'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred');
                });
        }

        function statusBadge(status) {
            const map = {
                'Done': 'bg-success',
                'To Do': 'bg-secondary',
                'In Progress': 'bg-primary',
                'On Hold': 'bg-warning text-dark'
            };
            const cls = map[status] || 'bg-secondary';
            return `<span class="badge rounded-pill ${cls}">${status}</span>`;
        }

        $(document).ready(() => {
            initTable();
        });
    </script>
@endsection
