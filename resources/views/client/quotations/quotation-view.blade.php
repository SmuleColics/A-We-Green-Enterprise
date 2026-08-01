@extends('layouts.client')

@section('title', 'View Quotation')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/quotation.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Quotation QT-2026-002</h2>
            <p>Review the details below and let us know how you'd like to proceed.</p>
        </div>

        <div class="main-content">
            <div class="quotation-view-wrap">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('client-quotation') }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-15">arrow_back</span>
                        Back to Quotations
                    </a>
                    {{-- Only shown if this quotation originated from an assessment request --}}
                    <a href="{{ route('assessment-form') }}#history-view"
                        class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                        View Assessment Details
                    </a>
                </div>

                <!-- Info Banner -->
                <div class="alert alert-warning d-flex align-items-start gap-2 mb-4">
                    <span class="material-symbols-outlined fs-18">info</span>
                    <p class="mb-0 small">This quotation is awaiting your review. Approve to proceed, or reject with a
                        reason if changes are needed.</p>
                </div>

                <!-- Section 1: Quotation Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="fw-semibold mb-0">Quotation Details</h6>
                            <span class="badge bg-warning text-dark rounded-pill fs-11">Pending Review</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small">Reference Number</label>
                                <input type="text" class="form-control bg-light" value="QT-2026-002" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Date</label>
                                <input type="text" class="form-control bg-light" value="March 11, 2026" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Service Type</label>
                                <input type="text" class="form-control bg-light" value="Solar Setup" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Subject / Project Title</label>
                                <input type="text" class="form-control bg-light"
                                    value="Solar Panel Installation — Reyes Residence" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Opening Message -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Message</h6>
                        <textarea class="form-control bg-light" rows="3" readonly>In response to your most valued request, A We Green Enterprise is pleased to submit our proposal for your requirement as per ACTUAL ASSESSMENT.</textarea>
                    </div>
                </div>

                <!-- Section 3: Line Items (read-only) -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Line Items</h6>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" id="lineItemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="w-70 text-end">QTY</th>
                                        <th class="w-90">Unit</th>
                                        <th>Description</th>
                                        <th class="w-145 text-end">Unit Price (₱)</th>
                                        <th class="w-145 text-end">Total (₱)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-end">10</td>
                                        <td>pcs</td>
                                        <td>Solar Panel 400W Monocrystalline</td>
                                        <td class="text-end">₱9,500.00</td>
                                        <td class="fw-medium text-end">₱95,000.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end">1</td>
                                        <td>unit</td>
                                        <td>5kW Hybrid Inverter</td>
                                        <td class="text-end">₱18,000.00</td>
                                        <td class="fw-medium text-end">₱18,000.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end">1</td>
                                        <td>lot</td>
                                        <td>Mounting Structure and Accessories</td>
                                        <td class="text-end">₱7,000.00</td>
                                        <td class="fw-medium text-end">₱7,000.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="labor-row">
                                        <td colspan="2" class="align-middle">
                                            <span class="fw-semibold small text-muted text-center">LABOR</span>
                                        </td>
                                        <td class="align-middle small text-muted">Overall labor charge</td>
                                        <td class="text-end small text-muted">20%</td>
                                        <td class="fw-medium text-end">₱24,000.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex flex-column align-items-end mt-4 pt-3 border-top gap-1">
                            <div class="d-flex justify-content-between totals-row small text-muted">
                                <span>Subtotal</span>
                                <span>₱120,000.00</span>
                            </div>
                            <div class="d-flex justify-content-between totals-row small text-muted">
                                <span>Labor (20%)</span>
                                <span>₱24,000.00</span>
                            </div>
                            <div class="d-flex justify-content-between totals-row mt-1 pt-2 border-top">
                                <span class="fw-semibold">Grand Total</span>
                                <span class="h5 green-text fw-semibold mb-0">₱144,000.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Terms and Conditions -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Terms and Conditions</h6>
                        <div class="bg-light rounded p-3 small text-muted">
                            <p class="mb-2">• Misuse, abuse, negligence, caused by accident or equipment tampering shall
                                render this warranty void. The warranty does not cover any product or items damaged by
                                abnormal, severe voltage fluctuation or main AC supply, fire, flood, lightning and all other
                                acts of God.</p>
                            <p class="mb-2">• All supplied items are still the property of A We Green Enterprise unless
                                full payment is received.</p>
                            <p class="mb-0">• A We Green Enterprise has the right to pull out all items supplied that do
                                not comply with the terms and conditions.</p>
                        </div>
                    </div>
                </div>

                <!-- Client Actions -->
                <div class="d-flex justify-content-between align-items-center pb-5">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-18">download</span>
                        Download PDF
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#rejectQuotationModal">
                            Reject
                        </button>
                        <button type="button" class="btn btn-success">
                            Approve Quotation
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Reject / Request Changes Modal -->
    <div class="modal fade" id="rejectQuotationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title d-flex align-items-center gap-2 text-danger">
                        <span class="material-symbols-outlined fs-18">rate_review</span>
                        Request Changes
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-3">Let us know what you'd like adjusted, and our team will send a revised quotation.</p>
                    <label class="form-label small fw-semibold text-muted mb-2 d-block">Reason / Requested Changes <span
                            class="text-danger">*</span></label>
                    <textarea class="form-control" rows="4"
                        placeholder="e.g. Please revise the quantity of solar panels to 8 units..."></textarea>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm px-4">Submit Request</button>
                </div>
            </div>
        </div>
    </div>

@endsection
