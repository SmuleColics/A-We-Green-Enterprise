@extends('layouts.admin')

@section('title', 'Project Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/projects/monitoring.css') }}">
@endsection

@section('page-title', 'Project Details')

@section('topbar-actions')
    <a href="{{ route('projects') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Projects
    </a>
@endsection

@section('content')

    @php
        $quotation = $project->quotation;
        $client = $quotation->assessment->client;

        $projectTasksForJs = $project->activeTasks()->map(function ($t) {
            return [
                'id' => $t->id,
                'title' => $t->title,
                'description' => $t->description,
                'required_position' => $t->required_position,
                'status' => $t->status,
                'start_date' => $t->start_date->toDateString(),
                'due_date' => $t->due_date->toDateString(),
                'employee_id' => $t->employee_id,
                'checklist_items' => $t->checklistItems->map(function ($i) {
                    return [
                        'id' => $i->id,
                        'name' => $i->name,
                        'total_quantity' => rtrim(rtrim($i->total_quantity, '0'), '.'),
                        'completed_quantity' => rtrim(rtrim($i->completed_quantity, '0'), '.'),
                    ];
                })->values(),
            ];
        })->values();
    @endphp

    <div class="container-fluid px-4 py-4">

        <!-- Project Header Card -->
        <div class="detail-card mb-4">
            <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-3 mb-3">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h4 class="fw-bold mb-0">{{ $project->project_title }}</h4>
                        <span class="badge rounded-pill
                            @if ($project->status === 'Completed') bg-success-subtle text-success border border-success-subtle
                            @elseif ($project->status === 'On Hold') bg-warning-subtle text-warning border border-warning-subtle
                            @elseif ($project->status === 'In Progress') bg-primary-subtle text-primary border border-primary-subtle
                            @else bg-secondary-subtle text-secondary border border-secondary-subtle
                            @endif">{{ $project->status }}</span>
                    </div>
                    <p class="text-muted small mb-1">
                        <span class="material-symbols-outlined text-muted" style="font-size:14px;vertical-align:middle;">person</span>
                        {{ $client->user->full_name }}
                        @if ($project->location)
                            &nbsp;—&nbsp;
                            <span class="material-symbols-outlined text-muted" style="font-size:14px;vertical-align:middle;">location_on</span>
                            {{ $project->location }}
                        @endif
                    </p>
                    <p class="text-muted small mb-0">
                        <span class="service-badge badge-green me-2">{{ $project->service_type }}</span>
                        {{ $project->reference_number }} &nbsp;—&nbsp; Started {{ $project->start_date->format('M j, Y') }}
                        @if ($project->end_date)
                            &nbsp;—&nbsp; Due {{ $project->end_date->format('M j, Y') }}
                        @endif
                    </p>
                </div>
                <div class="text-md-end flex-shrink-0">
                    <p class="text-muted small mb-0">Total Budget</p>
                    <p class="fw-bold text-success mb-0">₱{{ number_format($project->total_budget, 2) }}</p>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="small fw-semibold text-muted">Project Progress</span>
                    <span class="fw-bold text-success">{{ $project->taskProgress() }}%</span>
                </div>
                <div class="progress" style="height:8px;border-radius:8px;">
                    <div class="progress-bar bg-success" style="width:{{ $project->taskProgress() }}%;border-radius:8px;"></div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ \Illuminate\Support\Facades\Storage::url($quotation->contract_file) }}" target="_blank"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">description</span>
                    View Contract File
                </a>
                <a href="{{ route('assessments.form.edit', $quotation->assessment) }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">assignment</span>
                    View Assessment
                </a>
                <a href="{{ route('quotations.show', $quotation) }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">request_quote</span>
                    View Quotation
                </a>
                <a href="{{ route('checklists.edit', $project) }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">checklist</span>
                    View Checklist
                </a>
                <button type="button" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1 ms-auto"
                    data-bs-toggle="modal" data-bs-target="#editProjectModal">
                    <span class="material-symbols-outlined fs-17">edit</span>
                    Edit Project
                </button>
            </div>
        </div>

        @php
            $activeTasks = $project->activeTasks();
            $assignedEmployees = $activeTasks->pluck('employee')->filter()->unique('id')->values();
        @endphp

        <div class="detail-card mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <h6 class="fw-semibold mb-0 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined fs-18 text-success">group</span>
                    Assigned Employees
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#viewTasksModal">
                        <span class="material-symbols-outlined fs-15">task_alt</span>
                        View Project Tasks ({{ $activeTasks->count() }})
                    </button>
                    <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1"
                        onclick="openAddTaskModal()">
                        <span class="material-symbols-outlined fs-15">add</span>
                        Add Task
                    </button>
                </div>
            </div>
            @if ($assignedEmployees->isEmpty())
                <p class="text-muted small fst-italic mb-0">No employees assigned yet — add a task to assign
                    someone.</p>
            @else
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($assignedEmployees as $employee)
                        <span class="team-chip">
                            <span class="team-chip-avatar">{{ strtoupper(substr($employee->full_name, 0, 1)) }}</span>
                            {{ $employee->full_name }}
                            <span class="text-muted small">({{ ucfirst(str_replace('_', '/', $employee->position)) }})</span>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="detail-card mt-4">
            <h6 class="fw-semibold mb-4 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-success" style="font-size:20px;">timeline</span>
                Project Updates
            </h6>

            <form method="POST" action="{{ route('project-updates.store', $project) }}" enctype="multipart/form-data"
                class="compose-box mb-4">
                @csrf
                <div class="compose-inner">
                    <div class="update-avatar me-3 flex-shrink-0">{{ strtoupper(substr(Auth::user()->full_name, 0, 2)) }}</div>
                    <div class="flex-grow-1">
                        <textarea name="body" class="form-control compose-textarea" rows="2"
                            placeholder="Post an update about this project..." id="updateText" required>{{ old('body') }}</textarea>
                        <div class="d-flex flex-wrap gap-2 mt-2" id="imagePreviewStrip"></div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 mb-0" style="cursor:pointer;">
                                <span class="material-symbols-outlined fs-17">image</span>
                                Attach Image
                                <input type="file" name="images[]" accept="image/*" multiple class="d-none"
                                    id="updateImageInput" onchange="previewUpdateImages(this)">
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small" id="imageCount"></span>
                                <button type="submit" class="btn btn-sm btn-success px-3 d-flex align-items-center gap-1">
                                    <span class="material-symbols-outlined fs-17">send</span>
                                    Post Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if ($project->updates->isEmpty())
                <p class="text-muted small fst-italic mb-0">No updates posted yet.</p>
            @else
                <div class="timeline">
                    @foreach ($project->updates as $update)
                        <div class="timeline-item {{ $loop->last ? 'last' : '' }}">
                            <div class="tl-left">
                                <div class="tl-dot"></div>
                                @if (! $loop->last)
                                    <div class="tl-line"></div>
                                @endif
                            </div>
                            <div class="tl-body">
                                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                    <div class="update-avatar sm">{{ strtoupper(substr($update->user->full_name, 0, 2)) }}</div>
                                    <span class="small fw-semibold">{{ $update->user->full_name }}</span>
                                    <span class="text-muted small">·</span>
                                    <span class="text-muted small">{{ $update->created_at->format('M j, Y · g:i A') }}</span>
                                </div>
                                <p class="small mb-2">{{ $update->body }}</p>
                                @if (! empty($update->images))
                                    <div class="update-images">
                                        @foreach ($update->images as $image)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($image) }}" class="update-thumb" alt="Update image"
                                                onclick="openLightbox(this.src)" data-bs-toggle="modal" data-bs-target="#lightboxModal">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>


    <!-- ── Lightbox Modal ── -->
    <div class="modal fade" id="lightboxModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0 py-2 px-3">
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center pt-0 pb-4 px-4">
                    <img id="lightboxImg" src="" class="img-fluid rounded" style="max-height:75vh;" alt="Update image">
                </div>
            </div>
        </div>
    </div>


    <!-- ── View Project Tasks Modal ── -->
    <div class="modal fade" id="viewTasksModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-success fs-22">task_alt</span>
                        Project Tasks
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($activeTasks->isEmpty())
                        <p class="text-muted small fst-italic mb-0">No tasks yet. Add one to start tracking work and
                            assigning employees.</p>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach ($activeTasks as $task)
                                <div class="task-item-card {{ $task->status === 'Completed' ? 'status-done' : ($task->status === 'In Progress' ? 'status-inprogress' : ($task->status === 'On Hold' ? 'status-onhold' : '')) }}">
                                    <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
                                        <div>
                                            <p class="task-item-title mb-1">{{ $task->title }}</p>
                                            <p class="text-muted small mb-0">
                                                {{ $task->start_date->format('M j') }} – {{ $task->due_date->format('M j, Y') }}
                                                &nbsp;·&nbsp;
                                                {{ $task->employee ? $task->employee->full_name : 'Unassigned' }}
                                                &nbsp;·&nbsp;
                                                <span class="text-capitalize">{{ str_replace('_', '/', $task->required_position) }}</span>
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                            <span class="badge rounded-pill
                                                @if ($task->status === 'Completed') bg-success
                                                @elseif ($task->status === 'On Hold') bg-warning text-dark
                                                @elseif ($task->status === 'In Progress') bg-primary
                                                @else bg-secondary
                                                @endif">{{ $task->status }}</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="openEditTaskModal({{ $task->id }})">
                                                <span class="material-symbols-outlined" style="font-size:15px;vertical-align:middle;">edit</span>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="archiveTaskConfirm({{ $task->id }}, {{ Js::from($task->title) }})">
                                                <span class="material-symbols-outlined" style="font-size:15px;vertical-align:middle;">delete</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <div class="progress flex-grow-1" style="height:6px;border-radius:8px;">
                                            <div class="progress-bar bg-success" style="width:{{ $task->progress() }}%;border-radius:8px;"></div>
                                        </div>
                                        <small class="text-muted">{{ $task->progress() }}%</small>
                                    </div>

                                    @if ($task->checklistItems->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                            @foreach ($task->checklistItems as $item)
                                                <span class="small text-muted">{{ rtrim(rtrim($item->completed_quantity, '0'), '.') }}/{{ rtrim(rtrim($item->total_quantity, '0'), '.') }} {{ $item->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                        onclick="openAddTaskModal()">
                        <span class="material-symbols-outlined fs-15">add</span>
                        Add Task
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archive Task Confirm Modal ── -->
    <div class="modal fade" id="archiveTaskConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Remove this task?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">"<span id="archiveTaskTitle"></span>" will be archived and removed
                        from this project's active task list.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        onclick="confirmArchiveTask()">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Add / Edit Task Modal ── -->
    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="taskForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="task-method" value="POST">
                    <input type="hidden" name="task_id" id="task-id-field" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalTitle">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="task-form-error" class="alert alert-danger py-2 small d-none"></div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small">Task Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="task-title" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Description</label>
                                <input type="text" name="description" id="task-description" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Required Role <span class="text-danger">*</span></label>
                                <select name="required_position" id="task-required-position" class="form-select" required>
                                    <option value="technician">Technician</option>
                                    <option value="driver">Driver</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Status</label>
                                <select name="status" id="task-status" class="form-select">
                                    <option value="Pending">To Do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="On Hold">On Hold</option>
                                    <option value="Completed">Done</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="task-start" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                                <input type="date" name="due_date" id="task-due" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Assign to Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="task-employee" class="form-select" required>
                                <option value="">— Select employee —</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" data-position="{{ $employee->position }}">
                                        {{ $employee->full_name }} ({{ ucfirst(str_replace('_', '/', $employee->position)) }})
                                    </option>
                                @endforeach
                            </select>
                            <div id="task-availability-note" class="mt-2 small"></div>
                        </div>

                        <div class="assign-guidance mb-2">
                            <p class="small fw-semibold mb-1">Task Checklist</p>
                            <p class="small text-muted mb-0">Work steps for this task. Track progress by quantity — e.g.
                                "Mount Cameras", total 16, completed 10 — rather than one row per unit.</p>
                        </div>
                        <div class="table-responsive mb-2">
                            <table class="table table-sm mb-0" id="task-checklist-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Work Step</th>
                                        <th class="w-145">Total Qty</th>
                                        <th class="w-145">Completed Qty</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="task-checklist-body"></tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success" id="task-add-checklist-row">Add
                            Work Step</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1" id="task-save-btn">
                            <span class="material-symbols-outlined fs-17">save</span>
                            <span id="task-save-label">Add Task</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ── Edit Project Modal ── -->
    <div class="modal fade" id="editProjectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <p class="small text-danger mb-3">{{ $errors->first() }}</p>
                        @endif
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Not Started" @selected($project->status === 'Not Started')>Not Started</option>
                                    <option value="In Progress" @selected($project->status === 'In Progress')>In Progress</option>
                                    <option value="On Hold" @selected($project->status === 'On Hold')>On Hold</option>
                                    <option value="Completed" @selected($project->status === 'Completed')>Completed</option>
                                </select>
                                <p class="form-text small mb-0">Not Started/In Progress/Completed are normally set
                                    automatically from task progress — use this to override, or to place the project
                                    On Hold.</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ $project->start_date->toDateString() }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Target End Date</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ $project->end_date?->toDateString() }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-17">save</span>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function previewUpdateImages(input) {
            const strip = document.getElementById('imagePreviewStrip');
            const count = document.getElementById('imageCount');
            strip.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-thumb';
                    strip.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
            const n = input.files.length;
            count.textContent = n > 0 ? `${n} image${n > 1 ? 's' : ''} selected` : '';
        }

        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
        }

        const projectTasksData = @json($projectTasksForJs);

        const storeTaskUrl = '{{ route('project-tasks.store', $project) }}';
        function updateTaskUrl(id) { return `/project-tasks/${id}`; }

        let checklistRowIndex = 0;

        function addChecklistRow(name = '', total = '', completed = '', id = null) {
            const tbody = document.getElementById('task-checklist-body');
            const idx = checklistRowIndex++;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    ${id ? `<input type="hidden" name="checklist_items[${idx}][id]" value="${id}">` : ''}
                    <input type="text" name="checklist_items[${idx}][name]" class="form-control form-control-sm" value="${name}" placeholder="e.g. Mount Cameras" required>
                </td>
                <td><input type="number" step="0.01" min="0.01" name="checklist_items[${idx}][total_quantity]" class="form-control form-control-sm" value="${total}" required></td>
                <td><input type="number" step="0.01" min="0" name="checklist_items[${idx}][completed_quantity]" class="form-control form-control-sm" value="${completed}"></td>
                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">&times;</button></td>
            `;
            tbody.appendChild(row);
        }

        document.getElementById('task-add-checklist-row').addEventListener('click', () => addChecklistRow());

        function resetTaskForm() {
            document.getElementById('taskForm').reset();
            document.getElementById('task-checklist-body').innerHTML = '';
            checklistRowIndex = 0;
            document.getElementById('task-form-error').classList.add('d-none');
            document.getElementById('task-form-error').innerHTML = '';
            document.getElementById('task-availability-note').innerHTML = '';
            document.getElementById('task-id-field').value = '';
        }

        // ── Stacking helper: the task modals can be opened from inside the "View Project
        // Tasks" modal, so hide it first and reopen it once the nested modal closes ──
        let reopenViewTasksModal = false;

        function hideViewTasksModalIfOpen() {
            const el = document.getElementById('viewTasksModal');
            const instance = bootstrap.Modal.getInstance(el);
            if (instance) {
                reopenViewTasksModal = true;
                instance.hide();
            }
        }

        function openAddTaskModal() {
            hideViewTasksModalIfOpen();
            resetTaskForm();
            document.getElementById('taskModalTitle').textContent = 'Add Task';
            document.getElementById('task-save-label').textContent = 'Add Task';
            document.getElementById('taskForm').action = storeTaskUrl;
            document.getElementById('task-method').value = 'POST';
            new bootstrap.Modal(document.getElementById('taskModal')).show();
        }

        function fillTaskForm(data) {
            document.getElementById('task-title').value = data.title || '';
            document.getElementById('task-description').value = data.description || '';
            document.getElementById('task-required-position').value = data.required_position || 'technician';
            document.getElementById('task-status').value = data.status || 'Pending';
            document.getElementById('task-start').value = data.start_date || '';
            document.getElementById('task-due').value = data.due_date || '';
            document.getElementById('task-employee').value = data.employee_id || '';
            (data.checklist_items || []).forEach(item => addChecklistRow(item.name, item.total_quantity, item.completed_quantity, item.id));
        }

        function openEditTaskModal(taskId) {
            hideViewTasksModalIfOpen();
            resetTaskForm();
            const task = projectTasksData.find(t => t.id === taskId);
            if (!task) return;
            document.getElementById('taskModalTitle').textContent = 'Edit Task';
            document.getElementById('task-save-label').textContent = 'Save Changes';
            document.getElementById('taskForm').action = updateTaskUrl(taskId);
            document.getElementById('task-method').value = 'PUT';
            document.getElementById('task-id-field').value = taskId;
            fillTaskForm(task);
            checkAvailability(taskId);
            new bootstrap.Modal(document.getElementById('taskModal')).show();
        }

        function checkAvailability(ignoreTaskId = null) {
            const empId = document.getElementById('task-employee').value;
            const start = document.getElementById('task-start').value;
            const end = document.getElementById('task-due').value;
            const position = document.getElementById('task-required-position').value;
            const note = document.getElementById('task-availability-note');

            if (!empId || !start || !end) { note.innerHTML = ''; return; }

            let url = `/employees/${empId}/availability?start=${start}&end=${end}&required_position=${position}`;
            if (ignoreTaskId) url += `&ignore_project_task_id=${ignoreTaskId}`;

            note.innerHTML = '<span class="text-muted">Checking availability…</span>';

            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.qualifies === false) {
                        html += `<div class="text-danger">✕ This employee's role doesn't match the required position for this task.</div>`;
                    }
                    if (data.available) {
                        html += `<div class="text-success">✓ Available for this date range.</div>`;
                    } else {
                        const c = data.conflicts[0];
                        html += `<div class="text-danger">✕ Unavailable — conflicts with "${c.title}" (${c.type}${c.context ? ', ' + c.context : ''}) ${c.start} to ${c.end}.</div>`;
                    }
                    note.innerHTML = html;
                })
                .catch(() => { note.innerHTML = '<span class="text-muted">Could not check availability.</span>'; });
        }

        ['task-employee', 'task-start', 'task-due', 'task-required-position'].forEach(id => {
            document.getElementById(id).addEventListener('change', () => {
                const editingId = document.getElementById('task-method').value === 'PUT'
                    ? parseInt(document.getElementById('task-id-field').value)
                    : null;
                checkAvailability(editingId);
            });
        });

        // Reopen the "View Project Tasks" modal once the task modal closes, unless the
        // page is about to navigate away (form submit / validation redirect handles that itself)
        document.getElementById('taskModal').addEventListener('hidden.bs.modal', () => {
            if (reopenViewTasksModal) {
                reopenViewTasksModal = false;
                new bootstrap.Modal(document.getElementById('viewTasksModal')).show();
            }
        });

        let currentArchiveTaskId = null;

        function archiveTaskConfirm(id, title) {
            hideViewTasksModalIfOpen();
            currentArchiveTaskId = id;
            document.getElementById('archiveTaskTitle').textContent = title;
            new bootstrap.Modal(document.getElementById('archiveTaskConfirmModal')).show();
        }

        document.getElementById('archiveTaskConfirmModal').addEventListener('hidden.bs.modal', () => {
            if (reopenViewTasksModal) {
                reopenViewTasksModal = false;
                new bootstrap.Modal(document.getElementById('viewTasksModal')).show();
            }
        });

        function confirmArchiveTask() {
            if (!currentArchiveTaskId) return;
            reopenViewTasksModal = false; // page will reload — no need to reopen anything
            fetch(`/project-tasks/${currentArchiveTaskId}/archive`, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(res => res.json())
                .then(data => {
                    bootstrap.Modal.getInstance(document.getElementById('archiveTaskConfirmModal')).hide();
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        }

        // ── Re-open the modal with old input + errors if the last submission failed validation ──
        @if ($errors->any())
            (function() {
                const oldInput = @json(old());
                const errors = @json($errors->getMessages());

                if (oldInput._method === 'PUT' && oldInput.task_id) {
                    document.getElementById('taskModalTitle').textContent = 'Edit Task';
                    document.getElementById('task-save-label').textContent = 'Save Changes';
                    document.getElementById('taskForm').action = updateTaskUrl(oldInput.task_id);
                    document.getElementById('task-method').value = 'PUT';
                    document.getElementById('task-id-field').value = oldInput.task_id;
                } else {
                    document.getElementById('taskModalTitle').textContent = 'Add Task';
                    document.getElementById('task-save-label').textContent = 'Add Task';
                    document.getElementById('taskForm').action = storeTaskUrl;
                    document.getElementById('task-method').value = 'POST';
                }

                fillTaskForm({
                    title: oldInput.title,
                    description: oldInput.description,
                    required_position: oldInput.required_position,
                    status: oldInput.status,
                    start_date: oldInput.start_date,
                    due_date: oldInput.due_date,
                    employee_id: oldInput.employee_id,
                    checklist_items: oldInput.checklist_items || [],
                });

                const errEl = document.getElementById('task-form-error');
                errEl.classList.remove('d-none');
                errEl.innerHTML = Object.values(errors).flat().join('<br>');

                new bootstrap.Modal(document.getElementById('taskModal')).show();
            })();
        @endif
    </script>
@endsection
