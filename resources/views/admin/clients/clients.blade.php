@extends('layouts.admin')

@section('title', 'Clients')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/clients/clients.css') }}">
@endsection

@section('page-title', 'Clients')

@section('topbar-actions')
    <a href="{{ route('archive-clients') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
        data-bs-target="#addClientModal">
        <span class="material-symbols-outlined fs-17">person_add</span>
        Add Client
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">groups</span>
                    <div>
                        <p class="summary-label">Total Clients</p>
                        <p class="summary-value">{{ $total ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">home</span>
                    <div>
                        <p class="summary-label">Residential</p>
                        <p class="summary-value">{{ $residential ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">store</span>
                    <div>
                        <p class="summary-label">Commercial</p>
                        <p class="summary-value">{{ $commercial ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">account_balance</span>
                    <div>
                        <p class="summary-label">Government / LGU</p>
                        <p class="summary-value">{{ $government ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="typeFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Residential">Residential</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Commercial">Commercial</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Government/LGU">Government
                        / LGU</button>
                </div>

                <div class="table-responsive">
                    <table id="clientsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Client ID</th>
                                <th class="border-0 small green-text">Client Name</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Email</th>
                                <th class="border-0 small green-text">City/Municipality</th>
                                <th class="border-0 small green-text">Province</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                                <th class="d-none">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients ?? [] as $client)
                                <tr data-type="{{ $client->derived_type ?? '' }}">
                                    <td class="fw-semibold small">{{ $client->client_id }}</td>
                                    <td class="fw-semibold">{{ $client->user->full_name ?? 'N/A' }}</td>
                                    <td>{{ $client->user->contact_number ?? '—' }}</td>
                                    <td>{{ $client->user->email ?? '—' }}</td>
                                    <td>{{ $client->city ?: '—' }}</td>
                                    <td>{{ $client->province ?: '—' }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill bg-{{ ($client->user->status ?? '') === 'active' ? 'success' : 'warning text-dark' }}">
                                            {{ ucfirst($client->user->status ?? 'unknown') }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            onclick="openViewClient({{ $client->id }})">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                            onclick="openEditClient({{ $client->id }})">
                                            <span class="material-symbols-outlined icon-action">edit</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                            onclick="archiveClientConfirm({{ $client->id }})">
                                            <span class="material-symbols-outlined icon-action">archive</span>
                                        </button>
                                    </td>
                                    <td class="d-none">{{ $client->derived_type ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- ── View Client Modal ── -->
    <div class="modal fade" id="viewClientModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">person</span>
                        Client Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="client-avatar" id="vc-avatar">?</div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vc-name">—</p>
                            <p class="text-muted mb-1 small" id="vc-id">—</p>
                            <span class="badge rounded-pill bg-success" id="vc-status-badge">—</span>
                        </div>
                    </div>

                    <p class="section-label">Client Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Client Type</p>
                            <p class="detail-value small fw-semibold" id="vc-type">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Service</p>
                            <p class="detail-value small fw-semibold" id="vc-service">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Date Registered</p>
                            <p class="detail-value small" id="vc-joined">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Assessments</p>
                            <p class="detail-value small" id="vc-assessments">—</p>
                        </div>
                    </div>

                    <p class="section-label">Contact Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Contact Number</p>
                            <p class="detail-value small" id="vc-contact">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Email Address</p>
                            <p class="detail-value small" id="vc-email">—</p>
                        </div>
                    </div>

                    <p class="section-label">Address</p>
                    <p class="detail-value small" id="vc-address">—</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-16">close</span>Close
                    </button>
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        onclick="archiveClientConfirm(currentClientId)">
                        <span class="material-symbols-outlined fs-16">archive</span>Archive Client
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Client Modal ── -->
    <div class="modal fade" id="editClientModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">manage_accounts</span>
                        Edit Client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted small mb-0" id="edit-client-id">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">First Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-client-firstname" class="form-control form-control-sm">
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-client-lastname" class="form-control form-control-sm">
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Contact Number</label>
                            <input type="text" id="edit-client-contact" class="form-control form-control-sm"
                                placeholder="09171234567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                            <input type="email" id="edit-client-email" class="form-control form-control-sm">
                            <div class="invalid-feedback">A valid, unique email is required.</div>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small fw-semibold mb-0 mt-1 text-uppercase"
                                style="letter-spacing:.05em;">Address</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Block (Optional)</label>
                            <input type="text" id="edit-client-block" class="form-control form-control-sm"
                                placeholder="3">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Lot (Optional)</label>
                            <input type="text" id="edit-client-lot" class="form-control form-control-sm"
                                placeholder="12">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Street (Optional)</label>
                            <input type="text" id="edit-client-street" class="form-control form-control-sm"
                                placeholder="Diaz">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Barangay</label>
                            <input type="text" id="edit-client-barangay" class="form-control form-control-sm"
                                placeholder="Olaes">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">City</label>
                            <input type="text" id="edit-client-city" class="form-control form-control-sm"
                                placeholder="Bacoor">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Province</label>
                            <input type="text" id="edit-client-province" class="form-control form-control-sm"
                                placeholder="Cavite">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Zip Code (Optional)</label>
                            <input type="text" id="edit-client-zip" class="form-control form-control-sm"
                                placeholder="4117">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                        onclick="submitEditClient()">
                        <span class="material-symbols-outlined fs-16">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Add Client Modal (register-style) ── -->
    <div class="modal fade" id="addClientModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">person_add</span>
                        Add New Client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addClientForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                <input type="text" id="add-client-firstname" class="form-control form-control-sm"
                                    placeholder="Juan">
                                <div class="invalid-feedback">First name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                <input type="text" id="add-client-lastname" class="form-control form-control-sm"
                                    placeholder="Dela Cruz">
                                <div class="invalid-feedback">Last name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" id="add-client-email" class="form-control form-control-sm"
                                    placeholder="client@email.com">
                                <div class="invalid-feedback">A valid, unique email is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Contact Number</label>
                                <input type="text" id="add-client-contact" class="form-control form-control-sm"
                                    placeholder="09171234567">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="password" id="add-client-password" class="form-control"
                                        placeholder="At least 8 characters" minlength="8">
                                    <button class="btn btn-outline-secondary toggle-pw" type="button"
                                        data-target="add-client-password">
                                        <span class="material-symbols-outlined fs-17">visibility</span>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block" id="add-client-password-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="password" id="add-client-password-confirm" class="form-control"
                                        placeholder="Re-enter password">
                                    <button class="btn btn-outline-secondary toggle-pw" type="button"
                                        data-target="add-client-password-confirm">
                                        <span class="material-symbols-outlined fs-17">visibility</span>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block" id="add-client-password-confirm-error"></div>
                            </div>

                            <div class="col-12">
                                <p class="text-muted small fw-semibold mb-0 mt-1 text-uppercase"
                                    style="letter-spacing:.05em;">Address (Optional)</p>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Block</label>
                                <input type="text" id="add-client-block" class="form-control form-control-sm"
                                    placeholder="3">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Lot</label>
                                <input type="text" id="add-client-lot" class="form-control form-control-sm"
                                    placeholder="12">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Street</label>
                                <input type="text" id="add-client-street" class="form-control form-control-sm"
                                    placeholder="Diaz">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Barangay</label>
                                <input type="text" id="add-client-barangay" class="form-control form-control-sm"
                                    placeholder="Olaes">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">City / Municipality</label>
                                <input type="text" id="add-client-city" class="form-control form-control-sm"
                                    placeholder="Bacoor">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Province</label>
                                <input type="text" id="add-client-province" class="form-control form-control-sm"
                                    placeholder="Cavite">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Zip Code</label>
                                <input type="text" id="add-client-zip" class="form-control form-control-sm"
                                    placeholder="4117">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                        onclick="submitAddClient()">
                        <span class="material-symbols-outlined fs-16">save</span>Save Client
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archive Confirm Modal ── -->
    <div class="modal fade" id="archiveClientConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Archive this client?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">This client will be moved to the archive. You can restore them anytime
                        from <strong>View Archives</strong>.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        onclick="confirmArchiveClient()">
                        <span class="material-symbols-outlined fs-15">archive</span>Archive
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let dtTable = null;
        let currentClientId = null;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function toastThenReload(message, type = 'success') {
            sessionStorage.setItem('pendingToast', JSON.stringify({
                message,
                type
            }));
            location.reload();
        }

        // Password visibility toggle — works for all toggle-pw buttons
        document.querySelectorAll('.toggle-pw').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('.material-symbols-outlined');
                if (!input) return;

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility_off';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility';
                }
            });
        });

        function openViewClient(clientId) {
            currentClientId = clientId;
            fetch(`/admin/clients/${clientId}/details`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) throw new Error('Invalid response');
                    const c = data.client;
                    const initials = ((c.firstName?.[0] || '') + (c.lastName?.[0] || '')).toUpperCase() || '?';

                    document.getElementById('vc-avatar').textContent = initials;
                    document.getElementById('vc-name').textContent = c.name || '—';
                    document.getElementById('vc-id').textContent = c.client_id || '—';
                    document.getElementById('vc-type').textContent = c.type || '—';
                    document.getElementById('vc-service').textContent = c.service || '—';
                    document.getElementById('vc-joined').textContent = c.joined || '—';
                    document.getElementById('vc-assessments').textContent = c.assessments_count ?? '0';
                    document.getElementById('vc-contact').textContent = c.contact || '—';
                    document.getElementById('vc-email').textContent = c.email || '—';
                    document.getElementById('vc-address').textContent = c.address || '—';

                    const badge = document.getElementById('vc-status-badge');
                    badge.textContent = c.status ? c.status.charAt(0).toUpperCase() + c.status.slice(1) : '—';
                    badge.className =
                        `badge rounded-pill ${c.status === 'active' ? 'bg-success' : 'bg-warning text-dark'}`;

                    new bootstrap.Modal(document.getElementById('viewClientModal')).show();
                })
                .catch(() => showToast('Failed to load client details.', 'danger'));
        }

        function openEditClient(clientId) {
            currentClientId = clientId;
            fetch(`/admin/clients/${clientId}/details`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) throw new Error('Invalid response');
                    const c = data.client;
                    document.getElementById('edit-client-id').textContent = c.client_id || '';
                    document.getElementById('edit-client-firstname').value = c.firstName || '';
                    document.getElementById('edit-client-lastname').value = c.lastName || '';
                    document.getElementById('edit-client-contact').value = c.contact || '';
                    document.getElementById('edit-client-email').value = c.email || '';
                    document.getElementById('edit-client-block').value = c.block || '';
                    document.getElementById('edit-client-lot').value = c.lot || '';
                    document.getElementById('edit-client-street').value = c.street || '';
                    document.getElementById('edit-client-barangay').value = c.barangay || '';
                    document.getElementById('edit-client-city').value = c.city || '';
                    document.getElementById('edit-client-province').value = c.province || '';
                    document.getElementById('edit-client-zip').value = c.zip_code || '';

                    document.querySelectorAll('#editClientModal .is-invalid').forEach(el => el.classList.remove(
                        'is-invalid'));
                    new bootstrap.Modal(document.getElementById('editClientModal')).show();
                })
                .catch(() => showToast('Failed to load client for editing.', 'danger'));
        }

        function submitEditClient() {
            let valid = true;
            const firstEl = document.getElementById('edit-client-firstname');
            const lastEl = document.getElementById('edit-client-lastname');
            const emailEl = document.getElementById('edit-client-email');

            [firstEl, lastEl, emailEl].forEach(el => el.classList.remove('is-invalid'));

            if (!firstEl.value.trim()) {
                firstEl.classList.add('is-invalid');
                valid = false;
            }
            if (!lastEl.value.trim()) {
                lastEl.classList.add('is-invalid');
                valid = false;
            }
            if (!emailEl.value.trim() || !emailEl.value.includes('@')) {
                emailEl.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                showToast('Please fill in all required fields.', 'warning');
                return;
            }

            const payload = {
                first_name: firstEl.value.trim(),
                last_name: lastEl.value.trim(),
                email: emailEl.value.trim(),
                contact_number: document.getElementById('edit-client-contact').value.trim() || null,
                block: document.getElementById('edit-client-block').value.trim() || null,
                lot: document.getElementById('edit-client-lot').value.trim() || null,
                street: document.getElementById('edit-client-street').value.trim() || null,
                barangay: document.getElementById('edit-client-barangay').value.trim() || null,
                city: document.getElementById('edit-client-city').value.trim() || null,
                province: document.getElementById('edit-client-province').value.trim() || null,
                zip_code: document.getElementById('edit-client-zip').value.trim() || null,
            };

            fetch(`/admin/clients/${currentClientId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('editClientModal')).hide();
                        toastThenReload(data.message || 'Client updated.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to update client'), 'danger');
                    }
                })
                .catch(() => showToast('An error occurred', 'danger'));
        }

        function submitAddClient() {
            let valid = true;
            const fields = {
                firstname: document.getElementById('add-client-firstname'),
                lastname: document.getElementById('add-client-lastname'),
                email: document.getElementById('add-client-email'),
                password: document.getElementById('add-client-password'),
                passwordConfirm: document.getElementById('add-client-password-confirm'),
            };
            const pwError = document.getElementById('add-client-password-error');
            const pwConfirmError = document.getElementById('add-client-password-confirm-error');

            Object.values(fields).forEach(el => el.classList.remove('is-invalid'));
            pwError.textContent = '';
            pwConfirmError.textContent = '';

            if (!fields.firstname.value.trim()) {
                fields.firstname.classList.add('is-invalid');
                valid = false;
            }
            if (!fields.lastname.value.trim()) {
                fields.lastname.classList.add('is-invalid');
                valid = false;
            }
            if (!fields.email.value.trim() || !fields.email.value.includes('@')) {
                fields.email.classList.add('is-invalid');
                valid = false;
            }

            if (fields.password.value.length < 8) {
                fields.password.classList.add('is-invalid');
                pwError.textContent = 'Password must be at least 8 characters.';
                valid = false;
            }

            if (!fields.passwordConfirm.value) {
                fields.passwordConfirm.classList.add('is-invalid');
                pwConfirmError.textContent = 'Please confirm your password.';
                valid = false;
            } else if (fields.passwordConfirm.value !== fields.password.value) {
                fields.passwordConfirm.classList.add('is-invalid');
                pwConfirmError.textContent = 'Passwords do not match.';
                valid = false;
            }

            if (!valid) {
                showToast('Please fix the highlighted fields.', 'warning');
                return;
            }

            const payload = {
                first_name: fields.firstname.value.trim(),
                last_name: fields.lastname.value.trim(),
                email: fields.email.value.trim(),
                contact_number: document.getElementById('add-client-contact').value.trim() || null,
                password: fields.password.value,
                password_confirmation: fields.passwordConfirm.value,
                block: document.getElementById('add-client-block').value.trim() || null,
                lot: document.getElementById('add-client-lot').value.trim() || null,
                street: document.getElementById('add-client-street').value.trim() || null,
                barangay: document.getElementById('add-client-barangay').value.trim() || null,
                city: document.getElementById('add-client-city').value.trim() || null,
                province: document.getElementById('add-client-province').value.trim() || null,
                zip_code: document.getElementById('add-client-zip').value.trim() || null,
            };

            fetch('/admin/clients', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('addClientModal')).hide();
                        toastThenReload(data.message || 'Client created.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to create client'), 'danger');
                    }
                })
                .catch(() => showToast('An error occurred', 'danger'));
        }

        function archiveClientConfirm(clientId) {
            currentClientId = clientId;
            bootstrap.Modal.getInstance(document.getElementById('viewClientModal'))?.hide();
            new bootstrap.Modal(document.getElementById('archiveClientConfirmModal')).show();
        }

        function confirmArchiveClient() {
            if (!currentClientId) return;
            fetch(`/admin/clients/${currentClientId}/archive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('archiveClientConfirmModal')).hide();
                        toastThenReload(data.message || 'Client archived.', 'success');
                    } else {
                        showToast('Error: ' + (data.message || 'Failed to archive client'), 'danger');
                    }
                })
                .catch(() => showToast('An error occurred', 'danger'));
        }

        $(document).ready(function() {
            dtTable = $('#clientsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                lengthChange: true,
                info: true,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    },
                    {
                        visible: false,
                        targets: 8
                    }
                ],
                language: {
                    emptyTable: 'No clients found.',
                    zeroRecords: 'No matching clients found.'
                }
            });

            $('#typeFilterGroup button').on('click', function() {
                $('#typeFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                dtTable.column(8).search(filter === 'all' ? '' : filter, false, false).draw();
            });

            const pending = sessionStorage.getItem('pendingToast');
            if (pending) {
                sessionStorage.removeItem('pendingToast');
                try {
                    const {
                        message,
                        type
                    } = JSON.parse(pending);
                    showToast(message, type);
                } catch (e) {
                    console.error('Failed to parse pending toast', e);
                }
            }
        });
    </script>
@endsection
