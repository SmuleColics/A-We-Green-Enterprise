@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/task/task.css') }}">
@endsection

@section('page-title', 'Tasks')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1"
        data-bs-toggle="modal" data-bs-target="#archivedModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text"
        data-bs-toggle="modal" data-bs-target="#assignModal">
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
                        <p class="summary-value" id="cnt-done">2</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-secondary summary-icon">assignment</span>
                    <div>
                        <p class="summary-label">To Do</p>
                        <p class="summary-value" id="cnt-todo">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-primary summary-icon">autorenew</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value" id="cnt-inprogress">2</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined text-warning summary-icon">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value" id="cnt-onhold">1</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Done">Done</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="To Do">To Do</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In Progress</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tasksTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task</th>
                                <th class="border-0 small green-text">Project</th>
                                <th class="border-0 small green-text">Assigned To</th>
                                <th class="border-0 small green-text">Priority</th>
                                <th class="border-0 small green-text">Start Date</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tasksBody"></tbody>
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
                <div class="modal-body">
                    <div class="row g-2 mb-3" id="viewTaskInfo"></div>
                    <hr class="my-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <p class="fw-semibold mb-0 small text-uppercase section-label">Progress Updates</p>
                        <span class="badge bg-light text-muted border" id="updateCount">0 updates</span>
                    </div>
                    <div class="update-feed mb-3" id="updateFeed"></div>
                    <div class="border rounded p-3 bg-light-subtle">
                        <p class="small fw-semibold mb-2">Post an Update</p>
                        <textarea class="form-control form-control-sm mb-2" id="updateText" rows="2"
                            placeholder="Describe the progress, issue, or note..."></textarea>
                        <div class="upload-zone mb-1" onclick="document.getElementById('photoInput').click()">
                            <span class="material-symbols-outlined text-muted" style="font-size:26px;">add_photo_alternate</span>
                            <p class="small text-muted mb-0 mt-1">Click to attach a photo <span class="text-muted">(optional)</span></p>
                            <input type="file" id="photoInput" accept="image/*" onchange="previewPhoto(event)">
                        </div>
                        <img id="photoPreview" alt="preview">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <button class="btn btn-sm btn-link text-muted p-0" onclick="clearUpdate()">Clear</button>
                            <button class="btn btn-sm btn-success" onclick="postUpdate()">
                                <span class="material-symbols-outlined me-1" style="font-size:15px;vertical-align:middle;">send</span>Post Update
                            </button>
                        </div>
                    </div>
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
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label small">Task Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newTaskName" placeholder="e.g. Install DVR and HDD">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Project <span class="text-danger">*</span></label>
                            <select class="form-select" id="newProject">
                                <option value="">Select project</option>
                                <option>CCTV Installation – Makati Branch</option>
                                <option>Network Setup – BGC Office</option>
                                <option>Fire Alarm System – Pasig</option>
                                <option>Access Control – Alabang</option>
                                <option>Solar Street Lighting – Taguig</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Priority <span class="text-danger">*</span></label>
                            <select class="form-select" id="newPriority">
                                <option>High</option>
                                <option selected>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="newStartDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="newDueDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Status</label>
                            <select class="form-select" id="newStatus">
                                <option selected>To Do</option>
                                <option>In Progress</option>
                                <option>On Hold</option>
                            </select>
                        </div>
                    </div>

                    <div class="assign-guidance">
                        <p class="small fw-semibold mb-1">Availability Logic</p>
                        <p class="small text-muted mb-0">
                            An employee is selectable only when they have no overlapping active task within the chosen date range.
                            Active tasks include <strong>To Do</strong>, <strong>In Progress</strong>, and <strong>On Hold</strong>.
                        </p>
                    </div>

                    <div id="noDateNote" class="alert alert-secondary py-2 small d-flex align-items-center gap-2 mb-3 mt-3">
                        <span class="material-symbols-outlined fs-17">calendar_month</span>
                        Set both <strong>Start Date</strong> and <strong>Due Date</strong> to check employee availability.
                    </div>

                    <div id="empGrid" class="row g-3" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="assignTaskBtn" disabled onclick="assignTask()">
                        <span class="material-symbols-outlined me-1" style="font-size:16px;vertical-align:middle;">assignment_ind</span>
                        Assign Task
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Task Modal ── -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit / Reassign Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editTaskIndex">
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label small">Task Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editTaskName">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Project <span class="text-danger">*</span></label>
                            <select class="form-select" id="editProject">
                                <option>CCTV Installation – Makati Branch</option>
                                <option>Network Setup – BGC Office</option>
                                <option>Fire Alarm System – Pasig</option>
                                <option>Access Control – Alabang</option>
                                <option>Solar Street Lighting – Taguig</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Priority</label>
                            <select class="form-select" id="editPriority">
                                <option>High</option>
                                <option>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="editStartDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="editDueDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Status</label>
                            <select class="form-select" id="editStatus">
                                <option>Done</option>
                                <option>To Do</option>
                                <option>In Progress</option>
                                <option>On Hold</option>
                            </select>
                        </div>
                    </div>

                    <div class="assign-guidance">
                        <p class="small fw-semibold mb-1">Reassignment Rules</p>
                        <p class="small text-muted mb-0">
                            Only employees without overlapping active tasks can be selected. The task being edited is ignored during its own availability check.
                        </p>
                    </div>

                    <div id="editEmpGrid" class="row g-3 mt-1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveEdit()">
                        <span class="material-symbols-outlined me-1" style="font-size:16px;vertical-align:middle;">save</span>Save Changes
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
                    <h6 class="modal-title fw-semibold">Archive Task?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">This task will be moved to the archive. You can restore it anytime from <strong>Archived Tasks</strong>.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning" id="confirmArchiveBtn">
                        <span class="material-symbols-outlined me-1" style="font-size:14px;vertical-align:middle;">archive</span>Archive
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
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Task</th>
                                    <th class="border-0 small green-text">Project</th>
                                    <th class="border-0 small green-text">Assignee</th>
                                    <th class="border-0 small green-text">Priority</th>
                                    <th class="border-0 small green-text">Due Date</th>
                                    <th class="border-0 small green-text">Archived On</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="archivedBody"></tbody>
                        </table>
                    </div>
                    <p id="noArchivedMsg" class="text-muted text-center py-3 small" style="display:none;">No archived tasks yet.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightboxOverlay" onclick="closeLightbox()">
        <img id="lightboxImg" src="" alt="full photo">
    </div>

@endsection

@section('scripts')
    <script>
        const EMPLOYEES = [
            { id: 'carlo', initials: 'CM', name: 'Carlo Mendoza' },
            { id: 'jomar', initials: 'JT', name: 'Jomar Tan' },
            { id: 'marco', initials: 'MR', name: 'Marco Rivera' },
        ];

        let tasks = [
            { id: 1, name: 'Install DVR and HDD', project: 'CCTV Installation – Makati Branch', assigneeId: 'carlo', priority: 'High', start: '2026-04-18', due: '2026-04-22', status: 'To Do', updates: [] },
            { id: 2, name: 'Test Alarm Panel', project: 'Fire Alarm System – Pasig', assigneeId: 'carlo', priority: 'Medium', start: '2026-04-25', due: '2026-04-30', status: 'To Do', updates: [] },
            { id: 3, name: 'Mount Outdoor Cameras', project: 'CCTV Installation – Makati Branch', assigneeId: 'ana', priority: 'Medium', start: '2026-04-20', due: '2026-04-26', status: 'To Do', updates: [] },
            { id: 4, name: 'Run CAT6 Cabling', project: 'Network Setup – BGC Office', assigneeId: 'jomar', priority: 'Medium', start: '2026-04-15', due: '2026-04-28', status: 'In Progress', updates: [] },
            { id: 5, name: 'Configure NVR Settings', project: 'CCTV Installation – Makati Branch', assigneeId: 'marco', priority: 'Low', start: '2026-04-21', due: '2026-04-30', status: 'In Progress', updates: [] },
            { id: 6, name: 'Install Smoke Detectors', project: 'Fire Alarm System – Pasig', assigneeId: 'ana', priority: 'High', start: '2026-03-05', due: '2026-03-08', status: 'Done', updates: [] },
            { id: 7, name: 'Site Survey & Documentation', project: 'Network Setup – BGC Office', assigneeId: 'marco', priority: 'Low', start: '2026-03-15', due: '2026-03-18', status: 'Done', updates: [] },
            { id: 8, name: 'Access Card Programming', project: 'Access Control – Alabang', assigneeId: 'jomar', priority: 'High', start: '2026-04-10', due: '2026-04-12', status: 'On Hold', updates: [] }
        ];

        let archivedTasks = [];
        let nextId = 9;
        let activeTaskIndex = null;
        let dtTable = null;
        let photoData = null;
        const selectedAssignee = { empGrid: null, editEmpGrid: null };

        const ACTIVE_BLOCKING_STATUSES = ['To Do', 'In Progress', 'On Hold'];
        const STATUS_ORDER = { 'Done': 0, 'To Do': 1, 'In Progress': 2, 'On Hold': 3 };

        function getEmployee(id) { return EMPLOYEES.find(emp => emp.id === id) || null; }
        function getEmployeeName(id) { const emp = getEmployee(id); return emp ? emp.name : 'Unassigned'; }

        function fmtDate(ymd) {
            if (!ymd) return '—';
            return new Date(ymd + 'T00:00:00').toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function todayYmd() { return new Date().toISOString().split('T')[0]; }
        function overlaps(startA, endA, startB, endB) { return startA <= endB && endA >= startB; }
        function isBlockingTask(task) { return ACTIVE_BLOCKING_STATUSES.includes(task.status); }

        function getBlockingTasks(empId, start, end, ignoreTaskId = null) {
            return tasks.filter(task =>
                task.assigneeId === empId &&
                task.id !== ignoreTaskId &&
                isBlockingTask(task) &&
                overlaps(start, end, task.start, task.due)
            );
        }

        function isEmployeeAvailable(empId, start, end, ignoreTaskId = null) {
            return getBlockingTasks(empId, start, end, ignoreTaskId).length === 0;
        }

        function toLocalDate(dateString) {
            const [year, month, day] = dateString.split('-').map(Number);
            return new Date(year, month - 1, day);
        }

        function formatYmdLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function daysInRange(start, end) {
            const result = [];
            let current = toLocalDate(start);
            const last = toLocalDate(end);
            while (current <= last) {
                result.push(formatYmdLocal(current));
                current.setDate(current.getDate() + 1);
            }
            return result;
        }

        function busyDaysForEmployee(empId, start, end, ignoreTaskId = null) {
            const blockingTasks = getBlockingTasks(empId, start, end, ignoreTaskId);
            return daysInRange(start, end).map(day => ({
                day,
                blocked: blockingTasks.some(task => overlaps(day, day, task.start, task.due))
            }));
        }

        function priorityBadge(priority) {
            const map = { High: 'danger', Medium: 'warning text-dark', Low: 'success' };
            return `<span class="badge rounded-pill bg-${map[priority] || 'secondary'}">${priority}</span>`;
        }

        function statusBadge(status) {
            const map = { 'Done': 'success', 'To Do': 'secondary', 'In Progress': 'primary', 'On Hold': 'warning text-dark' };
            return `<span class="badge rounded-pill bg-${map[status] || 'secondary'}" data-ss="${STATUS_ORDER[status] || 99}">${status}</span>`;
        }

        function updateSummaryCounts() {
            document.getElementById('cnt-done').textContent      = tasks.filter(t => t.status === 'Done').length;
            document.getElementById('cnt-todo').textContent      = tasks.filter(t => t.status === 'To Do').length;
            document.getElementById('cnt-inprogress').textContent = tasks.filter(t => t.status === 'In Progress').length;
            document.getElementById('cnt-onhold').textContent    = tasks.filter(t => t.status === 'On Hold').length;
        }

        function renderTable() {
            const tbody = document.getElementById('tasksBody');
            if (dtTable) dtTable.destroy();

            const sortedTasks = [...tasks].sort((a, b) => (STATUS_ORDER[a.status] ?? 99) - (STATUS_ORDER[b.status] ?? 99));

            tbody.innerHTML = sortedTasks.map((task, originalIdx) => {
                const overdue = task.status !== 'Done' && task.due < todayYmd();
                const dueCell = overdue
                    ? `<td class="text-danger fw-semibold"><span class="material-symbols-outlined" style="font-size:13px;vertical-align:middle;">warning</span> ${fmtDate(task.due)}</td>`
                    : `<td class="text-muted">${fmtDate(task.due)}</td>`;

                const editBtn = task.status !== 'Done'
                    ? `<button class="btn btn-sm btn-outline-primary action-btn" title="Edit" onclick="openEdit(${originalIdx})"><span class="material-symbols-outlined icon-action">edit</span></button>`
                    : `<button class="btn btn-sm action-btn invisible" disabled aria-hidden="true"><span class="material-symbols-outlined icon-action">edit</span></button>`;

                return `
                    <tr>
                        <td class="fw-semibold">${task.name}</td>
                        <td class="text-muted small">${task.project}</td>
                        <td>${getEmployeeName(task.assigneeId)}</td>
                        <td>${priorityBadge(task.priority)}</td>
                        <td>${fmtDate(task.start)}</td>
                        ${dueCell}
                        <td>${statusBadge(task.status)}</td>
                        <td class="text-nowrap actions-col">
                            <button class="btn btn-sm btn-outline-success action-btn" title="View" onclick="openView(${originalIdx})">
                                <span class="material-symbols-outlined icon-action">visibility</span>
                            </button>
                            ${editBtn}
                            <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive" onclick="openArchive(${originalIdx})">
                                <span class="material-symbols-outlined icon-action">archive</span>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');

            dtTable = $('#tasksTable').DataTable({
                pageLength: 25,
                columnDefs: [{ orderable: false, targets: 7 }],
                order: [],
                searching: true
            });

            updateSummaryCounts();
        }

        document.getElementById('statusFilterGroup').addEventListener('click', function(event) {
            const btn = event.target.closest('[data-filter]');
            if (!btn || !dtTable) return;
            this.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            dtTable.column(6).search(filter === 'all' ? '' : filter, false, false).draw();
        });

        function buildAvailabilityCard(emp, gridId, start, end, currentEmpId = null, ignoreTaskId = null) {
            const conflicts = getBlockingTasks(emp.id, start, end, ignoreTaskId);
            const available = conflicts.length === 0;
            const selected  = selectedAssignee[gridId] === emp.id && available;
            const current   = currentEmpId === emp.id;
            const busyDays  = busyDaysForEmployee(emp.id, start, end, ignoreTaskId);

            const calendarHtml = busyDays.map(entry => {
                const dayNum = new Date(entry.day + 'T00:00:00').getDate();
                return `<div class="cal-day ${entry.blocked ? 'cal-busy' : 'cal-free'}" title="${entry.day}">${dayNum}</div>`;
            }).join('');

            const conflictHtml = conflicts.length
                ? conflicts.map(c => `
                    <div class="emp-task-item">
                        <span class="material-symbols-outlined text-danger">block</span>
                        <span><strong>${c.name}</strong> — ${c.project} <span class="text-muted">(${fmtDate(c.start)} – ${fmtDate(c.due)})</span></span>
                    </div>`).join('')
                : `<div class="emp-task-item text-success"><span class="material-symbols-outlined">event_available</span><span>No overlapping active task for this date range.</span></div>`;

            const recommendation = available
                ? `<div class="rec-box rec-ok">Available for the entire date range.</div>`
                : `<div class="rec-box rec-warn">Not available. Choose another employee or change the dates.</div>`;

            const currentTag = current ? `<span class="badge bg-light border text-muted ms-1 current-badge">current</span>` : '';
            const availBadge = available
                ? `<span class="avail-badge badge-free">Available</span>`
                : `<span class="avail-badge badge-busy">Unavailable</span>`;

            return `
                <div class="col-md-6 col-xl-4">
                    <div class="emp-avail-card ${available ? '' : 'emp-busy'} ${selected ? 'selected' : ''}"
                         id="ecard-${gridId}-${emp.id}"
                         ${available ? `onclick="pickEmp('${gridId}','${emp.id}')"` : ''}>
                        <div class="check-mark">
                            <span class="material-symbols-outlined" style="font-size:13px;color:#fff;">check</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="assignee-avatar">${emp.initials}</span>
                            <div><p class="fw-semibold small mb-0">${emp.name}${currentTag}</p></div>
                            <span class="ms-auto">${availBadge}</span>
                        </div>
                        <div class="mini-cal">${calendarHtml}</div>
                        <div class="emp-task-list">${conflictHtml}</div>
                        ${recommendation}
                    </div>
                </div>`;
        }

        function buildAvailGrid(gridId, start, end, currentEmpId = null, ignoreTaskId = null) {
            const grid = document.getElementById(gridId);
            grid.innerHTML = '';
            const hasCurrent = currentEmpId && isEmployeeAvailable(currentEmpId, start, end, ignoreTaskId);
            selectedAssignee[gridId] = hasCurrent ? currentEmpId : null;
            grid.innerHTML = EMPLOYEES.map(emp => buildAvailabilityCard(emp, gridId, start, end, currentEmpId, ignoreTaskId)).join('');
            if (gridId === 'empGrid') document.getElementById('assignTaskBtn').disabled = !selectedAssignee.empGrid;
        }

        function pickEmp(gridId, empId) {
            EMPLOYEES.forEach(emp => {
                const card = document.getElementById(`ecard-${gridId}-${emp.id}`);
                if (card) card.classList.remove('selected');
            });
            const target = document.getElementById(`ecard-${gridId}-${empId}`);
            if (!target || target.classList.contains('emp-busy')) return;
            target.classList.add('selected');
            selectedAssignee[gridId] = empId;
            if (gridId === 'empGrid') document.getElementById('assignTaskBtn').disabled = false;
        }

        function refreshAssignGrid() {
            const start = document.getElementById('newStartDate').value;
            const end   = document.getElementById('newDueDate').value;
            const note  = document.getElementById('noDateNote');
            const grid  = document.getElementById('empGrid');

            if (!start || !end || start > end) {
                note.style.display = '';
                grid.style.display = 'none';
                selectedAssignee.empGrid = null;
                document.getElementById('assignTaskBtn').disabled = true;
                return;
            }

            note.style.display = 'none';
            grid.style.display = '';
            buildAvailGrid('empGrid', start, end, null, null);
            document.getElementById('assignTaskBtn').disabled = !selectedAssignee.empGrid;
        }

        document.getElementById('newStartDate').addEventListener('change', refreshAssignGrid);
        document.getElementById('newDueDate').addEventListener('change', refreshAssignGrid);

        document.getElementById('assignModal').addEventListener('hidden.bs.modal', () => {
            document.getElementById('newTaskName').value  = '';
            document.getElementById('newProject').value   = '';
            document.getElementById('newPriority').value  = 'Medium';
            document.getElementById('newStatus').value    = 'To Do';
            document.getElementById('newStartDate').value = '';
            document.getElementById('newDueDate').value   = '';
            document.getElementById('noDateNote').style.display = '';
            document.getElementById('empGrid').style.display    = 'none';
            document.getElementById('empGrid').innerHTML        = '';
            selectedAssignee.empGrid = null;
            document.getElementById('assignTaskBtn').disabled = true;
        });

        function assignTask() {
            const name       = document.getElementById('newTaskName').value.trim();
            const project    = document.getElementById('newProject').value;
            const priority   = document.getElementById('newPriority').value;
            const status     = document.getElementById('newStatus').value;
            const start      = document.getElementById('newStartDate').value;
            const due        = document.getElementById('newDueDate').value;
            const assigneeId = selectedAssignee.empGrid;

            if (!name)    { alert('Please enter a task name.'); return; }
            if (!project) { alert('Please select a project.'); return; }
            if (!start || !due || start > due) { alert('Please enter a valid start and due date.'); return; }
            if (!assigneeId) { alert('Please choose an available employee.'); return; }
            if (!isEmployeeAvailable(assigneeId, start, due)) {
                alert('The selected employee is no longer available for this date range.');
                refreshAssignGrid();
                return;
            }

            tasks.push({ id: nextId++, name, project, assigneeId, priority, start, due, status, updates: [] });
            bootstrap.Modal.getInstance(document.getElementById('assignModal')).hide();
            renderTable();
        }

        function openView(idx) {
            activeTaskIndex = idx;
            const task   = tasks[idx];
            const overdue = task.status !== 'Done' && task.due < todayYmd();

            document.getElementById('viewTaskInfo').innerHTML = `
                <div class="col-sm-6"><p class="text-muted small mb-1">Task Name</p><p class="fw-semibold mb-0">${task.name}</p></div>
                <div class="col-sm-6"><p class="text-muted small mb-1">Project</p><p class="mb-0">${task.project}</p></div>
                <div class="col-sm-4"><p class="text-muted small mb-1">Assigned To</p><p class="mb-0">${getEmployeeName(task.assigneeId)}</p></div>
                <div class="col-sm-2"><p class="text-muted small mb-1">Priority</p>${priorityBadge(task.priority)}</div>
                <div class="col-sm-3"><p class="text-muted small mb-1">Status</p>${statusBadge(task.status)}</div>
                <div class="col-sm-3"><p class="text-muted small mb-1">Start Date</p><p class="mb-0 small">${fmtDate(task.start)}</p></div>
                <div class="col-sm-3"><p class="text-muted small mb-1">Due Date</p><p class="mb-0 small ${overdue ? 'text-danger fw-semibold' : ''}">${fmtDate(task.due)}</p></div>
            `;

            renderUpdateFeed(task);
            new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
        }

        function renderUpdateFeed(task) {
            const feed  = document.getElementById('updateFeed');
            const count = task.updates.length;
            document.getElementById('updateCount').textContent = `${count} update${count !== 1 ? 's' : ''}`;

            feed.innerHTML = count === 0
                ? '<p class="text-muted small text-center py-2">No updates yet. Post one below.</p>'
                : task.updates.slice().reverse().map(update => `
                    <div class="update-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="assignee-avatar update-admin-avatar">AD</span>
                            <span class="fw-semibold small">Admin</span>
                            <span class="text-muted small ms-auto">${update.date}</span>
                        </div>
                        <p class="small mb-1">${update.text}</p>
                        ${update.photo ? `<img src="${update.photo}" alt="update photo" class="update-photo" onclick="openLightbox(this.src)">` : ''}
                    </div>`).join('');
        }

        function openEdit(idx) {
            activeTaskIndex = idx;
            const task = tasks[idx];
            document.getElementById('editTaskIndex').value = idx;
            document.getElementById('editTaskName').value  = task.name;
            document.getElementById('editProject').value   = task.project;
            document.getElementById('editPriority').value  = task.priority;
            document.getElementById('editStatus').value    = task.status;
            document.getElementById('editStartDate').value = task.start;
            document.getElementById('editDueDate').value   = task.due;
            buildAvailGrid('editEmpGrid', task.start, task.due, task.assigneeId, task.id);
            new bootstrap.Modal(document.getElementById('editTaskModal')).show();
        }

        ['editStartDate', 'editDueDate'].forEach(id => {
            document.getElementById(id).addEventListener('change', () => {
                if (activeTaskIndex === null) return;
                const start = document.getElementById('editStartDate').value;
                const due   = document.getElementById('editDueDate').value;
                const task  = tasks[activeTaskIndex];
                if (!start || !due || start > due) { document.getElementById('editEmpGrid').innerHTML = ''; selectedAssignee.editEmpGrid = null; return; }
                buildAvailGrid('editEmpGrid', start, due, task.assigneeId, task.id);
            });
        });

        function saveEdit() {
            const idx         = parseInt(document.getElementById('editTaskIndex').value, 10);
            const task        = tasks[idx];
            const newName     = document.getElementById('editTaskName').value.trim();
            const newProject  = document.getElementById('editProject').value;
            const newPriority = document.getElementById('editPriority').value;
            const newStatus   = document.getElementById('editStatus').value;
            const newStart    = document.getElementById('editStartDate').value;
            const newDue      = document.getElementById('editDueDate').value;
            const newAssignee = selectedAssignee.editEmpGrid || task.assigneeId;

            if (!newName)  { alert('Task name cannot be empty.'); return; }
            if (!newStart || !newDue || newStart > newDue) { alert('Please enter a valid date range.'); return; }
            if (!newAssignee) { alert('Please choose an available employee.'); return; }
            if (newStatus !== 'Done' && !isEmployeeAvailable(newAssignee, newStart, newDue, task.id)) {
                alert('The selected employee is not available for the updated date range.');
                buildAvailGrid('editEmpGrid', newStart, newDue, task.assigneeId, task.id);
                return;
            }

            task.name = newName; task.project = newProject; task.priority = newPriority;
            task.status = newStatus; task.start = newStart; task.due = newDue; task.assigneeId = newAssignee;

            bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
            renderTable();
        }

        function openArchive(idx) {
            activeTaskIndex = idx;
            new bootstrap.Modal(document.getElementById('archiveConfirmModal')).show();
        }

        document.getElementById('confirmArchiveBtn').addEventListener('click', () => {
            if (activeTaskIndex === null) return;
            const [task] = tasks.splice(activeTaskIndex, 1);
            task.archivedOn = new Date().toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
            archivedTasks.push(task);
            activeTaskIndex = null;
            bootstrap.Modal.getInstance(document.getElementById('archiveConfirmModal')).hide();
            renderTable();
            renderArchived();
        });

        function renderArchived() {
            const tbody   = document.getElementById('archivedBody');
            const message = document.getElementById('noArchivedMsg');
            if (archivedTasks.length === 0) { tbody.innerHTML = ''; message.style.display = ''; return; }
            message.style.display = 'none';
            tbody.innerHTML = archivedTasks.map((task, idx) => `
                <tr>
                    <td class="fw-semibold">${task.name}</td>
                    <td class="text-muted small">${task.project}</td>
                    <td>${getEmployeeName(task.assigneeId)}</td>
                    <td>${priorityBadge(task.priority)}</td>
                    <td>${fmtDate(task.due)}</td>
                    <td class="text-muted small">${task.archivedOn}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success action-btn" onclick="restoreTask(${idx})">
                            <span class="material-symbols-outlined icon-action">unarchive</span> Restore
                        </button>
                    </td>
                </tr>`).join('');
        }

        function restoreTask(idx) {
            const task = archivedTasks[idx];
            if (task.status !== 'Done' && !isEmployeeAvailable(task.assigneeId, task.start, task.due)) {
                alert('This task cannot be restored because the original assignee is no longer available for its schedule.');
                return;
            }
            archivedTasks.splice(idx, 1);
            delete task.archivedOn;
            tasks.push(task);
            renderTable();
            renderArchived();
        }

        function previewPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                photoData = e.target.result;
                const preview = document.getElementById('photoPreview');
                preview.src = photoData;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function postUpdate() {
            if (activeTaskIndex === null) return;
            const text = document.getElementById('updateText').value.trim();
            if (!text) { alert('Please write something before posting.'); return; }
            const now  = new Date();
            const date = now.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' })
                       + ' · ' + now.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit' });
            tasks[activeTaskIndex].updates.push({ text, photo: photoData, date });
            renderUpdateFeed(tasks[activeTaskIndex]);
            clearUpdate();
        }

        function clearUpdate() {
            document.getElementById('updateText').value  = '';
            document.getElementById('photoInput').value  = '';
            document.getElementById('photoPreview').src  = '';
            document.getElementById('photoPreview').style.display = 'none';
            photoData = null;
        }

        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
            document.getElementById('lightboxOverlay').classList.add('show');
        }

        function closeLightbox() {
            document.getElementById('lightboxOverlay').classList.remove('show');
        }

        $(document).ready(() => { renderTable(); renderArchived(); });
    </script>
@endsection