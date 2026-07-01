<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Rental DB - Admin Panel</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
html,body{height:100%;overflow:hidden;}
body{font-family:'Inter',sans-serif;background:#f5f6f8;color:#1e293b;display:flex;}

/* Scrollbar */
::-webkit-scrollbar{width:8px;height:8px;}
::-webkit-scrollbar-track{background:#f0f1f3;}
::-webkit-scrollbar-thumb{background:#c4c9d4;border-radius:4px;}
::-webkit-scrollbar-thumb:hover{background:#a0a7b5;}

/* Sidebar */
.sidebar{width:240px;min-width:240px;background:#ffffff;height:100vh;display:flex;flex-direction:column;border-right:1px solid #e2e5ea;position:fixed;left:0;top:0;z-index:100;}
.sidebar-logo{padding:24px 20px 20px;border-bottom:1px solid #e2e5ea;}
.sidebar-logo h1{font-size:1.1rem;font-weight:700;color:#1e293b;}
.sidebar-logo p{font-size:0.68rem;color:#64748b;margin-top:4px;text-transform:uppercase;letter-spacing:1.5px;}
.sidebar-nav{flex:1;padding:16px 0;overflow-y:auto;}
.nav-label{font-size:0.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:1.5px;padding:8px 20px 8px;margin-top:4px;}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;cursor:pointer;color:#64748b;font-size:0.85rem;font-weight:500;transition:all 0.15s ease;border-left:3px solid transparent;user-select:none;}
.nav-item:hover{background:#f0f2f5;color:#1e293b;}
.nav-item.active{color:#1e293b;background:#eef2ff;border-left-color:#4f46e5;font-weight:600;}
.nav-separator{height:1px;background:#e2e5ea;margin:12px 20px;}
.sidebar-footer{padding:16px 20px;border-top:1px solid #e2e5ea;}
.sidebar-footer a{color:#4f46e5;font-size:0.8rem;text-decoration:none;font-weight:500;transition:color 0.15s;}
.sidebar-footer a:hover{color:#3730a3;}

/* Main content */
.main{margin-left:240px;flex:1;display:flex;flex-direction:column;height:100vh;overflow:hidden;}
.topbar{background:#ffffff;border-bottom:1px solid #e2e5ea;padding:16px 32px;display:flex;align-items:center;min-height:56px;}
.topbar-breadcrumb{font-size:0.75rem;color:#94a3b8;}
.topbar-breadcrumb span{color:#4f46e5;}
.topbar-title{font-size:1.05rem;font-weight:600;color:#1e293b;margin-left:0;}
.content-area{flex:1;overflow-y:auto;padding:28px 32px;}

/* Fade in */
.content-section{animation:fadeIn 0.2s ease;}
@keyframes fadeIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}

/* Stat cards */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;}
.stat-card{background:#ffffff;border:1px solid #e2e5ea;border-radius:10px;padding:22px 20px;transition:transform 0.2s ease;cursor:default;}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.06);}
.stat-card.blue{border-top:3px solid #4f46e5;}
.stat-card.green{border-top:3px solid #16a34a;}
.stat-card.purple{border-top:3px solid #7c3aed;}
.stat-card.yellow{border-top:3px solid #d97706;}
.stat-card .stat-label-top{font-size:0.72rem;color:#64748b;margin-bottom:8px;font-weight:500;text-transform:uppercase;letter-spacing:0.5px;}
.stat-card .stat-value{font-family:'JetBrains Mono',monospace;font-size:2rem;font-weight:700;color:#1e293b;line-height:1;}
.stat-card .stat-label{font-size:0.78rem;color:#94a3b8;margin-top:6px;font-weight:500;}

/* Table wrapper */
.table-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:12px;}
.table-title{display:flex;align-items:center;gap:10px;}
.table-title h2{font-size:1.1rem;font-weight:600;color:#1e293b;}
.table-title .badge{background:#e2e5ea;color:#64748b;font-family:'JetBrains Mono',monospace;font-size:0.7rem;padding:3px 10px;border-radius:20px;font-weight:500;}
.btn{padding:8px 18px;border:none;border-radius:8px;font-family:'Inter',sans-serif;font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.15s ease;display:inline-flex;align-items:center;gap:6px;}
.btn:hover{filter:brightness(0.92);}
.btn-primary{background:#4f46e5;color:#fff;}
.btn-success{background:#16a34a;color:#fff;}
.btn-danger{background:#dc2626;color:#fff;}
.btn-ghost{background:transparent;border:1px solid #d1d5db;color:#64748b;}
.btn-ghost:hover{border-color:#94a3b8;color:#1e293b;}
.btn-sm{padding:5px 10px;font-size:0.75rem;border-radius:6px;}

/* Data table */
.table-wrap{background:#ffffff;border:1px solid #e2e5ea;border-radius:10px;overflow:hidden;}
.data-table{width:100%;border-collapse:collapse;}
.data-table thead th{background:#f8f9fb;color:#64748b;font-size:0.68rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;padding:12px 14px;text-align:left;border-bottom:1px solid #e2e5ea;position:sticky;top:0;z-index:2;}
.data-table tbody td{font-family:'JetBrains Mono',monospace;font-size:0.82rem;padding:11px 14px;border-bottom:1px solid #f0f1f3;color:#1e293b;white-space:nowrap;max-width:220px;overflow:hidden;text-overflow:ellipsis;}
.data-table tbody tr{transition:background 0.15s ease;}
.data-table tbody tr:nth-child(even){background:#fafbfc;}
.data-table tbody tr:nth-child(odd){background:#ffffff;}
.data-table tbody tr:hover{background:#f0f2f5;}
.data-table .cell-id{color:#94a3b8;}
.data-table .cell-actions{display:flex;gap:6px;}
.data-table .cell-actions button{background:transparent;border:1px solid #e2e5ea;color:#94a3b8;width:30px;height:30px;border-radius:6px;cursor:pointer;font-size:0.78rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;}
.data-table .cell-actions .btn-edit:hover{border-color:#4f46e5;color:#4f46e5;background:#eef2ff;}
.data-table .cell-actions .btn-del:hover{border-color:#dc2626;color:#dc2626;background:#fef2f2;}

/* Badges */
.badge-status{padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:600;font-family:'JetBrains Mono',monospace;display:inline-block;}
.badge-active{background:#dcfce7;color:#16a34a;}
.badge-completed{background:#dbeafe;color:#2563eb;}
.badge-cancelled{background:#fee2e2;color:#dc2626;}
.badge-available{color:#16a34a;font-weight:600;}
.badge-rented{color:#dc2626;font-weight:600;}

/* Empty state */
.empty-state{padding:60px 20px;text-align:center;color:#94a3b8;}
.empty-state p{font-size:0.9rem;}

/* Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:500;display:flex;align-items:center;justify-content:center;animation:overlayIn 0.2s ease;}
@keyframes overlayIn{from{opacity:0;}to{opacity:1;}}
.modal-card{background:#ffffff;border:1px solid #e2e5ea;border-radius:12px;width:100%;max-width:500px;max-height:85vh;overflow-y:auto;animation:modalIn 0.2s ease;box-shadow:0 16px 48px rgba(0,0,0,0.12);}
@keyframes modalIn{from{opacity:0;transform:scale(0.95);}to{opacity:1;transform:scale(1);}}
.modal-header{padding:20px 24px 16px;border-bottom:1px solid #e2e5ea;display:flex;align-items:center;gap:12px;}
.modal-header .modal-accent{width:4px;height:24px;border-radius:2px;background:#4f46e5;}
.modal-header h3{font-size:1rem;font-weight:600;color:#1e293b;}
.modal-body{padding:20px 24px;}
.modal-body .form-group{margin-bottom:16px;}
.modal-body label{display:block;font-size:0.75rem;color:#64748b;margin-bottom:6px;font-weight:500;text-transform:uppercase;letter-spacing:0.5px;}
.modal-body input,.modal-body select,.modal-body textarea{width:100%;padding:10px 12px;background:#f8f9fb;border:1px solid #d1d5db;border-radius:8px;color:#1e293b;font-family:'JetBrains Mono',monospace;font-size:0.85rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;}
.modal-body input:focus,.modal-body select:focus,.modal-body textarea:focus{border-color:#4f46e5;box-shadow:0 0 0 3px rgba(79,70,229,0.12);}
.modal-body select{cursor:pointer;}
.modal-footer{padding:16px 24px 20px;display:flex;justify-content:flex-end;gap:10px;border-top:1px solid #e2e5ea;}

/* Toast */
.toast-container{position:fixed;bottom:24px;right:24px;z-index:600;display:flex;flex-direction:column;gap:10px;}
.toast{background:#ffffff;border:1px solid #e2e5ea;border-radius:10px;padding:14px 20px;min-width:300px;max-width:420px;display:flex;align-items:center;gap:10px;animation:toastIn 0.3s ease;box-shadow:0 4px 16px rgba(0,0,0,0.1);border-left:4px solid #16a34a;}
.toast.error{border-left-color:#dc2626;}
.toast .toast-msg{font-size:0.82rem;color:#1e293b;flex:1;}
@keyframes toastIn{from{opacity:0;transform:translateX(60px);}to{opacity:1;transform:translateX(0);}}
@keyframes toastOut{from{opacity:1;transform:translateX(0);}to{opacity:0;transform:translateX(60px);}}

/* Rent page two-column */
.rent-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;}
.form-card{background:#ffffff;border:1px solid #e2e5ea;border-radius:10px;padding:24px;}
.form-card h3{font-size:0.95rem;font-weight:600;margin-bottom:18px;color:#1e293b;}
.form-card .form-group{margin-bottom:16px;}
.form-card label{display:block;font-size:0.72rem;color:#64748b;margin-bottom:6px;font-weight:500;text-transform:uppercase;letter-spacing:0.5px;}
.form-card input,.form-card select{width:100%;padding:10px 12px;background:#f8f9fb;border:1px solid #d1d5db;border-radius:8px;color:#1e293b;font-family:'JetBrains Mono',monospace;font-size:0.85rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;}
.form-card input:focus,.form-card select:focus{border-color:#4f46e5;box-shadow:0 0 0 3px rgba(79,70,229,0.12);}

/* Preview card details */
.preview-item{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f1f3;font-size:0.82rem;}
.preview-item:last-child{border-bottom:none;}
.preview-item .p-label{color:#94a3b8;}
.preview-item .p-value{font-family:'JetBrains Mono',monospace;color:#1e293b;font-weight:500;}
.preview-placeholder{color:#94a3b8;font-size:0.82rem;text-align:center;padding:20px 0;}

/* Confirm delete modal */
.confirm-body{padding:24px;text-align:center;}
.confirm-body p{font-size:0.9rem;color:#64748b;margin-bottom:6px;}
.confirm-body .confirm-warn{color:#dc2626;font-size:0.78rem;}
.confirm-footer{padding:16px 24px 20px;display:flex;justify-content:center;gap:10px;}

/* Loading spinner */
.spinner{display:inline-block;width:18px;height:18px;border:2px solid #e2e5ea;border-top-color:#4f46e5;border-radius:50%;animation:spin 0.6s linear infinite;margin:0 auto;}
@keyframes spin{to{transform:rotate(360deg);}}
.loading-state{padding:40px;text-align:center;}

@media(max-width:1200px){.stat-grid{grid-template-columns:repeat(2,1fr);}.rent-grid{grid-template-columns:1fr;}}
@media(max-width:768px){.stat-grid{grid-template-columns:1fr;}}
</style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-logo">
    <h1>CarRental DB</h1>
    <p>Admin Panel</p>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-label">Navigation</div>
    <div class="nav-item active" data-section="dashboard" onclick="loadSection('dashboard')">
      Dashboard
    </div>
    <div class="nav-item" data-section="customers" onclick="loadSection('customers')">
      Customers
    </div>
    <div class="nav-item" data-section="cars" onclick="loadSection('cars')">
      Cars
    </div>
    <div class="nav-item" data-section="reservations" onclick="loadSection('reservations')">
      Reservations
    </div>
    <div class="nav-item" data-section="payments" onclick="loadSection('payments')">
      Payments
    </div>
    <div class="nav-separator"></div>
    <div class="nav-label">Operations</div>
    <div class="nav-item" data-section="rent" onclick="loadSection('rent')">
      Rent Car
    </div>
    <div class="nav-item" data-section="return" onclick="loadSection('return')">
      Return Car
    </div>
  </nav>
  <div class="sidebar-footer">
    <a href="index.php">Customer Portal &rarr;</a>
  </div>
</aside>

<main class="main">
  <header class="topbar">
    <div>
      <div class="topbar-breadcrumb">Admin / <span id="breadcrumb-section">Dashboard</span></div>
      <div class="topbar-title" id="topbar-title">Dashboard</div>
    </div>
  </header>
  <div class="content-area" id="content-area"></div>
</main>

<div class="toast-container" id="toast-container"></div>

<script>
const API = 'api.php';
let currentSection = 'dashboard';

const sectionMeta = {
  dashboard:     { title: 'Dashboard' },
  customers:     { title: 'Customers' },
  cars:          { title: 'Cars' },
  reservations:  { title: 'Reservations' },
  payments:      { title: 'Payments' },
  rent:          { title: 'Rent Car' },
  return:        { title: 'Return Car' }
};

function loadSection(name) {
  currentSection = name;
  document.querySelectorAll('.nav-item').forEach(el => {
    el.classList.toggle('active', el.dataset.section === name);
  });
  const meta = sectionMeta[name];
  document.getElementById('breadcrumb-section').textContent = meta.title;
  document.getElementById('topbar-title').textContent = meta.title;
  const area = document.getElementById('content-area');
  area.innerHTML = '<div class="loading-state"><div class="spinner"></div></div>';
  switch (name) {
    case 'dashboard': renderDashboard(); break;
    case 'customers': renderCustomers(); break;
    case 'cars': renderCars(); break;
    case 'reservations': renderReservations(); break;
    case 'payments': renderPayments(); break;
    case 'rent': renderRent(); break;
    case 'return': renderReturn(); break;
  }
}

// -- API Helpers --

async function apiGet(action) {
  const res = await fetch(`${API}?action=${action}`);
  return res.json();
}

async function apiPost(action, body) {
  const params = new URLSearchParams({ action, ...body });
  const res = await fetch(API, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: params.toString()
  });
  return res.json();
}

// -- Toast --

function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.className = 'toast' + (type === 'error' ? ' error' : '');
  toast.innerHTML = `<span class="toast-msg">${escapeHtml(message)}</span>`;
  container.appendChild(toast);
  setTimeout(() => {
    toast.style.animation = 'toastOut 0.3s ease forwards';
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

// -- Utilities --

function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function formatDate(d) {
  if (!d) return '-';
  const dt = new Date(d);
  if (isNaN(dt)) return escapeHtml(d);
  return dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function formatMoney(v) {
  const n = parseFloat(v);
  if (isNaN(n)) return '$0.00';
  return '$' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// -- Reusable Table Renderer --

function renderTable(columns, data, options = {}) {
  if (!data || data.length === 0) {
    return `<div class="table-wrap"><div class="empty-state"><p>No records found</p></div></div>`;
  }
  let html = '<div class="table-wrap"><table class="data-table"><thead><tr>';
  columns.forEach(c => { html += `<th>${escapeHtml(c.label)}</th>`; });
  if (options.actions) html += '<th>Actions</th>';
  html += '</tr></thead><tbody>';
  data.forEach(row => {
    html += '<tr>';
    columns.forEach(c => {
      let val = row[c.key] !== undefined && row[c.key] !== null ? row[c.key] : '';
      let cls = '';
      if (c.type === 'id') { cls = ' class="cell-id"'; val = escapeHtml(val); }
      else if (c.type === 'date') { val = formatDate(val); }
      else if (c.type === 'money') { val = formatMoney(val); }
      else if (c.type === 'available') {
        val = parseInt(val) ? '<span class="badge-available">Available</span>' : '<span class="badge-rented">Rented</span>';
      } else if (c.type === 'status') {
        const s = String(val).toLowerCase();
        let bc = 'badge-active';
        if (s === 'completed') bc = 'badge-completed';
        else if (s === 'cancelled') bc = 'badge-cancelled';
        val = `<span class="badge-status ${bc}">${escapeHtml(val)}</span>`;
      } else {
        val = escapeHtml(val);
      }
      html += `<td${cls}>${val}</td>`;
    });
    if (options.actions) {
      html += '<td><div class="cell-actions">';
      options.actions.forEach(a => {
        html += `<button class="${a.cls}" title="${a.title}" onclick="${a.handler}(${row[options.idKey]})">${a.icon}</button>`;
      });
      html += '</div></td>';
    }
    html += '</tr>';
  });
  html += '</tbody></table></div>';
  return html;
}

// -- Modal System --

function showModal(title, fields, values, onSave, accentColor) {
  const overlay = document.createElement('div');
  overlay.className = 'modal-overlay';
  overlay.id = 'modal-overlay';
  const accent = accentColor || '#4f46e5';
  let formHtml = '';
  fields.forEach(f => {
    const val = values && values[f.key] !== undefined ? values[f.key] : '';
    if (f.type === 'select') {
      let opts = '';
      f.options.forEach(o => {
        const sel = String(val) === String(o.value) ? ' selected' : '';
        opts += `<option value="${escapeHtml(o.value)}"${sel}>${escapeHtml(o.label)}</option>`;
      });
      formHtml += `<div class="form-group"><label>${escapeHtml(f.label)}</label><select id="modal-${f.key}">${opts}</select></div>`;
    } else {
      formHtml += `<div class="form-group"><label>${escapeHtml(f.label)}</label><input type="${f.type || 'text'}" id="modal-${f.key}" value="${escapeHtml(val)}" ${f.step ? 'step="'+f.step+'"' : ''} ${f.min ? 'min="'+f.min+'"' : ''}></div>`;
    }
  });
  overlay.innerHTML = `
    <div class="modal-card">
      <div class="modal-header"><div class="modal-accent" style="background:${accent}"></div><h3>${escapeHtml(title)}</h3></div>
      <div class="modal-body">${formHtml}</div>
      <div class="modal-footer">
        <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>
        <button class="btn btn-primary" id="modal-save-btn">Save</button>
      </div>
    </div>`;
  document.body.appendChild(overlay);
  overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(); });
  document.getElementById('modal-save-btn').addEventListener('click', () => {
    const data = {};
    fields.forEach(f => {
      const el = document.getElementById('modal-' + f.key);
      data[f.key] = el ? el.value : '';
    });
    onSave(data);
  });
  const firstInput = overlay.querySelector('input, select');
  if (firstInput) firstInput.focus();
}

function closeModal() {
  const ov = document.getElementById('modal-overlay');
  if (ov) ov.remove();
  const cv = document.getElementById('confirm-overlay');
  if (cv) cv.remove();
}

// -- Confirm Delete --

function confirmDelete(message, onConfirm) {
  const overlay = document.createElement('div');
  overlay.className = 'modal-overlay';
  overlay.id = 'confirm-overlay';
  overlay.innerHTML = `
    <div class="modal-card" style="max-width:400px;">
      <div class="confirm-body">
        <p>${escapeHtml(message)}</p>
        <p class="confirm-warn">This action cannot be undone.</p>
      </div>
      <div class="confirm-footer">
        <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>
        <button class="btn btn-danger" id="confirm-delete-btn">Delete</button>
      </div>
    </div>`;
  document.body.appendChild(overlay);
  overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(); });
  document.getElementById('confirm-delete-btn').addEventListener('click', () => {
    closeModal();
    onConfirm();
  });
}

// =======================================
// --             DASHBOARD             --
// =======================================

async function renderDashboard() {
  const area = document.getElementById('content-area');
  try {
    const res = await apiGet('get_stats');
    const s = res.data || res;
    const stats = {
      total_customers: s.total_customers || 0,
      total_cars: s.total_cars || 0,
      active_rentals: s.active_rentals || 0,
      total_revenue: s.total_revenue || 0,
      recent_reservations: s.recent_reservations || []
    };
    const cols = [
      { key: 'Reservation_ID', label: 'ID', type: 'id' },
      { key: 'Customer_Name', label: 'Customer' },
      { key: 'Car_Name', label: 'Car' },
      { key: 'Start_Date', label: 'Start Date', type: 'date' },
      { key: 'End_Date', label: 'End Date', type: 'date' },
      { key: 'Status', label: 'Status', type: 'status' },
      { key: 'Total_Cost', label: 'Cost', type: 'money' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="stat-grid">
          <div class="stat-card blue"><div class="stat-label-top">Customers</div><div class="stat-value">${escapeHtml(stats.total_customers)}</div><div class="stat-label">Total Customers</div></div>
          <div class="stat-card green"><div class="stat-label-top">Fleet</div><div class="stat-value">${escapeHtml(stats.total_cars)}</div><div class="stat-label">Total Cars</div></div>
          <div class="stat-card purple"><div class="stat-label-top">Rentals</div><div class="stat-value">${escapeHtml(stats.active_rentals)}</div><div class="stat-label">Active Rentals</div></div>
          <div class="stat-card yellow"><div class="stat-label-top">Revenue</div><div class="stat-value">${formatMoney(stats.total_revenue)}</div><div class="stat-label">Total Revenue</div></div>
        </div>
        <div class="table-header"><div class="table-title"><h2>Recent Reservations</h2></div></div>
        ${renderTable(cols, stats.recent_reservations.slice(0, 5))}
      </div>`;
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load dashboard data.</p></div></div>`;
  }
}

// =======================================
// --             CUSTOMERS             --
// =======================================

const customerFields = [
  { key: 'Name', label: 'Name', type: 'text' },
  { key: 'Email', label: 'Email', type: 'email' },
  { key: 'Phone', label: 'Phone', type: 'text' },
  { key: 'Drivers_License', label: 'Drivers License', type: 'text' },
  { key: 'Address', label: 'Address', type: 'text' }
];

async function renderCustomers() {
  const area = document.getElementById('content-area');
  try {
    const res = await apiGet('get_customers');
    const data = res.data || [];
    const cols = [
      { key: 'Customer_ID', label: 'ID', type: 'id' },
      { key: 'Name', label: 'Name' },
      { key: 'Email', label: 'Email' },
      { key: 'Phone', label: 'Phone' },
      { key: 'Drivers_License', label: 'License' },
      { key: 'Address', label: 'Address' },
      { key: 'Created_At', label: 'Created', type: 'date' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="table-header">
          <div class="table-title"><h2>Customers</h2><span class="badge">${data.length} records</span></div>
          <button class="btn btn-primary" onclick="openAddCustomer()">+ Add New</button>
        </div>
        ${renderTable(cols, data, {
          idKey: 'Customer_ID',
          actions: [
            { icon: 'Edit', title: 'Edit', cls: 'btn-edit', handler: 'editCustomer' },
            { icon: 'Del', title: 'Delete', cls: 'btn-del', handler: 'deleteCustomer' }
          ]
        })}
      </div>`;
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load customers.</p></div></div>`;
  }
}

function openAddCustomer() {
  showModal('Add Customer', customerFields, {}, async (data) => {
    closeModal();
    const res = await apiPost('add_customer', data);
    showToast(res.message || 'Customer added', res.success ? 'success' : 'error');
    if (res.success) renderCustomers();
  });
}

window.editCustomer = async function(id) {
  const res = await apiGet('get_customers');
  const list = res.data || [];
  const cust = list.find(c => c.Customer_ID == id);
  if (!cust) return showToast('Customer not found', 'error');
  showModal('Edit Customer', customerFields, cust, async (data) => {
    closeModal();
    data.Customer_ID = id;
    const r = await apiPost('update_customer', data);
    showToast(r.message || 'Customer updated', r.success ? 'success' : 'error');
    if (r.success) renderCustomers();
  });
};

window.deleteCustomer = function(id) {
  confirmDelete('Are you sure you want to delete this customer?', async () => {
    const r = await apiPost('delete_customer', { Customer_ID: id });
    showToast(r.message || 'Deleted', r.success ? 'success' : 'error');
    if (r.success) renderCustomers();
  });
};

// =======================================
// --               CARS               --
// =======================================

const carFields = [
  { key: 'Brand', label: 'Brand', type: 'text' },
  { key: 'Model', label: 'Model', type: 'text' },
  { key: 'Year', label: 'Year', type: 'number', min: '1900' },
  { key: 'Color', label: 'Color', type: 'text' },
  { key: 'License_Plate', label: 'License Plate', type: 'text' },
  { key: 'Rental_Price', label: 'Rental Price (per day)', type: 'number', step: '0.01', min: '0' }
];

async function renderCars() {
  const area = document.getElementById('content-area');
  try {
    const res = await apiGet('get_cars');
    const data = res.data || [];
    const cols = [
      { key: 'Car_ID', label: 'ID', type: 'id' },
      { key: 'Brand', label: 'Brand' },
      { key: 'Model', label: 'Model' },
      { key: 'Year', label: 'Year' },
      { key: 'Color', label: 'Color' },
      { key: 'License_Plate', label: 'Plate' },
      { key: 'Rental_Price', label: 'Price/Day', type: 'money' },
      { key: 'Available', label: 'Status', type: 'available' },
      { key: 'Created_At', label: 'Created', type: 'date' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="table-header">
          <div class="table-title"><h2>Cars</h2><span class="badge">${data.length} records</span></div>
          <button class="btn btn-primary" onclick="openAddCar()">+ Add New</button>
        </div>
        ${renderTable(cols, data, {
          idKey: 'Car_ID',
          actions: [
            { icon: 'Edit', title: 'Edit', cls: 'btn-edit', handler: 'editCar' },
            { icon: 'Del', title: 'Delete', cls: 'btn-del', handler: 'deleteCar' }
          ]
        })}
      </div>`;
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load cars.</p></div></div>`;
  }
}

function openAddCar() {
  showModal('Add Car', carFields, {}, async (data) => {
    closeModal();
    const res = await apiPost('add_car', data);
    showToast(res.message || 'Car added', res.success ? 'success' : 'error');
    if (res.success) renderCars();
  });
}

window.editCar = async function(id) {
  const res = await apiGet('get_cars');
  const list = res.data || [];
  const car = list.find(c => c.Car_ID == id);
  if (!car) return showToast('Car not found', 'error');
  showModal('Edit Car', carFields, car, async (data) => {
    closeModal();
    data.Car_ID = id;
    const r = await apiPost('update_car', data);
    showToast(r.message || 'Car updated', r.success ? 'success' : 'error');
    if (r.success) renderCars();
  });
};

window.deleteCar = function(id) {
  confirmDelete('Are you sure you want to delete this car?', async () => {
    const r = await apiPost('delete_car', { Car_ID: id });
    showToast(r.message || 'Deleted', r.success ? 'success' : 'error');
    if (r.success) renderCars();
  });
};

// =======================================
// --          RESERVATIONS             --
// =======================================

async function renderReservations() {
  const area = document.getElementById('content-area');
  try {
    const res = await apiGet('get_reservations');
    const data = res.data || [];
    const cols = [
      { key: 'Reservation_ID', label: 'ID', type: 'id' },
      { key: 'Customer_ID', label: 'Cust ID', type: 'id' },
      { key: 'Customer_Name', label: 'Customer' },
      { key: 'Car_ID', label: 'Car ID', type: 'id' },
      { key: 'Car_Name', label: 'Car' },
      { key: 'Start_Date', label: 'Start', type: 'date' },
      { key: 'End_Date', label: 'End', type: 'date' },
      { key: 'Total_Cost', label: 'Cost', type: 'money' },
      { key: 'Payment_ID', label: 'Pay ID', type: 'id' },
      { key: 'Status', label: 'Status', type: 'status' },
      { key: 'Created_At', label: 'Created', type: 'date' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="table-header">
          <div class="table-title"><h2>Reservations</h2><span class="badge">${data.length} records</span></div>
        </div>
        ${renderTable(cols, data, {
          idKey: 'Reservation_ID',
          actions: [
            { icon: 'Del', title: 'Delete', cls: 'btn-del', handler: 'deleteReservation' }
          ]
        })}
      </div>`;
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load reservations.</p></div></div>`;
  }
}

window.deleteReservation = function(id) {
  confirmDelete('Are you sure you want to delete this reservation?', async () => {
    const r = await apiPost('delete_reservation', { Reservation_ID: id });
    showToast(r.message || 'Deleted', r.success ? 'success' : 'error');
    if (r.success) renderReservations();
  });
};

// =======================================
// --            PAYMENTS               --
// =======================================

async function renderPayments() {
  const area = document.getElementById('content-area');
  try {
    const res = await apiGet('get_payments');
    const data = res.data || [];
    const cols = [
      { key: 'Payment_ID', label: 'ID', type: 'id' },
      { key: 'Customer_ID', label: 'Cust ID', type: 'id' },
      { key: 'Customer_Name', label: 'Customer' },
      { key: 'Amount', label: 'Amount', type: 'money' },
      { key: 'Payment_Method', label: 'Method' },
      { key: 'Payment_Date', label: 'Date', type: 'date' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="table-header">
          <div class="table-title"><h2>Payments</h2><span class="badge">${data.length} records</span></div>
        </div>
        ${renderTable(cols, data, {
          idKey: 'Payment_ID',
          actions: [
            { icon: 'Del', title: 'Delete', cls: 'btn-del', handler: 'deletePayment' }
          ]
        })}
      </div>`;
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load payments.</p></div></div>`;
  }
}

window.deletePayment = function(id) {
  confirmDelete('Are you sure you want to delete this payment?', async () => {
    const r = await apiPost('delete_payment', { Payment_ID: id });
    showToast(r.message || 'Deleted', r.success ? 'success' : 'error');
    if (r.success) renderPayments();
  });
};

// =======================================
// --            RENT CAR               --
// =======================================

let rentCarCache = null;

async function renderRent() {
  const area = document.getElementById('content-area');
  try {
    const avRes = await apiGet('get_available_cars');
    const available = avRes.data || [];
    rentCarCache = available;
    const today = new Date().toISOString().split('T')[0];
    const avCols = [
      { key: 'Car_ID', label: 'ID', type: 'id' },
      { key: 'Brand', label: 'Brand' },
      { key: 'Model', label: 'Model' },
      { key: 'Year', label: 'Year' },
      { key: 'Color', label: 'Color' },
      { key: 'License_Plate', label: 'Plate' },
      { key: 'Rental_Price', label: 'Price/Day', type: 'money' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="rent-grid">
          <div class="form-card">
            <h3>Rental Form</h3>
            <div class="form-group">
              <label>Customer ID</label>
              <input type="number" id="rent-customer-id" min="1" placeholder="Enter customer ID">
            </div>
            <div class="form-group">
              <label>Car ID</label>
              <input type="number" id="rent-car-id" min="1" placeholder="Enter car ID">
            </div>
            <div class="form-group">
              <label>Start Date</label>
              <input type="date" id="rent-start" value="${today}">
            </div>
            <div class="form-group">
              <label>End Date</label>
              <input type="date" id="rent-end">
            </div>
            <div class="form-group">
              <label>Payment Method</label>
              <select id="rent-payment">
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
              </select>
            </div>
            <button class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;" onclick="confirmRental()">Confirm Rental</button>
          </div>
          <div class="form-card">
            <h3>Car Preview</h3>
            <div id="rent-preview"><div class="preview-placeholder">Enter a Car ID to see details</div></div>
            <div style="margin-top:20px;"><h3>Cost Estimate</h3></div>
            <div id="rent-cost"><div class="preview-placeholder">Fill in dates to calculate cost</div></div>
          </div>
        </div>
        <div class="table-header"><div class="table-title"><h2>Available Cars</h2><span class="badge">${available.length} cars</span></div></div>
        ${renderTable(avCols, available)}
      </div>`;
    document.getElementById('rent-car-id').addEventListener('input', updateRentPreview);
    document.getElementById('rent-start').addEventListener('input', updateRentCost);
    document.getElementById('rent-end').addEventListener('input', updateRentCost);
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load rent page.</p></div></div>`;
  }
}

function updateRentPreview() {
  const carId = document.getElementById('rent-car-id').value;
  const preview = document.getElementById('rent-preview');
  if (!carId || !rentCarCache) {
    preview.innerHTML = '<div class="preview-placeholder">Enter a Car ID to see details</div>';
    updateRentCost();
    return;
  }
  const car = rentCarCache.find(c => c.Car_ID == carId);
  if (!car) {
    preview.innerHTML = '<div class="preview-placeholder" style="color:#dc2626;">Car not found or not available</div>';
    updateRentCost();
    return;
  }
  preview.innerHTML = `
    <div class="preview-item"><span class="p-label">Brand</span><span class="p-value">${escapeHtml(car.Brand)}</span></div>
    <div class="preview-item"><span class="p-label">Model</span><span class="p-value">${escapeHtml(car.Model)}</span></div>
    <div class="preview-item"><span class="p-label">Year</span><span class="p-value">${escapeHtml(car.Year)}</span></div>
    <div class="preview-item"><span class="p-label">Color</span><span class="p-value">${escapeHtml(car.Color)}</span></div>
    <div class="preview-item"><span class="p-label">Plate</span><span class="p-value">${escapeHtml(car.License_Plate)}</span></div>
    <div class="preview-item"><span class="p-label">Price/Day</span><span class="p-value">${formatMoney(car.Rental_Price)}</span></div>`;
  updateRentCost();
}

function updateRentCost() {
  const costEl = document.getElementById('rent-cost');
  const carId = document.getElementById('rent-car-id').value;
  const start = document.getElementById('rent-start').value;
  const end = document.getElementById('rent-end').value;
  if (!carId || !start || !end || !rentCarCache) {
    costEl.innerHTML = '<div class="preview-placeholder">Fill in dates to calculate cost</div>';
    return;
  }
  const car = rentCarCache.find(c => c.Car_ID == carId);
  if (!car) {
    costEl.innerHTML = '<div class="preview-placeholder">Select a valid car</div>';
    return;
  }
  const d1 = new Date(start);
  const d2 = new Date(end);
  const days = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
  if (days <= 0) {
    costEl.innerHTML = '<div class="preview-placeholder" style="color:#d97706;">End date must be after start date</div>';
    return;
  }
  const total = days * parseFloat(car.Rental_Price);
  costEl.innerHTML = `
    <div class="preview-item"><span class="p-label">Days</span><span class="p-value">${days}</span></div>
    <div class="preview-item"><span class="p-label">Rate</span><span class="p-value">${formatMoney(car.Rental_Price)}/day</span></div>
    <div class="preview-item"><span class="p-label">Total</span><span class="p-value" style="color:#16a34a;font-size:1.1rem;">${formatMoney(total)}</span></div>`;
}

async function confirmRental() {
  const customerId = document.getElementById('rent-customer-id').value;
  const carId = document.getElementById('rent-car-id').value;
  const start = document.getElementById('rent-start').value;
  const end = document.getElementById('rent-end').value;
  const payment = document.getElementById('rent-payment').value;
  if (!customerId || !carId || !start || !end) {
    showToast('Please fill in all fields', 'error');
    return;
  }
  const d1 = new Date(start);
  const d2 = new Date(end);
  if (d2 <= d1) {
    showToast('End date must be after start date', 'error');
    return;
  }
  try {
    const res = await apiPost('rent_car', {
      Customer_ID: customerId,
      Car_ID: carId,
      Start_Date: start,
      End_Date: end,
      Payment_Method: payment
    });
    showToast(res.message || 'Rental processed', res.success ? 'success' : 'error');
    if (res.success) renderRent();
  } catch (e) {
    showToast('Failed to process rental', 'error');
  }
}
window.confirmRental = confirmRental;

// =======================================
// --           RETURN CAR              --
// =======================================

async function renderReturn() {
  const area = document.getElementById('content-area');
  try {
    const res = await apiGet('get_reservations');
    const all = res.data || [];
    const active = all.filter(r => String(r.Status).toLowerCase() === 'active');
    const cols = [
      { key: 'Reservation_ID', label: 'ID', type: 'id' },
      { key: 'Customer_Name', label: 'Customer' },
      { key: 'Car_Name', label: 'Car' },
      { key: 'Start_Date', label: 'Start', type: 'date' },
      { key: 'End_Date', label: 'End', type: 'date' },
      { key: 'Total_Cost', label: 'Cost', type: 'money' },
      { key: 'Status', label: 'Status', type: 'status' }
    ];
    area.innerHTML = `
      <div class="content-section">
        <div class="table-header">
          <div class="table-title"><h2>Return Car</h2><span class="badge">${active.length} active rentals</span></div>
        </div>
        ${renderReturnTable(cols, active)}
      </div>`;
  } catch (e) {
    area.innerHTML = `<div class="content-section"><div class="empty-state"><p>Failed to load reservations.</p></div></div>`;
  }
}

function renderReturnTable(columns, data) {
  if (!data || data.length === 0) {
    return `<div class="table-wrap"><div class="empty-state"><p>No active rentals to return</p></div></div>`;
  }
  let html = '<div class="table-wrap"><table class="data-table"><thead><tr>';
  columns.forEach(c => { html += `<th>${escapeHtml(c.label)}</th>`; });
  html += '<th>Action</th></tr></thead><tbody>';
  data.forEach(row => {
    html += '<tr>';
    columns.forEach(c => {
      let val = row[c.key] !== undefined && row[c.key] !== null ? row[c.key] : '';
      let cls = '';
      if (c.type === 'id') { cls = ' class="cell-id"'; val = escapeHtml(val); }
      else if (c.type === 'date') { val = formatDate(val); }
      else if (c.type === 'money') { val = formatMoney(val); }
      else if (c.type === 'status') {
        val = `<span class="badge-status badge-active">${escapeHtml(val)}</span>`;
      } else { val = escapeHtml(val); }
      html += `<td${cls}>${val}</td>`;
    });
    html += `<td><button class="btn btn-success btn-sm" onclick="returnCar(${row.Reservation_ID})">Return</button></td>`;
    html += '</tr>';
  });
  html += '</tbody></table></div>';
  return html;
}

window.returnCar = async function(id) {
  try {
    const res = await apiPost('return_car', { Reservation_ID: id });
    showToast(res.message || 'Car returned', res.success ? 'success' : 'error');
    if (res.success) renderReturn();
  } catch (e) {
    showToast('Failed to return car', 'error');
  }
};

// -- Init --
loadSection('dashboard');
</script>
</body>
</html>
