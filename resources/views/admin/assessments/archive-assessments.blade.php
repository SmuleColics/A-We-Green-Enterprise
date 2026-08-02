@extends('layouts.admin')

@section('title', 'Archived Assessments')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/assessments.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Archived Assessments')

@section('topbar-actions')
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Assessments
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
                        <p class="summary-value">18</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Done Assessment</p>
                        <p class="summary-value">10</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">description</span>
                    <div>
                        <p class="summary-label">Submitted Form</p>
                        <p class="summary-value">5</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Cancelled</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Assessments Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Done Assessment">Done Assessment</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Submitted Form">Submitted Form</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Cancelled">Cancelled</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Time</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Feb 10, 2026</td>
                                <td>8:00 AM</td>
                                <td>Roberto Lim</td>
                                <td>CCTV Setup</td>
                                <td><span class="badge bg-success rounded-pill">Done Assessment</span></td>
                                <td class="text-muted small">Mar 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                        onclick="loadAssessmentDetail({
                                            date:'Feb 10, 2026', time:'8:00 AM', client:'Roberto Lim',
                                            contact:'0917-999-8888', email:'', clientType:'Residential',
                                            service:'CCTV Setup', establishment:'Home / Residence', assessor:'Marco Rivera',
                                            status:'Done Assessment', statusClass:'success', notes:'',
                                            cluster:'', block:'Block 7', lot:'Lot 3',
                                            brgy:'Brgy. Navarro', city:'General Trias', province:'Cavite', zip:'4107'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jan 28, 2026</td>
                                <td>1:00 PM</td>
                                <td>Carla Bautista</td>
                                <td>Solar Setup</td>
                                <td><span class="badge bg-primary rounded-pill">Submitted Form</span></td>
                                <td class="text-muted small">Mar 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                        onclick="loadAssessmentDetail({
                                            date:'Jan 28, 2026', time:'1:00 PM', client:'Carla Bautista',
                                            contact:'0919-777-6666', email:'carla@email.com', clientType:'Commercial',
                                            service:'Solar Setup', establishment:'Office / Commercial', assessor:'Carlo Mendoza',
                                            status:'Submitted Form', statusClass:'primary', notes:'Rooftop solar panels.',
                                            cluster:'', block:'', lot:'',
                                            brgy:'Brgy. Burol I', city:'Silang', province:'Cavite', zip:'4118'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jan 15, 2026</td>
                                <td>10:00 AM</td>
                                <td>Ben Soriano</td>
                                <td>Public Address System</td>
                                <td><span class="badge bg-danger rounded-pill">Cancelled</span></td>
                                <td class="text-muted small">Feb 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                        onclick="loadAssessmentDetail({
                                            date:'Jan 15, 2026', time:'10:00 AM', client:'Ben Soriano',
                                            contact:'0955-444-5555', email:'ben@email.com', clientType:'Commercial',
                                            service:'Public Address System', establishment:'Office / Commercial', assessor:'Carlo Mendoza',
                                            status:'Cancelled', statusClass:'danger', notes:'Client requested cancellation.',
                                            cluster:'', block:'Block 2', lot:'Lot 7',
                                            brgy:'Brgy. Anabu I-A', city:'Imus', province:'Cavite', zip:'4103'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jan 10, 2026</td>
                                <td>2:00 PM</td>
                                <td>Grace Villanueva</td>
                                <td>CCTV Setup</td>
                                <td><span class="badge bg-success rounded-pill">Done Assessment</span></td>
                                <td class="text-muted small">Feb 15, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                        onclick="loadAssessmentDetail({
                                            date:'Jan 10, 2026', time:'2:00 PM', client:'Grace Villanueva',
                                            contact:'0922-888-9999', email:'grace@email.com', clientType:'Residential',
                                            service:'CCTV Setup', establishment:'Home / Residence', assessor:'Marco Rivera',
                                            status:'Done Assessment', statusClass:'success', notes:'',
                                            cluster:'Cluster 3', block:'Block 1', lot:'Lot 9',
                                            brgy:'Brgy. Molino IV', city:'Bacoor', province:'Cavite', zip:'4102'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Dec 20, 2025</td>
                                <td>9:00 AM</td>
                                <td>Ramon dela Cruz</td>
                                <td>Solar Setup</td>
                                <td><span class="badge bg-danger rounded-pill">Cancelled</span></td>
                                <td class="text-muted small">Jan 05, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewAssessmentModal"
                                        onclick="loadAssessmentDetail({
                                            date:'Dec 20, 2025', time:'9:00 AM', client:'Ramon dela Cruz',
                                            contact:'0933-222-3333', email:'', clientType:'Commercial',
                                            service:'Solar Setup', establishment:'Office / Commercial', assessor:'Carlo Mendoza',
                                            status:'Cancelled', statusClass:'danger', notes:'No response from client.',
                                            cluster:'', block:'Block 4', lot:'Lot 9',
                                            brgy:'Brgy. Palico IV', city:'Imus', province:'Cavite', zip:'4103'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                        <span class="material-symbols-outlined fs-20">event_note</span>
                        Assessment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12"><p class="section-label">Schedule Info</p></div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Date</p>
                            <p class="detail-value small fw-semibold" id="vd-date">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Time</p>
                            <p class="detail-value small fw-semibold" id="vd-time">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Status</p>
                            <p class="detail-value small" id="vd-status">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Client Info</p></div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Name</p>
                            <p class="detail-value small fw-semibold" id="vd-client">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Contact Number</p>
                            <p class="detail-value small" id="vd-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Email</p>
                            <p class="detail-value small" id="vd-email">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Type</p>
                            <p class="detail-value small" id="vd-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Service</p>
                            <p class="detail-value small" id="vd-service">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Establishment Type</p>
                            <p class="detail-value small" id="vd-establishment">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Assessor</p>
                            <p class="detail-value small" id="vd-assessor">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Location</p></div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Cluster</p>
                            <p class="detail-value small" id="vd-cluster">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Block</p>
                            <p class="detail-value small" id="vd-block">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Lot</p>
                            <p class="detail-value small" id="vd-lot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Barangay</p>
                            <p class="detail-value small" id="vd-brgy">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">City / Municipality</p>
                            <p class="detail-value small" id="vd-city">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Province</p>
                            <p class="detail-value small" id="vd-province">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Zip Code</p>
                            <p class="detail-value small" id="vd-zip">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Notes</p></div>
                        <div class="col-12">
                            <p class="detail-value small" id="vd-notes">—</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">unarchive</span>Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        function loadAssessmentDetail(d) {
            document.getElementById('vd-date').textContent          = d.date          || '—';
            document.getElementById('vd-time').textContent          = d.time          || '—';
            document.getElementById('vd-client').textContent        = d.client        || '—';
            document.getElementById('vd-contact').textContent       = d.contact       || '—';
            document.getElementById('vd-email').textContent         = d.email         || '—';
            document.getElementById('vd-clientType').textContent    = d.clientType    || '—';
            document.getElementById('vd-service').textContent       = d.service       || '—';
            document.getElementById('vd-establishment').textContent = d.establishment || '—';
            document.getElementById('vd-assessor').textContent      = d.assessor      || '—';
            document.getElementById('vd-notes').textContent         = d.notes         || '—';
            document.getElementById('vd-cluster').textContent       = d.cluster       || '—';
            document.getElementById('vd-block').textContent         = d.block         || '—';
            document.getElementById('vd-lot').textContent           = d.lot           || '—';
            document.getElementById('vd-brgy').textContent          = d.brgy          || '—';
            document.getElementById('vd-city').textContent          = d.city          || '—';
            document.getElementById('vd-province').textContent      = d.province      || '—';
            document.getElementById('vd-zip').textContent           = d.zip           || '—';
            document.getElementById('vd-status').innerHTML =
                `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;
        }

        $(document).ready(function() {
            $('#archiveTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[0, 'desc']],
                columnDefs: [{ orderable: false, targets: 6 }]
            });
        });
    </script>
@endsection