@extends('layouts.admin')
@section('title', 'Assessment Form')
@section('styles') <link rel="stylesheet" href="{{ asset('css/admin/assessments/form.css') }}"> @endsection
@section('page-title', 'Assessment Form')
@section('topbar-actions')
    <a href="{{ route('employee.assessments') }}" class="btn btn-sm btn-outline-light">Back to Assessment</a>
@endsection
@section('content')
<div class="container-fluid px-4 py-4">

    <p class="text-muted small mb-4">Assessment #{{ $assessment->id }} — {{ $assessment->client->user->full_name }}</p>

    @if ($assessment->quotation && $assessment->quotation->status === 'Rejected')
        <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
            <span class="material-symbols-outlined fs-18">rate_review</span>
            <div class="small">
                <p class="mb-1"><strong>The client requested changes to this quotation</strong>
                    @if ($assessment->quotation->revision_requested_at)
                        on {{ $assessment->quotation->revision_requested_at->format('F j, Y') }}
                    @endif
                    .</p>
                @if ($assessment->quotation->revision_reason_category)
                    <p class="mb-1"><strong>Reason:</strong> {{ $assessment->quotation->revision_reason_category }}</p>
                @endif
                @if ($assessment->quotation->revision_reason)
                    <p class="mb-0"><strong>Details:</strong> {{ $assessment->quotation->revision_reason }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="small text-muted">Service(s)</label>
                    <input class="form-control form-control-sm bg-light" value="{{ implode(', ', $assessment->services) }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Location</label>
                    <input class="form-control form-control-sm bg-light" value="{{ $assessment->client->city }}, {{ $assessment->client->province }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Contact Person</label>
                    <input class="form-control form-control-sm bg-light" value="{{ $assessment->client->user->full_name }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Contact Number</label>
                    <input class="form-control form-control-sm bg-light" value="{{ $assessment->client->user->contact_number }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-semibold mb-2 green-text">ASSESSMENT FORM</h6>

            @if ($assessment->items->isEmpty())
                <p class="text-muted small mb-0">No items have been logged for this assessment yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>ITEM</th>
                                <th>QUANTITY</th>
                                <th>UNIT</th>
                                <th>LOCATION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessment->items as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->location ?: '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-semibold">Assessment Notes</h6>
            <p class="mb-0">{{ $assessment->assessment_notes ?: '—' }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a target="_blank" href="{{ route('employee.assessments.form.print', $assessment) }}" class="btn btn-outline-secondary">Print / Preview PDF</a>
    </div>

</div>
@endsection
@section('scripts')
<style>@media print {.sidebar,.topbar,.btn{display:none!important}.card{box-shadow:none!important;border:0!important}}</style>
@endsection
