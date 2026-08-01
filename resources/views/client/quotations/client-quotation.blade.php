@extends('layouts.client')

@section('title', 'Quotations')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/quotation.css') }}">
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>My Quotations</h2>
            <p>Review pricing, scope, and approve quotes from our team.</p>
        </div>

        <div class="main-content">

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon green-text">inbox</span>
                        <div>
                            <p class="summary-label">Total</p>
                            <p class="summary-value">4</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-warning">rate_review</span>
                        <div>
                            <p class="summary-label">Pending Review</p>
                            <p class="summary-value">1</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                        <div>
                            <p class="summary-label">Approved</p>
                            <p class="summary-value">2</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                        <div>
                            <p class="summary-label">Rejected</p>
                            <p class="summary-value">1</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quotations Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Pending Review</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Approved">Approved</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Rejected">Rejected</button>
                    </div>

                    <div class="table-responsive">
                        <table id="quotationsTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Ref No.</th>
                                    <th class="border-0 small green-text">Service</th>
                                    <th class="border-0 small green-text">Date</th>
                                    <th class="border-0 small green-text">Amount</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr data-status="Sent">
                                    <td>QT-2026-002</td>
                                    <td>Solar Setup</td>
                                    <td>Mar 11, 2026</td>
                                    <td>₱120,000.00</td>
                                    <td><span class="badge bg-warning text-dark rounded-pill">Pending Review</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('quotation-view', 'QT-2026-002') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                                <tr data-status="Approved">
                                    <td>QT-2026-003</td>
                                    <td>Solar Street Light</td>
                                    <td>Mar 12, 2026</td>
                                    <td>₱850,000.00</td>
                                    <td><span class="badge bg-success rounded-pill">Approved</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('quotation-view', 'QT-2026-003') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                                <tr data-status="Approved">
                                    <td>QT-2026-006</td>
                                    <td>Solar Street Light</td>
                                    <td>Mar 15, 2026</td>
                                    <td>₱750,000.00</td>
                                    <td><span class="badge bg-success rounded-pill">Approved</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('quotation-view', 'QT-2026-006') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                                <tr data-status="Rejected">
                                    <td>QT-2026-005</td>
                                    <td>CCTV Setup</td>
                                    <td>Mar 14, 2026</td>
                                    <td>₱55,000.00</td>
                                    <td><span class="badge bg-danger rounded-pill">Rejected</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('quotation-view', 'QT-2026-005') }}" class="btn btn-sm btn-outline-success" title="View">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            const table = $('#quotationsTable').DataTable({
                pageLength: 10,
                order: [[2, 'desc']],
                columnDefs: [{ orderable: false, targets: 5 }]
            });

            $('#statusFilterGroup .btn').on('click', function() {
                $('#statusFilterGroup .btn').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                table.column(4).search(filter === 'all' ? '' : filter, true, false).draw();
                // Simpler + more reliable: filter by data-status attribute on row
                if (filter === 'all') {
                    table.search('').draw();
                    $('#quotationsTable tbody tr').show();
                } else {
                    $('#quotationsTable tbody tr').each(function() {
                        $(this).toggle($(this).data('status') === filter);
                    });
                }
            });
        });
    </script>
@endsection