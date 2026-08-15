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
                        <p class="summary-label">Total Archived</p>
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

        <!-- Archived Staff Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Admin">Admin</button>
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
                            @foreach ($staffMembers as $staff)
                                @php
                                    $role = $staff->user->role;
                                    $typeLabel = $typeLabels[$role] ?? ucfirst($role);
                                    $roleDisplay =
                                        $role === \App\Models\User::ROLE_EMPLOYEE
                                            ? $positionLabels[$staff->employee?->position] ?? '—'
                                            : $typeLabel;

                                    $staffPayload = [
                                        'db_id' => $staff->id,
                                        'id' => $staff->staff_id,
                                        'name' => $staff->user->full_name,
                                        'type' => $typeLabel,
                                        'role' => $roleDisplay,
                                        'contact' => $staff->user->contact_number,
                                        'email' => $staff->user->email,
                                        'address' => collect([
                                            $staff->block ? "Blk {$staff->block}" : null,
                                            $staff->lot ? "Lot {$staff->lot}" : null,
                                            $staff->street,
                                            $staff->barangay,
                                            $staff->city,
                                            $staff->province,
                                            $staff->zip_code,
                                        ])->filter()->implode(', '),
                                        'joined' => optional($staff->date_joined)->format('M d, Y'),
                                        'archivedOn' => $staff->archived_at?->format('M d, Y'),
                                    ];
                                @endphp
                                <tr>
                                    <td class="fw-semibold small">{{ $staff->staff_id }}</td>
                                    <td class="fw-semibold">{{ $staff->user->full_name }}</td>
                                    <td><span class="type-pill type-{{ strtolower($typeLabel) }}">{{ $typeLabel }}</span>
                                    </td>
                                    <td>{{ $roleDisplay }}</td>
                                    <td>{{ $staff->user->contact_number }}</td>
                                    <td>{{ $staff->user->email }}</td>
                                    <td class="text-muted small"
                                        data-order="{{ optional($staff->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $staff->archived_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                            data-staff='@json($staffPayload)'
                                            onclick="loadStaffDetail(JSON.parse(this.dataset.staff))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm({{ $staff->id }}, {{ Js::from($staff->user->full_name) }})">
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
                            <span class="badge bg-secondary rounded-pill mt-1">Archived</span>
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
                            <p class="detail-label fs-12">Archived On</p>
                            <p class="detail-value fs-14" id="vs-archivedOn">—</p>
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
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1"
                        id="vs-restore-btn">
                        <span class="material-symbols-outlined fs-16">unarchive</span>Restore Staff
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
                    <h6 class="modal-title fw-semibold">Restore this staff member?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        <strong id="rc-staff-name">—</strong> will be moved back to <strong>Employees</strong>.
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const ROUTES = {
            unarchive: {{ Js::from(route('employees.unarchive', ['staff' => '__ID__'])) }},
        };

        let pendingRestoreId = null;

        function buildAddress(d) {
            return d.address || '—';
        }

        function loadStaffDetail(d) {
            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ? parts[0][0] + parts[parts.length - 1][0] : (parts[0] ? parts[0][0] : '?');
            const typeClass = 'type-' + (d.type || 'employee').toLowerCase();

            const avatar = document.getElementById('vs-avatar');
            avatar.textContent = initials.toUpperCase();
            avatar.className = 'staff-avatar ' + typeClass;

            document.getElementById('vs-name').textContent = d.name || '—';
            document.getElementById('vs-id').textContent = d.id || '—';
            document.getElementById('vs-type').textContent = d.type || '—';
            document.getElementById('vs-role').textContent = d.role || '—';
            document.getElementById('vs-joined').textContent = d.joined || '—';
            document.getElementById('vs-archivedOn').textContent = d.archivedOn || '—';
            document.getElementById('vs-contact').textContent = d.contact || '—';
            document.getElementById('vs-email').textContent = d.email || '—';
            document.getElementById('vs-address').textContent = buildAddress(d);

            document.getElementById('vs-restore-btn').onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewStaffModal'))?.hide();
                openRestoreConfirm(d.db_id, d.name);
            };
        }

        /* ─────────────────────────────────────────
           RESTORE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(id, name) {
            pendingRestoreId = id;
            document.getElementById('rc-staff-name').textContent = name;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        showToast(data.message || 'Unable to restore this staff member.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    restoreConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        $(document).ready(function() {
            const table = $('#archiveStaffTable').DataTable({
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
                }],
                language: {
                    emptyTable: 'No archived staff members yet.',
                    zeroRecords: 'No matching archived staff found.'
                }
            });

            $('#statusFilterGroup button').on('click', function() {
                $('#statusFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                table.column(2).search(filter === 'all' ? '' : filter, true, false).draw();
            });
        });
    </script>
@endsection
