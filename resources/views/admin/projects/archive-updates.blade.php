@extends('layouts.admin')

@section('title', 'Archived Updates')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/projects/monitoring.css') }}">
@endsection

@section('page-title', 'Archived Updates')

@section('topbar-actions')
    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1">
        <span class="material-symbols-outlined fs-17">arrow_back</span>
        Back to Project
    </a>
@endsection

@section('content')

    <div class="container-fluid px-4 py-4">

        <div class="detail-card">
            <p class="text-muted small mb-4">
                Archived updates for <strong>{{ $project->project_title }}</strong> ({{ $project->reference_number }}).
            </p>

            @if ($updates->isEmpty())
                <p class="text-muted small fst-italic mb-0">No archived updates for this project.</p>
            @else
                <div class="timeline">
                    @foreach ($updates as $update)
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
                                    <span class="text-muted small">·</span>
                                    <span class="text-muted small">Archived {{ $update->archived_at?->format('M j, Y') }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-auto d-flex align-items-center gap-1"
                                        onclick="restoreUpdateConfirm({{ $update->id }})">
                                        <span class="material-symbols-outlined fs-15">unarchive</span>
                                        Restore
                                    </button>
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


    <!-- ── Restore Confirm Modal ── -->
    <div class="modal fade" id="restoreConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Restore this update?</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="small text-muted mb-0">It will be moved back to this project's active updates timeline.</p>
                </div>
                <div class="modal-footer border-0 pt-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        onclick="confirmRestoreUpdate()">
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
        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
        }

        let currentRestoreUpdateId = null;

        function restoreUpdateConfirm(id) {
            currentRestoreUpdateId = id;
            new bootstrap.Modal(document.getElementById('restoreConfirmModal')).show();
        }

        function confirmRestoreUpdate() {
            if (!currentRestoreUpdateId) return;
            fetch(`/project-updates/${currentRestoreUpdateId}/unarchive`, {
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
    </script>
@endsection
