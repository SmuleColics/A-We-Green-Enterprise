@extends('layouts.admin')

@section('title', 'Quotation')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/quotation/quotation.css') }}">
@endsection

@section('page-title', 'Quotation')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archiveModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text" data-bs-toggle="modal"
        data-bs-target="#newQuotationModal">
        <span class="material-symbols-outlined me-1 fs-18">add</span>
        New Quotation
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">inbox</span>
                    <div>
                        <p class="summary-label">Total</p>
                        <p class="summary-value">26</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">send</span>
                    <div>
                        <p class="summary-label">Sent</p>
                        <p class="summary-value">8</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">rate_review</span>
                    <div>
                        <p class="summary-label">Pending</p>
                        <p class="summary-value">5</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Approved</p>
                        <p class="summary-value">12</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quotations Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active"
                            data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Approved">Approved</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Sent</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Pending">Pending</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Draft">Draft</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Rejected">Rejected</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="quotationsTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Amount</th>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Approved — show form button --}}
                            <tr>
                                <td>QT-2026-003</td>
                                <td>Anna Garcia</td>
                                <td>Solar Street Light</td>
                                <td>₱850,000.00</td>
                                <td>Mar 12, 2026</td>
                                <td><span class="badge bg-success rounded-pill" data-status="1">Approved</span></td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('proposals') }}" class="btn btn-sm btn-outline-success action-btn"
                                        title="Open Form">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#newQuotationModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- Approved — show form button --}}
                            <tr>
                                <td>QT-2026-006</td>
                                <td>Roberto Lim</td>
                                <td>Solar Street Light</td>
                                <td>₱750,000.00</td>
                                <td>Mar 15, 2026</td>
                                <td><span class="badge bg-success rounded-pill" data-status="1">Approved</span></td>
                                <td class="text-nowrap actions-col">
                                    <a href="{{ route('form') }}" class="btn btn-sm btn-outline-success action-btn"
                                        title="Open Form">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#newQuotationModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- Sent — placeholder --}}
                            <tr>
                                <td>QT-2026-002</td>
                                <td>John Reyes</td>
                                <td>Solar Setup</td>
                                <td>₱120,000.00</td>
                                <td>Mar 11, 2026</td>
                                <td><span class="badge bg-primary text-white rounded-pill" data-status="2">Sent</span>
                                </td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#newQuotationModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- For Review — placeholder --}}
                            <tr>
                                <td>QT-2026-001</td>
                                <td>Maria Santos</td>
                                <td>CCTV Setup</td>
                                <td>₱45,000.00</td>
                                <td>Mar 10, 2026</td>
                                <td><span class="badge bg-warning text-dark rounded-pill" data-status="3">For
                                        Review</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#newQuotationModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- Draft — placeholder --}}
                            <tr>
                                <td>QT-2026-004</td>
                                <td>Pedro Cruz</td>
                                <td>Public Address System</td>
                                <td>₱95,000.00</td>
                                <td>Mar 13, 2026</td>
                                <td><span class="badge bg-secondary rounded-pill" data-status="4">Draft</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#newQuotationModal">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- Rejected — placeholder --}}
                            <tr>
                                <td>QT-2026-005</td>
                                <td>Lisa Tan</td>
                                <td>CCTV Setup</td>
                                <td>₱55,000.00</td>
                                <td>Mar 14, 2026</td>
                                <td><span class="badge bg-danger rounded-pill" data-status="5">Rejected</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#newQuotationModal">
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


    <!-- ── New Quotation Modal ── -->
    <div class="modal fade" id="newQuotationModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Quotation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Info Banner -->
                    <div class="alert alert-info d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined fs-18">info</span>
                        <p class="mb-0 small">Fill in the quotation details below. If auto-filled from an assessment,
                            review before sending.</p>
                    </div>

                    <!-- Section 1: Quotation Details -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Quotation Details</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">Reference Number</label>
                                    <input type="text" class="form-control bg-light" value="QT-2026-007" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Date</label>
                                    <input type="date" class="form-control" value="2026-03-17">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Client Name *</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Service Type *</label>
                                    <select class="form-select">
                                        <option value="">Select</option>
                                        <option>CCTV Setup</option>
                                        <option>Solar Street Light</option>
                                        <option>Solar Setup</option>
                                        <option>Public Address System</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">Subject / Project Title *</label>
                                    <input type="text" class="form-control"
                                        placeholder="e.g. CCTV System Installation — Reyes Residence">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Opening Message -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Opening Message</h6>
                            <textarea class="form-control" rows="3">In response to your most valued request, A We Green Enterprise is pleased to submit our proposal for your requirement as per ACTUAL ASSESSMENT.</textarea>
                        </div>
                    </div>

                    <!-- Section 3: Line Items -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Line Items</h6>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0" id="lineItemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="w-70">QTY</th>
                                            <th class="w-90">Unit</th>
                                            <th>Description</th>
                                            <th class="w-140">Unit Price (₱)</th>
                                            <th class="w-140">Total (₱)</th>
                                            <th class="w-40"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="number" class="form-control form-control-sm" value="4"
                                                    min="1"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="pcs"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="IP Camera 4MP Outdoor"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    value="3500"></td>
                                            <td class="fw-medium align-middle">₱14,000.00</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <span class="material-symbols-outlined icon-action">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="number" class="form-control form-control-sm" value="1"
                                                    min="1"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="unit"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="8-Channel NVR Recorder"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    value="8500"></td>
                                            <td class="fw-medium align-middle">₱8,500.00</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <span class="material-symbols-outlined icon-action">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="number" class="form-control form-control-sm" value="50"
                                                    min="1"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="meters"></td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="CAT6 LAN Cable"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    value="45"></td>
                                            <td class="fw-medium align-middle">₱2,250.00</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <span class="material-symbols-outlined icon-action">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="labor-row">
                                            <td colspan="2" class="align-middle">
                                                <span class="fw-semibold small text-muted">LABOR</span>
                                            </td>
                                            <td class="align-middle small text-muted">Overall labor charge (% of subtotal)
                                            </td>
                                            <td class="align-middle">
                                                <select class="form-select form-select-sm">
                                                    <option value="">No Labor</option>
                                                    <option value="15">15%</option>
                                                    <option value="20" selected>20%</option>
                                                    <option value="25">25%</option>
                                                    <option value="30">30%</option>
                                                </select>
                                            </td>
                                            <td class="fw-medium align-middle">₱4,950.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-outline-primary mt-3 d-flex align-items-center gap-1">
                                <span class="material-symbols-outlined fs-18">add</span>
                                Add Item
                            </button>
                            <div class="d-flex flex-column align-items-end mt-4 pt-3 border-top gap-1">
                                <div class="d-flex justify-content-between totals-row small text-muted">
                                    <span>Subtotal</span>
                                    <span>₱24,750.00</span>
                                </div>
                                <div class="d-flex justify-content-between totals-row small text-muted">
                                    <span>Labor (20%)</span>
                                    <span>₱4,950.00</span>
                                </div>
                                <div class="d-flex justify-content-between totals-row mt-1 pt-2 border-top">
                                    <span class="fw-semibold me-5">Grand Total</span>
                                    <span class="h5 green-text fw-medium mb-0">₱29,700.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Terms and Conditions -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Terms and Conditions</h6>
                            <div class="bg-light rounded p-3 small text-muted">
                                <p class="mb-2">• Misuse, abuse, negligence, caused by accident or equipment tampering
                                    shall render this warranty void. The warranty does not cover any product or items
                                    damaged by abnormal, severe voltage fluctuation or main AC supply, fire, flood,
                                    lightning and all other acts of God.</p>
                                <p class="mb-2">• All supplied items are still the property of A We Green Enterprise
                                    unless full payment is received.</p>
                                <p class="mb-0">• A We Green Enterprise has the right to pull out all items supplied that
                                    do not comply with the terms and conditions.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary">Save Draft</button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-secondary">Preview PDF</button>
                        <button type="button" class="btn btn-success">Send to Client</button>
                    </div>
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
                        <h5 class="modal-title mb-0">Archived Quotations</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="archiveTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Ref No.</th>
                                    <th class="border-0 small green-text">Client</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Amount</th>
                                    <th class="border-0 small green-text">Date</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>QT-2025-089</td>
                                    <td>Carlo Mendoza</td>
                                    <td>Solar Setup</td>
                                    <td>₱210,000.00</td>
                                    <td>Nov 20, 2025</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <a href="#" class="btn btn-sm btn-outline-success action-btn"
                                            title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>QT-2025-074</td>
                                    <td>Grace Villanueva</td>
                                    <td>CCTV Setup</td>
                                    <td>₱38,500.00</td>
                                    <td>Oct 05, 2025</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <a href="#" class="btn btn-sm btn-outline-success action-btn"
                                            title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
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
        $(document).ready(function() {
            jQuery.fn.dataTable.ext.type.order['status-priority-pre'] = function(data) {
                return $(data).data('status') || 0;
            };

            $('#quotationsTable').DataTable({
                pageLength: 10,
                columnDefs: [{
                        orderable: false,
                        targets: 6
                    },
                    {
                        type: 'status-priority',
                        targets: 5
                    }
                ],
                order: [
                    [5, 'asc']
                ]
            });

            $('#archiveModal').on('shown.bs.modal', function() {
                if (!$.fn.DataTable.isDataTable('#archiveTable')) {
                    $('#archiveTable').DataTable({
                        pageLength: 5,
                        lengthChange: false,
                        info: true,
                        columnDefs: [{
                            orderable: false,
                            targets: 6
                        }]
                    });
                }
            });
        });
    </script>
@endsection
