document.addEventListener('DOMContentLoaded', function () {
  const switches = document.querySelectorAll('.js-notif-pref');

  switches.forEach(function (input) {
    input.addEventListener('change', function () {
      const previousStates = new Map();
      switches.forEach(sw => previousStates.set(sw, sw.checked));

      const payload = {};
      switches.forEach(sw => { payload[sw.dataset.pref] = sw.checked; });

      fetch(window.notificationPreferencesUrl, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: JSON.stringify(payload),
      })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
          if (status !== 200 || !data.success) {
            switches.forEach(sw => { sw.checked = previousStates.get(sw); });
            showToast(data.message || 'Could not update preferences. Please try again.', 'danger');
            return;
          }
          showToast(data.message, 'success');
        })
        .catch(() => {
          switches.forEach(sw => { sw.checked = previousStates.get(sw); });
          showToast('Network error. Please try again.', 'danger');
        });
    });
  });
});
