@extends('layouts.admin')

@section('title', 'Settings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin-settings.css') }}">
@endsection

@section('page-title', 'Settings')

@section('content')

    <div class="container-xxl px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="settings-card">
                    <div class="settings-card-header">
                        <span class="material-symbols-outlined">notifications</span>
                        Notification Preferences
                    </div>
                    <div class="settings-card-body">
                        <p class="settings-hint mb-4">Choose which system events you'd like to be notified about.</p>

                        <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div>
                                <p class="settings-label mb-1">Assessment Requests</p>
                                <p class="settings-hint mb-0">New assessment requests submitted by clients.</p>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-assessment" data-pref="notify_assessment"
                                    {{ $staff->notify_assessment ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div>
                                <p class="settings-label mb-1">Quotation Updates</p>
                                <p class="settings-hint mb-0">Quotations approved or revisions requested by clients.</p>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-quotation" data-pref="notify_quotation"
                                    {{ $staff->notify_quotation ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div>
                                <p class="settings-label mb-1">Task Updates</p>
                                <p class="settings-hint mb-0">Tasks assigned to you, put on hold, or reopened.</p>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-task" data-pref="notify_task"
                                    {{ $staff->notify_task ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div>
                                <p class="settings-label mb-1">Project Updates</p>
                                <p class="settings-hint mb-0">Projects created, status changed, put on hold, or completed.</p>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-project" data-pref="notify_project"
                                    {{ $staff->notify_project ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3">
                            <div>
                                <p class="settings-label mb-1">Checklist Updates</p>
                                <p class="settings-hint mb-0">Checklist items completed, updated, or marked unavailable.</p>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input js-notif-pref" type="checkbox" role="switch"
                                    id="notif-checklist" data-pref="notify_checklist"
                                    {{ $staff->notify_checklist ? 'checked' : '' }}>
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
        window.notificationPreferencesUrl = "{{ route('employee.settings.notification-preferences.update') }}";
    </script>
    <script src="{{ asset('js/admin/settings.js') }}"></script>
@endsection
