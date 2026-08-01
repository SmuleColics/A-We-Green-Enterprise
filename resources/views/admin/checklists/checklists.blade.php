@extends('layouts.admin')

@section('title', 'Checklists')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/checklist/checklist.css') }}">
@endsection

@section('page-title', 'Checklists')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1"
        data-bs-toggle="modal" data-bs-target="#archivedProjectsModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text">
        <span class="material-symbols-outlined me-1 fs-18">add</span>
        New Checklist
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">checklist</span>
                    <div>
                        <p class="summary-label">Total Checklists</p>
                        <p class="summary-value">4</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">task_alt</span>
                    <div>
                        <p class="summary-label">Completed</p>
                        <p class="summary-value">1</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">pending_actions</span>
                    <div>
                        <p class="summary-label">In Progress</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pause_circle</span>
                    <div>
                        <p class="summary-label">On Hold</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklists Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="btn-group filter-btn-group mb-3" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Completed">Completed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="In Progress">In Progress</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="On Hold">On Hold</button>
                </div>

                <div class="table-responsive">
                    <table id="checklistsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Checklist</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Progress</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">Santos Residence CCTV</td>
                                <td>Maria Santos</td>
                                <td>CCTV Setup</td>
                                <td>Mar 10, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-primary wp-30"></div>
                                        </div>
                                        <small class="text-muted">30%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary rounded-pill" data-status="2">In Progress</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalSantos">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalSantos">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveChecklistConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Reyes Solar Installation</td>
                                <td>John Reyes</td>
                                <td>Solar Setup</td>
                                <td>Mar 11, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-primary wp-55"></div>
                                        </div>
                                        <small class="text-muted">55%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary rounded-pill" data-status="2">In Progress</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalReyes">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalReyes">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveChecklistConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Garcia Street Lights</td>
                                <td>Anna Garcia</td>
                                <td>Solar Street Light</td>
                                <td>Mar 12, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress" style="height:6px;">
                                            <div class="progress-bar bg-warning" style="width:13%;"></div>
                                        </div>
                                        <small class="text-muted">13%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark rounded-pill" data-status="3">On Hold</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalGarcia">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalGarcia">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveChecklistConfirmModal">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Cruz PA System</td>
                                <td>Pedro Cruz</td>
                                <td>Public Address System</td>
                                <td>Mar 13, 2026</td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress hpx-6">
                                            <div class="progress-bar bg-awg-primary wp-100"></div>
                                        </div>
                                        <small class="text-muted">100%</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-awg-primary rounded-pill" data-status="1">Completed</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalCruz">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#checklistModalCruz">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                        data-bs-toggle="modal" data-bs-target="#archiveChecklistConfirmModal">
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


    <!-- ── Archived Projects Modal ── -->
    <div class="modal fade" id="archivedProjectsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">inventory_2</span>
                        <h5 class="modal-title mb-0">Archived Projects</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Project</th>
                                    <th class="border-0 small green-text">Client</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Archived On</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">PA System - Quezon City</td>
                                    <td>Lisa Tan</td>
                                    <td>Public Address System</td>
                                    <td><span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle">Completed</span></td>
                                    <td class="text-muted small">Feb 1, 2026</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Solar Setup - Cavite</td>
                                    <td>Ramon Dela Cruz</td>
                                    <td>Solar Setup</td>
                                    <td><span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle">Cancelled</span></td>
                                    <td class="text-muted small">Jan 5, 2026</td>
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


    <!-- ── Archive Confirm Modal ── -->
    <div class="modal fade" id="archiveChecklistConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Archive Checklist?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">This checklist will be moved to the archive. You can restore it anytime later.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Checklist Modal: Santos ── -->
    <div class="modal fade checklist-modal" id="checklistModalSantos" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1">Santos Residence CCTV</h5>
                        <p class="text-muted small mb-0">Maria Santos · CCTV Setup · 8 of 15 completed</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="checklist-table">
                            <thead>
                                <tr>
                                    <th>Item</th><th>Qty</th><th>Out</th><th>N/A</th><th>Complete</th><th>Return</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row-complete">
                                    <td>Camera</td><td>4 pcs</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="4"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td>
                                </tr>
                                <tr class="row-complete">
                                    <td>DVR</td><td>1 unit</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td>
                                </tr>
                                <tr class="row-complete">
                                    <td>Hard Disc</td><td>1 unit</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td>
                                </tr>
                                <tr>
                                    <td>Media Converter</td><td>2 pcs</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="2"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>Siamese Cable</td><td>50 m</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="50"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td>
                                </tr>
                                <tr class="row-complete">
                                    <td>CAT 6 Cable</td><td>30 m</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="30"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td>
                                </tr>
                                <tr class="row-complete">
                                    <td>Monitor</td><td>1 unit</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td>
                                </tr>
                                <tr class="row-complete">
                                    <td>Power Supply</td><td>1 unit</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td>
                                </tr>
                                <tr>
                                    <td>Video Balun</td><td>-</td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td>
                                    <td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td>
                                    <td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Checklist Modal: Reyes ── -->
    <div class="modal fade checklist-modal" id="checklistModalReyes" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1">Reyes Solar Installation</h5>
                        <p class="text-muted small mb-0">John Reyes · Solar Setup · 8 of 15 completed</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="checklist-table">
                            <thead>
                                <tr><th>Item</th><th>Qty</th><th>Out</th><th>N/A</th><th>Complete</th><th>Return</th></tr>
                            </thead>
                            <tbody>
                                <tr class="row-complete"><td>Solar Panel</td><td>6 pcs</td><td><input type="number" class="form-control form-control-sm checklist-input" value="6"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Solar Inverter</td><td>1 unit</td><td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Battery Pack</td><td>2 units</td><td><input type="number" class="form-control form-control-sm checklist-input" value="2"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Charge Controller</td><td>1 unit</td><td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>MC4 Connector</td><td>12 pairs</td><td><input type="number" class="form-control form-control-sm checklist-input" value="12"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Solar Cable (6mm)</td><td>30 m</td><td><input type="number" class="form-control form-control-sm checklist-input" value="30"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Mounting Rails</td><td>4 sets</td><td><input type="number" class="form-control form-control-sm checklist-input" value="4"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Circuit Breaker (DC)</td><td>2 pcs</td><td><input type="number" class="form-control form-control-sm checklist-input" value="2"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr><td>AC Distribution Box</td><td>1 unit</td><td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Conduit Pipe</td><td>10 lengths</td><td><input type="number" class="form-control form-control-sm checklist-input" value="10"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Ground Rod</td><td>2 pcs</td><td><input type="number" class="form-control form-control-sm checklist-input" value="2"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Copper Lug Terminal</td><td>20 pcs</td><td><input type="number" class="form-control form-control-sm checklist-input" value="20"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Cable Ties</td><td>2 bags</td><td><input type="number" class="form-control form-control-sm checklist-input" value="2"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Power Tools</td><td>1 lot</td><td><input type="number" class="form-control form-control-sm checklist-input" value="1"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Electrical Tape</td><td>3 rolls</td><td><input type="number" class="form-control form-control-sm checklist-input" value="3"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-outline-secondary" onclick="window.print()">Print</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Checklist Modal: Garcia ── -->
    <div class="modal fade checklist-modal" id="checklistModalGarcia" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1">Garcia Street Lights</h5>
                        <p class="text-muted small mb-0">Anna Garcia · Solar Street Light · 2 of 15 completed</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="checklist-table">
                            <thead>
                                <tr><th>Item</th><th>Qty</th><th>Out</th><th>N/A</th><th>Complete</th><th>Return</th></tr>
                            </thead>
                            <tbody>
                                <tr class="row-complete"><td>Solar Street Light Unit</td><td>10 units</td><td><input type="number" class="form-control form-control-sm checklist-input" value="10"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr class="row-complete"><td>Mounting Pole</td><td>10 pcs</td><td><input type="number" class="form-control form-control-sm checklist-input" value="10"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" value="0"></td></tr>
                                <tr><td>Anchor Bolt Set</td><td>10 sets</td><td><input type="number" class="form-control form-control-sm checklist-input" value="10"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Solar Panel (60W)</td><td>10 pcs</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>LED Light Head</td><td>10 units</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Lithium Battery (100Ah)</td><td>10 units</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Controller Box</td><td>10 units</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Fiber Optic Cable</td><td>200 m</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Conduit Pipe</td><td>20 lengths</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Cable Ties</td><td>3 bags</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Electrical Tape</td><td>5 rolls</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Grounding Wire</td><td>50 m</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Cement (for base)</td><td>10 bags</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Power Tools</td><td>1 lot</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                                <tr><td>Safety Equipment</td><td>1 lot</td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" class="form-control form-control-sm checklist-input" placeholder="0"></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-outline-secondary" onclick="window.print()">Print</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Checklist Modal: Cruz ── -->
    <div class="modal fade checklist-modal" id="checklistModalCruz" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1">Cruz PA System</h5>
                        <p class="text-muted small mb-0">Pedro Cruz · Public Address System · 0 of 15 completed</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="checklist-table">
                            <thead>
                                <tr><th>Item</th><th>Qty</th><th>Out</th><th>N/A</th><th>Complete</th><th>Return</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Amplifier</td><td>1 unit</td><td><input type="text" value="1 unit" class="form-control form-control-sm checklist-input"></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" value="0" class="form-control form-control-sm checklist-input"></td></tr>
                                <tr><td>Speaker (Horn)</td><td>8 pcs</td><td><input type="text" value="8 pcs" class="form-control form-control-sm checklist-input"></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="text" value="1 pc" class="form-control form-control-sm checklist-input"></td></tr>
                                <tr><td>Microphone</td><td>2 units</td><td><input type="text" value="2 units" class="form-control form-control-sm checklist-input"></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" value="0" class="form-control form-control-sm checklist-input"></td></tr>
                                <tr><td>Mixer Console</td><td>1 unit</td><td><input type="text" value="1 unit" class="form-control form-control-sm checklist-input"></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option selected>No</option><option>Yes</option></select></td><td><input type="number" value="0" class="form-control form-control-sm checklist-input"></td></tr>
                                <tr><td>Speaker Cable (2-core)</td><td>100 m</td><td><input type="text" value="100 m" class="form-control form-control-sm checklist-input"></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="text" value="10 m" class="form-control form-control-sm checklist-input"></td></tr>
                                <tr><td>Microphone Cable (XLR)</td><td>2 pcs</td><td><input type="number" value="2" class="form-control form-control-sm checklist-input"></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><select class="form-select form-select-sm checklist-select"><option>No</option><option selected>Yes</option></select></td><td><input type="number" value="0" class="form-control form-control-sm checklist-input"></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            jQuery.fn.dataTable.ext.type.order['status-priority-pre'] = function(data) {
                return $(data).data('status') || 0;
            };

            $('#checklistsTable').DataTable({
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: 6 },
                    { type: 'status-priority', targets: 5 }
                ],
                order: [[5, 'asc']]
            });
        });
    </script>
@endsection