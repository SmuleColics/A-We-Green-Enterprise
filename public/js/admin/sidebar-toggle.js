document.addEventListener('DOMContentLoaded', function () {
  const sidebarEl = document.getElementById('adminSidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  const closeBtn = document.getElementById('sidebarClose');
  const body = document.body;

  if (!sidebarEl || !toggleBtn) return;

  const isDesktop = window.matchMedia('(min-width: 576px)');

  // Create backdrop element once (used only on mobile)
  const backdrop = document.createElement('div');
  backdrop.className = 'sb-backdrop';
  document.body.appendChild(backdrop);

  function openMobile() {
    sidebarEl.classList.add('show');
    backdrop.classList.add('show');
  }

  function closeMobile() {
    sidebarEl.classList.remove('show');
    backdrop.classList.remove('show');
  }

  toggleBtn.addEventListener('click', function () {
    if (isDesktop.matches) {
      sidebarEl.classList.toggle('collapsed');
      body.classList.toggle('sb-collapsed');
    } else {
      if (sidebarEl.classList.contains('show')) {
        closeMobile();
      } else {
        openMobile();
      }
    }
  });

  // Clicking the backdrop closes the mobile sidebar
  backdrop.addEventListener('click', closeMobile);

  // Clicking the X button inside the sidebar closes it (mobile only)
  if (closeBtn) {
    closeBtn.addEventListener('click', closeMobile);
  }

  // Keep state clean when crossing the breakpoint
  isDesktop.addEventListener('change', function (e) {
    if (e.matches) {
      closeMobile();
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