@extends('layouts.admin')

@section('title', 'Archived Client Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/client-requests.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Archived Client Requests')

@section('topbar-actions')
    <a href="{{ route('requests') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Client Requests
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
                        <p class="summary-value">12</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Confirmed</p>
                        <p class="summary-value">7</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Declined</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                    <div>
                        <p class="summary-label">Pending</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Requests Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Confirmed">Confirmed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Declined">Declined</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Pending">Pending</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveRequestsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Pref. Date</th>
                                <th class="border-0 small green-text">Slot</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">AWG-2026-0001</td>
                                <td>Maria Santos</td>
                                <td>0917-111-2222</td>
                                <td>CCTV Setup</td>
                                <td>Jan 15, 2026</td>
                                <td>Morning</td>
                                <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                <td class="text-muted small">Feb 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                                            refNo:'AWG-2026-0001', client:'Maria Santos', contact:'0917-111-2222',
                                            email:'maria@email.com', clientType:'Residential',
                                            service:'CCTV Setup', establishment:'Home / Residence',
                                            date:'Jan 15, 2026', slot:'Morning', status:'Confirmed', statusClass:'success',
                                            cluster:'Cluster 1', block:'Block 3', lot:'Lot 12',
                                            brgy:'Brgy. Molino III', city:'Bacoor', province:'Cavite', zip:'4102',
                                            notes:'Client needs outdoor cameras.'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">AWG-2026-0002</td>
                                <td>John Reyes</td>
                                <td>0918-222-3333</td>
                                <td>Solar Setup</td>
                                <td>Jan 20, 2026</td>
                                <td>Afternoon</td>
                                <td><span class="badge bg-success rounded-pill">Confirmed</span></td>
                                <td class="text-muted small">Feb 05, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                                            refNo:'AWG-2026-0002', client:'John Reyes', contact:'0918-222-3333',
                                            email:'', clientType:'Commercial',
                                            service:'Solar Setup', establishment:'Office / Commercial',
                                            date:'Jan 20, 2026', slot:'Afternoon', status:'Confirmed', statusClass:'success',
                                            cluster:'', block:'Block 5', lot:'Lot 2',
                                            brgy:'Brgy. Alapan I', city:'Imus', province:'Cavite', zip:'4103',
                                            notes:''
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">AWG-2026-0003</td>
                                <td>Anna Garcia</td>
                                <td>0920-444-5555</td>
                                <td>Solar Street Light</td>
                                <td>Jan 22, 2026</td>
                                <td>Full Day</td>
                                <td><span class="badge bg-danger rounded-pill">Declined</span></td>
                                <td class="text-muted small">Feb 05, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                                            refNo:'AWG-2026-0003', client:'Anna Garcia', contact:'0920-444-5555',
                                            email:'anna@gmail.com', clientType:'Government/LGU',
                                            service:'Solar Street Light', establishment:'Government Facility',
                                            date:'Jan 22, 2026', slot:'Full Day', status:'Declined', statusClass:'danger',
                                            cluster:'', block:'', lot:'',
                                            brgy:'Brgy. Sampaloc I', city:'Dasmariñas', province:'Cavite', zip:'4114',
                                            notes:'Schedule not available.'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">AWG-2026-0004</td>
                                <td>Pedro Cruz</td>
                                <td>0955-444-5555</td>
                                <td>Public Address System</td>
                                <td>Feb 10, 2026</td>
                                <td>Morning</td>
                                <td><span class="badge bg-danger rounded-pill">Declined</span></td>
                                <td class="text-muted small">Feb 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                                            refNo:'AWG-2026-0004', client:'Pedro Cruz', contact:'0955-444-5555',
                                            email:'ben@email.com', clientType:'Commercial',
                                            service:'Public Address System', establishment:'Office / Commercial',
                                            date:'Feb 10, 2026', slot:'Morning', status:'Declined', statusClass:'danger',
                                            cluster:'', block:'Block 2', lot:'Lot 7',
                                            brgy:'Brgy. Anabu I-A', city:'Imus', province:'Cavite', zip:'4103',
                                            notes:'PA system for office lobby.'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">AWG-2026-0005</td>
                                <td>Luz Reyes</td>
                                <td>0944-333-4444</td>
                                <td>Solar Street Light</td>
                                <td>Feb 14, 2026</td>
                                <td>Full Day</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                <td class="text-muted small">Mar 01, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                                            refNo:'AWG-2026-0005', client:'Luz Reyes', contact:'0944-333-4444',
                                            email:'luz@email.com', clientType:'Government/LGU',
                                            service:'Solar Street Light', establishment:'Government Facility',
                                            date:'Feb 14, 2026', slot:'Full Day', status:'Pending', statusClass:'warning text-dark',
                                            cluster:'', block:'', lot:'',
                                            brgy:'Brgy. Malagasang I', city:'Imus', province:'Cavite', zip:'4103',
                                            notes:'Street lights along the barangay road.'
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


    <!-- ── View Request Detail Modal ── -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">person_search</span>
                        Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12"><p class="section-label">Request Info</p></div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Reference No.</p>
                            <p class="detail-value small fw-semibold" id="vr-refNo">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Preferred Date</p>
                            <p class="detail-value small" id="vr-date">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Time Slot</p>
                            <p class="detail-value small" id="vr-slot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Status</p>
                            <p class="detail-value small" id="vr-status">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Client Info</p></div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Name</p>
                            <p class="detail-value small fw-semibold" id="vr-client">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Contact Number</p>
                            <p class="detail-value small" id="vr-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Email</p>
                            <p class="detail-value small" id="vr-email">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Client Type</p>
                            <p class="detail-value small" id="vr-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Service</p>
                            <p class="detail-value small" id="vr-service">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Establishment Type</p>
                            <p class="detail-value small" id="vr-establishment">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Location</p></div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Cluster</p>
                            <p class="detail-value small" id="vr-cluster">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Block</p>
                            <p class="detail-value small" id="vr-block">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Lot</p>
                            <p class="detail-value small" id="vr-lot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label small mb-0">Barangay</p>
                            <p class="detail-value small" id="vr-brgy">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">City / Municipality</p>
                            <p class="detail-value small" id="vr-city">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Province</p>
                            <p class="detail-value small" id="vr-province">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label small mb-0">Zip Code</p>
                            <p class="detail-value small" id="vr-zip">—</p>
                        </div>

                        <div class="col-12"><p class="section-label">Notes</p></div>
                        <div class="col-12">
                            <p class="detail-value small" id="vr-notes">—</p>
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
        function loadRequestDetail(d) {
            document.getElementById('vr-refNo').textContent         = d.refNo         || '—';
            document.getElementById('vr-date').textContent          = d.date           || '—';
            document.getElementById('vr-slot').textContent          = d.slot           || '—';
            document.getElementById('vr-client').textContent        = d.client         || '—';
            document.getElementById('vr-contact').textContent       = d.contact        || '—';
            document.getElementById('vr-email').textContent         = d.email          || '—';
            document.getElementById('vr-clientType').textContent    = d.clientType     || '—';
            document.getElementById('vr-service').textContent       = d.service        || '—';
            document.getElementById('vr-establishment').textContent = d.establishment  || '—';
            document.getElementById('vr-cluster').textContent       = d.cluster        || '—';
            document.getElementById('vr-block').textContent         = d.block          || '—';
            document.getElementById('vr-lot').textContent           = d.lot            || '—';
            document.getElementById('vr-brgy').textContent          = d.brgy           || '—';
            document.getElementById('vr-city').textContent          = d.city           || '—';
            document.getElementById('vr-province').textContent      = d.province       || '—';
            document.getElementById('vr-zip').textContent           = d.zip            || '—';
            document.getElementById('vr-notes').textContent         = d.notes          || '—';
            document.getElementById('vr-status').innerHTML =
                `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;
        }

        $(document).ready(function() {
            $('#archiveRequestsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[7, 'desc']],
                columnDefs: [{ orderable: false, targets: 8 }]
            });
        });
    </script>
@endsection