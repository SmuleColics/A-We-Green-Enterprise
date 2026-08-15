@extends('layouts.admin')

@section('title', 'Materials')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/materials/materials.css') }}">
@endsection

@section('page-title', 'Materials')

@section('topbar-actions')
    <a href="{{ route('archive-materials') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </a>
    <button class="btn btn-sm btn-light fw-semibold d-flex align-items-center gap-1 green-text" data-bs-toggle="modal"
        data-bs-target="#addMaterialModal">
        <span class="material-symbols-outlined fs-17">add_box</span>
        Add Material
    </button>
@endsection

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
                                <th class="border-0 small green-text">Unit Cost (₱)</th>
                                <th class="border-0 small green-text">Selling Price (₱)</th>
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
                            @foreach ($materials as $m)
                                @php
                                    $payload = [
                                        'id' => $m->id,
                                        'name' => $m->name,
                                        'image' => $m->image_url,
                                        'category' => $m->category,
                                        'unit' => $m->unit,
                                        'cost' => number_format($m->unit_cost, 2),
                                        'costRaw' => $m->unit_cost,
                                        'price' => $m->selling_price ? number_format($m->selling_price, 2) : null,
                                        'priceRaw' => $m->selling_price,
                                        'markup' => $m->markup_percent,
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
                                    <td>₱{{ number_format($m->unit_cost, 2) }}</td>
                                    <td>
                                        @if ($m->selling_price)
                                            ₱{{ number_format($m->selling_price, 2) }}
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $m->supplier ?? '—' }}</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                            data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                            data-material='@json($payload)'
                                            onclick="loadMaterial(JSON.parse(this.dataset.material))">
                                            <span class="material-symbols-outlined icon-action">visibility</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                            data-material='@json($payload)'
                                            onclick="loadEditMaterial(JSON.parse(this.dataset.material))">
                                            <span class="material-symbols-outlined icon-action">edit</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive"
                                            onclick="openArchiveConfirm({{ $m->id }}, {{ Js::from($m->name) }})">
                                            <span class="material-symbols-outlined icon-action">archive</span>
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
                            <p class="detail-label small mb-0">Unit Cost</p>
                            <p class="detail-value small fw-semibold" id="vm-cost">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Selling Price</p>
                            <p class="detail-value small fw-semibold green-text" id="vm-price">—</p>
                        </div>
                        <div class="col-12" id="vm-markup-wrap" style="display:none;">
                            <p class="detail-label small mb-0">Markup</p>
                            <p class="detail-value small" id="vm-markup">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Supplier</p>
                            <p class="detail-value small" id="vm-supplier">—</p>
                        </div>
                        <div class="col-6">
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
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                        id="vm-archive-btn">
                        <span class="material-symbols-outlined fs-16">archive</span>Archive
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Edit Material Modal ── -->
    <div class="modal fade" id="editMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="editMaterialForm" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-20">edit</span>
                            Edit Material
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small">Item Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit-mat-name" class="form-control form-control-sm"
                                    placeholder="e.g. IP Camera 2MP Outdoor" required>
                                <div class="invalid-feedback">Item name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Category <span class="text-danger">*</span></label>
                                <select id="edit-mat-category" class="form-select form-select-sm" required>
                                    <option value="">Select category</option>
                                    <option>CCTV</option>
                                    <option>Solar</option>
                                    <option>PA System</option>
                                    <option>General</option>
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Unit <span class="text-danger">*</span></label>
                                <select id="edit-mat-unit" class="form-select form-select-sm" required>
                                    <option value="">Select unit</option>
                                    <option>pcs</option>
                                    <option>unit</option>
                                    <option>roll</option>
                                    <option>bag</option>
                                    <option>set</option>
                                    <option>meters</option>
                                    <option>lot</option>
                                    <option>box</option>
                                </select>
                                <div class="invalid-feedback">Please select a unit.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Unit Cost (₱) <span class="text-danger">*</span></label>
                                <input type="number" id="edit-mat-cost" class="form-control form-control-sm"
                                    placeholder="0.00" min="0" step="0.01" required>
                                <div class="invalid-feedback">Please enter a valid cost.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Selling Price (₱)</label>
                                <input type="number" id="edit-mat-price" class="form-control form-control-sm"
                                    placeholder="0.00" min="0" step="0.01">
                                <p class="text-muted mb-0" style="font-size:11px;">Leave blank if pricing varies per
                                    quotation</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Supplier</label>
                                <input type="text" id="edit-mat-supplier" class="form-control form-control-sm"
                                    placeholder="Supplier name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Storage Location</label>
                                <input type="text" id="edit-mat-location" class="form-control form-control-sm"
                                    placeholder="e.g. Shelf A-1">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Description</label>
                                <textarea id="edit-mat-description" class="form-control form-control-sm" rows="2"
                                    placeholder="Brief description of the item..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Item Photo</label>
                                <div class="mat-upload-area" id="editUploadArea"
                                    onclick="document.getElementById('edit-mat-image').click()">
                                    <img id="editImagePreview" src="" alt="" class="mat-upload-preview"
                                        style="display:none;">
                                    <div id="editUploadPlaceholder">
                                        <span class="material-symbols-outlined text-muted"
                                            style="font-size:32px;">add_photo_alternate</span>
                                        <p class="small text-muted mb-0 mt-1">Click to replace photo</p>
                                        <p class="text-muted mb-0" style="font-size:11px;">JPG, PNG — shown in quotations
                                        </p>
                                    </div>
                                    <input type="file" id="edit-mat-image" accept="image/*" class="d-none"
                                        onchange="previewMatImage(this, 'editImagePreview', 'editUploadPlaceholder')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">save</span>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ── Add Material Modal ── -->
    <div class="modal fade" id="addMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="addMaterialForm" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-20">add_box</span>
                            Add New Material
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small">Item Name <span class="text-danger">*</span></label>
                                <input type="text" id="add-mat-name" class="form-control form-control-sm"
                                    placeholder="e.g. IP Camera 2MP Outdoor" required>
                                <div class="invalid-feedback">Item name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Category <span class="text-danger">*</span></label>
                                <select id="add-mat-category" class="form-select form-select-sm" required>
                                    <option value="">Select category</option>
                                    <option>CCTV</option>
                                    <option>Solar</option>
                                    <option>PA System</option>
                                    <option>General</option>
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Unit <span class="text-danger">*</span></label>
                                <select id="add-mat-unit" class="form-select form-select-sm" required>
                                    <option value="">Select unit</option>
                                    <option>pcs</option>
                                    <option>unit</option>
                                    <option>roll</option>
                                    <option>bag</option>
                                    <option>set</option>
                                    <option>meters</option>
                                    <option>lot</option>
                                    <option>box</option>
                                </select>
                                <div class="invalid-feedback">Please select a unit.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Unit Cost (₱) <span class="text-danger">*</span></label>
                                <input type="number" id="add-mat-cost" class="form-control form-control-sm"
                                    placeholder="0.00" min="0" step="0.01" required>
                                <div class="invalid-feedback">Please enter a valid cost.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Selling Price (₱)</label>
                                <input type="number" id="add-mat-price" class="form-control form-control-sm"
                                    placeholder="0.00" min="0" step="0.01">
                                <p class="text-muted mb-0" style="font-size:11px;">Leave blank if pricing varies per
                                    quotation</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Supplier</label>
                                <input type="text" id="add-mat-supplier" class="form-control form-control-sm"
                                    placeholder="Supplier name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Storage Location</label>
                                <input type="text" id="add-mat-location" class="form-control form-control-sm"
                                    placeholder="e.g. Shelf A-1">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Description</label>
                                <textarea id="add-mat-description" class="form-control form-control-sm" rows="2"
                                    placeholder="Brief description of the item..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Item Photo</label>
                                <div class="mat-upload-area" id="addUploadArea"
                                    onclick="document.getElementById('add-mat-image').click()">
                                    <img id="addImagePreview" src="" alt="" class="mat-upload-preview"
                                        style="display:none;">
                                    <div id="addUploadPlaceholder">
                                        <span class="material-symbols-outlined text-muted"
                                            style="font-size:32px;">add_photo_alternate</span>
                                        <p class="small text-muted mb-0 mt-1">Click to upload item photo</p>
                                        <p class="text-muted mb-0" style="font-size:11px;">JPG, PNG — shown in quotations
                                        </p>
                                    </div>
                                    <input type="file" id="add-mat-image" accept="image/*" class="d-none"
                                        onchange="previewMatImage(this, 'addImagePreview', 'addUploadPlaceholder')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">save</span>Save Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ── Archive Confirm Modal ── -->
    <div class="modal fade" id="archiveConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Archive this material?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">
                        <strong id="ac-mat-name">—</strong> will be moved to the archive. You can restore it anytime
                        from <strong>View Archives</strong>.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                        id="ac-confirm-btn">
                        <span class="material-symbols-outlined fs-15">archive</span>
                        Archive
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const routes = {
            store: @json(route('materials.store')),
            update: @json(route('materials.update', ':id')),
            archive: @json(route('materials.archive', ':id')),
        };

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
            document.getElementById('vm-cost').textContent = '₱' + (d.cost || '0.00');
            document.getElementById('vm-price').textContent = d.price ? ('₱' + d.price) : '—';
            document.getElementById('vm-supplier').textContent = d.supplier || '—';
            document.getElementById('vm-location').textContent = d.location || '—';
            document.getElementById('vm-description').textContent = d.description || '—';

            const markupWrap = document.getElementById('vm-markup-wrap');
            if (d.markup !== null && d.markup !== undefined) {
                document.getElementById('vm-markup').textContent = `${d.markup}% above cost`;
                markupWrap.style.display = '';
            } else {
                markupWrap.style.display = 'none';
            }

            const badge = document.getElementById('vm-category-badge');
            badge.textContent = d.category || '—';
            badge.className = `cat-badge ${catMap[d.category] || ''}`;

            document.getElementById('vm-archive-btn').onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('viewMaterialModal'))?.hide();
                openArchiveConfirm(d.id, d.name);
            };
        }

        function loadEditMaterial(d) {
            document.getElementById('editMaterialForm').dataset.materialId = d.id;
            document.getElementById('edit-mat-name').value = d.name || '';
            document.getElementById('edit-mat-category').value = d.category || '';
            document.getElementById('edit-mat-unit').value = d.unit || '';
            document.getElementById('edit-mat-cost').value = d.costRaw ?? '';
            document.getElementById('edit-mat-price').value = d.priceRaw ?? '';
            document.getElementById('edit-mat-supplier').value = d.supplier || '';
            document.getElementById('edit-mat-location').value = d.location || '';
            document.getElementById('edit-mat-description').value = d.description || '';
            document.getElementById('edit-mat-image').value = '';

            const preview = document.getElementById('editImagePreview');
            const placeholder = document.getElementById('editUploadPlaceholder');
            if (d.image) {
                preview.src = d.image;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                preview.style.display = 'none';
                placeholder.style.display = '';
            }
        }

        function previewMatImage(input, previewId, placeholderId) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        document.getElementById('addMaterialModal').addEventListener('show.bs.modal', () => {
            document.getElementById('addMaterialForm').reset();
            document.getElementById('addMaterialForm').classList.remove('was-validated');
            document.getElementById('addImagePreview').style.display = 'none';
            document.getElementById('addUploadPlaceholder').style.display = '';
        });

        async function submitMaterialForm(form, url) {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData();
            const prefix = form.id === 'addMaterialForm' ? 'add-mat-' : 'edit-mat-';
            formData.append('name', document.getElementById(prefix + 'name').value);
            formData.append('category', document.getElementById(prefix + 'category').value);
            formData.append('unit', document.getElementById(prefix + 'unit').value);
            formData.append('unit_cost', document.getElementById(prefix + 'cost').value);
            formData.append('selling_price', document.getElementById(prefix + 'price').value);
            formData.append('supplier', document.getElementById(prefix + 'supplier').value);
            formData.append('location', document.getElementById(prefix + 'location').value);
            formData.append('description', document.getElementById(prefix + 'description').value);

            const imageInput = document.getElementById(prefix + 'image');
            if (imageInput.files[0]) {
                formData.append('image', imageInput.files[0]);
            }

            if (form.id === 'editMaterialForm') {
                formData.append('_method', 'PUT');
            }

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                const data = await res.json();

                if (!res.ok) {
                    showToast(data.message || 'Something went wrong. Please try again.', 'danger');
                    return;
                }

                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 800);
            } catch (err) {
                showToast('Network error — please try again.', 'danger');
            }
        }

        document.getElementById('addMaterialForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitMaterialForm(this, routes.store);
        });

        document.getElementById('editMaterialForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = this.dataset.materialId;
            submitMaterialForm(this, routes.update.replace(':id', id));
        });

        /* ─────────────────────────────────────────
           ARCHIVE CONFIRMATION FLOW
           ───────────────────────────────────────── */
        let pendingArchiveId = null;

        const archiveConfirmModalEl = document.getElementById('archiveConfirmModal');
        const archiveConfirmModal = new bootstrap.Modal(archiveConfirmModalEl);

        function openArchiveConfirm(id, name) {
            pendingArchiveId = id;
            document.getElementById('ac-mat-name').textContent = name;
            archiveConfirmModal.show();
        }

        document.getElementById('ac-confirm-btn').addEventListener('click', function() {
            if (!pendingArchiveId) return;

            fetch(routes.archive.replace(':id', pendingArchiveId), {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                .then(res => res.json())
                .then(data => {
                    archiveConfirmModal.hide();
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error — please try again.', 'danger'));
        });

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
                targets: 5
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
