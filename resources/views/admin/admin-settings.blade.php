@extends('layouts.admin')

@section('title', 'Settings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-settings.css') }}">
@endsection

@section('page-title', 'Settings')
@section('page-subtitle', 'The single source of truth for how SchedQuote operates')

@section('content')

    <div class="container-xxl px-4 py-4">

        <div class="row g-4">

            <!-- ── LEFT: SETTINGS NAV ── -->
            <div class="col-lg-3">
                <div class="settings-nav-card">
                    <p class="settings-nav-title">Configuration</p>
                    <a href="#company-information" class="settings-nav-link active" onclick="switchTab(this,'company-information')">
                        <span class="material-symbols-outlined">business</span>
                        Company Information
                    </a>
                    <a href="#assessment-scheduling" class="settings-nav-link" onclick="switchTab(this,'assessment-scheduling')">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Assessment &amp; Scheduling
                    </a>
                    <a href="#quotation-configuration" class="settings-nav-link" onclick="switchTab(this,'quotation-configuration')">
                        <span class="material-symbols-outlined">request_quote</span>
                        Quotation Configuration
                    </a>
                    <a href="#legal-policies" class="settings-nav-link" onclick="switchTab(this,'legal-policies')">
                        <span class="material-symbols-outlined">gavel</span>
                        Legal &amp; Policies
                    </a>
                    <a href="#website-content" class="settings-nav-link" onclick="switchTab(this,'website-content')">
                        <span class="material-symbols-outlined">web</span>
                        Website Content
                    </a>
                </div>
            </div>

            <!-- ── RIGHT: SETTINGS PANELS ── -->
            <div class="col-lg-9">

                <!-- ════════════════════════════════
                     PANEL: COMPANY INFORMATION (live)
                     ════════════════════════════════ -->
                <div class="settings-panel active" id="panel-company-information">

                    <form method="POST" action="{{ route('admin-settings.company.update') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Company Details -->
                        <div class="settings-card mb-4">
                            <div class="settings-card-header">
                                <span class="material-symbols-outlined">apartment</span>
                                Company Details
                            </div>
                            <div class="settings-card-body">
                                <div class="row g-3">
                                    <div class="col-12 mb-2">
                                        <label class="settings-label">Company Logo</label>
                                        <div class="image-upload-row">
                                            <div class="image-preview-box image-preview-box--logo" id="preview-logo">
                                                <img src="{{ asset($company['company_logo_path'] ?? 'css/images/AWeGreen-Logo.svg') }}"
                                                    alt="Logo preview" class="image-preview-thumb" style="object-fit:contain; padding:8px;">
                                                <div class="image-preview-overlay">
                                                    <span class="material-symbols-outlined">edit</span>
                                                    Change
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="file" name="logo" class="form-control form-control-sm" accept="image/*,image/svg+xml"
                                                    onchange="previewImage(this,'preview-logo')">
                                                <p class="settings-hint">SVG preferred. PNG/WebP also accepted. Max 3MB. Shown in navbar, footer, and PDFs.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Company Name</label>
                                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $company['company_name'] ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Tagline</label>
                                        <input type="text" name="company_tagline" class="form-control" value="{{ old('company_tagline', $company['company_tagline'] ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="settings-label">Year Founded</label>
                                        <input type="number" name="company_founded_year" class="form-control" value="{{ old('company_founded_year', $company['company_founded_year'] ?? '') }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="settings-label">Short Description (Footer)</label>
                                        <input type="text" name="company_description" class="form-control" value="{{ old('company_description', $company['company_description'] ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="settings-card mb-4">
                            <div class="settings-card-header">
                                <span class="material-symbols-outlined">location_on</span>
                                Address
                            </div>
                            <div class="settings-card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="settings-label">Main Office Address</label>
                                        <textarea name="company_address_main" class="form-control" rows="2">{{ old('company_address_main', $company['company_address_main'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="settings-label">Satellite / Branch Address (optional)</label>
                                        <textarea name="company_address_satellite" class="form-control" rows="2">{{ old('company_address_satellite', $company['company_address_satellite'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="settings-card mb-4">
                            <div class="settings-card-header">
                                <span class="material-symbols-outlined">contact_phone</span>
                                Contact Information
                            </div>
                            <div class="settings-card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="settings-label">Primary Phone (e.g. Smart)</label>
                                        <input type="text" name="company_phone_primary" class="form-control" value="{{ old('company_phone_primary', $company['company_phone_primary'] ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="settings-label">Secondary Phone (e.g. Globe)</label>
                                        <input type="text" name="company_phone_secondary" class="form-control" value="{{ old('company_phone_secondary', $company['company_phone_secondary'] ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="settings-label">Landline (optional)</label>
                                        <input type="text" name="company_phone_landline" class="form-control" value="{{ old('company_phone_landline', $company['company_phone_landline'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Primary Email</label>
                                        <input type="email" name="company_email_primary" class="form-control" value="{{ old('company_email_primary', $company['company_email_primary'] ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Secondary Email (optional)</label>
                                        <input type="email" name="company_email_secondary" class="form-control" value="{{ old('company_email_secondary', $company['company_email_secondary'] ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="settings-card mb-4">
                            <div class="settings-card-header">
                                <span class="material-symbols-outlined">schedule</span>
                                Business Hours
                            </div>
                            <div class="settings-card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="settings-label">Working Days</label>
                                        <input type="text" name="company_hours_days" class="form-control" value="{{ old('company_hours_days', $company['company_hours_days'] ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="settings-label">Opening Time</label>
                                        <input type="time" name="company_hours_open" class="form-control" value="{{ old('company_hours_open', $company['company_hours_open'] ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="settings-label">Closing Time</label>
                                        <input type="time" name="company_hours_close" class="form-control" value="{{ old('company_hours_close', $company['company_hours_close'] ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">save</span>
                            Save Company Information
                        </button>
                    </form>

                </div><!-- /panel-company-information -->


                <!-- ════════════════════════════════
                     PANEL: ASSESSMENT & SCHEDULING
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-assessment-scheduling">

                    <div class="alert alert-secondary d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined">construction</span>
                        <div>
                            Changes here apply immediately to the assessment request form clients use. If you turn
                            something off, clients will no longer be able to select it.
                        </div>
                    </div>

                    <!-- Client Types (live) -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">groups</span>
                            Client Types
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">
                                These are the options clients choose from when requesting an assessment. Turning one
                                off removes it from the request form — clients won't be able to select it.
                            </p>
                            <div class="d-flex flex-column gap-2">
                                @foreach ($clientTypes as $type)
                                    <form method="POST" action="{{ route('admin-settings.client-types.update', $type) }}"
                                        class="tag-edit-row">
                                        @csrf
                                        @method('PATCH')
                                        <span class="material-symbols-outlined tag-drag">{{ $type->icon ?? 'category' }}</span>
                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $type->name }}" required>
                                        <input type="text" name="description" class="form-control form-control-sm" placeholder="Description" value="{{ $type->description }}">
                                        <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon" value="{{ $type->icon }}" style="max-width:110px;">
                                        <select name="default_size" class="form-select form-select-sm tag-size-select">
                                            <option value="small" @selected($type->default_size === 'small')>Small (half-day)</option>
                                            <option value="large" @selected($type->default_size === 'large')>Large (full-day)</option>
                                        </select>
                                        <div class="form-check form-switch mb-0" title="Active">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" @checked($type->active)>
                                        </div>
                                        <button type="submit" class="btn-icon-remove" title="Save">
                                            <span class="material-symbols-outlined">save</span>
                                        </button>
                                    </form>
                                @endforeach
                            </div>

                            <form method="POST" action="{{ route('admin-settings.client-types.store') }}" class="tag-edit-row mt-3">
                                @csrf
                                <span class="material-symbols-outlined tag-drag">add</span>
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="New client type name" required>
                                <input type="text" name="description" class="form-control form-control-sm" placeholder="Description">
                                <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon (optional)" style="max-width:110px;">
                                <select name="default_size" class="form-select form-select-sm tag-size-select">
                                    <option value="small">Small (half-day)</option>
                                    <option value="large">Large (full-day)</option>
                                </select>
                                <button type="submit" class="btn-add-row">
                                    <span class="material-symbols-outlined">add</span> Add
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Establishment Types (live) -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">domain</span>
                            Establishment Types
                            <span class="settings-badge ms-2">Per client type</span>
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">Establishment types shown once a client type is selected.</p>

                            <ul class="nav nav-tabs mb-3">
                                @foreach ($clientTypes as $i => $type)
                                    <li class="nav-item">
                                        <button type="button" class="nav-link @if ($i === 0) active @endif" onclick="switchEstabTab(this,'{{ $type->id }}')">{{ $type->name }}</button>
                                    </li>
                                @endforeach
                            </ul>

                            @foreach ($clientTypes as $i => $type)
                                <div id="estab-panel-{{ $type->id }}" style="@if ($i !== 0) display:none; @endif">
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($type->establishmentTypes as $estab)
                                            <form method="POST" action="{{ route('admin-settings.establishment-types.update', $estab) }}" class="tag-edit-row">
                                                @csrf
                                                @method('PATCH')
                                                <span class="material-symbols-outlined tag-drag">{{ $estab->icon ?? 'category' }}</span>
                                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $estab->name }}" required>
                                                <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon" value="{{ $estab->icon }}" style="max-width:110px;">
                                                <select name="size" class="form-select form-select-sm tag-size-select">
                                                    <option value="small" @selected($estab->size === 'small')>Small</option>
                                                    <option value="large" @selected($estab->size === 'large')>Large</option>
                                                </select>
                                                <div class="form-check form-switch mb-0" title="Active">
                                                    <input class="form-check-input" type="checkbox" name="active" value="1" @checked($estab->active)>
                                                </div>
                                                <button type="submit" class="btn-icon-remove" title="Save">
                                                    <span class="material-symbols-outlined">save</span>
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                    <form method="POST" action="{{ route('admin-settings.establishment-types.store') }}" class="tag-edit-row mt-2">
                                        @csrf
                                        <input type="hidden" name="client_type_id" value="{{ $type->id }}">
                                        <input type="text" name="name" class="form-control form-control-sm" placeholder="New establishment name" required>
                                        <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon (optional)" style="max-width:110px;">
                                        <select name="size" class="form-select form-select-sm tag-size-select">
                                            <option value="small">Small</option>
                                            <option value="large">Large</option>
                                        </select>
                                        <button type="submit" class="btn-add-row"><span class="material-symbols-outlined">add</span> Add</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Assessment Services (live) -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">handyman</span>
                            Assessment Services
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">
                                These are the services clients can request. Turning one off removes it from the
                                request form — clients won't be able to select it.
                            </p>
                            <div class="d-flex flex-column gap-2">
                                @foreach ($services as $service)
                                    <form method="POST" action="{{ route('admin-settings.services.update', $service) }}" class="tag-edit-row">
                                        @csrf
                                        @method('PATCH')
                                        <span class="material-symbols-outlined tag-drag">{{ $service->icon ?? 'build' }}</span>
                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $service->name }}" required>
                                        <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon" value="{{ $service->icon }}" style="max-width:110px;">
                                        <div class="form-check form-switch mb-0" title="Has sub-types">
                                            <input class="form-check-input" type="checkbox" name="has_subtypes" value="1" @checked($service->has_subtypes)>
                                            <label class="form-check-label small">Sub-types</label>
                                        </div>
                                        <div class="form-check form-switch mb-0" title="Active">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" @checked($service->active)>
                                        </div>
                                        <button type="submit" class="btn-icon-remove" title="Save">
                                            <span class="material-symbols-outlined">save</span>
                                        </button>
                                    </form>
                                    @if ($service->has_subtypes)
                                        <div class="ms-4 ps-3 border-start d-flex flex-column gap-2 mb-2">
                                            @foreach ($service->subtypes as $subtype)
                                                <form method="POST" action="{{ route('admin-settings.subtypes.update', $subtype) }}" class="tag-edit-row">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ $subtype->name }}" required>
                                                    <div class="form-check form-switch mb-0" title="Active">
                                                        <input class="form-check-input" type="checkbox" name="active" value="1" @checked($subtype->active)>
                                                    </div>
                                                    <button type="submit" class="btn-icon-remove" title="Save">
                                                        <span class="material-symbols-outlined">save</span>
                                                    </button>
                                                </form>
                                            @endforeach
                                            <form method="POST" action="{{ route('admin-settings.subtypes.store') }}" class="tag-edit-row">
                                                @csrf
                                                <input type="hidden" name="assessment_service_id" value="{{ $service->id }}">
                                                <input type="text" name="name" class="form-control form-control-sm" placeholder="New sub-type for {{ $service->name }}" required>
                                                <button type="submit" class="btn-add-row"><span class="material-symbols-outlined">add</span> Add</button>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <form method="POST" action="{{ route('admin-settings.services.store') }}" class="tag-edit-row mt-3">
                                @csrf
                                <span class="material-symbols-outlined tag-drag">add</span>
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="New service name" required>
                                <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon (optional)" style="max-width:110px;">
                                <div class="form-check form-switch mb-0" title="Has sub-types">
                                    <input class="form-check-input" type="checkbox" name="has_subtypes" value="1">
                                    <label class="form-check-label small">Sub-types</label>
                                </div>
                                <button type="submit" class="btn-add-row">
                                    <span class="material-symbols-outlined">add</span> Add
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Working Days & Slot Capacity (live) -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">schedule</span>
                            Working Days &amp; Slot Capacity
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">
                                Choose which days you're open for assessments and how many can be booked per
                                half-day. Clients can't submit a request for a day you're closed or a slot that's
                                already full.
                            </p>
                            <form method="POST" action="{{ route('admin-settings.scheduling.update') }}">
                                @csrf
                                <span class="settings-sub-header">Working Days</span>
                                <div class="d-flex flex-wrap gap-3 mt-2 mb-3">
                                    @foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $i => $label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $i }}"
                                                id="wd-{{ $i }}" @checked(in_array($i, $workingDays))>
                                            <label class="form-check-label" for="wd-{{ $i }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="settings-label">Max Bookings per Half-Day Slot</label>
                                        <input type="number" name="max_bookings_per_slot" class="form-control" min="1" max="20"
                                            value="{{ $maxBookingsPerSlot }}" required>
                                        <p class="settings-hint">A Full Day request uses up both the morning and afternoon slot for that day.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-4">

                            <span class="settings-sub-header">Blocked Dates (Holidays / One-off Closures)</span>
                            <div class="d-flex flex-column gap-2 mt-2">
                                @forelse ($blockedDates as $blocked)
                                    <div class="tag-edit-row">
                                        <span class="material-symbols-outlined tag-drag">event_busy</span>
                                        <input type="text" class="form-control form-control-sm" value="{{ $blocked->date->format('M j, Y') }}" disabled>
                                        <input type="text" class="form-control form-control-sm" value="{{ $blocked->label }}" disabled>
                                        <form method="POST" action="{{ route('admin-settings.blocked-dates.destroy', $blocked) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-remove" title="Remove">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="settings-hint mb-0">No blocked dates configured.</p>
                                @endforelse
                            </div>
                            <form method="POST" action="{{ route('admin-settings.blocked-dates.store') }}" class="tag-edit-row mt-3">
                                @csrf
                                <span class="material-symbols-outlined tag-drag">add</span>
                                <input type="date" name="date" class="form-control form-control-sm" required>
                                <input type="text" name="label" class="form-control form-control-sm" placeholder="Label (e.g. Christmas Day)">
                                <button type="submit" class="btn-add-row"><span class="material-symbols-outlined">add</span> Add</button>
                            </form>
                        </div>
                    </div>

                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">public</span>
                            Coverage Areas
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">
                                These are the provinces clients can request an assessment from. Turning a province
                                off removes it from the request form — clients won't be able to select it.
                            </p>
                            @foreach ($coverageProvinces->groupBy('region') as $region => $provinces)
                                <p class="settings-sub-header">{{ $region }}</p>
                                <div class="d-flex flex-column gap-2 mb-3">
                                    @foreach ($provinces as $province)
                                        <form method="POST" action="{{ route('admin-settings.coverage-provinces.update', $province) }}" class="tag-edit-row">
                                            @csrf @method('PATCH')
                                            <span class="material-symbols-outlined tag-drag">location_on</span>
                                            <input type="text" name="region" class="form-control form-control-sm" value="{{ $province->region }}" placeholder="Region" style="max-width:220px;">
                                            <input type="text" name="province" class="form-control form-control-sm" value="{{ $province->province }}" required>
                                            <div class="form-check form-switch mb-0" title="Active">
                                                <input class="form-check-input" type="checkbox" name="active" value="1" @checked($province->active)>
                                            </div>
                                            <button type="submit" class="btn-icon-remove" title="Save"><span class="material-symbols-outlined">save</span></button>
                                        </form>
                                    @endforeach
                                </div>
                            @endforeach

                            <form method="POST" action="{{ route('admin-settings.coverage-provinces.store') }}" class="tag-edit-row mt-2">
                                @csrf
                                <span class="material-symbols-outlined tag-drag">add</span>
                                <input type="text" name="region" class="form-control form-control-sm" placeholder="Region (e.g. Region IV-A)" style="max-width:220px;" required>
                                <input type="text" name="province" class="form-control form-control-sm" placeholder="New province name" required>
                                <button type="submit" class="btn-add-row"><span class="material-symbols-outlined">add</span> Add</button>
                            </form>
                        </div>
                    </div>

                </div><!-- /panel-assessment-scheduling -->


                <!-- ════════════════════════════════
                     PANEL: QUOTATION CONFIGURATION
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-quotation-configuration">

                    <div class="alert alert-secondary d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined">percent</span>
                        <div>
                            These rates are used to calculate new quotations. Changing a rate only affects
                            quotations created from now on — quotations already sent to a client keep the rate they
                            were originally given.
                        </div>
                    </div>

                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">percent</span>
                            Labor Rates
                        </div>
                        <div class="settings-card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Client Type</th>
                                            <th style="width:140px;">Rate</th>
                                            <th style="width:90px;">Active</th>
                                            <th style="width:70px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laborRates as $rate)
                                            <tr>
                                                <form method="POST" action="{{ route('admin-settings.labor-rates.update', $rate) }}" id="rate-form-{{ $rate->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <td>{{ $rate->service_type }}</td>
                                                <td>{{ $rate->client_type_condition ?? 'Any / Other' }}</td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" step="0.01" min="0" max="100" name="rate_percent"
                                                            class="form-control" value="{{ $rate->rate_percent }}" form="rate-form-{{ $rate->id }}" required>
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch mb-0">
                                                        <input class="form-check-input" type="checkbox" name="active" value="1"
                                                            form="rate-form-{{ $rate->id }}" @checked($rate->active)>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn-icon-remove" form="rate-form-{{ $rate->id }}" title="Save">
                                                        <span class="material-symbols-outlined">save</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <form method="POST" action="{{ route('admin-settings.labor-rates.store') }}" class="tag-edit-row m-3">
                                @csrf
                                <span class="material-symbols-outlined tag-drag">add</span>
                                <select name="service_type" class="form-select form-select-sm" required>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->name }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <select name="client_type_condition" class="form-select form-select-sm">
                                    <option value="">Any / Other (default)</option>
                                    @foreach ($clientTypes as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group input-group-sm" style="max-width:130px;">
                                    <input type="number" step="0.01" min="0" max="100" name="rate_percent" class="form-control" placeholder="Rate" required>
                                    <span class="input-group-text">%</span>
                                </div>
                                <button type="submit" class="btn-add-row">
                                    <span class="material-symbols-outlined">add</span> Add Override
                                </button>
                            </form>
                        </div>
                    </div>

                </div><!-- /panel-quotation-configuration -->


                <!-- ════════════════════════════════
                     PANEL: LEGAL & POLICIES
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-legal-policies">

                    <div class="alert alert-secondary d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined">gavel</span>
                        <div>
                            Whatever you save here is exactly what clients see when they read your Terms of Service
                            or Privacy Policy while creating an account.
                        </div>
                    </div>

                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">description</span>
                            Terms of Service
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-2">
                                Last updated {{ \Carbon\Carbon::parse($legal['legal_terms_updated_at'] ?? now())->format('F j, Y') }}
                                @if (($legalMeta['legal_terms_content'] ?? null)?->updatedBy)
                                    by {{ $legalMeta['legal_terms_content']->updatedBy->full_name }}
                                @endif
                                &mdash; updates automatically when you save.
                            </p>
                            <p class="settings-hint mb-2">
                                Start a line with <code>##</code> to make it a heading (for example: <code>## 1. Acceptance of Terms</code>).
                                Start a line with <code>-</code> to make it a bullet point. Leave a blank line between paragraphs.
                            </p>
                            <form method="POST" action="{{ route('admin-settings.legal.terms.update') }}">
                                @csrf
                                <textarea name="content" class="form-control" rows="16">{{ old('content', $legal['legal_terms_content'] ?? '') }}</textarea>
                                <button type="submit" class="btn btn-success mt-3">Save Terms of Service</button>
                            </form>
                        </div>
                    </div>

                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">privacy_tip</span>
                            Privacy Policy
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-2">
                                Last updated {{ \Carbon\Carbon::parse($legal['legal_privacy_updated_at'] ?? now())->format('F j, Y') }}
                                @if (($legalMeta['legal_privacy_content'] ?? null)?->updatedBy)
                                    by {{ $legalMeta['legal_privacy_content']->updatedBy->full_name }}
                                @endif
                                &mdash; updates automatically when you save.
                            </p>
                            <p class="settings-hint mb-2">Same formatting as Terms of Service above.</p>
                            <form method="POST" action="{{ route('admin-settings.legal.privacy.update') }}">
                                @csrf
                                <textarea name="content" class="form-control" rows="18">{{ old('content', $legal['legal_privacy_content'] ?? '') }}</textarea>
                                <button type="submit" class="btn btn-success mt-3">Save Privacy Policy</button>
                            </form>
                        </div>
                    </div>

                </div><!-- /panel-legal-policies -->


                <!-- ════════════════════════════════
                     PANEL: WEBSITE CONTENT (live)
                     ════════════════════════════════ -->
                <div class="settings-panel" id="panel-website-content">

                    <div class="alert alert-secondary d-flex align-items-start gap-2 mb-4">
                        <span class="material-symbols-outlined">web</span>
                        <div>
                            This is exactly what visitors see on your public website.
                        </div>
                    </div>

                    <!-- Hero Section -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">movie</span>
                            Hero Section
                        </div>
                        <div class="settings-card-body">
                            <form method="POST" action="{{ route('admin-settings.website-content.hero.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <p class="settings-sub-header">Hero Background Image</p>
                                    <div class="image-upload-row mb-4">
                                        <div class="image-preview-box" id="preview-hero">
                                            <img src="{{ asset($landing['landing_hero_image_path'] ?? 'css/images/hero-img.jpg') }}" alt="Hero preview" class="image-preview-thumb">
                                            <div class="image-preview-overlay">
                                                <span class="material-symbols-outlined">edit</span>
                                                Change
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="settings-label">Hero Background</label>
                                            <input type="file" name="hero_image" class="form-control form-control-sm" accept="image/*"
                                                onchange="previewImage(this,'preview-hero')">
                                            <p class="settings-hint">Recommended: 1920×1080px, JPG or WebP. Max 3MB.</p>
                                        </div>
                                    </div>

                                    <hr class="my-2">
                                    <div class="col-12">
                                        <label class="settings-label">Main Headline</label>
                                        <input type="text" name="landing_hero_headline" class="form-control" value="{{ old('landing_hero_headline', $landing['landing_hero_headline'] ?? '') }}">
                                        <p class="settings-hint">The large bold text on the hero. Keep it short and impactful.</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="settings-label">Hero Subtitle</label>
                                        <textarea name="landing_hero_subtitle" class="form-control" rows="2">{{ old('landing_hero_subtitle', $landing['landing_hero_subtitle'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Primary CTA Button Text</label>
                                        <input type="text" name="landing_hero_cta_primary" class="form-control" value="{{ old('landing_hero_cta_primary', $landing['landing_hero_cta_primary'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Secondary CTA Button Text</label>
                                        <input type="text" name="landing_hero_cta_secondary" class="form-control" value="{{ old('landing_hero_cta_secondary', $landing['landing_hero_cta_secondary'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="settings-label">Eyebrow Badge Text</label>
                                        <input type="text" name="landing_hero_badge" class="form-control" value="{{ old('landing_hero_badge', $landing['landing_hero_badge'] ?? '') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Save Hero Section</button>
                            </form>
                        </div>
                    </div>

                    <!-- Hero Stat Cards -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">bar_chart</span>
                            Hero Stat Cards
                        </div>
                        <div class="settings-card-body">
                            <p class="settings-hint mb-3">The 4 mini stat cards under the hero CTAs.</p>
                            <div class="d-flex flex-column gap-2">
                                @foreach ($landingHeroStats as $stat)
                                    <form method="POST" action="{{ route('admin-settings.website-content.stats.update', $stat) }}" class="tag-edit-row">
                                        @csrf @method('PATCH')
                                        <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon" value="{{ $stat->icon }}" style="max-width:130px;">
                                        <input type="text" name="value" class="form-control form-control-sm" placeholder="Value" value="{{ $stat->value }}">
                                        <input type="text" name="label" class="form-control form-control-sm" placeholder="Label" value="{{ $stat->label }}">
                                        <div class="form-check form-switch mb-0" title="Active">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" @checked($stat->active)>
                                        </div>
                                        <button type="submit" class="btn-icon-remove" title="Save"><span class="material-symbols-outlined">save</span></button>
                                    </form>
                                @endforeach
                            </div>
                            <form method="POST" action="{{ route('admin-settings.website-content.stats.store') }}" class="tag-edit-row mt-3">
                                @csrf
                                <input type="hidden" name="placement" value="hero">
                                <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon (bi-*)" style="max-width:130px;">
                                <input type="text" name="value" class="form-control form-control-sm" placeholder="Value" required>
                                <input type="text" name="label" class="form-control form-control-sm" placeholder="Label" required>
                                <button type="submit" class="btn-add-row"><span class="material-symbols-outlined">add</span> Add</button>
                            </form>
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
                            <div class="d-flex flex-column gap-2">
                                @foreach ($landingBarStats as $stat)
                                    <form method="POST" action="{{ route('admin-settings.website-content.stats.update', $stat) }}" class="tag-edit-row">
                                        @csrf @method('PATCH')
                                        <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon" value="{{ $stat->icon }}" style="max-width:130px;">
                                        <input type="text" name="value" class="form-control form-control-sm" placeholder="Value" value="{{ $stat->value }}">
                                        <input type="text" name="label" class="form-control form-control-sm" placeholder="Label" value="{{ $stat->label }}">
                                        <div class="form-check form-switch mb-0" title="Active">
                                            <input class="form-check-input" type="checkbox" name="active" value="1" @checked($stat->active)>
                                        </div>
                                        <button type="submit" class="btn-icon-remove" title="Save"><span class="material-symbols-outlined">save</span></button>
                                    </form>
                                @endforeach
                            </div>
                            <form method="POST" action="{{ route('admin-settings.website-content.stats.store') }}" class="tag-edit-row mt-3">
                                @csrf
                                <input type="hidden" name="placement" value="bar">
                                <input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon (bi-*)" style="max-width:130px;">
                                <input type="text" name="value" class="form-control form-control-sm" placeholder="Value" required>
                                <input type="text" name="label" class="form-control form-control-sm" placeholder="Label" required>
                                <button type="submit" class="btn-add-row"><span class="material-symbols-outlined">add</span> Add</button>
                            </form>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">title</span>
                            Services Section Heading
                        </div>
                        <div class="settings-card-body">
                            <form method="POST" action="{{ route('admin-settings.website-content.services-section.update') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="settings-label">Section Heading</label>
                                        <input type="text" name="landing_services_heading" class="form-control" value="{{ old('landing_services_heading', $landing['landing_services_heading'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="settings-label">Section Subtitle</label>
                                        <input type="text" name="landing_services_subtitle" class="form-control" value="{{ old('landing_services_subtitle', $landing['landing_services_subtitle'] ?? '') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Save Heading</button>
                            </form>
                        </div>
                    </div>

                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">home_repair_service</span>
                            Service Cards
                        </div>
                        <div class="settings-card-body">
                            <div class="d-flex flex-column gap-3">
                                @foreach ($landingServices as $service)
                                    <form method="POST" action="{{ route('admin-settings.website-content.services.update', $service) }}" class="service-edit-row">
                                        @csrf @method('PATCH')
                                        <div class="service-edit-handle"><span class="material-symbols-outlined">drag_indicator</span></div>
                                        <div class="flex-grow-1 row g-2">
                                            <div class="col-md-3"><input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon" value="{{ $service->icon }}"></div>
                                            <div class="col-md-3"><input type="text" name="title" class="form-control form-control-sm" placeholder="Title" value="{{ $service->title }}"></div>
                                            <div class="col-md-6"><input type="text" name="description" class="form-control form-control-sm" placeholder="Short description" value="{{ $service->description }}"></div>
                                            <div class="col-8">
                                                <label class="settings-label fs-11">Features (one per line)</label>
                                                <textarea name="features" class="form-control form-control-sm" rows="2">{{ $service->features }}</textarea>
                                            </div>
                                            <div class="col-4 d-flex align-items-end">
                                                <div class="form-check form-switch mb-2" title="Active">
                                                    <input class="form-check-input" type="checkbox" name="active" value="1" @checked($service->active)>
                                                    <label class="form-check-label small">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn-icon-remove" title="Save"><span class="material-symbols-outlined">save</span></button>
                                    </form>
                                @endforeach
                            </div>
                            <form method="POST" action="{{ route('admin-settings.website-content.services.store') }}" class="service-edit-row mt-3">
                                @csrf
                                <div class="service-edit-handle"><span class="material-symbols-outlined">add</span></div>
                                <div class="flex-grow-1 row g-2">
                                    <div class="col-md-3"><input type="text" name="icon" class="form-control form-control-sm" placeholder="Icon (bi-*)"></div>
                                    <div class="col-md-3"><input type="text" name="title" class="form-control form-control-sm" placeholder="Title" required></div>
                                    <div class="col-md-6"><input type="text" name="description" class="form-control form-control-sm" placeholder="Short description" required></div>
                                    <div class="col-12">
                                        <textarea name="features" class="form-control form-control-sm" rows="2" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn-icon-remove" title="Add"><span class="material-symbols-outlined">add</span></button>
                            </form>
                        </div>
                    </div>

                    <!-- CTA Banner -->
                    <div class="settings-card mb-4">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">campaign</span>
                            CTA Banner (Bottom)
                        </div>
                        <div class="settings-card-body">
                            <form method="POST" action="{{ route('admin-settings.website-content.cta-banner.update') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="settings-label">CTA Headline</label>
                                        <input type="text" name="landing_cta_headline" class="form-control" value="{{ old('landing_cta_headline', $landing['landing_cta_headline'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="settings-label">CTA Subtext</label>
                                        <textarea name="landing_cta_subtext" class="form-control" rows="2">{{ old('landing_cta_subtext', $landing['landing_cta_subtext'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="settings-label">CTA Footnote</label>
                                        <input type="text" name="landing_cta_footnote" class="form-control" value="{{ old('landing_cta_footnote', $landing['landing_cta_footnote'] ?? '') }}">
                                    </div>
                                </div>
                                <p class="settings-hint mt-2">The "Call us now" button always shows the Primary Phone from Company Information — edit it there.</p>
                                <button type="submit" class="btn btn-success mt-2">Save CTA Banner</button>
                            </form>
                        </div>
                    </div>

                    <!-- Testimonials -->
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <span class="material-symbols-outlined">format_quote</span>
                            Testimonials
                        </div>
                        <div class="settings-card-body">
                            <div class="d-flex flex-column gap-3">
                                @foreach ($landingTestimonials as $t)
                                    <form method="POST" action="{{ route('admin-settings.website-content.testimonials.update', $t) }}" class="testimonial-edit-row">
                                        @csrf @method('PATCH')
                                        <div class="flex-grow-1 row g-2">
                                            <div class="col-md-5"><input type="text" name="name" class="form-control form-control-sm" placeholder="Reviewer name" value="{{ $t->name }}"></div>
                                            <div class="col-md-5"><input type="text" name="role" class="form-control form-control-sm" placeholder="Role / Company" value="{{ $t->role }}"></div>
                                            <div class="col-md-2 d-flex align-items-center">
                                                <div class="form-check form-switch mb-0" title="Active">
                                                    <input class="form-check-input" type="checkbox" name="active" value="1" @checked($t->active)>
                                                    <label class="form-check-label small">Active</label>
                                                </div>
                                            </div>
                                            <div class="col-12"><textarea name="quote" class="form-control form-control-sm" rows="2" placeholder="Quote text">{{ $t->quote }}</textarea></div>
                                        </div>
                                        <button type="submit" class="btn-icon-remove align-self-start mt-1" title="Save"><span class="material-symbols-outlined">save</span></button>
                                    </form>
                                @endforeach
                            </div>
                            <form method="POST" action="{{ route('admin-settings.website-content.testimonials.store') }}" class="testimonial-edit-row mt-3">
                                @csrf
                                <div class="flex-grow-1 row g-2">
                                    <div class="col-md-6"><input type="text" name="name" class="form-control form-control-sm" placeholder="Reviewer name" required></div>
                                    <div class="col-md-6"><input type="text" name="role" class="form-control form-control-sm" placeholder="Role / Company" required></div>
                                    <div class="col-12"><textarea name="quote" class="form-control form-control-sm" rows="2" placeholder="Quote text" required></textarea></div>
                                </div>
                                <button type="submit" class="btn-icon-remove align-self-start mt-1" title="Add"><span class="material-symbols-outlined">add</span></button>
                            </form>
                        </div>
                    </div>

                </div><!-- /panel-website-content -->

            </div><!-- /col-lg-9 -->
        </div><!-- /row -->

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

        /* ── LOGO PREVIEW (client-side only, real upload happens on submit) ── */
        function previewImage(input, previewId) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.querySelector('#' + previewId + ' .image-preview-thumb').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }

        /* ── ESTABLISHMENT TYPE TABS (per client type) ── */
        function switchEstabTab(btn, clientTypeId) {
            btn.closest('.nav-tabs').querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            btn.closest('.settings-card-body').querySelectorAll('[id^="estab-panel-"]').forEach(el => {
                el.style.display = (el.id === 'estab-panel-' + clientTypeId) ? 'block' : 'none';
            });
        }

        /* ── RESTORE TAB FROM URL HASH (after a save redirects back here) ── */
        if (window.location.hash) {
            const targetLink = document.querySelector('.settings-nav-link[href="' + window.location.hash + '"]');
            if (targetLink) switchTab(targetLink, window.location.hash.slice(1));
        }
    </script>
@endsection
