@extends('layouts.admin')

@section('title', 'View Quotation')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/quotation/quotation.css') }}">
@endsection
@section('page-title', 'View Quotation')
@section('topbar-actions')
    <a href="{{ route('quotations') }}" class="btn btn-sm btn-outline-light fw-semibold d-flex align-items-center gap-1"><span class="material-symbols-outlined fs-17">arrow_back</span>Back to Quotations</a>
@endsection
@section('content')
<div class="container-fluid px-4 py-4"><div class="quotation-form-wrap mx-auto">
    @if ($quotation->status === 'Rejected')
        <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
            <span class="material-symbols-outlined fs-18">rate_review</span>
            <div class="small">
                <p class="mb-1"><strong>The client requested changes</strong> to this quotation
                    @if ($quotation->revision_requested_at)
                        on {{ $quotation->revision_requested_at->format('F j, Y') }}
                    @endif
                    .</p>
                @if ($quotation->revision_reason_category)
                    <p class="mb-1"><strong>Reason:</strong> {{ $quotation->revision_reason_category }}</p>
                @endif
                @if ($quotation->revision_reason)
                    <p class="mb-1"><strong>Details:</strong> {{ $quotation->revision_reason }}</p>
                @endif
                <p class="mb-0">Adjust the linked assessment form to update the materials/quantities — saving it will
                    regenerate and resend this quotation to the client.</p>
            </div>
        </div>
    @elseif ($quotation->status === 'Approved' && $quotation->project)
        <div class="alert alert-success d-flex align-items-start gap-2 mb-4">
            <span class="material-symbols-outlined fs-18">check_circle</span>
            <p class="mb-0 small">The client approved this quotation and the contract has been confirmed.
                <a href="{{ route('projects.show', $quotation->project) }}" class="fw-semibold">View Project {{ $quotation->project->reference_number }}</a>.
            </p>
        </div>
    @elseif ($quotation->status === 'Approved')
        <div class="alert alert-success d-flex align-items-start gap-2 mb-4"><span
                class="material-symbols-outlined fs-18">check_circle</span><p class="mb-0 small">The client approved
                this quotation. Upload the signed contract below to start the project.</p></div>
    @else
        <div class="alert alert-success d-flex align-items-start gap-2 mb-4"><span
                class="material-symbols-outlined fs-18">info</span><p class="mb-0 small">This quotation was generated
                from the completed assessment form and sent to the client.</p></div>
    @endif
    <div class="card mb-4"><div class="card-body"><h6 class="fw-semibold mb-3">Quotation Details</h6><div class="row g-3">
        <div class="col-md-6"><label class="form-label small">Reference Number</label><input type="text" class="form-control bg-light" value="{{ $quotation->reference_number }}" readonly></div>
        <div class="col-md-6"><label class="form-label small">Date</label><input type="date" class="form-control bg-light" value="{{ $quotation->sent_at?->format('Y-m-d') }}" readonly></div>
        <div class="col-md-6"><label class="form-label small">Client Name</label><input type="text" class="form-control bg-light" value="{{ $quotation->assessment->client->user->full_name }}" readonly></div>
        <div class="col-md-6"><label class="form-label small">Service Type</label><input type="text" class="form-control bg-light" value="{{ $quotation->service_type }}" readonly></div>
        <div class="col-12"><label class="form-label small">Subject / Project Title</label><input type="text" class="form-control bg-light" value="{{ $quotation->project_title }}" readonly></div>
    </div></div></div>
    <div class="card mb-4"><div class="card-body"><h6 class="fw-semibold mb-3">Opening Message</h6><textarea class="form-control bg-light" rows="3" readonly>In response to your most valued request, A We Green Enterprise is pleased to submit our proposal for your requirement as per ACTUAL ASSESSMENT.</textarea></div></div>
    <div class="card mb-4"><div class="card-body"><h6 class="fw-semibold mb-3">Line Items</h6><div class="table-responsive"><table class="table table-sm mb-0" id="lineItemsTable"><thead class="table-light"><tr><th class="w-70 text-end">QTY</th><th class="w-90">Unit</th><th>Description</th><th class="w-145 text-end">Price (₱)</th><th class="w-145 text-end">Total (₱)</th></tr></thead><tbody>
        @foreach($quotation->items as $item)<tr><td class="text-end"><input type="number" class="form-control form-control-sm bg-light text-end" value="{{ $item->quantity }}" readonly></td><td><input type="text" class="form-control form-control-sm bg-light" value="{{ $item->unit }}" readonly></td><td><input type="text" class="form-control form-control-sm bg-light" value="{{ $item->description }}" readonly></td><td class="text-end"><input type="number" class="form-control form-control-sm bg-light text-end" value="{{ $item->unit_price }}" readonly></td><td class="fw-medium align-middle text-end">₱{{ number_format($item->line_total, 2) }}</td></tr>@endforeach
        <tr class="labor-row"><td class="text-end"><input type="number" class="form-control form-control-sm bg-light text-end" value="1" readonly></td><td><input type="text" class="form-control form-control-sm bg-light" value="lot" readonly></td><td><input type="text" class="form-control form-control-sm bg-light" value="Installation, Testing and Maintenance — with ONE (1) YEAR FULL WARRANTY" readonly></td><td class="text-end"><input type="number" class="form-control form-control-sm bg-light text-end" value="{{ $quotation->labor_total }}" readonly></td><td class="fw-medium align-middle text-end">₱{{ number_format($quotation->labor_total, 2) }}</td></tr>
    </tbody><tfoot><tr><td colspan="5" class="text-center p-1"><p class="quote-inclusion-note mb-0">Quoted Price with <span class="fw-bold">VALUE ADDED TAX</span> Inclusion</p></td></tr><tr class="grand-total-row"><td colspan="4" class="text-center"><span class="fw-bold text-center ps-5">ONE (1) YEAR FULL WARRANTY</span></td><td class="fw-bold text-end">₱{{ number_format($quotation->grand_total, 2) }}</td></tr></tfoot></table></div></div></div>
    @if ($quotation->status === 'Approved' && ! $quotation->project)
        <div class="card mb-4 border-success">
            <div class="card-body">
                <h6 class="fw-semibold mb-2 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined fs-18 text-success">upload_file</span>
                    Upload &amp; Confirm Contract
                </h6>
                <p class="small text-muted mb-3">A project cannot be created until the signed contract is uploaded and
                    confirmed. This will start the project immediately.</p>
                @if ($errors->any())
                    <p class="small text-danger mb-2">{{ $errors->first() }}</p>
                @endif
                <form method="POST" action="{{ route('quotations.upload-contract', $quotation) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small">Contract File <span class="text-danger">*</span></label>
                            <input type="file" name="contract" accept=".pdf,.jpg,.jpeg,.png" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Project Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->toDateString()) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Target End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-1">
                                <span class="material-symbols-outlined fs-18">check_circle</span>
                                Confirm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div class="card mb-4"><div class="card-body"><h6 class="fw-semibold mb-3">Terms and Conditions</h6><div class="bg-light rounded p-3 small text-muted"><p class="mb-2">• Misuse, abuse, negligence, caused by accident or equipment tampering shall render this warranty void. The warranty does not cover any product or items damaged by abnormal, severe voltage fluctuation or main AC supply, fire, flood, lightning and all other acts of God.</p><p class="mb-2">• All supplied items are still the property of A We Green Enterprise unless full payment is received.</p><p class="mb-0">• A We Green Enterprise has the right to pull out all items supplied that do not comply with the terms and conditions.</p></div></div></div>
    <div class="d-flex justify-content-between align-items-center pb-5"><a href="{{ route('assessments.form.edit', $quotation->assessment) }}" class="btn {{ $quotation->status === 'Rejected' ? 'btn-warning' : 'btn-outline-secondary' }}">{{ $quotation->status === 'Rejected' ? 'Update Assessment Form' : 'View Assessment' }}</a><div class="d-flex gap-2"><a target="_blank" href="{{ route('quotations.print', $quotation) }}" class="btn btn-outline-secondary">Preview PDF</a><button type="button" class="btn
        @if ($quotation->status === 'Approved') btn-success
        @elseif ($quotation->status === 'Rejected') btn-danger
        @else btn-primary
        @endif" disabled>{{ $quotation->status === 'Sent' ? 'Sent to Client' : $quotation->status }}</button></div></div>
</div></div>
@endsection
