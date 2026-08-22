@extends('layouts.admin')

@section('title', 'Checklist')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/checklists/checklists.css') }}">
@endsection

@section('page-title', 'Items Checklist')
@section('page-subtitle', $project->project_title . ' | ' . $project->quotation->assessment->client->user->full_name)

@section('topbar-actions')
    <a target="_blank" href="{{ route('checklists.print', $project) }}" class="btn btn-sm btn-outline-light fw-semibold d-flex align-items-center gap-1"><span class="material-symbols-outlined fs-17">print</span>Preview PDF</a>
    <a href="{{ route('checklists') }}" class="btn btn-sm btn-outline-light">Back to Checklists</a>
@endsection

@section('content')
    @php
        $completedCount = $project->checklistItems->filter(fn ($i) => $i->is_completed || $i->is_not_applicable)->count();
    @endphp
    <div class="container-fluid px-4 py-4">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <p class="text-muted small mb-0">{{ $completedCount }} of {{ $project->checklistItems->count() }} accounted for
                    &nbsp;—&nbsp; {{ $project->reference_number }} &nbsp;—&nbsp; {{ $project->service_type }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('checklists.update', $project) }}">
            @csrf
            @method('PUT')
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="checklist-table w-100">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Out</th>
                                    <th>N/A</th>
                                    <th>Complete</th>
                                    <th>Return</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->checklistItems as $index => $item)
                                    <tr class="{{ $item->is_completed ? 'row-complete' : '' }}">
                                        <td>
                                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                            {{ $item->item_name }}
                                        </td>
                                        <td>{{ rtrim(rtrim($item->quantity, '0'), '.') }} {{ $item->unit }}</td>
                                        <td>
                                            <input type="number" step="0.01" min="0"
                                                name="items[{{ $index }}][outgoing_quantity]"
                                                class="form-control form-control-sm checklist-input"
                                                value="{{ old("items.$index.outgoing_quantity", $item->outgoing_quantity) }}"
                                                placeholder="0">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input"
                                                name="items[{{ $index }}][is_not_applicable]" value="1"
                                                @checked($item->is_not_applicable)>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input"
                                                name="items[{{ $index }}][is_completed]" value="1"
                                                @checked($item->is_completed)>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0"
                                                name="items[{{ $index }}][returned_quantity]"
                                                class="form-control form-control-sm checklist-input"
                                                value="{{ old("items.$index.returned_quantity", $item->returned_quantity) }}"
                                                placeholder="0">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-18">save</span>
                    Save Checklist
                </button>
            </div>
        </form>

    </div>
@endsection
