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

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">home</span>
                    <div>
                        <p class="summary-label">Residential</p>
                        <p class="summary-value">1</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">store</span>
                    <div>
                        <p class="summary-label">Commercial</p>
                        <p class="summary-value">1</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">account_balance</span>
                    <div>
                        <p class="summary-label">Government / LGU</p>
                        <p class="summary-value">0</p>
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
                            <tr>
                                <td class="fw-semibold small">CLT-2025-018</td>
                                <td class="fw-semibold">Elena Cruz</td>
                                <td>0922-111-2222</td>
                                <td>elena.cruz@email.com</td>
                                <td><span class="type-pill type-residential">Residential</span></td>
                                <td>CCTV Setup</td>
                                <td class="text-muted small">Dec 20, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2025-018',name:'Elena Cruz',contact:'0922-111-2222',email:'elena.cruz@email.com',type:'Residential',service:'CCTV Setup',status:'Archived',address:'Brgy. Zapote III, Bacoor, Cavite',joined:'Aug 05, 2025',projects:'1',quotations:'1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">CLT-2025-022</td>
                                <td class="fw-semibold">Ramon dela Cruz</td>
                                <td>0933-222-3333</td>
                                <td>ramon.delacruz@email.com</td>
                                <td><span class="type-pill type-commercial">Commercial</span></td>
                                <td>Solar Setup</td>
                                <td class="text-muted small">Nov 08, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2025-022',name:'Ramon dela Cruz',contact:'0933-222-3333',email:'ramon.delacruz@email.com',type:'Commercial',service:'Solar Setup',status:'Archived',address:'Brgy. Poblacion, Silang, Cavite',joined:'Jun 14, 2025',projects:'2',quotations:'2'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
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
                            <span class="badge rounded-pill bg-secondary" id="vc-status-badge">—</span>
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
                            <p class="detail-label small mb-0">Projects</p>
                            <p class="detail-value small" id="vc-projects">—</p>
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
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">unarchive</span>Restore Client
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function loadClientDetail(d) {
            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ?
                parts[0][0] + parts[parts.length - 1][0] :
                (parts[0] ? parts[0][0] : '?');

            document.getElementById('vc-avatar').textContent = initials.toUpperCase();
            document.getElementById('vc-name').textContent = d.name || '—';
            document.getElementById('vc-id').textContent = d.id || '—';
            document.getElementById('vc-type').textContent = d.type || '—';
            document.getElementById('vc-service').textContent = d.service || '—';
            document.getElementById('vc-joined').textContent = d.joined || '—';
            document.getElementById('vc-projects').textContent = d.projects ? `${d.projects} project(s)` : '—';
            document.getElementById('vc-contact').textContent = d.contact || '—';
            document.getElementById('vc-email').textContent = d.email || '—';
            document.getElementById('vc-address').textContent = d.address || '—';

            const badge = document.getElementById('vc-status-badge');
            badge.textContent = d.status || '—';
            badge.className = 'badge rounded-pill bg-secondary';
        }

        $('#archiveClientsTable').DataTable({
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
            }]
        });
    </script>
@endsection