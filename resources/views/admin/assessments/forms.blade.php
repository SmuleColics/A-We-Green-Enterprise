@extends('layouts.admin')
@section('title', 'Assessment Form')
@section('styles') <link rel="stylesheet" href="{{ asset('css/admin/assessments/form.css') }}"> @endsection
@section('page-title', 'Assessment Form')
@section('page-subtitle', 'Assessment #' . $assessment->id . ' | ' . $assessment->client->user->full_name)
@section('topbar-actions')
    <a href="{{ route('assessments') }}" class="btn btn-sm btn-outline-light">Back to Assessment</a>
@endsection
@php
    $formItems = old('items', $assessment->items->map(fn($item) => ['material_id' => $item->material_id, 'quantity' => $item->quantity, 'unit' => $item->unit, 'location' => $item->location])->all());
    if (empty($formItems)) $formItems = [['material_id' => '', 'quantity' => '', 'unit' => '', 'location' => '']];
@endphp
@section('content')
<div class="container-fluid px-4 py-4">
@if ($quotation && $quotation->status === 'Rejected')
    <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
        <span class="material-symbols-outlined fs-18">rate_review</span>
        <div class="small">
            <p class="mb-1"><strong>The client requested changes to this quotation</strong>
                @if ($quotation->revision_requested_at)
                    on {{ $quotation->revision_requested_at->format('F j, Y') }}
                @endif
                .</p>
            @if ($quotation->revision_reason_category)
                <p class="mb-1"><strong>Reason:</strong> {{ $quotation->revision_reason_category }}</p>
            @endif
            @if ($quotation->revision_reason)
                <p class="mb-0"><strong>Details:</strong> {{ $quotation->revision_reason }}</p>
            @endif
        </div>
    </div>
@endif
<form method="POST" action="{{ route('assessments.form.update', $assessment) }}">
@csrf @method('PUT')
<div class="card border-0 shadow-sm mb-4"><div class="card-body"><div class="row g-3">
<div class="col-md-3"><label class="small text-muted">Service(s)</label><input class="form-control form-control-sm bg-light" value="{{ implode(', ', $assessment->services) }}" readonly></div>
<div class="col-md-3"><label class="small text-muted">Location</label><input class="form-control form-control-sm bg-light" value="{{ $assessment->client->city }}, {{ $assessment->client->province }}" readonly></div>
<div class="col-md-3"><label class="small text-muted">Contact Person</label><input class="form-control form-control-sm bg-light" value="{{ $assessment->client->user->full_name }}" readonly></div>
<div class="col-md-3"><label class="small text-muted">Contact Number</label><input class="form-control form-control-sm bg-light" value="{{ $assessment->client->user->contact_number }}" readonly></div>
</div></div></div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body"><h6 class="fw-semibold mb-2 green-text">ASSESSMENT FORM</h6><p class="small text-muted">Choose every item from Materials. Names, units, and prices are locked to inventory so the quotation is accurate.</p>
<div class="table-responsive"><table class="table table-bordered" id="materialsTable"><thead class="table-success"><tr><th>ITEM</th><th>QUANTITY</th><th>UNIT</th><th>LOCATION</th><th></th></tr></thead><tbody>
@foreach($formItems as $index => $item)<tr>
<td><select name="items[{{ $index }}][material_id]" class="form-select form-select-sm material-select" required><option value="">Select a material...</option>@foreach($materials as $material)<option value="{{ $material->id }}" data-unit="{{ $material->unit }}" @selected(($item['material_id'] ?? '') == $material->id)>{{ $material->name }} ({{ $material->unit }})</option>@endforeach</select></td>
<td><input type="number" name="items[{{ $index }}][quantity]" class="form-control form-control-sm" value="{{ $item['quantity'] }}" min="0.01" step="0.01" required></td>
<td><input class="form-control form-control-sm material-unit bg-light" value="{{ $item['unit'] }}" readonly></td>
<td><input type="text" name="items[{{ $index }}][location]" class="form-control form-control-sm" value="{{ $item['location'] }}" placeholder="Installation location"></td><td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>
</tr>@endforeach
</tbody></table></div><button type="button" class="btn btn-sm btn-outline-success" id="addRow">Add Row</button></div></div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body"><h6 class="fw-semibold">Assessment Notes</h6><textarea name="assessment_notes" class="form-control" rows="4">{{ old('assessment_notes', $assessment->assessment_notes) }}</textarea></div></div>
<div class="d-flex justify-content-end gap-2"><a target="_blank" href="{{ route('assessments.form.print', $assessment) }}" class="btn btn-outline-secondary">Print / Preview PDF</a>@if($quotation)<a href="{{ route('quotations.show', $quotation) }}" class="btn btn-outline-primary">View Quotation</a><button class="btn btn-success">Update Assessment Form</button>@else<button class="btn btn-success">Save, Create & Send Quotation</button>@endif</div>
</form></div>
@endsection
@section('scripts')
<script>
const materials = @json($materials->map(fn($m)=>['id'=>$m->id,'name'=>$m->name,'unit'=>$m->unit])); let rowIndex={{ count($formItems) }};
const optionList = () => '<option value="">Select a material...</option>'+materials.map(m=>`<option value="${m.id}" data-unit="${m.unit}">${m.name} (${m.unit})</option>`).join('');
function syncUnit(select){select.closest('tr').querySelector('.material-unit').value=select.options[select.selectedIndex]?.dataset.unit||'';}
document.addEventListener('change',e=>{if(e.target.matches('.material-select'))syncUnit(e.target);});
document.getElementById('addRow').onclick=()=>{document.querySelector('#materialsTable tbody').insertAdjacentHTML('beforeend',`<tr><td><select name="items[${rowIndex}][material_id]" class="form-select form-select-sm material-select" required>${optionList()}</select></td><td><input type="number" name="items[${rowIndex}][quantity]" class="form-control form-control-sm" min="0.01" step="0.01" required></td><td><input class="form-control form-control-sm material-unit bg-light" readonly></td><td><input name="items[${rowIndex}][location]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td></tr>`);rowIndex++;};
document.addEventListener('click',e=>{if(e.target.matches('.remove-row')) e.target.closest('tr').remove();});
</script>
<style>@media print {.sidebar,.topbar,.btn{display:none!important}.card{box-shadow:none!important;border:0!important}}</style>
@endsection
