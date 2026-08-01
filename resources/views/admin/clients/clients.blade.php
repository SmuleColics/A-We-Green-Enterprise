@extends('layouts.admin')

@section('title', 'Clients')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/clients/clients.css') }}">
@endsection

@section('page-title', 'Clients')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archiveModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
        data-bs-target="#addClientModal">
        <span class="material-symbols-outlined fs-17">person_add</span>
        Add Client
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">groups</span>
                    <div>
                        <p class="summary-label">Total Clients</p>
                        <p class="summary-value">24</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">home</span>
                    <div>
                        <p class="summary-label">Residential</p>
                        <p class="summary-value">14</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">store</span>
                    <div>
                        <p class="summary-label">Commercial</p>
                        <p class="summary-value">7</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">account_balance</span>
                    <div>
                        <p class="summary-label">Government / LGU</p>
                        <p class="summary-value">3</p>
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
                                <th class="border-0 small green-text">Type</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold small">CLT-2026-001</td>
                                <td class="fw-semibold">Maria Santos</td>
                                <td>0917-111-2222</td>
                                <td>maria@email.com</td>
                                <td><span class="type-pill type-residential">Residential</span></td>
                                <td>CCTV Setup</td>
                                <td><span class="badge bg-success rounded-pill">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2026-001',name:'Maria Santos',contact:'0917-111-2222',email:'maria@email.com',type:'Residential',service:'CCTV Setup',status:'Active',address:'123 Rizal St, Quezon City',joined:'Jan 10, 2026',projects:'1',quotations:'1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal"
                                        onclick="loadEditClient({id:'CLT-2026-001',firstname:'Maria',lastname:'Santos',contact:'0917-111-2222',email:'maria@email.com',type:'Residential',service:'CCTV Setup',address:'123 Rizal St, Quezon City'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">CLT-2026-002</td>
                                <td class="fw-semibold">John Reyes</td>
                                <td>0918-222-3333</td>
                                <td>john.reyes@email.com</td>
                                <td><span class="type-pill type-commercial">Commercial</span></td>
                                <td>Solar Setup</td>
                                <td><span class="badge bg-success rounded-pill">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2026-002',name:'John Reyes',contact:'0918-222-3333',email:'john.reyes@email.com',type:'Commercial',service:'Solar Setup',status:'Active',address:'456 Mabini Ave, Makati City',joined:'Jan 11, 2026',projects:'1',quotations:'1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal"
                                        onclick="loadEditClient({id:'CLT-2026-002',firstname:'John',lastname:'Reyes',contact:'0918-222-3333',email:'john.reyes@email.com',type:'Commercial',service:'Solar Setup',address:'456 Mabini Ave, Makati City'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">CLT-2026-003</td>
                                <td class="fw-semibold">Anna Garcia</td>
                                <td>0920-444-5555</td>
                                <td>anna@gmail.com</td>
                                <td><span class="type-pill type-government">Government/LGU</span></td>
                                <td>Solar Street Light</td>
                                <td><span class="badge bg-success rounded-pill">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2026-003',name:'Anna Garcia',contact:'0920-444-5555',email:'anna@gmail.com',type:'Government/LGU',service:'Solar Street Light',status:'Active',address:'Brgy. Sampaloc I, Dasmariñas, Cavite',joined:'Jan 12, 2026',projects:'1',quotations:'1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal"
                                        onclick="loadEditClient({id:'CLT-2026-003',firstname:'Anna',lastname:'Garcia',contact:'0920-444-5555',email:'anna@gmail.com',type:'Government/LGU',service:'Solar Street Light',address:'Brgy. Sampaloc I, Dasmariñas, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">CLT-2026-004</td>
                                <td class="fw-semibold">Pedro Cruz</td>
                                <td>0955-444-5555</td>
                                <td>pedro@email.com</td>
                                <td><span class="type-pill type-commercial">Commercial</span></td>
                                <td>Public Address System</td>
                                <td><span class="badge bg-success rounded-pill">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2026-004',name:'Pedro Cruz',contact:'0955-444-5555',email:'pedro@email.com',type:'Commercial',service:'Public Address System',status:'Active',address:'Brgy. Anabu I-A, Imus, Cavite',joined:'Jan 13, 2026',projects:'1',quotations:'1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal"
                                        onclick="loadEditClient({id:'CLT-2026-004',firstname:'Pedro',lastname:'Cruz',contact:'0955-444-5555',email:'pedro@email.com',type:'Commercial',service:'Public Address System',address:'Brgy. Anabu I-A, Imus, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">CLT-2026-005</td>
                                <td class="fw-semibold">Lisa Tan</td>
                                <td>0933-555-6666</td>
                                <td>lisa.tan@email.com</td>
                                <td><span class="type-pill type-residential">Residential</span></td>
                                <td>CCTV Setup</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Inactive</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2026-005',name:'Lisa Tan',contact:'0933-555-6666',email:'lisa.tan@email.com',type:'Residential',service:'CCTV Setup',status:'Inactive',address:'Brgy. Molino III, Bacoor, Cavite',joined:'Jan 14, 2026',projects:'0',quotations:'1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal"
                                        onclick="loadEditClient({id:'CLT-2026-005',firstname:'Lisa',lastname:'Tan',contact:'0933-555-6666',email:'lisa.tan@email.com',type:'Residential',service:'CCTV Setup',address:'Brgy. Molino III, Bacoor, Cavite'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold small">CLT-2026-006</td>
                                <td class="fw-semibold">Roberto Lim</td>
                                <td>0944-666-7777</td>
                                <td>roberto.lim@email.com</td>
                                <td><span class="type-pill type-government">Government/LGU</span></td>
                                <td>Solar Street Light</td>
                                <td><span class="badge bg-success rounded-pill">Active</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewClientModal"
                                        onclick="loadClientDetail({id:'CLT-2026-006',name:'Roberto Lim',contact:'0944-666-7777',email:'roberto.lim@email.com',type:'Government/LGU',service:'Solar Street Light',status:'Active',address:'Brgy. Navarro, General Trias, Cavite',joined:'Jan 15, 2026',projects:'1',quotations:'2'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editClientModal"
                                        onclick="loadEditClient({id:'CLT-2026-006',firstname:'Roberto',lastname:'Lim',contact:'0944-666-7777',email:'roberto.lim@email.com',type:'Government/LGU',service:'Solar Street Light',address:'Brgy. Navarro, General Trias, Cavite'})">
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
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">archive</span>Archive Client
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Client Modal ── -->
    <div class="modal fade" id="editClientModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">manage_accounts</span>
                        Edit Client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted small mb-0" id="edit-client-id">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">First Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-client-firstname" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-client-lastname" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Client Type <span class="text-danger">*</span></label>
                            <select id="edit-client-type" class="form-select form-select-sm">
                                <option value="Residential">Residential</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Government/LGU">Government / LGU</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Service <span class="text-danger">*</span></label>
                            <select id="edit-client-service" class="form-select form-select-sm">
                                <option>CCTV Setup</option>
                                <option>Solar Setup</option>
                                <option>Solar Street Light</option>
                                <option>Public Address System</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" id="edit-client-contact" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email Address</label>
                            <input type="email" id="edit-client-email" class="form-control form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Address</label>
                            <input type="text" id="edit-client-address" class="form-control form-control-sm">
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


    <!-- ── Add Client Modal ── -->
    <div class="modal fade" id="addClientModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">person_add</span>
                        Add New Client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="First name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="Last name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Client Type <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                                <option value="">Select type</option>
                                <option>Residential</option>
                                <option>Commercial</option>
                                <option>Government/LGU</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Service <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                                <option value="">Select service</option>
                                <option>CCTV Setup</option>
                                <option>Solar Setup</option>
                                <option>Solar Street Light</option>
                                <option>Public Address System</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" placeholder="0917-xxx-xxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email Address</label>
                            <input type="email" class="form-control form-control-sm" placeholder="client@email.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Address</label>
                            <input type="text" class="form-control form-control-sm"
                                placeholder="Block, Lot, Barangay, City, Province">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">save</span>Save Client
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
                        <h5 class="modal-title mb-0">Archived Clients</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="archiveTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Client ID</th>
                                    <th class="border-0 small green-text">Client Name</th>
                                    <th class="border-0 small green-text">Contact</th>
                                    <th class="border-0 small green-text">Type</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CLT-2025-018</td>
                                    <td>Elena Cruz</td>
                                    <td>0922-111-2222</td>
                                    <td><span class="type-pill type-residential">Residential</span></td>
                                    <td>CCTV Setup</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CLT-2025-022</td>
                                    <td>Ramon dela Cruz</td>
                                    <td>0933-222-3333</td>
                                    <td><span class="type-pill type-commercial">Commercial</span></td>
                                    <td>Solar Setup</td>
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
            badge.className = `badge rounded-pill ${d.status === 'Active' ? 'bg-success' : 'bg-warning text-dark'}`;
        }

        function loadEditClient(d) {
            document.getElementById('edit-client-id').textContent = d.id || '';
            document.getElementById('edit-client-firstname').value = d.firstname || '';
            document.getElementById('edit-client-lastname').value = d.lastname || '';
            document.getElementById('edit-client-type').value = d.type || 'Residential';
            document.getElementById('edit-client-service').value = d.service || '';
            document.getElementById('edit-client-contact').value = d.contact || '';
            document.getElementById('edit-client-email').value = d.email || '';
            document.getElementById('edit-client-address').value = d.address || '';
        }

        $('#clientsTable').DataTable({
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
