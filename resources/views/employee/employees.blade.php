@extends('layouts.admin')

@section('title', 'Employees')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/employees/employees.css') }}">
@endsection

@section('page-title', 'Employees')

@section('content')

    @php
        $positionLabels = [
            \App\Models\Employee::POSITION_DRIVER => 'Driver',
            \App\Models\Employee::POSITION_TECHNICIAN => 'Technician',
            \App\Models\Employee::POSITION_DRIVER_TECHNICIAN => 'Driver / Technician',
        ];
        $typeLabels = [
            \App\Models\User::ROLE_EMPLOYEE => 'Employee',
            \App\Models\User::ROLE_ADMIN => 'Admin',
        ];
    @endphp

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">badge</span>
                    <div>
                        <p class="summary-label">Total Staff</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">admin_panel_settings</span>
                    <div>
                        <p class="summary-label">Admins</p>
                        <p class="summary-value">{{ $admins }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">build</span>
                    <div>
                        <p class="summary-label">Technicians</p>
                        <p class="summary-value">{{ $technicians }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">local_shipping</span>
                    <div>
                        <p class="summary-label">Drivers</p>
                        <p class="summary-value">{{ $drivers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Admin">Admin</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Employee">Field
                        Employee</button>
                </div>

                <div class="table-responsive">
                    <table id="staffTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Staff ID</th>
                                <th class="border-0 small green-text">Name</th>
                                <th class="border-0 small green-text">Type</th>
                                <th class="border-0 small green-text">Role</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($staffMembers as $staff)
                                @php
                                    $role = $staff->user->role;
                                    $typeLabel = $typeLabels[$role] ?? ucfirst($role);
                                    $roleDisplay =
                                        $role === \App\Models\User::ROLE_EMPLOYEE
                                            ? $positionLabels[$staff->employee?->position] ?? '—'
                                            : $typeLabel;

                                    $staffPayload = [
                                        'id' => $staff->staff_id,
                                        'name' => $staff->user->full_name,
                                        'type' => $typeLabel,
                                        'role' => $roleDisplay,
                                        'contact' => $staff->user->contact_number,
                                        'email' => $staff->user->email,
                                        'block' => $staff->block,
                                        'lot' => $staff->lot,
                                        'street' => $staff->street,
                                        'barangay' => $staff->barangay,
                                        'province' => $staff->province,
                                        'city' => $staff->city,
                                        'zip_code' => $staff->zip_code,
                                        'status' => $staff->user->status,
                                        'joined' => optional($staff->date_joined)->format('M d, Y'),
                                    ];
                                @endphp
                                <tr>
                                    <td class="fw-semibold small">{{ $staff->staff_id }}</td>
                                    <td class="fw-semibold">{{ $staff->user->full_name }}</td>
                                    <td><span class="type-pill type-{{ strtolower($typeLabel) }}">{{ $typeLabel }}</span>
                                    </td>
                                    <td>{{ $roleDisplay }}</td>
                                    <td>{{ $staff->user->contact_number ?? '—' }}</td>
                                    <td class="actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                            data-staff='@json($staffPayload)'
                                            onclick="loadStaffDetail(JSON.parse(this.dataset.staff))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No staff members found.</td>
                                </tr>
                            @endforelse
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
                            <p class="detail-value"><span class="badge rounded-pill" id="vs-status-badge">—</span></p>
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
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const statusColors = {
            active: 'bg-success',
            inactive: 'bg-secondary',
            pending: 'bg-warning text-dark'
        };

        function buildAddress(d) {
            const line1 = [
                d.block ? `Blk ${d.block}` : null,
                d.lot ? `Lot ${d.lot}` : null,
                d.street,
            ].filter(Boolean).join(', ');

            return [line1, d.barangay, d.city, d.province, d.zip_code]
                .filter(Boolean)
                .join(', ');
        }

        function loadStaffDetail(d) {
            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ? parts[0][0] + parts[parts.length - 1][0] : (parts[0] ? parts[0][0] : '?');
            const typeClass = 'type-' + (d.type || 'employee').toLowerCase();

            const avatar = document.getElementById('vs-avatar');
            avatar.textContent = initials.toUpperCase();
            avatar.className = 'staff-avatar ' + typeClass;

            const badge = document.getElementById('vs-type-badge');
            badge.textContent = d.type;
            badge.className = 'type-pill ' + typeClass;

            const statusBadge = document.getElementById('vs-status-badge');
            statusBadge.textContent = d.status ? d.status.charAt(0).toUpperCase() + d.status.slice(1) : '—';
            statusBadge.className = 'badge rounded-pill ' + (statusColors[d.status] || 'bg-secondary');

            document.getElementById('vs-name').textContent = d.name || '—';
            document.getElementById('vs-id').textContent = d.id || '—';
            document.getElementById('vs-type').textContent = d.type || '—';
            document.getElementById('vs-role').textContent = d.role || '—';
            document.getElementById('vs-joined').textContent = d.joined || '—';
            document.getElementById('vs-contact').textContent = d.contact || '—';
            document.getElementById('vs-email').textContent = d.email || '—';
            document.getElementById('vs-address').textContent = buildAddress(d) || '—';
        }

        $('#staffTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            lengthChange: true,
            dom: "<'row align-items-center mb-2'<'col-auto'l><'col'f>>rt<'row align-items-center mt-2'<'col'i><'col-auto'p>>",
            info: true,
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: 5
            }],
            language: {
                emptyTable: 'No staff members found.',
                zeroRecords: 'No matching staff found.'
            },
        });

        $('#statusFilterGroup button').on('click', function() {
            $('#statusFilterGroup button').removeClass('active');
            $(this).addClass('active');
            const filter = $(this).data('filter');
            const table = $('#staffTable').DataTable();
            table.column(2).search(filter === 'all' ? '' : filter, true, false).draw();
        });
    </script>
@endsection
