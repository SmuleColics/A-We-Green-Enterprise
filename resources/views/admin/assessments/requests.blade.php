@extends('layouts.admin')

@section('title', 'Client Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/request.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Assessment Requests')

@section('topbar-actions')
     <a href="{{ route('archive-requests') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Schedule
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

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
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Confirmed</p>
                        <p class="summary-value">12</p>
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
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Declined</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requests Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Approved">Confirmed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Pending</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="For Review">Declined</button>
                </div>

                <div class="table-responsive">
                    <table id="requestsTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Contact</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Pref. Date</th>
                                <th class="border-0 small green-text">Slot</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- ROW 1: Pending -->
                            <tr>
                                <td>AWG-2026-0006</td>
                                <td>Elena Cruz</td>
                                <td>0922-111-2222</td>
                                <td>CCTV Setup</td>
                                <td>Mar 19, 2026</td>
                                <td>Morning</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0006', client:'Elena Cruz', contact:'0922-111-2222',
                          email:'elena@gmail.com', clientType:'Residential',
                          service:'CCTV Setup', establishment:'Home / Residence',
                          date:'Mar 19, 2026', slot:'Morning', status:'Pending', statusClass:'warning text-dark',
                          cluster:'Cluster 2', block:'Block 1', lot:'Lot 5',
                          brgy:'Brgy. Tanzang Luma II', city:'Imus', province:'Cavite', zip:'4103',
                          notes:'Wants 4 cameras around the house.'
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" title="Confirm"
                                        onclick="confirmRequest(this, 'AWG-2026-0006')">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Decline"
                                        onclick="declineRequest(this, 'AWG-2026-0006')">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <!-- ROW 2: Confirmed -->
                            <tr>
                                <td>AWG-2026-0007</td>
                                <td>Ramon dela Cruz</td>
                                <td>0933-222-3333</td>
                                <td>Solar Setup</td>
                                <td>Mar 21, 2026</td>
                                <td>Afternoon</td>
                                <td><span class="badge bg-success text-white rounded-pill">Confirmed</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0007', client:'Ramon dela Cruz', contact:'0933-222-3333',
                          email:'', clientType:'Commercial',
                          service:'Solar Setup', establishment:'Office / Commercial',
                          date:'Mar 21, 2026', slot:'Afternoon', status:'Confirmed', statusClass:'success',
                          cluster:'', block:'Block 4', lot:'Lot 9',
                          brgy:'Brgy. Palico IV', city:'Imus', province:'Cavite', zip:'4103',
                          notes:''
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Confirmed">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Confirmed">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <!-- ROW 3: Pending -->
                            <tr>
                                <td>AWG-2026-0005</td>
                                <td>Luz Reyes</td>
                                <td>0944-333-4444</td>
                                <td>Solar Street Light</td>
                                <td>Mar 14, 2026</td>
                                <td>Full Day</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Pending</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0005', client:'Luz Reyes', contact:'0944-333-4444',
                          email:'luz@email.com', clientType:'Government/LGU',
                          service:'Solar Street Light', establishment:'Government Facility',
                          date:'Mar 14, 2026', slot:'Full Day', status:'Pending', statusClass:'warning text-dark',
                          cluster:'', block:'', lot:'',
                          brgy:'Brgy. Malagasang I', city:'Imus', province:'Cavite', zip:'4103',
                          notes:'Street lights along the barangay road.'
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" title="Confirm"
                                        onclick="confirmRequest(this, 'AWG-2026-0005')">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Decline"
                                        onclick="declineRequest(this, 'AWG-2026-0005')">
                                        <span class="material-symbols-outlined icon-action">cancel</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            <!-- ROW 4: Declined -->
                            <tr>
                                <td>AWG-2026-0004</td>
                                <td>Ben Soriano</td>
                                <td>0955-444-5555</td>
                                <td>Public Address System</td>
                                <td>Mar 10, 2026</td>
                                <td>Morning</td>
                                <td><span class="badge bg-danger rounded-pill">Declined</span></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-success" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                        onclick="loadRequestDetail({
                          refNo:'AWG-2026-0004', client:'Ben Soriano', contact:'0955-444-5555',
                          email:'ben@email.com', clientType:'Commercial',
                          service:'Public Address System', establishment:'Office / Commercial',
                          date:'Mar 10, 2026', slot:'Morning', status:'Declined', statusClass:'danger',
                          cluster:'', block:'Block 2', lot:'Lot 7',
                          brgy:'Brgy. Anabu I-A', city:'Imus', province:'Cavite', zip:'4103',
                          notes:'PA system for office lobby.'
                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Declined">
                                        <span class="material-symbols-outlined icon-action">check_circle</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Already Declined">
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


    <!-- ── View Request Detail Modal ── -->
    <div class="modal fade" id="viewRequestModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:20px;">person_search</span>
                        Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Request Info -->
                        <div class="col-12">
                            <p class="section-label">Request Info</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Reference No.</p>
                            <p class="detail-value fw-semibold" id="vr-refNo">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Preferred Date</p>
                            <p class="detail-value" id="vr-date">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Time Slot</p>
                            <p class="detail-value" id="vr-slot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Status</p>
                            <p class="detail-value" id="vr-status">—</p>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Client Info -->
                        <div class="col-12">
                            <p class="section-label">Client Info</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Client Name</p>
                            <p class="detail-value fw-semibold" id="vr-client">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Contact Number</p>
                            <p class="detail-value" id="vr-contact">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Email</p>
                            <p class="detail-value" id="vr-email">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Client Type</p>
                            <p class="detail-value" id="vr-clientType">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Service</p>
                            <p class="detail-value" id="vr-service">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Establishment Type</p>
                            <p class="detail-value" id="vr-establishment">—</p>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Location -->
                        <div class="col-12">
                            <p class="section-label">Location</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Cluster</p>
                            <p class="detail-value" id="vr-cluster">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Block</p>
                            <p class="detail-value" id="vr-block">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Lot</p>
                            <p class="detail-value" id="vr-lot">—</p>
                        </div>
                        <div class="col-md-3">
                            <p class="detail-label">Barangay</p>
                            <p class="detail-value" id="vr-brgy">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">City / Municipality</p>
                            <p class="detail-value" id="vr-city">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Province</p>
                            <p class="detail-value" id="vr-province">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Zip Code</p>
                            <p class="detail-value" id="vr-zip">—</p>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <p class="detail-label">Notes</p>
                            <p class="detail-value" id="vr-notes">—</p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" id="vr-footer-actions">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="modal-decline-btn">Decline</button>
                    <button type="button" class="btn btn-success" id="modal-confirm-btn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        function loadRequestDetail(d) {
            document.getElementById('vr-refNo').textContent = d.refNo || '—';
            document.getElementById('vr-date').textContent = d.date || '—';
            document.getElementById('vr-slot').textContent = d.slot || '—';
            document.getElementById('vr-client').textContent = d.client || '—';
            document.getElementById('vr-contact').textContent = d.contact || '—';
            document.getElementById('vr-email').textContent = d.email || '—';
            document.getElementById('vr-clientType').textContent = d.clientType || '—';
            document.getElementById('vr-service').textContent = d.service || '—';
            document.getElementById('vr-establishment').textContent = d.establishment || '—';
            document.getElementById('vr-cluster').textContent = d.cluster || '—';
            document.getElementById('vr-block').textContent = d.block || '—';
            document.getElementById('vr-lot').textContent = d.lot || '—';
            document.getElementById('vr-brgy').textContent = d.brgy || '—';
            document.getElementById('vr-city').textContent = d.city || '—';
            document.getElementById('vr-province').textContent = d.province || '—';
            document.getElementById('vr-zip').textContent = d.zip || '—';
            document.getElementById('vr-notes').textContent = d.notes || '—';
            document.getElementById('vr-status').innerHTML =
                `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;

            const confirmBtn = document.getElementById('modal-confirm-btn');
            const declineBtn = document.getElementById('modal-decline-btn');
            confirmBtn.style.display = d.status === 'Pending' ? 'inline-block' : 'none';
            declineBtn.style.display = d.status === 'Pending' ? 'inline-block' : 'none';
        }

        function confirmRequest(btn, refNo) {
            const row = btn.closest('tr');
            row.querySelector('.badge').className = 'badge bg-success rounded-pill';
            row.querySelector('.badge').textContent = 'Confirmed';
            row.querySelectorAll('.btn-outline-success, .btn-outline-danger').forEach(b => {
                b.classList.replace('btn-outline-success', 'btn-outline-secondary');
                b.classList.replace('btn-outline-danger', 'btn-outline-secondary');
                b.disabled = true;
            });
        }

        function declineRequest(btn, refNo) {
            const row = btn.closest('tr');
            row.querySelector('.badge').className = 'badge bg-danger rounded-pill';
            row.querySelector('.badge').textContent = 'Declined';
            row.querySelectorAll('.btn-outline-success, .btn-outline-danger').forEach(b => {
                b.classList.replace('btn-outline-success', 'btn-outline-secondary');
                b.classList.replace('btn-outline-danger', 'btn-outline-secondary');
                b.disabled = true;
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#requestsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                    targets: 7,
                    orderable: false
                }]
            });
        });
    </script>
@endsection
