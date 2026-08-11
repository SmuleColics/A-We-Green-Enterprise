@extends('layouts.admin')

@section('title', 'Employees')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/employees/employees.css') }}">
@endsection

@section('page-title', 'Employees')

@section('topbar-actions')
    <a href="{{ route('archive-employees') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
        data-bs-target="#addStaffModal">
        <span class="material-symbols-outlined fs-17">person_add</span>
        Add Staff
    </button>
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
                    <span class="material-symbols-outlined summary-icon green-text">badge</span>
                    <div>
                        <p class="summary-label">Total Staff</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#8b5cf6;">admin_panel_settings</span>
                    <div>
                        <p class="summary-label">Admins</p>
                        <p class="summary-value">{{ $admins }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#f59e0b;">build</span>
                    <div>
                        <p class="summary-label">Technicians</p>
                        <p class="summary-value">{{ $technicians }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#3b82f6;">local_shipping</span>
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
                                <th class="border-0 small green-text">Email</th>
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
                                        'firstname' => $staff->user->first_name,
                                        'lastname' => $staff->user->last_name,
                                        'name' => $staff->user->full_name,
                                        'type' => $typeLabel,
                                        'role' => $roleDisplay,
                                        'position' => $staff->employee?->position,
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
                                    <td>{{ $staff->user->contact_number }}</td>
                                    <td>{{ $staff->user->email }}</td>
                                    <td class="actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                            data-staff='@json($staffPayload)'
                                            onclick="loadStaffDetail(JSON.parse(this.dataset.staff))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                            data-staff='@json($staffPayload)'
                                            onclick="loadEditStaff(JSON.parse(this.dataset.staff))">
                                            <span class="material-symbols-outlined icon-action">edit</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                            onclick="archiveStaff({{ $staff->id }}, '{{ $staff->user->full_name }}')">
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
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        id="vs-archive-btn">
                        <span class="material-symbols-outlined fs-16">archive</span>Archive Staff
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Staff Modal ── -->
    <div class="modal fade" id="editStaffModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="editStaffForm" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-20">manage_accounts</span>
                            Edit Profile
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <p class="text-muted small mb-0" id="edit-staff-id">—</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit-firstname" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit-lastname" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Staff Type <span class="text-danger">*</span></label>
                                <select id="edit-type" class="form-select form-select-sm"
                                    onchange="toggleEditRoleField()">
                                    <option value="Employee">Employee</option>
                                    <option value="Secretary">Secretary</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" id="edit-contact" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6" id="editRoleFieldWrap">
                                <label class="form-label small">Employee Role <span class="text-danger">*</span></label>
                                <select id="edit-role" class="form-select form-select-sm">
                                    <option value="driver">Driver</option>
                                    <option value="technician">Technician</option>
                                    <option value="driver_technician">Driver / Technician</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" id="edit-email" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6" id="editPasswordFieldWrap">
                                <label class="form-label small">New Password</label>
                                <div class="input-icon-wrap">
                                    <input type="password" id="edit-password"
                                        class="form-control form-control-sm pe-input"
                                        placeholder="Leave blank to keep current">
                                    <button type="button" class="password-toggle" id="toggleEditPassword"
                                        aria-label="Show password">
                                        <span class="material-symbols-outlined fs-16"
                                            id="toggleEditPasswordIcon">visibility</span>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-1">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small">Block</label>
                                <input type="text" id="edit-block" class="form-control form-control-sm"
                                    placeholder="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Lot</label>
                                <input type="text" id="edit-lot" class="form-control form-control-sm"
                                    placeholder="20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Street / Purok / Sitio</label>
                                <input type="text" id="edit-street" class="form-control form-control-sm"
                                    placeholder="Green St.">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Barangay <span class="text-danger">*</span></label>
                                <input type="text" id="edit-barangay" class="form-control form-control-sm"
                                    placeholder="Olaes" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">City <span class="text-danger">*</span></label>
                                <input type="text" id="edit-city" class="form-control form-control-sm"
                                    placeholder="GMA" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Province <span class="text-danger">*</span></label>
                                <input type="text" id="edit-province" class="form-control form-control-sm"
                                    placeholder="Cavite" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Zip Code</label>
                                <input type="text" id="edit-zip" class="form-control form-control-sm"
                                    placeholder="4117">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">save</span>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ── Add Staff Modal ── -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="addStaffForm" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-20">person_add</span>
                            Add New Staff
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                <input type="text" id="add-firstname" class="form-control form-control-sm"
                                    placeholder="First name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                <input type="text" id="add-lastname" class="form-control form-control-sm"
                                    placeholder="Last name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Staff Type <span class="text-danger">*</span></label>
                                <select id="add-type" class="form-select form-select-sm" onchange="toggleAddRoleField()"
                                    required>
                                    <option value="">Select type</option>
                                    <option value="Employee">Employee</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" id="add-contact" class="form-control form-control-sm"
                                    placeholder="0917-xxx-xxxx" required>
                            </div>

                            <div class="col-md-6" id="addRoleFieldWrap" style="display:none;">
                                <label class="form-label small">Employee Role <span class="text-danger">*</span></label>
                                <select id="add-role" class="form-select form-select-sm">
                                    <option value="">Select role</option>
                                    <option value="driver">Driver</option>
                                    <option value="technician">Technician</option>
                                    <option value="driver_technician">Driver / Technician</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" id="add-email" class="form-control form-control-sm"
                                    placeholder="staff@email.com" required>
                            </div>
                            <div class="col-md-6" id="addPasswordFieldWrap">
                                <label class="form-label small">Password <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <input type="password" id="add-password"
                                        class="form-control form-control-sm pe-input" placeholder="Min. 8 characters"
                                        required minlength="8">
                                    <button type="button" class="password-toggle" id="toggleAddPassword"
                                        aria-label="Show password">
                                        <span class="material-symbols-outlined fs-16"
                                            id="toggleAddPasswordIcon">visibility</span>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-1">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small">Block</label>
                                <input type="text" id="add-block" class="form-control form-control-sm"
                                    placeholder="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Lot</label>
                                <input type="text" id="add-lot" class="form-control form-control-sm"
                                    placeholder="20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Street / Purok / Sitio</label>
                                <input type="text" id="add-street" class="form-control form-control-sm"
                                    placeholder="Green St.">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Barangay <span class="text-danger">*</span></label>
                                <input type="text" id="add-barangay" class="form-control form-control-sm"
                                    placeholder="Olaes" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">City <span class="text-danger">*</span></label>
                                <input type="text" id="add-city" class="form-control form-control-sm"
                                    placeholder="GMA" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Province <span class="text-danger">*</span></label>
                                <input type="text" id="add-province" class="form-control form-control-sm"
                                    placeholder="Cavite" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Zip Code</label>
                                <input type="text" id="add-zip" class="form-control form-control-sm"
                                    placeholder="4117">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">save</span>Save Staff
                        </button>
                    </div>
                </form>
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

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Route templates — ':id' gets swapped for the real staff DB id at call time
        const routes = {
            store: @json(route('employees.store')),
            update: @json(route('employees.update', ':id')),
            archive: @json(route('employees.archive', ':id')),
        };

        function wirePasswordToggle(btnId, iconId, inputId) {
            const btn = document.getElementById(btnId);
            const icon = document.getElementById(iconId);
            const input = document.getElementById(inputId);
            if (!btn || !icon || !input) return;

            btn.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.textContent = isPassword ? 'visibility_off' : 'visibility';
                btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
            });
        }

        wirePasswordToggle('toggleAddPassword', 'toggleAddPasswordIcon', 'add-password');
        wirePasswordToggle('toggleEditPassword', 'toggleEditPasswordIcon', 'edit-password');

        function buildAddress(d) {
            return [
                [d.block, d.lot].filter(Boolean).join(' Lot '),
                d.street,
                d.barangay,
                d.city,
                d.province,
                d.zip_code,
            ].filter(Boolean).join(', ');
        }

        function loadStaffDetail(d) {
            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ? parts[0][0] + parts[parts.length - 1][0] : (parts[0] ? parts[0][0] : '?');
            const typeClass = 'type-' + (d.type || 'employee').toLowerCase();

            const avatar = document.getElementById('vs-avatar');
            avatar.textContent = initials.toUpperCase();
            avatar.className = 'staff-avatar ' + typeClass; // reuses .type-* bg/text from CSS

            const badge = document.getElementById('vs-type-badge');
            badge.textContent = d.type;
            badge.className = 'type-pill ' + typeClass; // same pill style as the table

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

            document.getElementById('vs-archive-btn').onclick = () => archiveStaff(d.db_id, d.name);
        }

        function setEditRoleAndPasswordLayout(isEmployee) {
            document.getElementById('editRoleFieldWrap').style.display = isEmployee ? '' : 'none';
            const pwWrap = document.getElementById('editPasswordFieldWrap');
            pwWrap.classList.toggle('col-md-6', !isEmployee);
            pwWrap.classList.toggle('col-12', isEmployee);
        }

        function loadEditStaff(d) {
            document.getElementById('edit-staff-id').textContent = d.id || '';
            document.getElementById('edit-staff-id').dataset.dbId = d.db_id;
            document.getElementById('edit-firstname').value = d.firstname || '';
            document.getElementById('edit-lastname').value = d.lastname || '';
            document.getElementById('edit-type').value = d.type || 'Employee';
            document.getElementById('edit-contact').value = d.contact || '';
            document.getElementById('edit-email').value = d.email || '';
            document.getElementById('edit-password').value = '';
            document.getElementById('edit-block').value = d.block || '';
            document.getElementById('edit-lot').value = d.lot || '';
            document.getElementById('edit-street').value = d.street || '';
            document.getElementById('edit-barangay').value = d.barangay || '';
            document.getElementById('edit-city').value = d.city || '';
            document.getElementById('edit-province').value = d.province || '';
            document.getElementById('edit-zip').value = d.zip_code || '';

            const isEmployee = d.type === 'Employee';
            setEditRoleAndPasswordLayout(isEmployee);
            if (isEmployee) {
                document.getElementById('edit-role').value = d.position || '';
            }
        }

        function toggleEditRoleField() {
            const type = document.getElementById('edit-type').value;
            setEditRoleAndPasswordLayout(type === 'Employee');
        }

        function toggleAddRoleField() {
            const type = document.getElementById('add-type').value;
            const isEmployee = type === 'Employee';
            document.getElementById('addRoleFieldWrap').style.display = isEmployee ? '' : 'none';

            const pwWrap = document.getElementById('addPasswordFieldWrap');
            pwWrap.classList.toggle('col-md-6', !isEmployee);
            pwWrap.classList.toggle('col-12', isEmployee);
        }

        document.getElementById('addStaffModal').addEventListener('show.bs.modal', () => {
            document.getElementById('addStaffForm').reset();
            document.getElementById('addRoleFieldWrap').style.display = 'none';
            document.getElementById('addPasswordFieldWrap').classList.add('col-md-6');
            document.getElementById('addPasswordFieldWrap').classList.remove('col-12');
        });

        async function submitJson(url, method, payload, form) {
            clearFieldErrors(form);
            try {
                const res = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await res.json();

                if (res.status === 422) {
                    showFieldErrors(form, data.errors || {});
                    return;
                }

                if (!res.ok) {
                    showToast(data.message || 'Something went wrong. Please try again.', 'danger');
                    return;
                }

                sessionStorage.setItem('pendingToast', JSON.stringify({
                    message: data.message,
                    type: 'success',
                }));
                window.location.reload();
            } catch (err) {
                showToast('Network error — please try again.', 'danger');
            }
        }

        function clearFieldErrors(form) {
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        }

        function showFieldErrors(form, errors) {
            Object.entries(errors).forEach(([field, messages]) => {
                const prefix = form.id === 'addStaffForm' ? 'add-' : 'edit-';
                const el = document.getElementById(prefix + field.replace('_', '')) ||
                    document.getElementById(prefix + field);
                if (el) {
                    el.classList.add('is-invalid');
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = messages[0];
                    el.insertAdjacentElement('afterend', feedback);
                }
            });
        }

        document.getElementById('addStaffForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!this.checkValidity()) {
                this.classList.add('was-validated');
                return; // stop — do not call submitJson()
            }

            const payload = {
                first_name: document.getElementById('add-firstname').value,
                last_name: document.getElementById('add-lastname').value,
                type: document.getElementById('add-type').value,
                position: document.getElementById('add-role').value || null,
                contact_number: document.getElementById('add-contact').value,
                email: document.getElementById('add-email').value,
                password: document.getElementById('add-password').value,
                block: document.getElementById('add-block').value,
                lot: document.getElementById('add-lot').value,
                street: document.getElementById('add-street').value,
                barangay: document.getElementById('add-barangay').value,
                city: document.getElementById('add-city').value,
                province: document.getElementById('add-province').value,
                zip_code: document.getElementById('add-zip').value,
            };
            submitJson(routes.store, 'POST', payload, this);
        });

        document.getElementById('editStaffForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!this.checkValidity()) {
                this.classList.add('was-validated');
                return;
            }

            const dbId = document.getElementById('edit-staff-id').dataset.dbId;
            const payload = {
                first_name: document.getElementById('edit-firstname').value,
                last_name: document.getElementById('edit-lastname').value,
                type: document.getElementById('edit-type').value,
                position: document.getElementById('edit-role').value || null,
                contact_number: document.getElementById('edit-contact').value,
                email: document.getElementById('edit-email').value,
                password: document.getElementById('edit-password').value || null,
                block: document.getElementById('edit-block').value,
                lot: document.getElementById('edit-lot').value,
                street: document.getElementById('edit-street').value,
                barangay: document.getElementById('edit-barangay').value,
                city: document.getElementById('edit-city').value,
                province: document.getElementById('edit-province').value,
                zip_code: document.getElementById('edit-zip').value,
            };
            submitJson(routes.update.replace(':id', dbId), 'PATCH', payload, this);
        });

        function archiveStaff(dbId, name) {
            if (!confirm(`Archive ${name}? They will be moved out of the active staff list.`)) return;
            fetch(routes.archive.replace(':id', dbId), {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                .then(res => res.json())
                .then(data => {
                    sessionStorage.setItem('pendingToast', JSON.stringify({
                        message: data.message,
                        type: 'success',
                    }));
                    window.location.reload();
                })
                .catch(() => showToast('Network error — please try again.', 'danger'));
        }

        // Show any toast queued from before a reload (Add/Edit/Archive success)
        document.addEventListener('DOMContentLoaded', function() {
            const pending = sessionStorage.getItem('pendingToast');
            if (pending) {
                const {
                    message,
                    type
                } = JSON.parse(pending);
                showToast(message, type);
                sessionStorage.removeItem('pendingToast');
            }
        });

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
                targets: 6
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
