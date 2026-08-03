@extends('layouts.admin')

@section('title', 'View Quotation')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/quotation/quotation.css') }}">
@endsection

@section('page-title', 'View Quotation')

@section('topbar-actions')
    <a href="{{ route('quotations') }}" class="btn btn-sm btn-outline-light fw-semibold d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Quotations
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">
        <div class="quotation-form-wrap mx-auto">

            <!-- Info Banner -->
            <div class="alert alert-success d-flex align-items-start gap-2 mb-4">
                <span class="material-symbols-outlined fs-18">info</span>
                <p class="mb-0 small">Review the quotation details below before sending to the client.</p>
            </div>

            <!-- Section 1: Quotation Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Quotation Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">Reference Number</label>
                            <input type="text" class="form-control bg-light" value="QT-2026-001" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Date</label>
                            <input type="date" class="form-control" value="2026-03-10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Client Name *</label>
                            <input type="text" class="form-control" value="Maria Santos">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Service Type *</label>
                            <select class="form-select">
                                <option selected>CCTV Setup</option>
                                <option>Solar Street Light</option>
                                <option>Solar Setup</option>
                                <option>Public Address System</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Subject / Project Title *</label>
                            <input type="text" class="form-control" value="CCTV System Installation — Santos Residence">
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
                                    <th class="w-70 text-end">QTY</th>
                                    <th class="w-90">Unit</th>
                                    <th>Description</th>
                                    <th class="w-145 text-end">Unit Price (₱)</th>
                                    <th class="w-145 text-end">Total (₱)</th>
                                    <th class="w-40"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end" value="4"
                                            min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="pcs">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="IP Camera 4MP Outdoor">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="3500" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱14,000.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end" value="1"
                                            min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="unit">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="8-Channel NVR Recorder">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="8500" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱8,500.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end" value="50"
                                            min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="meters">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="CAT6 LAN Cable">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="45" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱2,250.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="unit">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="2TB HDD Storage">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="3800" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱3,800.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="4" min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="pcs">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="Camera Mounting Bracket">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="250" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱1,000.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="lot">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="Conduit Pipe and Accessories">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="2500" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱2,500.00</td>
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
                                    <td class="align-middle small text-muted">Overall labor charge (% of subtotal)</td>
                                    <td class="text-end">
                                        <input type="text" class="form-control form-control-sm bg-light text-end pe-3 pe-none"
                                            value="20%" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱6,410.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button class="btn btn-sm btn-outline-success mt-3 d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-18">add</span>
                        Add Item
                    </button>

                    <!-- Totals -->
                    <div class="d-flex flex-column align-items-end mt-4 pt-3 border-top gap-1">
                        <div class="d-flex justify-content-between totals-row small text-muted">
                            <span>Subtotal</span>
                            <span>₱32,050.00</span>
                        </div>
                        <div class="d-flex justify-content-between totals-row small text-muted">
                            <span>Labor (20%)</span>
                            <span>₱6,410.00</span>
                        </div>
                        <div class="d-flex justify-content-between totals-row mt-1 pt-2 border-top">
                            <span class="fw-semibold">Grand Total</span>
                            <span class="h5 green-text fw-semibold mb-0">₱38,460.00</span>
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
                            render this warranty void. The warranty does not cover any product or items damaged by abnormal,
                            severe voltage fluctuation or main AC supply, fire, flood, lightning and all other acts of God.
                        </p>
                        <p class="mb-2">• All supplied items are still the property of A We Green Enterprise unless full
                            payment is received.</p>
                        <p class="mb-0">• A We Green Enterprise has the right to pull out all items supplied that do not
                            comply with the terms and conditions.</p>
                    </div>
                </div>
            </div>

            <!-- Page Footer Actions -->
            <div class="d-flex justify-content-between align-items-center pb-5">
                <button type="button" class="btn btn-outline-secondary">Save Draft</button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary">Preview PDF</button>
                    <button type="button" class="btn btn-success">Send to Client</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
@endsection
