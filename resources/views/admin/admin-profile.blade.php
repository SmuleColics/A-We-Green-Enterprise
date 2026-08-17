@extends('layouts.admin')

@section('title', 'My Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-profile.css') }}">
@endsection

@section('page-title', 'My Profile')

@section('content')

    @php
        $roleLabels = [
            'super_admin' => ['label' => 'Owner', 'class' => 'type-super-admin'],
            'admin' => ['label' => 'Admin', 'class' => 'type-admin'],
            'secretary' => ['label' => 'Secretary', 'class' => 'type-secretary'],
            'employee' => ['label' => 'Employee', 'class' => 'type-employee'],
        ];
        $rolePill = $roleLabels[$user->role] ?? ['label' => ucfirst($user->role), 'class' => 'type-admin'];

        $moduleIcons = [
            'Assessment' => 'event_available',
            'Quotation' => 'request_quote',
            'Project' => 'folder',
            'Task' => 'task_alt',
            'Employee' => 'badge',
            'Client' => 'person',
            'Material' => 'inventory_2',
            'Checklist' => 'checklist',
            'Settings' => 'settings',
        ];
        $moduleIconClasses = [
            'Assessment' => 'bg-success-subtle text-success',
            'Quotation' => 'bg-primary-subtle text-primary',
            'Project' => 'bg-success-subtle text-success',
            'Task' => 'bg-warning-subtle text-warning',
            'Employee' => 'bg-primary-subtle text-primary',
            'Client' => 'bg-primary-subtle text-primary',
            'Material' => 'bg-danger-subtle text-danger',
            'Checklist' => 'bg-success-subtle text-success',
            'Settings' => 'bg-secondary-subtle text-secondary',
        ];
    @endphp

    <div class="container-fluid px-4 py-4">
        <div class="row g-4">

            <!-- ── Left Column: Avatar + Quick Info ── -->
            <div class="col-12 col-lg-4">

                <!-- Profile Card -->
                <div class="profile-card mb-4">
                    <div class="profile-avatar-wrap">
                        <div class="profile-avatar" id="profileAvatar">{{ $user->initials }}</div>
                        <label class="profile-avatar-edit" title="Change photo" style="cursor:pointer;">
                            <span class="material-symbols-outlined fs-17">photo_camera</span>
                            <input type="file" accept="image/*" class="d-none">
                        </label>
                    </div>
                    <h5 class="fw-bold mb-0">{{ $user->full_name }}</h5>
                    @if ($user->staff)
                        <p class="text-muted small mb-2">{{ $user->staff->staff_id }}</p>
                    @endif
                    <span class="type-pill {{ $rolePill['class'] }}">{{ $rolePill['label'] }}</span>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2 text-start w-100">
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">call</span>
                            <span>{{ $user->contact_number ?? '—' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">mail</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">calendar_today</span>
                            <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Activity Summary -->
                @if (!empty($summary))
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="section-label mb-3">Activity Summary</p>
                            <div class="d-flex flex-column gap-3">
                                @foreach ($summary as $metric)
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2 small">
                                            <span
                                                class="material-symbols-outlined green-text fs-18">{{ $metric['icon'] }}</span>
                                            {{ $metric['label'] }}
                                        </div>
                                        <span class="fw-bold">{{ $metric['value'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- ── Right Column: Edit Forms ── -->
            <div class="col-12 col-lg-8 d-flex flex-column gap-4">

                <!-- Personal Information -->
                <form id="personalInfoForm">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <span class="material-symbols-outlined green-text fs-22">person</span>
                                <div>
                                    <h6 class="fw-semibold mb-0">Personal Information</h6>
                                    <p class="text-muted small mb-0">Update your name and contact details.</p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">First Name</label>
                                    <input type="text" class="form-control" id="ap-fname" placeholder="First name"
                                        value="{{ $user->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Last Name</label>
                                    <input type="text" class="form-control" id="ap-lname" placeholder="Last name"
                                        value="{{ $user->last_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Contact Number</label>
                                    <input type="text" class="form-control" id="ap-contact" placeholder="09171234567"
                                        maxlength="11" inputmode="numeric"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11)"
                                        value="{{ $user->contact_number }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Email Address</label>
                                    <input type="email" class="form-control" id="ap-email" placeholder="you@example.com"
                                        value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                                    <span class="material-symbols-outlined fs-17">save</span>Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Change Password -->
                <form id="passwordForm">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <span class="material-symbols-outlined green-text fs-22">lock</span>
                                <div>
                                    <h6 class="fw-semibold mb-0">Change Password</h6>
                                    <p class="text-muted small mb-0">Leave blank if you don't want to change your password.
                                    </p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="currentPassword"
                                            placeholder="Enter current password">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="currentPassword">
                                            <span class="material-symbols-outlined fs-17">visibility</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="newPassword"
                                            placeholder="New password">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="newPassword">
                                            <span class="material-symbols-outlined fs-17">visibility</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirmPassword"
                                            placeholder="Confirm new password">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="confirmPassword">
                                            <span class="material-symbols-outlined fs-17">visibility</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Password Strength -->
                                <div class="col-12" id="passwordStrengthWrap" style="display:none;">
                                    <div class="pw-strength-bar">
                                        <div class="pw-strength-fill" id="pwStrengthFill"></div>
                                    </div>
                                    <p class="small mb-0 mt-1" id="pwStrengthLabel"></p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                                    <span class="material-symbols-outlined fs-17">lock_reset</span>Update Password
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Recent Activity Log -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <span class="material-symbols-outlined green-text fs-22">history</span>
                                <div>
                                    <h6 class="fw-semibold mb-0">Recent Activity</h6>
                                    <p class="text-muted small mb-0">Your last {{ $recentActivity->count() }} actions in
                                        the system.</p>
                                </div>
                            </div>
                            <a href="{{ route('admin-activity-logs') }}"
                                class="small fw-semibold text-decoration-none green-text d-flex align-items-center gap-1">
                                View all <span class="material-symbols-outlined fs-15">arrow_forward</span>
                            </a>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            @forelse ($recentActivity as $log)
                                <div class="activity-row">
                                    <div
                                        class="activity-icon {{ $moduleIconClasses[$log->module] ?? 'bg-secondary-subtle text-secondary' }}">
                                        <span
                                            class="material-symbols-outlined fs-17">{{ $moduleIcons[$log->module] ?? 'inbox' }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small fw-semibold mb-0">{{ $log->description }}</p>
                                        <p class="text-muted small mb-0">{{ $log->created_at->format('M j, Y · g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">No activity yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-pw').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('.material-symbols-outlined');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility_off';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility';
                }
            });
        });

        // Password strength meter
        document.getElementById('newPassword').addEventListener('input', function() {
            const val = this.value;
            const wrap = document.getElementById('passwordStrengthWrap');
            const fill = document.getElementById('pwStrengthFill');
            const label = document.getElementById('pwStrengthLabel');

            if (!val) {
                wrap.style.display = 'none';
                return;
            }
            wrap.style.display = '';

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [{
                    pct: '25%',
                    color: '#ef4444',
                    text: 'Weak',
                    textColor: '#ef4444'
                },
                {
                    pct: '50%',
                    color: '#f59e0b',
                    text: 'Fair',
                    textColor: '#f59e0b'
                },
                {
                    pct: '75%',
                    color: '#3b82f6',
                    text: 'Good',
                    textColor: '#3b82f6'
                },
                {
                    pct: '100%',
                    color: '#16A249',
                    text: 'Strong',
                    textColor: '#16A249'
                },
            ];

            const level = levels[score - 1] || levels[0];
            fill.style.width = level.pct;
            fill.style.backgroundColor = level.color;
            label.textContent = `Password strength: ${level.text}`;
            label.style.color = level.textColor;
        });

        function setFieldError(field, message) {
            if (!field) return;
            field.classList.add('is-invalid');
            let feedback = field.parentElement.nextElementSibling;
            if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback d-block';
                field.closest('.col-12, .col-md-6').appendChild(feedback);
            }
            feedback.textContent = message;
        }

        function clearFormErrors(form) {
            form.querySelectorAll('.is-invalid').forEach(f => f.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(f => f.remove());
        }

        document.getElementById('personalInfoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearFormErrors(this);

            const payload = {
                first_name: document.getElementById('ap-fname').value.trim(),
                last_name: document.getElementById('ap-lname').value.trim(),
                contact_number: document.getElementById('ap-contact').value.trim(),
                email: document.getElementById('ap-email').value.trim(),
            };
            const fieldMap = {
                first_name: 'ap-fname',
                last_name: 'ap-lname',
                contact_number: 'ap-contact',
                email: 'ap-email'
            };

            fetch('{{ route('admin-profile.update') }}', {
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
                        Object.keys(data.errors).forEach(key => {
                            setFieldError(document.getElementById(fieldMap[key]), data.errors[key][0]);
                        });
                        showToast('Please review the highlighted fields.', 'danger');
                        return;
                    }
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Something went wrong. Please try again.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearFormErrors(this);

            const payload = {
                current_password: document.getElementById('currentPassword').value,
                new_password: document.getElementById('newPassword').value,
                new_password_confirmation: document.getElementById('confirmPassword').value,
            };
            const fieldMap = {
                current_password: 'currentPassword',
                new_password: 'newPassword'
            };

            fetch('{{ route('admin-profile.update-password') }}', {
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
                        Object.keys(data.errors).forEach(key => {
                            setFieldError(document.getElementById(fieldMap[key]), data.errors[key][0]);
                        });
                        showToast('Please review the highlighted fields.', 'danger');
                        return;
                    }
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Something went wrong. Please try again.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    this.reset();
                    document.getElementById('passwordStrengthWrap').style.display = 'none';
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });
    </script>
@endsection
