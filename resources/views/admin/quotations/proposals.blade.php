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
                                    <th class="w-145 text-end">Price (₱)</th>
                                    <th class="w-145 text-end">Total (₱)</th>
                                    <th class="w-40"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Camera --}}
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end" value="6"
                                            min="1">
                                    </td>
                                    <td>
                                        <div class="item-unit-cell">
                                            <div class="item-thumb-wrap">
                                                <img src="{{ asset('css/images/materials/ip-camera.jpg') }}"
                                                    alt="CCTV Camera" class="item-thumb"
                                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="item-thumb-fallback" style="display:none;">
                                                    <span class="material-symbols-outlined">image_not_supported</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="CCTV System using Ultra HD DVR with Cloud and HD Camera — 2.8mm 3K 40mtrs IR Camera (Plastic) All Weather Condition, Hikvision Colorvu Colored Night">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="3385" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱20,310.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                {{-- NVR/DVR --}}
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end" value="1"
                                            min="1">
                                    </td>
                                    <td>
                                        <div class="item-unit-cell">
                                            <div class="item-thumb-wrap">
                                                <img src="{{ asset('css/images/materials/nvr-8ch.jpg') }}"
                                                    alt="Digital Video Recorder" class="item-thumb"
                                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="item-thumb-fallback" style="display:none;">
                                                    <span class="material-symbols-outlined">image_not_supported</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="16 Channel 8K Ultra HD Digital Video Recorder — Hikvision AcuSense Technology">
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm bg-light text-end pe-none"
                                            value="18890" readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱18,890.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                {{-- HDD --}}
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="1" min="1">
                                    </td>
                                    <td>
                                        <div class="item-unit-cell">
                                            <div class="item-thumb-wrap">
                                                <img src="{{ asset('css/images/materials/hdd-2tb.jpg') }}"
                                                    alt="Hard Disc Drive" class="item-thumb"
                                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="item-thumb-fallback" style="display:none;">
                                                    <span class="material-symbols-outlined">image_not_supported</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="Hard Disc Drive 2TB">
                                    </td>
                                    <td class="text-end">
                                        <input type="number"
                                            class="form-control form-control-sm bg-light text-end pe-none" value="9975"
                                            readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱9,975.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                {{-- Cable (bundle, with photo — matches Camera/NVR/HDD rows) --}}
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="1.5" min="0" step="0.1">
                                    </td>
                                    <td>
                                        <div class="item-unit-cell">
                                            <div class="item-thumb-wrap">
                                                <img src="{{ asset('css/images/materials/cat6-cable.jpg') }}"
                                                    alt="Cat6 Outdoor Cable" class="item-thumb"
                                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="item-thumb-fallback" style="display:none;">
                                                    <span class="material-symbols-outlined">image_not_supported</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="Cat6 Outdoor PureCopper Cables">
                                    </td>
                                    <td class="text-end">
                                        <input type="number"
                                            class="form-control form-control-sm bg-light text-end pe-none" value="14650"
                                            readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱21,975.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                {{-- Connectors/power supply (bundle, no photo) --}}
                                <tr>
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="6" min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="bundle">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="DC Connectors, Video Balun, Big White Power Supply Box">
                                    </td>
                                    <td class="text-end">
                                        <input type="number"
                                            class="form-control form-control-sm bg-light text-end pe-none" value="975"
                                            readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱5,850.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                {{-- Grouped accessories (lot, no photo) --}}
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
                                            value="Accessories — stainless strap band, buckles, ties, 4-gang outlet, power cable, moldings, and other electrical supplies such as tape and clip">
                                    </td>
                                    <td class="text-end">
                                        <input type="number"
                                            class="form-control form-control-sm bg-light text-end pe-none" value="3500"
                                            readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱3,500.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                                {{-- Labor / Installation --}}
                                <tr class="labor-row">
                                    <td class="text-end">
                                        <input type="number" class="form-control form-control-sm text-end"
                                            value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="lot">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            value="Installation, Testing and Maintenance — with ONE (1) YEAR FULL WARRANTY">
                                    </td>
                                    <td class="text-end">
                                        <input type="number"
                                            class="form-control form-control-sm bg-light text-end pe-none" value="24150"
                                            readonly>
                                    </td>
                                    <td class="fw-medium align-middle text-end">₱24,150.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <span class="material-symbols-outlined icon-action">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-center p-1">
                                        <p class="quote-inclusion-note mb-0">
                                            Quoted Price with <span class="fw-bold">VALUE ADDED TAX</span> Inclusion
                                        </p>
                                    </td>
                                </tr>
                                <tr class="grand-total-row">
                                    <td colspan="4" class="text-center"><span class="fw-bold text-center ps-5">ONE (1)
                                            YEAR FULL WARRANTY</span></td>
                                    <td class="fw-bold text-end">₱104,650.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button class="btn btn-sm btn-outline-success mt-3 d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-18">add</span>
                        Add Item
                    </button>
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