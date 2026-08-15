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
                        <p class="summary-value">{{ $quotations->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">send</span>
                    <div>
                        <p class="summary-label">Sent</p>
                        <p class="summary-value">{{ $quotations->where('status', 'Sent')->count() }}</p>
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
                    <span class="material-symbols-outlined summary-icon text-danger">rate_review</span>
                    <div>
                        <p class="summary-label">Revision Requested</p>
                        <p class="summary-value">{{ $quotations->where('status', 'Rejected')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Quotations Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="statusFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Sent">Sent</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Approved">Approved</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-filter="Revision Requested">Revision Requested</button>
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
                            @foreach ($quotations as $quotation)
                                @php
                                    $statusLabel = $quotation->status === 'Rejected' ? 'Revision Requested' : $quotation->status;
                                    $statusClass = $quotation->status === 'Approved'
                                        ? 'success'
                                        : ($quotation->status === 'Rejected' ? 'danger' : 'primary text-white');
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $quotation->reference_number }}</td>
                                    <td>{{ $quotation->assessment->client->user->full_name }}</td>
                                    <td>{{ $quotation->service_type }}</td>
                                    <td class="fw-semibold text-success">₱{{ number_format($quotation->grand_total, 2) }}</td>
                                    <td data-order="{{ $quotation->sent_at?->format('Y-m-d') }}">
                                        {{ $quotation->sent_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $statusClass }} rounded-pill"
                                            @if ($quotation->status === 'Rejected' && $quotation->revision_reason_category)
                                                title="{{ $quotation->revision_reason_category }}{{ $quotation->revision_reason ? ' — ' . $quotation->revision_reason : '' }}"
                                            @endif
                                            >{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-muted small"
                                        data-order="{{ optional($quotation->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $quotation->archived_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <a href="{{ route('quotations.show', $quotation) }}"
                                            class="btn btn-sm btn-outline-success action-btn" title="View Quotation">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </a>
                                        <a target="_blank" href="{{ route('quotations.print', $quotation) }}"
                                            class="btn btn-sm btn-outline-secondary action-btn" title="Preview PDF">
                                            <span class="material-symbols-outlined icon-action">print</span>
                                        </a>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm({{ $quotation->id }}, {{ Js::from($quotation->reference_number) }})">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
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

    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this quotation?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        Quotation <strong id="rc-refNo">—</strong> will be moved back to <strong>Quotations</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        id="rc-confirm-btn">
                        <span class="material-symbols-outlined fs-15">unarchive</span>
                        Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const ROUTES = {
            unarchive: {{ Js::from(route('quotations.unarchive', ['quotation' => '__ID__'])) }},
        };

        let pendingRestoreId = null;

        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(id, refNo) {
            pendingRestoreId = id;
            document.getElementById('rc-refNo').textContent = refNo;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status,
                    data
                }) => {
                    if (status !== 200 || !data.success) {
                        showToast(data.message || 'Unable to restore this quotation.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    restoreConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        $(document).ready(function() {
            const table = $('#archiveQuotationsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [6, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }],
                language: {
                    emptyTable: 'No archived quotations yet.',
                    zeroRecords: 'No matching archived quotations found.'
                }
            });

            $('#statusFilterGroup button').on('click', function() {
                $('#statusFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                table.column(5).search(filter === 'all' ? '' : filter, false, false).draw();
            });
        });
    </script>
@endsection
