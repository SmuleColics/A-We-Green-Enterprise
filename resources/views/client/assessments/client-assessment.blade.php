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
                        <button class="nav-link active" id="book-tab" data-bs-toggle="tab" data-bs-target="#book-view" type="button">
                            Book Assessment
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-view" type="button">
                            My Requests
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">

                <!-- TAB 1: BOOK ASSESSMENT -->
                <div class="tab-pane fade show active" id="book-view" role="tabpanel">

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
                                <p class="text-muted small mb-4">This helps us check the right schedule availability for your assessment.</p>

                                <span class="section-label">Client Type</span>
                                <div class="row g-3 mb-4">
                                    <div class="col-6 col-md-3">
                                        <div class="type-card" onclick="selectClientType(this,'Residential')">
                                            <span class="material-symbols-outlined">home</span>
                                            <h6>Residential</h6>
                                            <p>Individual homeowner</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="type-card" onclick="selectClientType(this,'Subdivision')">
                                            <span class="material-symbols-outlined">holiday_village</span>
                                            <h6>Subdivision / HOA</h6>
                                            <p>Gated community or homeowners association</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="type-card" onclick="selectClientType(this,'Commercial')">
                                            <span class="material-symbols-outlined">business</span>
                                            <h6>Commercial</h6>
                                            <p>Business or company</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="type-card" onclick="selectClientType(this,'Government')">
                                            <span class="material-symbols-outlined">account_balance</span>
                                            <h6>Government / LGU</h6>
                                            <p>Barangay, school, government office</p>
                                        </div>
                                    </div>
                                </div>

                                <span class="section-label">Establishment Type</span>
                                <div class="row g-2 mb-4" id="estab-options">
                                    <div class="col-12 text-muted small fst-italic">Please select a client type first.</div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(2)">
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
                                <h5 class="fw-semibold mb-0">March 2026</h5>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-light border">
                                        <span class="material-symbols-outlined fs-18">chevron_left</span>
                                    </button>
                                    <button class="btn btn-sm btn-light border">
                                        <span class="material-symbols-outlined fs-18">chevron_right</span>
                                    </button>
                                </div>
                            </div>

                            <div class="full-calendar-grid">
                                <div class="calendar-header-cell">Sun</div>
                                <div class="calendar-header-cell">Mon</div>
                                <div class="calendar-header-cell">Tue</div>
                                <div class="calendar-header-cell">Wed</div>
                                <div class="calendar-header-cell">Thu</div>
                                <div class="calendar-header-cell">Fri</div>
                                <div class="calendar-header-cell">Sat</div>

                                <div class="calendar-cell no-work">
                                    <div class="calendar-date">1</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 2, 2026')">
                                    <div class="calendar-date">2</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 3, 2026')">
                                    <div class="calendar-date">3</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 4, 2026')">
                                    <div class="calendar-date">4</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 5, 2026')">
                                    <div class="calendar-date">5</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 6, 2026')">
                                    <div class="calendar-date">6</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 7, 2026')">
                                    <div class="calendar-date">7</div>
                                </div>

                                <div class="calendar-cell no-work">
                                    <div class="calendar-date">8</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 9, 2026')">
                                    <div class="calendar-date">9</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 10, 2026')">
                                    <div class="calendar-date">10</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 11, 2026')">
                                    <div class="calendar-date">11</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 12, 2026')">
                                    <div class="calendar-date">12</div>
                                </div>
                                <div class="calendar-cell full no-click" onclick="fullAlert()">
                                    <div class="calendar-date">13</div>
                                    <span class="calendar-slot-badge">AM — Booked</span>
                                    <span class="calendar-slot-badge">PM — Booked</span>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 14, 2026')">
                                    <div class="calendar-date">14</div>
                                </div>

                                <div class="calendar-cell today partial" id="mar15" onclick="handleMar15(this,'Mar 15, 2026')">
                                    <div class="calendar-date" style="color:#fff;">15</div>
                                    <span class="calendar-slot-badge">AM — Pedro</span>
                                </div>
                                <div class="calendar-cell no-work">
                                    <div class="calendar-date">16</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 17, 2026')">
                                    <div class="calendar-date">17</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 18, 2026')">
                                    <div class="calendar-date">18</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 19, 2026')">
                                    <div class="calendar-date">19</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 20, 2026')">
                                    <div class="calendar-date">20</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 21, 2026')">
                                    <div class="calendar-date">21</div>
                                </div>

                                <div class="calendar-cell no-work">
                                    <div class="calendar-date">22</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 23, 2026')">
                                    <div class="calendar-date">23</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 24, 2026')">
                                    <div class="calendar-date">24</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 25, 2026')">
                                    <div class="calendar-date">25</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 26, 2026')">
                                    <div class="calendar-date">26</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 27, 2026')">
                                    <div class="calendar-date">27</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 28, 2026')">
                                    <div class="calendar-date">28</div>
                                </div>

                                <div class="calendar-cell no-work">
                                    <div class="calendar-date">29</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 30, 2026')">
                                    <div class="calendar-date">30</div>
                                </div>
                                <div class="calendar-cell" onclick="pickDate(this,'Mar 31, 2026')">
                                    <div class="calendar-date">31</div>
                                </div>
                                <div class="calendar-cell no-work"></div>
                                <div class="calendar-cell no-work"></div>
                                <div class="calendar-cell no-work"></div>
                                <div class="calendar-cell no-work"></div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-3 pt-2" style="font-size:.75rem; color:#555;">
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#fff;border:1px solid #dee2e6;"></div> Available
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#e0f7fa;"></div> Partially Booked
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#f0f0f0;border:1px solid #dee2e6;"></div> Fully Booked
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:#f8f9fa;border:1px solid #dee2e6;"></div> Not Available
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="legend-dot" style="background:var(--awg-primary);"></div> Today
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(1)">
                                    <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                </button>
                                <p class="text-muted small mb-0 fst-italic" id="selected-date-label">No date selected yet.</p>
                            </div>
                        </div>
                    </div>


                    <!-- STEP 3: Service & Schedule -->
                    <div class="step-pane" id="pane3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-1">Service & Schedule</h5>
                                <p class="text-muted small mb-4">Select one or more services you need and your preferred time slot.</p>

                                <span class="section-label">Service Type <span class="text-muted fw-normal" style="text-transform:none;letter-spacing:0;font-size:.7rem;">(you may select multiple)</span></span>
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
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Installation')">Installation</div>
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Relocation')">Relocation</div>
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Rehabilitation')">Rehabilitation</div>
                                        <div class="subtype-pill" onclick="selectSubtype(this,'Restoration')">Restoration</div>
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
                                        <div class="slot-card" id="slot-afternoon" onclick="selectSlot(this,'Afternoon')">
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
                                    <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(2)">
                                        <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                    </button>
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(4)">
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
                                        <input type="text" class="form-control form-control-sm" id="d-fname" value="Maria" placeholder="First name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-lname" value="Santos" placeholder="Last name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-contact" value="0917-123-4567" placeholder="Mobile or telephone number">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control form-control-sm" id="d-email" value="maria.santos@email.com" placeholder="Optional">
                                    </div>
                                </div>

                                <span class="section-label">Service Location</span>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">Block</label>
                                        <input type="text" class="form-control form-control-sm" id="d-block" value="12" placeholder="Block number">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Lot</label>
                                        <input type="text" class="form-control form-control-sm" id="d-lot" value="5" placeholder="Lot number">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Street / Purok / Sitio</label>
                                        <input type="text" class="form-control form-control-sm" id="d-street" value="Sampaguita St." placeholder="Street name or purok/sitio">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Barangay <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="d-brgy" value="Brgy. Tanzang Luma II" placeholder="Barangay name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Province <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="d-province" onchange="updateCities()">
                                            <option value="">— Select Province —</option>
                                            <optgroup label="NCR">
                                                <option value="Metro Manila">Metro Manila (NCR)</option>
                                            </optgroup>
                                            <optgroup label="Region IV-A (CALABARZON)">
                                                <option value="Batangas">Batangas</option>
                                                <option value="Cavite" selected>Cavite</option>
                                                <option value="Laguna">Laguna</option>
                                                <option value="Quezon">Quezon</option>
                                                <option value="Rizal">Rizal</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">City / Municipality <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm" id="d-city">
                                            <!-- pre-populated via JS on load -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Zip Code</label>
                                        <input type="text" class="form-control form-control-sm" id="d-zip" value="4103" placeholder="Postal code">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Notes / Special Instructions</label>
                                        <textarea class="form-control form-control-sm" id="d-notes" rows="2"
                                            placeholder="Describe any specific requirements or concerns...">Requesting 4 cameras around the perimeter of the house.</textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(3)">
                                        <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                    </button>
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(5)">
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

                                <div class="alert alert-light border d-flex gap-2 align-items-start py-2 px-3 mb-4" style="font-size:.8rem;">
                                    <span class="material-symbols-outlined text-warning" style="font-size:18px;flex-shrink:0;">info</span>
                                    <span>Your request will be reviewed by our team. You will be notified once your schedule is confirmed. Preferred dates are subject to availability.</span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-sm px-4 d-flex align-items-center gap-1" onclick="goStep(4)">
                                        <span class="material-symbols-outlined fs-15">arrow_back</span> Back
                                    </button>
                                    <button class="btn btn-success btn-sm px-4 d-flex align-items-center gap-1" onclick="submitRequest()">
                                        <span class="material-symbols-outlined">send</span> Submit Request
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TAB 2: MY REQUESTS -->
                <div class="tab-pane fade" id="history-view" role="tabpanel">
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon green-text">inbox</span>
                                <div>
                                    <p class="summary-label">Total</p>
                                    <p class="summary-value">4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                                <div>
                                    <p class="summary-label">Confirmed</p>
                                    <p class="summary-value">1</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                                <div>
                                    <p class="summary-label">Pending</p>
                                    <p class="summary-value">2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="summary-card">
                                <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                                <div>
                                    <p class="summary-label">Declined</p>
                                    <p class="summary-value">1</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="requestHistoryTable" class="table table-hover mb-0 small w-100">
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
                                        <!-- 1: Confirmed -->
                                        <tr>
                                            <td class="fw-semibold">1</td>
                                            <td>Feb 20, 2026</td>
                                            <td>CCTV Setup</td>
                                            <td>Rehabilitation</td>
                                            <td>Morning</td>
                                            <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                                    onclick="loadViewRequest({ref:'1',date:'Feb 20, 2026',slot:'Morning',service:'CCTV Setup',subtype:'Rehabilitation',clientType:'Residential',estab:'Home / Residence',status:'Confirmed',statusClass:'success',name:'Maria Santos',contact:'0917-123-4567',email:'maria.santos@email.com',brgy:'Brgy. Tanzang Luma II',city:'Imus',province:'Cavite',notes:'Old cameras need replacement.'})">
                                                    <span class="material-symbols-outlined icon-action">visibility</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- 2: Pending -->
                                        <tr data-ref="2">
                                            <td class="fw-semibold">2</td>
                                            <td>Mar 19, 2026</td>
                                            <td>CCTV Setup</td>
                                            <td>Installation</td>
                                            <td>Morning</td>
                                            <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                                        onclick="loadViewRequest({ref:'2',date:'Mar 19, 2026',slot:'Morning',service:'CCTV Setup',subtype:'Installation',clientType:'Residential',estab:'Home / Residence',status:'Pending',statusClass:'warning text-dark',name:'Maria Santos',contact:'0917-123-4567',email:'maria.santos@email.com',brgy:'Brgy. Tanzang Luma II',city:'Imus',province:'Cavite',notes:'Wants 4 cameras around the house.'})">
                                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                                    </button>
                                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelRequestModal"
                                                        onclick="prepareCancel(2, 'Mar 19, 2026')">
                                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 3: Pending -->
                                        <tr data-ref="3">
                                            <td class="fw-semibold">3</td>
                                            <td>Mar 14, 2026</td>
                                            <td>Solar Setup, CCTV Setup</td>
                                            <td>—</td>
                                            <td>Full Day</td>
                                            <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                                        onclick="loadViewRequest({ref:'3',date:'Mar 14, 2026',slot:'Full Day',service:'Solar Setup, CCTV Setup',subtype:'—',clientType:'Residential',estab:'Home / Residence',status:'Pending',statusClass:'warning text-dark',name:'Maria Santos',contact:'0917-123-4567',email:'maria.santos@email.com',brgy:'Brgy. Tanzang Luma II',city:'Imus',province:'Cavite',notes:''})">
                                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                                    </button>
                                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelRequestModal"
                                                        onclick="prepareCancel(3, 'Mar 14, 2026')">
                                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- 4: Declined -->
                                        <tr>
                                            <td class="fw-semibold">4</td>
                                            <td>Feb 5, 2026</td>
                                            <td>Public Address</td>
                                            <td>—</td>
                                            <td>Afternoon</td>
                                            <td><span class="badge bg-danger rounded-pill">Declined</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                                    onclick="loadViewRequest({ref:'4',date:'Feb 5, 2026',slot:'Afternoon',service:'Public Address',subtype:'—',clientType:'Residential',estab:'Home / Residence',status:'Declined',statusClass:'danger',name:'Maria Santos',contact:'0917-123-4567',email:'maria.santos@email.com',brgy:'Brgy. Tanzang Luma II',city:'Imus',province:'Cavite',notes:''})">
                                                    <span class="material-symbols-outlined icon-action">visibility</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                <div style="width:60px;height:60px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <span class="material-symbols-outlined green-text" style="font-size:32px;">check_circle</span>
                </div>
                <h5 class="fw-semibold mb-1">Request Submitted!</h5>
                <p class="text-muted small mb-3">Your assessment request has been sent. Our team will confirm your schedule within 1–2 business days.</p>
                <button class="btn btn-success btn-sm w-100" data-bs-dismiss="modal" onclick="resetWizard()">Done</button>
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
                        <strong>Note:</strong> This action cannot be undone. Your request will be marked as "Cancelled" and removed from the pending queue.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-2 d-block">Cancellation Reason <span class="text-danger">*</span></label>

                        <select class="form-select form-select-sm mb-2" id="cancel-reason-select" onchange="toggleOtherReason()">
                            <option value="">— Select a reason —</option>
                            <option value="changed_mind">Changed my mind</option>
                            <option value="date_unavailable">Preferred date no longer works</option>
                            <option value="found_provider">Found another provider</option>
                            <option value="needs_change">Need to change services/location</option>
                            <option value="other">Other (please specify)</option>
                        </select>

                        <div id="other-reason-group" class="collapse">
                            <textarea class="form-control form-control-sm" id="cancel-reason-other"
                                rows="3" placeholder="Please specify the reason..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-15">close</span>
                        Keep Request
                    </button>
                    <button type="button" class="btn btn-danger btn-sm px-4 d-flex align-items-center gap-1" id="confirm-cancel-btn">
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
        /* ─── State ─── */
        const state = {
            clientType: '',
            estabType: '',
            estabSize: '',
            selectedDate: '',
            services: [],
            subtype: '',
            slot: ''
        };
        let currentStep = 1;

        /* ─── Establishment options ─── */
        const estabOptions = {
            Residential: [{
                    icon: 'home',
                    label: 'Home / Residence',
                    size: 'small'
                },
                {
                    icon: 'apartment',
                    label: 'Apartment / Condominium',
                    size: 'small'
                },
                {
                    icon: 'villa',
                    label: 'Townhouse',
                    size: 'small'
                },
            ],
            Subdivision: [{
                    icon: 'holiday_village',
                    label: 'Subdivision / HOA',
                    size: 'large'
                },
                {
                    icon: 'location_city',
                    label: 'Condominium Complex',
                    size: 'large'
                },
            ],
            Commercial: [{
                    icon: 'storefront',
                    label: 'Office / Commercial Space',
                    size: 'small'
                },
                {
                    icon: 'warehouse',
                    label: 'Warehouse / Industrial',
                    size: 'large'
                },
                {
                    icon: 'local_mall',
                    label: 'Mall / Shopping Center',
                    size: 'large'
                },
                {
                    icon: 'restaurant',
                    label: 'Restaurant / Café',
                    size: 'small'
                },
                {
                    icon: 'hotel',
                    label: 'Hotel / Resort',
                    size: 'large'
                },
                {
                    icon: 'factory',
                    label: 'Factory / Plant',
                    size: 'large'
                },
            ],
            Government: [{
                    icon: 'account_balance',
                    label: 'Barangay Hall',
                    size: 'small'
                },
                {
                    icon: 'school',
                    label: 'School / University',
                    size: 'large'
                },
                {
                    icon: 'local_hospital',
                    label: 'Hospital / Health Center',
                    size: 'large'
                },
                {
                    icon: 'sports_soccer',
                    label: 'Sports Facility / Gym',
                    size: 'large'
                },
                {
                    icon: 'park',
                    label: 'Park / Public Space',
                    size: 'large'
                },
                {
                    icon: 'directions_bus',
                    label: 'Terminal / Transport Hub',
                    size: 'large'
                },
                {
                    icon: 'local_police',
                    label: 'Police Station / Fire',
                    size: 'small'
                },
                {
                    icon: 'museum',
                    label: 'Museum / Cultural Center',
                    size: 'large'
                },
            ]
        };

        /* ─── Cities per province ─── */
        const cityData = {
            'Metro Manila': [
                'Caloocan', 'Las Piñas', 'Makati', 'Malabon', 'Mandaluyong', 'Manila',
                'Marikina', 'Muntinlupa', 'Navotas', 'Parañaque', 'Pasay', 'Pasig',
                'Pateros', 'Quezon City', 'San Juan', 'Taguig', 'Valenzuela'
            ],
            'Batangas': [
                'Agoncillo', 'Alitagtag', 'Balayan', 'Balete', 'Batangas City', 'Bauan',
                'Calaca', 'Calatagan', 'Cuenca', 'Ibaan', 'Laurel', 'Lemery', 'Lian',
                'Lipa City', 'Lobo', 'Mabini', 'Malvar', 'Mataas na Kahoy', 'Nasugbu',
                'Padre Garcia', 'Rosario', 'San Jose', 'San Juan', 'San Luis', 'San Nicolas',
                'San Pascual', 'Santa Teresita', 'Santo Tomas', 'Taal', 'Talisay',
                'Tanauan City', 'Taysan', 'Tingloy', 'Tuy'
            ],
            'Cavite': [
                'Alfonso', 'Amadeo', 'Bacoor', 'Carmona', 'Cavite City', 'Dasmariñas',
                'General Emilio Aguinaldo', 'General Mariano Alvarez', 'General Trias',
                'Imus', 'Indang', 'Kawit', 'Magallanes', 'Maragondon', 'Mendez',
                'Naic', 'Noveleta', 'Rosario', 'Silang', 'Tagaytay City', 'Tanza',
                'Ternate', 'Trece Martires City'
            ],
            'Laguna': [
                'Alaminos', 'Bay', 'Biñan City', 'Cabuyao City', 'Calamba City',
                'Calauan', 'Cavinti', 'Famy', 'Kalayaan', 'Liliw', 'Los Baños',
                'Luisiana', 'Lumban', 'Mabitac', 'Magdalena', 'Majayjay', 'Nagcarlan',
                'Paete', 'Pagsanjan', 'Pakil', 'Pangil', 'Pila', 'Rizal', 'San Pablo City',
                'San Pedro City', 'Santa Cruz', 'Santa Maria', 'Santa Rosa City',
                'Siniloan', 'Victoria'
            ],
            'Quezon': [
                'Agdangan', 'Alabat', 'Atimonan', 'Buenavista', 'Burdeos', 'Calauag',
                'Candelaria', 'Catanauan', 'Dolores', 'General Luna', 'General Nakar',
                'Guinayangan', 'Gumaca', 'Infanta', 'Jomalig', 'Lopez', 'Lucban',
                'Lucena City', 'Macalelon', 'Mauban', 'Mulanay', 'Padre Burgos',
                'Pagbilao', 'Panukulan', 'Patnanungan', 'Perez', 'Pitogo', 'Plaridel',
                'Polillo', 'Quezon', 'Real', 'Sampaloc', 'San Andres', 'San Antonio',
                'San Francisco', 'San Narciso', 'Sariaya', 'Tagkawayan', 'Tiaong', 'Unisan'
            ],
            'Rizal': [
                'Angono', 'Antipolo City', 'Baras', 'Binangonan', 'Cainta', 'Cardona',
                'Jala-Jala', 'Morong', 'Pililla', 'Rodriguez', 'San Mateo', 'Tanay',
                'Taytay', 'Teresa'
            ]
        };

        function updateCities(preselect) {
            const prov = document.getElementById('d-province').value;
            const sel = document.getElementById('d-city');
            if (!prov || !cityData[prov]) {
                sel.innerHTML = '<option value="">— Select Province First —</option>';
                return;
            }
            sel.innerHTML = '<option value="">— Select City / Municipality —</option>' +
                cityData[prov].map(c =>
                    `<option value="${c}"${(preselect || '') === c ? ' selected' : ''}>${c}</option>`
                ).join('');
        }

        /* Pre-fill city dropdown on page load */
        window.addEventListener('DOMContentLoaded', function() {
            updateCities('Imus');
        });

        /* ─── Step 1: Client Type ─── */
        function selectClientType(el, type) {
            document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            state.clientType = type;
            state.estabType = '';
            state.estabSize = '';
            const opts = estabOptions[type] || [];
            document.getElementById('estab-options').innerHTML = opts.map(o => `
        <div class="col-6 col-md-3">
          <div class="estab-card" onclick="selectEstab(this,'${o.label}','${o.size}')">
            <span class="material-symbols-outlined">${o.icon}</span>
            <span class="elabel">${o.label}</span>
          </div>
        </div>`).join('');
            applyBookingRules();
        }

        function selectEstab(el, label, size) {
            document.querySelectorAll('.estab-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            state.estabType = label;
            state.estabSize = size;
            updateSlotLogic();
        }

        /* ─── Booking rules for Mar 15 ─── */
        function applyBookingRules() {
            const cell = document.getElementById('mar15');
            if (!cell) return;
            if (state.clientType === 'Government') {
                cell.classList.remove('today', 'partial');
                cell.classList.add('full', 'no-click');
                cell.querySelector('.calendar-date').style.color = '#bbb';
            } else {
                cell.classList.remove('full', 'no-click');
                cell.classList.add('today', 'partial');
                cell.querySelector('.calendar-date').style.color = '#fff';
            }
        }

        function handleMar15(el, date) {
            pickDate(el, date);
        }

        /* ─── Step 2: Pick date ─── */
        function pickDate(el, date) {
            if (el.classList.contains('no-click') || el.classList.contains('no-work') || el.classList.contains('full')) {
                fullAlert();
                return;
            }
            document.querySelectorAll('.calendar-cell.selected-day').forEach(c => c.classList.remove('selected-day'));
            el.classList.add('selected-day');
            state.selectedDate = date;
            document.getElementById('selected-date-label').textContent = 'Selected: ' + date;
            setTimeout(() => goStep(3), 300);
        }

        function fullAlert() {
            alert('This date is not available for your client type. Please choose another date.');
        }

        /* ─── Step 3: Multi-select services ─── */
        function toggleService(el, service) {
            el.classList.toggle('selected');
            if (el.classList.contains('selected')) {
                if (!state.services.includes(service)) state.services.push(service);
            } else {
                state.services = state.services.filter(s => s !== service);
            }
            const hasCCTV = state.services.includes('CCTV Setup');
            document.getElementById('cctv-subtype-section').style.display = hasCCTV ? 'block' : 'none';
            if (!hasCCTV) {
                state.subtype = '';
                document.querySelectorAll('.subtype-pill').forEach(p => p.classList.remove('selected'));
            }
            updateSlotLogic();
        }

        function selectSubtype(el, sub) {
            document.querySelectorAll('.subtype-pill').forEach(p => p.classList.remove('selected'));
            el.classList.add('selected');
            state.subtype = sub;
        }

        /* ─── Slot logic ─── */
        function isFullDay() {
            return state.estabSize === 'large' || state.services.length > 1;
        }

        function updateSlotLogic() {
            const full = isFullDay();
            const banner = document.getElementById('slot-info-banner');
            const infoText = document.getElementById('slot-info-text');
            const morningCard = document.getElementById('slot-morning');
            const afternoonCard = document.getElementById('slot-afternoon');
            const fullDayWrap = document.getElementById('slot-fullday-wrap');

            if (full) {
                fullDayWrap.style.display = 'block';
                morningCard.closest('.col-md-6').style.display = 'none';
                afternoonCard.closest('.col-md-6').style.display = 'none';
                state.slot = 'Full Day';
                banner.style.display = 'flex';
                if (state.services.length > 1 && state.estabSize === 'large') {
                    infoText.textContent = 'Multiple services on a large establishment — a full day is required for this assessment.';
                } else if (state.services.length > 1) {
                    infoText.textContent = 'Multiple services selected — a full day is required to cover all assessments in one visit.';
                } else {
                    infoText.textContent = 'This establishment type requires a full-day assessment visit.';
                }
            } else {
                fullDayWrap.style.display = 'none';
                morningCard.closest('.col-md-6').style.display = 'block';
                afternoonCard.closest('.col-md-6').style.display = 'block';
                if (state.slot === 'Full Day') state.slot = '';
                document.querySelectorAll('.slot-card').forEach(c => {
                    if (c.id !== 'slot-fullday') c.classList.remove('selected');
                });
                banner.style.display = 'none';
            }
        }

        function selectSlot(el, slot) {
            if (isFullDay()) return;
            document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            state.slot = slot;
        }

        /* ─── Step navigation ─── */
        function goStep(n) {
            if (n > currentStep && !validateStep(currentStep)) return;
            if (n > currentStep) {
                const sc = document.getElementById('sc' + currentStep);
                sc.classList.remove('active');
                sc.classList.add('done');
                sc.innerHTML = '✓';
                document.getElementById('sl' + currentStep).classList.remove('active');
                document.getElementById('sl' + currentStep).classList.add('done');
                if (currentStep < 5) document.getElementById('sline' + currentStep).classList.add('done');
            }
            if (n < currentStep) {
                for (let i = n; i <= currentStep; i++) {
                    const sc = document.getElementById('sc' + i);
                    sc.classList.remove('active', 'done');
                    sc.innerHTML = i;
                    document.getElementById('sl' + i).classList.remove('active', 'done');
                    if (i < 5) document.getElementById('sline' + i).classList.remove('done');
                }
            }
            document.getElementById('sc' + n).classList.add('active');
            document.getElementById('sl' + n).classList.add('active');
            document.getElementById('pane' + currentStep).classList.remove('active');
            document.getElementById('pane' + n).classList.add('active');
            currentStep = n;
            if (n === 5) buildReview();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        /* ─── Validation ─── */
        function validateStep(s) {
            if (s === 1) {
                if (!state.clientType) {
                    alert('Please select a client type.');
                    return false;
                }
                if (!state.estabType) {
                    alert('Please select an establishment type.');
                    return false;
                }
            }
            if (s === 2) {
                if (!state.selectedDate) {
                    alert('Please select a date from the calendar.');
                    return false;
                }
            }
            if (s === 3) {
                if (state.services.length === 0) {
                    alert('Please select at least one service type.');
                    return false;
                }
                if (state.services.includes('CCTV Setup') && !state.subtype) {
                    alert('Please select a CCTV service type.');
                    return false;
                }
                if (!state.slot) {
                    alert('Please select a time slot.');
                    return false;
                }
            }
            if (s === 4) {
                if (!document.getElementById('d-fname').value.trim()) {
                    alert('Please enter your first name.');
                    return false;
                }
                if (!document.getElementById('d-lname').value.trim()) {
                    alert('Please enter your last name.');
                    return false;
                }
                if (!document.getElementById('d-contact').value.trim()) {
                    alert('Please enter your contact number.');
                    return false;
                }
                if (!document.getElementById('d-brgy').value.trim()) {
                    alert('Please enter the barangay.');
                    return false;
                }
                if (!document.getElementById('d-province').value) {
                    alert('Please select a province.');
                    return false;
                }
                if (!document.getElementById('d-city').value) {
                    alert('Please select a city/municipality.');
                    return false;
                }
            }
            return true;
        }

        /* ─── Build review ─── */
        function buildReview() {
            const fname = document.getElementById('d-fname').value.trim();
            const lname = document.getElementById('d-lname').value.trim();
            const contact = document.getElementById('d-contact').value.trim();
            const email = document.getElementById('d-email').value.trim();
            const block = document.getElementById('d-block').value.trim();
            const lot = document.getElementById('d-lot').value.trim();
            const street = document.getElementById('d-street').value.trim();
            const brgy = document.getElementById('d-brgy').value.trim();
            const city = document.getElementById('d-city').value;
            const province = document.getElementById('d-province').value;
            const zip = document.getElementById('d-zip').value.trim();
            const notes = document.getElementById('d-notes').value.trim();

            document.getElementById('rv-clientType').textContent = state.clientType;
            document.getElementById('rv-estab').textContent = state.estabType;
            document.getElementById('rv-date').textContent = state.selectedDate;
            document.getElementById('rv-slot').textContent = state.slot;
            document.getElementById('rv-service').textContent = state.services.join(', ') || '—';
            document.getElementById('rv-subtype').textContent = state.subtype || '—';
            document.getElementById('rv-subtype-row').style.display =
                state.services.includes('CCTV Setup') ? 'flex' : 'none';
            document.getElementById('rv-name').textContent = [fname, lname].filter(Boolean).join(' ') || '—';
            document.getElementById('rv-contact').textContent = contact;
            document.getElementById('rv-email').textContent = email || '—';
            const locParts = [];
            if (block) locParts.push('Blk ' + block);
            if (lot) locParts.push('Lot ' + lot);
            if (street) locParts.push(street);
            if (brgy) locParts.push(brgy);
            if (city) locParts.push(city);
            if (province) locParts.push(province);
            if (zip) locParts.push(zip);
            document.getElementById('rv-location').textContent = locParts.join(', ') || '—';
            document.getElementById('rv-notes').textContent = notes || '—';
        }

        /* ─── Submit ─── */
        function submitRequest() {
            new bootstrap.Modal(document.getElementById('successModal')).show();
        }

        /* ─── Reset wizard ─── */
        function resetWizard() {
            currentStep = 1;
            for (let i = 1; i <= 5; i++) {
                const sc = document.getElementById('sc' + i);
                sc.classList.remove('active', 'done');
                sc.innerHTML = i;
                document.getElementById('sl' + i).classList.remove('active', 'done');
                document.getElementById('pane' + i).classList.remove('active');
                if (i < 5) document.getElementById('sline' + i).classList.remove('done');
            }
            document.getElementById('sc1').classList.add('active');
            document.getElementById('sl1').classList.add('active');
            document.getElementById('pane1').classList.add('active');
            state.clientType = '';
            state.estabType = '';
            state.estabSize = '';
            state.selectedDate = '';
            state.services = [];
            state.subtype = '';
            state.slot = '';
            document.querySelectorAll('.type-card,.estab-card,.service-card,.slot-card').forEach(c => c.classList.remove('selected'));
            document.querySelectorAll('.subtype-pill').forEach(p => p.classList.remove('selected'));
            document.querySelectorAll('.calendar-cell.selected-day').forEach(c => c.classList.remove('selected-day'));
            document.getElementById('selected-date-label').textContent = 'No date selected yet.';
            document.getElementById('cctv-subtype-section').style.display = 'none';
            document.getElementById('slot-info-banner').style.display = 'none';
            document.getElementById('slot-fullday-wrap').style.display = 'none';
            const mc = document.getElementById('slot-morning').closest('.col-md-6');
            const ac = document.getElementById('slot-afternoon').closest('.col-md-6');
            if (mc) mc.style.display = 'block';
            if (ac) ac.style.display = 'block';
            document.getElementById('d-fname').value = 'Maria';
            document.getElementById('d-lname').value = 'Santos';
            document.getElementById('d-contact').value = '0917-123-4567';
            document.getElementById('d-email').value = 'maria.santos@email.com';
            document.getElementById('d-block').value = '12';
            document.getElementById('d-lot').value = '5';
            document.getElementById('d-street').value = 'Sampaguita St.';
            document.getElementById('d-brgy').value = 'Brgy. Tanzang Luma II';
            document.getElementById('d-zip').value = '4103';
            document.getElementById('d-notes').value = 'Requesting 4 cameras around the perimeter of the house.';
            document.getElementById('d-province').value = 'Cavite';
            updateCities('Imus');
        }

        /* ─── View request modal ─── */
        function loadViewRequest(d) {
            document.getElementById('vr-ref').textContent = d.ref || '—';
            document.getElementById('vr-date').textContent = d.date || '—';
            document.getElementById('vr-slot').textContent = d.slot || '—';
            document.getElementById('vr-clientType').textContent = d.clientType || '—';
            document.getElementById('vr-estab').textContent = d.estab || '—';
            document.getElementById('vr-service').textContent = d.service || '—';
            document.getElementById('vr-subtype').textContent = d.subtype || '—';
            document.getElementById('vr-name').textContent = d.name || '—';
            document.getElementById('vr-contact').textContent = d.contact || '—';
            document.getElementById('vr-email').textContent = d.email || '—';
            document.getElementById('vr-brgy').textContent = d.brgy || '—';
            document.getElementById('vr-city').textContent = d.city || '—';
            document.getElementById('vr-province').textContent = d.province || '—';
            document.getElementById('vr-notes').textContent = d.notes || '—';
            document.getElementById('vr-status').innerHTML =
                `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;
            document.getElementById('vr-subtype-col').style.display =
                (d.service && d.service.includes('CCTV Setup')) ? 'block' : 'none';
        }

        /* ─── DataTable ─── */
        $(document).ready(function() {
            $('#requestHistoryTable').DataTable({
                pageLength: 10,
                order: [
                    [5, 'asc']
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 6
                    },
                    {
                        targets: 5,
                        orderData: 5,
                        render: function(data, type) {
                            if (type === 'sort') {
                                const txt = $(data).text().trim();
                                if (txt === 'Confirmed') return '1';
                                if (txt === 'Pending') return '2';
                                if (txt === 'Declined') return '3';
                                return '9';
                            }
                            return data;
                        }
                    }
                ]
            });
        });

        /* ─── Cancel Request Functions ─── */
        let cancelRequestData = {};

        function prepareCancel(ref, date) {
            cancelRequestData = {
                ref: ref,
                date: date
            };
            document.getElementById('cancel-reason-select').value = '';
            document.getElementById('cancel-reason-other').value = '';
            document.getElementById('other-reason-group').classList.remove('show');
        }

        function toggleOtherReason() {
            const select = document.getElementById('cancel-reason-select');
            const otherGroup = document.getElementById('other-reason-group');
            const otherInput = document.getElementById('cancel-reason-other');

            if (select.value === 'other') {
                otherGroup.classList.add('show');
                otherInput.focus();
            } else {
                otherGroup.classList.remove('show');
                otherInput.value = '';
            }
        }

        document.getElementById('confirm-cancel-btn')?.addEventListener('click', function() {
            const select = document.getElementById('cancel-reason-select');
            const otherInput = document.getElementById('cancel-reason-other');

            if (!select.value) {
                alert('Please select a cancellation reason.');
                select.focus();
                return;
            }

            let reason = select.options[select.selectedIndex].text;
            if (select.value === 'other' && !otherInput.value.trim()) {
                alert('Please specify the reason for "Other".');
                otherInput.focus();
                return;
            }
            if (select.value === 'other') {
                reason = otherInput.value.trim();
            }

            console.log('Cancelling request:', cancelRequestData.ref, 'Reason:', reason);

            const table = $('#requestHistoryTable').DataTable();
            const rowIdx = table.rows().indexes().filter(idx => {
                const row = table.row(idx).node();
                return row.querySelector('td:first-child').textContent.trim() === cancelRequestData.ref;
            })[0];

            if (rowIdx !== undefined) {
                const rowData = table.row(rowIdx).data();
                const newRow = [
                    rowData[0],
                    rowData[1],
                    rowData[2],
                    rowData[3],
                    rowData[4],
                    '<span class="badge bg-secondary rounded-pill">Cancelled</span>',
                    rowData[6].replace(/data-bs-target="#cancelRequestModal"/g, 'data-bs-target="#viewRequestModal"')
                    .replace(/onclick="prepareCancel/g, 'onclick="loadViewRequest')
                ];
                table.row(rowIdx).data(newRow).draw();
            }

            showCancelToast(cancelRequestData.ref, reason);

            bootstrap.Modal.getInstance(document.getElementById('cancelRequestModal')).hide();
        });

        function showCancelToast(ref, reason) {
            const toastEl = $(`
    <div class="toast align-items-center text-white bg-success border-0 position-fixed" 
         style="top: 20px; right: 20px; z-index: 1090; min-width: 300px;" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          <div class="d-flex align-items-start gap-2 mb-1">
            <span class="material-symbols-outlined text-white mt-1" style="font-size:18px;">check_circle</span>
            <strong>Request #${ref} cancelled successfully!</strong>
          </div>
          <small class="opacity-90">${reason}</small>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  `)[0];

            document.body.appendChild(toastEl);
            const toast = new bootstrap.Toast(toastEl);
            toast.show();

            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }
    </script>
@endsection