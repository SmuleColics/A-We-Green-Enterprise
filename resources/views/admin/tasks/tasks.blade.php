@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tasks/tasks.css') }}">
@endsection

@section('page-title', 'Tasks')

@section('topbar-actions')
    <a href="{{ route('archive-tasks') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">archive</span>
        Archived Tasks
    </a>
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
                    <span class="material-symbols-outlined text-warning summary-icon muted-text">schedule</span>
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
                    <span class="material-symbols-outlined text-secondary summary-icon text-warning">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value" id="cnt-on-hold">{{ $onHold ?? 0 }}</p>
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

                <div class="table-responsive">
                    <table id="tasksTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task</th>
                                <th class="border-0 small green-text">Type</th>
                                <th class="border-0 small green-text">Assigned To</th>
                                <th class="border-0 small green-text">Context</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tasksBody">
                            @forelse($allTasks ?? [] as $task)
                                <tr data-status="{{ $task['status'] }}" data-task-id="{{ $task['id'] }}"
                                    data-task-type="{{ $task['type'] }}">
                                    <td class="fw-semibold">{{ $task['title'] }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ $task['type'] === 'project' ? 'bg-info-subtle text-info' : 'bg-light text-dark border' }}">
                                            {{ $task['type'] === 'project' ? 'Project' : 'Assessment' }}
                                        </span>
                                    </td>
                                    <td>{{ $task['employee_name'] }}</td>
                                    <td class="text-muted small">
                                        <a href="{{ $task['context_url'] }}" class="green-text text-decoration-none fw-semibold">{{ $task['context_label'] }}</a>
                                    </td>
                                    <td class="text-muted">{{ $task['due_date']->format('M j, Y') }}</td>
                                    <td>{!! $task['status_badge'] !!}</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            onclick="openView({{ $task['id'] }}, '{{ $task['type'] }}')">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        @if ($task['type'] === 'assessment')
                                            <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                                onclick="openEdit({{ $task['id'] }})">
                                                <span class="material-symbols-outlined icon-action">edit</span>
                                            </button>
                                        @else
                                            <a href="{{ $task['context_url'] }}" class="btn btn-sm btn-outline-primary action-btn" title="Manage on project page">
                                                <span class="material-symbols-outlined icon-action">open_in_new</span>
                                            </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                            onclick="archiveTaskConfirm({{ $task['id'] }}, '{{ $task['type'] }}')">
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
                    <div class="btn-group w-100 mb-3" role="group">
                        <button type="button" class="btn btn-sm btn-success" id="typeAssessmentBtn" onclick="setAssignType('assessment')">
                            Assessment Task
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" id="typeProjectBtn" onclick="setAssignType('project')">
                            Project Task
                        </button>
                    </div>

                    <!-- ── Assessment Task ── -->
                    <div id="assessmentTaskFields">
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
                                    <select class="form-select" name="assessment_id" id="assessmentSelect" required>
                                        <option value="">-- Select Assessment --</option>
                                        @forelse ($assessments ?? [] as $assessment)
                                            <option value="{{ $assessment->id }}">
                                                #{{ $assessment->id }} — {{ $assessment->client->user->full_name }}
                                                ({{ $assessment->preferred_date->format('M j, Y') }})
                                            </option>
                                        @empty
                                            <option disabled>No assessments available</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-muted small mb-0">
                                        <span class="material-symbols-outlined fs-15" style="vertical-align:middle;">info</span>
                                        Assessors already get a task automatically when an assessment is confirmed.
                                        Use this for extra work on that same assessment, assigned to any
                                        technician or driver — not just the ones already assigned as assessors.
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="taskTitle"
                                        placeholder="e.g., Prepare site photos for the report" required>
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

                    <!-- ── Project Task ── -->
                    <div id="projectTaskFields" class="d-none">
                        <p class="text-muted small mb-3">
                            Project tasks need a role check and an employee-availability check against that
                            project's schedule, so they're created from the project's own page. Pick a project
                            to continue there.
                        </p>
                        <label class="form-label small">Project <span class="text-danger">*</span></label>
                        <select class="form-select" id="goToProjectSelect">
                            <option value="">-- Select Project --</option>
                            @forelse ($projects ?? [] as $project)
                                <option value="{{ route('projects.show', $project) }}?tab=tasks">
                                    {{ $project->reference_number }} — {{ $project->project_title }}
                                </option>
                            @empty
                                <option disabled>No projects available</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="createTaskBtn" onclick="submitCreateTask()">
                        <span class="material-symbols-outlined me-1"
                            style="font-size:16px;vertical-align:middle;">assignment_ind</span>
                        Create Task
                    </button>
                    <button type="button" class="btn btn-success d-none" id="goToProjectBtn" onclick="goToProject()">
                        <span class="material-symbols-outlined me-1"
                            style="font-size:16px;vertical-align:middle;">open_in_new</span>
                        Go to Project
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
                                    <option value="On Hold">On Hold</option>
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

@endsection

@section('scripts')
    <script>
        let dtTable = null;
        let currentTaskId = null;
        let currentTaskType = 'assessment';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const projectTasksData = @json($projectTasksForJs ?? []);

        function goToProject() {
            const url = document.getElementById('goToProjectSelect').value;
            if (!url) { showToast('Please select a project.', 'warning'); return; }
            window.location.href = url;
        }

        function setAssignType(type) {
            const isProject = type === 'project';
            document.getElementById('assessmentTaskFields').classList.toggle('d-none', isProject);
            document.getElementById('projectTaskFields').classList.toggle('d-none', !isProject);
            document.getElementById('createTaskBtn').classList.toggle('d-none', isProject);
            document.getElementById('goToProjectBtn').classList.toggle('d-none', !isProject);
            document.getElementById('typeAssessmentBtn').classList.toggle('btn-success', !isProject);
            document.getElementById('typeAssessmentBtn').classList.toggle('btn-outline-success', isProject);
            document.getElementById('typeProjectBtn').classList.toggle('btn-success', isProject);
            document.getElementById('typeProjectBtn').classList.toggle('btn-outline-success', !isProject);
        }

        document.getElementById('assignModal').addEventListener('hidden.bs.modal', () => setAssignType('assessment'));

        // Fires a toast, then reloads — stashes the message so it survives the reload.
        function toastThenReload(message, type = 'success') {
            sessionStorage.setItem('pendingToast', JSON.stringify({
                message,
                type
            }));
            location.reload();
        }

        function initTable() {
            if (dtTable) dtTable.destroy();
            dtTable = $('#tasksTable').DataTable({
                pageLength: 25,
                columnDefs: [{
                    orderable: false,
                    targets: 6
                }],
                order: [],
                searching: true,
                language: {
                    emptyTable: 'No tasks found.',
                    zeroRecords: 'No matching tasks found.'
                }
            });
        }

        document.getElementById('statusFilterGroup').addEventListener('click', function(event) {
            const btn = event.target.closest('[data-filter]');
            if (!btn || !dtTable) return;
            this.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            dtTable.column(5).search(filter === 'all' ? '' : filter, false, false).draw();
        });

        function openView(taskId, type = 'assessment') {
            currentTaskId = taskId;
            currentTaskType = type;

            if (type === 'project') {
                const task = projectTasksData.find(t => t.id === taskId);
                if (!task) return;
                const content = `
                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <p class="text-muted small mb-1">Task Title</p>
                            <p class="fw-semibold mb-0">${task.title}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted small mb-1">Assigned To</p>
                            <p class="mb-0">${task.employee_name}</p>
                        </div>
                        <div class="col-sm-12">
                            <p class="text-muted small mb-1">Project</p>
                            <p class="mb-0"><a href="${task.project_url}">${task.project_label}</a></p>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted small mb-1">Required Role</p>
                            <p class="mb-0 text-capitalize">${task.required_position.replace('_', '/')}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted small mb-1">Dates</p>
                            <p class="mb-0">${task.start_date} – ${task.due_date}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted small mb-1">Status</p>
                            <span class="badge bg-${getStatusBadgeClass(task.status)}">${task.status}</span>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted small mb-1">Progress</p>
                            <p class="mb-0">${task.progress}%</p>
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
                return;
            }

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

        function openEdit(taskId) {
            currentTaskId = taskId;
            currentTaskType = 'assessment';
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
                    showToast('Failed to load task: ' + err.message, 'danger');
                });
        }

        function archiveTaskConfirm(taskId, type = 'assessment') {
            currentTaskId = taskId;
            currentTaskType = type;
            new bootstrap.Modal(document.getElementById('archiveConfirmModal')).show();
        }

        function confirmArchive() {
            if (!currentTaskId) return;

            const url = currentTaskType === 'project'
                ? `/project-tasks/${currentTaskId}/archive`
                : `/admin/tasks/${currentTaskId}/archive`;
            const method = currentTaskType === 'project' ? 'PATCH' : 'POST';

            fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('archiveConfirmModal')).hide();
                        toastThenReload(data.message || 'Task archived.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to archive task'), 'danger');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToast('An error occurred', 'danger');
                });
        }

        function submitCreateTask() {
            const formData = {
                employee_id: document.getElementById('employeeSelect').value,
                assessment_id: document.getElementById('assessmentSelect').value,
                title: document.getElementById('taskTitle').value,
                description: document.getElementById('taskDescription').value,
                due_date: document.getElementById('taskDueDate').value,
            };

            if (!formData.employee_id || !formData.assessment_id || !formData.title || !formData.description || !formData.due_date) {
                showToast('Please fill in all required fields', 'warning');
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
                        toastThenReload(data.message || 'Task created.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to create task'), 'danger');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToast('An error occurred', 'danger');
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
                showToast('Please fill in all required fields', 'warning');
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
                        toastThenReload(data.message || 'Task updated.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to update task'), 'danger');
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

            // Show any toast that was stashed before a reload (see toastThenReload).
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
