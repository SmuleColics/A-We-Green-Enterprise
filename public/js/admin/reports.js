const GREEN = '#16A249';      
const GREEN_FILL = 'rgba(22,162,73,.09)';
const AMBER = '#f59e0b';
const RED = '#ef4444';
const GRAY = '#9ca3af';

function baseBarOpts(step) {
  return {
    responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
    scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: '#f0f0f0' }, border: { display: false }, ticks: { stepSize: step } } }
  };
}

function groupedOpts(step) {
  return {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: true, position: 'top', align: 'end', labels: { boxWidth: 10, boxHeight: 10, borderRadius: 5, useBorderRadius: true, padding: 14 } } },
    scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: '#f0f0f0' }, border: { display: false }, ticks: { stepSize: step } } }
  };
}

function lineOpts(step) {
  return {
    responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
    scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { color: '#f0f0f0' }, border: { display: false }, ticks: { stepSize: step } } }
  };
}

function doughnutOpts() {
  return {
    responsive: true, maintainAspectRatio: false, cutout: '62%',
    plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } } }
  };
}

function buildLegend(id, items) {
  const el = document.getElementById(id);
  if (!el) return;
  el.innerHTML = items.map(d =>
    `<div class="d-flex align-items-center gap-1 small text-muted">
                    <span style="width:10px;height:10px;border-radius:50%;background:${d.color};display:inline-block;"></span>${d.label}
                </div>`).join('');
}

function initWeekly() {
  new Chart(document.getElementById('weeklyAssessmentsBar'), {
    type: 'bar',
    data: { labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], datasets: [{ data: [3, 5, 2, 4], backgroundColor: GREEN, borderRadius: 6, borderSkipped: false }] },
    options: baseBarOpts(1)
  });

  const wD = [{ label: 'Approved', value: 5, color: GREEN }, { label: 'For Review', value: 2, color: AMBER }, { label: 'Draft', value: 1, color: GRAY }, { label: 'Rejected', value: 1, color: RED }];
  new Chart(document.getElementById('weeklyQuotationDoughnut'), {
    type: 'doughnut',
    data: { labels: wD.map(d => d.label), datasets: [{ data: wD.map(d => d.value), backgroundColor: wD.map(d => d.color), borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }] },
    options: doughnutOpts()
  });
  buildLegend('weeklyDoughnutLegend', wD);

  new Chart(document.getElementById('weeklyClientLine'), {
    type: 'line',
    data: { labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], datasets: [{ data: [18, 20, 20, 23, 25, 26, 28], borderColor: GREEN, backgroundColor: GREEN_FILL, borderWidth: 2.5, pointBackgroundColor: GREEN, pointRadius: 4, pointHoverRadius: 6, fill: true, tension: 0.4 }] },
    options: lineOpts(5)
  });

  new Chart(document.getElementById('weeklyAcceptRejectBar'), {
    type: 'bar',
    data: { labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], datasets: [{ label: 'Accepted', data: [2, 3, 1, 2], backgroundColor: GREEN, borderRadius: 5, borderSkipped: false }, { label: 'Rejected', data: [1, 1, 0, 1], backgroundColor: RED, borderRadius: 5, borderSkipped: false }] },
    options: groupedOpts(1)
  });
}

let monthlyDone = false;

function initMonthly() {
  if (monthlyDone) return;
  monthlyDone = true;
  const mo = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  new Chart(document.getElementById('monthlyAssessmentsBar'), {
    type: 'bar',
    data: { labels: mo, datasets: [{ data: [8, 10, 14, 12, 9, 11, 13, 15, 10, 12, 14, 16], backgroundColor: GREEN, borderRadius: 6, borderSkipped: false }] },
    options: baseBarOpts(2)
  });

  const mD = [{ label: 'Approved', value: 20, color: GREEN }, { label: 'For Review', value: 8, color: AMBER }, { label: 'Draft', value: 5, color: GRAY }, { label: 'Rejected', value: 5, color: RED }];
  new Chart(document.getElementById('monthlyQuotationDoughnut'), {
    type: 'doughnut',
    data: { labels: mD.map(d => d.label), datasets: [{ data: mD.map(d => d.value), backgroundColor: mD.map(d => d.color), borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }] },
    options: doughnutOpts()
  });
  buildLegend('monthlyDoughnutLegend', mD);

  new Chart(document.getElementById('monthlyClientLine'), {
    type: 'line',
    data: { labels: mo, datasets: [{ data: [12, 15, 18, 22, 25, 28, 32, 35, 38, 42, 46, 52], borderColor: GREEN, backgroundColor: GREEN_FILL, borderWidth: 2.5, pointBackgroundColor: GREEN, pointRadius: 4, pointHoverRadius: 6, fill: true, tension: 0.4 }] },
    options: lineOpts(10)
  });

  new Chart(document.getElementById('monthlyAcceptRejectBar'), {
    type: 'bar',
    data: { labels: mo, datasets: [{ label: 'Accepted', data: [6, 7, 9, 8, 7, 9, 10, 11, 8, 9, 10, 12], backgroundColor: GREEN, borderRadius: 5, borderSkipped: false }, { label: 'Rejected', data: [2, 3, 1, 2, 2, 1, 2, 1, 2, 1, 2, 1], backgroundColor: RED, borderRadius: 5, borderSkipped: false }] },
    options: groupedOpts(2)
  });
}

document.addEventListener('DOMContentLoaded', function () {
  initWeekly();
  document.getElementById('monthly-tab').addEventListener('shown.bs.tab', initMonthly);
});

const MOCK_DATA = {
  checklist: [
    { checklist: 'Santos Residence CCTV', client: 'Maria Santos', service: 'CCTV Setup', date: 'Mar 10, 2026', total: 9, completed: 8, status: 'In Progress', pct: 89 },
    { checklist: 'Reyes Solar Installation', client: 'John Reyes', service: 'Solar Setup', date: 'Mar 11, 2026', total: 15, completed: 8, status: 'In Progress', pct: 53 },
    { checklist: 'Garcia Street Lights', client: 'Anna Garcia', service: 'Solar Street Light', date: 'Mar 12, 2026', total: 15, completed: 2, status: 'On Hold', pct: 13 },
    { checklist: 'Cruz PA System', client: 'Pedro Cruz', service: 'Public Address System', date: 'Mar 13, 2026', total: 6, completed: 6, status: 'Completed', pct: 100 },
  ],
  tasks: [
    { task: 'Install DVR and HDD', project: 'CCTV Installation – Makati Branch', assignee: 'Carlo Mendoza', priority: 'High', start: 'Apr 18, 2026', due: 'Apr 22, 2026', status: 'To Do' },
    { task: 'Test Alarm Panel', project: 'Fire Alarm System – Pasig', assignee: 'Carlo Mendoza', priority: 'Medium', start: 'Apr 25, 2026', due: 'Apr 30, 2026', status: 'To Do' },
    { task: 'Run CAT6 Cabling', project: 'Network Setup – BGC Office', assignee: 'Jomar Tan', priority: 'Medium', start: 'Apr 15, 2026', due: 'Apr 28, 2026', status: 'In Progress' },
    { task: 'Configure NVR Settings', project: 'CCTV Installation – Makati Branch', assignee: 'Marco Rivera', priority: 'Low', start: 'Apr 21, 2026', due: 'Apr 30, 2026', status: 'In Progress' },
    { task: 'Install Smoke Detectors', project: 'Fire Alarm System – Pasig', assignee: 'Ana', priority: 'High', start: 'Mar 5, 2026', due: 'Mar 8, 2026', status: 'Done' },
    { task: 'Site Survey & Documentation', project: 'Network Setup – BGC Office', assignee: 'Marco Rivera', priority: 'Low', start: 'Mar 15, 2026', due: 'Mar 18, 2026', status: 'Done' },
    { task: 'Access Card Programming', project: 'Access Control – Alabang', assignee: 'Jomar Tan', priority: 'High', start: 'Apr 10, 2026', due: 'Apr 12, 2026', status: 'On Hold' },
  ]
};

const REPORT_CONFIG = {
  checklist: {
    subject: 'CHECKLIST COMPLETION REPORT',
    summaryFn: data => [
      { label: 'Total Checklists', value: data.length, color: '#16A249' },
      { label: 'Completed', value: data.filter(d => d.status === 'Completed').length, color: '#0d6efd' },
      { label: 'In Progress', value: data.filter(d => d.status === 'In Progress').length, color: '#f59e0b' },
      { label: 'On Hold', value: data.filter(d => d.status === 'On Hold').length, color: '#6c757d' },
    ],
    tableFn: data => `<table class="rpt-table"><thead><tr>
                    <th>Checklist</th><th>Client</th><th>Service</th><th>Date</th><th>Items</th><th>Completed</th><th>Progress</th><th>Status</th>
                    </tr></thead><tbody>${data.map(r => `<tr>
                    <td class="fw-semibold">${r.checklist}</td><td>${r.client}</td><td>${r.service}</td><td>${r.date}</td>
                    <td style="text-align:center;">${r.total}</td><td style="text-align:center;">${r.completed}</td>
                    <td><div style="background:#e9ecef;border-radius:4px;height:6px;min-width:80px;"><div style="background:#16A249;height:6px;border-radius:4px;width:${r.pct}%;"></div></div><small style="color:#6b7280;">${r.pct}%</small></td>
                    <td><span class="rpt-badge rpt-badge-${r.status.toLowerCase().replace(/ /g, '-')}">${r.status}</span></td>
                    </tr>`).join('')}</tbody></table>`,
    notesFn: () => ``
  },
  tasks: {
    subject: 'TASK COMPLETION REPORT',
    summaryFn: data => [
      { label: 'Total Tasks', value: data.length, color: '#16A249' },
      { label: 'Done', value: data.filter(d => d.status === 'Done').length, color: '#198754' },
      { label: 'In Progress', value: data.filter(d => d.status === 'In Progress').length, color: '#0d6efd' },
      { label: 'On Hold / Pending', value: data.filter(d => d.status === 'On Hold' || d.status === 'To Do').length, color: '#f59e0b' },
    ],
    tableFn: data => `<table class="rpt-table"><thead><tr>
                    <th>Task</th><th>Project</th><th>Assigned To</th><th>Priority</th><th>Start</th><th>Due</th><th>Status</th>
                    </tr></thead><tbody>${data.map(r => `<tr>
                    <td class="fw-semibold">${r.task}</td><td>${r.project}</td><td>${r.assignee}</td>
                    <td><span class="rpt-badge rpt-badge-priority-${r.priority.toLowerCase()}">${r.priority}</span></td>
                    <td>${r.start}</td><td>${r.due}</td>
                    <td><span class="rpt-badge rpt-badge-${r.status.toLowerCase().replace(/ /g, '-')}">${r.status}</span></td>
                    </tr>`).join('')}</tbody></table>`,
    notesFn: () => ``
  }
};

function fmtDisplay(ymd) {
  if (!ymd) return '—';
  return new Date(ymd + 'T00:00:00').toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' });
}

function setPreset(type, btn) {
  const now = new Date();
  let from, to;
  const ymd = d => d.toISOString().split('T')[0];

  if (type === 'this_week') {
    const day = now.getDay(), mon = new Date(now);
    mon.setDate(now.getDate() - (day === 0 ? 6 : day - 1));
    const sun = new Date(mon); sun.setDate(mon.getDate() + 6);
    from = ymd(mon); to = ymd(sun);
  } else if (type === 'last_week') {
    const day = now.getDay(), mon = new Date(now);
    mon.setDate(now.getDate() - (day === 0 ? 6 : day - 1) - 7);
    const sun = new Date(mon); sun.setDate(mon.getDate() + 6);
    from = ymd(mon); to = ymd(sun);
  } else if (type === 'this_month') {
    from = ymd(new Date(now.getFullYear(), now.getMonth(), 1));
    to = ymd(new Date(now.getFullYear(), now.getMonth() + 1, 0));
  } else if (type === 'last_month') {
    from = ymd(new Date(now.getFullYear(), now.getMonth() - 1, 1));
    to = ymd(new Date(now.getFullYear(), now.getMonth(), 0));
  } else if (type === 'this_year') {
    from = `${now.getFullYear()}-01-01`;
    to = `${now.getFullYear()}-12-31`;
  }

  document.getElementById('reportDateFrom').value = from;
  document.getElementById('reportDateTo').value = to;
  document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function generateReport() {
  const type = document.getElementById('reportTypeSelect').value;
  const from = document.getElementById('reportDateFrom').value;
  const to = document.getElementById('reportDateTo').value;

  if (!type) { alert('Please select a report type.'); return; }
  if (!from || !to) { alert('Please select both a start and end date.'); return; }
  if (from > to) { alert('Start date must be before end date.'); return; }

  const cfg = REPORT_CONFIG[type];
  const data = MOCK_DATA[type];
  const today = new Date().toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' });

  document.getElementById('rpt-date-label').textContent = today;
  document.getElementById('rpt-period-label').textContent = `${fmtDisplay(from)} – ${fmtDisplay(to)}`;
  document.getElementById('rpt-subject-text').textContent = cfg.subject;

  document.getElementById('rpt-summary-row').innerHTML = cfg.summaryFn(data).map(s =>
    `<div class="rpt-summary-box">
                    <div class="rpt-summary-value" style="color:${s.color};">${s.value}</div>
                    <div class="rpt-summary-label">${s.label}</div>
                </div>`).join('');

  document.getElementById('rpt-table-wrap').innerHTML = cfg.tableFn(data);
  document.getElementById('rpt-terms-section').innerHTML = cfg.notesFn();

  document.getElementById('reportPlaceholder').style.display = 'none';
  document.getElementById('reportOutput').style.display = 'block';
  document.getElementById('printReportBtn').style.removeProperty('display');
  document.getElementById('exportReportBtn').style.removeProperty('display');
}

function printReport() {
  const content = document.getElementById('printableReport').innerHTML;
  const win = window.open('', '_blank');
  win.document.write(`<!DOCTYPE html><html><head>
                <meta charset="UTF-8"><title>A We Green Enterprise — Report</title>
                <style>
                    *{box-sizing:border-box;margin:0;padding:0}
                    body{font-family:Arial,sans-serif;font-size:12px;color:#111;background:#fff;padding:32px 40px}
                    .rpt-company-name{font-size:16px;font-weight:900;color:#16A249;letter-spacing:.05em;text-transform:uppercase;margin-bottom:4px}
                    .rpt-company-address,.rpt-company-contact{font-size:10px;color:#444;line-height:1.5;margin-bottom:0}
                    .rpt-divider{border:none;border-top:2px solid #16A249;margin:10px 0 14px}
                    .d-flex{display:flex}.justify-content-between{justify-content:space-between}.align-items-start{align-items:flex-start}.flex-grow-1{flex:1}
                    .rpt-meta-row{display:flex;gap:24px;font-size:11px;margin-bottom:10px;flex-wrap:wrap}
                    .rpt-meta-label{color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-right:4px}
                    .rpt-meta-value{color:#111;font-weight:600}
                    .rpt-subject-line{font-size:12px;font-weight:700;text-transform:uppercase;color:#111;margin-bottom:12px;border-bottom:1px solid #e5e7eb;padding-bottom:6px}
                    .rpt-summary-row{display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap}
                    .rpt-summary-box{border:1px solid #e5e7eb;border-radius:8px;padding:10px 16px;flex:1;min-width:100px}
                    .rpt-summary-value{font-size:20px;font-weight:700;margin-bottom:2px}
                    .rpt-summary-label{font-size:10px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.04em}
                    table.rpt-table{width:100%;border-collapse:collapse;font-size:11px;margin-top:8px}
                    table.rpt-table thead th{background:#16A249;color:#fff;padding:7px 10px;font-weight:600;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.04em}
                    table.rpt-table tbody td{padding:7px 10px;border-bottom:1px solid #f0f0f0;vertical-align:middle}
                    table.rpt-table tbody tr:nth-child(even) td{background:#f9fdf9}
                    .rpt-badge{display:inline-block;font-size:9px;font-weight:700;padding:2px 7px;border-radius:20px;text-transform:uppercase;letter-spacing:.04em}
                    .rpt-badge-completed,.rpt-badge-confirmed,.rpt-badge-approved,.rpt-badge-done{background:#d1fae5;color:#065f46}
                    .rpt-badge-in-progress,.rpt-badge-sent{background:#dbeafe;color:#1e40af}
                    .rpt-badge-on-hold,.rpt-badge-pending,.rpt-badge-for-review,.rpt-badge-to-do{background:#fef3c7;color:#92400e}
                    .rpt-badge-cancelled,.rpt-badge-rejected{background:#fee2e2;color:#991b1b}
                    .rpt-badge-priority-high{background:#fee2e2;color:#991b1b}
                    .rpt-badge-priority-medium{background:#fef3c7;color:#92400e}
                    .rpt-badge-priority-low{background:#d1fae5;color:#065f46}
                    .fw-semibold{font-weight:600}
                </style></head><body>${content}</body></html>`);
  win.document.close();
  win.focus();
  setTimeout(() => { win.print(); }, 600);
}
