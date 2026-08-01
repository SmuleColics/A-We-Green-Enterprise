@extends('layouts.admin')

@section('title', 'Employees')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/employees/employees.css') }}">
@endsection

@section('page-title', 'Employees')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archiveModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
        data-bs-target="#addStaffModal">
        <span class="material-symbols-outlined fs-17">person_add</span>
        Add Staff
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">badge</span>
                    <div>
                        <p class="summary-label">Total Employees</p>
                        <p class="summary-value">6</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon"
                        style="color:var(--awg-primary);">engineering</span>
                    <div>
                        <p class="summary-label">Field Employees</p>
                        <p class="summary-value">4</p>
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
                        <p class="summary-value">1</p>
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
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Secretary">Secretary</button>
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
                            <tr>
                                <td class="fw-semibold small">EMP-2026-001</td>
                                <td class="fw-semibold">Ramon Dela Cruz</td>
                                <td><span class="type-pill type-employee">Employee</span></td>
                                <td>Technician</td>
                                <td>0917-111-2222</td>
                                <td>ramon.dc@email.com</td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'EMP-2026-001',name:'Ramon Dela Cruz',type:'Employee',role:'Technician',contact:'0917-111-2222',email:'ramon.dc@email.com',address:'Block 3, Lot 5, Brgy. Tanzang Luma II, Imus, Cavite',joined:'Jan 05, 2026'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        onclick="loadEditStaff({id:'EMP-2026-001',firstname:'Ramon',lastname:'Dela Cruz',type:'Employee',role:'Technician',contact:'0917-111-2222',email:'ramon.dc@email.com',address:'Block 3, Lot 5, Brgy. Tanzang Luma II, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">EMP-2026-002</td>
                                <td class="fw-semibold">Jose Bautista</td>
                                <td><span class="type-pill type-employee">Employee</span></td>
                                <td>Driver</td>
                                <td>0918-222-3333</td>
                                <td>jose.bautista@email.com</td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'EMP-2026-002',name:'Jose Bautista',type:'Employee',role:'Driver',contact:'0918-222-3333',email:'jose.bautista@email.com',address:'Block 1, Lot 2, Brgy. Palico IV, Imus, Cavite',joined:'Jan 10, 2026'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        onclick="loadEditStaff({id:'EMP-2026-002',firstname:'Jose',lastname:'Bautista',type:'Employee',role:'Driver',contact:'0918-222-3333',email:'jose.bautista@email.com',address:'Block 1, Lot 2, Brgy. Palico IV, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">EMP-2026-003</td>
                                <td class="fw-semibold">Carlo Reyes</td>
                                <td><span class="type-pill type-employee">Employee</span></td>
                                <td>Driver / Technician</td>
                                <td>0919-333-4444</td>
                                <td>carlo.reyes@email.com</td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'EMP-2026-003',name:'Carlo Reyes',type:'Employee',role:'Driver / Technician',contact:'0919-333-4444',email:'carlo.reyes@email.com',address:'Block 4, Lot 8, Brgy. Malagasang I, Imus, Cavite',joined:'Jan 15, 2026'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        onclick="loadEditStaff({id:'EMP-2026-003',firstname:'Carlo',lastname:'Reyes',type:'Employee',role:'Driver / Technician',contact:'0919-333-4444',email:'carlo.reyes@email.com',address:'Block 4, Lot 8, Brgy. Malagasang I, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">EMP-2026-004</td>
                                <td class="fw-semibold">Mark Santos</td>
                                <td><span class="type-pill type-employee">Employee</span></td>
                                <td>Technician</td>
                                <td>0920-444-5555</td>
                                <td>mark.santos@email.com</td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'EMP-2026-004',name:'Mark Santos',type:'Employee',role:'Technician',contact:'0920-444-5555',email:'mark.santos@email.com',address:'Block 2, Lot 3, Brgy. Anabu I-A, Imus, Cavite',joined:'Jan 20, 2026'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        onclick="loadEditStaff({id:'EMP-2026-004',firstname:'Mark',lastname:'Santos',type:'Employee',role:'Technician',contact:'0920-444-5555',email:'mark.santos@email.com',address:'Block 2, Lot 3, Brgy. Anabu I-A, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">SEC-2026-001</td>
                                <td class="fw-semibold">Patricia Lim</td>
                                <td><span class="type-pill type-secretary">Secretary</span></td>
                                <td>Secretary</td>
                                <td>0925-100-2000</td>
                                <td>patricia.lim@schedquote.com</td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'SEC-2026-001',name:'Patricia Lim',type:'Secretary',role:'Secretary',contact:'0925-100-2000',email:'patricia.lim@schedquote.com',address:'Block 2, Lot 4, Brgy. Carsadang Bago I, Imus, Cavite',joined:'Jan 03, 2026'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        onclick="loadEditStaff({id:'SEC-2026-001',firstname:'Patricia',lastname:'Lim',type:'Secretary',role:'Secretary',contact:'0925-100-2000',email:'patricia.lim@schedquote.com',address:'Block 2, Lot 4, Brgy. Carsadang Bago I, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">ADM-2026-001</td>
                                <td class="fw-semibold">Michael Garcia</td>
                                <td><span class="type-pill type-admin">Admin</span></td>
                                <td>Admin</td>
                                <td>0927-300-4000</td>
                                <td>michael.garcia@schedquote.com</td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewStaffModal"
                                        onclick="loadStaffDetail({id:'ADM-2026-001',name:'Michael Garcia',type:'Admin',role:'Admin',contact:'0927-300-4000',email:'michael.garcia@schedquote.com',address:'Block 1, Lot 1, Brgy. Tanzang Luma II, Imus, Cavite',joined:'Jan 01, 2026'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                        onclick="loadEditStaff({id:'ADM-2026-001',firstname:'Michael',lastname:'Garcia',type:'Admin',role:'Admin',contact:'0927-300-4000',email:'michael.garcia@schedquote.com',address:'Block 1, Lot 1, Brgy. Tanzang Luma II, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
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
                            <p class="detail-value"><span class="badge bg-success rounded-pill">Active</span></p>
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
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1">
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
                            <input type="text" id="edit-firstname" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-lastname" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Staff Type <span class="text-danger">*</span></label>
                            <select id="edit-type" class="form-select form-select-sm" onchange="toggleEditRoleField()">
                                <option value="Employee">Employee</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="editRoleFieldWrap">
                            <label class="form-label small">Employee Role <span class="text-danger">*</span></label>
                            <select id="edit-role" class="form-select form-select-sm">
                                <option value="Driver">Driver</option>
                                <option value="Technician">Technician</option>
                                <option value="Driver / Technician">Driver / Technician</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" id="edit-contact" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email Address</label>
                            <input type="email" id="edit-email" class="form-control form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Address</label>
                            <input type="text" id="edit-address" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Add Staff Modal ── -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
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
                                placeholder="First name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" id="add-lastname" class="form-control form-control-sm"
                                placeholder="Last name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Staff Type <span class="text-danger">*</span></label>
                            <select id="add-type" class="form-select form-select-sm" onchange="toggleAddRoleField()">
                                <option value="">Select type</option>
                                <option value="Employee">Employee</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="addRoleFieldWrap" style="display:none;">
                            <label class="form-label small">Employee Role <span class="text-danger">*</span></label>
                            <select id="add-role" class="form-select form-select-sm">
                                <option value="">Select role</option>
                                <option value="Driver">Driver</option>
                                <option value="Technician">Technician</option>
                                <option value="Driver / Technician">Driver / Technician</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" id="add-contact" class="form-control form-control-sm"
                                placeholder="0917-xxx-xxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email Address</label>
                            <input type="email" id="add-email" class="form-control form-control-sm"
                                placeholder="staff@email.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Address</label>
                            <input type="text" id="add-address" class="form-control form-control-sm"
                                placeholder="Block, Lot, Barangay, City, Province">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">save</span>Save Staff
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archive Modal ── -->
    <div class="modal fade" id="archiveModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">inventory_2</span>
                        <h5 class="modal-title mb-0">Archived Staff</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="archiveTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Staff ID</th>
                                    <th class="border-0 small green-text">Name</th>
                                    <th class="border-0 small green-text">Type</th>
                                    <th class="border-0 small green-text">Role</th>
                                    <th class="border-0 small green-text">Contact</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>EMP-2025-011</td>
                                    <td>Felix Navarro</td>
                                    <td>Employee</td>
                                    <td>Technician</td>
                                    <td>0930-111-2222</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>EMP-2025-009</td>
                                    <td>Renato Aguilar</td>
                                    <td>Employee</td>
                                    <td>Driver</td>
                                    <td>0931-222-3333</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SEC-2025-001</td>
                                    <td>Lorna Castillo</td>
                                    <td>Secretary</td>
                                    <td>Secretary</td>
                                    <td>0932-333-4444</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        function loadEditStaff(d) {
            document.getElementById('edit-staff-id').textContent = d.id || '';
            document.getElementById('edit-firstname').value = d.firstname || '';
            document.getElementById('edit-lastname').value = d.lastname || '';
            document.getElementById('edit-type').value = d.type || 'Employee';
            document.getElementById('edit-contact').value = d.contact || '';
            document.getElementById('edit-email').value = d.email || '';
            document.getElementById('edit-address').value = d.address || '';

            const roleWrap = document.getElementById('editRoleFieldWrap');
            if (d.type === 'Employee') {
                roleWrap.style.display = '';
                document.getElementById('edit-role').value = d.role || '';
            } else {
                roleWrap.style.display = 'none';
            }
        }

        function toggleEditRoleField() {
            const type = document.getElementById('edit-type').value;
            document.getElementById('editRoleFieldWrap').style.display = type === 'Employee' ? '' : 'none';
        }

        function toggleAddRoleField() {
            const type = document.getElementById('add-type').value;
            document.getElementById('addRoleFieldWrap').style.display = type === 'Employee' ? '' : 'none';
        }

        document.getElementById('addStaffModal').addEventListener('show.bs.modal', () => {
            document.getElementById('add-type').value = '';
            document.getElementById('addRoleFieldWrap').style.display = 'none';
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
            }]
        });

        $('#archiveModal').on('shown.bs.modal', function() {
            if (!$.fn.DataTable.isDataTable('#archiveTable')) {
                $('#archiveTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    info: true,
                    order: [
                        [0, 'desc']
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: 6
                    }]
                });
            }
        });
    </script>
@endsection
