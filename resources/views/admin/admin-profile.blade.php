@extends('layouts.admin')

@section('title', 'My Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-profile.css') }}">
@endsection

@section('page-title', 'My Profile')

@section('content')

    <div class="container-fluid px-4 py-4">
        <div class="row g-4">

            <!-- ── Left Column: Avatar + Quick Info ── -->
            <div class="col-12 col-lg-4">

                <!-- Profile Card -->
                <div class="profile-card mb-4">
                    <div class="profile-avatar-wrap">
                        <div class="profile-avatar" id="profileAvatar">MG</div>
                        <label class="profile-avatar-edit" title="Change photo" style="cursor:pointer;">
                            <span class="material-symbols-outlined fs-17">photo_camera</span>
                            <input type="file" accept="image/*" class="d-none">
                        </label>
                    </div>
                    <h5 class="fw-bold mb-0">Michael Garcia</h5>
                    <p class="text-muted small mb-2">ADM-2026-001</p>
                    <span class="type-pill type-admin">Admin</span>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2 text-start w-100">
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">call</span>
                            <span>0927-300-4000</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">mail</span>
                            <span>michael.garcia@schedquote.com</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">location_on</span>
                            <span>Block 1, Lot 1, Brgy. Tanzang Luma II, Imus, Cavite</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="material-symbols-outlined text-muted fs-17">calendar_today</span>
                            <span>Joined Jan 01, 2026</span>
                        </div>
                    </div>
                </div>

                <!-- Activity Summary -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="section-label mb-3">Activity Summary</p>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 small">
                                    <span class="material-symbols-outlined green-text fs-18">event_available</span>
                                    Assessments Handled
                                </div>
                                <span class="fw-bold">42</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 small">
                                    <span class="material-symbols-outlined green-text fs-18">request_quote</span>
                                    Quotations Created
                                </div>
                                <span class="fw-bold">26</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 small">
                                    <span class="material-symbols-outlined green-text fs-18">folder</span>
                                    Projects Monitored
                                </div>
                                <span class="fw-bold">5</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 small">
                                    <span class="material-symbols-outlined green-text fs-18">task_alt</span>
                                    Tasks Assigned
                                </div>
                                <span class="fw-bold">18</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── Right Column: Edit Forms ── -->
            <div class="col-12 col-lg-8 d-flex flex-column gap-4">

                <!-- Personal Information -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <span class="material-symbols-outlined green-text fs-22">person</span>
                            <div>
                                <h6 class="fw-semibold mb-0">Personal Information</h6>
                                <p class="text-muted small mb-0">Update your name, contact, and address details.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">First Name</label>
                                <input type="text" class="form-control" value="Michael">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Last Name</label>
                                <input type="text" class="form-control" value="Garcia">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Contact Number</label>
                                <input type="text" class="form-control" value="0927-300-4000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Email Address</label>
                                <input type="email" class="form-control" value="michael.garcia@schedquote.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Address</label>
                                <input type="text" class="form-control" value="Block 1, Lot 1, Brgy. Tanzang Luma II, Imus, Cavite">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-success d-flex align-items-center gap-1">
                                <span class="material-symbols-outlined fs-17">save</span>Save Changes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <span class="material-symbols-outlined green-text fs-22">lock</span>
                            <div>
                                <h6 class="fw-semibold mb-0">Change Password</h6>
                                <p class="text-muted small mb-0">Leave blank if you don't want to change your password.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password">
                                    <button class="btn btn-outline-secondary toggle-pw" type="button" data-target="currentPassword">
                                        <span class="material-symbols-outlined fs-17">visibility</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword" placeholder="New password">
                                    <button class="btn btn-outline-secondary toggle-pw" type="button" data-target="newPassword">
                                        <span class="material-symbols-outlined fs-17">visibility</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                                    <button class="btn btn-outline-secondary toggle-pw" type="button" data-target="confirmPassword">
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
                            <button class="btn btn-success d-flex align-items-center gap-1">
                                <span class="material-symbols-outlined fs-17">lock_reset</span>Update Password
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Log -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <span class="material-symbols-outlined green-text fs-22">history</span>
                            <div>
                                <h6 class="fw-semibold mb-0">Recent Activity</h6>
                                <p class="text-muted small mb-0">Your last 5 actions in the system.</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            <div class="activity-row">
                                <div class="activity-icon bg-success-subtle">
                                    <span class="material-symbols-outlined text-success fs-17">event_available</span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small fw-semibold mb-0">Scheduled assessment for Maria Santos</p>
                                    <p class="text-muted small mb-0">Mar 15, 2026 · 9:00 AM</p>
                                </div>
                            </div>
                            <div class="activity-row">
                                <div class="activity-icon bg-primary-subtle">
                                    <span class="material-symbols-outlined text-primary fs-17">description</span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small fw-semibold mb-0">Created quotation QT-2026-007 for John Reyes</p>
                                    <p class="text-muted small mb-0">Mar 14, 2026 · 2:30 PM</p>
                                </div>
                            </div>
                            <div class="activity-row">
                                <div class="activity-icon bg-warning-subtle">
                                    <span class="material-symbols-outlined text-warning fs-17">task_alt</span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small fw-semibold mb-0">Assigned task "Run CAT6 Cabling" to Jomar Tan</p>
                                    <p class="text-muted small mb-0">Mar 14, 2026 · 11:00 AM</p>
                                </div>
                            </div>
                            <div class="activity-row">
                                <div class="activity-icon bg-success-subtle">
                                    <span class="material-symbols-outlined text-success fs-17">folder</span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small fw-semibold mb-0">Posted update on CCTV Installation — Santos Residence</p>
                                    <p class="text-muted small mb-0">Mar 13, 2026 · 4:00 PM</p>
                                </div>
                            </div>
                            <div class="activity-row">
                                <div class="activity-icon bg-danger-subtle">
                                    <span class="material-symbols-outlined text-danger fs-17">inventory_2</span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small fw-semibold mb-0">Low stock alert triggered for Solar Panels</p>
                                    <p class="text-muted small mb-0">Mar 13, 2026 · 10:15 AM</p>
                                </div>
                            </div>
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
                const icon  = this.querySelector('.material-symbols-outlined');
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
            const val  = this.value;
            const wrap = document.getElementById('passwordStrengthWrap');
            const fill = document.getElementById('pwStrengthFill');
            const label = document.getElementById('pwStrengthLabel');

            if (!val) { wrap.style.display = 'none'; return; }
            wrap.style.display = '';

            let score = 0;
            if (val.length >= 8)            score++;
            if (/[A-Z]/.test(val))          score++;
            if (/[0-9]/.test(val))          score++;
            if (/[^A-Za-z0-9]/.test(val))   score++;

            const levels = [
                { pct: '25%',  color: '#ef4444', text: 'Weak',      textColor: '#ef4444' },
                { pct: '50%',  color: '#f59e0b', text: 'Fair',      textColor: '#f59e0b' },
                { pct: '75%',  color: '#3b82f6', text: 'Good',      textColor: '#3b82f6' },
                { pct: '100%', color: '#16A249', text: 'Strong',    textColor: '#16A249' },
            ];

            const level = levels[score - 1] || levels[0];
            fill.style.width           = level.pct;
            fill.style.backgroundColor = level.color;
            label.textContent          = `Password strength: ${level.text}`;
            label.style.color          = level.textColor;
        });
    </script>
@endsection