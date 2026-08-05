@extends('layouts.admin')

@section('title', 'Archived Materials')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/materials/materials.css') }}">
@endsection

@section('page-title', 'Archived Materials')

@section('topbar-actions')
    <a href="{{ route('materials') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Materials
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
                        <p class="summary-value">10</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#1e40af;">videocam</span>
                    <div>
                        <p class="summary-label">CCTV</p>
                        <p class="summary-value">4</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color: #eeee0b;">solar_power</span>
                    <div>
                        <p class="summary-label">Solar</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon" style="color:#5b21b6;">speaker</span>
                    <div>
                        <p class="summary-label">PA / General</p>
                        <p class="summary-value">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archived Materials Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="all">All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="CCTV">CCTV</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="Solar">Solar</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="PA System">PA System</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="General">General</button>
                </div>

                <div class="table-responsive">
                    <table id="archiveMaterialsTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Item</th>
                                <th class="border-0 small green-text">Category</th>
                                <th class="border-0 small green-text">Unit</th>
                                <th class="border-0 small green-text">Last Stock</th>
                                <th class="border-0 small green-text">Unit Cost (₱)</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="" alt="Video Balun Passive" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:flex;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Video Balun Passive</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>pairs</td>
                                <td>0</td>
                                <td>₱120.00</td>
                                <td class="text-muted small">Feb 10, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Video Balun Passive', image:'', category:'CCTV', unit:'pairs',
                                            stock:0, cost:'₱120.00',
                                            description:'Passive video balun for transmitting CCTV signals over UTP cable.',
                                            supplier:'TechPro Supplies', location:'Shelf A-4',
                                            archivedOn:'Feb 10, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="" alt="Siamese CCTV Cable" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:flex;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Siamese CCTV Cable</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>roll</td>
                                <td>1</td>
                                <td>₱2,200.00</td>
                                <td class="text-muted small">Feb 15, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Siamese CCTV Cable', image:'', category:'CCTV', unit:'roll',
                                            stock:1, cost:'₱2,200.00',
                                            description:'305m siamese coaxial cable with power for analog CCTV cameras.',
                                            supplier:'CablePro PH', location:'Shelf B-2',
                                            archivedOn:'Feb 15, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="{{ asset('css/images/materials/dome-camera-1mp.jpg') }}"
                                                alt="Dome Camera 1MP Indoor" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:none;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Dome Camera 1MP Indoor</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>pcs</td>
                                <td>2</td>
                                <td>₱1,200.00</td>
                                <td class="text-muted small">Jan 20, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Dome Camera 1MP Indoor', image:'{{ asset('css/images/materials/dome-camera-1mp.jpg') }}', category:'CCTV', unit:'pcs',
                                            stock:2, cost:'₱1,200.00',
                                            description:'1 Megapixel indoor dome camera, replaced by higher resolution models.',
                                            supplier:'NetVision Inc.', location:'Shelf A-5',
                                            archivedOn:'Jan 20, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="" alt="MC4 Solar Connector Set" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:flex;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">MC4 Solar Connector Set</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-solar">Solar</span></td>
                                <td>set</td>
                                <td>2</td>
                                <td>₱180.00</td>
                                <td class="text-muted small">Jan 10, 2026</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'MC4 Solar Connector Set', image:'', category:'Solar', unit:'set',
                                            stock:2, cost:'₱180.00',
                                            description:'MC4 male and female connector set for solar panel wiring.',
                                            supplier:'SolarGreen PH', location:'Warehouse Row C',
                                            archivedOn:'Jan 10, 2026'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="{{ asset('css/images/materials/solar-panel-250w.jpg') }}"
                                                alt="Solar Panel 250W Polycrystalline" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:none;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Solar Panel 250W Polycrystalline</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-solar">Solar</span></td>
                                <td>pcs</td>
                                <td>0</td>
                                <td>₱4,200.00</td>
                                <td class="text-muted small">Dec 15, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Solar Panel 250W Polycrystalline', image:'{{ asset('css/images/materials/solar-panel-250w.jpg') }}', category:'Solar', unit:'pcs',
                                            stock:0, cost:'₱4,200.00',
                                            description:'250W polycrystalline solar panel, superseded by monocrystalline units.',
                                            supplier:'SolarGreen PH', location:'Warehouse Row C',
                                            archivedOn:'Dec 15, 2025'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="" alt="Lead-Acid Battery 100Ah" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:flex;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Lead-Acid Battery 100Ah</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-solar">Solar</span></td>
                                <td>unit</td>
                                <td>0</td>
                                <td>₱8,500.00</td>
                                <td class="text-muted small">Dec 01, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Lead-Acid Battery 100Ah', image:'', category:'Solar', unit:'unit',
                                            stock:0, cost:'₱8,500.00',
                                            description:'100Ah deep cycle lead-acid battery, replaced by lithium units.',
                                            supplier:'BatteryKing PH', location:'Warehouse Row D',
                                            archivedOn:'Dec 01, 2025'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="" alt="Wall Speaker 15W" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:flex;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Wall Speaker 15W</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-pa">PA System</span></td>
                                <td>pcs</td>
                                <td>3</td>
                                <td>₱650.00</td>
                                <td class="text-muted small">Nov 20, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Wall Speaker 15W', image:'', category:'PA System', unit:'pcs',
                                            stock:3, cost:'₱650.00',
                                            description:'15W indoor wall-mount speaker for PA systems.',
                                            supplier:'AudioPro PH', location:'Shelf D-3',
                                            archivedOn:'Nov 20, 2025'
                                        })">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Restore">
                                        <span class="material-symbols-outlined icon-action">unarchive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mat-thumb-wrap">
                                            <img src="" alt="Plastic Conduit Clips" class="mat-thumb"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="mat-thumb-fallback" style="display:flex;">
                                                <span class="material-symbols-outlined">image_not_supported</span>
                                            </div>
                                        </div>
                                        <span class="fw-semibold">Plastic Conduit Clips</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge cat-general">General</span></td>
                                <td>bag</td>
                                <td>0</td>
                                <td>₱45.00</td>
                                <td class="text-muted small">Nov 05, 2025</td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View Details"
                                        data-bs-toggle="modal" data-bs-target="#viewArchivedMaterialModal"
                                        onclick="loadArchivedMaterial({
                                            name:'Plastic Conduit Clips', image:'', category:'General', unit:'bag',
                                            stock:0, cost:'₱45.00',
                                            description:'Plastic conduit clips for wall mounting conduit pipes.',
                                            supplier:'Hardware Plus', location:'Shelf E-3',
                                            archivedOn:'Nov 05, 2025'
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


    <!-- ── View Archived Material Modal ── -->
    <div class="modal fade" id="viewArchivedMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-20">inventory_2</span>
                        Archived Material Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="mat-view-img-wrap">
                            <img id="vam-image" src="" alt="" class="mat-view-img"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="mat-thumb-fallback mat-thumb-fallback-lg" id="vam-image-fallback" style="display:none;">
                                <span class="material-symbols-outlined">image_not_supported</span>
                            </div>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vam-name">—</p>
                            <span class="cat-badge mt-1 d-inline-block" id="vam-category-badge">—</span>
                        </div>
                    </div>

                    <p class="section-label">Stock Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <p class="detail-label small mb-0">Unit</p>
                            <p class="detail-value small fw-semibold" id="vam-unit">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Last Stock</p>
                            <p class="detail-value small fw-semibold" id="vam-stock">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Unit Cost</p>
                            <p class="detail-value small fw-semibold green-text" id="vam-cost">—</p>
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
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">unarchive</span>Restore
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
            General: 'cat-general'
        };

        function loadArchivedMaterial(d) {
            const img      = document.getElementById('vam-image');
            const fallback = document.getElementById('vam-image-fallback');

            if (d.image) {
                img.src = d.image;
                img.style.display = '';
                fallback.style.display = 'none';
            } else {
                img.style.display = 'none';
                fallback.style.display = 'flex';
            }

            document.getElementById('vam-name').textContent        = d.name        || '—';
            document.getElementById('vam-unit').textContent        = d.unit        || '—';
            document.getElementById('vam-stock').textContent       = d.stock ?? '—';
            document.getElementById('vam-cost').textContent        = d.cost        || '—';
            document.getElementById('vam-supplier').textContent    = d.supplier    || '—';
            document.getElementById('vam-location').textContent    = d.location    || '—';
            document.getElementById('vam-description').textContent = d.description || '—';
            document.getElementById('vam-archivedOn').textContent  = d.archivedOn  || '—';

            const badge = document.getElementById('vam-category-badge');
            badge.textContent = d.category || '—';
            badge.className   = `cat-badge ${catMap[d.category] || ''}`;
        }

        $(document).ready(function() {
            $('#archiveMaterialsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                info: true,
                order: [[5, 'desc']],
                columnDefs: [{ orderable: false, targets: 6 }]
            });
        });
    </script>
@endsection