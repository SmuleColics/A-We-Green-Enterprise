@extends('layouts.client')

@section('title', 'Settings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/settings.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Settings</h2>
            <p>Manage your notification preferences and account settings.</p>
        </div>

        <div class="main-content">
            <div class="settings-wrap">

                <form>
                    <!-- Section 1: Notification Preferences -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-1">Notification Preferences</h6>
                            <p class="text-muted small mb-4">Choose how you'd like to be notified about updates.</p>

                            <div class="setting-row">
                                <div>
                                    <p class="setting-label">Assessment Reminders</p>
                                    <p class="setting-desc">Get notified before your scheduled site assessment.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="notif-assessment" checked>
                                </div>
                            </div>

                            <div class="setting-row">
                                <div>
                                    <p class="setting-label">Quotation Updates</p>
                                    <p class="setting-desc">Be alerted when a new quotation is sent for your review.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="notif-quotation" checked>
                                </div>
                            </div>

                            <div class="setting-row">
                                <div>
                                    <p class="setting-label">Project Progress Updates</p>
                                    <p class="setting-desc">Receive updates whenever your project status changes.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="notif-project" checked>
                                </div>
                            </div>

                            <div class="setting-row border-bottom-0">
                                <div>
                                    <p class="setting-label">Promotions & Announcements</p>
                                    <p class="setting-desc">Occasional news about new services and offers.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="notif-promo">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Notification Channels -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-1">Notification Channels</h6>
                            <p class="text-muted small mb-4">Choose where these notifications should be sent.</p>

                            <div class="setting-row">
                                <div>
                                    <p class="setting-label">Email</p>
                                    <p class="setting-desc">maria.santos@email.com</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="channel-email" checked>
                                </div>
                            </div>

                            <div class="setting-row border-bottom-0">
                                <div>
                                    <p class="setting-label">SMS</p>
                                    <p class="setting-desc">0917-123-4567</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="channel-sms">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Privacy -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-1">Privacy</h6>
                            <p class="text-muted small mb-4">Control how your information is used.</p>

                            <div class="setting-row border-bottom-0">
                                <div>
                                    <p class="setting-label">Share Feedback Anonymously</p>
                                    <p class="setting-desc">Allow us to use your feedback for service improvement without attaching your name.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="privacy-feedback" checked>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Danger Zone -->
                    <div class="card border-0 shadow-sm mb-4 danger-zone-card">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">These actions are permanent and cannot be undone.</p>
                            <button type="button" class="btn btn-outline-danger btn-sm">
                                Deactivate My Account
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-end gap-2 pb-5">
                        <button type="button" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-18">save</span>
                            Save Settings
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection