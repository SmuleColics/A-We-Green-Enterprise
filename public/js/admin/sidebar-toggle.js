document.addEventListener('DOMContentLoaded', function () {
  const sidebarEl = document.getElementById('adminSidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  const closeBtn = document.getElementById('sidebarClose');
  const body = document.body;

  if (!sidebarEl || !toggleBtn) return;

  const isDesktop = window.matchMedia('(min-width: 576px)');

  // Mobile: a real Bootstrap Offcanvas (slide-in panel + backdrop + focus
  // trap, all handled by Bootstrap). Desktop keeps the separate .collapsed
  // toggle below — the two never run at the same time.
  const mobileOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebarEl);

  toggleBtn.addEventListener('click', function () {
    if (isDesktop.matches) {
      sidebarEl.classList.toggle('collapsed');
      body.classList.toggle('sb-collapsed');
    } else {
      mobileOffcanvas.toggle();
    }
  });

  // Clicking the X button inside the sidebar closes it (mobile only)
  if (closeBtn) {
    closeBtn.addEventListener('click', function () {
      mobileOffcanvas.hide();
    });
  }

  // Keep state clean when crossing the breakpoint
  isDesktop.addEventListener('change', function (e) {
    if (e.matches) {
      mobileOffcanvas.hide();
    } else {
      sidebarEl.classList.remove('collapsed');
      body.classList.remove('sb-collapsed');
    }
  });

  function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    const chevron = document.getElementById('profileChevron');
    const btn = document.getElementById('profileToggle');
    const isOpen = menu.style.display !== 'none';

    menu.style.display = isOpen ? 'none' : 'block';
    chevron.classList.toggle('open', !isOpen);
    btn.setAttribute('aria-expanded', !isOpen);
  }

  const profileToggleBtn = document.getElementById('profileToggle');
  if (profileToggleBtn) {
    profileToggleBtn.addEventListener('click', toggleProfileMenu);
  }

  // Auto-expand if on profile page
  const profileRoutes = ['{{ route("admin-profile") }}'];
  if (profileRoutes.some(r => window.location.pathname === new URL(r).pathname)) {
    toggleProfileMenu();
  }
});