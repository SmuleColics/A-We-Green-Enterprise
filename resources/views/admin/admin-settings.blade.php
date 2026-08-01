@extends('layouts.admin')

@section('title', 'Settings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-settings.css') }}">
@endsection

@section('page-title', 'Settings')
@section('page-subtitle', 'Manage system configuration')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" onclick="saveAllSettings()">
        <span class="material-symbols-outlined fs-16">save</span>
        Save All Changes
    </button>
@endsection

@section('content')

    <div class="container-xxl px-4 py-4">

        <div class="row g-4">

            <!-- ── LEFT: SETTINGS NAV ── -->
            <div class="col-lg-3">
                <div class="settings-nav-card">
                    <p class="settings-nav-title">Configuration</p>
                    <a href="#landing-page" class="settings-nav-link active" onclick="switchTab(this,'landing-page')">
                        <span class="material-symbols-outlined">web</span>
                        Landing Page
                    </a>
                    <a href="#assessment" class="settings-nav-link" onclick="switchTab(this,'assessment')">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Assessment Settings
                    </a>
                    <a href="#coverage" class="settings-nav-link" onclick="switchTab(this,'coverage')">
                        <span class="material-symbols-outlined">map</span>
                        Coverage Areas
                    </a>
                    <a href="#company" class="settings-nav-link" onclick="switchTab(this,'company')">
                        <span class="material-symbols-outlined">business</span>
                        Company Info
                    </a>
                    <a href="#contact" class="settings-nav-link" onclick="switchTab(this,'contact')">
                        <span class="material-symbols-outlined">contact_phone</span>
                        Contact Details
                    </a>
                    <a href="#legal" class="settings-nav-link" onclick="switchTab(this,'legal')">
                        <span class="material-symbols-outlined">gavel</span>
                        Legal &amp; Policies
                    </a>
                </div>
            </div>

            <!-- ── RIGHT: SETTINGS PANELS ── -->
            <div class="col-lg-9">

                <!-- ════════════════════════════════
                     PANEL 1: LANDING PAGE
                     ════════════════════════════════ -->
                <div class="settings-panel active" id="panel-landing-page">

                    <!-- Hero Section -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">movie</span>
                            Hero Section
                        </div>
                        <div class="settings-card-body">

                            <div class="row g-3">
                                <!-- Hero Background -->
                                <p class="settings-sub-header">Hero Background Image</p>
                                <div class="image-upload-row mb-4">
                                    <div class="image-preview-box" id="preview-hero">
                                        <img src="{{ asset('css/images/hero-img.jpg') }}" alt="Hero preview" class="image-preview-thumb">
                                        <div class="image-preview-overlay">
                                            <span class="material-symbols-outlined">edit</span>
                                            Change
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="settings-label">Hero Background</label>
                                        <input type="file" class="form-control form-control-sm" accept="image/*"
                                            onchange="previewImage(this,'preview-hero')">
                                        <p class="settings-hint">Recommended: 1920×1080px, JPG or WebP. Max 3MB.</p>
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="col-12">
                                    <label class="settings-label">Main Headline</label>
                                    <input type="text" class="form-control" id="hero-headline"
                                        value="We Bring The Right Technology">
                                    <p class="settings-hint">The large bold text on the hero. Keep it short and impactful.</p>
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">Hero Subtitle</label>
                                    <textarea class="form-control" id="hero-subtitle" rows="2">Your trusted partner for CCTV, Solar Energy, Solar Street Lighting, and Public Address Systems since 2015.</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Primary CTA Button Text</label>
                                    <input type="text" class="form-control" id="hero-cta-primary" value="Schedule Free Assessment">
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Secondary CTA Button Text</label>
                                    <input type="text" class="form-control" id="hero-cta-secondary" value="View Our Projects">
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Eyebrow Badge Text</label>
                                    <input type="text" class="form-control" id="hero-badge" value="Trusted Since 2015">
                                </div>
                            </div>

                            <hr class="my-4">
                            <p class="settings-sub-header">Hero Stat Cards</p>
                            <div class="row g-3" id="hero-stats-list">
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="5,000+">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Cameras Installed">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)" title="Remove"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="800+">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Solar Street Lights">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)" title="Remove"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="12 Years">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="of Excellence">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)" title="Remove"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="Gov't &amp; Private">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Trusted">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)" title="Remove"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn-add-row mt-3" onclick="addStatRow()">
                                <span class="material-symbols-outlined">add</span> Add Stat Card
                            </button>

                        </div>
                    </div>

                    <!-- Stats Bar -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">bar_chart</span>
                            Stats Bar
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">The 4-column stats bar below the hero.</p>
                            <div class="row g-3" id="stats-bar-list">
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="Since 2015">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Years of Service">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="5,800+">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Installations Completed">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="500+">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Satisfied Customers">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-edit-row">
                                        <input type="text" class="form-control form-control-sm" placeholder="Value" value="Region IV-A &amp; NCR">
                                        <input type="text" class="form-control form-control-sm" placeholder="Label" value="Coverage Areas">
                                        <button class="btn-icon-remove" onclick="removeStatRow(this)"><span class="material-symbols-outlined">close</span></button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn-add-row mt-3" onclick="addStatsBarRow()">
                                <span class="material-symbols-outlined">add</span> Add Stat
                            </button>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">home_repair_service</span>
                            Services Section
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="settings-label">Section Heading</label>
                                    <input type="text" class="form-control" value="Comprehensive Solutions for Your Security and Energy Needs">
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">Section Subtitle</label>
                                    <input type="text" class="form-control" value="We specialize in four core services designed to protect your property and reduce your energy costs.">
                                </div>
                            </div>
                            <hr class="my-4">
                            <p class="settings-sub-header">Service Cards</p>
                            <div class="d-flex flex-column gap-3" id="services-list">

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Title" value="CCTV Surveillance"></div>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" placeholder="Short description" value="HD & IP camera systems with 24/7 monitoring, remote access, and intelligent analytics."></div>
                                        <div class="col-12">
                                            <label class="settings-label fs-11">Features (one per line)</label>
                                            <textarea class="form-control form-control-sm" rows="2">IP & Analog HD
Mobile App Access
Cloud Recording</textarea>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Title" value="Solar Energy Systems"></div>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" placeholder="Short description" value="On-grid, off-grid, and hybrid solar power solutions that cut electric bills."></div>
                                        <div class="col-12">
                                            <textarea class="form-control form-control-sm" rows="2">Residential & Commercial
Battery Backup
Net Metering</textarea>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Title" value="Street Lights"></div>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" placeholder="Short description" value="Strong and bright street lights for roads, subdivisions, and barangays."></div>
                                        <div class="col-12">
                                            <textarea class="form-control form-control-sm" rows="2">Bright LED Light
Auto On at Night
Rainproof Design</textarea>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Title" value="Public Address Systems"></div>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" placeholder="Short description" value="Outdoor & indoor PA systems for plazas, schools, and LGUs."></div>
                                        <div class="col-12">
                                            <textarea class="form-control form-control-sm" rows="2">Wireless Mics
Weatherproof
Long-Range Coverage</textarea>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                            </div>
                            <button class="btn-add-row mt-3" onclick="addServiceRow()">
                                <span class="material-symbols-outlined">add</span> Add Service
                            </button>
                        </div>
                    </div>

                    <!-- CTA Banner -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">campaign</span>
                            CTA Banner (Bottom)
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="settings-label">CTA Headline</label>
                                    <input type="text" class="form-control" value="Ready to Secure and Power Your Property?">
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">CTA Subtext</label>
                                    <textarea class="form-control" rows="2">Schedule your free site assessment today. Our team will check your location and recommend the best solution for your needs.</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">CTA Footnote</label>
                                    <input type="text" class="form-control" value="Free consultation • Transparent pricing • No hidden fees">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonials -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">format_quote</span>
                            Testimonials
                        </div>
                        <div class="settings-card-body">
                            <div class="d-flex flex-column gap-3" id="testimonials-list">

                                <div class="testimonial-edit-row">
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Reviewer name" value="Engr. Roberto Cruz"></div>
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Role / Company" value="Operations Manager, Manufacturing Plant"></div>
                                        <div class="col-12"><textarea class="form-control form-control-sm" rows="2" placeholder="Quote text">A We Green installed CCTV across our entire facility. Quality of work is excellent and after-sales support is top-notch.</textarea></div>
                                    </div>
                                    <button class="btn-icon-remove align-self-start mt-1" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="testimonial-edit-row">
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Reviewer name" value="Hon. Maria Santos"></div>
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Role / Company" value="Barangay Captain, Bulacan"></div>
                                        <div class="col-12"><textarea class="form-control form-control-sm" rows="2" placeholder="Quote text">Our solar street lights have been running flawlessly for 3 years. Best decision our barangay ever made.</textarea></div>
                                    </div>
                                    <button class="btn-icon-remove align-self-start mt-1" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="testimonial-edit-row">
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Reviewer name" value="Anna Reyes"></div>
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Role / Company" value="Homeowner, Quezon City"></div>
                                        <div class="col-12"><textarea class="form-control form-control-sm" rows="2" placeholder="Quote text">Professional team, fair pricing, and they actually deliver on time. Highly recommend their solar systems.</textarea></div>
                                    </div>
                                    <button class="btn-icon-remove align-self-start mt-1" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                            </div>
                            <button class="btn-add-row mt-3" onclick="addTestimonialRow()">
                                <span class="material-symbols-outlined">add</span> Add Testimonial
                            </button>
                        </div>
                    </div>

                </div><!-- /panel-landing-page -->


                <!-- ════════════════════════════════
                     PANEL 2: ASSESSMENT SETTINGS
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-assessment">

                    <!-- Client Types -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">groups</span>
                            Client Types
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">These appear as the selection cards in Step 1 of the assessment booking wizard.</p>
                            <div class="d-flex flex-column gap-2" id="client-types-list">
                                <div class="tag-edit-row">
                                    <span class="material-symbols-outlined tag-drag">drag_indicator</span>
                                    <input type="text" class="form-control form-control-sm" value="Residential">
                                    <input type="text" class="form-control form-control-sm" placeholder="Description" value="Individual homeowner">
                                    <select class="form-select form-select-sm tag-size-select">
                                        <option value="small" selected>Small (half-day)</option>
                                        <option value="large">Large (full-day)</option>
                                    </select>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="tag-edit-row">
                                    <span class="material-symbols-outlined tag-drag">drag_indicator</span>
                                    <input type="text" class="form-control form-control-sm" value="Subdivision">
                                    <input type="text" class="form-control form-control-sm" placeholder="Description" value="Gated community or HOA">
                                    <select class="form-select form-select-sm tag-size-select">
                                        <option value="small">Small (half-day)</option>
                                        <option value="large" selected>Large (full-day)</option>
                                    </select>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="tag-edit-row">
                                    <span class="material-symbols-outlined tag-drag">drag_indicator</span>
                                    <input type="text" class="form-control form-control-sm" value="Commercial">
                                    <input type="text" class="form-control form-control-sm" placeholder="Description" value="Business or company">
                                    <select class="form-select form-select-sm tag-size-select">
                                        <option value="small">Small (half-day)</option>
                                        <option value="large" selected>Large (full-day)</option>
                                    </select>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="tag-edit-row">
                                    <span class="material-symbols-outlined tag-drag">drag_indicator</span>
                                    <input type="text" class="form-control form-control-sm" value="Government">
                                    <input type="text" class="form-control form-control-sm" placeholder="Description" value="Barangay, school, government office">
                                    <select class="form-select form-select-sm tag-size-select">
                                        <option value="small">Small (half-day)</option>
                                        <option value="large" selected>Large (full-day)</option>
                                    </select>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                            </div>
                            <button class="btn-add-row mt-3" onclick="addClientTypeRow()">
                                <span class="material-symbols-outlined">add</span> Add Client Type
                            </button>
                        </div>
                    </div>

                    <!-- Establishment Types -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">domain</span>
                            Establishment Types
                            <span class="settings-badge ms-2">Per client type</span>
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">Establishment types shown when a client type is selected. Each row belongs to a client type.</p>

                            <ul class="nav nav-tabs mb-3" id="estabTabs">
                                <li class="nav-item"><button class="nav-link active" onclick="switchEstabTab(this,'Residential')">Residential</button></li>
                                <li class="nav-item"><button class="nav-link" onclick="switchEstabTab(this,'Subdivision')">Subdivision</button></li>
                                <li class="nav-item"><button class="nav-link" onclick="switchEstabTab(this,'Commercial')">Commercial</button></li>
                                <li class="nav-item"><button class="nav-link" onclick="switchEstabTab(this,'Government')">Government</button></li>
                            </ul>

                            <div id="estab-panel-Residential">
                                <div class="d-flex flex-column gap-2">
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Home / Residence"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Apartment / Condominium"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Townhouse"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                </div>
                                <button class="btn-add-row mt-2" onclick="addEstabRow('Residential')"><span class="material-symbols-outlined">add</span> Add</button>
                            </div>

                            <div id="estab-panel-Subdivision" style="display:none;">
                                <div class="d-flex flex-column gap-2">
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Subdivision / HOA"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Condominium Complex"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                </div>
                                <button class="btn-add-row mt-2" onclick="addEstabRow('Subdivision')"><span class="material-symbols-outlined">add</span> Add</button>
                            </div>

                            <div id="estab-panel-Commercial" style="display:none;">
                                <div class="d-flex flex-column gap-2">
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Office / Commercial Space"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Warehouse / Industrial"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Mall / Shopping Center"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Restaurant / Café"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Hotel / Resort"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Factory / Plant"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                </div>
                                <button class="btn-add-row mt-2" onclick="addEstabRow('Commercial')"><span class="material-symbols-outlined">add</span> Add</button>
                            </div>

                            <div id="estab-panel-Government" style="display:none;">
                                <div class="d-flex flex-column gap-2">
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Barangay Hall"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="School / University"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Hospital / Health Center"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Sports Facility / Gym"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Park / Public Space"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large" selected>Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                    <div class="tag-edit-row"><span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" value="Police Station / Fire"><select class="form-select form-select-sm tag-size-select">
                                            <option value="small" selected>Small</option>
                                            <option value="large">Large</option>
                                        </select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button></div>
                                </div>
                                <button class="btn-add-row mt-2" onclick="addEstabRow('Government')"><span class="material-symbols-outlined">add</span> Add</button>
                            </div>

                        </div>
                    </div>

                    <!-- Assessment Services -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">handyman</span>
                            Assessment Services
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">These are the service checkboxes in Step 3 of the booking wizard. Each service can optionally have sub-types.</p>
                            <div class="d-flex flex-column gap-3" id="assessment-services-list">

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Service name" value="CCTV Setup"></div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mt-1">
                                                <input class="form-check-input" type="checkbox" checked id="cctv-has-subtypes">
                                                <label class="form-check-label small" for="cctv-has-subtypes">Has sub-types</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="settings-label fs-11">Sub-types (one per line)</label>
                                            <textarea class="form-control form-control-sm" rows="2">Installation
Relocation
Rehabilitation
Restoration</textarea>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Service name" value="Solar Setup"></div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mt-1"><input class="form-check-input" type="checkbox" id="solar-has-subtypes"><label class="form-check-label small" for="solar-has-subtypes">Has sub-types</label></div>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Service name" value="Street Light"></div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mt-1"><input class="form-check-input" type="checkbox" id="streetlight-has-subtypes"><label class="form-check-label small" for="streetlight-has-subtypes">Has sub-types</label></div>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                                <div class="service-edit-row">
                                    <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                    <div class="flex-grow-1 row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Service name" value="Public Address"></div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mt-1"><input class="form-check-input" type="checkbox" id="pa-has-subtypes"><label class="form-check-label small" for="pa-has-subtypes">Has sub-types</label></div>
                                        </div>
                                    </div>
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>

                            </div>
                            <button class="btn-add-row mt-3" onclick="addAssessmentServiceRow()">
                                <span class="material-symbols-outlined">add</span> Add Service
                            </button>
                        </div>
                    </div>

                    <!-- Time Slot Settings -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">schedule</span>
                            Time Slot Settings
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="settings-label">Morning Start</label>
                                    <input type="time" class="form-control" value="08:00">
                                </div>
                                <div class="col-md-3">
                                    <label class="settings-label">Morning End</label>
                                    <input type="time" class="form-control" value="12:00">
                                </div>
                                <div class="col-md-3">
                                    <label class="settings-label">Afternoon Start</label>
                                    <input type="time" class="form-control" value="13:00">
                                </div>
                                <div class="col-md-3">
                                    <label class="settings-label">Afternoon End</label>
                                    <input type="time" class="form-control" value="17:00">
                                </div>
                                <div class="col-12">
                                    <p class="settings-hint">Full Day is automatically applied when multiple services are selected or when a large establishment type is chosen.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /panel-assessment -->


                <!-- ════════════════════════════════
                     PANEL 3: COVERAGE AREAS
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-coverage">

                    <div class="settings-card mb-4">
                        <div class="settings-card-header d-flex justify-content-between">
                            <div>
                                <span class="material-symbols-outlined">public</span>
                                Allowed Regions &amp; Provinces
                            </div>
                            <button class="btn btn-sm btn-success">Add coverage</button>
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">These provinces appear in the dropdown on Step 4 (Your Details) of the assessment booking form. Only checked provinces will be available to clients.</p>

                            <div class="row g-4">

                                <!-- NCR -->
                                <div class="col-md-6">
                                    <div class="region-block">
                                        <div class="region-header">
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" class="form-check-input me-2" id="region-ncr" checked onchange="toggleRegion('ncr',this)">
                                                    <label for="region-ncr" class="fw-semibold small mb-0">NCR (Metro Manila)</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove ms-3" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="region-body" id="region-ncr-body">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-metro-manila">
                                                    <label class="form-check-label small mb-0" for="prov-metro-manila">Pasig</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-metro-manila-2">
                                                    <label class="form-check-label small mb-0" for="prov-metro-manila-2">Pasay</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CALABARZON -->
                                <div class="col-md-6">
                                    <div class="region-block">
                                        <div class="region-header d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" class="form-check-input me-2" id="region-4a" checked onchange="toggleRegion('4a',this)">
                                                <label for="region-4a" class="fw-semibold small mb-0">Region IV-A (CALABARZON)</label>
                                            </div>
                                            <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>
                                        <div class="region-body" id="region-4a-body">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-batangas">
                                                    <label class="form-check-label small mb-0" for="prov-batangas">Batangas</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-cavite">
                                                    <label class="form-check-label small mb-0" for="prov-cavite">Cavite</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-laguna">
                                                    <label class="form-check-label small mb-0" for="prov-laguna">Laguna</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-quezon">
                                                    <label class="form-check-label small mb-0" for="prov-quezon">Quezon</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" checked id="prov-rizal">
                                                    <label class="form-check-label small mb-0" for="prov-rizal">Rizal</label>
                                                </div>
                                                <button type="button" class="btn-icon-remove" onclick="removeRow(this)">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Coverage Display Text -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">edit_location</span>
                            Coverage Display Text
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">These labels appear on the landing page and footer.</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="settings-label">Stats Bar Coverage Label</label>
                                    <input type="text" class="form-control" value="Region IV-A & NCR">
                                    <p class="settings-hint">Shown in the stats bar under "Coverage Areas"</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Footer Coverage Text</label>
                                    <input type="text" class="form-control" value="Serving Region IV-A & NCR">
                                    <p class="settings-hint">Shown in the footer contact section</p>
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">Office Location Description</label>
                                    <textarea class="form-control" rows="2">Strategically based in Gen. Mariano Alvarez, Cavite — well-positioned to serve communities and projects across Region IV-A and Metro Manila.</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /panel-coverage -->


                <!-- ════════════════════════════════
                     PANEL 4: COMPANY INFO
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-company">

                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">apartment</span>
                            Company Information
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-12 mb-2">
                                    <label class="settings-label">Company Logo</label>
                                    <div class="image-upload-row">
                                        <div class="image-preview-box image-preview-box--logo" id="preview-logo">
                                            <img src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="Logo preview" class="image-preview-thumb"
                                                style="object-fit:contain; padding:8px;">
                                            <div class="image-preview-overlay">
                                                <span class="material-symbols-outlined">edit</span>
                                                Change
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm" accept="image/*,image/svg+xml"
                                                onchange="previewImage(this,'preview-logo')">
                                            <p class="settings-hint">SVG preferred. PNG/WebP also accepted. Shown in navbar and footer.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Company Name</label>
                                    <input type="text" class="form-control" value="A We Green Enterprise">
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Tagline</label>
                                    <input type="text" class="form-control" value="We Bring The Right Technology">
                                </div>
                                <div class="col-md-4">
                                    <label class="settings-label">Year Founded</label>
                                    <input type="number" class="form-control" value="2015">
                                </div>
                                <div class="col-md-8">
                                    <label class="settings-label">Short Description (Footer)</label>
                                    <input type="text" class="form-control" value="We bring the right technology to communities — through CCTV, solar, and public address solutions since 2015.">
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">Main Office Address</label>
                                    <textarea class="form-control" rows="2">Alta Tierra Homes Phase 4, Blk 51 Lot 30
Brgy. A. Olaes, Gen. Mariano Alvarez, Cavite 4117</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">Satellite Office Address (optional)</label>
                                    <textarea class="form-control" rows="2">Alta Tierra Homes Phase 5, Blk 14 Lot 5
Brgy. A. Olaes, Gen. Mariano Alvarez, Cavite 4117</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">schedule</span>
                            Operating Hours
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="settings-label">Open Days</label>
                                    <input type="text" class="form-control" value="Mon – Sat">
                                </div>
                                <div class="col-md-4">
                                    <label class="settings-label">Opening Time</label>
                                    <input type="time" class="form-control" value="08:00">
                                </div>
                                <div class="col-md-4">
                                    <label class="settings-label">Closing Time</label>
                                    <input type="time" class="form-control" value="17:00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">share</span>
                            Social Media Links
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="settings-label"><i class="bi bi-facebook me-1"></i> Facebook URL</label>
                                    <input type="url" class="form-control" placeholder="https://facebook.com/...">
                                </div>
                                <div class="col-md-4">
                                    <label class="settings-label"><i class="bi bi-instagram me-1"></i> Instagram URL</label>
                                    <input type="url" class="form-control" placeholder="https://instagram.com/...">
                                </div>
                                <div class="col-md-4">
                                    <label class="settings-label"><i class="bi bi-twitter-x me-1"></i> X (Twitter) URL</label>
                                    <input type="url" class="form-control" placeholder="https://x.com/...">
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /panel-company -->


                <!-- ════════════════════════════════
                     PANEL 5: CONTACT DETAILS
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-contact">

                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">phone_in_talk</span>
                            Phone Numbers
                        </div>
                        <div class="settings-card-body">
                            <div class="d-flex flex-column gap-2" id="phone-list">
                                <div class="tag-edit-row">
                                    <input type="text" class="form-control form-control-sm" placeholder="Label" value="Smart">
                                    <input type="text" class="form-control form-control-sm" placeholder="Number" value="0998 884 5671">
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="tag-edit-row">
                                    <input type="text" class="form-control form-control-sm" placeholder="Label" value="Globe">
                                    <input type="text" class="form-control form-control-sm" placeholder="Number" value="0917 752 3343">
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="tag-edit-row">
                                    <input type="text" class="form-control form-control-sm" placeholder="Label" value="Landline">
                                    <input type="text" class="form-control form-control-sm" placeholder="Number" value="046 443 6374">
                                    <button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>
                                </div>
                            </div>
                            <button class="btn-add-row mt-3" onclick="addPhoneRow()">
                                <span class="material-symbols-outlined">add</span> Add Phone Number
                            </button>
                        </div>
                    </div>

                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">mail</span>
                            Email Address
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="settings-label">Primary Email</label>
                                    <input type="email" class="form-control" value="awegreenenterprise@gmail.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="settings-label">Secondary Email (optional)</label>
                                    <input type="email" class="form-control" placeholder="e.g. support@awegreen.ph">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">map</span>
                            Google Maps Embed
                        </div>
                        <div class="settings-card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="settings-label">Map Embed URL</label>
                                    <input type="url" class="form-control" value="https://www.google.com/maps?q=Alta+Tierra+Homes+Phase+4+Blk+51+Lot+30+Brgy+A+Olaes+Gen+Mariano+Alvarez+Cavite+4117&output=embed">
                                    <p class="settings-hint">Paste the embed URL from Google Maps. Go to Google Maps → Share → Embed a map → copy the src URL.</p>
                                </div>
                                <div class="col-12">
                                    <label class="settings-label">Google Maps Link (Open in Maps button)</label>
                                    <input type="url" class="form-control" value="https://www.google.com/maps/search/?api=1&query=Alta+Tierra+Homes+Phase+4+Blk+51+Lot+30+Brgy+A+Olaes+Gen+Mariano+Alvarez+Cavite+4117">
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /panel-contact -->


                <!-- ════════════════════════════════
                     PANEL 6: LEGAL & POLICIES
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-legal">

                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">description</span>
                            Terms of Service
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">This content appears in the "Terms of Service" modal on the client registration page.</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="settings-label">Last Updated Date</label>
                                    <input type="date" class="form-control" value="2025-01-01">
                                </div>
                            </div>
                            <hr class="my-3">
                            <label class="settings-label">Full Terms of Service Text</label>
                            <p class="settings-hint mb-2">Use <code>##</code> at the start of a line to mark it as a section heading (e.g. <code>## 1. Acceptance of Terms</code>).</p>
                            <textarea class="form-control" rows="18" id="terms-content">## 1. Acceptance of Terms
By creating an account and using the A We Green Enterprise platform ("Service"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use the Service.

## 2. Use of the Service
The Service is intended for clients and partners of A We Green Enterprise to monitor and manage their CCTV, security, and solar installation projects. You agree to use the Service only for lawful purposes and in accordance with these Terms.
- You must have the legal capacity to agree to these Terms. If you are using the Service on behalf of another person or organization, you confirm that you are authorized to do so.
- You are responsible for maintaining the confidentiality of your login credentials.
- You agree not to share your account with any third party.

## 3. Account Registration
You agree to provide accurate, current, and complete information during registration and to update such information to keep it accurate. A We Green Enterprise reserves the right to suspend or terminate accounts with inaccurate information.

## 4. Intellectual Property
All content, trademarks, logos, and data on this platform are the property of A We Green Enterprise or its licensors. You may not reproduce, distribute, or create derivative works without our express written permission.

## 5. Limitation of Liability
A We Green Enterprise shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service. Our total liability shall not exceed the amount paid by you, if any, for access to the Service.

## 6. Termination
We reserve the right to suspend or terminate your access to the Service at our sole discretion, without notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties.

## 7. Changes to Terms
We may update these Terms from time to time. Continued use of the Service after changes are posted constitutes your acceptance of the revised Terms.

## 8. Contact Us
For questions about these Terms, contact us at support@awegreenenterprise.com.</textarea>
                        </div>
                    </div>

                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">privacy_tip</span>
                            Privacy Policy
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">This content appears in the "Privacy Policy" modal on the client registration page.</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="settings-label">Last Updated Date</label>
                                    <input type="date" class="form-control" value="2025-01-01">
                                </div>
                            </div>
                            <hr class="my-3">
                            <label class="settings-label">Full Privacy Policy Text</label>
                            <p class="settings-hint mb-2">Use <code>##</code> at the start of a line to mark it as a section heading.</p>
                            <textarea class="form-control" rows="20" id="privacy-content">A We Green Enterprise ("we", "us", or "our") is committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our platform.

## 1. Information We Collect
We collect information you provide directly to us when registering or using the Service, including:
- Full name, email address, and phone number
- Account credentials (stored securely, passwords are hashed)
- Project-related communications and support requests
- Usage data and device/browser information for analytics

## 2. How We Use Your Information
We use the information collected to:
- Create and manage your account
- Provide project tracking and monitoring features
- Send service-related notifications and updates
- Respond to support inquiries
- Improve and secure the platform

## 3. Sharing of Information
We do not sell or rent your personal information to third parties. We may share data with trusted service providers who assist in operating our platform, subject to confidentiality agreements. We may also disclose information if required by law.

## 4. Data Security
We implement industry-standard security measures including encryption, access controls, and regular audits to protect your information. However, no method of transmission over the internet is 100% secure.

## 5. Data Retention
We retain your personal data for as long as your account is active or as needed to provide services. You may request deletion of your account and associated data by contacting us.

## 6. Your Rights
Under applicable Philippine data privacy laws (Republic Act No. 10173), you have the right to access, correct, or request deletion of your personal data. To exercise these rights, contact our Data Protection Officer.

## 7. Cookies
We use cookies and similar technologies to maintain sessions and improve user experience. You may disable cookies in your browser settings, though some features may not function properly as a result.

## 8. Contact Us
For privacy-related concerns, reach us at privacy@awegreenenterprise.com.</textarea>
                        </div>
                    </div>

                </div><!-- /panel-legal -->

            </div><!-- /col-lg-9 -->
        </div><!-- /row -->

        <!-- Save toast -->
        <div class="position-fixed bottom-0 end-0 p-3 z-1090">
            <div id="saveToast" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-18">check_circle</span>
                        Settings saved successfully!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        /* ── TAB SWITCHING ── */
        function switchTab(link, panel) {
            document.querySelectorAll('.settings-nav-link').forEach(l => l.classList.remove('active'));
            document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
            link.classList.add('active');
            document.getElementById('panel-' + panel).classList.add('active');
            return false;
        }

        /* ── ESTAB TAB SWITCHING ── */
        function switchEstabTab(btn, type) {
            document.querySelectorAll('#estabTabs .nav-link').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            ['Residential', 'Subdivision', 'Commercial', 'Government'].forEach(t => {
                const el = document.getElementById('estab-panel-' + t);
                if (el) el.style.display = (t === type) ? 'block' : 'none';
            });
        }

        /* ── REGION TOGGLE ── */
        function toggleRegion(id, checkbox) {
            const body = document.getElementById('region-' + id + '-body');
            if (!body) return;
            const checkboxes = body.querySelectorAll('input[type="checkbox"]');
            if (checkbox.checked) {
                body.classList.remove('disabled');
                checkboxes.forEach(c => c.disabled = false);
            } else {
                body.classList.add('disabled');
                checkboxes.forEach(c => {
                    c.disabled = true;
                    c.checked = false;
                });
            }
        }

        /* ── ADD/REMOVE ROW HELPERS ── */
        function removeRow(btn) {
            btn.closest('.tag-edit-row, .service-edit-row, .testimonial-edit-row, .stat-edit-row, .col-md-6')?.remove();
        }

        function removeStatRow(btn) {
            btn.closest('.stat-edit-row')?.closest('.col-md-6')?.remove();
        }

        function addStatRow() {
            const list = document.getElementById('hero-stats-list');
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `<div class="stat-edit-row"><input type="text" class="form-control form-control-sm" placeholder="Value"><input type="text" class="form-control form-control-sm" placeholder="Label"><button class="btn-icon-remove" onclick="removeStatRow(this)"><span class="material-symbols-outlined">close</span></button></div>`;
            list.appendChild(col);
        }

        function addStatsBarRow() {
            const list = document.getElementById('stats-bar-list');
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `<div class="stat-edit-row"><input type="text" class="form-control form-control-sm" placeholder="Value"><input type="text" class="form-control form-control-sm" placeholder="Label"><button class="btn-icon-remove" onclick="removeStatRow(this)"><span class="material-symbols-outlined">close</span></button></div>`;
            list.appendChild(col);
        }

        function addServiceRow() {
            const list = document.getElementById('services-list');
            const row = document.createElement('div');
            row.className = 'service-edit-row';
            row.innerHTML = `<div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div><div class="flex-grow-1 row g-2"><div class="col-md-4"><input type="text" class="form-control form-control-sm" placeholder="Service title"></div><div class="col-md-8"><input type="text" class="form-control form-control-sm" placeholder="Short description"></div><div class="col-12"><label class="settings-label fs-11">Features (one per line)</label><textarea class="form-control form-control-sm" rows="2" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea></div></div><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>`;
            list.appendChild(row);
        }

        function addTestimonialRow() {
            const list = document.getElementById('testimonials-list');
            const row = document.createElement('div');
            row.className = 'testimonial-edit-row';
            row.innerHTML = `<div class="flex-grow-1 row g-2"><div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Reviewer name"></div><div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Role / Company"></div><div class="col-12"><textarea class="form-control form-control-sm" rows="2" placeholder="Quote text"></textarea></div></div><button class="btn-icon-remove align-self-start mt-1" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>`;
            list.appendChild(row);
        }

        function addClientTypeRow() {
            const list = document.getElementById('client-types-list');
            const row = document.createElement('div');
            row.className = 'tag-edit-row';
            row.innerHTML = `<span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" placeholder="Type name"><input type="text" class="form-control form-control-sm" placeholder="Description"><select class="form-select form-select-sm tag-size-select"><option value="small">Small (half-day)</option><option value="large">Large (full-day)</option></select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>`;
            list.appendChild(row);
        }

        function addEstabRow(type) {
            const panel = document.getElementById('estab-panel-' + type);
            const list = panel.querySelector('.d-flex.flex-column');
            const row = document.createElement('div');
            row.className = 'tag-edit-row';
            row.innerHTML = `<span class="material-symbols-outlined tag-drag">drag_indicator</span><input type="text" class="form-control form-control-sm" placeholder="Establishment name"><select class="form-select form-select-sm tag-size-select"><option value="small">Small</option><option value="large">Large</option></select><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>`;
            list.appendChild(row);
        }

        function addAssessmentServiceRow() {
            const list = document.getElementById('assessment-services-list');
            const uid = Date.now();
            const row = document.createElement('div');
            row.className = 'service-edit-row';
            row.innerHTML = `<div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div><div class="flex-grow-1 row g-2"><div class="col-md-6"><input type="text" class="form-control form-control-sm" placeholder="Service name"></div><div class="col-md-6"><div class="form-check form-switch mt-1"><input class="form-check-input" type="checkbox" id="svc-${uid}"><label class="form-check-label small" for="svc-${uid}">Has sub-types</label></div></div></div><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>`;
            list.appendChild(row);
        }

        function addPhoneRow() {
            const list = document.getElementById('phone-list');
            const row = document.createElement('div');
            row.className = 'tag-edit-row';
            row.innerHTML = `<input type="text" class="form-control form-control-sm" placeholder="Label (e.g. Smart)"><input type="text" class="form-control form-control-sm" placeholder="Number"><button class="btn-icon-remove" onclick="removeRow(this)"><span class="material-symbols-outlined">close</span></button>`;
            list.appendChild(row);
        }

        /* ── SAVE ── */
        function saveAllSettings() {
            const toast = new bootstrap.Toast(document.getElementById('saveToast'));
            toast.show();
        }
    </script>
@endsection