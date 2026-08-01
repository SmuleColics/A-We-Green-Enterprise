@extends('layouts.admin')

@section('title', 'Materials')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/materials/materials.css') }}">
@endsection

@section('page-title', 'Materials')

@section('topbar-actions')
    <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#archiveModal">
        <span class="material-symbols-outlined fs-17">inventory_2</span>
        View Archives
    </button>
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
                    <span class="material-symbols-outlined summary-icon green-text">inventory_2</span>
                    <div>
                        <p class="summary-label">Total Items</p>
                        <p class="summary-value">48</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-success">check_circle</span>
                    <div>
                        <p class="summary-label">In Stock</p>
                        <p class="summary-value">35</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-warning">warning</span>
                    <div>
                        <p class="summary-label">Low Stock</p>
                        <p class="summary-value">9</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-card">
                    <span class="material-symbols-outlined summary-icon text-danger">cancel</span>
                    <div>
                        <p class="summary-label">Out of Stock</p>
                        <p class="summary-value">4</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="mb-3 btn-group filter-btn-group" role="group">
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
                                <th class="border-0 small green-text">In Stock</th>
                                <th class="border-0 small green-text">Unit Cost (₱)</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- CCTV --}}
                            <tr>
                                <td><span class="fw-semibold">IP Camera 2MP Outdoor</span></td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>pcs</td>
                                <td>24</td>
                                <td>₱2,500.00</td>
                                <td><span class="badge bg-success rounded-pill">In Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'IP Camera 2MP Outdoor',category:'CCTV',unit:'pcs',stock:24,cost:'₱2,500.00',status:'In Stock',description:'2 Megapixel outdoor IP camera with night vision and weatherproof casing.',supplier:'TechPro Supplies',location:'Shelf A-1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'IP Camera 2MP Outdoor',category:'CCTV',unit:'pcs',stock:24,cost:2500,description:'2 Megapixel outdoor IP camera with night vision and weatherproof casing.',supplier:'TechPro Supplies',location:'Shelf A-1'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">8-Channel NVR with 2TB HDD</span></td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>unit</td>
                                <td>8</td>
                                <td>₱8,500.00</td>
                                <td><span class="badge bg-success rounded-pill">In Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'8-Channel NVR with 2TB HDD',category:'CCTV',unit:'unit',stock:8,cost:'₱8,500.00',status:'In Stock',description:'8-channel network video recorder bundled with 2TB hard drive.',supplier:'NetVision Inc.',location:'Shelf A-2'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'8-Channel NVR with 2TB HDD',category:'CCTV',unit:'unit',stock:8,cost:8500,description:'8-channel network video recorder bundled with 2TB hard drive.',supplier:'NetVision Inc.',location:'Shelf A-2'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Cat6 UTP Cable</span></td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>roll</td>
                                <td>3</td>
                                <td>₱1,800.00</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Low Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Cat6 UTP Cable',category:'CCTV',unit:'roll',stock:3,cost:'₱1,800.00',status:'Low Stock',description:'Cat6 unshielded twisted pair cable, 305m per roll.',supplier:'CablePro PH',location:'Shelf B-1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Cat6 UTP Cable',category:'CCTV',unit:'roll',stock:3,cost:1800,description:'Cat6 unshielded twisted pair cable, 305m per roll.',supplier:'CablePro PH',location:'Shelf B-1'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">DC Power Supply 12V 5A</span></td>
                                <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                <td>pcs</td>
                                <td>0</td>
                                <td>₱650.00</td>
                                <td><span class="badge bg-danger rounded-pill">Out of Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'DC Power Supply 12V 5A',category:'CCTV',unit:'pcs',stock:0,cost:'₱650.00',status:'Out of Stock',description:'12V 5A CCTV power supply with multi-output ports.',supplier:'PowerTech Supplies',location:'Shelf A-3'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'DC Power Supply 12V 5A',category:'CCTV',unit:'pcs',stock:0,cost:650,description:'12V 5A CCTV power supply with multi-output ports.',supplier:'PowerTech Supplies',location:'Shelf A-3'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- Solar --}}
                            <tr>
                                <td><span class="fw-semibold">Solar Panel 330W Monocrystalline</span></td>
                                <td><span class="cat-badge cat-solar">Solar</span></td>
                                <td>pcs</td>
                                <td>12</td>
                                <td>₱6,500.00</td>
                                <td><span class="badge bg-success rounded-pill">In Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Solar Panel 330W Monocrystalline',category:'Solar',unit:'pcs',stock:12,cost:'₱6,500.00',status:'In Stock',description:'High-efficiency 330W monocrystalline solar panel.',supplier:'SolarGreen PH',location:'Warehouse Row C'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Solar Panel 330W Monocrystalline',category:'Solar',unit:'pcs',stock:12,cost:6500,description:'High-efficiency 330W monocrystalline solar panel.',supplier:'SolarGreen PH',location:'Warehouse Row C'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Solar Inverter 3kW</span></td>
                                <td><span class="cat-badge cat-solar">Solar</span></td>
                                <td>unit</td>
                                <td>4</td>
                                <td>₱18,000.00</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Low Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Solar Inverter 3kW',category:'Solar',unit:'unit',stock:4,cost:'₱18,000.00',status:'Low Stock',description:'3kW pure sine wave solar inverter with built-in MPPT charge controller.',supplier:'SolarGreen PH',location:'Warehouse Row C'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Solar Inverter 3kW',category:'Solar',unit:'unit',stock:4,cost:18000,description:'3kW pure sine wave solar inverter with built-in MPPT charge controller.',supplier:'SolarGreen PH',location:'Warehouse Row C'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Lithium Battery 100Ah</span></td>
                                <td><span class="cat-badge cat-solar">Solar</span></td>
                                <td>unit</td>
                                <td>0</td>
                                <td>₱22,000.00</td>
                                <td><span class="badge bg-danger rounded-pill">Out of Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Lithium Battery 100Ah',category:'Solar',unit:'unit',stock:0,cost:'₱22,000.00',status:'Out of Stock',description:'100Ah LiFePO4 lithium deep cycle battery for solar storage.',supplier:'BatteryKing PH',location:'Warehouse Row D'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Lithium Battery 100Ah',category:'Solar',unit:'unit',stock:0,cost:22000,description:'100Ah LiFePO4 lithium deep cycle battery for solar storage.',supplier:'BatteryKing PH',location:'Warehouse Row D'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- PA System --}}
                            <tr>
                                <td><span class="fw-semibold">Horn Speaker 30W</span></td>
                                <td><span class="cat-badge cat-pa">PA System</span></td>
                                <td>pcs</td>
                                <td>18</td>
                                <td>₱950.00</td>
                                <td><span class="badge bg-success rounded-pill">In Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Horn Speaker 30W',category:'PA System',unit:'pcs',stock:18,cost:'₱950.00',status:'In Stock',description:'30W weather-resistant horn speaker for outdoor PA systems.',supplier:'AudioPro PH',location:'Shelf D-1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Horn Speaker 30W',category:'PA System',unit:'pcs',stock:18,cost:950,description:'30W weather-resistant horn speaker for outdoor PA systems.',supplier:'AudioPro PH',location:'Shelf D-1'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">100W Mixer Amplifier</span></td>
                                <td><span class="cat-badge cat-pa">PA System</span></td>
                                <td>unit</td>
                                <td>5</td>
                                <td>₱7,200.00</td>
                                <td><span class="badge bg-success rounded-pill">In Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'100W Mixer Amplifier',category:'PA System',unit:'unit',stock:5,cost:'₱7,200.00',status:'In Stock',description:'100W rack-mount mixer amplifier with 3 mic inputs and 1 aux input.',supplier:'AudioPro PH',location:'Shelf D-2'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'100W Mixer Amplifier',category:'PA System',unit:'unit',stock:5,cost:7200,description:'100W rack-mount mixer amplifier with 3 mic inputs and 1 aux input.',supplier:'AudioPro PH',location:'Shelf D-2'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

                            {{-- General --}}
                            <tr>
                                <td><span class="fw-semibold">Cable Ties (100pcs/bag)</span></td>
                                <td><span class="cat-badge cat-general">General</span></td>
                                <td>bag</td>
                                <td>22</td>
                                <td>₱85.00</td>
                                <td><span class="badge bg-success rounded-pill">In Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Cable Ties (100pcs/bag)',category:'General',unit:'bag',stock:22,cost:'₱85.00',status:'In Stock',description:'Assorted nylon cable ties, 100 pieces per bag.',supplier:'Hardware Plus',location:'Shelf E-1'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Cable Ties (100pcs/bag)',category:'General',unit:'bag',stock:22,cost:85,description:'Assorted nylon cable ties, 100 pieces per bag.',supplier:'Hardware Plus',location:'Shelf E-1'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-semibold">Electrical Tape</span></td>
                                <td><span class="cat-badge cat-general">General</span></td>
                                <td>roll</td>
                                <td>2</td>
                                <td>₱35.00</td>
                                <td><span class="badge bg-warning text-dark rounded-pill">Low Stock</span></td>
                                <td class="text-nowrap actions-col">
                                    <button class="btn btn-sm btn-outline-success action-btn" title="View"
                                        data-bs-toggle="modal" data-bs-target="#viewMaterialModal"
                                        onclick="loadMaterial({name:'Electrical Tape',category:'General',unit:'roll',stock:2,cost:'₱35.00',status:'Low Stock',description:'PVC insulation electrical tape, black.',supplier:'Hardware Plus',location:'Shelf E-2'})">
                                        <span class="material-symbols-outlined icon-action">visibility</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary action-btn" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                        onclick="loadEditMaterial({name:'Electrical Tape',category:'General',unit:'roll',stock:2,cost:35,description:'PVC insulation electrical tape, black.',supplier:'Hardware Plus',location:'Shelf E-2'})">
                                        <span class="material-symbols-outlined icon-action">edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn" title="Archive">
                                        <span class="material-symbols-outlined icon-action">archive</span>
                                    </button>
                                </td>
                            </tr>

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
                        <div class="mat-icon-circle mat-icon-circle-lg" id="vm-icon-wrap">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 fs-16" id="vm-name">—</p>
                            <span class="cat-badge mt-1 d-inline-block" id="vm-category-badge">—</span>
                        </div>
                    </div>

                    <p class="section-label">Stock Information</p>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <p class="detail-label small mb-0">Unit</p>
                            <p class="detail-value small fw-semibold" id="vm-unit">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">In Stock</p>
                            <p class="detail-value small fw-semibold" id="vm-stock">—</p>
                        </div>
                        <div class="col-4">
                            <p class="detail-label small mb-0">Status</p>
                            <p class="detail-value small" id="vm-status">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Unit Cost</p>
                            <p class="detail-value small fw-semibold green-text" id="vm-cost">—</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-label small mb-0">Supplier</p>
                            <p class="detail-value small" id="vm-supplier">—</p>
                        </div>
                    </div>

                    <p class="section-label">Storage</p>
                    <div class="row g-2 mb-2">
                        <div class="col-12">
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
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1">
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
                            <input type="text" id="edit-mat-name" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Category <span class="text-danger">*</span></label>
                            <select id="edit-mat-category" class="form-select form-select-sm">
                                <option>CCTV</option>
                                <option>Solar</option>
                                <option>PA System</option>
                                <option>General</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Unit <span class="text-danger">*</span></label>
                            <select id="edit-mat-unit" class="form-select form-select-sm">
                                <option>pcs</option>
                                <option>unit</option>
                                <option>roll</option>
                                <option>bag</option>
                                <option>set</option>
                                <option>meters</option>
                                <option>lot</option>
                                <option>box</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Quantity in Stock <span class="text-danger">*</span></label>
                            <input type="number" id="edit-mat-stock" class="form-control form-control-sm"
                                min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Unit Cost (₱) <span class="text-danger">*</span></label>
                            <input type="number" id="edit-mat-cost" class="form-control form-control-sm"
                                min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Supplier</label>
                            <input type="text" id="edit-mat-supplier" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Storage Location</label>
                            <input type="text" id="edit-mat-location" class="form-control form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Description</label>
                            <textarea id="edit-mat-description" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">save</span>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Add Material Modal ── -->
    <div class="modal fade" id="addMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
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
                            <input type="text" class="form-control form-control-sm"
                                placeholder="e.g. IP Camera 2MP Outdoor">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
                                <option value="">Select category</option>
                                <option>CCTV</option>
                                <option>Solar</option>
                                <option>PA System</option>
                                <option>General</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Unit <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm">
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
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Quantity in Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" placeholder="0" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Unit Cost (₱) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" placeholder="0.00"
                                min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Supplier</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Supplier name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Storage Location</label>
                            <input type="text" class="form-control form-control-sm" placeholder="e.g. Shelf A-1">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Description</label>
                            <textarea class="form-control form-control-sm" rows="2" placeholder="Brief description of the item..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-16">save</span>Save Material
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ── Archive Modal ── -->
    <div class="modal fade" id="archiveModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-22">inventory_2</span>
                        <h5 class="modal-title mb-0">Archived Materials</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="archiveTable" class="table table-hover mb-0 small w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 small green-text">Item</th>
                                    <th class="border-0 small green-text">Category</th>
                                    <th class="border-0 small green-text">Unit</th>
                                    <th class="border-0 small green-text">Last Stock</th>
                                    <th class="border-0 small green-text">Status</th>
                                    <th class="border-0 small green-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Video Balun Passive</td>
                                    <td><span class="cat-badge cat-cctv">CCTV</span></td>
                                    <td>pairs</td>
                                    <td>0</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">MC4 Solar Connector Set</td>
                                    <td><span class="cat-badge cat-solar">Solar</span></td>
                                    <td>set</td>
                                    <td>2</td>
                                    <td><span class="badge bg-secondary rounded-pill">Archived</span></td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-success action-btn" title="Restore">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
                                            Restore
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const catColors = {
            'CCTV': {
                bg: 'rgba(59,130,246,.12)',
                border: '#3b82f6',
                text: '#3b82f6'
            },
            'Solar': {
                bg: 'rgba(22,162,73,.12)',
                border: '#16A249',
                text: '#16A249'
            },
            'PA System': {
                bg: 'rgba(245,158,11,.12)',
                border: '#f59e0b',
                text: '#b45309'
            },
            'General': {
                bg: 'rgba(107,114,128,.12)',
                border: '#6b7280',
                text: '#374151'
            }
        };

        function loadMaterial(d) {
            document.getElementById('vm-name').textContent = d.name || '—';
            document.getElementById('vm-unit').textContent = d.unit || '—';
            document.getElementById('vm-stock').textContent = d.stock ?? '—';
            document.getElementById('vm-cost').textContent = d.cost || '—';
            document.getElementById('vm-supplier').textContent = d.supplier || '—';
            document.getElementById('vm-location').textContent = d.location || '—';
            document.getElementById('vm-description').textContent = d.description || '—';

            const parts = (d.name || '').trim().split(' ');
            const initials = parts.length >= 2 ? parts[0][0] + parts[1][0] : (parts[0] ? parts[0][0] : '?');
            const c = catColors[d.category] || catColors['General'];

            const avatar = document.getElementById('vm-avatar');
            avatar.textContent = initials.toUpperCase();
            avatar.style.backgroundColor = c.bg;
            avatar.style.border = `2px solid ${c.border}`;
            avatar.style.color = c.text;

            const badge = document.getElementById('vm-category-badge');
            badge.textContent = d.category || '—';
            const catMap = {
                CCTV: 'cat-cctv',
                Solar: 'cat-solar',
                'PA System': 'cat-pa',
                General: 'cat-general'
            };
            badge.className = `cat-badge ${catMap[d.category] || ''}`;

            const statusMap = {
                'In Stock': 'bg-success',
                'Low Stock': 'bg-warning text-dark',
                'Out of Stock': 'bg-danger'
            };
            document.getElementById('vm-status').innerHTML =
                `<span class="badge rounded-pill ${statusMap[d.status] || 'bg-secondary'}">${d.status}</span>`;
        }

        function loadEditMaterial(d) {
            document.getElementById('edit-mat-name').value = d.name || '';
            document.getElementById('edit-mat-category').value = d.category || 'CCTV';
            document.getElementById('edit-mat-unit').value = d.unit || 'pcs';
            document.getElementById('edit-mat-stock').value = d.stock ?? 0;
            document.getElementById('edit-mat-cost').value = d.cost ?? 0;
            document.getElementById('edit-mat-supplier').value = d.supplier || '';
            document.getElementById('edit-mat-location').value = d.location || '';
            document.getElementById('edit-mat-description').value = d.description || '';
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
                targets: 6
            }]
        });

        $('#archiveModal').on('shown.bs.modal', function() {
            if (!$.fn.DataTable.isDataTable('#archiveTable')) {
                $('#archiveTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    info: true,
                    order: [
                        [0, 'asc']
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: 5
                    }]
                });
            }
        });
    </script>
@endsection
