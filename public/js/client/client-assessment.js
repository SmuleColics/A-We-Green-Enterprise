/* ─── State ─── */
const state = {
  clientType: '',
  estabType: '',
  estabSize: '',
  selectedDate: '',        // ISO yyyy-mm-dd, sent to the backend
  selectedDateDisplay: '', // human-readable, shown in the UI
  services: [],
  subtype: '',
  slot: ''
};
let currentStep = 1;

/* ─── Establishment options ─── */
const estabOptions = {
  Residential: [
    { icon: 'home', label: 'Home / Residence', size: 'small' },
    { icon: 'apartment', label: 'Apartment / Condominium', size: 'small' },
    { icon: 'villa', label: 'Townhouse', size: 'small' },
    { icon: 'bed', label: 'Boarding House / Dormitory', size: 'large' },
  ],
  Subdivision: [
    { icon: 'holiday_village', label: 'Subdivision / HOA', size: 'large' },
    { icon: 'location_city', label: 'Condominium Complex', size: 'large' },
  ],
  Commercial: [
    { icon: 'storefront', label: 'Office / Commercial Space', size: 'small' },
    { icon: 'warehouse', label: 'Warehouse / Industrial', size: 'large' },
    { icon: 'local_mall', label: 'Mall / Shopping Center', size: 'large' },
    { icon: 'restaurant', label: 'Restaurant / Café', size: 'small' },
    { icon: 'hotel', label: 'Hotel / Resort', size: 'large' },
    { icon: 'factory', label: 'Factory / Plant', size: 'large' },
    { icon: 'account_balance_wallet', label: 'Bank / Financial Institution', size: 'small' },
    { icon: 'local_gas_station', label: 'Gas Station', size: 'small' },
  ],
  Government: [
    { icon: 'account_balance', label: 'Barangay Hall', size: 'small' },
    { icon: 'school', label: 'School / University', size: 'large' },
    { icon: 'local_hospital', label: 'Hospital / Health Center', size: 'large' },
    { icon: 'sports_soccer', label: 'Sports Facility / Gym', size: 'large' },
    { icon: 'park', label: 'Park / Public Space', size: 'large' },
    { icon: 'directions_bus', label: 'Terminal / Transport Hub', size: 'large' },
    { icon: 'local_police', label: 'Police Station / Fire', size: 'small' },
    { icon: 'museum', label: 'Museum / Cultural Center', size: 'large' },
  ],
  Agricultural: [
    { icon: 'agriculture', label: 'Farm / Plantation', size: 'large' },
    { icon: 'pets', label: 'Poultry / Livestock Facility', size: 'large' },
    { icon: 'water', label: 'Fishpond / Aquaculture', size: 'large' },
  ],
  Institutional: [
    { icon: 'church', label: 'Church / Chapel', size: 'small' },
    { icon: 'volunteer_activism', label: 'NGO / Foundation Office', size: 'small' },
    { icon: 'handshake', label: 'Cooperative', size: 'small' },
  ],
};

/* ─── Cities per province ─── */
const cityData = {
  'Metro Manila': [
    'Caloocan', 'Las Piñas', 'Makati', 'Malabon', 'Mandaluyong', 'Manila',
    'Marikina', 'Muntinlupa', 'Navotas', 'Parañaque', 'Pasay', 'Pasig',
    'Pateros', 'Quezon City', 'San Juan', 'Taguig', 'Valenzuela'
  ],
  'Batangas': [
    'Agoncillo', 'Alitagtag', 'Balayan', 'Balete', 'Batangas City', 'Bauan',
    'Calaca', 'Calatagan', 'Cuenca', 'Ibaan', 'Laurel', 'Lemery', 'Lian',
    'Lipa City', 'Lobo', 'Mabini', 'Malvar', 'Mataas na Kahoy', 'Nasugbu',
    'Padre Garcia', 'Rosario', 'San Jose', 'San Juan', 'San Luis', 'San Nicolas',
    'San Pascual', 'Santa Teresita', 'Santo Tomas', 'Taal', 'Talisay',
    'Tanauan City', 'Taysan', 'Tingloy', 'Tuy'
  ],
  'Cavite': [
    'Alfonso', 'Amadeo', 'Bacoor', 'Carmona', 'Cavite City', 'Dasmariñas',
    'General Emilio Aguinaldo', 'General Mariano Alvarez', 'General Trias',
    'Imus', 'Indang', 'Kawit', 'Magallanes', 'Maragondon', 'Mendez',
    'Naic', 'Noveleta', 'Rosario', 'Silang', 'Tagaytay City', 'Tanza',
    'Ternate', 'Trece Martires City'
  ],
  'Laguna': [
    'Alaminos', 'Bay', 'Biñan City', 'Cabuyao City', 'Calamba City',
    'Calauan', 'Cavinti', 'Famy', 'Kalayaan', 'Liliw', 'Los Baños',
    'Luisiana', 'Lumban', 'Mabitac', 'Magdalena', 'Majayjay', 'Nagcarlan',
    'Paete', 'Pagsanjan', 'Pakil', 'Pangil', 'Pila', 'Rizal', 'San Pablo City',
    'San Pedro City', 'Santa Cruz', 'Santa Maria', 'Santa Rosa City',
    'Siniloan', 'Victoria'
  ],
  'Quezon': [
    'Agdangan', 'Alabat', 'Atimonan', 'Buenavista', 'Burdeos', 'Calauag',
    'Candelaria', 'Catanauan', 'Dolores', 'General Luna', 'General Nakar',
    'Guinayangan', 'Gumaca', 'Infanta', 'Jomalig', 'Lopez', 'Lucban',
    'Lucena City', 'Macalelon', 'Mauban', 'Mulanay', 'Padre Burgos',
    'Pagbilao', 'Panukulan', 'Patnanungan', 'Perez', 'Pitogo', 'Plaridel',
    'Polillo', 'Quezon', 'Real', 'Sampaloc', 'San Andres', 'San Antonio',
    'San Francisco', 'San Narciso', 'Sariaya', 'Tagkawayan', 'Tiaong', 'Unisan'
  ],
  'Rizal': [
    'Angono', 'Antipolo City', 'Baras', 'Binangonan', 'Cainta', 'Cardona',
    'Jala-Jala', 'Morong', 'Pililla', 'Rodriguez', 'San Mateo', 'Tanay',
    'Taytay', 'Teresa'
  ]
};

/*
 * ─── Client defaults (auto-fill) ───
 * Provided by the Blade view via window.clientDefaults before this file loads.
 * Falls back to empty strings so this file never breaks if missing.
 */
const clientDefaults = window.clientDefaults || {
  fname: '', lname: '', contact: '', email: '',
  block: '', lot: '', street: '', brgy: '', zip: '',
  province: '', city: ''
};

function updateCities(preselect) {
  const prov = document.getElementById('d-province').value;
  const sel = document.getElementById('d-city');
  if (!prov || !cityData[prov]) {
    sel.innerHTML = '<option value="">— Select Province First —</option>';
    return;
  }
  sel.innerHTML = '<option value="">— Select City / Municipality —</option>' +
    cityData[prov].map(c =>
      `<option value="${c}"${(preselect || '') === c ? ' selected' : ''}>${c}</option>`
    ).join('');
}

/* Pre-fill city dropdown + calendar on page load */
window.addEventListener('DOMContentLoaded', function () {
  updateCities(clientDefaults.city);
  initCalendar();
});

/* ─── Step 1: Client Type ─── */
function selectClientType(el, type) {
  document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  state.clientType = type;
  state.estabType = '';
  state.estabSize = '';
  const opts = estabOptions[type] || [];
  document.getElementById('estab-options').innerHTML = opts.map(o => `
        <div class="col-6 col-md-3">
          <div class="estab-card" onclick="selectEstab(this,'${o.label}','${o.size}')">
            <span class="material-symbols-outlined">${o.icon}</span>
            <span class="elabel">${o.label}</span>
          </div>
        </div>`).join('');
}

function selectEstab(el, label, size) {
  document.querySelectorAll('.estab-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  state.estabType = label;
  state.estabSize = size;
  updateSlotLogic();
}

/* ─────────────────────────────────────────────────────────
   Step 2: Dynamic, month-navigable calendar
   Backed by GET window.assessmentAvailabilityUrl?year=&month=
   which returns: { "2026-03-19": { morning: true, afternoon: false }, ... }
   ───────────────────────────────────────────────────────── */
const MONTH_NAMES = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
];

let calendarYear;
let calendarMonth; // 0-indexed (0 = January), matches JS Date

function initCalendar() {
  const today = new Date();
  calendarYear = today.getFullYear();
  calendarMonth = today.getMonth();
  renderCalendar();
}

function changeMonth(delta) {
  calendarMonth += delta;
  if (calendarMonth < 0) {
    calendarMonth = 11;
    calendarYear -= 1;
  } else if (calendarMonth > 11) {
    calendarMonth = 0;
    calendarYear += 1;
  }
  renderCalendar();
}

function renderCalendar() {
  const label = document.getElementById('calendar-month-label');
  if (label) label.textContent = `${MONTH_NAMES[calendarMonth]} ${calendarYear}`;

  const url = `${window.assessmentAvailabilityUrl}?year=${calendarYear}&month=${calendarMonth + 1}`;

  fetch(url, { headers: { 'Accept': 'application/json' } })
    .then(res => res.json())
    .then(data => buildCalendarGrid(data || {}))
    .catch(() => {
      showToast('Could not load availability for this month. Showing dates as open.', 'warning');
      buildCalendarGrid({});
    });
}

function toISODate(d) {
  return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
}

function toDisplayDate(d) {
  return `${MONTH_NAMES[d.getMonth()].slice(0, 3)} ${d.getDate()}, ${d.getFullYear()}`;
}

function buildCalendarGrid(availability) {
  const grid = document.getElementById('full-calendar-grid');
  if (!grid) return;

  const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  let html = dayHeaders.map(d => `<div class="calendar-header-cell">${d}</div>`).join('');

  const firstOfMonth = new Date(calendarYear, calendarMonth, 1);
  const startWeekday = firstOfMonth.getDay(); // 0 = Sunday
  const daysInMonth = new Date(calendarYear, calendarMonth + 1, 0).getDate();
  const todayISO = toISODate(new Date());

  /* Leading blanks before day 1 */
  for (let i = 0; i < startWeekday; i++) {
    html += `<div class="calendar-cell no-work"></div>`;
  }

  for (let day = 1; day <= daysInMonth; day++) {
    const dateObj = new Date(calendarYear, calendarMonth, day);
    const iso = toISODate(dateObj);
    const isSunday = dateObj.getDay() === 0;
    const isPast = iso < todayISO;
    const isToday = iso === todayISO;
    const slots = availability[iso];

    let classes = 'calendar-cell';
    let badges = '';
    let clickable = true;

    if (isSunday || isPast) {
      classes += ' no-work';
      clickable = false;
    } else if (slots && slots.morning && slots.afternoon) {
      classes += ' full no-click';
      clickable = false;
      badges = `<span class="calendar-slot-badge">AM — Booked</span><span class="calendar-slot-badge">PM — Booked</span>`;
    } else if (slots && (slots.morning || slots.afternoon)) {
      classes += ' partial';
      badges = slots.morning
        ? `<span class="calendar-slot-badge">AM — Booked</span>`
        : `<span class="calendar-slot-badge">PM — Booked</span>`;
    }

    if (isToday) classes += ' today';

    const dateStyle = isToday ? ' style="color:#fff;"' : '';
    const dateLabel = `<div class="calendar-date"${dateStyle}>${day}</div>`;

    if (clickable) {
      html += `<div class="${classes}" onclick="pickDate(this,'${toDisplayDate(dateObj)}','${iso}')">${dateLabel}${badges}</div>`;
    } else {
      html += `<div class="${classes}" onclick="fullAlert()">${dateLabel}${badges}</div>`;
    }
  }

  /* Trailing blanks to complete the last row */
  const totalCells = startWeekday + daysInMonth;
  const remainder = totalCells % 7;
  if (remainder !== 0) {
    for (let i = 0; i < 7 - remainder; i++) {
      html += `<div class="calendar-cell no-work"></div>`;
    }
  }

  grid.innerHTML = html;

  /* Re-highlight the previously selected date if it falls in this month */
  if (state.selectedDate) {
    const match = Array.from(grid.querySelectorAll('.calendar-cell')).find(cell => {
      return cell.getAttribute('onclick') && cell.getAttribute('onclick').includes(`'${state.selectedDate}'`);
    });
    if (match) match.classList.add('selected-day');
  }
}

function pickDate(el, displayDate, isoDate) {
  document.querySelectorAll('.calendar-cell.selected-day').forEach(c => c.classList.remove('selected-day'));
  el.classList.add('selected-day');
  state.selectedDate = isoDate;
  state.selectedDateDisplay = displayDate;
  document.getElementById('selected-date-label').textContent = 'Selected: ' + displayDate;
  setTimeout(() => goStep(3), 300);
}

function fullAlert() {
  showToast('This date is not available. Please choose another date.', 'danger');
}

/* ─── Step 3: Multi-select services ─── */
function toggleService(el, service) {
  el.classList.toggle('selected');
  if (el.classList.contains('selected')) {
    if (!state.services.includes(service)) state.services.push(service);
  } else {
    state.services = state.services.filter(s => s !== service);
  }
  const hasCCTV = state.services.includes('CCTV Setup');
  document.getElementById('cctv-subtype-section').style.display = hasCCTV ? 'block' : 'none';
  if (!hasCCTV) {
    state.subtype = '';
    document.querySelectorAll('.subtype-pill').forEach(p => p.classList.remove('selected'));
  }
  updateSlotLogic();
}

function selectSubtype(el, sub) {
  document.querySelectorAll('.subtype-pill').forEach(p => p.classList.remove('selected'));
  el.classList.add('selected');
  state.subtype = sub;
}

/* ─── Slot logic ─── */
function isFullDay() {
  return state.estabSize === 'large' || state.services.length > 1;
}

function updateSlotLogic() {
  const full = isFullDay();
  const banner = document.getElementById('slot-info-banner');
  const infoText = document.getElementById('slot-info-text');
  const morningCard = document.getElementById('slot-morning');
  const afternoonCard = document.getElementById('slot-afternoon');
  const fullDayWrap = document.getElementById('slot-fullday-wrap');

  if (full) {
    fullDayWrap.style.display = 'block';
    morningCard.closest('.col-md-6').style.display = 'none';
    afternoonCard.closest('.col-md-6').style.display = 'none';
    state.slot = 'Full Day';
    banner.style.display = 'flex';
    if (state.services.length > 1 && state.estabSize === 'large') {
      infoText.textContent =
        'Multiple services on a large establishment — a full day is required for this assessment.';
    } else if (state.services.length > 1) {
      infoText.textContent =
        'Multiple services selected — a full day is required to cover all assessments in one visit.';
    } else {
      infoText.textContent = 'This establishment type requires a full-day assessment visit.';
    }
  } else {
    fullDayWrap.style.display = 'none';
    morningCard.closest('.col-md-6').style.display = 'block';
    afternoonCard.closest('.col-md-6').style.display = 'block';
    if (state.slot === 'Full Day') state.slot = '';
    document.querySelectorAll('.slot-card').forEach(c => {
      if (c.id !== 'slot-fullday') c.classList.remove('selected');
    });
    banner.style.display = 'none';
  }
}

function selectSlot(el, slot) {
  if (isFullDay()) return;
  document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  state.slot = slot;
}

/* ─── Step navigation ─── */
function goStep(n) {
  if (n > currentStep && !validateStep(currentStep)) return;
  if (n > currentStep) {
    const sc = document.getElementById('sc' + currentStep);
    sc.classList.remove('active');
    sc.classList.add('done');
    sc.innerHTML = '✓';
    document.getElementById('sl' + currentStep).classList.remove('active');
    document.getElementById('sl' + currentStep).classList.add('done');
    if (currentStep < 5) document.getElementById('sline' + currentStep).classList.add('done');
  }
  if (n < currentStep) {
    for (let i = n; i <= currentStep; i++) {
      const sc = document.getElementById('sc' + i);
      sc.classList.remove('active', 'done');
      sc.innerHTML = i;
      document.getElementById('sl' + i).classList.remove('active', 'done');
      if (i < 5) document.getElementById('sline' + i).classList.remove('done');
    }
  }
  document.getElementById('sc' + n).classList.add('active');
  document.getElementById('sl' + n).classList.add('active');
  document.getElementById('pane' + currentStep).classList.remove('active');
  document.getElementById('pane' + n).classList.add('active');
  currentStep = n;
  if (n === 5) buildReview();
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

/* ─── Validation ─── */
function validateStep(s) {
  if (s === 1) {
    if (!state.clientType) {
      showToast('Please select a client type.', 'danger');
      return false;
    }
    if (!state.estabType) {
      showToast('Please select an establishment type.', 'danger');
      return false;
    }
  }
  if (s === 2) {
    if (!state.selectedDate) {
      showToast('Please select a date from the calendar.', 'danger');
      return false;
    }
  }
  if (s === 3) {
    if (state.services.length === 0) {
      showToast('Please select at least one service type.', 'danger');
      return false;
    }
    if (state.services.includes('CCTV Setup') && !state.subtype) {
      showToast('Please select a CCTV service type.', 'danger');
      return false;
    }
    if (!state.slot) {
      showToast('Please select a time slot.', 'danger');
      return false;
    }
  }
  if (s === 4) {
    if (!document.getElementById('d-fname').value.trim()) {
      showToast('Please enter your first name.', 'danger');
      return false;
    }
    if (!document.getElementById('d-lname').value.trim()) {
      showToast('Please enter your last name.', 'danger');
      return false;
    }
    if (!document.getElementById('d-contact').value.trim()) {
      showToast('Please enter your contact number.', 'danger');
      return false;
    }
    if (!document.getElementById('d-brgy').value.trim()) {
      showToast('Please enter the barangay.', 'danger');
      return false;
    }
    if (!document.getElementById('d-province').value) {
      showToast('Please select a province.', 'danger');
      return false;
    }
    if (!document.getElementById('d-city').value) {
      showToast('Please select a city/municipality.', 'danger');
      return false;
    }
  }
  return true;
}

/* ─── Build review ─── */
function buildReview() {
  const fname = document.getElementById('d-fname').value.trim();
  const lname = document.getElementById('d-lname').value.trim();
  const contact = document.getElementById('d-contact').value.trim();
  const email = document.getElementById('d-email').value.trim();
  const block = document.getElementById('d-block').value.trim();
  const lot = document.getElementById('d-lot').value.trim();
  const street = document.getElementById('d-street').value.trim();
  const brgy = document.getElementById('d-brgy').value.trim();
  const city = document.getElementById('d-city').value;
  const province = document.getElementById('d-province').value;
  const zip = document.getElementById('d-zip').value.trim();
  const notes = document.getElementById('d-notes').value.trim();

  document.getElementById('rv-clientType').textContent = state.clientType;
  document.getElementById('rv-estab').textContent = state.estabType;
  document.getElementById('rv-date').textContent = state.selectedDateDisplay || '—';
  document.getElementById('rv-slot').textContent = state.slot;
  document.getElementById('rv-service').textContent = state.services.join(', ') || '—';
  document.getElementById('rv-subtype').textContent = state.subtype || '—';
  document.getElementById('rv-subtype-row').style.display =
    state.services.includes('CCTV Setup') ? 'flex' : 'none';
  document.getElementById('rv-name').textContent = [fname, lname].filter(Boolean).join(' ') || '—';
  document.getElementById('rv-contact').textContent = contact;
  document.getElementById('rv-email').textContent = email || '—';
  const locParts = [];
  if (block) locParts.push('Blk ' + block);
  if (lot) locParts.push('Lot ' + lot);
  if (street) locParts.push(street);
  if (brgy) locParts.push(brgy);
  if (city) locParts.push(city);
  if (province) locParts.push(province);
  if (zip) locParts.push(zip);
  document.getElementById('rv-location').textContent = locParts.join(', ') || '—';
  document.getElementById('rv-notes').textContent = notes || '—';
}

/* ─── Submit (real AJAX to AssessmentController@store) ─── */
function submitRequest() {
  const payload = {
    client_type: state.clientType,
    establishment_type: state.estabType,
    establishment_size: state.estabSize,
    preferred_date: state.selectedDate,
    time_slot: state.slot,
    services: state.services,
    cctv_subtype: state.subtype || null,
    first_name: document.getElementById('d-fname').value.trim(),
    last_name: document.getElementById('d-lname').value.trim(),
    contact_number: document.getElementById('d-contact').value.trim(),
    email: document.getElementById('d-email').value.trim() || null,
    block: document.getElementById('d-block').value.trim() || null,
    lot: document.getElementById('d-lot').value.trim() || null,
    street: document.getElementById('d-street').value.trim() || null,
    barangay: document.getElementById('d-brgy').value.trim(),
    province: document.getElementById('d-province').value,
    city: document.getElementById('d-city').value,
    zip_code: document.getElementById('d-zip').value.trim() || null,
    notes: document.getElementById('d-notes').value.trim() || null,
  };

  fetch(window.assessmentStoreUrl, {
    method: 'POST',
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
        showToast(data.message || 'Something went wrong. Please try again.', 'danger');
        return;
      }
      new bootstrap.Modal(document.getElementById('successModal')).show();
    })
    .catch(() => showToast('Network error. Please try again.', 'danger'));
}

/* ─── Reset wizard ─── */
function resetWizard() {
  currentStep = 1;
  for (let i = 1; i <= 5; i++) {
    const sc = document.getElementById('sc' + i);
    sc.classList.remove('active', 'done');
    sc.innerHTML = i;
    document.getElementById('sl' + i).classList.remove('active', 'done');
    document.getElementById('pane' + i).classList.remove('active');
    if (i < 5) document.getElementById('sline' + i).classList.remove('done');
  }
  document.getElementById('sc1').classList.add('active');
  document.getElementById('sl1').classList.add('active');
  document.getElementById('pane1').classList.add('active');
  state.clientType = '';
  state.estabType = '';
  state.estabSize = '';
  state.selectedDate = '';
  state.selectedDateDisplay = '';
  state.services = [];
  state.subtype = '';
  state.slot = '';
  document.querySelectorAll('.type-card,.estab-card,.service-card,.slot-card').forEach(c => c.classList.remove(
    'selected'));
  document.querySelectorAll('.subtype-pill').forEach(p => p.classList.remove('selected'));
  document.querySelectorAll('.calendar-cell.selected-day').forEach(c => c.classList.remove('selected-day'));
  document.getElementById('selected-date-label').textContent = 'No date selected yet.';
  document.getElementById('cctv-subtype-section').style.display = 'none';
  document.getElementById('slot-info-banner').style.display = 'none';
  document.getElementById('slot-fullday-wrap').style.display = 'none';
  const mc = document.getElementById('slot-morning').closest('.col-md-6');
  const ac = document.getElementById('slot-afternoon').closest('.col-md-6');
  if (mc) mc.style.display = 'block';
  if (ac) ac.style.display = 'block';

  /* Reset Step 4 back to the client's saved defaults, not hardcoded sample data */
  document.getElementById('d-fname').value = clientDefaults.fname;
  document.getElementById('d-lname').value = clientDefaults.lname;
  document.getElementById('d-contact').value = clientDefaults.contact;
  document.getElementById('d-email').value = clientDefaults.email;
  document.getElementById('d-block').value = clientDefaults.block;
  document.getElementById('d-lot').value = clientDefaults.lot;
  document.getElementById('d-street').value = clientDefaults.street;
  document.getElementById('d-brgy').value = clientDefaults.brgy;
  document.getElementById('d-zip').value = clientDefaults.zip;
  document.getElementById('d-notes').value = '';
  document.getElementById('d-province').value = clientDefaults.province;
  updateCities(clientDefaults.city);

  /* Reset calendar to the current month */
  initCalendar();
}

/* ─── View request modal ─── */
function loadViewRequest(d) {
  document.getElementById('vr-ref').textContent = d.ref || '—';
  document.getElementById('vr-date').textContent = d.date || '—';
  document.getElementById('vr-slot').textContent = d.slot || '—';
  document.getElementById('vr-clientType').textContent = d.clientType || '—';
  document.getElementById('vr-estab').textContent = d.estab || '—';
  document.getElementById('vr-service').textContent = d.service || '—';
  document.getElementById('vr-subtype').textContent = d.subtype || '—';
  document.getElementById('vr-name').textContent = d.name || '—';
  document.getElementById('vr-contact').textContent = d.contact || '—';
  document.getElementById('vr-email').textContent = d.email || '—';
  document.getElementById('vr-brgy').textContent = d.brgy || '—';
  document.getElementById('vr-city').textContent = d.city || '—';
  document.getElementById('vr-province').textContent = d.province || '—';
  document.getElementById('vr-notes').textContent = d.notes || '—';
  document.getElementById('vr-status').innerHTML =
    `<span class="badge bg-${d.statusClass} rounded-pill">${d.status}</span>`;
  document.getElementById('vr-subtype-col').style.display =
    (d.service && d.service.includes('CCTV Setup')) ? 'block' : 'none';
}

/* ─── DataTable ─── */
$(document).ready(function () {
  $('#requestHistoryTable').DataTable({
    pageLength: 10,
    order: [
      [5, 'asc']
    ],
    columnDefs: [{
      orderable: false,
      targets: 6
    },
    {
      targets: 5,
      orderData: 5,
      render: function (data, type) {
        if (type === 'sort') {
          const txt = $(data).text().trim();
          if (txt === 'Confirmed') return '1';
          if (txt === 'Pending') return '2';
          if (txt === 'Declined') return '3';
          return '9';
        }
        return data;
      }
    }
    ]
  });
});

/* ─── Cancel Request Functions (real AJAX to AssessmentController@cancel) ─── */
let cancelRequestData = {};

function prepareCancel(ref, date) {
  cancelRequestData = {
    ref: ref,
    date: date
  };
  document.getElementById('cancel-reason-select').value = '';
  document.getElementById('cancel-reason-other').value = '';
  document.getElementById('other-reason-group').classList.remove('show');
}

function toggleOtherReason() {
  const select = document.getElementById('cancel-reason-select');
  const otherGroup = document.getElementById('other-reason-group');
  const otherInput = document.getElementById('cancel-reason-other');

  if (select.value === 'other') {
    otherGroup.classList.add('show');
    otherInput.focus();
  } else {
    otherGroup.classList.remove('show');
    otherInput.value = '';
  }
}

document.getElementById('confirm-cancel-btn')?.addEventListener('click', function () {
  const select = document.getElementById('cancel-reason-select');
  const otherInput = document.getElementById('cancel-reason-other');

  if (!select.value) {
    showToast('Please select a cancellation reason.', 'danger');
    select.focus();
    return;
  }

  let reason = select.options[select.selectedIndex].text;
  if (select.value === 'other') {
    if (!otherInput.value.trim()) {
      showToast('Please specify the reason for "Other".', 'danger');
      otherInput.focus();
      return;
    }
    reason = otherInput.value.trim();
  }

  fetch(`/assessment/${cancelRequestData.ref}/cancel`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Accept': 'application/json',
    },
    body: JSON.stringify({ reason }),
  })
    .then(res => res.json().then(data => ({ status: res.status, data })))
    .then(({ status, data }) => {
      if (status !== 200 || !data.success) {
        showToast(data.message || 'Unable to cancel this request.', 'danger');
        return;
      }

      const table = $('#requestHistoryTable').DataTable();
      const rowIdx = table.rows().indexes().filter(idx => {
        const row = table.row(idx).node();
        return row.querySelector('td:first-child').textContent.trim() === String(cancelRequestData.ref);
      })[0];

      if (rowIdx !== undefined) {
        const rowData = table.row(rowIdx).data();
        const newRow = [
          rowData[0],
          rowData[1],
          rowData[2],
          rowData[3],
          rowData[4],
          '<span class="badge bg-secondary rounded-pill">Cancelled</span>',
          rowData[6].replace(/data-bs-target="#cancelRequestModal"/g,
            'data-bs-target="#viewRequestModal"')
            .replace(/onclick="prepareCancel/g, 'onclick="loadViewRequest')
        ];
        table.row(rowIdx).data(newRow).draw();
      }

      showToast(data.message, 'success');
      bootstrap.Modal.getInstance(document.getElementById('cancelRequestModal')).hide();
    })
    .catch(() => showToast('Network error. Please try again.', 'danger'));
});