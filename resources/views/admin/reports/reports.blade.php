@extends('layouts.admin')

@section('title', 'Reports')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/reports/reports.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endsection

@section('page-title', 'Reports')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" onclick="window.print()">
        <span class="material-symbols-outlined fs-17">picture_as_pdf</span>
        Export PDF
    </button>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text"
        data-bs-toggle="modal" data-bs-target="#generateReportModal">
        <span class="material-symbols-outlined fs-17">summarize</span>
        Generate Report
    </button>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weeklyTab" type="button">Weekly Report</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthlyTab" type="button">Monthly Report</button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- ── Weekly Tab ── -->
            <div class="tab-pane fade show active" id="weeklyTab" role="tabpanel">

                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">calendar_month</span></div>
                            <div><p class="report-label">Assessments</p><p class="report-value">14</p></div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">description</span></div>
                            <div><p class="report-label">Quotations Sent</p><p class="report-value">9</p></div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">folder_open</span></div>
                            <div><p class="report-label">Completed Projects</p><p class="report-value">3</p></div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">payments</span></div>
                            <div><p class="report-label">Total Project Cost</p><p class="report-value green-text">₱1.09M</p></div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 1 -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Assessments per Week</p>
                            <div class="position-relative hpx-260 wp-100"><canvas id="weeklyAssessmentsBar"></canvas></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Quotation Status Breakdown</p>
                            <div class="position-relative hpx-200 wp-100"><canvas id="weeklyQuotationDoughnut"></canvas></div>
                            <div class="d-flex justify-content-center flex-wrap gap-3 mt-3 w-100" id="weeklyDoughnutLegend"></div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 2 -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Client Growth (Total Users)</p>
                            <div class="position-relative hpx-260 wp-100"><canvas id="weeklyClientLine"></canvas></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Accepted vs Rejected Quotations</p>
                            <div class="position-relative hpx-260 wp-100"><canvas id="weeklyAcceptRejectBar"></canvas></div>
                        </div>
                    </div>
                </div>

                <!-- Quotation Table -->
                <div class="row g-4">
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <p class="chart-card-title mb-0">Quotation Status</p>
                                <a href="#" class="green-text text-decoration-none small">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Client</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Service</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Amount</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Date Sent</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Maria Santos</td><td>CCTV Installation</td><td>₱45,000</td><td>Mar 10, 2026</td><td><span class="badge bg-success rounded-pill">Approved</span></td></tr>
                                        <tr><td>John Reyes</td><td>Solar Panel Setup</td><td>₱120,000</td><td>Mar 11, 2026</td><td><span class="badge bg-success rounded-pill">Approved</span></td></tr>
                                        <tr><td>Anna Garcia</td><td>Solar Street Light</td><td>₱850,000</td><td>Mar 12, 2026</td><td><span class="badge bg-primary rounded-pill">Sent</span></td></tr>
                                        <tr><td>Pedro Cruz</td><td>Public Address</td><td>₱95,000</td><td>Mar 13, 2026</td><td><span class="badge bg-warning text-dark rounded-pill">For Review</span></td></tr>
                                        <tr><td>Lisa Tan</td><td>CCTV Installation</td><td>₱55,000</td><td>Mar 14, 2026</td><td><span class="badge bg-danger rounded-pill">Rejected</span></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /weeklyTab -->


            <!-- ── Monthly Tab ── -->
            <div class="tab-pane fade" id="monthlyTab" role="tabpanel">

                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">calendar_month</span></div>
                            <div><p class="report-label">Assessments</p><p class="report-value">52</p></div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-primary-subtle"><span class="material-symbols-outlined text-primary">description</span></div>
                            <div><p class="report-label">Quotations Sent</p><p class="report-value">38</p></div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">folder_open</span></div>
                            <div><p class="report-label">Completed Projects</p><p class="report-value">11</p></div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="report-card">
                            <div class="report-icon-wrap bg-success-subtle"><span class="material-symbols-outlined text-success">payments</span></div>
                            <div><p class="report-label">Total Project Cost</p><p class="report-value green-text">₱4.35M</p></div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 1 -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Assessments per Month</p>
                            <div style="position:relative;width:100%;height:260px;"><canvas id="monthlyAssessmentsBar"></canvas></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Quotation Status Breakdown</p>
                            <div style="position:relative;width:100%;height:200px;"><canvas id="monthlyQuotationDoughnut"></canvas></div>
                            <div class="d-flex justify-content-center flex-wrap gap-3 mt-3 w-100" id="monthlyDoughnutLegend"></div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 2 -->
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Client Growth (Total Users)</p>
                            <div style="position:relative;width:100%;height:260px;"><canvas id="monthlyClientLine"></canvas></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="chart-card">
                            <p class="chart-card-title">Accepted vs Rejected Quotations</p>
                            <div style="position:relative;width:100%;height:260px;"><canvas id="monthlyAcceptRejectBar"></canvas></div>
                        </div>
                    </div>
                </div>

                <!-- Quotation Table -->
                <div class="row g-4">
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <p class="chart-card-title mb-0">Quotation Status</p>
                                <a href="#" class="green-text text-decoration-none small">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Client</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Service</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Amount</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Date Sent</th>
                                            <th class="border-0 green-text" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Maria Santos</td><td>CCTV Installation</td><td>₱45,000</td><td>Mar 10, 2026</td><td><span class="badge bg-success rounded-pill">Approved</span></td></tr>
                                        <tr><td>John Reyes</td><td>Solar Panel Setup</td><td>₱120,000</td><td>Mar 11, 2026</td><td><span class="badge bg-success rounded-pill">Approved</span></td></tr>
                                        <tr><td>Anna Garcia</td><td>Solar Street Light</td><td>₱850,000</td><td>Mar 12, 2026</td><td><span class="badge bg-primary rounded-pill">Sent</span></td></tr>
                                        <tr><td>Pedro Cruz</td><td>Public Address</td><td>₱95,000</td><td>Mar 13, 2026</td><td><span class="badge bg-warning text-dark rounded-pill">For Review</span></td></tr>
                                        <tr><td>Lisa Tan</td><td>CCTV Installation</td><td>₱55,000</td><td>Mar 14, 2026</td><td><span class="badge bg-danger rounded-pill">Rejected</span></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /monthlyTab -->

        </div><!-- /tab-content -->
    </div>


    <!-- ── Generate Report Modal ── -->
    <div class="modal fade" id="generateReportModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined green-text fs-22">summarize</span>
                        <h5 class="modal-title mb-0">Generate Report</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Controls -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing:.05em;">Report Type</label>
                            <select class="form-select" id="reportTypeSelect">
                                <option value="">— Select a report —</option>
                                <option value="checklist">Checklist Report</option>
                                <option value="tasks">Task Completion Report</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing:.05em;">Date From</label>
                            <input type="date" class="form-control" id="reportDateFrom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing:.05em;">Date To</label>
                            <input type="date" class="form-control" id="reportDateTo">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-1" onclick="generateReport()">
                                <span class="material-symbols-outlined fs-17">search</span>
                                Generate
                            </button>
                        </div>
                    </div>

                    <!-- Quick Presets -->
                    <div class="d-flex flex-wrap gap-2 mb-4" id="datePresets">
                        <span class="report-preset-label">Quick select:</span>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" onclick="setPreset('this_week',this)">This Week</button>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" onclick="setPreset('last_week',this)">Last Week</button>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" onclick="setPreset('this_month',this)">This Month</button>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" onclick="setPreset('last_month',this)">Last Month</button>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" onclick="setPreset('this_year',this)">This Year</button>
                    </div>

                    <!-- Placeholder -->
                    <div id="reportPlaceholder" class="report-placeholder">
                        <span class="material-symbols-outlined">query_stats</span>
                        <p>Select a report type and date range, then click <strong>Generate</strong>.</p>
                    </div>

                    <!-- Output -->
                    <div id="reportOutput" style="display:none;">
                        <div id="printableReport">

                            <!-- Letterhead -->
                            <div class="rpt-letterhead">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="flex-grow-1">
                                        <h2 class="rpt-company-name">A WE GREEN ENTERPRISE</h2>
                                        <p class="rpt-company-address mb-0">Alta Tierra Homes Phase 4 Blk 51 Lot 30 Brgy. A. Olaes, Gen. Mariano Alvarez, Cavite 4117</p>
                                        <p class="rpt-company-contact mb-0">Smart: 0998 884 5671 &bull; 0998 884 5670 &nbsp; Globe: 0917 752 3343 &nbsp; Landline: 046 443 6374</p>
                                        <p class="rpt-company-contact mb-0">E-mail: awegreenenterprise@gmail.com</p>
                                        <p class="rpt-company-contact mb-0">DTI Reg. No: 1748459 &nbsp; BIR Reg. No: 5AARC20240000002223</p>
                                    </div>
                                    <div class="rpt-logo-box">
                                        <img src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green" style="height:64px;width:auto;">
                                    </div>
                                </div>
                                <div class="rpt-divider"></div>
                            </div>

                            <!-- Meta -->
                            <div class="rpt-meta-row">
                                <div><span class="rpt-meta-label">Date:</span><span class="rpt-meta-value" id="rpt-date-label">—</span></div>
                                <div><span class="rpt-meta-label">Period:</span><span class="rpt-meta-value" id="rpt-period-label">—</span></div>
                                <div><span class="rpt-meta-label">Prepared by:</span><span class="rpt-meta-value">Admin</span></div>
                            </div>

                            <div class="rpt-subject-line">SUBJECT: <span id="rpt-subject-text">—</span></div>
                            <div class="rpt-summary-row" id="rpt-summary-row"></div>
                            <div class="table-responsive mt-3" id="rpt-table-wrap"></div>
                            <div class="rpt-terms-section" id="rpt-terms-section"></div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        id="printReportBtn" style="display:none!important;" onclick="printReport()">
                        <span class="material-symbols-outlined fs-17">print</span> Print
                    </button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                        id="exportReportBtn" style="display:none!important;" onclick="printReport()">
                        <span class="material-symbols-outlined fs-17">picture_as_pdf</span> Export / Print
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="{{ asset('js/admin/reports.js') }}"></script>