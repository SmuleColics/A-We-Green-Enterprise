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

                <!-- Section 1: Notification Preferences -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-1">Notification Preferences</h6>
                        <p class="text-muted small mb-4">Choose which system updates you'd like to receive.</p>

                        <div class="setting-row">
                            <div>
                                <p class="setting-label">Assessment Reminders</p>
                                <p class="setting-desc">Get notified before your scheduled site assessment.</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-assessment" data-pref="notify_assessment"
                                    {{ $client->notify_assessment ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-row">
                            <div>
                                <p class="setting-label">Quotation Updates</p>
                                <p class="setting-desc">Be notified when a new quotation is available for your review.</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-quotation" data-pref="notify_quotation"
                                    {{ $client->notify_quotation ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="setting-row border-bottom-0">
                            <div>
                                <p class="setting-label">Project Progress Updates</p>
                                <p class="setting-desc">Receive notifications when your project status or progress is updated.</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-project" data-pref="notify_project"
                                    {{ $client->notify_project ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Account Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Account Information</h6>

                        <div class="setting-row">
                            <div>
                                <p class="setting-label">Email Address</p>
                                <p class="setting-desc">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="setting-row border-bottom-0">
                            <div>
                                <p class="setting-label">Contact Number</p>
                                <p class="setting-desc">{{ $user->contact_number ?? '—' }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('profile') }}" class="btn btn-success btn-sm">Manage Profile</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        window.notificationPreferencesUrl = "{{ route('settings.notification-preferences.update') }}";
    </script>
    <script src="{{ asset('js/client/settings.js') }}"></script>
@endsection
