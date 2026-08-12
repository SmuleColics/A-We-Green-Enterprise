@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tasks/tasks.css') }}">
@endsection

@section('page-title', 'Tasks')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archivedModal">
        <span class="material-symbols-outlined fs-17">archive</span>
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
                    <span class="material-symbols-outlined text-warning summary-icon">schedule</span>
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
                    <span class="material-symbols-outlined text-danger summary-icon">cancel</span>
                    <div>
                        <p class="summary-label">Declined</p>
                        <p class="summary-value" id="cnt-declined">{{ $declined ?? 0 }}</p>
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
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Declined">Declined</button>
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
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                            onclick="archiveTaskConfirm({{ $task->id }})">
                                            <span class="material-symbols-outlined icon-action">archive</span>
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


    <!-- ── View Task Modal ── -->
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
                </div>
            </div>
        </div>
    </div>


    <!-- ── Assign Task Modal ── -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
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
                                <textarea class="form-control" name="description" id="taskDescription" rows="2" placeholder="Task details..."
                                    required></textarea>
                            </div>
                            <div class="col-md-12">
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
        <div class="modal-dialog modal-dialog-centered modal-md">
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
                                <textarea class="form-control" id="editTaskDescription" rows="2" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="editTaskDueDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="editTaskStatus" required>
                                    <option value="Pending">To Do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Done</option>
                                    <option value="Declined">Declined</option>
                                </select>
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


    <!-- ── Archive Confirm Modal ── -->
    <div class="modal fade" id="archiveConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Archive this task?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        This task will be moved to the archive. You can restore it anytime from
                        <strong>Archived Tasks</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        id="confirmArchiveBtn" onclick="confirmArchive()">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archived Tasks Modal ── -->
    <div class="modal fade" id="archivedModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">archive</span>
                        <h5 class="modal-title mb-0">Archived Tasks</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="archivedTasksBody">
                        <p class="text-muted text-center py-3 small">Loading...</p>
                    </div>
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
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

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
                    alert('Failed to load task details: ' + err.message);
                });
        }

        function openEdit(taskId) {
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
                    document.getElementById('editTaskId').value = task.id;
                    document.getElementById('editTaskTitle').value = task.title;
                    document.getElementById('editTaskDescription').value = task.description;
                    document.getElementById('editTaskDueDate').value = task.due_date;
                    document.getElementById('editTaskStatus').value = task.status;
                    new bootstrap.Modal(document.getElementById('editTaskModal')).show();
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Failed to load task: ' + err.message);
                });
        }

        function archiveTaskConfirm(taskId) {
            currentTaskId = taskId;
            new bootstrap.Modal(document.getElementById('archiveConfirmModal')).show();
        }

        function confirmArchive() {
            if (!currentTaskId) return;
            fetch(`/admin/tasks/${currentTaskId}/archive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('archiveConfirmModal')).hide();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to archive task'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred');
                });
        }

        function loadArchivedTasks() {
            const body = document.getElementById('archivedTasksBody');
            body.innerHTML = '<p class="text-muted text-center py-3 small">Loading...</p>';

            fetch('/admin/tasks/archived', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success || !data.tasks.length) {
                        body.innerHTML = '<p class="text-muted text-center py-3 small">No archived tasks.</p>';
                        return;
                    }

                    const rows = data.tasks.map(t => `
                        <tr>
                            <td class="fw-semibold small">${t.title}</td>
                            <td class="small">${t.employee_name}</td>
                            <td>${t.status_badge}</td>
                            <td class="text-muted small">${t.due_date}</td>
                            <td class="text-muted small">${t.archived_at ?? '—'}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-success" title="Restore" onclick="restoreTask(${t.id})">
                                    <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle;">restore</span>
                                </button>
                            </td>
                        </tr>
                    `).join('');

                    body.innerHTML = `
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th>Task</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Archived On</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>`;
                })
                .catch(err => {
                    console.error('Error:', err);
                    body.innerHTML = '<p class="text-danger text-center py-3 small">Failed to load archived tasks.</p>';
                });
        }

        function restoreTask(taskId) {
            fetch(`/admin/tasks/${taskId}/unarchive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to restore task'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred');
                });
        }

        document.getElementById('archivedModal').addEventListener('show.bs.modal', loadArchivedTasks);

        function submitCreateTask() {
            const formData = {
                employee_id: document.getElementById('employeeSelect').value,
                assessment_id: document.getElementById('assessmentSelect').value || 1,
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
                        'X-CSRF-TOKEN': CSRF_TOKEN
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
                status: document.getElementById('editTaskStatus').value,
            };

            if (!formData.title || !formData.description || !formData.due_date || !formData.status) {
                alert('Please fill in all required fields');
                return;
            }

            fetch(`/admin/tasks/${taskId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
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

        function getStatusBadgeClass(status) {
            const map = {
                'Completed': 'success',
                'Pending': 'warning text-dark',
                'In Progress': 'primary',
                'Declined': 'danger'
            };
            return map[status] || 'secondary';
        }

        $(document).ready(() => {
            initTable();
        });
    </script>
@endsection
