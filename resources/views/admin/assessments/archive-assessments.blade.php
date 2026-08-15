@extends('layouts.admin')

@section('title', 'Archived Assessments')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/assessments.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Archived Assessments')

@section('topbar-actions')
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Assessments
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
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

        <!-- Archived Assessments Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Done Assessment">Done Assessment</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Submitted Form">Submitted Form</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Pending">Pending</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Time</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessments as $a)
                                @php
                                    $client = $a->client;
                                    $clientUser = $client->user;
                                    $assessorNames = $a->assessors->pluck('full_name')->implode(', ') ?: '—';
                                    $statusClass = $a->derived_status === 'Done Assessment'
                                        ? 'success'
                                        : ($a->derived_status === 'Submitted Form' ? 'primary text-white' : 'warning text-dark');
                                @endphp
                                <tr data-status="{{ $a->derived_status }}">
                                    <td data-order="{{ $a->preferred_date->format('Y-m-d') }}">
                                        {{ $a->preferred_date->format('M j, Y') }}
                                    </td>
                                    <td>{{ $a->time_slot }}</td>
                                    <td>{{ $clientUser->full_name }}</td>
                                    <td>{{ implode(', ', $a->services ?? []) }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill bg-{{ $statusClass }}">{{ $a->derived_status }}</span>
                                    </td>
                                    <td class="text-muted small"
                                        data-order="{{ optional($a->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $a->archived_at?->format('M j, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                            onclick="loadAssessmentDetail({
                                id: {{ $a->id }},
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
                                statusClass: {{ Js::from($statusClass) }},
                                notes: {{ Js::from($a->notes ?? '') }},
                                block: {{ Js::from($client->block ?? '—') }},
                                lot: {{ Js::from($client->lot ?? '—') }},
                                brgy: {{ Js::from($client->barangay ?? '—') }},
                                city: {{ Js::from($client->city ?? '—') }},
                                province: {{ Js::from($client->province ?? '—') }},
                                zip: {{ Js::from($client->zip_code ?? '—') }},
                                archivedOn: {{ Js::from($a->archived_at?->format('M j, Y')) }}
                            })">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm({{ $a->id }})">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
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


    <!-- ── View Assessment Detail Modal ── -->
    <div class="modal fade" id="viewAssessmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">event_note</span>
                        Assessment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12">
                            <p class="section-label">Schedule Info</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Date</p>
                            <p class="detail-value small fw-semibold" id="vd-date">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Time</p>
                            <p class="detail-value small fw-semibold" id="vd-time">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Status</p>
                            <p class="detail-value small" id="vd-status">—</p>
                        </div>

                        <div class="col-12">
                            <p class="section-label">Client Info</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Name</p>
                            <p class="detail-value small fw-semibold" id="vd-client">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Contact Number</p>
                            <p class="detail-value small" id="vd-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Email</p>
                            <p class="detail-value small" id="vd-email">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Type</p>
                            <p class="detail-value small" id="vd-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Service</p>
                            <p class="detail-value small" id="vd-service">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Establishment Type</p>
                            <p class="detail-value small" id="vd-establishment">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Assessor(s)</p>
                            <p class="detail-value small" id="vd-assessor">—</p>
                        </div>

                        <div class="col-12">
                            <p class="section-label">Location</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Block</p>
                            <p class="detail-value small" id="vd-block">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Lot</p>
                            <p class="detail-value small" id="vd-lot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Barangay</p>
                            <p class="detail-value small" id="vd-brgy">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">City / Municipality</p>
                            <p class="detail-value small" id="vd-city">—</p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label small mb-0">Province</p>
                            <p class="detail-value small" id="vd-province">—</p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label small mb-0">Zip Code</p>
                            <p class="detail-value small" id="vd-zip">—</p>
                        </div>

                        <div class="col-12">
                            <p class="section-label">Archive Info</p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label small mb-0">Archived On</p>
                            <p class="detail-value small" id="vd-archivedOn">—</p>
                        </div>

                        <div class="col-12">
                            <p class="section-label">Notes</p>
                        </div>
                        <div class="col-12">
                            <p class="detail-value small" id="vd-notes">—</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1"
                        id="vd-restore-btn">
                        <span class="material-symbols-outlined fs-17">unarchive</span>Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this assessment?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        This assessment will be moved back to the schedule. If it has a linked quotation that was
                        auto-archived with it, that quotation will be restored too.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        id="rc-confirm-btn">
                        <span class="material-symbols-outlined fs-15">unarchive</span>
                        Restore
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
        const ROUTES = {
            unarchive: {{ Js::from(route('assessments.unarchive', ['assessment' => '__ID__'])) }},
        };

        function csrfHeader() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

        function loadAssessmentDetail(d) {
            document.getElementById('vd-date').textContent = d.date || '—';
            document.getElementById('vd-time').textContent = d.time || '—';
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
            document.getElementById('vd-archivedOn').textContent = d.archivedOn || '—';

            document.getElementById('vd-restore-btn').onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewAssessmentModal'))?.hide();
                openRestoreConfirm(d.id);
            };
        }

        /* ─────────────────────────────────────────
           RESTORE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingRestoreId = null;

        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(id) {
            pendingRestoreId = id;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfHeader(),
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
                        showToast(data.message || 'Unable to restore this assessment.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    restoreConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        /* ─── DataTable + status filter buttons ─── */
        $(document).ready(function() {
            const table = $('#archiveTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [5, 'desc']
                ],
                columnDefs: [{
                    targets: 6,
                    orderable: false
                }],
                language: {
                    emptyTable: 'No archived assessments yet.',
                    zeroRecords: 'No matching archived assessments found.'
                }
            });

            $('#statusFilterGroup button').on('click', function() {
                $('#statusFilterGroup button').removeClass('active');
                $(this).addClass('active');

                const filter = $(this).data('filter');
                table.column(4).search(filter === 'all' ? '' : filter, true, false).draw();
            });
        });
    </script>
@endsection
