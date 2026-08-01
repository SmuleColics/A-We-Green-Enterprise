@extends('layouts.client')

@section('title', 'My Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>My Profile</h2>
            <p>Manage your account details and contact information.</p>
        </div>

        <div class="main-content">
            <div class="profile-wrap">

                <!-- Profile Header -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                        <div class="profile-avatar">MS</div>
                        <div class="flex-grow-1">
                            <h5 class="fw-semibold mb-0">Maria Santos</h5>
                            <p class="text-muted small mb-0">Residential Client · Member since March 2026</p>
                        </div>
                        <span class="badge bg-success rounded-pill">Verified Account</span>
                    </div>
                </div>

                <form>
                    <!-- Section 1: Personal Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Maria">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Santos">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="0917-123-4567">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" value="maria.santos@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Client Type</label>
                                    <input type="text" class="form-control bg-light" value="Residential" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Establishment Type</label>
                                    <input type="text" class="form-control bg-light" value="Home / Residence" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Address -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Address</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small">Block</label>
                                    <input type="text" class="form-control" value="12">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Lot</label>
                                    <input type="text" class="form-control" value="5">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Street / Purok / Sitio</label>
                                    <input type="text" class="form-control" value="Sampaguita St.">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Barangay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Brgy. Tanzang Luma II">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Province <span class="text-danger">*</span></label>
                                    <select class="form-select" id="p-province" onchange="updateProfileCities()">
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
                                    <label class="form-label small">City / Municipality <span class="text-danger">*</span></label>
                                    <select class="form-select" id="p-city">
                                        <!-- pre-populated via JS on load -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Zip Code</label>
                                    <input type="text" class="form-control" value="4103">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Security -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Security</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">New Password</label>
                                    <input type="password" class="form-control" placeholder="Leave blank to keep current password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Confirm New Password</label>
                                    <input type="password" class="form-control" placeholder="Re-enter new password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-end gap-2 pb-5">
                        <button type="button" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-18">save</span>
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
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

        function updateProfileCities(preselect) {
            const prov = document.getElementById('p-province').value;
            const sel = document.getElementById('p-city');
            if (!prov || !cityData[prov]) {
                sel.innerHTML = '<option value="">— Select Province First —</option>';
                return;
            }
            sel.innerHTML = '<option value="">— Select City / Municipality —</option>' +
                cityData[prov].map(c =>
                    `<option value="${c}"${(preselect || '') === c ? ' selected' : ''}>${c}</option>`
                ).join('');
        }

        window.addEventListener('DOMContentLoaded', function () {
            updateProfileCities('Imus');
        });
    </script>
@endsection