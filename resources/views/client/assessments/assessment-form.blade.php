@extends('layouts.client')

@section('title', 'Assessment Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/assessment.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Assessment Details</h2>
            <p>Ref: ASM-2026-001 · This is the basis for your quotation.</p>
        </div>

        <div class="main-content">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('client-assessment') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-15">arrow_back</span>
                    Back to Assessment
                </a>
                <a href="{{ route('quotation-view', 'QT-2026-002') }}" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-15">receipt_long</span>
                    View Related Quotation
                </a>
            </div>

            <!-- Info Banner -->
            <div class="alert alert-info d-flex align-items-start gap-2 mb-4">
                <span class="material-symbols-outlined fs-18">info</span>
                <p class="mb-0 small">This is a summary of what our team assessed on-site. Quantities and items listed here form the basis of your quotation.</p>
            </div>

            <!-- Assessment Header Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Project Type</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="CCTV Installation" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Location</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="Bacoor, Cavite" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Contact Person</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="Maria Santos" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Assessment Date</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="March 15, 2026" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials Table (read-only) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3 green-text">ASSESSMENT SUMMARY</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="materialsTable">
                            <thead class="table-success">
                                <tr>
                                    <th class="wp-40">ITEM</th>
                                    <th class="wp-15">QUANTITY</th>
                                    <th class="wp-20">UNIT</th>
                                    <th class="wp-25">LOCATION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IP Camera 2MP Outdoor</td>
                                    <td>8</td>
                                    <td>pcs</td>
                                    <td>Front, Back, Sides</td>
                                </tr>
                                <tr>
                                    <td>8-Channel NVR with 2TB HDD</td>
                                    <td>1</td>
                                    <td>pcs</td>
                                    <td>Main Office</td>
                                </tr>
                                <tr>
                                    <td>Cat6 UTP Cable</td>
                                    <td>1</td>
                                    <td>roll</td>
                                    <td>Throughout property</td>
                                </tr>
                                <tr>
                                    <td>DC Connector</td>
                                    <td>8</td>
                                    <td>pcs</td>
                                    <td>Each camera</td>
                                </tr>
                                <tr>
                                    <td>Video Balun</td>
                                    <td>2</td>
                                    <td>pair</td>
                                    <td>Each camera</td>
                                </tr>
                                <tr>
                                    <td>Cable clips & fasteners</td>
                                    <td>1</td>
                                    <td>lot</td>
                                    <td>Cable routing</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Assessment Notes -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Assessor's Notes</h6>
                    <textarea class="form-control bg-light" rows="4" readonly>Client needs outdoor cameras with night vision capability. Existing wiring can be reused for 4 of the 8 planned camera locations, reducing installation time.</textarea>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
@endsection