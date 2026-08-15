@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    {{-- ========== DASHBOARD CSS ========== --}}
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    {{-- ========== CHARTS ========== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endsection

@section('content')

@section('topbar-actions')
    <a href="{{ route('portal') }}" class="btn btn-sm btn-outline-light fw-semibold">
        View Client Portal
    </a>
@endsection

<div class="container-xxl px-4 py-4">

    <!-- Metric Cards -->
    <div class="row g-4 mb-4">

        <!-- Assessments This Month -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Assessments This Month</p>
                            <h3 class="mb-1 fw-medium">{{ $assessmentsThisMonth }}</h3>
                            <p class="text-secondary mb-0 small">{{ $assessmentsToday }} scheduled today</p>
                        </div>
                        <div class="p-2 rounded bg-light">
                            <span class="material-symbols-outlined green-text">event_available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Quotations -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Pending Quotations</p>
                            <h3 class="mb-1 fw-medium">{{ $pendingQuotations }}</h3>
                            <p class="text-secondary mb-0 small">{{ $pendingQuotations }} awaiting approval</p>
                        </div>
                        <div class="p-2 rounded bg-warning bg-opacity-10">
                            <span class="material-symbols-outlined text-warning">request_quote</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Active Projects</p>
                            <h3 class="mb-1 fw-medium">{{ $activeProjects }}</h3>
                            <p class="text-secondary mb-0 small">{{ $projectsDueThisWeek }} due this week</p>
                        </div>
                        <div class="p-2 rounded bg-primary bg-opacity-10">
                            <span class="material-symbols-outlined" style="color: #0d6efd;">folder</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Overview -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Tasks This Week</p>
                            <h3 class="mb-1 fw-medium">{{ $tasksThisWeek }}</h3>
                            <p class="text-secondary mb-0 small">{{ $tasksOverdue }} overdue</p>
                        </div>
                        <div class="p-2 rounded bg-success bg-opacity-10">
                            <span class="material-symbols-outlined green-text">task_alt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Upcoming Assessments & Calendar Row -->
    <div class="row g-4 mb-4">

        <!-- Ongoing Assessments Table -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">Ongoing Assessments</h5>
                        <a href="/admin/assessments" class="green-text text-decoration-none small">View all</a>
                    </div>

                    @if ($ongoingAssessments->isEmpty())
                        <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="material-symbols-outlined text-muted" style="font-size:40px;">event_available</span>
                            <p class="text-muted mt-2 mb-0 small">No assessments scheduled for today.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 small green-text">Time</th>
                                        <th class="border-0 small green-text">Client</th>
                                        <th class="border-0 small d-none d-xl-table-cell green-text">Location</th>
                                        <th class="border-0 small d-none d-lg-table-cell green-text">Service</th>
                                        <th class="border-0 small green-text">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="small">
                                    @foreach ($ongoingAssessments as $assessment)
                                        <tr>
                                            <td>{{ $assessment->time_slot }}</td>
                                            <td>{{ $assessment->client->user->full_name }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                {{ collect([$assessment->client->barangay, $assessment->client->city])->filter()->implode(', ') ?: '—' }}
                                            </td>
                                            <td class="d-none d-lg-table-cell">{{ collect($assessment->services)->implode(', ') }}</td>
                                            <td>
                                                <span class="badge rounded-pill @if ($assessment->status === 'Confirmed') bg-success @else bg-warning text-dark @endif">
                                                    {{ $assessment->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mini Calendar -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-semibold mb-0">{{ $now->format('F Y') }}</h5>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-light border-0">
                                <span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span>
                            </button>
                            <button class="btn btn-sm btn-light border-0">
                                <span class="material-symbols-outlined" style="font-size: 20px;">chevron_right</span>
                            </button>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="calendar-grid mb-3">
                        <!-- Week Days Header -->
                        <div class="calendar-header">Su</div>
                        <div class="calendar-header">Mo</div>
                        <div class="calendar-header">Tu</div>
                        <div class="calendar-header">We</div>
                        <div class="calendar-header">Th</div>
                        <div class="calendar-header">Fr</div>
                        <div class="calendar-header">Sa</div>

                        <!-- Empty cells before month starts -->
                        @for ($i = 0; $i < $calendarLeadingBlanks; $i++)
                            <div></div>
                        @endfor

                        <!-- Calendar Days -->
                        @for ($day = 1; $day <= $calendarDaysInMonth; $day++)
                            <div class="calendar-day {{ $day === $now->day ? 'today active' : '' }}">
                                {{ $day }}
                                @if ($assessmentDays->contains($day) || $projectDueDays->contains($day))
                                    <div class="calendar-indicators">
                                        @if ($assessmentDays->contains($day))
                                            <span class="cal-dot bg-success"></span>
                                        @endif
                                        @if ($projectDueDays->contains($day))
                                            <span class="cal-dot bg-warning"></span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>

                    <!-- Calendar Legend -->
                    <div class="d-flex gap-3 small text-secondary">
                        <div class="d-flex align-items-center gap-2">
                            <span class="cal-dot bg-success"></span> Assessment
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="cal-dot bg-warning"></span> Project Due
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tasks & Recent Activity Row -->
    <div class="row g-4">

        <!-- Tasks -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">Tasks</h5>
                        <a href="admin-tasks.php" class="green-text text-decoration-none small">View all</a>
                    </div>
                    @if ($mergedTasks->isEmpty())
                        <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="material-symbols-outlined text-muted" style="font-size:40px;">task_alt</span>
                            <p class="text-muted mt-2 mb-0 small">No active tasks.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 small align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 green-th">Task</th>
                                        <th class="border-0 green-th">Assigned To</th>
                                        <th class="border-0 green-th">Due</th>
                                        <th class="border-0 green-th">Priority</th>
                                        <th class="border-0 green-th">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mergedTasks as $task)
                                        <tr>
                                            <td class="fw-semibold">{{ $task['title'] }}</td>
                                            <td>{{ $task['employee_name'] }}</td>
                                            <td class="{{ $task['is_overdue'] ? 'text-danger fw-semibold' : '' }}">
                                                @if ($task['is_overdue'])
                                                    <span class="material-symbols-outlined"
                                                        style="font-size:13px;vertical-align:middle;">warning</span>
                                                @endif
                                                {{ $task['due_date']->format('M j, Y') }}
                                            </td>
                                            <td><span class="badge {{ $task['priority']['class'] }} rounded-pill">{{ $task['priority']['label'] }}</span></td>
                                            <td><span class="badge {{ $task['status_display']['class'] }} rounded-pill">{{ $task['status_display']['label'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold">Recent Activity</h5>
                        <a href="admin-tasks.php" class="green-text text-decoration-none small">View all</a>
                    </div>

                    <div class="d-flex flex-column gap-3">

                        @forelse ($recentActivity as $activity)
                            <div class="d-flex align-items-start gap-3">
                                <span class="activity-dot {{ $activity['dot_class'] }}"></span>
                                <div class="flex-fill">
                                    <p class="mb-1 small">{{ $activity['description'] }}</p>
                                    <p class="text-secondary mb-0 small">{{ $activity['date'] }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-secondary small mb-0">No recent activity yet.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
{{-- <script src="{{ asset('js/admin/dashboard.js') }}"></script> --}}
@endsection
