@extends('layouts.client')

@section('title', 'Project Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/project-monitoring.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Project Details</h2>
            <p>CCTV Installation – Santos Residence</p>
        </div>

        <div class="main-content">

            <div class="mb-3">
                <a href="{{ route('client-project') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" style="width:fit-content;">
                    <span class="material-symbols-outlined fs-15">arrow_back</span>
                    Back to Projects
                </a>
            </div>

            <!-- Project Header Card -->
            <div class="detail-card mb-4">
                <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-3 mb-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h4 class="fw-bold mb-0">CCTV Installation — Santos Residence</h4>
                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">Active</span>
                        </div>
                        <p class="text-muted small mb-1">
                            <span class="material-symbols-outlined text-muted fs-14" style="vertical-align:middle;">location_on</span>
                            123 Rizal St, Quezon City
                        </p>
                        <p class="text-muted small mb-0">
                            <span class="service-badge badge-green me-2">CCTV Setup</span>
                            Mar 10, 2026 &nbsp;—&nbsp; Mar 20, 2026
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <span class="progress-pct" id="headerProgressPct">65%</span>
                    </div>
                </div>

                <div class="progress mb-4" style="height:10px;border-radius:8px;">
                    <div class="progress-bar bg-success" id="headerProgressBar" style="width:65%;border-radius:8px;"></div>
                </div>

                <!-- Project Team (read-only) -->
                <div class="d-flex align-items-center gap-2 flex-wrap mb-3 pb-3 border-bottom">
                    <span class="small fw-semibold text-muted me-1">Project Team:</span>
                    <span class="team-chip"><span class="team-chip-avatar">CM</span>Carlo Mendoza</span>
                    <span class="team-chip"><span class="team-chip-avatar">MR</span>Marco Rivera</span>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#contractModal">
                        <span class="material-symbols-outlined fs-17">description</span>
                        View Contract Files
                    </button>
                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#taskChecklistModal">
                        <span class="material-symbols-outlined fs-17">checklist</span>
                        View Checklist
                    </button>
                    <a href="{{ route('assessment-form', 'ASM-2026-001') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">assignment</span>
                        View Assessment
                    </a>
                    <a href="{{ route('quotation-view', 'QT-2026-002') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">request_quote</span>
                        View Quotation
                    </a>
                </div>
            </div>


            <!-- Project Updates (read-only) -->
            <div class="detail-card">
                <h6 class="fw-semibold mb-4 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-success fs-20">timeline</span>
                    Project Updates
                </h6>

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


    <!-- ── Task Checklist Modal (read-only) ── -->
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
                        <p class="small text-muted mb-0" id="taskProgressLabel">9 / 13 tasks completed</p>
                        <span class="fw-bold text-success small" id="taskProgressPct">69%</span>
                    </div>
                    <div class="checklist-progress-bar mb-3">
                        <div class="bar-fill" id="taskProgressBar" style="width:69%"></div>
                    </div>

                    <ul class="nav checklist-tabs border-bottom w-auto mb-3" id="checklistTabs">
                        <li class="nav-item"><button class="nav-link active" data-tab="all">All <span class="badge bg-secondary" id="tab-count-all">13</span></button></li>
                        <li class="nav-item"><button class="nav-link" data-tab="To Do">To Do <span class="badge bg-secondary" id="tab-count-todo">2</span></button></li>
                        <li class="nav-item"><button class="nav-link" data-tab="In Progress">In Progress <span class="badge bg-warning text-dark" id="tab-count-inprog">2</span></button></li>
                        <li class="nav-item"><button class="nav-link" data-tab="Done">Done <span class="badge bg-success" id="tab-count-done">9</span></button></li>
                    </ul>

                    <div id="checklistTaskList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Contract Files Modal (view/download only) ── -->
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
                    <p class="small fw-semibold text-muted text-uppercase mb-2" style="letter-spacing:.05em;">Uploaded Files</p>
                    <div class="d-flex flex-column gap-2" id="contractUploadedFiles">
                        <a href="#" class="contract-file-row text-decoration-none">
                            <span class="material-symbols-outlined fs-18 green-text">image</span>
                            <span class="flex-grow-1">contract-page-1.jpg</span>
                            <span class="material-symbols-outlined fs-18 text-muted">download</span>
                        </a>
                        <a href="#" class="contract-file-row text-decoration-none">
                            <span class="material-symbols-outlined fs-18" style="color:#ef4444;">picture_as_pdf</span>
                            <span class="flex-grow-1">signed-contract.pdf</span>
                            <span class="material-symbols-outlined fs-18 text-muted">download</span>
                        </a>
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
        // Static demo data — read-only checklist for the client view
        const projectTasks = [
            { name: 'Site Survey & Measurements', assignee: 'Carlo Mendoza', initials: 'CM', priority: 'High', start: '2026-03-01', due: '2026-03-02', status: 'Done' },
            { name: 'Equipment Procurement & Staging', assignee: 'Marco Rivera', initials: 'MR', priority: 'High', start: '2026-03-03', due: '2026-03-04', status: 'Done' },
            { name: 'Mount Indoor Camera Brackets', assignee: 'Carlo Mendoza', initials: 'CM', priority: 'Medium', start: '2026-03-05', due: '2026-03-06', status: 'Done' },
            { name: 'Mount Outdoor Camera Brackets', assignee: 'Jomar Tan', initials: 'JT', priority: 'Medium', start: '2026-03-06', due: '2026-03-07', status: 'Done' },
            { name: 'Run Power & Video Cabling', assignee: 'Carlo Mendoza', initials: 'CM', priority: 'High', start: '2026-03-07', due: '2026-03-09', status: 'Done' },
            { name: 'Install DVR Unit & Hard Drive', assignee: 'Marco Rivera', initials: 'MR', priority: 'High', start: '2026-03-09', due: '2026-03-10', status: 'Done' },
            { name: 'Connect Cameras to DVR', assignee: 'Carlo Mendoza', initials: 'CM', priority: 'High', start: '2026-03-10', due: '2026-03-11', status: 'Done' },
            { name: 'Configure DVR Recording Settings', assignee: 'Marco Rivera', initials: 'MR', priority: 'Medium', start: '2026-03-11', due: '2026-03-12', status: 'Done' },
            { name: 'Set Up Remote Viewing Access', assignee: 'Jomar Tan', initials: 'JT', priority: 'Medium', start: '2026-03-12', due: '2026-03-13', status: 'In Progress' },
            { name: 'Camera Angle Fine-Tuning', assignee: 'Carlo Mendoza', initials: 'CM', priority: 'Low', start: '2026-03-13', due: '2026-03-14', status: 'In Progress' },
            { name: 'Night Vision & Motion Test', assignee: 'Marco Rivera', initials: 'MR', priority: 'Medium', start: '2026-03-14', due: '2026-03-15', status: 'To Do' },
            { name: 'Client Walkthrough & Demo', assignee: 'Carlo Mendoza', initials: 'CM', priority: 'High', start: '2026-03-16', due: '2026-03-17', status: 'To Do' },
            { name: 'Sign-Off & Documentation', assignee: 'Jomar Tan', initials: 'JT', priority: 'High', start: '2026-03-18', due: '2026-03-18', status: 'To Do' },
        ];

        let activeChecklistFilter = 'all';

        function fmtDate(ymd) {
            return new Date(ymd + 'T00:00:00').toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function priorityBadge(p) {
            const map = { High: 'danger', Medium: 'warning text-dark', Low: 'success' };
            return `<span class="badge rounded-pill bg-${map[p] || 'secondary'}">${p}</span>`;
        }

        function statusBadge(s) {
            const map = { 'Done': 'success', 'To Do': 'secondary', 'In Progress': 'primary' };
            return `<span class="badge rounded-pill bg-${map[s] || 'secondary'}">${s}</span>`;
        }

        function renderChecklist() {
            const list = document.getElementById('checklistTaskList');
            const filtered = activeChecklistFilter === 'all' ? projectTasks : projectTasks.filter(t => t.status === activeChecklistFilter);

            if (filtered.length === 0) {
                list.innerHTML = `<div class="text-center py-4 text-muted">
                    <span class="material-symbols-outlined fs-36" style="opacity:.3;">task_alt</span>
                    <p class="small mt-2 mb-0">No tasks with this status.</p>
                </div>`;
                return;
            }

            const statusClass = { 'Done': 'status-done', 'In Progress': 'status-inprogress', 'To Do': '' };
            list.innerHTML = filtered.map(task => `
                <div class="task-item-card ${statusClass[task.status] || ''}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="task-checkbox readonly ${task.status === 'Done' ? 'checked' : ''}">
                            <span class="material-symbols-outlined">${task.status === 'Done' ? 'check_circle' : 'radio_button_unchecked'}</span>
                        </div>
                        <div class="flex-grow-1">
                            <p class="task-item-title ${task.status === 'Done' ? 'text-decoration-line-through text-muted' : ''}">${task.name}</p>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            ${priorityBadge(task.priority)}
                            ${statusBadge(task.status)}
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-wrap small text-muted mt-2" style="padding-left:36px;">
                        <span><span class="material-symbols-outlined fs-13" style="vertical-align:middle;">calendar_today</span> ${fmtDate(task.start)} – ${fmtDate(task.due)}</span>
                        <span class="assignee-chip"><span class="chip-avatar">${task.initials}</span>${task.assignee}</span>
                    </div>
                </div>`).join('');
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

        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
        }
    </script>
@endsection