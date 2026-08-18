@extends('layouts.admin')

@section('title', 'Client Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/request.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Assessment Requests')

@section('topbar-actions')
    <a href="{{ route('employee.assessments') }}" class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Schedule
    </a>
@endsection

@section('content')

    @php
        $statusBadgeClass = [
            'Pending' => 'warning text-dark',
            'Confirmed' => 'success text-white',
            'Declined' => 'danger',
        ];
    @endphp

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">inbox</span>
                    <div>
                        <p class="summary-label">Total</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Confirmed</p>
                        <p class="summary-value">{{ $confirmed }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">pending</span>
                    <div>
                        <p class="summary-label">Pending</p>
                        <p class="summary-value">{{ $pending }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Declined</p>
                        <p class="summary-value">{{ $declined }}</p>
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
                        data-filter="Confirmed">Confirmed</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Pending">Pending</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Declined">Declined</button>
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
                                <th class="border-0 small green-text">Details</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($assessments as $assessment)
                                @php
                                    $refNo =
                                        'AWG-' .
                                        $assessment->created_at->format('Y') .
                                        '-' .
                                        str_pad($assessment->id, 4, '0', STR_PAD_LEFT);
                                    $badgeClass = $statusBadgeClass[$assessment->status] ?? 'secondary';
                                    $client = $assessment->client;
                                    $clientUser = $client->user;
                                @endphp
                                <tr data-status="{{ $assessment->status }}">
                                    <td>{{ $refNo }}</td>
                                    <td>{{ $clientUser->full_name }}</td>
                                    <td>{{ $clientUser->contact_number ?? '—' }}</td>
                                    <td>{{ implode(', ', $assessment->services ?? []) }}</td>
                                    <td data-order="{{ $assessment->preferred_date->format('Y-m-d') }}">
                                        {{ $assessment->preferred_date->format('M j, Y') }}
                                    </td>
                                    <td>{{ $assessment->time_slot }}</td>
                                    <td><span
                                            class="badge bg-{{ $badgeClass }} rounded-pill">{{ $assessment->status }}</span>
                                    </td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-sm btn-outline-success" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                            onclick="loadRequestDetail({
                                id: {{ $assessment->id }},
                                refNo: {{ Js::from($refNo) }},
                                client: {{ Js::from($clientUser->full_name) }},
                                contact: {{ Js::from($clientUser->contact_number ?? '—') }},
                                email: {{ Js::from($clientUser->email ?? '—') }},
                                clientType: {{ Js::from($assessment->client_type) }},
                                service: {{ Js::from(implode(', ', $assessment->services ?? [])) }},
                                establishment: {{ Js::from($assessment->establishment_type) }},
                                date: {{ Js::from($assessment->preferred_date->format('M j, Y')) }},
                                slot: {{ Js::from($assessment->time_slot) }},
                                status: {{ Js::from($assessment->status) }},
                                statusClass: {{ Js::from($badgeClass) }},
                                block: {{ Js::from($client->block ?? '—') }},
                                lot: {{ Js::from($client->lot ?? '—') }},
                                brgy: {{ Js::from($client->barangay ?? '—') }},
                                city: {{ Js::from($client->city ?? '—') }},
                                province: {{ Js::from($client->province ?? '—') }},
                                zip: {{ Js::from($client->zip_code ?? '—') }},
                                notes: {{ Js::from($assessment->notes ?? '') }}
                            })">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
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
                        <div class="col-md-4">
                            <p class="detail-label">Block</p>
                            <p class="detail-value" id="vr-block">—</p>
                        </div>
                        <div class="col-md-4">
                            <p class="detail-label">Lot</p>
                            <p class="detail-value" id="vr-lot">—</p>
                        </div>
                        <div class="col-md-4">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            document.getElementById('vr-block').textContent = d.block || '—';
            document.getElementById('vr-lot').textContent = d.lot || '—';
            document.getElementById('vr-brgy').textContent = d.brgy || '—';
            document.getElementById('vr-city').textContent = d.city || '—';
            document.getElementById('vr-province').textContent = d.province || '—';
            document.getElementById('vr-zip').textContent = d.zip || '—';
            document.getElementById('vr-notes').textContent = d.notes || '—';
            document.getElementById('vr-status').innerHTML =
                `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;
        }

        /* ─── DataTable + status filter buttons ─── */
        $(document).ready(function() {
            const table = $('#requestsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                    targets: 7,
                    orderable: false
                }],
                language: {
                    emptyTable: 'No client requests found.',
                    zeroRecords: 'No matching client requests found.'
                }
            });

            $('#statusFilterGroup button').on('click', function() {
                $('#statusFilterGroup button').removeClass('active');
                $(this).addClass('active');

                const filter = $(this).data('filter');
                if (filter === 'all') {
                    table.column(6).search('').draw();
                } else {
                    table.column(6).search(filter).draw();
                }
            });
        });
    </script>
@endsection
