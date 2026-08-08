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

    @php
        $statusBadgeClass = [
            'Pending' => 'warning text-dark',
            'Confirmed' => 'success text-white',
            'Declined' => 'danger',
        ];
    @endphp

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">inbox</span>
                    <div>
                        <p class="summary-label">Total</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Confirmed</p>
                        <p class="summary-value">{{ $confirmed }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                    <div>
                        <p class="summary-label">Pending</p>
                        <p class="summary-value">{{ $pending }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Declined</p>
                        <p class="summary-value">{{ $declined }}</p>
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
                        data-filter="Confirmed">Confirmed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Pending">Pending</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Declined">Declined</button>
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

                            @forelse ($assessments as $assessment)
                                @php
                                    $refNo =
                                        'AWG-' .
                                        $assessment->created_at->format('Y') .
                                        '-' .
                                        str_pad($assessment->id, 4, '0', STR_PAD_LEFT);
                                    $badgeClass = $statusBadgeClass[$assessment->status] ?? 'secondary';
                                    $isPending = $assessment->status === 'Pending';
                                    $client = $assessment->client;
                                    $clientUser = $client->user;
                                @endphp
                                <tr data-status="{{ $assessment->status }}">
                                    <td>{{ $refNo }}</td>
                                    <td>{{ $clientUser->full_name }}</td>
                                    <td>{{ $clientUser->contact_number ?? '—' }}</td>
                                    <td>{{ implode(', ', $assessment->services ?? []) }}</td>
                                    <td data-order="{{ $assessment->preferred_date->format('Y-m-d') }}">
                                        {{ $assessment->preferred_date->format('M j, Y') }}
                                    </td>
                                    <td>{{ $assessment->time_slot }}</td>
                                    <td><span
                                            class="badge bg-{{ $badgeClass }} rounded-pill">{{ $assessment->status }}</span>
                                    </td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-sm btn-outline-success" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                            onclick="loadRequestDetail({
                                id: {{ $assessment->id }},
                                refNo: {{ Js::from($refNo) }},
                                client: {{ Js::from($clientUser->full_name) }},
                                contact: {{ Js::from($clientUser->contact_number ?? '—') }},
                                email: {{ Js::from($clientUser->email ?? '—') }},
                                clientType: {{ Js::from($assessment->client_type) }},
                                service: {{ Js::from(implode(', ', $assessment->services ?? [])) }},
                                establishment: {{ Js::from($assessment->establishment_type) }},
                                date: {{ Js::from($assessment->preferred_date->format('M j, Y')) }},
                                slot: {{ Js::from($assessment->time_slot) }},
                                status: {{ Js::from($assessment->status) }},
                                statusClass: {{ Js::from($badgeClass) }},
                                block: {{ Js::from($client->block ?? '—') }},
                                lot: {{ Js::from($client->lot ?? '—') }},
                                brgy: {{ Js::from($client->barangay ?? '—') }},
                                city: {{ Js::from($client->city ?? '—') }},
                                province: {{ Js::from($client->province ?? '—') }},
                                zip: {{ Js::from($client->zip_code ?? '—') }},
                                notes: {{ Js::from($assessment->notes ?? '') }}
                            })">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>

                                        @if ($isPending)
                                            <button class="btn btn-sm btn-outline-success" title="Confirm"
                                                onclick="openAssignAssessorModal(this, {{ $assessment->id }}, {{ Js::from($refNo) }})">
                                                <span class="material-symbols-outlined icon-action">check_circle</span>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" title="Decline"
                                                onclick="openDeclineConfirm(this, {{ $assessment->id }}, {{ Js::from($refNo) }})">
                                                <span class="material-symbols-outlined icon-action">cancel</span>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled
                                                title="Already {{ $assessment->status }}">
                                                <span class="material-symbols-outlined icon-action">check_circle</span>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" disabled
                                                title="Already {{ $assessment->status }}">
                                                <span class="material-symbols-outlined icon-action">cancel</span>
                                            </button>
                                        @endif

                                        <button class="btn btn-sm btn-outline-secondary" title="Archive"
                                            onclick="openArchiveConfirm(this, {{ $assessment->id }}, {{ Js::from($refNo) }})">
                                            <span class="material-symbols-outlined icon-action">archive</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No assessment requests yet.
                                    </td>
                                </tr>
                            @endforelse

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
                        <div class="col-md-4">
                            <p class="detail-label">Block</p>
                            <p class="detail-value" id="vr-block">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Lot</p>
                            <p class="detail-value" id="vr-lot">—</p>
                        </div>
                        <div class="col-md-4">
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
                    <button type="button" class="btn btn-danger d-none" id="modal-decline-btn">Decline</button>
                    <button type="button" class="btn btn-success d-none" id="modal-confirm-btn">Confirm</button>
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
                        @forelse ($employees as $employee)
                            @php
                                $initials = collect(explode(' ', $employee->full_name))
                                    ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                    ->take(2)
                                    ->implode('');
                            @endphp
                            <label class="assessor-check-row">
                                <input type="checkbox" class="form-check-input assessor-checkbox"
                                    value="{{ $employee->id }}">
                                <span class="assessor-avatar">{{ $initials }}</span>
                                <span class="flex-grow-1">{{ $employee->full_name }}</span>
                            </label>
                        @empty
                            <p class="text-muted small mb-0">No employees available to assign.</p>
                        @endforelse
                    </div>

                    <div class="alert alert-warning py-2 px-3 mt-3 mb-0 small d-none" id="aa-limit-warning">
                        <span class="material-symbols-outlined fs-15" style="vertical-align:middle;">warning</span>
                        You can only assign up to 3 assessors.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
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
                    <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1"
                        id="dc-confirm-btn">
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
                        Request <strong id="ac-refNo">—</strong> will be moved to the archive. You can restore it anytime
                        from <strong>View Archives</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        id="ac-confirm-btn">
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
        /* URL templates — __ID__ gets swapped for the real assessment id before each fetch */
        const ROUTES = {
            confirm: {{ Js::from(route('requests.confirm', ['assessment' => '__ID__'])) }},
            decline: {{ Js::from(route('requests.decline', ['assessment' => '__ID__'])) }},
            archive: {{ Js::from(route('requests.archive', ['assessment' => '__ID__'])) }},
        };

        function csrfHeader() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

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
            const isPending = d.status === 'Pending';
            confirmBtn.classList.toggle('d-none', !isPending);
            declineBtn.classList.toggle('d-none', !isPending);

            confirmBtn.onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewRequestModal')).hide();
                openAssignAssessorModal(null, d.id, d.refNo);
            };
            declineBtn.onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewRequestModal')).hide();
                openDeclineConfirm(null, d.id, d.refNo);
            };
        }

        /* ─────────────────────────────────────────
           CONFIRM → ASSIGN ASSESSORS FLOW
           ───────────────────────────────────────── */
        let pendingConfirmBtn = null;
        let pendingConfirmId = null;
        const MAX_ASSESSORS = 3;

        const assignAssessorModalEl = document.getElementById('assignAssessorModal');
        const assignAssessorModal = new bootstrap.Modal(assignAssessorModalEl);
        const assessorCheckboxes = document.querySelectorAll('.assessor-checkbox');
        const aaConfirmBtn = document.getElementById('aa-confirm-btn');
        const aaLimitWarning = document.getElementById('aa-limit-warning');

        function openAssignAssessorModal(btn, id, refNo) {
            pendingConfirmBtn = btn;
            pendingConfirmId = id;
            document.getElementById('aa-refNo').textContent = refNo;

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
            const employeeIds = Array.from(document.querySelectorAll('.assessor-checkbox:checked'))
                .map(cb => parseInt(cb.value, 10));

            if (employeeIds.length === 0 || !pendingConfirmId) return;

            fetch(ROUTES.confirm.replace('__ID__', pendingConfirmId), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfHeader(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        employee_ids: employeeIds
                    }),
                })
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status,
                    data
                }) => {
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Unable to confirm this request.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    assignAssessorModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        /* ─────────────────────────────────────────
           DECLINE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingDeclineId = null;

        const declineConfirmModalEl = document.getElementById('declineConfirmModal');
        const declineConfirmModal = new bootstrap.Modal(declineConfirmModalEl);

        function openDeclineConfirm(btn, id, refNo) {
            pendingDeclineId = id;
            document.getElementById('dc-refNo').textContent = refNo;
            declineConfirmModal.show();
        }

        document.getElementById('dc-confirm-btn').addEventListener('click', function() {
            if (!pendingDeclineId) return;

            fetch(ROUTES.decline.replace('__ID__', pendingDeclineId), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfHeader(),
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status,
                    data
                }) => {
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Unable to decline this request.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    declineConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        /* ─────────────────────────────────────────
           ARCHIVE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingArchiveId = null;

        const archiveConfirmModalEl = document.getElementById('archiveConfirmModal');
        const archiveConfirmModal = new bootstrap.Modal(archiveConfirmModalEl);

        function openArchiveConfirm(btn, id, refNo) {
            pendingArchiveId = id;
            document.getElementById('ac-refNo').textContent = refNo;
            archiveConfirmModal.show();
        }

        document.getElementById('ac-confirm-btn').addEventListener('click', function() {
            if (!pendingArchiveId) return;

            fetch(ROUTES.archive.replace('__ID__', pendingArchiveId), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfHeader(),
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status,
                    data
                }) => {
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Unable to archive this request.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    archiveConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        /* ─── DataTable + status filter buttons ─── */
        $(document).ready(function() {
            const table = $('#requestsTable').DataTable({
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

            $('#statusFilterGroup button').on('click', function() {
                $('#statusFilterGroup button').removeClass('active');
                $(this).addClass('active');

                const filter = $(this).data('filter');
                if (filter === 'all') {
                    table.column(6).search('').draw();
                } else {
                    table.column(6).search(filter).draw();
                }
            });
        });
    </script>
@endsection
