@extends('layouts.admin')

@section('title', 'Archived Client Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/client-requests.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Archived Client Requests')

@section('topbar-actions')
    <a href="{{ route('requests') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Client Requests
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
                        <p class="summary-label">Confirmed</p>
                        <p class="summary-value">{{ $confirmed }}</p>
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
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                    <div>
                        <p class="summary-label">Pending</p>
                        <p class="summary-value">{{ $pending }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Requests Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Confirmed">Confirmed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Declined">Declined</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Pending">Pending</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveRequestsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Pref. Date</th>
                                <th class="border-0 small green-text">Slot</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessments as $assessment)
                                @php
                                    $refNo =
                                        'AWG-' .
                                        $assessment->created_at->format('Y') .
                                        '-' .
                                        str_pad($assessment->id, 4, '0', STR_PAD_LEFT);
                                    $badgeClass = $statusBadgeClass[$assessment->status] ?? 'secondary';
                                    $client = $assessment->client;
                                    $clientUser = $client->user;
                                @endphp
                                <tr data-status="{{ $assessment->status }}">
                                    <td class="fw-semibold">{{ $refNo }}</td>
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
                                    <td class="text-muted small"
                                        data-order="{{ optional($assessment->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $assessment->archived_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
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
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm(this, {{ $assessment->id }}, {{ Js::from($refNo) }})">
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


    <!-- ── View Request Detail Modal ── -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">person_search</span>
                        Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12"><p class="section-label">Request Info</p></div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Reference No.</p>
                            <p class="detail-value small fw-semibold" id="vr-refNo">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Preferred Date</p>
                            <p class="detail-value small" id="vr-date">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Time Slot</p>
                            <p class="detail-value small" id="vr-slot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Status</p>
                            <p class="detail-value small" id="vr-status">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Client Info</p></div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Name</p>
                            <p class="detail-value small fw-semibold" id="vr-client">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Contact Number</p>
                            <p class="detail-value small" id="vr-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Email</p>
                            <p class="detail-value small" id="vr-email">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Type</p>
                            <p class="detail-value small" id="vr-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Service</p>
                            <p class="detail-value small" id="vr-service">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Establishment Type</p>
                            <p class="detail-value small" id="vr-establishment">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Location</p></div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Block</p>
                            <p class="detail-value small" id="vr-block">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Lot</p>
                            <p class="detail-value small" id="vr-lot">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Barangay</p>
                            <p class="detail-value small" id="vr-brgy">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">City / Municipality</p>
                            <p class="detail-value small" id="vr-city">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Province</p>
                            <p class="detail-value small" id="vr-province">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Zip Code</p>
                            <p class="detail-value small" id="vr-zip">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Notes</p></div>
                        <div class="col-12">
                            <p class="detail-value small" id="vr-notes">—</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1"
                        id="modal-restore-btn">
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
                    <h6 class="modal-title fw-semibold">Restore this request?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        Request <strong id="rc-refNo">—</strong> will be moved back to
                        <strong>Client Requests</strong>.
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
            unarchive: {{ Js::from(route('requests.unarchive', ['assessment' => '__ID__'])) }},
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

            document.getElementById('modal-restore-btn').onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewRequestModal')).hide();
                openRestoreConfirm(null, d.id, d.refNo);
            };
        }

        /* ─────────────────────────────────────────
           RESTORE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingRestoreId = null;

        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(btn, id, refNo) {
            pendingRestoreId = id;
            document.getElementById('rc-refNo').textContent = refNo;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
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
                        showToast(data.message || 'Unable to restore this request.', 'danger');
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
            const table = $('#archiveRequestsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [7, 'desc']
                ],
                columnDefs: [{
                    targets: 8,
                    orderable: false
                }],
                language: {
                    emptyTable: 'No archived requests yet.',
                    zeroRecords: 'No matching archived requests found.'
                }
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
