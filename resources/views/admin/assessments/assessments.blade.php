@extends('layouts.admin')

@section('title', 'Assessment Schedule')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/assessments.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

@section('page-title', 'Assessments')

@section('topbar-actions')
    <a href="{{ route('archive-assessments') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <a href="{{ route('requests') }}" class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text">
        View Assessment Requests
    </a>
@endsection

<div class="container-fluid px-4 py-4">

    <!-- Tabs -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <ul class="nav nav-tabs border-0 mb-0" id="assessmentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-view"
                    type="button">
                    Calendar View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button">
                    List View
                </button>
            </li>
        </ul>

    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="assessmentTabsContent">

        <!-- ── Calendar View ── -->
        <div class="tab-pane fade show active" id="calendar-view" role="tabpanel">
            <div class="calendar-container">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0" id="calendar-month-label">—</h5>
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-sm btn-light border" onclick="changeMonth(-1)">
                            <span class="material-symbols-outlined fs-5">chevron_left</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-light border" onclick="changeMonth(1)">
                            <span class="material-symbols-outlined fs-5">chevron_right</span>
                        </button>
                    </div>
                </div>

                <div class="full-calendar-grid" id="full-calendar-grid">
                    <!-- entirely rendered by JS from window.assessmentsByDate -->
                </div>

                <div class="d-flex flex-wrap gap-4 mt-3 small text-muted">
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#d4f1e0;border:1px solid #aaa;"></span> Available
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#e0f7fa;"></span> Has Assessment(s)
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:var(--awg-primary);"></span> Today
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#f8f9fa;border:1px solid #dee2e6;"></span> No Work
                        (Sunday)
                    </div>
                </div>

            </div>
        </div>

        <!-- ── List View ── -->
        <div class="tab-pane fade" id="list-view" role="tabpanel">
            <div class="row g-3 mb-4">

                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon muted-text">inbox</span>
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
                            <p class="summary-label">Done Assessment</p>
                            <p class="summary-value">{{ $doneCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-primary">description</span>
                        <div>
                            <p class="summary-label">Submitted Form</p>
                            <p class="summary-value">{{ $submittedFormCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                        <div>
                            <p class="summary-label">Pending</p>
                            <p class="summary-value">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                            <button type="button" class="btn btn-sm btn-outline-secondary active"
                                data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-filter="Pending">Pending</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-filter="Done Assessment">
                                Done Assessment
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="assessmentTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Date</th>
                                    <th class="border-0 small green-text">Slot</th>
                                    <th class="border-0 small green-text">Client</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Assessor(s)</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessments as $a)
                                    @php
                                        $client = $a->client;
                                        $clientUser = $client->user;
                                        $assessorNames = $a->assessors->pluck('full_name')->implode(', ') ?: '—';
                                    @endphp
                                    <tr data-status="{{ $a->derived_status }}">
                                        <td data-order="{{ $a->preferred_date->format('Y-m-d') }}">
                                            {{ $a->preferred_date->format('M j, Y') }}
                                        </td>
                                        <td>{{ $a->time_slot }}</td>
                                        <td>{{ $clientUser->full_name }}</td>
                                        <td>{{ implode(', ', $a->services ?? []) }}</td>
                                        <td>{{ $assessorNames }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill {{ $a->derived_status === 'Done Assessment' ? 'bg-success' : ($a->derived_status === 'Submitted Form' ? 'bg-primary text-white' : 'bg-warning text-dark') }}">
                                                {{ $a->derived_status }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-outline-success" title="View Details"
                                                data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                                onclick="loadAssessmentDetail({
                                    date: {{ Js::from($a->preferred_date->format('M j, Y')) }},
                                    time: {{ Js::from($a->time_slot) }},
                                    client: {{ Js::from($clientUser->full_name) }},
                                    contact: {{ Js::from($clientUser->contact_number ?? '—') }},
                                    email: {{ Js::from($clientUser->email ?? '—') }},
                                    clientType: {{ Js::from($a->client_type) }},
                                    service: {{ Js::from(implode(', ', $a->services ?? [])) }},
                                    establishment: {{ Js::from($a->establishment_type) }},
                                    assessor: {{ Js::from($assessorNames) }},
                                    status: {{ Js::from($a->derived_status) }},
                                    statusClass: {{ Js::from($a->derived_status === 'Done Assessment' ? 'success' : 'warning text-dark') }},
                                    notes: {{ Js::from($a->notes ?? '') }},
                                    block: {{ Js::from($client->block ?? '—') }},
                                    lot: {{ Js::from($client->lot ?? '—') }},
                                    brgy: {{ Js::from($client->barangay ?? '—') }},
                                    city: {{ Js::from($client->city ?? '—') }},
                                    province: {{ Js::from($client->province ?? '—') }},
                                    zip: {{ Js::from($client->zip_code ?? '—') }}
                                })">
                                                <span class="material-symbols-outlined icon-action">visibility</span>
                                            </button>
                                            @if ($a->derived_status === 'Done Assessment' || $a->derived_status === 'Submitted Form')
                                                <a href="{{ route('assessments.form.edit', $a) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="{{ $a->assessment_form_completed_at ? 'Open Assessment Form' : 'Create Assessment Form' }}">
                                                <span class="material-symbols-outlined icon-action">
                                                        {{ $a->assessment_form_completed_at ? 'article' : 'description' }}
                                                    </span>
                                                </a>
                                            @endif
                                            @if ($a->assessment_form_completed_at)
                                                <a target="_blank" href="{{ route('assessments.form.print', $a) }}"
                                                    class="btn btn-sm btn-outline-secondary" title="Preview PDF">
                                                    <span class="material-symbols-outlined icon-action">print</span>
                                                </a>
                                            @endif
                                            <button class="btn btn-sm btn-outline-secondary" title="Archive"
                                                onclick="archiveAssessmentConfirm({{ $a->id }}, {{ $a->quotation ? 'true' : 'false' }})">
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

    </div>
</div>


<!-- ── View Assessment Detail Modal ── -->
<div class="modal fade" id="viewAssessmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined" style="font-size:20px;">event_note</span>
                    Assessment Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing:.05em;">
                            Schedule Info</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Date</label>
                        <p class="fw-semibold mb-0" id="vd-date">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Time Slot</label>
                        <p class="fw-semibold mb-0" id="vd-time">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Status</label>
                        <p class="mb-0" id="vd-status">—</p>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing:.05em;">
                            Client Info</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Client Name</label>
                        <p class="fw-semibold mb-0" id="vd-client">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Contact Number</label>
                        <p class="mb-0" id="vd-contact">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Email</label>
                        <p class="mb-0" id="vd-email">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Client Type</label>
                        <p class="mb-0" id="vd-clientType">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Service</label>
                        <p class="mb-0" id="vd-service">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Establishment Type</label>
                        <p class="mb-0" id="vd-establishment">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Assessor(s)</label>
                        <p class="mb-0" id="vd-assessor">—</p>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing:.05em;">
                            Location</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Block</label>
                        <p class="mb-0" id="vd-block">—</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Lot</label>
                        <p class="mb-0" id="vd-lot">—</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Barangay</label>
                        <p class="mb-0" id="vd-brgy">—</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">City / Municipality</label>
                        <p class="mb-0" id="vd-city">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Province</label>
                        <p class="mb-0" id="vd-province">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Zip Code</label>
                        <p class="mb-0" id="vd-zip">—</p>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <div class="col-12">
                        <label class="form-label small text-muted mb-1">Notes</label>
                        <p class="mb-0" id="vd-notes">—</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- ── Day Detail Modal ── -->
<div class="modal fade" id="dayDetailModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined fs-20">calendar_today</span>
                    <span id="dayModalDate">—</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="dayModalBody">
                <!-- filled by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ── Archive Confirm Modal ── -->
<div class="modal fade" id="archiveConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-semibold">Archive this assessment?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="small text-muted mb-0">
                    This assessment will be moved to the archive. You can restore it anytime from
                    <strong>View Archives</strong>.
                </p>
                <p class="small text-warning mb-0 mt-2 d-none" id="archiveQuotationWarning">
                    <span class="material-symbols-outlined fs-15" style="vertical-align:middle;">info</span>
                    This assessment has a related quotation. Archiving the assessment will
                    <strong>not</strong> archive the quotation.
                </p>
            </div>
            <div class="modal-footer border-0 pt-1">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                    id="confirmArchiveBtn" onclick="confirmArchiveAssessment()">
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
    window.assessmentsByDate = @json($byDate);
</script>

<script>
    function csrfHeader() {
        return document.querySelector('meta[name="csrf-token"]').content;
    }

    let currentArchiveAssessmentId = null;

    function archiveAssessmentConfirm(id, hasQuotation) {
        currentArchiveAssessmentId = id;
        document.getElementById('archiveQuotationWarning').classList.toggle('d-none', !hasQuotation);
        new bootstrap.Modal(document.getElementById('archiveConfirmModal')).show();
    }

    function confirmArchiveAssessment() {
        if (!currentArchiveAssessmentId) return;
        fetch(`/assessments/${currentArchiveAssessmentId}/archive`, {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfHeader(),
                },
            })
            .then(res => res.json())
            .then(data => {
                bootstrap.Modal.getInstance(document.getElementById('archiveConfirmModal')).hide();
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 800);
            })
            .catch(() => showToast('Network error. Please try again.', 'danger'));
    }

    function loadAssessmentDetail(d) {
        document.getElementById('vd-date').textContent = d.date || '—';
        document.getElementById('vd-time').textContent = d.time || d.slot || '—';
        document.getElementById('vd-status').innerHTML =
            `<span class="badge rounded-pill bg-${d.statusClass}">${d.status}</span>`;
        document.getElementById('vd-client').textContent = d.client || '—';
        document.getElementById('vd-contact').textContent = d.contact || '—';
        document.getElementById('vd-email').textContent = d.email || '—';
        document.getElementById('vd-clientType').textContent = d.clientType || '—';
        document.getElementById('vd-service').textContent = d.service || '—';
        document.getElementById('vd-establishment').textContent = d.establishment || '—';
        document.getElementById('vd-assessor').textContent = d.assessor || '—';
        document.getElementById('vd-block').textContent = d.block || '—';
        document.getElementById('vd-lot').textContent = d.lot || '—';
        document.getElementById('vd-brgy').textContent = d.brgy || '—';
        document.getElementById('vd-city').textContent = d.city || '—';
        document.getElementById('vd-province').textContent = d.province || '—';
        document.getElementById('vd-zip').textContent = d.zip || '—';
        document.getElementById('vd-notes').textContent = d.notes || '—';
    }

    function openDayModal(date, assessments) {
        document.getElementById('dayModalDate').textContent = date;
        const body = document.getElementById('dayModalBody');

        if (!assessments || assessments.length === 0) {
            body.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <span class="material-symbols-outlined" style="font-size:40px;opacity:.3;">event_available</span>
                    <p class="small mt-2 mb-0">No assessments scheduled for this day.</p>
                </div>`;
        } else {
            body.innerHTML = `
                <p class="section-label mb-3">${assessments.length} Assessment${assessments.length > 1 ? 's' : ''} Scheduled</p>
                <div class="d-flex flex-column gap-3">
                    ${assessments.map((a, i) => {
                        const locationParts = [a.block, a.lot, a.brgy, a.city, a.province, a.zip]
                            .filter(part => part && part !== '—')
                            .join(', ');

                        return `
                            <div class="day-assessment-card">
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="material-symbols-outlined green-text fs-18">schedule</span>
                                        <span class="fw-semibold small">${a.time}</span>
                                        <span class="badge rounded-pill bg-${a.statusClass} ms-1">${a.status}</span>
                                    </div>
                                    <span class="day-slot-badge">${a.slot}</span>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <p class="detail-label small mb-0">Client</p>
                                        <p class="detail-value small fw-semibold mb-0">${a.client}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="detail-label small mb-0">Service</p>
                                        <p class="detail-value small mb-0">${a.service}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="detail-label small mb-0">Contact</p>
                                        <p class="detail-value small mb-0">${a.contact || '—'}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="detail-label small mb-0">Client Type</p>
                                        <p class="detail-value small mb-0">${a.clientType || '—'}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="detail-label small mb-0">Establishment</p>
                                        <p class="detail-value small mb-0">${a.establishment || '—'}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="detail-label small mb-0">Assessor(s)</p>
                                        <p class="detail-value small mb-0">${a.assessor || '—'}</p>
                                    </div>
                                </div>
                                <div class="day-location-row mb-2">
                                    <span class="material-symbols-outlined fs-15 muted-text">location_on</span>
                                    <p class="small mb-0">${locationParts || 'No location details provided.'}</p>
                                </div>
                                ${a.notes ? `
                                    <div class="day-notes-row">
                                        <span class="material-symbols-outlined fs-15 muted-text">sticky_note_2</span>
                                        <p class="small mb-0">${a.notes}</p>
                                    </div>
                                ` : ''}
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-success py-1 px-2"
                                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                        onclick='loadAssessmentDetail(${JSON.stringify(a)})'>
                                        <span class="material-symbols-outlined fs-14" style="vertical-align:middle;">open_in_full</span>
                                        View Full Details
                                    </button>
                                </div>
                            </div>
                            ${i < assessments.length - 1 ? '<hr class="my-1">' : ''}
                        `;
                    }).join('')}
                </div>`;
        }

        new bootstrap.Modal(document.getElementById('dayDetailModal')).show();
    }

    /* ─── Dynamic, month-navigable calendar (mirrors the client-side one) ─── */
    const MONTH_NAMES = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    let calendarYear, calendarMonth;

    function initCalendar() {
        const today = new Date();
        calendarYear = today.getFullYear();
        calendarMonth = today.getMonth();
        renderCalendar();
    }

    function changeMonth(delta) {
        calendarMonth += delta;
        if (calendarMonth < 0) {
            calendarMonth = 11;
            calendarYear -= 1;
        } else if (calendarMonth > 11) {
            calendarMonth = 0;
            calendarYear += 1;
        }
        renderCalendar();
    }

    function toISODate(d) {
        return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
    }

    function renderCalendar() {
        document.getElementById('calendar-month-label').textContent = `${MONTH_NAMES[calendarMonth]} ${calendarYear}`;

        const grid = document.getElementById('full-calendar-grid');
        const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        let html = dayHeaders.map(d => `<div class="calendar-header-cell">${d}</div>`).join('');

        const firstOfMonth = new Date(calendarYear, calendarMonth, 1);
        const startWeekday = firstOfMonth.getDay();
        const daysInMonth = new Date(calendarYear, calendarMonth + 1, 0).getDate();
        const todayISO = toISODate(new Date());

        for (let i = 0; i < startWeekday; i++) {
            html += `<div class="calendar-cell no-work"></div>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dateObj = new Date(calendarYear, calendarMonth, day);
            const iso = toISODate(dateObj);
            const isSunday = dateObj.getDay() === 0;
            const isToday = iso === todayISO;
            const dayAssessments = window.assessmentsByDate[iso] || [];

            let classes = 'calendar-cell';
            let booking = '';

            if (isSunday) {
                classes += ' no-work';
            } else if (dayAssessments.length > 0) {
                classes += ' calendar-clickable half-booked';
                booking = dayAssessments.slice(0, 2).map(a =>
                    `<div class="calendar-booking"><small class="d-block text-truncate">${a.time} — ${a.client}</small></div>`
                ).join('');
            } else {
                classes += ' calendar-clickable';
            }

            if (isToday) classes += ' today';

            const dateStyle = isToday ? ' style="color:#fff;"' : '';
            const dateLabel = `<div class="calendar-date"${dateStyle}>${day}</div>`;
            const dateDisplay = `${MONTH_NAMES[calendarMonth].slice(0, 3)} ${day}, ${calendarYear}`;
            const onclickAttr = isSunday ? '' :
                `onclick='openDayModal(${JSON.stringify(dateDisplay)}, ${JSON.stringify(dayAssessments)})'`;

            html += `<div class="${classes}" ${onclickAttr}>${dateLabel}${booking}</div>`;
        }

        const totalCells = startWeekday + daysInMonth;
        const remainder = totalCells % 7;
        if (remainder !== 0) {
            for (let i = 0; i < 7 - remainder; i++) {
                html += `<div class="calendar-cell no-work"></div>`;
            }
        }

        grid.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', initCalendar);

    $(document).ready(function() {
        const table = $('#assessmentTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            info: true,
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: 6
            }],
            language: {
                emptyTable: 'No confirmed assessments yet.'
            },
        });

        $('#statusFilterGroup button').on('click', function() {
            $('#statusFilterGroup button').removeClass('active');
            $(this).addClass('active');
            const filter = $(this).data('filter');
            table.column(5).search(filter === 'all' ? '' : filter).draw();
        });
    });
</script>
@endsection
