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
                            <h3 class="mb-1 fw-medium">12</h3>
                            <p class="text-secondary mb-0 small">2 scheduled today</p>
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
                            <h3 class="mb-1 fw-medium">5</h3>
                            <p class="text-secondary mb-0 small">5 awaiting approval</p>
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
                            <h3 class="mb-1 fw-medium">8</h3>
                            <p class="text-secondary mb-0 small">1 due this week</p>
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
                            <h3 class="mb-1 fw-medium">8</h3>
                            <p class="text-secondary mb-0 small">2 overdue</p>
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
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">Ongoing Assessments</h5>
                        <a href="/admin/assessments" class="green-text text-decoration-none small">View all</a>
                    </div>

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
                                <tr>
                                    <td>8:00 AM</td>
                                    <td>Maria Santos</td>
                                    <td class="d-none d-xl-table-cell">Bacoor, Cavite</td>
                                    <td class="d-none d-lg-table-cell">CCTV</td>
                                    <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>8:30 AM</td>
                                    <td>Anna Garcia</td>
                                    <td class="d-none d-xl-table-cell">Dasmariñas</td>
                                    <td class="d-none d-lg-table-cell">Solar Street</td>
                                    <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>10:00 AM</td>
                                    <td>Pedro Cruz</td>
                                    <td class="d-none d-xl-table-cell">GMA, Cavite</td>
                                    <td class="d-none d-lg-table-cell">Public Address</td>
                                    <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>11:30 AM</td>
                                    <td>Lisa Tan</td>
                                    <td class="d-none d-xl-table-cell">Silang, Cavite</td>
                                    <td class="d-none d-lg-table-cell">CCTV</td>
                                    <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>1:00 PM</td>
                                    <td>John Reyes</td>
                                    <td class="d-none d-xl-table-cell">Imus, Cavite</td>
                                    <td class="d-none d-lg-table-cell">Solar Panel</td>
                                    <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Calendar -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-semibold mb-0">March 2026</h5>
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
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>

                        <!-- Calendar Days -->
                        <div class="calendar-day">1</div>
                        <div class="calendar-day">2</div>
                        <div class="calendar-day today">3
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                            </div>
                        </div>
                        <div class="calendar-day">4</div>
                        <div class="calendar-day">5
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                            </div>
                        </div>
                        <div class="calendar-day">6</div>
                        <div class="calendar-day">7</div>
                        <div class="calendar-day">8</div>
                        <div class="calendar-day">9</div>
                        <div class="calendar-day">10</div>
                        <div class="calendar-day">11</div>
                        <div class="calendar-day">12</div>
                        <div class="calendar-day today">13
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                            </div>
                        </div>
                        <div class="calendar-day">14</div>
                        <div class="calendar-day today active">15</div>
                        <div class="calendar-day">16</div>
                        <div class="calendar-day">17
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                            </div>
                        </div>
                        <div class="calendar-day">18</div>
                        <div class="calendar-day">19</div>
                        <div class="calendar-day">20
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                                <span class="cal-dot bg-warning"></span>
                            </div>
                        </div>
                        <div class="calendar-day">21</div>
                        <div class="calendar-day">22
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                            </div>
                        </div>
                        <div class="calendar-day">23</div>
                        <div class="calendar-day">24
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-success"></span>
                            </div>
                        </div>
                        <div class="calendar-day">25</div>
                        <div class="calendar-day">26</div>
                        <div class="calendar-day">27
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-warning"></span>
                            </div>
                        </div>
                        <div class="calendar-day">28
                            <div class="calendar-indicators">
                                <span class="cal-dot bg-warning"></span>
                            </div>
                        </div>
                        <div class="calendar-day">29</div>
                        <div class="calendar-day">30</div>
                        <div class="calendar-day">31</div>
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
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-semibold mb-0">Tasks</h5>
                        <a href="admin-tasks.php" class="green-text text-decoration-none small">View all</a>
                    </div>
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
                                <tr>
                                    <td class="fw-semibold">Run CAT6 Cabling</td>
                                    <td>Jomar Tan</td>
                                    <td>Apr 28, 2026</td>
                                    <td><span class="badge bg-warning text-dark rounded-pill">Medium</span></td>
                                    <td><span class="badge bg-primary rounded-pill">In Progress</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Install DVR and HDD</td>
                                    <td>Carlo Mendoza</td>
                                    <td>Apr 22, 2026</td>
                                    <td><span class="badge bg-danger rounded-pill">High</span></td>
                                    <td><span class="badge bg-secondary rounded-pill">To Do</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Configure NVR Settings</td>
                                    <td>Marco Rivera</td>
                                    <td>Apr 30, 2026</td>
                                    <td><span class="badge bg-success rounded-pill">Low</span></td>
                                    <td><span class="badge bg-primary rounded-pill">In Progress</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Access Card Programming</td>
                                    <td>Jomar Tan</td>
                                    <td class="text-danger fw-semibold">
                                        <span class="material-symbols-outlined"
                                            style="font-size:13px;vertical-align:middle;">warning</span>
                                        Apr 12, 2026
                                    </td>
                                    <td><span class="badge bg-danger rounded-pill">High</span></td>
                                    <td><span class="badge bg-warning text-dark rounded-pill">On Hold</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Mount Outdoor Cameras</td>
                                    <td>Ana</td>
                                    <td>Apr 26, 2026</td>
                                    <td><span class="badge bg-warning text-dark rounded-pill">Medium</span></td>
                                    <td><span class="badge bg-secondary rounded-pill">To Do</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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

                        <div class="d-flex align-items-start gap-3">
                            <span class="activity-dot bg-success"></span>
                            <div class="flex-fill">
                                <p class="mb-1 small">New assessment scheduled with Maria Santos for CCTV installation
                                </p>
                                <p class="text-secondary mb-0 small">March 15, 2026</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="activity-dot bg-primary"></span>
                            <div class="flex-fill">
                                <p class="mb-1 small">Quotation sent to John Reyes for Solar Panel Setup</p>
                                <p class="text-secondary mb-0 small">March 14, 2026</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="activity-dot bg-warning"></span>
                            <div class="flex-fill">
                                <p class="mb-1 small">Task "Install CCTV cameras" marked as In Progress</p>
                                <p class="text-secondary mb-0 small">March 14, 2026</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="activity-dot bg-danger"></span>
                            <div class="flex-fill">
                                <p class="mb-1 small">Low stock alert: Solar panels need reordering</p>
                                <p class="text-secondary mb-0 small">March 13, 2026</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="activity-dot bg-success"></span>
                            <div class="flex-fill">
                                <p class="mb-1 small">Assessment completed for Anna Garcia's project</p>
                                <p class="text-secondary mb-0 small">March 13, 2026</p>
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
{{-- <script src="{{ asset('js/admin/dashboard.js') }}"></script> --}}
@endsection
