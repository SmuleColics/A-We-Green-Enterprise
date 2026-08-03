@extends('layouts.admin')

@section('title', 'Archived Quotations')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/quotation/quotation.css') }}">
@endsection

@section('page-title', 'Archived Quotations')

@section('topbar-actions')
    <a href="{{ route('quotations') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Quotations
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
                        <p class="summary-value">14</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Approved</p>
                        <p class="summary-value">8</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Rejected</p>
                        <p class="summary-value">4</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">draft</span>
                    <div>
                        <p class="summary-label">Draft</p>
                        <p class="summary-value">2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Quotations Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Approved">Approved</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Rejected">Rejected</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Draft">Draft</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Sent</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveQuotationsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Amount</th>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">QT-2025-089</td>
                                <td>Carlo Mendoza</td>
                                <td>Solar Setup</td>
                                <td class="fw-semibold text-success">₱210,000.00</td>
                                <td>Nov 20, 2025</td>
                                <td><span class="badge bg-success rounded-pill" data-status="1">Approved</span></td>
                                <td class="text-muted small">Jan 10, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="{{ route('proposals', ['ref' => 'QT-2025-089']) }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">QT-2025-074</td>
                                <td>Grace Villanueva</td>
                                <td>CCTV Setup</td>
                                <td class="fw-semibold text-success">₱38,500.00</td>
                                <td>Oct 05, 2025</td>
                                <td><span class="badge bg-success rounded-pill" data-status="1">Approved</span></td>
                                <td class="text-muted small">Jan 10, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="{{ route('proposals', ['ref' => 'QT-2025-074']) }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">QT-2025-061</td>
                                <td>Ramon dela Cruz</td>
                                <td>Solar Street Light</td>
                                <td class="fw-semibold text-success">₱750,000.00</td>
                                <td>Sep 12, 2025</td>
                                <td><span class="badge bg-danger rounded-pill" data-status="3">Rejected</span></td>
                                <td class="text-muted small">Dec 01, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="{{ route('proposals', ['ref' => 'QT-2025-061']) }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">QT-2025-055</td>
                                <td>Elena Cruz</td>
                                <td>CCTV Setup</td>
                                <td class="fw-semibold text-success">₱42,000.00</td>
                                <td>Aug 30, 2025</td>
                                <td><span class="badge bg-danger rounded-pill" data-status="3">Rejected</span></td>
                                <td class="text-muted small">Nov 15, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="{{ route('proposals', ['ref' => 'QT-2025-055']) }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">QT-2025-048</td>
                                <td>Ben Soriano</td>
                                <td>Public Address System</td>
                                <td class="fw-semibold text-success">₱95,000.00</td>
                                <td>Aug 10, 2025</td>
                                <td><span class="badge bg-secondary rounded-pill" data-status="4">Draft</span></td>
                                <td class="text-muted small">Oct 01, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="{{ route('proposals', ['ref' => 'QT-2025-048']) }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">QT-2025-040</td>
                                <td>Lorna Castillo</td>
                                <td>Solar Setup</td>
                                <td class="fw-semibold text-success">₱185,000.00</td>
                                <td>Jul 22, 2025</td>
                                <td><span class="badge bg-primary text-white rounded-pill" data-status="2">Sent</span></td>
                                <td class="text-muted small">Sep 15, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm action-btn invisible" disabled aria-hidden="true">
                                        <span class="material-symbols-outlined icon-action">description</span>
                                    </button>
                                    <a href="{{ route('proposals', ['ref' => 'QT-2025-040']) }}"
                                        class="btn btn-sm btn-outline-success action-btn" title="View">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </a>
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

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            jQuery.fn.dataTable.ext.type.order['status-priority-pre'] = function(data) {
                return $(data).data('status') || 0;
            };

            $('#archiveQuotationsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[6, 'desc']],
                columnDefs: [
                    { orderable: false, targets: 7 },
                    { type: 'status-priority', targets: 5 }
                ]
            });
        });
    </script>
@endsection