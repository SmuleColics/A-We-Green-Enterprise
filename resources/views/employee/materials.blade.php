@extends('layouts.admin')

@section('title', 'Materials')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/materials/materials.css') }}">
@endsection

@section('page-title', 'Materials')

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon muted-text">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Items</p>
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
        </div>

        <!-- Materials Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group" id="categoryFilterGroup">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="CCTV">CCTV</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Solar">Solar</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="PA System">PA
                        System</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="General">General</button>
                </div>

                <div class="table-responsive">
                    <table id="materialsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Item</th>
                                <th class="border-0 small green-text">Category</th>
                                <th class="border-0 small green-text">Unit</th>
                                <th class="border-0 small green-text">Supplier</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $catClass = [
                                    'CCTV' => 'cat-cctv',
                                    'Solar' => 'cat-solar',
                                    'PA System' => 'cat-pa',
                                    'General' => 'cat-general',
                                ];
                            @endphp
                            @forelse ($materials as $m)
                                @php
                                    $payload = [
                                        'id' => $m->id,
                                        'name' => $m->name,
                                        'image' => $m->image_url,
                                        'category' => $m->category,
                                        'unit' => $m->unit,
                                        'description' => $m->description,
                                        'supplier' => $m->supplier,
                                        'location' => $m->location,
                                    ];
                                @endphp
                                <tr data-category="{{ $m->category }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="mat-thumb-wrap">
                                                <img src="{{ $m->image_url ?? '' }}" alt="{{ $m->name }}"
                                                    class="mat-thumb"
                                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="mat-thumb-fallback"
                                                    style="{{ $m->image_url ? 'display:none;' : 'display:flex;' }}">
                                                    <span class="material-symbols-outlined">image_not_supported</span>
                                                </div>
                                            </div>
                                            <span class="fw-semibold">{{ $m->name }}</span>
                                        </div>
                                    </td>
                                    <td><span
                                            class="cat-badge {{ $catClass[$m->category] ?? '' }}">{{ $m->category }}</span>
                                    </td>
                                    <td>{{ $m->unit }}</td>
                                    <td>{{ $m->supplier ?? '—' }}</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                            data-material='@json($payload)'
                                            onclick="loadMaterial(JSON.parse(this.dataset.material))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No materials found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- ── View Material Modal ── -->
    <div class="modal fade" id="viewMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">inventory_2</span>
                        Material Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="mat-view-img-wrap">
                            <img id="vm-image" src="" alt="" class="mat-view-img"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="mat-thumb-fallback mat-thumb-fallback-lg" id="vm-image-fallback"
                                style="display:none;">
                                <span class="material-symbols-outlined">image_not_supported</span>
                            </div>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vm-name">—</p>
                            <span class="cat-badge mt-1 d-inline-block" id="vm-category-badge">—</span>
                        </div>
                    </div>

                    <p class="section-label">Item Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <p class="detail-label small mb-0">Unit</p>
                            <p class="detail-value small fw-semibold" id="vm-unit">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Supplier</p>
                            <p class="detail-value small" id="vm-supplier">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Location</p>
                            <p class="detail-value small" id="vm-location">—</p>
                        </div>
                    </div>

                    <p class="section-label">Description</p>
                    <p class="detail-value small" id="vm-description">—</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        data-bs-dismiss="modal">
                        <span class="material-symbols-outlined fs-16">close</span>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const catMap = {
            CCTV: 'cat-cctv',
            Solar: 'cat-solar',
            'PA System': 'cat-pa',
            General: 'cat-general',
        };

        function loadMaterial(d) {
            const img = document.getElementById('vm-image');
            const fallback = document.getElementById('vm-image-fallback');

            if (d.image) {
                img.src = d.image;
                img.style.display = '';
                fallback.style.display = 'none';
            } else {
                img.style.display = 'none';
                fallback.style.display = 'flex';
            }

            document.getElementById('vm-name').textContent = d.name || '—';
            document.getElementById('vm-unit').textContent = d.unit || '—';
            document.getElementById('vm-supplier').textContent = d.supplier || '—';
            document.getElementById('vm-location').textContent = d.location || '—';
            document.getElementById('vm-description').textContent = d.description || '—';

            const badge = document.getElementById('vm-category-badge');
            badge.textContent = d.category || '—';
            badge.className = `cat-badge ${catMap[d.category] || ''}`;
        }

        $('#materialsTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            lengthChange: true,
            info: true,
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: 4
            }],
            language: {
                emptyTable: 'No materials found.',
                zeroRecords: 'No matching materials found.'
            },
        });

        $('#categoryFilterGroup button').on('click', function() {
            $('#categoryFilterGroup button').removeClass('active');
            $(this).addClass('active');
            const filter = $(this).data('filter');
            $('#materialsTable').DataTable().column(1).search(filter === 'all' ? '' : filter, true, false).draw();
        });
    </script>
@endsection
