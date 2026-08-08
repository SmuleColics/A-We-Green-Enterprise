function showToast(message, type = 'danger') {
    const config = {
        success: { bg: 'bg-success', text: 'text-white', icon: 'check_circle', delay: 4000, closeClass: 'btn-close-white' },
        danger:  { bg: 'bg-danger',  text: 'text-white', icon: 'error',        delay: 5000, closeClass: 'btn-close-white' },
        warning: { bg: 'bg-warning', text: 'text-dark',  icon: 'warning',      delay: 5000, closeClass: '' },
        info:    { bg: 'bg-primary', text: 'text-white', icon: 'info',         delay: 4000, closeClass: 'btn-close-white' },
    }[type] || {};

    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }

    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center ${config.text} ${config.bg} border-0`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.setAttribute('data-bs-autohide', 'true');
    toastEl.setAttribute('data-bs-delay', config.delay);
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:18px;">${config.icon}</span>
                ${message}
            </div>
            <button type="button" class="btn-close ${config.closeClass} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>`;

    container.appendChild(toastEl);
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}