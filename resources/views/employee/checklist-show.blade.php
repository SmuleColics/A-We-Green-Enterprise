@extends('layouts.admin')

@section('title', 'Checklist')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/checklists/checklists.css') }}">
@endsection

@section('page-title', 'Items Checklist')

@section('topbar-actions')
    <a target="_blank" href="{{ route('employee.checklists.print', $project) }}"
        class="btn btn-sm btn-outline-light fw-semibold d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">print</span>
        Preview PDF
    </a>
    <a href="{{ route('employee.projects.show', $project) }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Project
    </a>
@endsection

@section('content')
    @php
        $completedCount = $project->checklistItems->filter(fn ($i) => $i->is_completed || $i->is_not_applicable)->count();
    @endphp
    <div class="container-fluid px-4 py-4">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <p class="text-muted small mb-0">{{ $project->project_title }} — {{ $project->quotation->assessment->client->user->full_name }}</p>
                    <p class="text-muted small mb-0">{{ $completedCount }} of {{ $project->checklistItems->count() }} accounted for
                        &nbsp;—&nbsp; {{ $project->reference_number }} &nbsp;—&nbsp; {{ $project->service_type }}</p>
                </div>
                @unless ($canEdit)
                    <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-15">visibility</span>
                        View only
                    </span>
                @endunless
            </div>
        </div>

        @if ($canEdit)
            <form method="POST" action="{{ route('employee.checklists.update', $project) }}">
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
                                        <th class="text-center">Out</th>
                                        <th class="text-center">N/A</th>
                                        <th class="text-center">Complete</th>
                                        <th class="text-center">Return</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($project->checklistItems as $index => $item)
                                        <tr class="{{ $item->is_completed ? 'row-complete' : '' }}">
                                            <td>
                                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                                {{ $item->item_name }}
                                            </td>
                                            <td>{{ rtrim(rtrim($item->quantity, '0'), '.') }} {{ $item->unit }}</td>
                                            <td class="text-center">
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $index }}][outgoing_quantity]"
                                                    class="form-control form-control-sm checklist-input mx-auto"
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
                                            <td class="text-center">
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $index }}][returned_quantity]"
                                                    class="form-control form-control-sm checklist-input mx-auto"
                                                    value="{{ old("items.$index.returned_quantity", $item->returned_quantity) }}"
                                                    placeholder="0">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No checklist items for this project.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if ($project->checklistItems->isNotEmpty())
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-18">save</span>
                            Save Checklist
                        </button>
                    </div>
                @endif
            </form>
        @else
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="checklist-table w-100">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th class="text-center">Out</th>
                                    <th class="text-center">N/A</th>
                                    <th class="text-center">Complete</th>
                                    <th class="text-center">Return</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($project->checklistItems as $item)
                                    <tr class="{{ $item->is_completed ? 'row-complete' : '' }}">
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ rtrim(rtrim($item->quantity, '0'), '.') }} {{ $item->unit }}</td>
                                        <td class="text-center">{{ $item->outgoing_quantity !== null ? rtrim(rtrim($item->outgoing_quantity, '0'), '.') : '—' }}</td>
                                        <td class="text-center">
                                            @if ($item->is_not_applicable)
                                                <span class="material-symbols-outlined text-success fs-18" style="vertical-align:middle;">check_circle</span>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->is_completed)
                                                <span class="material-symbols-outlined text-success fs-18" style="vertical-align:middle;">check_circle</span>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->returned_quantity !== null ? rtrim(rtrim($item->returned_quantity, '0'), '.') : '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No checklist items for this project.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
