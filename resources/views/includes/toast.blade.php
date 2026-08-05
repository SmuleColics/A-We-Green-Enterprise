@if(session('success') || session('error') || session('warning') || session('info'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999;">

    @if(session('success'))
    <div class="toast align-items-center text-white bg-success border-0 show"
        role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast align-items-center text-white bg-danger border-0 show"
        role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true" data-bs-delay="5000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:18px;">error</span>
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="toast align-items-center text-dark bg-warning border-0 show"
        role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true" data-bs-delay="5000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:18px;">warning</span>
                {{ session('warning') }}
            </div>
            <button type="button" class="btn-close me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="toast align-items-center text-white bg-primary border-0 show"
        role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:18px;">info</span>
                {{ session('info') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toast').forEach(function (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    });
</script>
@endif