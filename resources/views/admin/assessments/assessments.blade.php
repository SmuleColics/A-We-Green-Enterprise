@extends('layouts.admin')

@section('title', 'Assessment Schedule')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/assessments.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

@section('page-title', 'Assessments')

@section('topbar-actions')
    <a href="{{ route('archive-assessments') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center green-text" data-bs-toggle="modal"
        data-bs-target="#scheduleModal">
        <span class="material-symbols-outlined me-1 fs-18">add</span>
        Schedule Assessment
    </button>
@endsection

<div class="container-fluid px-4 py-4">

    <!-- Tabs + Archive Button -->
    <div class="d-flex align-items-center justify-content-between mb-4">

        <ul class="nav nav-tabs border-0 mb-0" id="assessmentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-view"
                    type="button">
                    Calendar View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button">
                    List View
                </button>
            </li>
        </ul>

        <a href="{{ route('requests') }}"
            class="btn btn-sm btn-outline-secondary fw-semibold d-flex align-items-center gap-1">
            View Assessment Requests
        </a>

    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="assessmentTabsContent">

        <!-- ── Calendar View ── -->
        <!-- ── Calendar View ── -->
        <div class="tab-pane fade show active" id="calendar-view" role="tabpanel">
            <div class="calendar-container">

                <!-- Calendar Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-semibold mb-0">March 2026</h5>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-light border">
                            <span class="material-symbols-outlined fs-5">chevron_left</span>
                        </button>
                        <button class="btn btn-sm btn-light border">
                            <span class="material-symbols-outlined fs-5">chevron_right</span>
                        </button>
                    </div>
                </div>

                <!-- Full Calendar Grid -->
                <div class="full-calendar-grid">

                    <!-- Day Headers -->
                    <div class="calendar-header-cell">Sun</div>
                    <div class="calendar-header-cell">Mon</div>
                    <div class="calendar-header-cell">Tue</div>
                    <div class="calendar-header-cell">Wed</div>
                    <div class="calendar-header-cell">Thu</div>
                    <div class="calendar-header-cell">Fri</div>
                    <div class="calendar-header-cell">Sat</div>

                    <!-- Empty offset cells -->
                    <div class="calendar-cell no-work"></div>
                    <div class="calendar-cell no-work"></div>
                    <div class="calendar-cell no-work"></div>
                    <div class="calendar-cell no-work"></div>
                    <div class="calendar-cell no-work"></div>
                    <div class="calendar-cell no-work"></div>

                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 1, 2026', [])">
                        <div class="calendar-date">1</div>
                    </div>
                    <div class="calendar-cell no-work">
                        <div class="calendar-date">2</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 3, 2026', [])">
                        <div class="calendar-date">3</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 4, 2026', [])">
                        <div class="calendar-date">4</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 5, 2026', [])">
                        <div class="calendar-date">5</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 6, 2026', [])">
                        <div class="calendar-date">6</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 7, 2026', [])">
                        <div class="calendar-date">7</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 8, 2026', [])">
                        <div class="calendar-date">8</div>
                    </div>
                    <div class="calendar-cell no-work">
                        <div class="calendar-date">9</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 10, 2026', [])">
                        <div class="calendar-date">10</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 11, 2026', [])">
                        <div class="calendar-date">11</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 12, 2026', [])">
                        <div class="calendar-date">12</div>
                    </div>

                    <div class="calendar-cell fully-booked calendar-clickable"
                        onclick="openDayModal('March 13, 2026', [
        {time:'8:00 AM', client:'Maria Santos', contact:'0917-123-4567', email:'maria@email.com', clientType:'Residential', service:'CCTV Setup', establishment:'Home / Residence', assessor:'Marco Rivera', slot:'Morning', status:'Done Assessment', statusClass:'success', cluster:'Cluster 1', block:'Block 3', lot:'Lot 12', brgy:'Brgy. Molino III', city:'Bacoor', province:'Cavite', zip:'4102', notes:'Client needs outdoor cameras.', date:'Mar 13, 2026'},
        {time:'1:00 PM', client:'Juan dela Cruz', contact:'0918-555-7777', email:'', clientType:'Commercial', service:'Solar Setup', establishment:'Office / Commercial', assessor:'Carlo Mendoza', slot:'Afternoon', status:'Pending', statusClass:'warning text-dark', cluster:'', block:'Block 6', lot:'Lot 3', brgy:'Brgy. Poblacion', city:'Imus', province:'Cavite', zip:'4103', notes:'', date:'Mar 13, 2026'}
      ])">
                        <div class="calendar-date">13</div>
                        <div class="calendar-booking"><small class="d-block text-truncate">AM — Maria</small></div>
                        <div class="calendar-booking"><small class="d-block text-truncate">PM — Juan</small></div>
                    </div>

                    <div class="calendar-cell fully-booked calendar-clickable"
                        onclick="openDayModal('March 14, 2026', [
        {time:'Full Day', client:'Brgy. San Jose', contact:'046-123-4567', email:'brgysanjose@gmail.com', clientType:'Government/LGU', service:'Solar Street Light', establishment:'Government Facility', assessor:'Ana Garcia', slot:'Full Day', status:'Pending', statusClass:'warning text-dark', cluster:'', block:'', lot:'', brgy:'Brgy. San Jose', city:'Dasmariñas', province:'Cavite', zip:'4114', notes:'Streetlights along the main barangay road.', date:'Mar 14, 2026'}
    ])">
                        <div class="calendar-date">14</div>
                        <div class="calendar-booking"><small class="d-block text-truncate">Full Day — Brgy.</small>
                        </div>
                    </div>

                    <div class="calendar-cell today calendar-clickable"
                        onclick="openDayModal('March 15, 2026', [
        {time:'8:00 AM', client:'Pedro Cruz', contact:'0919-888-2222', email:'pedro.cruz@email.com', clientType:'Commercial', service:'Public Address System', establishment:'Office / Commercial', assessor:'Marco Rivera', slot:'Morning', status:'Done Assessment', statusClass:'success', cluster:'', block:'Block 2', lot:'Lot 8', brgy:'Brgy. GMA', city:'General Mariano Alvarez', province:'Cavite', zip:'4117', notes:'', date:'Mar 15, 2026'}
    ])">
                        <div class="calendar-date text-white">15</div>
                        <div class="calendar-booking"><small class="d-block text-truncate">AM — Pedro</small></div>
                    </div>
                    <div class="calendar-cell no-work">
                        <div class="calendar-date">16</div>
                    </div>

                    <div class="calendar-cell half-booked calendar-clickable"
                        onclick="openDayModal('March 17, 2026', [
        {time:'1:00 PM', client:'ABC Company', contact:'046-987-6543', email:'contact@abccompany.com', clientType:'Commercial', service:'CCTV Setup', establishment:'Office / Commercial', assessor:'Carlo Mendoza', slot:'Afternoon', status:'Pending', statusClass:'warning text-dark', cluster:'', block:'Block 1', lot:'Lot 4', brgy:'Brgy. Salawag', city:'Dasmariñas', province:'Cavite', zip:'4114', notes:'Requesting perimeter coverage for warehouse.', date:'Mar 17, 2026'}
    ])">
                        <div class="calendar-date">17</div>
                        <div class="calendar-booking"><small class="d-block text-truncate">PM — ABC</small></div>
                    </div>

                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 18, 2026', [])">
                        <div class="calendar-date">18</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 19, 2026', [])">
                        <div class="calendar-date">19</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 20, 2026', [])">
                        <div class="calendar-date">20</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 21, 2026', [])">
                        <div class="calendar-date">21</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 22, 2026', [])">
                        <div class="calendar-date">22</div>
                    </div>
                    <div class="calendar-cell no-work">
                        <div class="calendar-date">23</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 24, 2026', [])">
                        <div class="calendar-date">24</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 25, 2026', [])">
                        <div class="calendar-date">25</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 26, 2026', [])">
                        <div class="calendar-date">26</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 27, 2026', [])">
                        <div class="calendar-date">27</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 28, 2026', [])">
                        <div class="calendar-date">28</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 29, 2026', [])">
                        <div class="calendar-date">29</div>
                    </div>
                    <div class="calendar-cell no-work">
                        <div class="calendar-date">30</div>
                    </div>
                    <div class="calendar-cell calendar-clickable" onclick="openDayModal('March 31, 2026', [])">
                        <div class="calendar-date">31</div>
                    </div>

                </div>

                <!-- Calendar Legend -->
                <div class="d-flex flex-wrap gap-4 mt-3 small text-muted">
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#d4f1e0;border:1px solid #aaa;"></span> Available
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#e0f7fa;"></span> Half Booked
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#f3e5f5;"></span> Fully Booked
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:var(--awg-primary);"></span> Today
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:#f8f9fa;border:1px solid #dee2e6;"></span> No Work
                    </div>
                </div>

            </div>
        </div>

        <!-- ── List View ── -->
        <div class="tab-pane fade" id="list-view" role="tabpanel">
            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-primary">inbox</span>
                        <div>
                            <p class="summary-label">Total</p>
                            <p class="summary-value">18</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon muted-text" ">assignment</span>
                        <div>
                            <p class="summary-label">Submitted Form</p>
                            <p class="summary-value">2</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                        <div>
                            <p class="summary-label">Pending</p>
                            <p class="summary-value">4</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                        <div>
                            <p class="summary-label">Done Assessment</p>
                            <p class="summary-value">12</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                            <button type="button" class="btn btn-sm btn-outline-secondary active"
                                data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="To Do">
                                Done assessment
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-filter="In Progress">
                                Pending
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Done">
                                Submitted Form
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="assessmentTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Date</th>
                                    <th class="border-0 small green-text">Time</th>
                                    <th class="border-0 small green-text">Client</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mar 15, 2026</td>
                                    <td>8:00 AM</td>
                                    <td>Maria Santos</td>
                                    <td>CCTV Setup</td>
                                    <td><span class="badge bg-success rounded-pill">Done Assessment</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('form') }} " class="btn btn-sm btn-outline-success"
                                            title="Open Form">
                                            <span class="material-symbols-outlined icon-action">description</span>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                            onclick="loadAssessmentDetail({
                              date:'Mar 15, 2026', time:'8:00 AM', client:'Maria Santos',
                              contact:'0917-123-4567', email:'maria@email.com', clientType:'Residential',
                              service:'CCTV Setup', establishment:'Home / Residence', assessor:'Marco Rivera',
                              status:'Done Assessment', statusClass:'success', notes:'Client needs outdoor cameras.',
                              cluster:'Cluster 1', block:'Block 3', lot:'Lot 12',
                              brgy:'Brgy. Molino III', city:'Bacoor', province:'Cavite', zip:'4102'
                            })">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Cancel">
                                            <span class="material-symbols-outlined icon-action">cancel</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="Archive">
                                            <span class="material-symbols-outlined icon-action">archive</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mar 15, 2026</td>
                                    <td>1:00 PM</td>
                                    <td>John Reyes</td>
                                    <td>Solar Setup</td>
                                    <td><span class="badge bg-warning text-light rounded-pill">Pending</span></td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-sm invisible" disabled aria-hidden="true">
                                            <span class="material-symbols-outlined icon-action">description</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                            onclick="loadAssessmentDetail({
                              date:'Mar 15, 2026', time:'1:00 PM', client:'John Reyes',
                              contact:'0918-222-3333', email:'', clientType:'Commercial',
                              service:'Solar Setup', establishment:'Office / Commercial', assessor:'Carlo Mendoza',
                              status:'Pending', statusClass:'warning',notes:'',
                              cluster:'', block:'Block 5', lot:'Lot 2',
                              brgy:'Brgy. Alapan I', city:'Imus', province:'Cavite', zip:'4103'
                            })">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Cancel">
                                            <span class="material-symbols-outlined icon-action">cancel</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="Archive">
                                            <span class="material-symbols-outlined icon-action">archive</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mar 16, 2026</td>
                                    <td>8:00 AM</td>
                                    <td>Anna Garcia</td>
                                    <td>Solar Street Light</td>
                                    <td><span class="badge bg-primary rounded-pill">Submitted Form</span></td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-sm btn-outline-primary text-primary" title="Edit Form">
                                            <span class="material-symbols-outlined icon-action">edit_document</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                            onclick="loadAssessmentDetail({
                              date:'Mar 16, 2026', time:'8:00 AM', client:'Anna Garcia',
                              contact:'0920-444-5555', email:'anna@gmail.com', clientType:'Government/LGU',
                              service:'Solar Street Light', establishment:'Government Facility', assessor:'Marco Rivera',
                              status:'Submitted Form', statusClass:'primary', notes:'Streetlights along main road.',
                              cluster:'', block:'', lot:'',
                              brgy:'Brgy. Sampaloc I', city:'Dasmariñas', province:'Cavite', zip:'4114'
                            })">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Cancel">
                                            <span class="material-symbols-outlined icon-action">cancel</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" title="Archive">
                                            <span class="material-symbols-outlined icon-action">archive</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- ── View Assessment Detail Modal ── -->
<div class="modal fade" id="viewAssessmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined" style="font-size:20px;">event_note</span>
                    Assessment Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">

                    <!-- Schedule Info -->
                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing:.05em;">
                            Schedule Info</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Date</label>
                        <p class="fw-semibold mb-0" id="vd-date">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Time</label>
                        <p class="fw-semibold mb-0" id="vd-time">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Status</label>
                        <p class="mb-0" id="vd-status">—</p>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <!-- Client Info -->
                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing:.05em;">
                            Client Info</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Client Name</label>
                        <p class="fw-semibold mb-0" id="vd-client">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Contact Number</label>
                        <p class="mb-0" id="vd-contact">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Email</label>
                        <p class="mb-0" id="vd-email">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Client Type</label>
                        <p class="mb-0" id="vd-clientType">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Service</label>
                        <p class="mb-0" id="vd-service">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Establishment Type</label>
                        <p class="mb-0" id="vd-establishment">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Assessor</label>
                        <p class="mb-0" id="vd-assessor">—</p>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <!-- Location Info -->
                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-2 text-uppercase" style="letter-spacing:.05em;">
                            Location</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Cluster</label>
                        <p class="mb-0" id="vd-cluster">—</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Block</label>
                        <p class="mb-0" id="vd-block">—</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Lot</label>
                        <p class="mb-0" id="vd-lot">—</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Barangay</label>
                        <p class="mb-0" id="vd-brgy">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">City / Municipality</label>
                        <p class="mb-0" id="vd-city">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Province</label>
                        <p class="mb-0" id="vd-province">—</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Zip Code</label>
                        <p class="mb-0" id="vd-zip">—</p>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label small text-muted mb-1">Notes</label>
                        <p class="mb-0" id="vd-notes">—</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- ── Schedule Assessment Modal ── -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small">Client Name *</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Contact Number *</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Email (Optional)</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Client Type *</label>
                        <select class="form-select">
                            <option value="">Select</option>
                            <option>Residential</option>
                            <option>Commercial</option>
                            <option>Government/LGU</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Service Type *</label>
                        <select class="form-select">
                            <option value="">Select</option>
                            <option>CCTV Setup</option>
                            <option>Solar Street Light</option>
                            <option>Solar Setup</option>
                            <option>Public Address System</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Establishment Type *</label>
                        <select class="form-select">
                            <option value="">Select</option>
                            <option>Home / Residence</option>
                            <option>Office / Commercial</option>
                            <option>Subdivision / Barangay</option>
                            <option>Government Facility</option>
                        </select>
                    </div>

                    <!-- Location Fields -->
                    <div class="col-12">
                        <p class="text-muted small fw-semibold mb-0 mt-1 text-uppercase"
                            style="letter-spacing:.05em;">Location</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Cluster (Optional)</label>
                        <input type="text" class="form-control" placeholder="e.g. Cluster 1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Block (Optional)</label>
                        <input type="text" class="form-control" placeholder="e.g. Block 3">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Lot (Optional)</label>
                        <input type="text" class="form-control" placeholder="e.g. Lot 12">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Barangay *</label>
                        <input type="text" class="form-control" placeholder="e.g. Brgy. Molino III">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">City / Municipality *</label>
                        <input type="text" class="form-control" placeholder="e.g. Bacoor">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Province *</label>
                        <input type="text" class="form-control" placeholder="e.g. Cavite">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Zip Code *</label>
                        <input type="text" class="form-control" placeholder="e.g. 4102">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small">Date *</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Time Slot *</label>
                        <select class="form-select">
                            <option value="">Select</option>
                            <option>Morning</option>
                            <option>Afternoon</option>
                            <option>Full Day</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Assessor *</label>
                        <select class="form-select">
                            <option value="">Select</option>
                            <option>Marco Rivera</option>
                            <option>Ana Garcia</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Notes (Optional)</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success">Schedule</button>
            </div>
        </div>
    </div>
</div>


<!-- ── Client Requests Modal ── -->
<div class="modal fade" id="clientRequestsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Client Requests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Ref No</th>
                                <th>Client</th>
                                <th>Contact</th>
                                <th class="d-none d-sm-table-cell">Service</th>
                                <th>Date</th>
                                <th class="d-none d-sm-table-cell">Slot</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>AWG-2026-0006</td>
                                <td>Elena Cruz</td>
                                <td>0922-111-2222</td>
                                <td class="d-none d-sm-table-cell">CCTV Setup</td>
                                <td>Mar 19, 2026</td>
                                <td class="d-none d-sm-table-cell">Morning</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                                              refNo:'AWG-2026-0006', client:'Elena Cruz', contact:'0922-111-2222',
                                              email:'elena@gmail.com', clientType:'Residential',
                                              service:'CCTV Setup', establishment:'Home / Residence',
                                              date:'Mar 19, 2026', slot:'Morning', status:'Pending',
                                              cluster:'Cluster 2', block:'Block 1', lot:'Lot 5',
                                              brgy:'Brgy. Tanzang Luma II', city:'Imus', province:'Cavite', zip:'4103',
                                              notes:'Wants 4 cameras around the house.'
                                            })">
                                        <span class="material-symbols-outlined"
                                            style="font-size:16px;vertical-align:middle;">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-success">Confirm</button>
                                    <button class="btn btn-sm btn-danger">Decline</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Day Detail Modal ── -->
<div class="modal fade" id="dayDetailModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined fs-20">calendar_today</span>
                    <span id="dayModalDate">—</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="dayModalBody">
                <!-- filled by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                    data-bs-dismiss="modal"
                    data-bs-toggle="modal" data-bs-target="#scheduleModal">
                    <span class="material-symbols-outlined fs-17">add</span>
                    Schedule on This Day
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#assessmentTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            info: true,
            order: [
                [0, 'asc']
            ]
        });

        $('#archiveModal').on('shown.bs.modal', function() {
            if (!$.fn.DataTable.isDataTable('#archiveTable')) {
                $('#archiveTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    info: true,
                    order: [
                        [0, 'desc']
                    ]
                });
            }
        });
    });
</script>

<script>
    function openDayModal(date, assessments) {
        document.getElementById('dayModalDate').textContent = date;
        const body = document.getElementById('dayModalBody');

        if (!assessments || assessments.length === 0) {
            body.innerHTML = `
            <div class="text-center py-4 text-muted">
                <span class="material-symbols-outlined" style="font-size:40px;opacity:.3;">event_available</span>
                <p class="small mt-2 mb-0">No assessments scheduled for this day.</p>
                <p class="small text-muted mb-0">Click <strong>Schedule on This Day</strong> to add one.</p>
            </div>`;
        } else {
            body.innerHTML = `
            <p class="section-label mb-3">${assessments.length} Assessment${assessments.length > 1 ? 's' : ''} Scheduled</p>
            <div class="d-flex flex-column gap-3">
                ${assessments.map((a, i) => {
                    const locationParts = [a.cluster, a.block, a.lot, a.brgy, a.city, a.province, a.zip]
                        .filter(part => part && part.trim() !== '')
                        .join(', ');

                    return `
                        <div class="day-assessment-card">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="material-symbols-outlined green-text fs-18">schedule</span>
                                    <span class="fw-semibold small">${a.time}</span>
                                    <span class="badge rounded-pill bg-${a.statusClass} ms-1">${a.status}</span>
                                </div>
                                <span class="day-slot-badge">${a.slot}</span>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <p class="detail-label small mb-0">Client</p>
                                    <p class="detail-value small fw-semibold mb-0">${a.client}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-label small mb-0">Service</p>
                                    <p class="detail-value small mb-0">${a.service}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-label small mb-0">Contact</p>
                                    <p class="detail-value small mb-0">${a.contact || '—'}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-label small mb-0">Client Type</p>
                                    <p class="detail-value small mb-0">${a.clientType || '—'}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-label small mb-0">Establishment</p>
                                    <p class="detail-value small mb-0">${a.establishment || '—'}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-label small mb-0">Assessor</p>
                                    <p class="detail-value small mb-0">${a.assessor || '—'}</p>
                                </div>
                            </div>

                            <div class="day-location-row mb-2">
                                <span class="material-symbols-outlined fs-15 muted-text">location_on</span>
                                <p class="small mb-0">${locationParts || 'No location details provided.'}</p>
                            </div>

                            ${a.notes ? `
                                <div class="day-notes-row">
                                    <span class="material-symbols-outlined fs-15 muted-text">sticky_note_2</span>
                                    <p class="small mb-0">${a.notes}</p>
                                </div>
                            ` : ''}

                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-sm btn-outline-success py-1 px-2"
                                    data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                    onclick="loadAssessmentDetail(${JSON.stringify(a).replace(/"/g, '&quot;')})">
                                    <span class="material-symbols-outlined fs-14" style="vertical-align:middle;">open_in_full</span>
                                    View Full Details
                                </button>
                            </div>
                        </div>
                        ${i < assessments.length - 1 ? '<hr class="my-1">' : ''}
                    `;
                }).join('')}
            </div>`;
        }

        new bootstrap.Modal(document.getElementById('dayDetailModal')).show();
    }
</script>
@endsection
