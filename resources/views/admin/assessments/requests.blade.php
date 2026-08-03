@extends('layouts.admin')

@section('title', 'Client Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/request.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Assessment Requests')

@section('topbar-actions')
     <a href="{{ route('archive-requests') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Schedule
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">inbox</span>
                    <div>
                        <p class="summary-label">Total</p>
                        <p class="summary-value">18</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Confirmed</p>
                        <p class="summary-value">12</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                    <div>
                        <p class="summary-label">Pending</p>
                        <p class="summary-value">4</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Declined</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requests Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Approved">Confirmed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Pending</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="For Review">Declined</button>
                </div>

                <div class="table-responsive">
                    <table id="requestsTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Pref. Date</th>
                                <th class="border-0 small green-text">Slot</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- ROW 1: Pending -->
                            <tr>
                                <td>AWG-2026-0006</td>
                                <td>Elena Cruz</td>
                                <td>0922-111-2222</td>
                                <td>CCTV Setup</td>
                                <td>Mar 19, 2026</td>
                                <td>Morning</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0006', client:'Elena Cruz', contact:'0922-111-2222',
                          email:'elena@gmail.com', clientType:'Residential',
                          service:'CCTV Setup', establishment:'Home / Residence',
                          date:'Mar 19, 2026', slot:'Morning', status:'Pending', statusClass:'warning text-dark',
                          cluster:'Cluster 2', block:'Block 1', lot:'Lot 5',
                          brgy:'Brgy. Tanzang Luma II', city:'Imus', province:'Cavite', zip:'4103',
                          notes:'Wants 4 cameras around the house.'
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" title="Confirm"
                                        onclick="openAssignAssessorModal(this, 'AWG-2026-0006')">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Decline"
                                        onclick="openDeclineConfirm(this, 'AWG-2026-0006')">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive"
                                        onclick="openArchiveConfirm(this, 'AWG-2026-0006')">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <!-- ROW 2: Confirmed -->
                            <tr>
                                <td>AWG-2026-0007</td>
                                <td>Ramon dela Cruz</td>
                                <td>0933-222-3333</td>
                                <td>Solar Setup</td>
                                <td>Mar 21, 2026</td>
                                <td>Afternoon</td>
                                <td><span class="badge bg-success text-white rounded-pill">Confirmed</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0007', client:'Ramon dela Cruz', contact:'0933-222-3333',
                          email:'', clientType:'Commercial',
                          service:'Solar Setup', establishment:'Office / Commercial',
                          date:'Mar 21, 2026', slot:'Afternoon', status:'Confirmed', statusClass:'success',
                          cluster:'', block:'Block 4', lot:'Lot 9',
                          brgy:'Brgy. Palico IV', city:'Imus', province:'Cavite', zip:'4103',
                          notes:''
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Confirmed">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Confirmed">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive"
                                        onclick="openArchiveConfirm(this, 'AWG-2026-0007')">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <!-- ROW 3: Pending -->
                            <tr>
                                <td>AWG-2026-0005</td>
                                <td>Luz Reyes</td>
                                <td>0944-333-4444</td>
                                <td>Solar Street Light</td>
                                <td>Mar 14, 2026</td>
                                <td>Full Day</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0005', client:'Luz Reyes', contact:'0944-333-4444',
                          email:'luz@email.com', clientType:'Government/LGU',
                          service:'Solar Street Light', establishment:'Government Facility',
                          date:'Mar 14, 2026', slot:'Full Day', status:'Pending', statusClass:'warning text-dark',
                          cluster:'', block:'', lot:'',
                          brgy:'Brgy. Malagasang I', city:'Imus', province:'Cavite', zip:'4103',
                          notes:'Street lights along the barangay road.'
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" title="Confirm"
                                        onclick="openAssignAssessorModal(this, 'AWG-2026-0005')">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Decline"
                                        onclick="openDeclineConfirm(this, 'AWG-2026-0005')">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive"
                                        onclick="openArchiveConfirm(this, 'AWG-2026-0005')">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <!-- ROW 4: Declined -->
                            <tr>
                                <td>AWG-2026-0004</td>
                                <td>Ben Soriano</td>
                                <td>0955-444-5555</td>
                                <td>Public Address System</td>
                                <td>Mar 10, 2026</td>
                                <td>Morning</td>
                                <td><span class="badge bg-danger rounded-pill">Declined</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0004', client:'Ben Soriano', contact:'0955-444-5555',
                          email:'ben@email.com', clientType:'Commercial',
                          service:'Public Address System', establishment:'Office / Commercial',
                          date:'Mar 10, 2026', slot:'Morning', status:'Declined', statusClass:'danger',
                          cluster:'', block:'Block 2', lot:'Lot 7',
                          brgy:'Brgy. Anabu I-A', city:'Imus', province:'Cavite', zip:'4103',
                          notes:'PA system for office lobby.'
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Declined">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Declined">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive"
                                        onclick="openArchiveConfirm(this, 'AWG-2026-0004')">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- ── View Request Detail Modal ── -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:20px;">person_search</span>
                        Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Request Info -->
                        <div class="col-12">
                            <p class="section-label">Request Info</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Reference No.</p>
                            <p class="detail-value fw-semibold" id="vr-refNo">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Preferred Date</p>
                            <p class="detail-value" id="vr-date">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Time Slot</p>
                            <p class="detail-value" id="vr-slot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Status</p>
                            <p class="detail-value" id="vr-status">—</p>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Client Info -->
                        <div class="col-12">
                            <p class="section-label">Client Info</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Client Name</p>
                            <p class="detail-value fw-semibold" id="vr-client">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Contact Number</p>
                            <p class="detail-value" id="vr-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Email</p>
                            <p class="detail-value" id="vr-email">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Client Type</p>
                            <p class="detail-value" id="vr-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Service</p>
                            <p class="detail-value" id="vr-service">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Establishment Type</p>
                            <p class="detail-value" id="vr-establishment">—</p>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Location -->
                        <div class="col-12">
                            <p class="section-label">Location</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Cluster</p>
                            <p class="detail-value" id="vr-cluster">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Block</p>
                            <p class="detail-value" id="vr-block">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Lot</p>
                            <p class="detail-value" id="vr-lot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Barangay</p>
                            <p class="detail-value" id="vr-brgy">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">City / Municipality</p>
                            <p class="detail-value" id="vr-city">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Province</p>
                            <p class="detail-value" id="vr-province">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Zip Code</p>
                            <p class="detail-value" id="vr-zip">—</p>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <p class="detail-label">Notes</p>
                            <p class="detail-value" id="vr-notes">—</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" id="vr-footer-actions">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="modal-decline-btn">Decline</button>
                    <button type="button" class="btn btn-success" id="modal-confirm-btn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Assign Assessor Modal (shown on Confirm) ── -->
    <div class="modal fade" id="assignAssessorModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title d-flex align-items-center gap-2 text-success">
                        <span class="material-symbols-outlined fs-18">groups</span>
                        Assign Assessors
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-1">Confirming request <strong id="aa-refNo">—</strong></p>
                    <p class="text-muted small mb-3">Select up to 3 employees to assess this request.</p>

                    <div class="d-flex flex-column gap-2" id="aa-employee-list">
                        <label class="assessor-check-row">
                            <input type="checkbox" class="form-check-input assessor-checkbox" value="Marco Rivera">
                            <span class="assessor-avatar">MR</span>
                            <span class="flex-grow-1">Marco Rivera</span>
                        </label>
                        <label class="assessor-check-row">
                            <input type="checkbox" class="form-check-input assessor-checkbox" value="Carlo Mendoza">
                            <span class="assessor-avatar">CM</span>
                            <span class="flex-grow-1">Carlo Mendoza</span>
                        </label>
                        <label class="assessor-check-row">
                            <input type="checkbox" class="form-check-input assessor-checkbox" value="Jomar Tan">
                            <span class="assessor-avatar">JT</span>
                            <span class="flex-grow-1">Jomar Tan</span>
                        </label>
                        <label class="assessor-check-row">
                            <input type="checkbox" class="form-check-input assessor-checkbox" value="Ana Garcia">
                            <span class="assessor-avatar">AG</span>
                            <span class="flex-grow-1">Ana Garcia</span>
                        </label>
                        <label class="assessor-check-row">
                            <input type="checkbox" class="form-check-input assessor-checkbox" value="Paolo Reyes">
                            <span class="assessor-avatar">PR</span>
                            <span class="flex-grow-1">Paolo Reyes</span>
                        </label>
                    </div>

                    <div class="alert alert-warning py-2 px-3 mt-3 mb-0 small d-none" id="aa-limit-warning">
                        <span class="material-symbols-outlined fs-15" style="vertical-align:middle;">warning</span>
                        You can only assign up to 3 assessors.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success btn-sm px-4" id="aa-confirm-btn" disabled>
                        <span class="material-symbols-outlined fs-15" style="vertical-align:middle;">check_circle</span>
                        Confirm Request
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Decline Confirm Modal ── -->
    <div class="modal fade" id="declineConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold text-danger">Decline this request?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        Are you sure you want to decline request <strong id="dc-refNo">—</strong>?
                        This action cannot be undone, and the client will be notified.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1" id="dc-confirm-btn">
                        <span class="material-symbols-outlined fs-15">cancel</span>
                        Decline Request
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
                    <h6 class="modal-title fw-semibold">Archive this request?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        Request <strong id="ac-refNo">—</strong> will be moved to the archive. You can restore it anytime from <strong>View Archives</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1" id="ac-confirm-btn">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        function loadRequestDetail(d) {
            document.getElementById('vr-refNo').textContent = d.refNo || '—';
            document.getElementById('vr-date').textContent = d.date || '—';
            document.getElementById('vr-slot').textContent = d.slot || '—';
            document.getElementById('vr-client').textContent = d.client || '—';
            document.getElementById('vr-contact').textContent = d.contact || '—';
            document.getElementById('vr-email').textContent = d.email || '—';
            document.getElementById('vr-clientType').textContent = d.clientType || '—';
            document.getElementById('vr-service').textContent = d.service || '—';
            document.getElementById('vr-establishment').textContent = d.establishment || '—';
            document.getElementById('vr-cluster').textContent = d.cluster || '—';
            document.getElementById('vr-block').textContent = d.block || '—';
            document.getElementById('vr-lot').textContent = d.lot || '—';
            document.getElementById('vr-brgy').textContent = d.brgy || '—';
            document.getElementById('vr-city').textContent = d.city || '—';
            document.getElementById('vr-province').textContent = d.province || '—';
            document.getElementById('vr-zip').textContent = d.zip || '—';
            document.getElementById('vr-notes').textContent = d.notes || '—';
            document.getElementById('vr-status').innerHTML =
                `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;

            const confirmBtn = document.getElementById('modal-confirm-btn');
            const declineBtn = document.getElementById('modal-decline-btn');
            confirmBtn.style.display = d.status === 'Pending' ? 'inline-block' : 'none';
            declineBtn.style.display = d.status === 'Pending' ? 'inline-block' : 'none';
        }

        /* ─────────────────────────────────────────
           CONFIRM → ASSIGN ASSESSORS FLOW
           ───────────────────────────────────────── */
        let pendingConfirmBtn = null;
        let pendingConfirmRefNo = null;
        const MAX_ASSESSORS = 3;

        const assignAssessorModalEl = document.getElementById('assignAssessorModal');
        const assignAssessorModal = new bootstrap.Modal(assignAssessorModalEl);
        const assessorCheckboxes = document.querySelectorAll('.assessor-checkbox');
        const aaConfirmBtn = document.getElementById('aa-confirm-btn');
        const aaLimitWarning = document.getElementById('aa-limit-warning');

        function openAssignAssessorModal(btn, refNo) {
            pendingConfirmBtn = btn;
            pendingConfirmRefNo = refNo;
            document.getElementById('aa-refNo').textContent = refNo;

            // Reset checkboxes each time the modal opens
            assessorCheckboxes.forEach(cb => {
                cb.checked = false;
                cb.disabled = false;
            });
            aaLimitWarning.classList.add('d-none');
            aaConfirmBtn.disabled = true;

            assignAssessorModal.show();
        }

        assessorCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.assessor-checkbox:checked').length;

                if (checkedCount >= MAX_ASSESSORS) {
                    assessorCheckboxes.forEach(other => {
                        if (!other.checked) other.disabled = true;
                    });
                    aaLimitWarning.classList.remove('d-none');
                } else {
                    assessorCheckboxes.forEach(other => other.disabled = false);
                    aaLimitWarning.classList.add('d-none');
                }

                aaConfirmBtn.disabled = checkedCount === 0;
            });
        });

        aaConfirmBtn.addEventListener('click', function() {
            const selectedAssessors = Array.from(document.querySelectorAll('.assessor-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedAssessors.length === 0 || !pendingConfirmBtn) return;

            const row = pendingConfirmBtn.closest('tr');
            row.querySelector('.badge').className = 'badge bg-success text-white rounded-pill';
            row.querySelector('.badge').textContent = 'Confirmed';
            row.querySelectorAll('.btn-outline-success, .btn-outline-danger').forEach(b => {
                if (b.title === 'Confirm' || b.title === 'Decline') {
                    b.classList.replace('btn-outline-success', 'btn-outline-secondary');
                    b.classList.replace('btn-outline-danger', 'btn-outline-secondary');
                    b.disabled = true;
                    b.title = b.title === 'Confirm' ? 'Already Confirmed' : 'Already Confirmed';
                }
            });

            // In a real app: send selectedAssessors + pendingConfirmRefNo to the server here.
            console.log('Confirmed', pendingConfirmRefNo, 'with assessors:', selectedAssessors);

            assignAssessorModal.hide();
            pendingConfirmBtn = null;
            pendingConfirmRefNo = null;
        });

        /* ─────────────────────────────────────────
           DECLINE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingDeclineBtn = null;

        const declineConfirmModalEl = document.getElementById('declineConfirmModal');
        const declineConfirmModal = new bootstrap.Modal(declineConfirmModalEl);

        function openDeclineConfirm(btn, refNo) {
            pendingDeclineBtn = btn;
            document.getElementById('dc-refNo').textContent = refNo;
            declineConfirmModal.show();
        }

        document.getElementById('dc-confirm-btn').addEventListener('click', function() {
            if (!pendingDeclineBtn) return;
            const row = pendingDeclineBtn.closest('tr');
            row.querySelector('.badge').className = 'badge bg-danger rounded-pill';
            row.querySelector('.badge').textContent = 'Declined';
            row.querySelectorAll('.btn-outline-success, .btn-outline-danger').forEach(b => {
                b.classList.replace('btn-outline-success', 'btn-outline-secondary');
                b.classList.replace('btn-outline-danger', 'btn-outline-secondary');
                b.disabled = true;
            });
            declineConfirmModal.hide();
            pendingDeclineBtn = null;
        });

        /* ─────────────────────────────────────────
           ARCHIVE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingArchiveBtn = null;

        const archiveConfirmModalEl = document.getElementById('archiveConfirmModal');
        const archiveConfirmModal = new bootstrap.Modal(archiveConfirmModalEl);

        function openArchiveConfirm(btn, refNo) {
            pendingArchiveBtn = btn;
            document.getElementById('ac-refNo').textContent = refNo;
            archiveConfirmModal.show();
        }

        document.getElementById('ac-confirm-btn').addEventListener('click', function() {
            if (!pendingArchiveBtn) return;
            const row = pendingArchiveBtn.closest('tr');
            // In a real app: send an archive request to the server, then remove/hide the row.
            row.remove();
            archiveConfirmModal.hide();
            pendingArchiveBtn = null;
        });

        $(document).ready(function() {
            $('#requestsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                    targets: 7,
                    orderable: false
                }]
            });
        });
    </script>
@endsection