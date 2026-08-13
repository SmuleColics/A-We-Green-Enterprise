@extends('layouts.client')

@section('title', 'Assessment Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/assessment.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Assessment #{{ $assessment->id }}</h2>
            <p>Details of your site assessment and findings.</p>
        </div>

        <div class="main-content">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('client-assessment', ['tab' => 'history']) }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-15">arrow_back</span>
                    Back to Assessments
                </a>
                <div class="d-flex gap-2">
                    @if ($assessment->assessment_form_completed_at)
                        <a target="_blank" href="{{ route('client-assessment.print', $assessment) }}"
                            class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-15">download</span>
                            Download PDF
                        </a>
                    @endif
                    @if ($assessment->quotation)
                        <a href="{{ route('quotation-view', $assessment->quotation) }}"
                            class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                            View Quotation
                        </a>
                    @endif
                </div>
            </div>

            @php
                $statusBadge = [
                    'Pending' => 'warning text-dark',
                    'Confirmed' => 'success',
                    'Declined' => 'danger',
                    'Cancelled' => 'secondary',
                ];
                $badge = $statusBadge[$assessment->status] ?? 'secondary';
            @endphp

            <!-- Section 1: Schedule & Service Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="fw-semibold mb-0">Schedule Info</h6>
                        <span class="badge bg-{{ $badge }} rounded-pill fs-11">{{ $assessment->status }}</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="small text-muted">Service(s)</label>
                            <input class="form-control form-control-sm bg-light" value="{{ implode(', ', $assessment->services ?? []) }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted">Location</label>
                            <input class="form-control form-control-sm bg-light" value="{{ $assessment->client->city }}, {{ $assessment->client->province }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted">Date</label>
                            <input class="form-control form-control-sm bg-light" value="{{ $assessment->preferred_date?->format('F j, Y') }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted">Time Slot</label>
                            <input class="form-control form-control-sm bg-light" value="{{ $assessment->time_slot }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            @if ($assessment->assessment_form_completed_at)
                <!-- Section 2: Assessment Findings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-2 green-text">ASSESSMENT FORM</h6>
                        <p class="small text-muted">Items identified by our team during the on-site assessment.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
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
                                            <td>{{ rtrim(rtrim($item->quantity, '0'), '.') }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>{{ $item->location }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($assessment->assessment_notes)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold">Assessment Notes</h6>
                            <textarea class="form-control bg-light" rows="3" readonly>{{ $assessment->assessment_notes }}</textarea>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-info d-flex align-items-start gap-2 mb-4">
                    <span class="material-symbols-outlined fs-18">info</span>
                    <p class="mb-0 small">Our team hasn't completed the on-site assessment yet. Findings and
                        recommendations will appear here once it's done.</p>
                </div>
            @endif

        </div>
    </div>

@endsection
