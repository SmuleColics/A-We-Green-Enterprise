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

    <div class="container-fluid px-4 py-4">

        <!-- Project Header Card -->
        <div class="detail-card mb-4">
            <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-3 mb-3">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h4 class="fw-bold mb-0">CCTV Installation — Santos Residence</h4>
                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">Active</span>
                    </div>
                    <p class="text-muted small mb-1">
                        <span class="material-symbols-outlined text-muted" style="font-size:14px;vertical-align:middle;">person</span>
                        Maria Santos &nbsp;—&nbsp;
                        <span class="material-symbols-outlined text-muted" style="font-size:14px;vertical-align:middle;">location_on</span>
                        123 Rizal St, Quezon City
                    </p>
                    <p class="text-muted small mb-0">
                        <span class="service-badge badge-green me-2">CCTV Setup</span>
                        Mar 10, 2026 &nbsp;—&nbsp; Mar 20, 2026
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3 flex-shrink-0">
                    <span class="progress-pct" id="headerProgressPct">0%</span>
                    <select class="form-select form-select-sm" style="width:140px;">
                        <option selected>Active</option>
                        <option>Completed</option>
                        <option>On Hold</option>
                        <option>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="progress mb-4" style="height:10px;border-radius:8px;">
                <div class="progress-bar bg-success" id="headerProgressBar" style="width:0%;border-radius:8px;"></div>
            </div>

            <!-- Project Team -->
            <div class="d-flex align-items-center gap-2 flex-wrap mb-3 pb-3 border-bottom">
                <span class="small fw-semibold text-muted me-1">Project Team:</span>
                <div class="d-flex align-items-center gap-2 flex-wrap" id="projectTeamChips"></div>
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 ms-auto"
                    data-bs-toggle="modal" data-bs-target="#manageTeamModal">
                    <span class="material-symbols-outlined fs-15">group_add</span>
                    Manage Team
                </button>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#contractModal">
                    <span class="material-symbols-outlined fs-17">upload_file</span>
                    Upload Contract
                </button>
                <a href="#" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">checklist</span>
                    View Checklist
                </a>
                <a href="#" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">assignment</span>
                    View Assessment
                </a>
                <a href="#" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-17">request_quote</span>
                    View Quotation
                </a>
                <button class="btn btn-sm btn-outline-success d-flex align-items-center gap-1 ms-auto"
                    data-bs-toggle="modal" data-bs-target="#editProjectModal">
                    <span class="material-symbols-outlined fs-17">edit</span>
                    Edit Project
                </button>
            </div>
        </div>


        <!-- Project Updates -->
        <div class="detail-card">
            <h6 class="fw-semibold mb-4 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-success" style="font-size:20px;">timeline</span>
                Project Updates
                <button class="btn btn-sm btn-success ms-auto d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#taskChecklistModal">
                    <span class="material-symbols-outlined fs-15">task_alt</span>
                    Task Checklist
                </button>
            </h6>

            <!-- Compose Box -->
            <div class="compose-box mb-4">
                <div class="compose-inner">
                    <div class="update-avatar me-3 flex-shrink-0">AD</div>
                    <div class="flex-grow-1">
                        <textarea class="form-control compose-textarea" rows="2"
                            placeholder="Post an update about this project..." id="updateText"></textarea>
                        <div class="d-flex flex-wrap gap-2 mt-2" id="imagePreviewStrip"></div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 mb-0" style="cursor:pointer;">
                                <span class="material-symbols-outlined fs-17">image</span>
                                Attach Image
                                <input type="file" accept="image/*" multiple class="d-none"
                                    id="updateImageInput" onchange="previewImages(this)">
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small" id="imageCount"></span>
                                <button class="btn btn-sm btn-success px-3 d-flex align-items-center gap-1" onclick="postUpdate()">
                                    <span class="material-symbols-outlined fs-17">send</span>
                                    Post Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline" id="updateTimeline">
                <div class="timeline-item">
                    <div class="tl-left">
                        <div class="tl-dot"></div>
                        <div class="tl-line"></div>
                    </div>
                    <div class="tl-body">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <div class="update-avatar sm">CM</div>
                            <span class="small fw-semibold">Carlo Mendoza</span>
                            <span class="text-muted small">·</span>
                            <span class="text-muted small">Mar 12, 2026 · 2:00 PM</span>
                        </div>
                        <p class="small mb-2">50% of cameras installed. Outdoor units on the north side are complete.</p>
                        <div class="update-images">
                            <img src="https://placehold.co/160x100/d1fae5/16A249?text=Site+Photo+1" class="update-thumb" alt="Site photo"
                                onclick="openLightbox(this.src)" data-bs-toggle="modal" data-bs-target="#lightboxModal">
                            <img src="https://placehold.co/160x100/dbeafe/1e40af?text=Camera+Install" class="update-thumb" alt="Camera"
                                onclick="openLightbox(this.src)" data-bs-toggle="modal" data-bs-target="#lightboxModal">
                        </div>
                    </div>
                </div>
                <div class="timeline-item last">
                    <div class="tl-left">
                        <div class="tl-dot"></div>
                    </div>
                    <div class="tl-body">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <div class="update-avatar sm">CM</div>
                            <span class="small fw-semibold">Carlo Mendoza</span>
                            <span class="text-muted small">·</span>
                            <span class="text-muted small">Mar 10, 2026 · 9:00 AM</span>
                        </div>
                        <p class="small mb-0">Installation started. Team arrived, completed site orientation. Equipment staged in lobby area.</p>
                    </div>
                </div>
            </div>
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


    <!-- ── Manage Team Modal ── -->
    <div class="modal fade" id="manageTeamModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:20px;">group</span>
                        Project Team
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Team members listed here can be assigned tasks on this project.
                        Removing a member does not remove their existing task assignments.
                    </p>
                    <div class="d-flex flex-column gap-2 mb-3" id="teamMemberList"></div>
                    <hr>
                    <p class="small fw-semibold mb-1">Add Team Member</p>
                    <p class="text-muted small mb-3">
                        Select an employee and set a date range to check their availability.
                        Conflicts are shown as a warning — you can still add them if needed.
                    </p>
                    <div class="row g-2 mb-3">
                        <div class="col-md-12">
                            <label class="form-label small">Employee</label>
                            <select class="form-select form-select-sm" id="addTeamMemberSelect" onchange="refreshTeamAvailCard()">
                                <option value="">— Select employee —</option>
                            </select>
                        </div>
                    </div>
                    <div id="team-avail-note" class="alert alert-secondary py-2 small d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined fs-17">calendar_month</span>
                        Select an employee and set a date range to check availability.
                    </div>
                    <div id="team-avail-card" style="display:none;" class="mb-3"></div>
                    <div id="team-add-confirm" style="display:none;">
                        <button class="btn btn-sm btn-success d-flex align-items-center gap-1" onclick="confirmAddTeamMember()">
                            <span class="material-symbols-outlined fs-17">person_add</span>
                            Confirm Add to Team
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Task Checklist Modal ── -->
    <div class="modal fade" id="taskChecklistModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-success fs-22">task_alt</span>
                        <div>
                            <h5 class="modal-title mb-0">Task Checklist</h5>
                            <p class="text-muted small mb-0">CCTV Installation — Santos Residence</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <p class="small text-muted mb-0" id="taskProgressLabel">0 / 0 tasks completed</p>
                        <span class="fw-bold text-success small" id="taskProgressPct">0%</span>
                    </div>
                    <div class="checklist-progress-bar mb-3">
                        <div class="bar-fill" id="taskProgressBar" style="width:0%"></div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <ul class="nav checklist-tabs border-bottom w-auto" id="checklistTabs">
                            <li class="nav-item"><button class="nav-link active" data-tab="all">All <span class="badge bg-secondary" id="tab-count-all">0</span></button></li>
                            <li class="nav-item"><button class="nav-link" data-tab="To Do">To Do <span class="badge bg-secondary" id="tab-count-todo">0</span></button></li>
                            <li class="nav-item"><button class="nav-link" data-tab="In Progress">In Progress <span class="badge bg-warning text-dark" id="tab-count-inprog">0</span></button></li>
                            <li class="nav-item"><button class="nav-link" data-tab="Done">Done <span class="badge bg-success" id="tab-count-done">0</span></button></li>
                            <li class="nav-item"><button class="nav-link" data-tab="On Hold">On Hold <span class="badge bg-warning text-dark" id="tab-count-hold">0</span></button></li>
                        </ul>
                        <button class="btn btn-sm btn-success d-flex align-items-center gap-1" onclick="openAssignTaskPanel()">
                            <span class="material-symbols-outlined fs-17">add</span>
                            Add Task
                        </button>
                    </div>

                    <div id="checklistTaskList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Save Changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Add / Edit Task Modal ── -->
    <div class="modal fade" id="assignTaskModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignTaskModalTitle">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="at-task-id">
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label small">Task Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="at-name" placeholder="e.g. Install DVR and HDD">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Project</label>
                            <input type="text" class="form-control" id="at-project" value="CCTV Installation – Santos Residence" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Priority <span class="text-danger">*</span></label>
                            <select class="form-select" id="at-priority">
                                <option>High</option>
                                <option selected>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="at-start">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="at-due">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Status</label>
                            <select class="form-select" id="at-status">
                                <option selected>To Do</option>
                                <option>In Progress</option>
                                <option>Done</option>
                                <option>On Hold</option>
                            </select>
                        </div>
                    </div>

                    <div class="assign-guidance mb-3">
                        <p class="small fw-semibold mb-1">Assign to Team Member</p>
                        <p class="small text-muted mb-0">
                            Only project team members are shown. Set both dates first to see who is free
                            for this specific task. Active tasks (<strong>To Do</strong>, <strong>In Progress</strong>,
                            <strong>On Hold</strong>) block availability — <strong>Done</strong> tasks do not.
                            You can still select a member with conflicts if needed.
                        </p>
                    </div>

                    <div id="at-no-date-note" class="alert alert-secondary py-2 small d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined fs-17">calendar_month</span>
                        Set both <strong>Start Date</strong> and <strong>Due Date</strong> to check team member availability for this task.
                    </div>

                    <div id="at-emp-grid" class="row g-3" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="at-save-btn" disabled onclick="saveAssignTask()">
                        <span class="material-symbols-outlined me-1 fs-17">save</span>
                        <span id="at-save-label">Add Task</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Upload Contract Modal ── -->
    <div class="modal fade" id="contractModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-0">Contract Files</h5>
                        <p class="text-muted small mb-0 mt-1">CCTV Installation — Santos Residence</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="contract-upload-area mb-4" for="contractFileInput">
                        <span class="material-symbols-outlined text-muted mb-2" style="font-size:36px;">upload_file</span>
                        <p class="small fw-semibold mb-0">Click to upload contract files</p>
                        <p class="text-muted small mb-0">Supports images (JPG, PNG) and PDF</p>
                        <input type="file" id="contractFileInput" accept="image/*,.pdf" multiple class="d-none"
                            onchange="previewContractFiles(this)">
                    </label>
                    <div class="d-flex flex-wrap gap-2 mb-3" id="contractPreviewGrid"></div>
                    <p class="small fw-semibold text-muted text-uppercase mb-2" style="letter-spacing:.05em;">Uploaded Files</p>
                    <div class="d-flex flex-wrap gap-2" id="contractUploadedFiles">
                        <div class="contract-file-chip">
                            <span class="material-symbols-outlined fs-15" style="color:var(--awg-primary);">image</span>
                            contract-page-1.jpg
                            <button class="btn-chip-remove" onclick="this.parentElement.remove()">
                                <span class="material-symbols-outlined" style="font-size:13px;">close</span>
                            </button>
                        </div>
                        <div class="contract-file-chip">
                            <span class="material-symbols-outlined fs-15" style="color:#ef4444;">picture_as_pdf</span>
                            signed-contract.pdf
                            <button class="btn-chip-remove" onclick="this.parentElement.remove()">
                                <span class="material-symbols-outlined" style="font-size:13px;">close</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">save</span>Save Files
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Project Modal ── -->
    <div class="modal fade" id="editProjectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">Project Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="CCTV Installation — Santos Residence">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="Maria Santos">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select">
                                <option selected>CCTV Setup</option>
                                <option>Solar Street Light</option>
                                <option>Solar Setup</option>
                                <option>Public Address System</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="123 Rizal St, Quezon City">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contract Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" value="45000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Status</label>
                            <select class="form-select">
                                <option selected>Active</option>
                                <option>Completed</option>
                                <option>On Hold</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" value="2026-03-10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" value="2026-03-20">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">save</span>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const EMPLOYEES = [
            { id: 'carlo', initials: 'CM', name: 'Carlo Mendoza' },
            { id: 'jomar', initials: 'JT', name: 'Jomar Tan' },
            { id: 'marco', initials: 'MR', name: 'Marco Rivera' },
        ];

        let allTasks = [
            { id: 1, name: 'Run CAT6 Cabling', project: 'Network Setup – BGC Office', assigneeId: 'jomar', priority: 'Medium', start: '2026-04-15', due: '2026-04-28', status: 'In Progress' },
            { id: 2, name: 'Configure NVR Settings', project: 'CCTV Installation – Makati Branch', assigneeId: 'marco', priority: 'Low', start: '2026-04-21', due: '2026-04-30', status: 'In Progress' },
            { id: 3, name: 'Access Card Programming', project: 'Access Control – Alabang', assigneeId: 'jomar', priority: 'High', start: '2026-04-10', due: '2026-04-12', status: 'On Hold' },
        ];

        let projectTasks = [
            { id: 100, name: 'Site Survey & Measurements', project: 'CCTV Installation – Santos Residence', assigneeId: 'carlo', priority: 'High', start: '2026-03-01', due: '2026-03-02', status: 'Done', updates: [] },
            { id: 101, name: 'Equipment Procurement & Staging', project: 'CCTV Installation – Santos Residence', assigneeId: 'marco', priority: 'High', start: '2026-03-03', due: '2026-03-04', status: 'Done', updates: [] },
            { id: 102, name: 'Mount Indoor Camera Brackets', project: 'CCTV Installation – Santos Residence', assigneeId: 'carlo', priority: 'Medium', start: '2026-03-05', due: '2026-03-06', status: 'Done', updates: [] },
            { id: 103, name: 'Mount Outdoor Camera Brackets', project: 'CCTV Installation – Santos Residence', assigneeId: 'jomar', priority: 'Medium', start: '2026-03-06', due: '2026-03-07', status: 'Done', updates: [] },
            { id: 104, name: 'Run Power & Video Cabling', project: 'CCTV Installation – Santos Residence', assigneeId: 'carlo', priority: 'High', start: '2026-03-07', due: '2026-03-09', status: 'Done', updates: [] },
            { id: 105, name: 'Install DVR Unit & Hard Drive', project: 'CCTV Installation – Santos Residence', assigneeId: 'marco', priority: 'High', start: '2026-03-09', due: '2026-03-10', status: 'Done', updates: [] },
            { id: 106, name: 'Connect Cameras to DVR', project: 'CCTV Installation – Santos Residence', assigneeId: 'carlo', priority: 'High', start: '2026-03-10', due: '2026-03-11', status: 'Done', updates: [] },
            { id: 107, name: 'Configure DVR Recording Settings', project: 'CCTV Installation – Santos Residence', assigneeId: 'marco', priority: 'Medium', start: '2026-03-11', due: '2026-03-12', status: 'Done', updates: [] },
            { id: 108, name: 'Set Up Remote Viewing Access', project: 'CCTV Installation – Santos Residence', assigneeId: 'jomar', priority: 'Medium', start: '2026-03-12', due: '2026-03-13', status: 'In Progress', updates: [] },
            { id: 109, name: 'Camera Angle Fine-Tuning', project: 'CCTV Installation – Santos Residence', assigneeId: 'carlo', priority: 'Low', start: '2026-03-13', due: '2026-03-14', status: 'In Progress', updates: [] },
            { id: 110, name: 'Night Vision & Motion Test', project: 'CCTV Installation – Santos Residence', assigneeId: 'marco', priority: 'Medium', start: '2026-03-14', due: '2026-03-15', status: 'To Do', updates: [] },
            { id: 111, name: 'Client Walkthrough & Demo', project: 'CCTV Installation – Santos Residence', assigneeId: 'carlo', priority: 'High', start: '2026-03-16', due: '2026-03-17', status: 'To Do', updates: [] },
            { id: 112, name: 'Sign-Off & Documentation', project: 'CCTV Installation – Santos Residence', assigneeId: 'jomar', priority: 'High', start: '2026-03-18', due: '2026-03-18', status: 'To Do', updates: [] },
        ];

        let nextTaskId = 113;
        let activeChecklistFilter = 'all';
        let editingTaskId = null;
        const ACTIVE_BLOCKING_STATUSES = ['To Do', 'In Progress', 'On Hold'];
        let selectedAssigneeId = null;

        function getEmployee(id) { return EMPLOYEES.find(e => e.id === id) || null; }
        function getEmployeeName(id) { const e = getEmployee(id); return e ? e.name : 'Unassigned'; }

        function fmtDate(ymd) {
            if (!ymd) return '—';
            return new Date(ymd + 'T00:00:00').toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function todayYmd() { return new Date().toISOString().split('T')[0]; }
        function overlaps(sA, eA, sB, eB) { return sA <= eB && eA >= sB; }

        function getBlockingTasks(empId, start, end, ignoreTaskId = null) {
            return [...allTasks, ...projectTasks].filter(t =>
                t.assigneeId === empId &&
                t.id !== ignoreTaskId &&
                ACTIVE_BLOCKING_STATUSES.includes(t.status) &&
                overlaps(start, end, t.start, t.due)
            );
        }

        function daysInRange(start, end) {
            const result = [];
            let cur = new Date(start + 'T00:00:00');
            const last = new Date(end + 'T00:00:00');
            while (cur <= last) {
                result.push(cur.toISOString().split('T')[0]);
                cur.setDate(cur.getDate() + 1);
            }
            return result;
        }

        function priorityBadge(p) {
            const map = { High: 'danger', Medium: 'warning text-dark', Low: 'success' };
            return `<span class="badge rounded-pill bg-${map[p] || 'secondary'}">${p}</span>`;
        }

        function statusBadge(s) {
            const map = { 'Done': 'success', 'To Do': 'secondary', 'In Progress': 'primary', 'On Hold': 'warning text-dark' };
            return `<span class="badge rounded-pill bg-${map[s] || 'secondary'}">${s}</span>`;
        }

        function buildAvailCard(emp, start, end, ignoreTaskId, clickable, fullWidth, isSelected) {
            const conflicts = getBlockingTasks(emp.id, start, end, ignoreTaskId);
            const available = conflicts.length === 0;
            const days = daysInRange(start, end);
            const calHtml = days.map(d => {
                const busy = getBlockingTasks(emp.id, d, d, ignoreTaskId).length > 0;
                return `<div class="cal-day ${busy ? 'cal-busy' : 'cal-free'}">${new Date(d + 'T00:00:00').getDate()}</div>`;
            }).join('');

            const conflictHtml = conflicts.length
                ? conflicts.map(c => `
                    <div class="emp-task-item">
                        <span class="material-symbols-outlined text-danger">block</span>
                        <span><strong>${c.name}</strong> — ${c.project}
                            <span class="text-muted">(${fmtDate(c.start)} – ${fmtDate(c.due)}) · ${c.status}</span>
                        </span>
                    </div>`).join('')
                : `<div class="emp-task-item text-success">
                       <span class="material-symbols-outlined">event_available</span>
                       <span>No conflicting active tasks for this date range.</span>
                   </div>`;

            const recHtml = available
                ? `<div class="rec-box rec-ok">✅ Available for the entire date range.</div>`
                : `<div class="rec-box rec-warn">⚠ Has conflict(s) in this date range. ${clickable ? 'You can still select them if needed.' : 'You can still add them to the team.'}</div>`;

            const availBadge = available
                ? `<span class="avail-badge badge-free">Available</span>`
                : `<span class="avail-badge badge-busy">Has Conflicts</span>`;

            const clickAttr = clickable ? `onclick="pickEmp('${emp.id}')" style="cursor:pointer;"` : `style="cursor:default;"`;
            const checkMark = clickable ? `<div class="check-mark"><span class="material-symbols-outlined" style="font-size:13px;color:#fff;">check</span></div>` : '';
            const colClass = fullWidth ? 'col-12' : 'col-md-6 col-xl-4';
            const selectedCls = (isSelected && clickable) ? 'selected' : '';

            return `
                <div class="${colClass}">
                    <div class="emp-avail-card ${selectedCls}" id="ecard-${emp.id}" ${clickAttr}>
                        ${checkMark}
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="assignee-avatar">${emp.initials}</span>
                            <span class="fw-semibold small">${emp.name}</span>
                            <span class="ms-auto">${availBadge}</span>
                        </div>
                        <p class="text-muted small mb-1">Checking: <strong>${fmtDate(start)}</strong> – <strong>${fmtDate(end)}</strong></p>
                        <div class="mini-cal">${calHtml}</div>
                        <div class="emp-task-list">${conflictHtml}</div>
                        ${recHtml}
                    </div>
                </div>`;
        }

        function pickEmp(empId) {
            document.querySelectorAll('#at-emp-grid .emp-avail-card').forEach(c => c.classList.remove('selected'));
            const card = document.getElementById(`ecard-${empId}`);
            if (card) card.classList.add('selected');
            selectedAssigneeId = empId;
            document.getElementById('at-save-btn').disabled = false;
        }

        let projectTeam = [...new Set(projectTasks.map(t => t.assigneeId).filter(Boolean))];

        function renderTeamChips() {
            const chips = document.getElementById('projectTeamChips');
            if (!chips) return;
            chips.innerHTML = projectTeam.length === 0
                ? `<span class="text-muted small fst-italic">No team members yet.</span>`
                : projectTeam.map(id => {
                    const emp = getEmployee(id);
                    return emp ? `<span class="team-chip"><span class="team-chip-avatar">${emp.initials}</span>${emp.name}</span>` : '';
                }).join('');
        }

        function renderTeamModal() {
            const list = document.getElementById('teamMemberList');
            if (!list) return;
            list.innerHTML = projectTeam.length === 0
                ? `<p class="text-muted small text-center mb-0">No team members added yet.</p>`
                : projectTeam.map(id => {
                    const emp = getEmployee(id);
                    if (!emp) return '';
                    const taskCount = projectTasks.filter(t => t.assigneeId === id).length;
                    return `
                        <div class="team-member-row">
                            <span class="assignee-avatar">${emp.initials}</span>
                            <div class="flex-grow-1">
                                <p class="team-member-name">${emp.name}</p>
                                <p class="team-member-tasks">${taskCount} task${taskCount !== 1 ? 's' : ''} on this project</p>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" onclick="removeTeamMember('${id}')">
                                <span class="material-symbols-outlined" style="font-size:15px;vertical-align:middle;">person_remove</span>
                            </button>
                        </div>`;
                }).join('');

            const sel = document.getElementById('addTeamMemberSelect');
            const remaining = EMPLOYEES.filter(e => !projectTeam.includes(e.id));
            sel.innerHTML = remaining.length === 0
                ? '<option value="">All employees are already on the team</option>'
                : '<option value="">— Select employee —</option>' + remaining.map(e => `<option value="${e.id}">${e.name}</option>`).join('');

            document.getElementById('team-avail-note').style.display = '';
            document.getElementById('team-avail-card').style.display = 'none';
            document.getElementById('team-avail-card').innerHTML = '';
            document.getElementById('team-add-confirm').style.display = 'none';
        }

        function refreshTeamAvailCard() {
            const empId = document.getElementById('addTeamMemberSelect').value;
            const start = '2026-03-10';
            const end   = '2026-03-20';
            const note  = document.getElementById('team-avail-note');
            const card  = document.getElementById('team-avail-card');
            const confirm = document.getElementById('team-add-confirm');

            if (!empId) { note.style.display = ''; card.style.display = 'none'; card.innerHTML = ''; confirm.style.display = 'none'; return; }

            const emp = getEmployee(empId);
            card.innerHTML = `<div class="row g-3">${buildAvailCard(emp, start, end, null, false, true, false)}</div>`;
            note.style.display = 'none';
            card.style.display = '';
            confirm.style.display = '';
        }

        function confirmAddTeamMember() {
            const empId = document.getElementById('addTeamMemberSelect').value;
            if (!empId || projectTeam.includes(empId)) return;
            projectTeam.push(empId);
            renderTeamChips();
            renderTeamModal();
        }

        function removeTeamMember(id) {
            const taskCount = projectTasks.filter(t => t.assigneeId === id).length;
            if (taskCount > 0 && !confirm(`${getEmployeeName(id)} has ${taskCount} task(s) on this project. Remove them from the team anyway?\n\nExisting task assignments will remain.`)) return;
            projectTeam = projectTeam.filter(t => t !== id);
            renderTeamChips();
            renderTeamModal();
        }

        document.getElementById('manageTeamModal')?.addEventListener('show.bs.modal', renderTeamModal);

        function renderChecklist() {
            const list = document.getElementById('checklistTaskList');
            const filtered = activeChecklistFilter === 'all' ? projectTasks : projectTasks.filter(t => t.status === activeChecklistFilter);

            document.getElementById('tab-count-all').textContent   = projectTasks.length;
            document.getElementById('tab-count-todo').textContent   = projectTasks.filter(t => t.status === 'To Do').length;
            document.getElementById('tab-count-inprog').textContent = projectTasks.filter(t => t.status === 'In Progress').length;
            document.getElementById('tab-count-done').textContent   = projectTasks.filter(t => t.status === 'Done').length;
            document.getElementById('tab-count-hold').textContent   = projectTasks.filter(t => t.status === 'On Hold').length;

            if (filtered.length === 0) {
                list.innerHTML = `<div class="text-center py-4 text-muted">
                    <span class="material-symbols-outlined" style="font-size:36px;opacity:.3;">task_alt</span>
                    <p class="small mt-2 mb-0">${activeChecklistFilter === 'all' ? 'No tasks yet. Click <strong>Add Task</strong> to get started.' : 'No tasks with this status.'}</p>
                </div>`;
            } else {
                const statusClass = { 'Done': 'status-done', 'In Progress': 'status-inprogress', 'On Hold': 'status-onhold', 'To Do': '' };
                list.innerHTML = filtered.map(task => {
                    const emp = getEmployee(task.assigneeId);
                    const overdue = task.status !== 'Done' && task.due < todayYmd();
                    const assigneeHtml = emp
                        ? `<span class="assignee-chip"><span class="chip-avatar">${emp.initials}</span>${emp.name}</span>`
                        : `<span class="assignee-chip unassigned">Unassigned</span>`;
                    return `
                        <div class="task-item-card ${statusClass[task.status] || ''}" id="task-card-${task.id}">
                            <div class="d-flex align-items-start gap-3">
                                <div class="task-checkbox ${task.status === 'Done' ? 'checked' : ''}" onclick="toggleTaskDone(${task.id})" title="${task.status === 'Done' ? 'Mark as To Do' : 'Mark as Done'}">
                                    <span class="material-symbols-outlined">${task.status === 'Done' ? 'check_circle' : 'radio_button_unchecked'}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="task-item-title ${task.status === 'Done' ? 'text-decoration-line-through text-muted' : ''}">${task.name}</p>
                                    <p class="task-item-project">${task.project}</p>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    ${priorityBadge(task.priority)}
                                    ${statusBadge(task.status)}
                                    ${task.status !== 'Done' ? `<button class="btn btn-sm btn-outline-primary" onclick="openEditTask(${task.id})"><span class="material-symbols-outlined" style="font-size:15px;vertical-align:middle;">edit</span></button>` : ''}
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeTask(${task.id})"><span class="material-symbols-outlined" style="font-size:15px;vertical-align:middle;">delete</span></button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-wrap small text-muted mt-2" style="padding-left:36px;">
                                <span><span class="material-symbols-outlined" style="font-size:13px;vertical-align:middle;">calendar_today</span> ${fmtDate(task.start)} – <span class="${overdue ? 'text-danger fw-semibold' : ''}">${fmtDate(task.due)}</span></span>
                                ${assigneeHtml}
                            </div>
                        </div>`;
                }).join('');
            }
            updateProjectProgress();
        }

        function updateProjectProgress() {
            const total = projectTasks.length;
            const done  = projectTasks.filter(t => t.status === 'Done').length;
            const pct   = total === 0 ? 0 : Math.round((done / total) * 100);
            document.getElementById('taskProgressBar').style.width    = pct + '%';
            document.getElementById('taskProgressLabel').textContent  = `${done} / ${total} task${total !== 1 ? 's' : ''} completed`;
            document.getElementById('taskProgressPct').textContent    = pct + '%';
            document.getElementById('headerProgressBar').style.width  = pct + '%';
            document.getElementById('headerProgressPct').textContent  = pct + '%';
        }

        function toggleTaskDone(id) {
            const task = projectTasks.find(t => t.id === id);
            if (!task) return;
            task.status = task.status === 'Done' ? 'To Do' : 'Done';
            renderChecklist();
        }

        function removeTask(id) {
            if (!confirm('Remove this task from the checklist?')) return;
            projectTasks = projectTasks.filter(t => t.id !== id);
            renderChecklist();
        }

        document.getElementById('checklistTabs').addEventListener('click', function(e) {
            const btn = e.target.closest('[data-tab]');
            if (!btn) return;
            this.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeChecklistFilter = btn.dataset.tab;
            renderChecklist();
        });

        document.getElementById('taskChecklistModal').addEventListener('show.bs.modal', renderChecklist);

        function refreshTaskGrid() {
            const start = document.getElementById('at-start').value;
            const end   = document.getElementById('at-due').value;
            const note  = document.getElementById('at-no-date-note');
            const grid  = document.getElementById('at-emp-grid');

            if (!start || !end || start > end) {
                note.style.display = ''; grid.style.display = 'none'; grid.innerHTML = '';
                selectedAssigneeId = null; document.getElementById('at-save-btn').disabled = true; return;
            }

            note.style.display = 'none';
            grid.style.display = '';
            grid.innerHTML = projectTeam.map(empId => {
                const emp = getEmployee(empId);
                return emp ? buildAvailCard(emp, start, end, editingTaskId, true, false, selectedAssigneeId === empId) : '';
            }).join('');
            document.getElementById('at-save-btn').disabled = !selectedAssigneeId;
        }

        document.getElementById('at-start').addEventListener('change', () => { selectedAssigneeId = null; refreshTaskGrid(); });
        document.getElementById('at-due').addEventListener('change',  () => { selectedAssigneeId = null; refreshTaskGrid(); });

        function openAssignTaskPanel() {
            editingTaskId = null; selectedAssigneeId = null;
            document.getElementById('assignTaskModalTitle').textContent = 'Add Task';
            document.getElementById('at-save-label').textContent        = 'Add Task';
            document.getElementById('at-task-id').value = '';
            document.getElementById('at-name').value    = '';
            document.getElementById('at-priority').value = 'Medium';
            document.getElementById('at-status').value   = 'To Do';
            document.getElementById('at-start').value    = '';
            document.getElementById('at-due').value      = '';
            document.getElementById('at-no-date-note').style.display = '';
            document.getElementById('at-emp-grid').style.display     = 'none';
            document.getElementById('at-emp-grid').innerHTML         = '';
            document.getElementById('at-save-btn').disabled = true;
            new bootstrap.Modal(document.getElementById('assignTaskModal')).show();
        }

        function openEditTask(id) {
            const task = projectTasks.find(t => t.id === id);
            if (!task) return;
            editingTaskId = id; selectedAssigneeId = task.assigneeId || null;
            document.getElementById('assignTaskModalTitle').textContent = 'Edit Task';
            document.getElementById('at-save-label').textContent        = 'Save Changes';
            document.getElementById('at-task-id').value   = id;
            document.getElementById('at-name').value      = task.name;
            document.getElementById('at-priority').value  = task.priority;
            document.getElementById('at-status').value    = task.status;
            document.getElementById('at-start').value     = task.start;
            document.getElementById('at-due').value       = task.due;
            if (task.start && task.due) { document.getElementById('at-no-date-note').style.display = 'none'; document.getElementById('at-emp-grid').style.display = ''; refreshTaskGrid(); }
            else { document.getElementById('at-no-date-note').style.display = ''; document.getElementById('at-emp-grid').style.display = 'none'; }
            document.getElementById('at-save-btn').disabled = !selectedAssigneeId;
            new bootstrap.Modal(document.getElementById('assignTaskModal')).show();
        }

        function saveAssignTask() {
            const name       = document.getElementById('at-name').value.trim();
            const project    = document.getElementById('at-project').value.trim();
            const priority   = document.getElementById('at-priority').value;
            const status     = document.getElementById('at-status').value;
            const start      = document.getElementById('at-start').value;
            const due        = document.getElementById('at-due').value;
            const assigneeId = selectedAssigneeId;

            if (!name)    { alert('Please enter a task name.'); return; }
            if (!start || !due || start > due) { alert('Please enter a valid date range.'); return; }
            if (!assigneeId) { alert('Please select a team member to assign to.'); return; }

            if (editingTaskId !== null) {
                const task = projectTasks.find(t => t.id === editingTaskId);
                if (task) Object.assign(task, { name, priority, status, start, due, assigneeId });
            } else {
                projectTasks.push({ id: nextTaskId++, name, project, priority, status, start, due, assigneeId, updates: [] });
            }

            bootstrap.Modal.getInstance(document.getElementById('assignTaskModal')).hide();
            renderChecklist();
        }

        document.getElementById('assignTaskModal').addEventListener('hidden.bs.modal', () => {
            editingTaskId = null; selectedAssigneeId = null;
            document.getElementById('at-emp-grid').innerHTML = '';
            document.getElementById('at-save-btn').disabled = true;
        });

        function previewImages(input) {
            const strip = document.getElementById('imagePreviewStrip');
            const count = document.getElementById('imageCount');
            strip.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result; img.className = 'preview-thumb'; strip.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
            const n = input.files.length;
            count.textContent = n > 0 ? `${n} image${n > 1 ? 's' : ''} selected` : '';
        }

        function previewContractFiles(input) {
            const grid = document.getElementById('contractPreviewGrid');
            Array.from(input.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result; img.className = 'update-thumb'; img.style.cursor = 'default'; grid.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    const chip = document.createElement('div');
                    chip.className = 'contract-file-chip';
                    chip.innerHTML = `<span class="material-symbols-outlined" style="font-size:15px;color:#ef4444;">picture_as_pdf</span>${file.name}<button class="btn-chip-remove" onclick="this.parentElement.remove()"><span class="material-symbols-outlined" style="font-size:13px;">close</span></button>`;
                    grid.appendChild(chip);
                }
            });
        }

        function postUpdate() {
            const textarea = document.getElementById('updateText');
            const strip    = document.getElementById('imagePreviewStrip');
            const text     = textarea.value.trim();
            if (!text) { textarea.focus(); return; }

            const now = new Date().toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
            let imgHtml = '';
            strip.querySelectorAll('img').forEach(img => {
                imgHtml += `<img src="${img.src}" class="update-thumb" alt="Update image" onclick="openLightbox(this.src)" data-bs-toggle="modal" data-bs-target="#lightboxModal">`;
            });

            const item = document.createElement('div');
            item.className = 'timeline-item';
            item.innerHTML = `
                <div class="tl-left"><div class="tl-dot"></div><div class="tl-line"></div></div>
                <div class="tl-body">
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <div class="update-avatar sm">AD</div>
                        <span class="small fw-semibold">Admin</span>
                        <span class="text-muted small">·</span>
                        <span class="text-muted small">${now}</span>
                    </div>
                    <p class="small mb-2">${text}</p>
                    ${imgHtml ? `<div class="update-images">${imgHtml}</div>` : ''}
                </div>`;

            const timeline = document.getElementById('updateTimeline');
            const first = timeline.querySelector('.timeline-item');
            if (first) first.classList.remove('last');
            timeline.insertBefore(item, timeline.firstChild);
            textarea.value = '';
            strip.innerHTML = '';
            document.getElementById('imageCount').textContent = '';
            document.getElementById('updateImageInput').value = '';
        }

        function openLightbox(src) { document.getElementById('lightboxImg').src = src; }

        updateProjectProgress();
        renderChecklist();
        renderTeamChips();
    </script>
@endsection