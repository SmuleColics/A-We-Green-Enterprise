@extends('layouts.admin')

@section('title', 'Archived Employees')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/employees/employees.css') }}">
@endsection

@section('page-title', 'Archived Employees')

@section('topbar-actions')
    <a href="{{ route('employees') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Employees
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
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:var(--awg-primary);">engineering</span>
                    <div>
                        <p class="summary-label">Field Employees</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#3b82f6;">assignment_ind</span>
                    <div>
                        <p class="summary-label">Secretaries</p>
                        <p class="summary-value">1</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#8b5cf6;">admin_panel_settings</span>
                    <div>
                        <p class="summary-label">Admins</p>
                        <p class="summary-value">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Staff Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Admin">Admin</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Secretary">Secretary</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Employee">Field
                        Employee</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveStaffTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Staff ID</th>
                                <th class="border-0 small green-text">Name</th>
                                <th class="border-0 small green-text">Type</th>
                                <th class="border-0 small green-text">Role</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Email</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold small">EMP-2025-011</td>
                                <td class="fw-semibold">Felix Navarro</td>
                                <td><span class="type-pill type-employee">Employee</span></td>
                                <td>Technician</td>
                                <td>0930-111-2222</td>
                                <td>felix.navarro@email.com</td>
                                <td class="text-muted small">Dec 15, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'EMP-2025-011',name:'Felix Navarro',type:'Employee',role:'Technician',contact:'0930-111-2222',email:'felix.navarro@email.com',address:'Block 5, Lot 7, Brgy. Bucandala I, Imus, Cavite',joined:'Mar 12, 2025'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">EMP-2025-009</td>
                                <td class="fw-semibold">Renato Aguilar</td>
                                <td><span class="type-pill type-employee">Employee</span></td>
                                <td>Driver</td>
                                <td>0931-222-3333</td>
                                <td>renato.aguilar@email.com</td>
                                <td class="text-muted small">Nov 28, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'EMP-2025-009',name:'Renato Aguilar',type:'Employee',role:'Driver',contact:'0931-222-3333',email:'renato.aguilar@email.com',address:'Block 2, Lot 9, Brgy. Medicion I, Imus, Cavite',joined:'Feb 20, 2025'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">SEC-2025-001</td>
                                <td class="fw-semibold">Lorna Castillo</td>
                                <td><span class="type-pill type-secretary">Secretary</span></td>
                                <td>Secretary</td>
                                <td>0932-333-4444</td>
                                <td>lorna.castillo@schedquote.com</td>
                                <td class="text-muted small">Oct 03, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'SEC-2025-001',name:'Lorna Castillo',type:'Secretary',role:'Secretary',contact:'0932-333-4444',email:'lorna.castillo@schedquote.com',address:'Block 6, Lot 2, Brgy. Malagasang II-G, Imus, Cavite',joined:'Jan 08, 2025'})">
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

    <!-- ── View Staff Modal ── -->
    <div class="modal fade" id="viewStaffModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">badge</span>
                        Staff Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div id="vs-avatar" class="staff-avatar">?</div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vs-name">—</p>
                            <p class="text-muted mb-0 fs-12" id="vs-id">—</p>
                            <span class="badge rounded-pill mt-1" id="vs-type-badge">—</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <p class="section-label fs-11">Staff Information</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label fs-12">Staff Type</p>
                            <p class="detail-value fs-14" id="vs-type">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label fs-12">Role</p>
                            <p class="detail-value fs-14" id="vs-role">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label fs-12">Date Joined</p>
                            <p class="detail-value fs-14" id="vs-joined">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label fs-12">Status</p>
                            <p class="detail-value"><span class="badge bg-secondary rounded-pill">Archived</span></p>
                        </div>

                        <div class="col-12">
                            <p class="section-label fs-11">Contact Information</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label fs-12">Contact Number</p>
                            <p class="detail-value fs-14" id="vs-contact">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label fs-12">Email Address</p>
                            <p class="detail-value fs-14" id="vs-email">—</p>
                        </div>

                        <div class="col-12">
                            <p class="section-label fs-11">Address</p>
                        </div>
                        <div class="col-12">
                            <p class="detail-value fs-14 mb-0" id="vs-address">—</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-16">close</span>Close
                    </button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">unarchive</span>Restore Staff
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const typeColors = {
            'Employee': {
                bg: '#16A249',
                avatar: 'rgba(22,162,73,.12)',
                border: '#16A249',
                text: '#16A249'
            },
            'Secretary': {
                bg: '#3b82f6',
                avatar: 'rgba(59,130,246,.12)',
                border: '#3b82f6',
                text: '#3b82f6'
            },
            'Admin': {
                bg: '#8b5cf6',
                avatar: 'rgba(139,92,246,.12)',
                border: '#8b5cf6',
                text: '#8b5cf6'
            },
        };

        function loadStaffDetail(d) {
            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ? parts[0][0] + parts[parts.length - 1][0] : (parts[0] ? parts[0][0] : '?');
            const c = typeColors[d.type] || typeColors['Employee'];

            const avatar = document.getElementById('vs-avatar');
            avatar.textContent = initials.toUpperCase();
            avatar.style.backgroundColor = c.avatar;
            avatar.style.border = `2px solid ${c.border}`;
            avatar.style.color = c.text;

            const badge = document.getElementById('vs-type-badge');
            badge.textContent = d.type;
            badge.style.backgroundColor = c.bg;
            badge.style.color = '#fff';

            document.getElementById('vs-name').textContent = d.name || '—';
            document.getElementById('vs-id').textContent = d.id || '—';
            document.getElementById('vs-type').textContent = d.type || '—';
            document.getElementById('vs-role').textContent = d.role || '—';
            document.getElementById('vs-joined').textContent = d.joined || '—';
            document.getElementById('vs-contact').textContent = d.contact || '—';
            document.getElementById('vs-email').textContent = d.email || '—';
            document.getElementById('vs-address').textContent = d.address || '—';
        }

        $('#archiveStaffTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            lengthChange: true,
            dom: "<'row align-items-center mb-2'<'col-auto'l><'col'f>>rt<'row align-items-center mt-2'<'col'i><'col-auto'p>>",
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