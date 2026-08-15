@extends('layouts.admin')

@section('title', 'Archived Clients')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/clients/clients.css') }}">
@endsection

@section('page-title', 'Archived Clients')

@section('topbar-actions')
    <a href="{{ route('clients') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Clients
    </a>
@endsection

@section('content')

    @php
        $typeClass = [
            'Residential' => 'type-residential',
            'Commercial' => 'type-commercial',
            'Government/LGU' => 'type-government',
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
                    <span class="material-symbols-outlined summary-icon text-primary">home</span>
                    <div>
                        <p class="summary-label">Residential</p>
                        <p class="summary-value">{{ $residential }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">store</span>
                    <div>
                        <p class="summary-label">Commercial</p>
                        <p class="summary-value">{{ $commercial }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">account_balance</span>
                    <div>
                        <p class="summary-label">Government / LGU</p>
                        <p class="summary-value">{{ $government }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Clients Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="typeFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Residential">Residential</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Commercial">Commercial</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Government/LGU">Government
                        / LGU</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveClientsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Client ID</th>
                                <th class="border-0 small green-text">Client Name</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Email</th>
                                <th class="border-0 small green-text">Type</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                @php
                                    $payload = [
                                        'id' => $client->id,
                                        'clientId' => $client->client_id,
                                        'name' => $client->user->full_name ?? 'N/A',
                                        'contact' => $client->user->contact_number ?? '—',
                                        'email' => $client->user->email ?? '—',
                                        'type' => $client->derived_type,
                                        'service' => $client->derived_service,
                                        'address' => collect([
                                            $client->block ? "Blk {$client->block}" : null,
                                            $client->lot ? "Lot {$client->lot}" : null,
                                            $client->street ? "{$client->street} St." : null,
                                            $client->barangay,
                                            $client->city,
                                            $client->province,
                                            $client->zip_code,
                                        ])->filter()->implode(', '),
                                        'joined' => $client->created_at->format('M j, Y'),
                                        'archivedOn' => $client->archived_at?->format('M j, Y'),
                                    ];
                                @endphp
                                <tr data-type="{{ $client->derived_type ?? '' }}">
                                    <td class="fw-semibold small">{{ $client->client_id }}</td>
                                    <td class="fw-semibold">{{ $client->user->full_name ?? 'N/A' }}</td>
                                    <td>{{ $client->user->contact_number ?? '—' }}</td>
                                    <td>{{ $client->user->email ?? '—' }}</td>
                                    <td>
                                        @if ($client->derived_type)
                                            <span
                                                class="type-pill {{ $typeClass[$client->derived_type] ?? '' }}">{{ $client->derived_type }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $client->derived_service ?: '—' }}</td>
                                    <td class="text-muted small"
                                        data-order="{{ optional($client->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $client->archived_at?->format('M j, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                            data-client='@json($payload)'
                                            onclick="loadClientDetail(JSON.parse(this.dataset.client))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm({{ $client->id }}, {{ Js::from($client->user->full_name ?? 'N/A') }})">
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

    <!-- ── View Client Modal ── -->
    <div class="modal fade" id="viewClientModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">person</span>
                        Client Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="client-avatar" id="vc-avatar">?</div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vc-name">—</p>
                            <p class="text-muted mb-1 small" id="vc-id">—</p>
                            <span class="badge rounded-pill bg-secondary">Archived</span>
                        </div>
                    </div>

                    <p class="section-label">Client Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Client Type</p>
                            <p class="detail-value small fw-semibold" id="vc-type">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Service</p>
                            <p class="detail-value small fw-semibold" id="vc-service">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Date Registered</p>
                            <p class="detail-value small" id="vc-joined">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Archived On</p>
                            <p class="detail-value small" id="vc-archivedOn">—</p>
                        </div>
                    </div>

                    <p class="section-label">Contact Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Contact Number</p>
                            <p class="detail-value small" id="vc-contact">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Email Address</p>
                            <p class="detail-value small" id="vc-email">—</p>
                        </div>
                    </div>

                    <p class="section-label">Address</p>
                    <p class="detail-value small" id="vc-address">—</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-16">close</span>Close
                    </button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1"
                        id="vc-restore-btn">
                        <span class="material-symbols-outlined fs-16">unarchive</span>Restore Client
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
                    <h6 class="modal-title fw-semibold">Restore this client?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        <strong id="rc-client-name">—</strong> will be moved back to <strong>Clients</strong>.
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
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        const ROUTES = {
            unarchive: {{ Js::from(route('clients.unarchive', ['client' => '__ID__'])) }},
        };

        let pendingRestoreId = null;

        function loadClientDetail(d) {
            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ?
                parts[0][0] + parts[parts.length - 1][0] :
                (parts[0] ? parts[0][0] : '?');

            document.getElementById('vc-avatar').textContent = initials.toUpperCase();
            document.getElementById('vc-name').textContent = d.name || '—';
            document.getElementById('vc-id').textContent = d.clientId || '—';
            document.getElementById('vc-type').textContent = d.type || '—';
            document.getElementById('vc-service').textContent = d.service || '—';
            document.getElementById('vc-joined').textContent = d.joined || '—';
            document.getElementById('vc-archivedOn').textContent = d.archivedOn || '—';
            document.getElementById('vc-contact').textContent = d.contact || '—';
            document.getElementById('vc-email').textContent = d.email || '—';
            document.getElementById('vc-address').textContent = d.address || '—';

            document.getElementById('vc-restore-btn').onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewClientModal'))?.hide();
                openRestoreConfirm(d.id, d.name);
            };
        }

        /* ─────────────────────────────────────────
           RESTORE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(id, name) {
            pendingRestoreId = id;
            document.getElementById('rc-client-name').textContent = name;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        showToast(data.message || 'Unable to restore this client.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    restoreConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        $(document).ready(function() {
            const table = $('#archiveClientsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                lengthChange: true,
                info: true,
                order: [
                    [6, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }],
                language: {
                    emptyTable: 'No archived clients yet.',
                    zeroRecords: 'No matching archived clients found.'
                }
            });

            $('#typeFilterGroup button').on('click', function() {
                $('#typeFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                table.column(4).search(filter === 'all' ? '' : filter, true, false).draw();
            });
        });
    </script>
@endsection
