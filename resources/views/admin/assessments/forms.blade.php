@extends('layouts.admin')

@section('title', 'Assessment Form')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessments/form.css') }}">
@endsection

@section('page-title', 'Assessment Form')
@section('page-subtitle', 'Assessment #' . $assessment->id . ' | ' . $assessment->client->user->full_name)

@section('topbar-actions')
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-outline-light fw-semibold d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-18">arrow_back</span>
        Back to Assessment
    </a>
@endsection

@php
    $formItems = old(
        'items',
        $assessment->items
            ->map(
                fn($item) => [
                    'item_name' => $item->item_name,
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                    'location' => $item->location,
                ],
            )
            ->all(),
    );

    if (empty($formItems)) {
        $formItems = [
            [
                'item_name' => '',
                'quantity' => '',
                'unit' => 'pcs',
                'location' => '',
            ],
        ];
    }

    $units = ['pcs', 'roll', 'pair', 'set', 'meters', 'lot', 'box'];
@endphp

@section('content')

    <div class="container-fluid px-4 py-4">

        <form method="POST" action="{{ route('assessments.form.update', $assessment) }}">
            @csrf
            @method('PUT')

            <!-- Assessment Header Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Service(s)</label>
                            <input type="text" class="form-control form-control-sm bg-light"
                                value="{{ implode(', ', $assessment->services) }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Location</label>
                            <input type="text" class="form-control form-control-sm bg-light"
                                value="{{ $assessment->client->city }}, {{ $assessment->client->province }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Contact Person</label>
                            <input type="text" class="form-control form-control-sm bg-light"
                                value="{{ $assessment->client->user->full_name }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Contact Number</label>
                            <input type="text" class="form-control form-control-sm bg-light"
                                value="{{ $assessment->client->user->contact_number }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials Table -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3 green-text">ASSESSMENT FORM</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="materialsTable">
                            <thead class="table-success">
                                <tr>
                                    <th class="wp-40">ITEM</th>
                                    <th class="wp-15">QUANTITY</th>
                                    <th class="wp-20">UNIT</th>
                                    <th class="wp-25">LOCATION</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($formItems as $index => $item)
                                    <tr>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="items[{{ $index }}][item_name]"
                                                    class="form-control border-0 @error("items.$index.item_name") is-invalid @enderror"
                                                    value="{{ $item['item_name'] ?? '' }}"
                                                    placeholder="Type or click + to select..." required>

                                                <button type="button" class="btn btn-outline-success btn-sm picker-btn"
                                                    onclick="openInventoryPicker(this)" title="Pick from inventory">
                                                    <span class="material-symbols-outlined fs-18">add_circle</span>
                                                </button>
                                            </div>

                                            @error("items.$index.item_name")
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                class="form-control form-control-sm border-0 @error("items.$index.quantity") is-invalid @enderror"
                                                value="{{ $item['quantity'] ?? '' }}" min="0.01" step="0.01"
                                                placeholder="0" required>
                                        </td>

                                        <td>
                                            <select name="items[{{ $index }}][unit]"
                                                class="form-select form-select-sm border-0 @error("items.$index.unit") is-invalid @enderror"
                                                required>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit }}" @selected(($item['unit'] ?? 'pcs') === $unit)>
                                                        {{ $unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $index }}][location]"
                                                class="form-control form-control-sm border-0"
                                                value="{{ $item['location'] ?? '' }}" placeholder="Installation location">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-success mt-2 d-flex align-items-center gap-1"
                        onclick="addRow()">
                        <span class="material-symbols-outlined fs-18">add</span>
                        Add Row
                    </button>
                </div>
            </div>

            <!-- Assessment Notes -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Assessment Notes</h6>

                    <textarea name="assessment_notes" class="form-control @error('assessment_notes') is-invalid @enderror" rows="4"
                        placeholder="Add installation notes, special requirements, site conditions, etc...">{{ old('assessment_notes', $assessment->assessment_notes) }}</textarea>

                    @error('assessment_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('assessments') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-18">arrow_back</span>
                    Cancel
                </a>

                <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-18">save</span>
                    Save Assessment Form
                </button>
            </div>
        </form>
    </div>

    <!-- ── Quick Inventory Picker Modal ── -->
    <div class="modal fade" id="inventoryPickerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-22">inventory</span>
                        Select Item from Materials
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="quickSearch" placeholder="Search material...">
                    </div>
                    <div class="list-group overflow-y-auto mh-400" id="inventoryItemList">
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="IP Camera 2MP Outdoor">IP Camera 2MP Outdoor</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="8-Channel NVR with 2TB HDD">8-Channel NVR with 2TB HDD</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="DC Connector">DC Connector</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="Video Balun">Video Balun</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="Cat6 UTP Cable">Cat6 UTP Cable</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="Cable Clips">Cable Clips</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="Power Supply 12V 2A">Power Supply 12V 2A</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="HDMI Cable 10m">HDMI Cable 10m</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="RJ45 Connector">RJ45 Connector</button>
                        <button type="button" class="list-group-item list-group-item-action"
                            data-item-name="Conduit Pipe 1 inch">Conduit Pipe 1 inch</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <small class="text-muted me-auto">Click an item to select it</small>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const UNIT_OPTIONS = ['pcs', 'roll', 'pair', 'set', 'meters', 'lot', 'box']
            .map(unit => `<option value="${unit}">${unit}</option>`)
            .join('');

        let materialRowIndex = {{ count($formItems) }};

        let currentInput = null;
        let pickerModal = null;

        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('inventoryPickerModal');

            pickerModal = new bootstrap.Modal(modalEl);

            document.getElementById('inventoryItemList').addEventListener('click', function(event) {
                const item = event.target.closest('[data-item-name]');

                if (!item || !currentInput) return;

                currentInput.value = item.dataset.itemName;
                currentInput.dispatchEvent(new Event('input', {
                    bubbles: true
                }));

                pickerModal.hide();
                currentInput = null;
            });

            modalEl.addEventListener('show.bs.modal', function() {
                const search = document.getElementById('quickSearch');

                search.value = '';

                document.querySelectorAll('#inventoryItemList [data-item-name]')
                    .forEach(item => item.style.display = '');
            });

            modalEl.addEventListener('shown.bs.modal', function() {
                document.getElementById('quickSearch').focus();
            });

            document.getElementById('quickSearch').addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();

                document.querySelectorAll('#inventoryItemList [data-item-name]')
                    .forEach(item => {
                        const name = item.dataset.itemName.toLowerCase();

                        item.style.display = name.includes(query) ? '' : 'none';
                    });
            });
        });

        function openInventoryPicker(button) {
            currentInput = button.previousElementSibling;
            pickerModal.show();
        }

        function addRow() {
            const tbody = document.querySelector('#materialsTable tbody');

            const row = document.createElement('tr');

            row.innerHTML = `
                <td>
                    <div class="input-group input-group-sm">
                        <input type="text"
                            name="items[${materialRowIndex}][item_name]"
                            class="form-control border-0"
                            placeholder="Type or click + to select..."
                            required>

                        <button type="button"
                            class="btn btn-outline-success btn-sm picker-btn"
                            onclick="openInventoryPicker(this)"
                            title="Pick from inventory">
                            <span class="material-symbols-outlined fs-18">add_circle</span>
                        </button>
                    </div>
                </td>

                <td>
                    <input type="number"
                        name="items[${materialRowIndex}][quantity]"
                        class="form-control form-control-sm border-0"
                        min="0.01"
                        step="0.01"
                        placeholder="0"
                        required>
                </td>

                <td>
                    <select name="items[${materialRowIndex}][unit]"
                        class="form-select form-select-sm border-0"
                        required>
                        ${UNIT_OPTIONS}
                    </select>
                </td>

                <td>
                    <input type="text"
                        name="items[${materialRowIndex}][location]"
                        class="form-control form-control-sm border-0"
                        placeholder="Installation location">
                </td>
            `;

            tbody.appendChild(row);
            materialRowIndex++;
        }
    </script>
@endsection
