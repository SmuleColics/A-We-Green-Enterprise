@extends('layouts.client')

@section('title', 'My Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
@endsection

@section('content')

    @php
        $statusBadges = [
            'active' => ['label' => 'Active Account', 'class' => 'bg-success'],
            'inactive' => ['label' => 'Inactive Account', 'class' => 'bg-secondary'],
            'pending' => ['label' => 'Pending Activation', 'class' => 'bg-warning text-dark'],
        ];
        $statusBadge = $statusBadges[$user->status] ?? $statusBadges['pending'];
        $clientTypeLabel = $latestAssessment->client_type ?? null;
    @endphp

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
                        <div class="profile-avatar">{{ $user->initials }}</div>
                        <div class="flex-grow-1">
                            <h5 class="fw-semibold mb-0">{{ $user->full_name }}</h5>
                            <p class="text-muted small mb-0">
                                {{ $clientTypeLabel ? $clientTypeLabel . ' Client' : 'Client' }} · Member since
                                {{ $user->created_at->format('F Y') }}
                            </p>
                        </div>
                        <span class="badge {{ $statusBadge['class'] }} rounded-pill">{{ $statusBadge['label'] }}</span>
                    </div>
                </div>

                <form id="profileForm">
                    @csrf
                    <!-- Section 1: Personal Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="p-fname"
                                        value="{{ $user->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="p-lname"
                                        value="{{ $user->last_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Contact Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="p-contact"
                                        placeholder="09171234567" maxlength="11" inputmode="numeric"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11)"
                                        value="{{ $user->contact_number }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="p-email" value="{{ $user->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Client Type</label>
                                    <input type="text" class="form-control bg-light"
                                        value="{{ $clientTypeLabel ?? '—' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Establishment Type</label>
                                    <input type="text" class="form-control bg-light"
                                        value="{{ $latestAssessment->establishment_type ?? '—' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Address -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Address</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Block</label>
                                    <input type="text" class="form-control" id="p-block" value="{{ $client->block }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Lot</label>
                                    <input type="text" class="form-control" id="p-lot" value="{{ $client->lot }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Street / Purok / Sitio</label>
                                    <input type="text" class="form-control" id="p-street"
                                        value="{{ $client->street }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Barangay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="p-brgy"
                                        value="{{ $client->barangay }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Province <span class="text-danger">*</span></label>
                                    <select class="form-select" id="p-province" onchange="updateProfileCities()">
                                        <option value="">— Select Province —</option>
                                        <optgroup label="NCR">
                                            <option value="Metro Manila" @selected($client->province === 'Metro Manila')>Metro Manila (NCR)
                                            </option>
                                        </optgroup>
                                        <optgroup label="Region IV-A (CALABARZON)">
                                            <option value="Batangas" @selected($client->province === 'Batangas')>Batangas</option>
                                            <option value="Cavite" @selected($client->province === 'Cavite')>Cavite</option>
                                            <option value="Laguna" @selected($client->province === 'Laguna')>Laguna</option>
                                            <option value="Quezon" @selected($client->province === 'Quezon')>Quezon</option>
                                            <option value="Rizal" @selected($client->province === 'Rizal')>Rizal</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">City / Municipality <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="p-city">
                                        <!-- pre-populated via JS on load -->
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Zip Code</label>
                                    <input type="text" class="form-control" id="p-zip"
                                        value="{{ $client->zip_code }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Security -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Security</h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small">Current Password</label>
                                    <input type="password" class="form-control" id="p-current-password"
                                        placeholder="Required to change password" autocomplete="current-password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">New Password</label>
                                    <input type="password" class="form-control" id="p-new-password"
                                        placeholder="Leave blank to keep current password" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Confirm New Password</label>
                                    <input type="password" class="form-control" id="p-new-password-confirmation"
                                        placeholder="Re-enter new password" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-end gap-2 pb-5">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="location.reload()">Cancel</button>
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

        window.addEventListener('DOMContentLoaded', function() {
            updateProfileCities(@json($client->city));
        });

        /* ─── Field error helpers (same pattern as client-assessment.js) ─── */
        function setFieldError(field, message) {
            if (!field) return;
            field.classList.add('is-invalid');
            let feedback = field.nextElementSibling;
            if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                field.insertAdjacentElement('afterend', feedback);
            }
            feedback.textContent = message;
        }

        function clearAllFieldErrors() {
            document.querySelectorAll('#profileForm .is-invalid').forEach(f => f.classList.remove('is-invalid'));
            document.querySelectorAll('#profileForm .invalid-feedback').forEach(f => f.remove());
        }

        const FIELD_MAP = {
            first_name: 'p-fname',
            last_name: 'p-lname',
            contact_number: 'p-contact',
            email: 'p-email',
            block: 'p-block',
            lot: 'p-lot',
            street: 'p-street',
            barangay: 'p-brgy',
            province: 'p-province',
            city: 'p-city',
            zip_code: 'p-zip',
            current_password: 'p-current-password',
            new_password: 'p-new-password',
        };

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearAllFieldErrors();

            const payload = {
                first_name: document.getElementById('p-fname').value.trim(),
                last_name: document.getElementById('p-lname').value.trim(),
                contact_number: document.getElementById('p-contact').value.trim(),
                email: document.getElementById('p-email').value.trim(),
                block: document.getElementById('p-block').value.trim() || null,
                lot: document.getElementById('p-lot').value.trim() || null,
                street: document.getElementById('p-street').value.trim() || null,
                barangay: document.getElementById('p-brgy').value.trim(),
                province: document.getElementById('p-province').value,
                city: document.getElementById('p-city').value,
                zip_code: document.getElementById('p-zip').value.trim() || null,
                current_password: document.getElementById('p-current-password').value || null,
                new_password: document.getElementById('p-new-password').value || null,
                new_password_confirmation: document.getElementById('p-new-password-confirmation').value || null,
            };

            fetch('{{ route('profile.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                })
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status,
                    data
                }) => {
                    if (status === 422 && data.errors) {
                        let firstField = null;
                        Object.keys(data.errors).forEach(key => {
                            const fieldId = FIELD_MAP[key];
                            const field = fieldId ? document.getElementById(fieldId) : null;
                            setFieldError(field, data.errors[key][0]);
                            if (field && !firstField) firstField = field;
                        });
                        firstField?.focus();
                        showToast('Please review the highlighted fields.', 'danger');
                        return;
                    }

                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Something went wrong. Please try again.', 'danger');
                        return;
                    }

                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });
    </script>
@endsection
