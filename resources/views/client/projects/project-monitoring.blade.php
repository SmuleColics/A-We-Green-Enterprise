@extends('layouts.client')

@section('title', 'Project Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/client/project-monitoring.css') }}">
@endsection

@section('content')

    @php
        $quotation = $project->quotation;
        $activeTasks = $project->activeTasks();
        $assignedEmployees = $activeTasks->pluck('employee')->filter()->unique('id')->values();
        $activeUpdates = $project->activeUpdates();
    @endphp

    <div class="page-wrapper">
        <div class="page-hero">
            <h2>Project Details</h2>
            <p>{{ $project->project_title }}</p>
        </div>

        <div class="main-content">

            <div class="mb-3">
                <a href="{{ route('client-project') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" style="width:fit-content;">
                    <span class="material-symbols-outlined fs-15">arrow_back</span>
                    Back to Projects
                </a>
            </div>

            <!-- Project Header Card -->
            <div class="detail-card mb-4">
                <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-3 mb-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h4 class="fw-bold mb-0">{{ $project->project_title }}</h4>
                            <span class="badge rounded-pill
                                @if ($project->status === 'Completed') bg-success-subtle text-success border border-success-subtle
                                @elseif ($project->status === 'On Hold') bg-warning-subtle text-warning border border-warning-subtle
                                @elseif ($project->status === 'In Progress') bg-primary-subtle text-primary border border-primary-subtle
                                @else bg-secondary-subtle text-secondary border border-secondary-subtle
                                @endif">{{ $project->status }}</span>
                        </div>
                        @if ($project->location)
                            <p class="text-muted small mb-1">
                                <span class="material-symbols-outlined text-muted fs-14" style="vertical-align:middle;">location_on</span>
                                {{ $project->location }}
                            </p>
                        @endif
                        <p class="text-muted small mb-0">
                            <span class="service-badge badge-green me-2">{{ $project->service_type }}</span>
                            {{ $project->reference_number }} &nbsp;—&nbsp; Started {{ $project->start_date->format('M j, Y') }}
                            @if ($project->end_date)
                                &nbsp;—&nbsp; Due {{ $project->end_date->format('M j, Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <span class="progress-pct">{{ $project->taskProgress() }}%</span>
                    </div>
                </div>

                <div class="progress mb-4" style="height:10px;border-radius:8px;">
                    <div class="progress-bar bg-success" style="width:{{ $project->taskProgress() }}%;border-radius:8px;"></div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @if ($quotation->contract_file)
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($quotation->contract_file) }}" target="_blank"
                            class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-17">description</span>
                            View Contract File
                        </a>
                    @endif
                    <a href="{{ route('client-assessment.show', $quotation->assessment) }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">assignment</span>
                        View Assessment
                    </a>
                    <a href="{{ route('quotation-view', $quotation) }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-17">request_quote</span>
                        View Quotation
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <ul class="nav nav-tabs border-0 mb-0" id="projectSectionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updatesSection"
                            type="button" role="tab" aria-controls="updatesSection" aria-selected="true">
                            Project Updates
                            <span class="badge rounded-pill bg-success-subtle text-success">{{ $activeUpdates->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasksSection"
                            type="button" role="tab" aria-controls="tasksSection" aria-selected="false">
                            Project Tasks
                            <span class="badge rounded-pill bg-success-subtle text-success">{{ $activeTasks->count() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="projectSectionTabsContent">

                <!-- ── Project Updates Section (read-only) ── -->
                <div class="tab-pane fade show active" id="updatesSection" role="tabpanel" aria-labelledby="updates-tab">
                    <div class="detail-card">
                        @if ($activeUpdates->isEmpty())
                            <p class="text-muted small fst-italic mb-0">No updates posted yet.</p>
                        @else
                            <div class="timeline">
                                @foreach ($activeUpdates as $update)
                                    <div class="timeline-item {{ $loop->last ? 'last' : '' }}">
                                        <div class="tl-left">
                                            <div class="tl-dot"></div>
                                            @if (! $loop->last)
                                                <div class="tl-line"></div>
                                            @endif
                                        </div>
                                        <div class="tl-body">
                                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                <div class="update-avatar sm">{{ strtoupper(substr($update->user->full_name, 0, 2)) }}</div>
                                                <span class="small fw-semibold">{{ $update->user->full_name }}</span>
                                                <span class="text-muted small">·</span>
                                                <span class="text-muted small">{{ $update->created_at->format('M j, Y · g:i A') }}</span>
                                            </div>
                                            <p class="small mb-2">{{ $update->body }}</p>
                                            @if (! empty($update->images))
                                                <div class="update-images">
                                                    @foreach ($update->images as $image)
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($image) }}" class="update-thumb" alt="Update image"
                                                            onclick="openLightbox(this.src)" data-bs-toggle="modal" data-bs-target="#lightboxModal">
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ── Project Tasks Section (read-only) ── -->
                <div class="tab-pane fade" id="tasksSection" role="tabpanel" aria-labelledby="tasks-tab">
                    <div class="detail-card">
                        <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-18 text-success">group</span>
                            Assigned Team
                        </h6>
                        @if ($assignedEmployees->isEmpty())
                            <p class="text-muted small fst-italic mb-0">No one assigned yet.</p>
                        @else
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($assignedEmployees as $employee)
                                    <span class="team-chip">
                                        <span class="team-chip-avatar">{{ strtoupper(substr($employee->full_name, 0, 1)) }}</span>
                                        {{ $employee->full_name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <h6 class="fw-semibold mb-3 mt-4 pt-3 border-top d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-18 text-success">task_alt</span>
                            Project Tasks
                        </h6>
                        @if ($activeTasks->isEmpty())
                            <p class="text-muted small fst-italic mb-0">No tasks yet.</p>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach ($activeTasks as $task)
                                    <div class="task-item-card {{ $task->status === 'Completed' ? 'status-done' : ($task->status === 'In Progress' ? 'status-inprogress' : '') }}">
                                        <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
                                            <div>
                                                <p class="task-item-title mb-1">{{ $task->title }}</p>
                                                <p class="text-muted small mb-0">
                                                    {{ $task->start_date->format('M j') }} – {{ $task->due_date->format('M j, Y') }}
                                                    &nbsp;·&nbsp;
                                                    {{ $task->employee ? $task->employee->full_name : 'Unassigned' }}
                                                </p>
                                            </div>
                                            <span class="badge rounded-pill
                                                @if ($task->status === 'Completed') bg-success
                                                @elseif ($task->status === 'On Hold') bg-warning text-dark
                                                @elseif ($task->status === 'In Progress') bg-primary
                                                @else bg-secondary
                                                @endif">{{ $task->status }}</span>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <div class="progress flex-grow-1" style="height:6px;border-radius:8px;">
                                                <div class="progress-bar bg-success" style="width:{{ $task->progress() }}%;border-radius:8px;"></div>
                                            </div>
                                            <small class="text-muted">{{ $task->progress() }}%</small>
                                        </div>

                                        @if ($task->checklistItems->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-3 mt-2">
                                                @foreach ($task->checklistItems as $item)
                                                    <span class="small text-muted">{{ rtrim(rtrim($item->completed_quantity, '0'), '.') }}/{{ rtrim(rtrim($item->total_quantity, '0'), '.') }} {{ $item->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- ── Lightbox Modal ── -->
    <div class="modal fade" id="lightboxModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0 py-2 px-3">
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center pt-0 pb-4 px-4">
                    <img id="lightboxImg" src="" class="img-fluid rounded" style="max-height:75vh;" alt="Update image">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
        }
    </script>
@endsection
