@extends('layouts.client')

@section('title', 'View Quotation')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/quotation.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Quotation {{ $quotation->reference_number }}</h2>
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
                    <a href="{{ route('client-assessment.show', $quotation->assessment) }}"
                        class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                        View Assessment Details
                    </a>
                </div>

                <!-- Info Banner -->
                @if ($quotation->status === 'Approved')
                    <div class="alert alert-success d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined fs-18">check_circle</span>
                        <p class="mb-0 small">You approved this quotation. Our team will reach out to schedule the next
                            steps.</p>
                    </div>
                @elseif ($quotation->status === 'Rejected')
                    <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined fs-18">cancel</span>
                        <p class="mb-0 small">You requested changes to this quotation. Our team will follow up with a
                            revised quote.</p>
                    </div>
                @else
                    <div class="alert alert-warning d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined fs-18">info</span>
                        <p class="mb-0 small">This quotation is awaiting your review. Approve to proceed, or reject with a
                            reason if changes are needed.</p>
                    </div>
                @endif

                <!-- Section 1: Quotation Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="fw-semibold mb-0">Quotation Details</h6>
                            <span class="badge rounded-pill fs-11
                                @if ($quotation->status === 'Approved') bg-success
                                @elseif ($quotation->status === 'Rejected') bg-danger
                                @else bg-warning text-dark
                                @endif">{{ $quotation->status === 'Sent' ? 'Pending Review' : $quotation->status }}</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small">Reference Number</label>
                                <input type="text" class="form-control bg-light" value="{{ $quotation->reference_number }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Date</label>
                                <input type="text" class="form-control bg-light" value="{{ $quotation->sent_at?->format('F j, Y') }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Service Type</label>
                                <input type="text" class="form-control bg-light" value="{{ $quotation->service_type }}" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Subject / Project Title</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $quotation->project_title }}" readonly>
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
                                        <th class="w-145 text-end">Price (₱)</th>
                                        <th class="w-145 text-end">Total (₱)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotation->items as $item)
                                        <tr>
                                            <td class="text-end"><input type="text" class="form-control form-control-sm bg-light text-end" value="{{ rtrim(rtrim($item->quantity, '0'), '.') }}" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm bg-light" value="{{ $item->unit }}" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm bg-light" value="{{ $item->description }}" readonly></td>
                                            <td class="text-end"><input type="text" class="form-control form-control-sm bg-light text-end" value="{{ number_format($item->unit_price, 2) }}" readonly></td>
                                            <td class="fw-medium align-middle text-end">₱{{ number_format($item->line_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="labor-row">
                                        <td class="text-end"><input type="text" class="form-control form-control-sm bg-light text-end" value="1" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm bg-light" value="lot" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm bg-light" value="Installation, Testing and Maintenance — with ONE (1) YEAR FULL WARRANTY" readonly></td>
                                        <td class="text-end"><input type="text" class="form-control form-control-sm bg-light text-end" value="{{ number_format($quotation->labor_total, 2) }}" readonly></td>
                                        <td class="fw-medium align-middle text-end">₱{{ number_format($quotation->labor_total, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-center p-1">
                                            <p class="quote-inclusion-note mb-0">Quoted Price with <span class="fw-bold">VALUE ADDED TAX</span> Inclusion</p>
                                        </td>
                                    </tr>
                                    <tr class="grand-total-row">
                                        <td colspan="4" class="text-center"><span class="fw-bold text-center ps-5">ONE (1) YEAR FULL WARRANTY</span></td>
                                        <td class="fw-bold text-end">₱{{ number_format($quotation->grand_total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
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
                    <a target="_blank" href="{{ route('client-quotation.print', $quotation) }}"
                        class="btn btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-18">download</span>
                        Download PDF
                    </a>
                    @if ($quotation->status === 'Sent')
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#rejectQuotationModal">
                                Reject
                            </button>
                            <button type="button" class="btn btn-success">
                                Approve Quotation
                            </button>
                        </div>
                    @endif
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
