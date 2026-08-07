@extends('layouts.client')

@section('title', 'Client Portal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/portal.css') }}">
@endsection

@section('content')

    @php
        $moduleIcons = [
            'Assessment' => 'calendar_month',
            'Quotation' => 'receipt_long',
            'Project' => 'folder_open',
            'Checklist' => 'checklist',
            'Client' => 'inbox',
        ];

        $actionBadges = [
            'Requested' => ['label' => 'UNDER REVIEW', 'class' => 'badge-review'],
            'Approved' => ['label' => 'CONFIRMED', 'class' => 'badge-confirmed'],
            'Rejected' => ['label' => 'DECLINED', 'class' => 'badge-awaiting'],
            'Created' => ['label' => 'SUBMITTED', 'class' => 'badge-review'],
            'Updated' => ['label' => 'IN PROGRESS', 'class' => 'badge-inprogress'],
            'Archived' => ['label' => 'ARCHIVED', 'class' => 'badge-review'],
        ];
    @endphp

    <!-- ============================================================
                                        HERO BAND
                                        ============================================================ -->
    <section class="portal-hero">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between gap-3 pt-2">
                <div>
                    <p class="portal-hero-eyebrow mb-1">WELCOME BACK</p>
                    <h1 class="portal-hero-title mb-2">Hello, Maria</h1>
                    <p class="portal-hero-sub mb-0">
                        Here's an overview of your assessments, quotations, and active projects<br class="d-none d-md-block">
                        with A We Green Enterprise.
                    </p>
                </div>
                <a href="{{ route('client-assessment') }}"
                    class="btn btn-gold-portal btn-light align-self-start flex-shrink-0">
                    <span class="material-symbols-outlined fs-18">add</span>
                    Request Assessment
                </a>
            </div>

            <!-- Stat cards — overlap hero bottom -->
            <div class="row g-3 portal-stats-row">
                <div class="col-6 col-lg-3">
                    <div class="portal-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="portal-stat-label">ACTIVE REQUESTS</p>
                                <p class="portal-stat-value">2</p>
                            </div>
                            <span class="portal-stat-icon stat-accent">
                                <span class="material-symbols-outlined">inbox</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="portal-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="portal-stat-label">PENDING QUOTATIONS</p>
                                <p class="portal-stat-value">1</p>
                            </div>
                            <span class="portal-stat-icon stat-highlight">
                                <span class="material-symbols-outlined">receipt_long</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="portal-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="portal-stat-label">ONGOING PROJECTS</p>
                                <p class="portal-stat-value">1</p>
                            </div>
                            <span class="portal-stat-icon stat-secondary">
                                <span class="material-symbols-outlined">folder_open</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="portal-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="portal-stat-label">COMPLETED</p>
                                <p class="portal-stat-value">3</p>
                            </div>
                            <span class="portal-stat-icon stat-primary">
                                <span class="material-symbols-outlined">check_circle</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
                                                MAIN CONTENT
                                                ============================================================ -->
    <div class="container-fluid px-4 portal-content-wrap">
        <div class="portal-content-inner">

            <!-- Quick actions -->
            <section class="mb-4 mt-4">
                <h2 class="portal-section-title">Quick actions</h2>
                <p class="portal-section-sub">Get things moving in a few clicks.</p>

                <div class="row g-3 mt-1">
                    <!-- Book assessment -->
                    <div class="col-md-3">
                        <div class="portal-action-card h-100">
                            <span class="portal-action-icon">
                                <span class="material-symbols-outlined">calendar_month</span>
                            </span>
                            <h3 class="portal-action-title">Book a Site Assessment</h3>
                            <p class="portal-action-desc">Schedule a free on-site visit with our engineers in 5 quick steps.
                            </p>
                            <a href="{{ route('client-assessment') }}"
                                class="btn btn-portal-primary mt-auto align-self-start">
                                Start booking <span class="material-symbols-outlined fs-15">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- My Requests -->
                    <div class="col-md-3">
                        <div class="portal-action-card h-100">
                            <span class="portal-action-icon">
                                <span class="material-symbols-outlined">inbox</span>
                            </span>
                            <h3 class="portal-action-title">View My Requests</h3>
                            <p class="portal-action-desc">Track the status of every assessment you've submitted.</p>
                            <a href="{{ route('client-assessment', ['tab' => 'history']) }}"
                                class="btn btn-portal-outline mt-auto align-self-start">
                                Open requests <span class="material-symbols-outlined fs-15">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Quotations -->
                    <div class="col-md-3">
                        <div class="portal-action-card h-100">
                            <span class="portal-action-icon">
                                <span class="material-symbols-outlined">receipt_long</span>
                            </span>
                            <h3 class="portal-action-title">Review Quotations</h3>
                            <p class="portal-action-desc">See pricing, scope, and approve quotes from our team.</p>
                            <a href="{{ route('client-quotation') }}"
                                class="btn btn-portal-outline mt-auto align-self-start">
                                View quotes <span class="material-symbols-outlined fs-15">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="col-md-3">
                        <div class="portal-action-card h-100">
                            <span class="portal-action-icon">
                                <span class="material-symbols-outlined">folder_open</span>
                            </span>
                            <h3 class="portal-action-title">Track My Projects</h3>
                            <p class="portal-action-desc">Follow installation progress from start to completion.</p>
                            <a href="{{ route('client-project') }}" class="btn btn-portal-outline mt-auto align-self-start">
                                View projects <span class="material-symbols-outlined fs-15">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recent activity + Help -->
            <section>
                <div class="row g-4">
                    <!-- Activity feed -->
                    <div class="col-lg-8">
                        <div class="portal-card recent-activity">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h2 class="portal-section-title mb-0">Recent activity</h2>
                                    <p class="portal-section-sub mb-0">Your latest updates across the portal.</p>
                                </div>
                                <a href="{{ route('activity-logs') }}" class="portal-view-all">
                                    View all <span class="material-symbols-outlined fs-15"
                                        style="vertical-align:middle;">arrow_forward</span>
                                </a>
                            </div>

                            @if ($today->isEmpty() && $thisWeek->isEmpty() && $older->isEmpty())
                                <div class="text-center py-5">
                                    <span class="material-symbols-outlined text-muted" style="font-size:40px;">inbox</span>
                                    <p class="text-muted mt-2 mb-0">No activity yet. Your assessment, quotation, and project
                                        updates will show up here.</p>
                                </div>
                            @else
                                @foreach (['TODAY' => $today, 'THIS WEEK' => $thisWeek, 'OLDER' => $older] as $label => $group)
                                    @if ($group->isNotEmpty())
                                        <p
                                            class="activity-group-label @unless ($loop->first) mt-4 @endunless">
                                            {{ $label }}</p>
                                        <ul class="list-unstyled activity-list mb-0">
                                            @foreach ($group as $log)
                                                @php
                                                    $badge = $actionBadges[$log->action] ?? [
                                                        'label' => strtoupper($log->action),
                                                        'class' => 'badge-review',
                                                    ];
                                                    $icon = $moduleIcons[$log->module] ?? 'inbox';
                                                @endphp
                                                <li>
                                                    <a href="#" class="activity-item text-decoration-none">
                                                        <span class="activity-icon">
                                                            <span
                                                                class="material-symbols-outlined">{{ $icon }}</span>
                                                        </span>
                                                        <div class="flex-1">
                                                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                                                <span class="activity-title">{{ $log->module }}
                                                                    {{ strtolower($log->action) }}</span>
                                                                <span
                                                                    class="activity-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                                            </div>
                                                            <p class="activity-detail mb-1">{{ $log->description }}</p>
                                                            <p class="activity-date mb-0">
                                                                <span class="material-symbols-outlined fs-12"
                                                                    style="vertical-align:middle;">schedule</span>
                                                                {{ $log->created_at->format('M j, Y · g:i A') }}
                                                            </p>
                                                        </div>
                                                        <span
                                                            class="activity-arrow material-symbols-outlined">arrow_forward</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Need a hand -->
                    <div class="col-lg-4 d-none d-md-block">
                        <div class="portal-help-card h-100">
                            <span class="portal-help-icon">
                                <span class="material-symbols-outlined fs-22">error</span>
                            </span>
                            <h3 class="portal-help-title mt-3">Need a hand?</h3>
                            <p class="portal-help-sub">
                                Our team is happy to walk you through your assessment, quotation, or project status.
                            </p>
                            <div class="d-flex flex-column gap-2 mt-4">
                                <a href="tel:+639998845671" class="portal-help-contact">
                                    <span class="material-symbols-outlined portal-help-contact-icon">call</span>
                                    <div>
                                        <div class="portal-help-contact-label">CALL US</div>
                                        <div class="portal-help-contact-value">
                                            Smart: 0998 884 5671 <br>
                                            Globe: 0917 752 3343 <br>
                                            Landline: (046) 443 6374
                                        </div>
                                    </div>
                                </a>
                                <a href="mailto:info@awegreen.ph" class="portal-help-contact">
                                    <span class="material-symbols-outlined portal-help-contact-icon">mail</span>
                                    <div>
                                        <div class="portal-help-contact-label">EMAIL</div>
                                        <div class="portal-help-contact-value">awegreen@gmail.com</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection
