@extends('layouts.client')

@section('title', 'Request Assessment')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/assessment.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Request an Assessment</h2>
            <p>Book a site visit with our team in just a few steps.</p>
        </div>

        <div class="main-content">

            <div class="d-flex align-items-center mb-3 mt-4" style="margin-top:-1rem;">
                <ul class="nav nav-tabs border-0" id="mainTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if (!request('tab')) active @endif" id="book-tab"
                            data-bs-toggle="tab" data-bs-target="#book-view" type="button">
                            Book Assessment
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if (request('tab') === 'history') active @endif" id="history-tab"
                            data-bs-toggle="tab" data-bs-target="#history-view" type="button">
                            My Requests
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">

                <!-- TAB 1: BOOK ASSESSMENT -->
                <div class="tab-pane fade @if (!request('tab')) show active @endif" id="book-view"
                    role="tabpanel">

                    <div class="step-wizard">
                        <div class="step-item">
                            <div class="step-circle active" id="sc1"><span>1</span></div>
                            <div class="step-label active" id="sl1">Who Are You</div>
                        </div>
                        <div class="step-line" id="sline1"></div>
                        <div class="step-item">
                            <div class="step-circle" id="sc2"><span>2</span></div>
                            <div class="step-label" id="sl2">Pick a Date</div>
                        </div>
                        <div class="step-line" id="sline2"></div>
                        <div class="step-item">
                            <div class="step-circle" id="sc3"><span>3</span></div>
                            <div class="step-label" id="sl3">Service</div>
                        </div>
                        <div class="step-line" id="sline3"></div>
                        <div class="step-item">
                            <div class="step-circle" id="sc4"><span>4</span></div>
                            <div class="step-label" id="sl4">Your Details</div>
                        </div>
                        <div class="step-line" id="sline4"></div>
                        <div class="step-item">
                            <div class="step-circle" id="sc5"><span>5</span></div>
                            <div class="step-label" id="sl5">Review</div>
                        </div>
                    </div>


                    <!-- STEP 1: Who Are You -->
                    <div class="step-pane active" id="pane1">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-1">Who are you?</h5>
                                <p class="text-muted small mb-4">This helps us check the right schedule availability for
                                    your assessment.</p>

                                <span class="section-label">Client Type</span>
                                <div class="row g-3 mb-4">
                                    <div class="col-6 col-md-4">
                                        <div class="type-card" onclick="selectClientType(this,'Residential')">
                                            <span class="material-symbols-outlined">home</span>
                                            <h6>Residential</h6>
                                            <p>Individual homeowner</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="type-card" onclick="selectClientType(this,'Subdivision')">
                                            <span class="material-symbols-outlined">holiday_village</span>
                                            <h6>Subdivision / HOA</h6>
                                            <p>Gated community or homeowners association</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="type-card" onclick="selectClientType(this,'Commercial')">
                                            <span class="material-symbols-outlined">business</span>
                                            <h6>Commercial</h6>
                                            <p>Business or company</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="type-card" onclick="selectClientType(this,'Government')">
                                            <span class="material-symbols-outlined">account_balance</span>
                                            <h6>Government / LGU</h6>
                                            <p>Barangay, school, government office</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="type-card" onclick="selectClientType(this,'Agricultural')">
                                            <span class="material-symbols-outlined">agriculture</span>
                                            <h6>Agricultural</h6>
                                            <p>Farm, poultry, or aquaculture site</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="type-card" onclick="selectClientType(this,'Institutional')">
                                            <span class="material-symbols-outlined">diversity_3</span>
                                            <h6>Institutional</h6>
                                            <p>Church, NGO, or cooperative</p>
                                        </div>
                                    </div>
                                </div>

                                <span class="section-label">Establishment Type</span>
                                <div class="row g-2 mb-4" id="estab-options">
                                    <div class="col-12 text-muted small fst-italic">Please select a client type first.</div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="goStep(2)">
                                        Next <span class="material-symbols-outlined fs-15">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Pick a Date -->
                    <div class="step-pane" id="pane2">
                        <div class="calendar-container">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="fw-semibold mb-0" id="calendar-month-label">—</h5>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-light border" onclick="changeMonth(-1)">
                                        <span class="material-symbols-outlined fs-18">chevron_left</span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light border" onclick="changeMonth(1)">
                                        <span class="material-symbols-outlined fs-18">chevron_right</span>
                                    </button>
                                </div>
                            </div>

                            <div class="full-calendar-grid" id="full-calendar-grid">
                                <!-- entirely rendered by JS: header row + day cells -->
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-3 pt-2" style="font-size:.75rem; color:#555;">
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#fff;border:1px solid #dee2e6;"></div>
                                    Available
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#e0f7fa;"></div> Partially Booked
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#f0f0f0;border:1px solid #dee2e6;"></div>
                                    Fully Booked
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#f8f9fa;border:1px solid #dee2e6;"></div>
                                    Not Available
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:var(--awg-primary);"></div> Today
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1"
                                    onclick="goStep(1)">
                                    <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                </button>
                                <p class="text-muted small mb-0 fst-italic" id="selected-date-label">No date selected yet.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Service & Schedule -->
                    <div class="step-pane" id="pane3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-1">Service & Schedule</h5>
                                <p class="text-muted small mb-4">Select one or more services you need and your preferred
                                    time slot.</p>

                                <span class="section-label">Service Type <span class="text-muted fw-normal"
                                        style="text-transform:none;letter-spacing:0;font-size:.7rem;">(you may select
                                        multiple)</span></span>
                                <div class="row g-3 mb-3">
                                    <div class="col-6 col-md-3">
                                        <div class="service-card" onclick="toggleService(this,'CCTV Setup')">
                                            <div class="service-check">✓</div>
                                            <span class="material-symbols-outlined">videocam</span>
                                            <h6>CCTV Setup</h6>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="service-card" onclick="toggleService(this,'Solar Setup')">
                                            <div class="service-check">✓</div>
                                            <span class="material-symbols-outlined">wb_sunny</span>
                                            <h6>Solar Setup</h6>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="service-card" onclick="toggleService(this,'Street Light')">
                                            <div class="service-check">✓</div>
                                            <span class="material-symbols-outlined">light</span>
                                            <h6>Street Light</h6>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="service-card" onclick="toggleService(this,'Public Address')">
                                            <div class="service-check">✓</div>
                                            <span class="material-symbols-outlined">speaker</span>
                                            <h6>Public Address</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- CCTV Sub-type -->
                                <div id="cctv-subtype-section" style="display:none;" class="mb-4">
                                    <span class="section-label">CCTV Service Type</span>
                                    <div class="d-flex flex-wrap gap-2 mt-1">
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Installation')">
                                            Installation</div>
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Relocation')">Relocation
                                        </div>
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Rehabilitation')">
                                            Rehabilitation</div>
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Restoration')">Restoration
                                        </div>
                                    </div>
                                </div>

                                <!-- Slot info banner -->
                                <div class="slot-info-banner" id="slot-info-banner" style="display:none;">
                                    <span class="material-symbols-outlined">info</span>
                                    <span id="slot-info-text"></span>
                                </div>

                                <!-- Time Slot -->
                                <span class="section-label">Preferred Time Slot</span>
                                <div class="row g-3 mb-4" id="slot-options">
                                    <div class="col-md-6">
                                        <div class="slot-card" id="slot-morning" onclick="selectSlot(this,'Morning')">
                                            <span class="material-symbols-outlined">wb_twilight</span>
                                            <h6>Morning</h6>
                                            <p>8:00 AM – 12:00 PM</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="slot-card" id="slot-afternoon"
                                            onclick="selectSlot(this,'Afternoon')">
                                            <span class="material-symbols-outlined">light_mode</span>
                                            <h6>Afternoon</h6>
                                            <p>1:00 PM – 5:00 PM</p>
                                        </div>
                                    </div>
                                    <!-- Full Day (shown when applicable) -->
                                    <div class="col-12" id="slot-fullday-wrap" style="display:none;">
                                        <div class="slot-card selected" id="slot-fullday">
                                            <span class="material-symbols-outlined">calendar_today</span>
                                            <h6>Full Day</h6>
                                            <p>8:00 AM – 5:00 PM</p>
                                            <div class="full-day-badge">Automatically Applied</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="goStep(2)">
                                        <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                    </button>
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="goStep(4)">
                                        Next <span class="material-symbols-outlined fs-15">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: Personal Details (pre-filled) -->
                    <div class="step-pane" id="pane4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-1">Your Details</h5>
                                <p class="text-muted small mb-4">Fill in your contact information and service location.</p>

                                <span class="section-label">Contact Information</span>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-fname"
                                            value="{{ auth()->user()->first_name }}" placeholder="First name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-lname"
                                            value="{{ auth()->user()->last_name }}" placeholder="Last name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-contact"
                                            value="{{ auth()->user()->contact_number }}"
                                            placeholder="Mobile or telephone number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-sm" id="d-email"
                                            value="{{ auth()->user()->email }}" placeholder="Email address" required>
                                    </div>
                                </div>

                                <span class="section-label">Service Location</span>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Block</label>
                                        <input type="text" class="form-control form-control-sm" id="d-block"
                                            value="{{ auth()->user()->client->block }}" placeholder="Block number"
                                            required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Lot</label>
                                        <input type="text" class="form-control form-control-sm" id="d-lot"
                                            value="{{ auth()->user()->client->lot }}" placeholder="Lot number" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Street / Purok / Sitio</label>
                                        <input type="text" class="form-control form-control-sm" id="d-street"
                                            value="{{ auth()->user()->client->street }}"
                                            placeholder="Street name or purok/sitio" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Barangay <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-brgy"
                                            value="{{ auth()->user()->client->barangay }}" placeholder="Barangay name"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Province <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="d-province"
                                            onchange="updateCities()" required>
                                            <option value="">— Select Province —</option>
                                            <optgroup label="NCR">
                                                <option value="Metro Manila"
                                                    {{ auth()->user()->client->province === 'Metro Manila' ? 'selected' : '' }}>
                                                    Metro Manila (NCR)</option>
                                            </optgroup>
                                            <optgroup label="Region IV-A (CALABARZON)">
                                                <option value="Batangas"
                                                    {{ auth()->user()->client->province === 'Batangas' ? 'selected' : '' }}>
                                                    Batangas</option>
                                                <option value="Cavite"
                                                    {{ auth()->user()->client->province === 'Cavite' ? 'selected' : '' }}>
                                                    Cavite</option>
                                                <option value="Laguna"
                                                    {{ auth()->user()->client->province === 'Laguna' ? 'selected' : '' }}>
                                                    Laguna</option>
                                                <option value="Quezon"
                                                    {{ auth()->user()->client->province === 'Quezon' ? 'selected' : '' }}>
                                                    Quezon</option>
                                                <option value="Rizal"
                                                    {{ auth()->user()->client->province === 'Rizal' ? 'selected' : '' }}>
                                                    Rizal</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">City / Municipality <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="d-city" required>
                                            <!-- pre-populated via JS on load, using window.clientDefaults.city -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-zip"
                                            value="{{ auth()->user()->client->zip_code }}" placeholder="Postal code"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Notes / Special Instructions</label>
                                        <textarea class="form-control form-control-sm" id="d-notes" rows="2"
                                            placeholder="Describe any specific requirements or concerns..."></textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="goStep(3)">
                                        <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                    </button>
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="goStep(5)">
                                        Next <span class="material-symbols-outlined fs-15">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 5: Review & Submit -->
                    <div class="step-pane" id="pane5">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-1">Review Your Request</h5>
                                <p class="text-muted small mb-4">Please check all details before submitting.</p>

                                <div class="review-box mb-4">
                                    <span class="section-label mb-3 d-block">Request Summary</span>

                                    <div class="review-row">
                                        <span class="review-label">Client Type</span>
                                        <span class="review-value" id="rv-clientType">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Establishment Type</span>
                                        <span class="review-value" id="rv-estab">—</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="review-row">
                                        <span class="review-label">Preferred Date</span>
                                        <span class="review-value" id="rv-date">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Time Slot</span>
                                        <span class="review-value" id="rv-slot">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Service(s)</span>
                                        <span class="review-value" id="rv-service">—</span>
                                    </div>
                                    <div class="review-row" id="rv-subtype-row" style="display:none;">
                                        <span class="review-label">CCTV Type</span>
                                        <span class="review-value" id="rv-subtype">—</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="review-row">
                                        <span class="review-label">Full Name</span>
                                        <span class="review-value" id="rv-name">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Contact Number</span>
                                        <span class="review-value" id="rv-contact">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Email</span>
                                        <span class="review-value" id="rv-email">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Location</span>
                                        <span class="review-value" id="rv-location">—</span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">Notes</span>
                                        <span class="review-value" id="rv-notes">—</span>
                                    </div>
                                </div>

                                <div class="alert alert-light border d-flex gap-2 align-items-start py-2 px-3 mb-4"
                                    style="font-size:.8rem;">
                                    <span class="material-symbols-outlined text-warning"
                                        style="font-size:18px;flex-shrink:0;">info</span>
                                    <span>Your request will be reviewed by our team. You will be notified once your schedule
                                        is confirmed. Preferred dates are subject to availability.</span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="goStep(4)">
                                        <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                    </button>
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1"
                                        onclick="submitRequest()">
                                        <span class="material-symbols-outlined">send</span> Submit Request
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TAB 2: MY REQUESTS -->
                <div class="tab-pane fade @if (request('tab') === 'history') show active @endif" id="history-view"
                    role="tabpanel">

                    @php
                        $statusBadge = [
                            'Pending' => 'warning text-dark',
                            'Confirmed' => 'success',
                            'Declined' => 'danger',
                            'Cancelled' => 'secondary',
                        ];
                        $subView = request('sub', 'active');
                    @endphp

                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon green-text">inbox</span>
                                <div>
                                    <p class="summary-label">Total</p>
                                    <p class="summary-value">{{ $total }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                                <div>
                                    <p class="summary-label">Confirmed</p>
                                    <p class="summary-value">{{ $confirmed }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                                <div>
                                    <p class="summary-label">Pending</p>
                                    <p class="summary-value">{{ $pending }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                                <div>
                                    <p class="summary-label">Declined</p>
                                    <p class="summary-value">{{ $declined }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active / History sub-toggle -->
                    <div class="btn-group btn-group-sm mb-3" role="group" id="requestSubToggle">
                        <button type="button"
                            class="btn btn-outline-success @if ($subView === 'active') active @endif"
                            data-sub="active">
                            Active Requests
                        </button>
                        <button type="button"
                            class="btn btn-outline-success @if ($subView === 'history') active @endif"
                            data-sub="history">
                            Request History
                        </button>
                    </div>

                    <!-- ACTIVE: Pending + Confirmed -->
                    <div id="sub-active-view" class="@if ($subView !== 'active') d-none @endif">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="activeRequestsTable" class="table table-hover mb-0 small w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 small green-th">ID</th>
                                                <th class="border-0 small green-th">Pref. Date</th>
                                                <th class="border-0 small green-th">Service(s)</th>
                                                <th class="border-0 small green-th">Sub-type</th>
                                                <th class="border-0 small green-th">Time Slot</th>
                                                <th class="border-0 small green-th">Status</th>
                                                <th class="border-0 small green-th">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($activeAssessments as $a)
                                                @php $badge = $statusBadge[$a->status] ?? 'secondary'; @endphp
                                                <tr data-ref="{{ $a->id }}">
                                                    <td class="fw-semibold">{{ $a->id }}</td>
                                                    <td data-order="{{ $a->preferred_date->format('Y-m-d') }}">
                                                        {{ $a->preferred_date->format('M j, Y') }}
                                                    </td>
                                                    <td>{{ implode(', ', $a->services ?? []) }}</td>
                                                    <td>{{ $a->cctv_subtype ?? '—' }}</td>
                                                    <td>{{ $a->time_slot }}</td>
                                                    <td><span
                                                            class="badge bg-{{ $badge }} rounded-pill">{{ $a->status }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button class="btn btn-outline-success" data-bs-toggle="modal"
                                                                data-bs-target="#viewRequestModal"
                                                                onclick="loadViewRequest({
                                            ref: {{ Js::from($a->id) }},
                                            date: {{ Js::from($a->preferred_date->format('M j, Y')) }},
                                            slot: {{ Js::from($a->time_slot) }},
                                            service: {{ Js::from(implode(', ', $a->services ?? [])) }},
                                            subtype: {{ Js::from($a->cctv_subtype ?? '—') }},
                                            clientType: {{ Js::from($a->client_type) }},
                                            estab: {{ Js::from($a->establishment_type) }},
                                            status: {{ Js::from($a->status) }},
                                            statusClass: {{ Js::from($badge) }},
                                            name: {{ Js::from(auth()->user()->full_name) }},
                                            contact: {{ Js::from(auth()->user()->contact_number ?? '—') }},
                                            email: {{ Js::from(auth()->user()->email) }},
                                            brgy: {{ Js::from(auth()->user()->client->barangay ?? '—') }},
                                            city: {{ Js::from(auth()->user()->client->city ?? '—') }},
                                            province: {{ Js::from(auth()->user()->client->province ?? '—') }},
                                            notes: {{ Js::from($a->notes ?? '') }}
                                        })">
                                                                <span
                                                                    class="material-symbols-outlined icon-action">visibility</span>
                                                            </button>
                                                            <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                                data-bs-target="#cancelRequestModal"
                                                                onclick="prepareCancel({{ $a->id }}, {{ Js::from($a->preferred_date->format('M j, Y')) }})">
                                                                <span
                                                                    class="material-symbols-outlined icon-action">cancel</span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HISTORY: Declined + Cancelled -->
                    <div id="sub-history-view" class="@if ($subView !== 'history') d-none @endif">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="historyRequestsTable" class="table table-hover mb-0 small w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 small green-th">ID</th>
                                                <th class="border-0 small green-th">Pref. Date</th>
                                                <th class="border-0 small green-th">Service(s)</th>
                                                <th class="border-0 small green-th">Sub-type</th>
                                                <th class="border-0 small green-th">Time Slot</th>
                                                <th class="border-0 small green-th">Status</th>
                                                <th class="border-0 small green-th">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($historyAssessments as $a)
                                                @php $badge = $statusBadge[$a->status] ?? 'secondary'; @endphp
                                                <tr data-ref="{{ $a->id }}">
                                                    <td class="fw-semibold">{{ $a->id }}</td>
                                                    <td data-order="{{ $a->preferred_date->format('Y-m-d') }}">
                                                        {{ $a->preferred_date->format('M j, Y') }}
                                                    </td>
                                                    <td>{{ implode(', ', $a->services ?? []) }}</td>
                                                    <td>{{ $a->cctv_subtype ?? '—' }}</td>
                                                    <td>{{ $a->time_slot }}</td>
                                                    <td><span
                                                            class="badge bg-{{ $badge }} rounded-pill">{{ $a->status }}</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                                            onclick="loadViewRequest({
                                        ref: {{ Js::from($a->id) }},
                                        date: {{ Js::from($a->preferred_date->format('M j, Y')) }},
                                        slot: {{ Js::from($a->time_slot) }},
                                        service: {{ Js::from(implode(', ', $a->services ?? [])) }},
                                        subtype: {{ Js::from($a->cctv_subtype ?? '—') }},
                                        clientType: {{ Js::from($a->client_type) }},
                                        estab: {{ Js::from($a->establishment_type) }},
                                        status: {{ Js::from($a->status) }},
                                        statusClass: {{ Js::from($badge) }},
                                        name: {{ Js::from(auth()->user()->full_name) }},
                                        contact: {{ Js::from(auth()->user()->contact_number ?? '—') }},
                                        email: {{ Js::from(auth()->user()->email) }},
                                        brgy: {{ Js::from(auth()->user()->client->barangay ?? '—') }},
                                        city: {{ Js::from(auth()->user()->client->city ?? '—') }},
                                        province: {{ Js::from(auth()->user()->client->province ?? '—') }},
                                        notes: {{ Js::from($a->status === 'Cancelled' ? $a->cancellation_reason ?? ($a->notes ?? '') : $a->notes ?? '') }}
                                    })">
                                                            <span
                                                                class="material-symbols-outlined icon-action">visibility</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- View Request Modal -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-18">receipt_long</span>
                        Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="modal-section-label">Request Info</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">ID</p>
                            <p class="detail-value fw-semibold" id="vr-ref">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Preferred Date</p>
                            <p class="detail-value" id="vr-date">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Time Slot</p>
                            <p class="detail-value" id="vr-slot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Status</p>
                            <p class="detail-value" id="vr-status">—</p>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                        </div>
                        <div class="col-12">
                            <p class="modal-section-label">Service Info</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Client Type</p>
                            <p class="detail-value" id="vr-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Establishment Type</p>
                            <p class="detail-value" id="vr-estab">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Service(s)</p>
                            <p class="detail-value fw-semibold" id="vr-service">—</p>
                        </div>
                        <div class="col-md-4" id="vr-subtype-col">
                            <p class="detail-label">CCTV Type</p>
                            <p class="detail-value" id="vr-subtype">—</p>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                        </div>
                        <div class="col-12">
                            <p class="modal-section-label">Contact Info</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Full Name</p>
                            <p class="detail-value fw-semibold" id="vr-name">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Contact Number</p>
                            <p class="detail-value" id="vr-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Email</p>
                            <p class="detail-value" id="vr-email">—</p>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                        </div>
                        <div class="col-12">
                            <p class="modal-section-label">Location</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Barangay</p>
                            <p class="detail-value" id="vr-brgy">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">City / Municipality</p>
                            <p class="detail-value" id="vr-city">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Province</p>
                            <p class="detail-value" id="vr-province">—</p>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                        </div>
                        <div class="col-12">
                            <p class="detail-label">Notes</p>
                            <p class="detail-value" id="vr-notes">—</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4">
                <div
                    style="width:60px;height:60px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <span class="material-symbols-outlined green-text" style="font-size:32px;">check_circle</span>
                </div>
                <h5 class="fw-semibold mb-1">Request Submitted!</h5>
                <p class="text-muted small mb-3">Your assessment request has been sent. Our team will confirm your schedule
                    within 1–2 business days.</p>
                <button class="btn btn-success btn-sm w-100" data-bs-dismiss="modal"
                    onclick="resetWizard()">Done</button>
            </div>
        </div>
    </div>

    <!-- Cancel Request Modal -->
    <div class="modal fade" id="cancelRequestModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title d-flex align-items-center gap-2 text-danger">
                        <span class="material-symbols-outlined fs-18">cancel</span>
                        Cancel Request
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-4">Are you sure you want to cancel this request?</p>

                    <div class="alert alert-warning border-0" style="font-size:.85rem;">
                        <span class="material-symbols-outlined text-warning me-2" style="font-size:18px;">warning</span>
                        <strong>Note:</strong> This action cannot be undone. Your request will be marked as "Cancelled" and
                        removed from the pending queue.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-2 d-block">Cancellation Reason <span
                                class="text-danger">*</span></label>

                        <select class="form-select form-select-sm mb-2" id="cancel-reason-select"
                            onchange="toggleOtherReason()">
                            <option value="">— Select a reason —</option>
                            <option value="changed_mind">Changed my mind</option>
                            <option value="date_unavailable">Preferred date no longer works</option>
                            <option value="found_provider">Found another provider</option>
                            <option value="needs_change">Need to change services/location</option>
                            <option value="other">Other (please specify)</option>
                        </select>

                        <div id="other-reason-group" class="collapse">
                            <textarea class="form-control form-control-sm" id="cancel-reason-other" rows="3"
                                placeholder="Please specify the reason..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-15">close</span>
                        Keep Request
                    </button>
                    <button type="button" class="btn btn-danger btn-sm px-4 d-flex align-items-center gap-1"
                        id="confirm-cancel-btn">
                        <span class="material-symbols-outlined fs-15">delete</span>
                        Cancel Request
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        window.clientDefaults = {
            fname: @json(auth()->user()->first_name),
            lname: @json(auth()->user()->last_name),
            contact: @json(auth()->user()->contact_number),
            email: @json(auth()->user()->email),
            block: @json(auth()->user()->client->block),
            lot: @json(auth()->user()->client->lot),
            street: @json(auth()->user()->client->street),
            brgy: @json(auth()->user()->client->barangay),
            zip: @json(auth()->user()->client->zip_code),
            province: @json(auth()->user()->client->province),
            city: @json(auth()->user()->client->city),
        };
        window.assessmentStoreUrl = @json(route('assessment.store'));
        window.assessmentAvailabilityUrl = @json(route('assessment.availability'));
    </script>

    <script src="{{ asset('js/client/client-assessment.js') }}"></script>
@endsection
