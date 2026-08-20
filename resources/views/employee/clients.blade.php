@extends('layouts.admin')

@section('title', 'Clients')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/clients/clients.css') }}">
@endsection

@section('page-title', 'Clients')

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">groups</span>
                    <div>
                        <p class="summary-label">Total Clients</p>
                        <p class="summary-value">{{ $total ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">home</span>
                    <div>
                        <p class="summary-label">Residential</p>
                        <p class="summary-value">{{ $residential ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">store</span>
                    <div>
                        <p class="summary-label">Commercial</p>
                        <p class="summary-value">{{ $commercial ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">account_balance</span>
                    <div>
                        <p class="summary-label">Government / LGU</p>
                        <p class="summary-value">{{ $government ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
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
                    <table id="clientsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Client ID</th>
                                <th class="border-0 small green-text">Client Name</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Email</th>
                                <th class="border-0 small green-text">City/Municipality</th>
                                <th class="border-0 small green-text">Province</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                                <th class="d-none">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients ?? [] as $client)
                                <tr data-type="{{ $client->derived_type ?? '' }}">
                                    <td class="fw-semibold small">{{ $client->client_id }}</td>
                                    <td class="fw-semibold">{{ $client->user->full_name ?? 'N/A' }}</td>
                                    <td>{{ $client->user->contact_number ?? '—' }}</td>
                                    <td>{{ $client->user->email ?? '—' }}</td>
                                    <td>{{ $client->city ?: '—' }}</td>
                                    <td>{{ $client->province ?: '—' }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill bg-{{ ($client->user->status ?? '') === 'active' ? 'success' : 'warning text-dark' }}">
                                            {{ ucfirst($client->user->status ?? 'unknown') }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            onclick="openViewClient({{ $client->id }})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                    <td class="d-none">{{ $client->derived_type ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No clients found.</td>
                                </tr>
                            @endforelse
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
                            <span class="badge rounded-pill bg-success" id="vc-status-badge">—</span>
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
                            <p class="detail-label small mb-0">Assessments</p>
                            <p class="detail-value small" id="vc-assessments">—</p>
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
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let dtTable = null;

        function openViewClient(clientId) {
            fetch(`{{ url('/employee/clients') }}/${clientId}/details`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) throw new Error('Invalid response');
                    const c = data.client;
                    const initials = ((c.firstName?.[0] || '') + (c.lastName?.[0] || '')).toUpperCase() || '?';

                    document.getElementById('vc-avatar').textContent = initials;
                    document.getElementById('vc-name').textContent = c.name || '—';
                    document.getElementById('vc-id').textContent = c.client_id || '—';
                    document.getElementById('vc-type').textContent = c.type || '—';
                    document.getElementById('vc-service').textContent = c.service || '—';
                    document.getElementById('vc-joined').textContent = c.joined || '—';
                    document.getElementById('vc-assessments').textContent = c.assessments_count ?? '0';
                    document.getElementById('vc-contact').textContent = c.contact || '—';
                    document.getElementById('vc-email').textContent = c.email || '—';
                    document.getElementById('vc-address').textContent = c.address || '—';

                    const badge = document.getElementById('vc-status-badge');
                    badge.textContent = c.status ? c.status.charAt(0).toUpperCase() + c.status.slice(1) : '—';
                    badge.className =
                        `badge rounded-pill ${c.status === 'active' ? 'bg-success' : 'bg-warning text-dark'}`;

                    new bootstrap.Modal(document.getElementById('viewClientModal')).show();
                })
                .catch(() => showToast('Failed to load client details.', 'danger'));
        }

        $(document).ready(function() {
            dtTable = $('#clientsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                lengthChange: true,
                info: true,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    },
                    {
                        visible: false,
                        targets: 8
                    }
                ],
                language: {
                    emptyTable: 'No clients found.',
                    zeroRecords: 'No matching clients found.'
                }
            });

            $('#typeFilterGroup button').on('click', function() {
                $('#typeFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                dtTable.column(8).search(filter === 'all' ? '' : filter, false, false).draw();
            });
        });
    </script>
@endsection
