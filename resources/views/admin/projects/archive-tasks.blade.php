@extends('layouts.admin')

@section('title', 'Archived Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/projects/monitoring.css') }}">
@endsection

@section('page-title', 'Archived Tasks')

@section('topbar-actions')
    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Project
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Archived tasks for <strong>{{ $project->project_title }}</strong> ({{ $project->reference_number }}).
                </p>

                <div class="table-responsive">
                    <table id="archiveProjectTasksTable" class="table table-hover mb-0 small w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 small green-text">Task</th>
                                <th class="border-0 small green-text">Assigned To</th>
                                <th class="border-0 small green-text">Required Role</th>
                                <th class="border-0 small green-text">Due Date</th>
                                <th class="border-0 small green-text">Status</th>
                                <th class="border-0 small green-text">Archived On</th>
                                <th class="border-0 small green-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="fw-semibold">{{ $task->title }}</td>
                                    <td>{{ $task->employee ? $task->employee->full_name : 'Unassigned' }}</td>
                                    <td class="text-capitalize">{{ str_replace('_', '/', $task->required_position) }}</td>
                                    <td class="text-muted">{{ $task->due_date->format('M j, Y') }}</td>
                                    <td>
                                        <span class="badge rounded-pill
                                            @if ($task->status === 'Completed') bg-success
                                            @elseif ($task->status === 'On Hold') bg-warning text-dark
                                            @elseif ($task->status === 'In Progress') bg-primary
                                            @else bg-secondary
                                            @endif">{{ $task->status }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $task->archived_at?->format('M j, Y') ?? '—' }}</td>
                                    <td class="text-nowrap actions-col">
                                        <button class="btn btn-sm btn-outline-primary action-btn" title="Restore"
                                            onclick="restoreTaskConfirm({{ $task->id }}, {{ Js::from($task->title) }})">
                                            <span class="material-symbols-outlined icon-action">unarchive</span>
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


    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this task?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">"<span id="restoreTaskTitle"></span>" will be moved back to this
                        project's active task list.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        onclick="confirmRestoreTask()">
                        <span class="material-symbols-outlined fs-15">unarchive</span>
                        Restore
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let currentRestoreTaskId = null;

        function restoreTaskConfirm(id, title) {
            currentRestoreTaskId = id;
            document.getElementById('restoreTaskTitle').textContent = title;
            new bootstrap.Modal(document.getElementById('restoreConfirmModal')).show();
        }

        function confirmRestoreTask() {
            if (!currentRestoreTaskId) return;
            fetch(`/project-tasks/${currentRestoreTaskId}/unarchive`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(res => res.json())
                .then(data => {
                    bootstrap.Modal.getInstance(document.getElementById('restoreConfirmModal')).hide();
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 800);
                })
                .catch(() => showToast('Network error. Please try again.', 'danger'));
        }

        $(document).ready(function() {
            $('#archiveProjectTasksTable').DataTable({
                pageLength: 10,
                order: [[5, 'desc']],
                columnDefs: [{ orderable: false, targets: 6 }],
                language: {
                    emptyTable: 'No archived tasks yet.',
                    zeroRecords: 'No matching archived tasks found.'
                }
            });
        });
    </script>
@endsection
