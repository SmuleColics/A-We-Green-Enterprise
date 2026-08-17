document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('mobileNavToggle');
  const drawer = document.getElementById('mobileDrawer');

  if (!toggleBtn || !drawer) {
    console.warn('Topnav: toggle button or drawer not found in DOM');
    return;
  }

  toggleBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    const isOpen = drawer.classList.toggle('open');
    toggleBtn.setAttribute('aria-expanded', isOpen);
  });

  // Close drawer when a nav link inside it is clicked
  drawer.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      drawer.classList.remove('open');
      toggleBtn.setAttribute('aria-expanded', 'false');
    });
  });

  // Close drawer if clicking outside it
  document.addEventListener('click', function (e) {
    if (!drawer.contains(e.target) && !toggleBtn.contains(e.target)) {
      drawer.classList.remove('open');
      toggleBtn.setAttribute('aria-expanded', 'false');
    }
  });

  document.querySelectorAll('.js-mark-all-read').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      fetch(this.dataset.url, {
        method: 'PATCH',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
      }).then(() => location.reload());
    });
  });

  document.querySelectorAll('.js-notif-item').forEach(item => {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      const markReadUrl = this.dataset.markReadUrl;

      fetch(markReadUrl, {
        method: 'PATCH',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
      }).finally(() => {
        window.location.href = href;
      });
    });
  });
});