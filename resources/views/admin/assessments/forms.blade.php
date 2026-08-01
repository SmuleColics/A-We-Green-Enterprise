@extends('layouts.admin')

@section('title', 'Assessment Form')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/assessment/form.css') }}">
@endsection

@section('page-title', 'Assessment Form')
@section('page-subtitle', 'Ref: ASM-2026-001 | Maria Santos')

@section('topbar-actions')
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-outline-light fw-semibold d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-18">arrow_back</span>
        Back to Assessment
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <!-- Assessment Header Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="small text-muted mb-1">Project Type *</label>
                        <select class="form-select form-select-sm" id="projectType">
                            <option value="">Select Project Type</option>
                            <option value="CCTV Installation" selected>CCTV Installation</option>
                            <option value="CCTV Rehabilitation">CCTV Rehabilitation</option>
                            <option value="CCTV Relocation">CCTV Relocation</option>
                            <option value="Solar Setup">Solar Setup</option>
                            <option value="Solar Street Lights">Solar Street Lights</option>
                            <option value="Public Address System">Public Address System</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted mb-1">Location</label>
                        <input type="text" class="form-control form-control-sm" id="location" value="Bacoor, Cavite">
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted mb-1">Contact Person</label>
                        <input type="text" class="form-control form-control-sm" id="contactPerson" value="Maria Santos">
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted mb-1">Contact Number</label>
                        <input type="text" class="form-control form-control-sm" id="contactNumber" value="0998-884-5671">
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
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" value="IP Camera 2MP Outdoor">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" value="8" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option>roll</option><option>pair</option>
                                        <option>set</option><option>meters</option><option>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0" value="Front, Back, Sides"></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" value="8-Channel NVR with 2TB HDD">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" value="1" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option>roll</option><option>pair</option>
                                        <option>set</option><option>meters</option><option>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0" value="Main Office"></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" value="Cat6 UTP Cable">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" value="1" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option selected>roll</option><option>pair</option>
                                        <option>set</option><option>meters</option><option>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0" value="Throughout property"></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" value="DC Connector">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" value="8" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option>roll</option><option>pair</option>
                                        <option>set</option><option>meters</option><option>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0" value="Each camera"></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" value="Video Balun">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" value="2" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option>roll</option><option selected>pair</option>
                                        <option>set</option><option>meters</option><option>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0" value="Each camera"></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" value="Cable clips & fasteners">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" value="1" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option>roll</option><option>pair</option>
                                        <option>set</option><option>meters</option><option selected>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0" value="Cable routing"></td>
                            </tr>
                            <!-- Empty row -->
                            <tr>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0" placeholder="Type or click + to select...">
                                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                                            <span class="material-symbols-outlined fs-18">add_circle</span>
                                        </button>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control form-control-sm border-0" placeholder="0" min="0"></td>
                                <td>
                                    <select class="form-select form-select-sm border-0">
                                        <option>pcs</option><option>roll</option><option>pair</option>
                                        <option>set</option><option>meters</option><option>lot</option><option>box</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm border-0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-sm btn-outline-success mt-2 d-flex align-items-center gap-1" onclick="addRow()">
                    <span class="material-symbols-outlined fs-18">add</span>
                    Add Row
                </button>
            </div>
        </div>

        <!-- Assessment Notes -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Assessment Notes</h6>
                <textarea class="form-control" rows="4" id="assessmentNotes"
                    placeholder="Add installation notes, special requirements, site conditions, etc..."></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-2">
            <button class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <span class="material-symbols-outlined fs-18">save</span>
                Save Draft
            </button>
            <button class="btn btn-success d-flex align-items-center gap-1" onclick="completeAndGenerate()">
                <span class="material-symbols-outlined fs-18">description</span>
                Complete & Generate Quotation
            </button>
        </div>

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
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="IP Camera 2MP Outdoor">IP Camera 2MP Outdoor</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="8-Channel NVR with 2TB HDD">8-Channel NVR with 2TB HDD</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="DC Connector">DC Connector</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="Video Balun">Video Balun</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="Cat6 UTP Cable">Cat6 UTP Cable</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="Cable Clips">Cable Clips</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="Power Supply 12V 2A">Power Supply 12V 2A</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="HDMI Cable 10m">HDMI Cable 10m</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="RJ45 Connector">RJ45 Connector</button>
                        <button type="button" class="list-group-item list-group-item-action" data-item-name="Conduit Pipe 1 inch">Conduit Pipe 1 inch</button>
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
        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('inventoryPickerModal');
            const pickerModal = new bootstrap.Modal(modalEl);
            let currentInput = null;

            window.openInventoryPicker = function(button) {
                currentInput = button.previousElementSibling;
                pickerModal.show();
            };

            document.getElementById('inventoryItemList').addEventListener('click', function(e) {
                const btn = e.target.closest('[data-item-name]');
                if (!btn) return;
                if (currentInput) {
                    currentInput.value = btn.getAttribute('data-item-name');
                    currentInput.dispatchEvent(new Event('input'));
                }
                pickerModal.hide();
                currentInput = null;
            });

            modalEl.addEventListener('show.bs.modal', function() {
                document.getElementById('quickSearch').value = '';
                document.querySelectorAll('#inventoryItemList [data-item-name]').forEach(function(item) {
                    item.style.display = '';
                });
            });

            document.getElementById('quickSearch').addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                document.querySelectorAll('#inventoryItemList [data-item-name]').forEach(function(item) {
                    item.style.display = item.getAttribute('data-item-name').toLowerCase().includes(term) ? '' : 'none';
                });
            });

        });

        const UNIT_OPTIONS = ['pcs','roll','pair','set','meters','lot','box']
            .map(u => `<option>${u}</option>`).join('');

        function addRow() {
            const tbody = document.querySelector('#materialsTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control border-0" placeholder="Type or click + to select...">
                        <button class="btn btn-outline-success btn-sm picker-btn" onclick="openInventoryPicker(this)" title="Pick from inventory">
                            <span class="material-symbols-outlined fs-18">add_circle</span>
                        </button>
                    </div>
                </td>
                <td><input type="number" class="form-control form-control-sm border-0" placeholder="0" min="0"></td>
                <td><select class="form-select form-select-sm border-0">${UNIT_OPTIONS}</select></td>
                <td><input type="text" class="form-control form-control-sm border-0"></td>
            `;
            tbody.appendChild(newRow);
        }

        function completeAndGenerate() {
            const materials = [];
            document.querySelectorAll('#materialsTable tbody tr').forEach(function(row) {
                const inputs = row.querySelectorAll('input[type="text"]');
                const item = inputs[0] ? inputs[0].value.trim() : '';
                if (item) {
                    materials.push({
                        item: item,
                        quantity: row.querySelector('input[type="number"]')?.value.trim() || '',
                        unit: row.querySelector('select')?.value || '',
                        location: inputs[1]?.value.trim() || ''
                    });
                }
            });

            if (materials.length === 0) {
                alert('Please add at least one item to the assessment.');
                return;
            }

            const assessmentData = {
                assessmentId: 'ASM-2026-001',
                clientName: document.getElementById('contactPerson').value,
                projectType: document.getElementById('projectType').value,
                location: document.getElementById('location').value,
                contactNumber: document.getElementById('contactNumber').value,
                materials: materials,
                notes: document.getElementById('assessmentNotes').value,
                date: new Date().toISOString().split('T')[0]
            };

            localStorage.setItem('assessmentData', JSON.stringify(assessmentData));

            if (confirm('Assessment complete! Generate quotation now?')) {
                window.location.href = '?from=assessment&id=ASM-2026-001';
            }
        }
    </script>
@endsection