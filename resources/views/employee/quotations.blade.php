@extends('layouts.admin')

@section('title', 'Quotations')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/quotation/quotation.css') }}">
@endsection

@section('page-title', 'Quotations')

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">inbox</span>
                    <div>
                        <p class="summary-label">Total</p>
                        <p class="summary-value">{{ $quotations->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">Approved</p>
                        <p class="summary-value">{{ $quotations->where('status', 'Approved')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">send</span>
                    <div>
                        <p class="summary-label">Sent</p>
                        <p class="summary-value">{{ $quotations->where('status', 'Sent')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">rate_review</span>
                    <div>
                        <p class="summary-label">Revision Requested</p>
                        <p class="summary-value">{{ $quotations->where('status', 'Rejected')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quotations Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <div class="btn-group filter-btn-group" role="group" id="statusFilterGroup">
                        <button type="button" class="btn btn-sm btn-outline-secondary active"
                            data-filter="all">All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Sent</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Approved">Approved</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-filter="Revision Requested">Revision Requested</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="quotationsTable" class="table table-hover mb-0 small w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Ref No.</th>
                                <th class="border-0 small green-text">Client</th>
                                <th class="border-0 small green-text">Service</th>
                                <th class="border-0 small green-text">Amount</th>
                                <th class="border-0 small green-text">Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotations as $quotation)
                                <tr>
                                    <td>{{ $quotation->reference_number }}</td>
                                    <td>{{ $quotation->assessment->client->user->full_name }}</td>
                                    <td>{{ $quotation->service_type }}</td>
                                    <td>₱{{ number_format($quotation->grand_total, 2) }}</td>
                                    <td data-order="{{ $quotation->sent_at?->format('Y-m-d') }}">
                                        {{ $quotation->sent_at?->format('M d, Y') }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill
                                            @if ($quotation->status === 'Approved') bg-success
                                            @elseif ($quotation->status === 'Rejected') bg-danger
                                            @else bg-primary text-white @endif"
                                            @if ($quotation->status === 'Rejected' && $quotation->revision_reason_category) title="{{ $quotation->revision_reason_category }}{{ $quotation->revision_reason ? ' — ' . $quotation->revision_reason : '' }}" @endif>{{ $quotation->status === 'Rejected' ? 'Revision Requested' : $quotation->status }}</span>
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <a href="{{ route('employee.quotations.show', $quotation) }}"
                                            class="btn btn-sm btn-outline-primary action-btn" title="View Quotation"><span
                                                class="material-symbols-outlined icon-action">visibility</span></a>
                                        <a target="_blank" href="{{ route('employee.quotations.print', $quotation) }}"
                                            class="btn btn-sm btn-outline-secondary action-btn" title="Preview PDF"><span
                                                class="material-symbols-outlined icon-action">print</span></a>
                                    </td>
                                </tr>
                            @endforeach
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
            const table = $('#quotationsTable').DataTable({
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: 6
                }],
                order: [
                    [4, 'desc']
                ],
                language: {
                    emptyTable: 'No quotations found.',
                    zeroRecords: 'No matching quotations found.'
                }
            });

            document.getElementById('statusFilterGroup').addEventListener('click', function(event) {
                const btn = event.target.closest('[data-filter]');
                if (!btn) return;
                this.querySelectorAll('.btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                table.column(5).search(filter === 'all' ? '' : filter, false, false).draw();
            });
        });
    </script>
@endsection
