@extends('layouts.admin')

@section('title', 'Archived Items')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/items/items.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title', 'Archived Items')

@section('topbar-actions')
    <a href="{{ route('items') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Items
    </a>
@endsection

@section('content')

    @php
        $catClass = [
            'CCTV' => 'cat-cctv',
            'Solar' => 'cat-solar',
            'PA System' => 'cat-pa',
            'General' => 'cat-general',
            'Labor' => 'cat-labor',
        ];
    @endphp

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Archived</p>
                        <p class="summary-value">{{ $total }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon green-text">videocam</span>
                    <div>
                        <p class="summary-label">CCTV</p>
                        <p class="summary-value">{{ $byCategory['CCTV'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-primary">speaker</span>
                    <div>
                        <p class="summary-label">PA System</p>
                        <p class="summary-value">{{ $byCategory['PA System'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">wb_sunny</span>
                    <div>
                        <p class="summary-label">Solar</p>
                        <p class="summary-value">{{ $byCategory['Solar'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-secondary">engineering</span>
                    <div>
                        <p class="summary-label">Labor</p>
                        <p class="summary-value">{{ $byCategory['Labor'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Items Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="categoryFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="CCTV">CCTV</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Solar">Solar</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="PA System">PA
                        System</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="General">General</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Labor">Labor</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveItemsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Item</th>
                                <th class="border-0 small green-text">Category</th>
                                <th class="border-0 small green-text">Unit</th>
                                <th class="border-0 small green-text">Unit Cost (₱)</th>
                                <th class="border-0 small green-text">Selling Price (₱)</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $it)
                                @php
                                    $payload = [
                                        'id' => $it->id,
                                        'name' => $it->name,
                                        'image' => $it->image_url,
                                        'category' => $it->category,
                                        'unit' => $it->unit,
                                        'cost' => $it->unit_cost ? number_format($it->unit_cost, 2) : null,
                                        'price' => $it->selling_price ? number_format($it->selling_price, 2) : null,
                                        'description' => $it->description,
                                        'supplier' => $it->supplier,
                                        'location' => $it->location,
                                        'archivedOn' => $it->archived_at?->format('M j, Y'),
                                    ];
                                @endphp
                                <tr data-category="{{ $it->category }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="mat-thumb-wrap">
                                                <img src="{{ $it->image_url ?? '' }}" alt="{{ $it->name }}"
                                                    class="mat-thumb"
                                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="mat-thumb-fallback"
                                                    style="{{ $it->image_url ? 'display:none;' : 'display:flex;' }}">
                                                    <span class="material-symbols-outlined">image_not_supported</span>
                                                </div>
                                            </div>
                                            <span class="fw-semibold">{{ $it->name }}</span>
                                        </div>
                                    </td>
                                    <td><span
                                            class="cat-badge {{ $catClass[$it->category] ?? '' }}">{{ $it->category }}</span>
                                    </td>
                                    <td>{{ $it->unit }}</td>
                                    <td>{{ $it->unit_cost ? '₱'.number_format($it->unit_cost, 2) : '—' }}</td>
                                    <td>
                                        @if ($it->selling_price)
                                            ₱{{ number_format($it->selling_price, 2) }}
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small"
                                        data-order="{{ optional($it->archived_at)->format('Y-m-d H:i:s') }}">
                                        {{ $it->archived_at?->format('M j, Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#viewArchivedItemModal"
                                            data-item='@json($payload)'
                                            onclick="loadArchivedItem(JSON.parse(this.dataset.item))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="openRestoreConfirm({{ $it->id }}, {{ Js::from($it->name) }})">
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


    <!-- ── View Archived Item Modal ── -->
    <div class="modal fade" id="viewArchivedItemModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">inventory_2</span>
                        Archived Item Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="mat-view-img-wrap">
                            <img id="vam-image" src="" alt="" class="mat-view-img"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="mat-thumb-fallback mat-thumb-fallback-lg" id="vam-image-fallback"
                                style="display:none;">
                                <span class="material-symbols-outlined">image_not_supported</span>
                            </div>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vam-name">—</p>
                            <span class="cat-badge mt-1 d-inline-block" id="vam-category-badge">—</span>
                        </div>
                    </div>

                    <p class="section-label">Item Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <p class="detail-label small mb-0">Unit</p>
                            <p class="detail-value small fw-semibold" id="vam-unit">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Unit Cost</p>
                            <p class="detail-value small fw-semibold" id="vam-cost">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Selling Price</p>
                            <p class="detail-value small fw-semibold green-text" id="vam-price">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Supplier</p>
                            <p class="detail-value small" id="vam-supplier">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Storage Location</p>
                            <p class="detail-value small" id="vam-location">—</p>
                        </div>
                    </div>

                    <p class="section-label">Description</p>
                    <p class="detail-value small" id="vam-description">—</p>

                    <p class="section-label">Archive Info</p>
                    <div class="row g-2">
                        <div class="col-6">
                            <p class="detail-label small mb-0">Archived On</p>
                            <p class="detail-value small" id="vam-archivedOn">—</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1"
                        id="vam-restore-btn">
                        <span class="material-symbols-outlined fs-17">unarchive</span>Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this item?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        <strong id="rc-mat-name">—</strong> will be moved back to <strong>Items</strong>.
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const ROUTES = {
            unarchive: {{ Js::from(route('items.unarchive', ['item' => '__ID__'])) }},
        };

        const catMap = {
            CCTV: 'cat-cctv',
            Solar: 'cat-solar',
            'PA System': 'cat-pa',
            General: 'cat-general',
            Labor: 'cat-labor',
        };

        let pendingRestoreId = null;

        function loadArchivedItem(d) {
            const img = document.getElementById('vam-image');
            const fallback = document.getElementById('vam-image-fallback');

            if (d.image) {
                img.src = d.image;
                img.style.display = '';
                fallback.style.display = 'none';
            } else {
                img.style.display = 'none';
                fallback.style.display = 'flex';
            }

            document.getElementById('vam-name').textContent = d.name || '—';
            document.getElementById('vam-unit').textContent = d.unit || '—';
            document.getElementById('vam-cost').textContent = d.cost ? ('₱' + d.cost) : '—';
            document.getElementById('vam-price').textContent = d.price ? ('₱' + d.price) : '—';
            document.getElementById('vam-supplier').textContent = d.supplier || '—';
            document.getElementById('vam-location').textContent = d.location || '—';
            document.getElementById('vam-description').textContent = d.description || '—';
            document.getElementById('vam-archivedOn').textContent = d.archivedOn || '—';

            const badge = document.getElementById('vam-category-badge');
            badge.textContent = d.category || '—';
            badge.className = `cat-badge ${catMap[d.category] || ''}`;

            document.getElementById('vam-restore-btn').onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewArchivedItemModal'))?.hide();
                openRestoreConfirm(d.id, d.name);
            };
        }

        /* ─────────────────────────────────────────
           RESTORE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        const restoreConfirmModalEl = document.getElementById('restoreConfirmModal');
        const restoreConfirmModal = new bootstrap.Modal(restoreConfirmModalEl);

        function openRestoreConfirm(id, name) {
            pendingRestoreId = id;
            document.getElementById('rc-mat-name').textContent = name;
            restoreConfirmModal.show();
        }

        document.getElementById('rc-confirm-btn').addEventListener('click', function() {
            if (!pendingRestoreId) return;

            fetch(ROUTES.unarchive.replace('__ID__', pendingRestoreId), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
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
                        showToast(data.message || 'Unable to restore this item.', 'danger');
                        return;
                    }
                    showToast(data.message, 'success');
                    restoreConfirmModal.hide();
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        });

        /* ─── DataTable + category filter buttons ─── */
        $(document).ready(function() {
            const table = $('#archiveItemsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [
                    [5, 'desc']
                ],
                columnDefs: [{
                    targets: 6,
                    orderable: false
                }],
                language: {
                    emptyTable: 'No archived items yet.',
                    zeroRecords: 'No matching archived items found.'
                }
            });

            $('#categoryFilterGroup button').on('click', function() {
                $('#categoryFilterGroup button').removeClass('active');
                $(this).addClass('active');
                const filter = $(this).data('filter');
                table.column(1).search(filter === 'all' ? '' : filter, true, false).draw();
            });
        });
    </script>
@endsection
