@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <style>
        /* Keeps Ongoing Assessments / Calendar / My Tasks / My Recent Activity
           at a consistent height regardless of row count, so the two rows line up. */
        .dash-card { min-height: 420px; }
    </style>
@endsection

@section('content')

<div class="container-xxl px-4 py-4">

    <!-- Metric Cards -->
    <div class="row g-4 mb-4">

        <!-- Total Tasks -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Total Tasks</p>
                            <h3 class="mb-1 fw-medium">{{ $total }}</h3>
                            <p class="text-secondary mb-0 small">Assigned to you</p>
                        </div>
                        <div class="p-2 rounded bg-light">
                            <span class="material-symbols-outlined green-text">task_alt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Pending</p>
                            <h3 class="mb-1 fw-medium">{{ $pending }}</h3>
                            <p class="text-secondary mb-0 small">Not yet started</p>
                        </div>
                        <div class="p-2 rounded bg-warning bg-opacity-10">
                            <span class="material-symbols-outlined text-warning">pending_actions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">In Progress</p>
                            <h3 class="mb-1 fw-medium">{{ $inProgress }}</h3>
                            <p class="text-secondary mb-0 small">Currently working</p>
                        </div>
                        <div class="p-2 rounded bg-primary bg-opacity-10">
                            <span class="material-symbols-outlined" style="color: #0d6efd;">schedule</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="text-secondary mb-1 small">Completed</p>
                            <h3 class="mb-1 fw-medium">{{ $completed }}</h3>
                            <p class="text-secondary mb-0 small">Finished tasks</p>
                        </div>
                        <div class="p-2 rounded bg-success bg-opacity-10">
                            <span class="material-symbols-outlined green-text">check_circle</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Today's Assessments & Calendar Row -->
    <div class="row g-4 mb-4">

        <!-- Ongoing Assessments -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100 dash-card">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">Ongoing Assessments</h5>
                        <a href="{{ route('employee.assessments') }}" class="green-text text-decoration-none small">View all</a>
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
            <div class="card border-0 shadow-sm h-100 dash-card">
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
                                @if ($assessmentDays->contains($day))
                                    <div class="calendar-indicators">
                                        <span class="cal-dot bg-success"></span>
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
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tasks & Recent Activity Row -->
    <div class="row g-4">

        <!-- My Tasks -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100 dash-card">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">My Tasks</h5>
                        <a href="{{ route('employee.tasks') }}" class="green-text text-decoration-none small">View all</a>
                    </div>
                    @if ($myTasks->isEmpty())
                        <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="material-symbols-outlined text-muted" style="font-size:40px;">task_alt</span>
                            <p class="text-muted mt-2 mb-0 small">No active tasks right now.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 small align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 green-th">Task</th>
                                        <th class="border-0 green-th">Client</th>
                                        <th class="border-0 green-th">Due</th>
                                        <th class="border-0 green-th">Priority</th>
                                        <th class="border-0 green-th">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myTasks as $task)
                                        <tr>
                                            <td class="fw-semibold">{{ $task['title'] }}</td>
                                            <td>{{ $task['client_name'] }}</td>
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

        <!-- My Recent Activity -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100 dash-card">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">My Recent Activity</h5>
                        <a href="{{ route('admin-activity-logs') }}" class="green-text text-decoration-none small">View all</a>
                    </div>

                    @if ($recentActivity->isEmpty())
                        <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="material-symbols-outlined text-muted" style="font-size:40px;">history</span>
                            <p class="text-muted mt-2 mb-0 small">No recent activity yet.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach ($recentActivity as $activity)
                                <div class="d-flex align-items-start gap-3">
                                    <span class="activity-dot {{ $activity['dot_class'] }}"></span>
                                    <div class="flex-fill">
                                        <p class="mb-1 small">{{ $activity['description'] }}</p>
                                        <p class="text-secondary mb-0 small">{{ $activity['date'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
