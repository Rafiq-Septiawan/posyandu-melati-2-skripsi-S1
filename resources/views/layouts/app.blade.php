<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Posyandu Melati 2')</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root {
  --teal-900:#0d3b38; --teal-800:#0f4f4a; --teal-700:#0e6660; --teal-600:#0f8075;
  --teal-500:#14a398; --teal-400:#2ec4b6; --teal-300:#5dd8cd; --teal-200:#a0ebe6;
  --teal-100:#d4f5f3; --teal-50:#edfaf9;
  --rose-400:#fb7185; --rose-500:#f43f5e;
  --amber-400:#fbbf24; --amber-500:#f59e0b;
  --indigo-400:#818cf8; --indigo-500:#6366f1;
  --slate-50:#f8fafc; --slate-100:#f1f5f9; --slate-200:#e2e8f0; --slate-300:#cbd5e1;
  --slate-400:#94a3b8; --slate-500:#64748b; --slate-600:#475569; --slate-700:#334155;
  --slate-800:#1e293b; --slate-900:#0f172a; --white:#ffffff;
  --sidebar-w: clamp(200px, 17vw, 260px);
  --radius-sm:8px; --radius-md:12px; --radius-lg:16px; --radius-xl:24px;
  --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
  --shadow-md:0 4px 16px rgba(0,0,0,.08); --shadow-lg:0 8px 32px rgba(0,0,0,.12);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html, body { overflow-x: hidden; width: 100%; }
body { font-family:'DM Sans',sans-serif; background:var(--slate-100); color:var(--slate-800); display:flex; min-height:100vh; min-height:100dvh; }
.main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; min-height:100vh; min-height:100dvh; min-width:0; }
.content {
  padding: clamp(16px, 2vw, 28px) clamp(16px, 2.5vw, 32px);
  flex:1;
  max-width: 1600px;
  width: 100%;
  margin: 0 auto;     
  align-self: flex-start;
}

.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
.stats-grid-3 { grid-template-columns:repeat(3,1fr); }
.stat-card { background:#fff; border-radius:14px; padding:20px 22px 16px; box-shadow:0 1px 4px rgba(0,0,0,.06); border-top:4px solid transparent; transition:box-shadow .15s,transform .15s; }
.stat-card:hover { transform:translateY(-3px); box-shadow:0 6px 18px rgba(0,0,0,.1); }
.stat-card::before { display:none !important; }
.card-teal{border-top-color:#14a398;} .card-rose{border-top-color:#f43f5e;}
.card-amber{border-top-color:#f59e0b;} .card-indigo{border-top-color:#6366f1;} .card-green{border-top-color:#22c55e;}
.stat-icon { width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:12px; }
.icon-teal{background:#e6f7f6;color:#14a398;} .icon-rose{background:#ffeef2;color:#f43f5e;}
.icon-amber{background:#fef3c7;color:#f59e0b;} .icon-indigo{background:#eef0ff;color:#6366f1;} .icon-green{background:#e9fbe9;color:#22c55e;}
.stat-value { font-size:28px;font-weight:800;color:var(--slate-800,#1e293b);line-height:1; }
.stat-label { font-size:13px;color:var(--slate-500,#64748b);margin-top:4px; }
.stat-delta { font-size:12px;margin-top:6px; }
.dashboard-stats-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:20px; }
.dashboard-chart-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:16px;margin-bottom:16px; }
.delta-up { color:#16a34a; } .delta-down { color:var(--rose-500); }
.card { background:var(--white); border-radius:var(--radius-lg); box-shadow:var(--shadow-sm); border:1.5px solid var(--slate-200); overflow:visible; margin-bottom:16px; }
.card > *:first-child { border-radius:var(--radius-lg) var(--radius-lg) 0 0; overflow:hidden; }
.card > *:last-child  { border-radius:0 0 var(--radius-lg) var(--radius-lg); }
.table-scroll {
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch;
  width: 100%;
}
.table-scroll .data-table,
.table-scroll table {
  min-width: 680px;
}

.card-header { padding:18px 22px; display:flex; align-items:center; border-bottom:1.5px solid var(--slate-100); gap:12px; }
.card-title { font-size:14.5px; font-weight:700; color:var(--slate-800); flex:1; }
.card-subtitle { font-size:12px; color:var(--slate-400); }
.btn { display:inline-flex; align-items:center; gap:7px; padding:8px 16px; border-radius:var(--radius-sm); font-family:inherit; font-size:13px; font-weight:600; cursor:pointer; border:none; transition:all .2s; text-decoration:none; }
.btn-primary { background:var(--teal-600); color:#fff; box-shadow:0 2px 8px rgba(14,128,117,.25); }
.btn-primary:hover { background:var(--teal-700); color:#fff; }
.btn-outline { background:transparent; color:var(--slate-600); border:1.5px solid var(--slate-200); }
.btn-outline:hover { border-color:var(--teal-400); color:var(--teal-600); background:var(--teal-50); }
.btn-sm { padding:6px 12px; font-size:12px; }
.btn-danger { background:#fee2e2; color:#dc2626; } .btn-danger:hover { background:#fecaca; }
.btn-edit { background:#dbeafe; color:#1d4ed8; } .btn-edit:hover { background:#bfdbfe; }
.btn-view { background:var(--teal-100); color:var(--teal-700); } .btn-view:hover { background:var(--teal-200); }
.data-table { width:100%; border-collapse:collapse; }
.data-table thead tr { background:var(--slate-50); border-bottom:1.5px solid var(--slate-200); }
.data-table th { padding:11px 16px; font-size:11.5px; font-weight:700; color:var(--slate-500); text-transform:uppercase; letter-spacing:.6px; text-align:left; }
.data-table td { padding:13px 16px; font-size:13.5px; color:var(--slate-700); border-bottom:1px solid var(--slate-100); vertical-align:middle; }
.data-table tr:last-child td { border-bottom:none; }
.data-table tbody tr:hover { background:var(--teal-50); }
.avatar-table { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#fff; flex-shrink:0; }
.cell-with-avatar { display:flex; align-items:center; gap:10px; }
.cell-name { font-weight:600; color:var(--slate-800); font-size:13.5px; }
.cell-meta { font-size:12px; color:var(--slate-400); margin-top:1px; }
.action-btns { display:flex; gap:6px; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600; }
.badge-green { background:#dcfce7; color:#166534; }
.badge-blue { background:#dbeafe; color:#1e40af; }
.badge-orange { background:#fff7ed; color:#9a3412; }
.badge-red { background:#fee2e2; color:#991b1b; }
.badge-purple { background:#f3e8ff; color:#6b21a8; }
.badge-teal { background:var(--teal-100); color:var(--teal-800); }
.form-section { padding:20px 24px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.form-row-3 { grid-template-columns:1fr 1fr 1fr; }
.form-row-1 { grid-template-columns:1fr; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-label { font-size:13px; font-weight:600; color:var(--slate-600); }
.required { color:var(--rose-500); margin-left:2px; }
.form-control { padding:10px 14px; border:1.5px solid var(--slate-200); border-radius:var(--radius-sm); font-family:inherit; font-size:13.5px; color:var(--slate-800); background:var(--white); outline:none; transition:border-color .2s,box-shadow .2s; width:100%; }
.form-control:focus { border-color:var(--teal-400); box-shadow:0 0 0 3px rgba(46,196,182,.12); }
.form-control::placeholder { color:var(--slate-400); }
.form-hint { font-size:12px; color:var(--slate-400); margin-top:2px; }
.form-footer { padding:16px 24px; border-top:1.5px solid var(--slate-100); display:flex; justify-content:flex-end; gap:10px; background:var(--slate-50); }
.section-divider { font-size:12px; font-weight:700; color:var(--teal-700); text-transform:uppercase; letter-spacing:.8px; padding:0 24px; margin:16px 0 0; display:flex; align-items:center; gap:10px; }
.section-divider::after { content:''; flex:1; height:1px; background:var(--slate-200); }
.pagination-wrapper { display:flex; align-items:center; gap:4px; padding:14px 20px; border-top:1.5px solid var(--slate-100); justify-content:flex-end; }
.page-info { font-size:12.5px; color:var(--slate-400); margin-right:8px; }
.alert { padding:12px 16px; border-radius:var(--radius-sm); font-size:13.5px; margin-bottom:16px; display:flex; align-items:center; gap:10px; }
.alert-success { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
.alert-danger { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
.alert-warning { background:#fff7ed; color:#9a3412; border:1px solid #fed7aa; }
.search-bar { display:flex; align-items:center; gap:8px; background:var(--slate-100); border:1.5px solid var(--slate-200); border-radius:var(--radius-md); padding:8px 14px; transition:border-color .2s; }
.search-bar:focus-within { border-color:var(--teal-400); }
.search-bar input { border:none; background:transparent; font-family:inherit; font-size:13px; color:var(--slate-700); outline:none; }
.search-bar i { color:var(--slate-400); font-size:13px; }
.pemeriksaan-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; padding:20px; }
.pemeriksaan-item { background:var(--slate-50); border:1.5px solid var(--slate-200); border-radius:var(--radius-md); padding:14px 16px; }
.pem-label { font-size:11.5px; font-weight:700; color:var(--slate-400); text-transform:uppercase; letter-spacing:.6px; margin-bottom:6px; }
.pem-value { font-size:20px; font-weight:700; color:var(--slate-800); }
.pem-unit { font-size:12px; color:var(--slate-400); font-weight:400; }
.pem-status { margin-top:4px; }
.pasien-header { background:linear-gradient(135deg,var(--teal-800),var(--teal-900)); border-radius:var(--radius-lg); padding:22px 26px; color:#fff; display:flex; align-items:center; gap:20px; margin-bottom:20px; position:relative; overflow:hidden; }
.pasien-header::before { content:''; position:absolute; right:-40px; top:-40px; width:160px; height:160px; background:rgba(255,255,255,.05); border-radius:50%; }
.pasien-avatar-lg { width:60px; height:60px; border-radius:var(--radius-md); background:linear-gradient(135deg,var(--teal-400),var(--teal-600)); display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:700; color:#fff; flex-shrink:0; }
.pasien-name { font-size:18px; font-weight:700; margin-bottom:4px; }
.pasien-meta { font-size:13px; color:var(--teal-200); display:flex; gap:16px; flex-wrap:wrap; }
.pasien-meta span { display:flex; align-items:center; gap:5px; }

@keyframes fadeSlideIn { from{opacity:0;transform:translateY(8px);} to{opacity:1;transform:translateY(0);} }
.content > * { animation:fadeSlideIn .25s ease; }
.tabs { display:flex; gap:4px; background:var(--white); border:1.5px solid var(--slate-200); border-radius:var(--radius-md); padding:4px; width:fit-content; margin-bottom:20px; }
.tab { padding:8px 20px; border-radius:var(--radius-sm); font-size:13.5px; font-weight:500; cursor:pointer; color:var(--slate-500); transition:all .2s; text-decoration:none; }
.tab.active, .tab:hover.active { background:var(--teal-600); color:var(--white); }
.tab:hover:not(.active) { background:var(--slate-100); color:var(--slate-700); }
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.page-header-left h2 { font-size:18px; font-weight:700; color:var(--slate-800); }
.page-header-left p { font-size:13px; color:var(--slate-400); margin-top:2px; }

@media (max-width: 1280px) {
  :root { --sidebar-w: clamp(180px, 15vw, 220px); }
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .stat-value { font-size: 22px; }
}

.sidebar-toggle {
  display: none;
  background: none;
  border: none;
  color: var(--slate-600);
  font-size: 18px;
  cursor: pointer;
  padding: 8px 12px;
  border-radius: var(--radius-sm);
  align-items: center;
  justify-content: center;
  transition: background .2s;
}
.sidebar-toggle:hover {
  background: var(--slate-100);
  color: var(--teal-700);
}

.sidebar-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.45);
  backdrop-filter: blur(2px);
  z-index: 90;
}

@media (max-width: 768px) {
  :root { --sidebar-w: 0px; }

  html, body {
    overflow-x: hidden;
    width: 100%;
    max-width: 100vw;
  }

  html.sidebar-open,
  body.sidebar-open {
    overflow: hidden !important;
    height: 100% !important;
    height: 100dvh !important;
    position: relative !important;
  }

  .main {
    margin-left: 0 !important;
    width: 100%;
    max-width: 100vw;
    overflow-x: hidden;
  }

  .content {
    padding: 12px !important;
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
    box-sizing: border-box;
  }

  .sidebar-toggle {
    display: inline-flex;
  }

  .sidebar {
    width: 260px !important;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: 100;
  }
  .sidebar.active {
    transform: translateX(0);
  }
  .sidebar-overlay.active {
    display: block;
  }
  .topnav {
    padding: 0 12px !important;
    width: 100%;
    box-sizing: border-box;
  }

  .dashboard-stats-grid,
  .grid-stats,
  .stats-grid,
  .stats-grid-3 {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 10px !important;
  }

  .dashboard-stats-grid > :last-child:nth-child(odd),
  .grid-stats > :last-child:nth-child(odd),
  .stats-grid > :last-child:nth-child(odd),
  .stats-grid-3 > :last-child:nth-child(odd) {
    grid-column: span 2 !important;
  }

  .stat-card {
    padding: 12px 14px 10px !important;
    border-radius: var(--radius-md) !important;
  }
  .stat-icon {
    width: 32px !important;
    height: 32px !important;
    font-size: 14px !important;
    margin-bottom: 8px !important;
    border-radius: 6px !important;
  }
  .stat-value {
    font-size: 20px !important;
  }
  .stat-label {
    font-size: 11.5px !important;
    margin-top: 2px !important;
  }
  .stat-delta {
    font-size: 10px !important;
    margin-top: 4px !important;
  }

  .welcome-banner {
    padding: 12px 16px !important;
    gap: 10px !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    border-radius: var(--radius-md) !important;
  }
  .welcome-banner > div:first-child {
    flex: 1 !important;
  }
  .welcome-banner > div:first-child > div:last-child {
    display: none !important;
  }
  .welcome-banner > div:first-child > div:first-child {
    font-size: 15px !important;
  }
  .welcome-banner > div:last-child {
    margin-left: 0 !important;
  }
  .dp-box {
    padding: 6px 12px !important;
    border-radius: 8px !important;
    gap: 6px !important;
    width: auto !important;
  }
  .dp-box div:first-child div:first-child {
    font-size: 15px !important;
  }
  .dp-box div:first-child div:last-child {
    font-size: 9px !important;
  }
  .dp-box i, .dp-box .fa-calendar-alt {
    font-size: 11px !important;
  }

  .form-row, .form-row-3 {
    grid-template-columns: 1fr !important;
    gap: 12px;
  }
  .form-section {
    padding: 16px;
  }
  .form-control {
    width: 100% !important;
  }

  .form-footer {
    flex-direction: column-reverse !important;
    padding: 12px 16px !important;
    gap: 8px !important;
  }
  .form-footer .btn {
    width: 100% !important;
    justify-content: center !important;
  }

  #filter-form,
  form[id="filter-form"],
  form[id^="filter-form-"] {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
    padding: 12px !important;
  }
  #filter-form > div,
  form[id="filter-form"] > div,
  form[id^="filter-form-"] > div {
    width: 100% !important;
    max-width: none !important;
    flex: none !important;
    box-sizing: border-box !important;
  }
  #filter-form select,
  #filter-form input,
  form[id="filter-form"] select,
  form[id="filter-form"] input,
  form[id^="filter-form-"] select,
  form[id^="filter-form-"] input {
    width: 100% !important;
  }
  #filter-form > a.btn,
  form[id="filter-form"] > a.btn,
  form[id^="filter-form-"] > a.btn {
    width: 100% !important;
    justify-content: center !important;
  }

  .table-scroll,
  .dashboard-table-wrap {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
    width: 100% !important;
    box-sizing: border-box !important;
  }
  .table-scroll table,
  .dashboard-table-wrap table {
    min-width: 680px !important;
    width: max-content !important;
  }
  .table-scroll table th,
  .table-scroll table td,
  .dashboard-table-wrap table th,
  .dashboard-table-wrap table td {
    white-space: nowrap !important;
  }
  .cell-name, .cell-meta {
    white-space: normal !important;
    min-width: 100px !important;
    max-width: 160px !important;
  }

  .grid-charts .card:last-child > div:last-child {
    flex-direction: row !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 20px !important;
    padding: 16px !important;
  }
  .grid-charts .card:last-child div[style*="width:100px"] {
    width: 130px !important;
    height: 130px !important;
  }
  .grid-charts .card:last-child div[style*="display:flex"][style*="flex-direction:column"][style*="gap:5px"] {
    flex: 1 !important;
  }

  .grid-charts, .grid-tables,
  .dashboard-chart-grid,
  .dashboard-bottom-grid {
    grid-template-columns: 1fr !important;
  }
  .pemeriksaan-grid {
    grid-template-columns: 1fr !important;
    padding: 12px !important;
  }

  div[style*="display:grid"][style*="grid-template-columns:1fr 1fr"],
  div[style*="display: grid"][style*="grid-template-columns: 1fr 1fr"],
  div[style*="display:grid"][style*="grid-template-columns: 1fr 1fr"],
  div[style*="display: grid"][style*="grid-template-columns:1fr 1fr"],
  div[style*="display:grid"][style*="grid-template-columns:1fr 300px"],
  div[style*="display:grid"][style*="grid-template-columns:1fr 320px"],
  div[style*="display:grid"][style*="grid-template-columns:1fr 290px"],
  div[style*="display:grid"][style*="grid-template-columns: 1fr 300px"],
  div[style*="display:grid"][style*="grid-template-columns: 1fr 320px"],
  div[style*="display:grid"][style*="grid-template-columns: 1fr 290px"] {
    grid-template-columns: 1fr !important;
    gap: 16px !important;
  }

  .pasien-header {
    flex-direction: column !important;
    align-items: stretch !important;
    padding: 12px 14px !important;
    gap: 10px !important;
  }
  .pasien-avatar-lg {
    display: none !important;
  }
  .pasien-header > div:not(.pasien-avatar-lg) {
    width: 100% !important;
    flex: none !important;
  }
  .pasien-header > div[style*="flex:1"] > div:first-child {
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 6px !important;
  }
  .pasien-header > div[style*="flex:1"] > div:first-child > div {
    font-size: 18px !important;
    font-weight: 800 !important;
  }
  .pasien-header > div[style*="flex:1"] > div:first-child > span {
    padding: 3px 10px !important;
    font-size: 10px !important;
    border-radius: 12px !important;
  }
  .pasien-name {
    font-size: 17px !important;
    font-weight: 800 !important;
    margin-bottom: 4px !important;
  }
  .pasien-meta {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 6px 12px !important;
    margin-top: 6px !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }
  .pasien-meta span {
    display: flex !important;
    align-items: center !important;
    font-size: 11px !important;
    line-height: 1.3 !important;
    color: rgba(255, 255, 255, 0.85) !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
  }
  .pasien-meta span i {
    width: 14px !important;
    text-align: center !important;
    margin-right: 6px !important;
    flex-shrink: 0 !important;
    font-size: 11.5px !important;
    opacity: 0.9 !important;
  }
  .pasien-header > div[style*="gap:10px"],
  .pasien-header > div[style*="gap: 10px"] {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 6px !important;
    width: 100% !important;
    margin-top: 4px !important;
  }
  .pasien-header > div[style*="gap:10px"] > div,
  .pasien-header > div[style*="gap: 10px"] > div {
    min-width: 0 !important;
    padding: 6px 4px !important;
    border-radius: 8px !important;
    text-align: center !important;
  }
  .pasien-header > div[style*="gap:10px"] > div div:first-child,
  .pasien-header > div[style*="gap: 10px"] > div div:first-child {
    font-size: 8px !important;
    margin-bottom: 2px !important;
    letter-spacing: 0.1px !important;
  }
  .pasien-header > div[style*="gap:10px"] > div div:last-child,
  .pasien-header > div[style*="gap: 10px"] > div div:last-child {
    font-size: 11px !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
  }
  .page-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  .page-header .btn {
    width: 100%;
    justify-content: center;
  }

  /* Bidan Trimester Distribution Layout Grid */
  div[style*="grid-template-columns:180px 1fr"],
  div[style*="grid-template-columns: 180px 1fr"] {
    grid-template-columns: 1fr !important;
    justify-items: center;
    text-align: center;
    gap: 16px !important;
  }
  
  /* Keep trimester boxes in 3 columns on mobile */
  .card:has(#chartTrimester) div[style*="grid-template-columns:repeat(3,1fr)"],
  .card:has(#chartTrimester) div[style*="grid-template-columns: repeat(3,1fr)"] {
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 6px !important;
  }
  
  /* Make each trimester box compact */
  .card:has(#chartTrimester) div[style*="grid-template-columns:repeat(3,1fr)"] > div,
  .card:has(#chartTrimester) div[style*="grid-template-columns: repeat(3,1fr)"] > div {
    padding: 8px 4px !important;
    border-radius: 8px !important;
  }
  
  /* Trimester title */
  .card:has(#chartTrimester) div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:first-child,
  .card:has(#chartTrimester) div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:first-child {
    font-size: 8.5px !important;
    margin-bottom: 4px !important;
    letter-spacing: 0 !important;
  }
  
  /* Trimester value */
  .card:has(#chartTrimester) div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:nth-child(2),
  .card:has(#chartTrimester) div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:nth-child(2) {
    font-size: 18px !important;
  }
  
  /* Trimester percentage */
  .card:has(#chartTrimester) div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:nth-child(3),
  .card:has(#chartTrimester) div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:nth-child(3) {
    font-size: 9px !important;
    margin-top: 1px !important;
  }
  
  /* Trimester description tagline */
  .card:has(#chartTrimester) div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:last-child,
  .card:has(#chartTrimester) div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:last-child {
    font-size: 8px !important;
    margin-top: 2px !important;
    line-height: 1.1 !important;
  }

  /* Make Bidan trimester card header actions stack cleanly */
  .card:has(#chartTrimester) > div:first-child {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 8px !important;
  }
  
  /* Make legend list in Bidan trimester card look neat */
  .card:has(#chartTrimester) div[style*="display:flex"][style*="gap:12px"] {
    flex-wrap: wrap !important;
    gap: 8px !important;
    font-size: 10px !important;
  }

  /* Make chart wrapper smaller */
  div[style*="position:relative"][style*="width:180px"] {
    width: 130px !important;
    height: 130px !important;
    margin-bottom: 12px !important;
  }
  
  /* Center text inside smaller chart wrapper */
  div[style*="position:relative"][style*="width:180px"] div[style*="font-size:22px"] {
    font-size: 18px !important;
  }

  /* ─── TABS: Compact filter tabs (Semua / Menunggu Pemeriksaan / Sudah Diperiksa) ─── */
  .tabs {
    width: 100% !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
    white-space: nowrap !important;
    flex-wrap: nowrap !important;
    gap: 4px !important;
    padding: 3px !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
  }
  .tabs::-webkit-scrollbar {
    display: none !important;
  }
  .tab {
    flex-shrink: 0 !important;
    padding: 5px 10px !important;
    font-size: 11.5px !important;
    white-space: nowrap !important;
    gap: 4px !important;
  }
  .tab i {
    font-size: 10px !important;
  }
  /* Compact badge count inside tabs */
  .badge-count {
    min-width: 15px !important;
    height: 15px !important;
    font-size: 9px !important;
    padding: 0 3px !important;
    margin-left: 2px !important;
    vertical-align: middle !important;
    flex-shrink: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    line-height: 1 !important;
  }

  /* ─── CARD HEADER: Info data + sort dropdown satu baris ─── */
  .card-header {
    flex-wrap: nowrap !important;
    align-items: center !important;
    padding: 10px 14px !important;
    gap: 8px !important;
  }
  /* Biarkan info teks (title + subtitle) menyusut kalau perlu */
  .card-header > div:first-child {
    flex: 1 !important;
    min-width: 0 !important;
  }
  .card-title {
    font-size: 13px !important;
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: clip !important;
    line-height: 1.3 !important;
  }
  .card-subtitle {
    font-size: 11px !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    line-height: 1.3 !important;
  }
  .card-header form[method="GET"]:has(select) {
    flex-shrink: 0 !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 6px !important;
    width: auto !important;
    padding: 0 !important;
  }
  .card-header form[method="GET"]:has(select) select.form-control,
  .card-header form[method="GET"]:has(select) select {
    width: 110px !important;
    font-size: 11.5px !important;
    padding: 5px 8px !important;
    min-width: 0 !important;
  }
  .card > form#filter-form,
  .card > form[id^="filter-form"] {
    flex-direction: row !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
    padding: 10px 12px !important;
    align-items: center !important;
  }
  .card > form#filter-form > div,
  .card > form[id^="filter-form"] > div {
    flex: 1 !important;
    min-width: 120px !important;
  }
  /* Date filter box tidak lebih lebar dari perlu */
  .card > form#filter-form > div:first-of-type,
  .card > form[id^="filter-form"] > div:first-of-type {
    flex: 0 0 auto !important;
    min-width: 0 !important;
  }
  /* Reset button compact */
  .card > form#filter-form > a.btn,
  .card > form[id^="filter-form"] > a.btn {
    flex: 0 0 auto !important;
    width: auto !important;
    padding: 6px 10px !important;
    font-size: 11.5px !important;
  }

  /* ─── GENERIC STATS GRIDS: 2-kolom di mobile untuk inline repeat(3,1fr) ─── */
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:repeat(3,1fr)"],
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: repeat(3,1fr)"],
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:1fr 1fr 1fr"],
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: 1fr 1fr 1fr"] {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 10px !important;
  }
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:repeat(3,1fr)"] > :last-child:nth-child(odd),
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: repeat(3,1fr)"] > :last-child:nth-child(odd),
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:1fr 1fr 1fr"] > :last-child:nth-child(odd),
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: 1fr 1fr 1fr"] > :last-child:nth-child(odd) {
    grid-column: span 2 !important;
  }
  /* Sesuaikan spacing stat box generic agar pas di 2 kolom mobile */
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:repeat(3,1fr)"] > div,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: repeat(3,1fr)"] > div,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:1fr 1fr 1fr"] > div,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: 1fr 1fr 1fr"] > div {
    padding: 12px 14px !important;
    gap: 10px !important;
  }
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:first-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:first-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:1fr 1fr 1fr"] > div > div:first-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: 1fr 1fr 1fr"] > div > div:first-child {
    width: 36px !important;
    height: 36px !important;
    font-size: 14px !important;
    border-radius: 8px !important;
  }
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:nth-child(2) > div:first-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:nth-child(2) > div:first-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:1fr 1fr 1fr"] > div > div:nth-child(2) > div:first-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: 1fr 1fr 1fr"] > div > div:nth-child(2) > div:first-child {
    font-size: 18px !important;
  }
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:repeat(3,1fr)"] > div > div:nth-child(2) > div:last-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: repeat(3,1fr)"] > div > div:nth-child(2) > div:last-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns:1fr 1fr 1fr"] > div > div:nth-child(2) > div:last-child,
  div:not(.card:has(#chartTrimester) *) > div[style*="grid-template-columns: 1fr 1fr 1fr"] > div > div:nth-child(2) > div:last-child {
    font-size: 10.5px !important;
  }

  /* Dashboard bottom grid donut wrap — flex row on mobile (chart kiri, legend kanan) */
  .donut-wrap {
    flex-direction: row !important;
    align-items: center !important;
    padding: 12px 14px !important;
    gap: 14px !important;
  }
  .donut-canvas-wrap {
    width: 130px !important;
    height: 130px !important;
    flex-shrink: 0 !important;
    overflow: hidden !important;
  }
  .legend-list {
    flex: 1 !important;
    min-width: 0 !important;
  }
  .legend-row {
    gap: 5px !important;
  }
  .legend-label {
    font-size: 10.5px !important;
    white-space: normal !important;
    line-height: 1.3 !important;
  }
  .legend-val, .legend-pct {
    font-size: 10.5px !important;
    flex-shrink: 0 !important;
  }

  /* Page header title compact */
  .page-header-left h2 {
    font-size: 16px !important;
  }
  .page-header-left p {
    font-size: 11.5px !important;
    margin-top: 1px !important;
  }

  /* Section divider compact */
  .section-divider {
    font-size: 10.5px !important;
    padding: 0 14px !important;
    margin: 12px 0 0 !important;
  }

  /* Pagination compact — rata kanan */
  .pagination-wrapper {
    padding: 10px 12px !important;
    flex-wrap: wrap !important;
    gap: 4px !important;
    justify-content: flex-end !important;
  }
  .page-info {
    font-size: 11px !important;
    margin-right: auto !important;
    flex-shrink: 0 !important;
  }
  .alert {
    font-size: 12.5px !important;
    padding: 10px 12px !important;
  }
  .page-header {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 10px !important;
    margin-bottom: 14px !important;
  }
  .page-header > form,
  .page-header form[method="GET"] {
    width: 100% !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
  }
  .page-header form[method="GET"] select.form-control {
    flex: 1 !important;
    min-width: 0 !important;
    font-size: 12.5px !important;
    padding: 7px 10px !important;
  }
  .page-header form[method="GET"] button[type="submit"] {
    flex-shrink: 0 !important;
    font-size: 12px !important;
    padding: 7px 12px !important;
  }

  /* ─── LAPORAN: Navigation tab cards (Ringkasan / Ibu Hamil / Balita) ─── */
  div[style*="display:flex"][style*="gap:12px"][style*="margin-bottom:24px"],
  div[style*="display: flex"][style*="gap: 12px"][style*="margin-bottom: 24px"] {
    flex-direction: column !important;
    gap: 8px !important;
    margin-bottom: 14px !important;
  }
  div[style*="display:flex"][style*="gap:12px"][style*="margin-bottom:24px"] > a,
  div[style*="display: flex"][style*="gap: 12px"][style*="margin-bottom: 24px"] > a {
    padding: 12px 14px !important;
    border-radius: 10px !important;
    gap: 10px !important;
  }
  div[style*="display:flex"][style*="gap:12px"][style*="margin-bottom:24px"] > a > div > div:first-child,
  div[style*="display: flex"][style*="gap: 12px"][style*="margin-bottom: 24px"] > a > div > div:first-child {
    font-size: 13px !important;
  }
  div[style*="display:flex"][style*="gap:12px"][style*="margin-bottom:24px"] > a > div > div:last-child,
  div[style*="display: flex"][style*="gap: 12px"][style*="margin-bottom: 24px"] > a > div > div:last-child {
    font-size: 11px !important;
  }

  /* ─── LAPORAN DETAIL: Breadcrumb + action buttons row ─── */
  div[style*="align-items:center"][style*="gap:8px"][style*="margin-bottom:20px"][style*="flex-wrap:wrap"],
  div[style*="align-items: center"][style*="gap: 8px"][style*="margin-bottom: 20px"][style*="flex-wrap: wrap"] {
    flex-wrap: wrap !important;
    gap: 6px !important;
  }
  div[style*="margin-left:auto"][style*="display:flex"][style*="gap:8px"],
  div[style*="margin-left: auto"][style*="display: flex"][style*="gap: 8px"] {
    margin-left: 0 !important;
    width: 100% !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
  }
  div[style*="margin-left:auto"][style*="display:flex"][style*="gap:8px"] > a,
  div[style*="margin-left:auto"][style*="display:flex"][style*="gap:8px"] > button,
  div[style*="margin-left: auto"][style*="display: flex"][style*="gap: 8px"] > a,
  div[style*="margin-left: auto"][style*="display: flex"][style*="gap: 8px"] > button {
    flex: 1 !important;
    justify-content: center !important;
    font-size: 11.5px !important;
    padding: 6px 8px !important;
    min-width: 0 !important;
    white-space: nowrap !important;
  }

  /* ─── LAPORAN DETAIL: Filter form (bulan/tahun/cari/terapkan) ─── */
  form[style*="padding:16px 22px"] {
    flex-direction: column !important;
    gap: 10px !important;
    padding: 12px 14px !important;
    align-items: stretch !important;
  }
  form[style*="padding:16px 22px"] .form-group {
    margin: 0 !important;
    width: 100% !important;
  }
  form[style*="padding:16px 22px"] .form-control {
    width: 100% !important;
    font-size: 12.5px !important;
  }
  form[style*="padding:16px 22px"] .search-bar {
    width: 100% !important;
  }
  form[style*="padding:16px 22px"] button[type="submit"],
  form[style*="padding:16px 22px"] a.btn {
    width: 100% !important;
    justify-content: center !important;
    font-size: 12.5px !important;
  }

  /* ─── LAPORAN DETAIL: Stat cards (inline grid repeat(3,1fr) laporan) ─── */
  div[style*="grid-template-columns:repeat(3,1fr)"][style*="margin-bottom:20px"],
  div[style*="grid-template-columns: repeat(3,1fr)"][style*="margin-bottom:20px"] {
    grid-template-columns: 1fr 1fr !important;
    gap: 8px !important;
  }
  div[style*="grid-template-columns:repeat(3,1fr)"][style*="margin-bottom:20px"] > div,
  div[style*="grid-template-columns: repeat(3,1fr)"][style*="margin-bottom:20px"] > div {
    padding: 12px 14px !important;
    gap: 10px !important;
    border-radius: 10px !important;
  }
  div[style*="grid-template-columns:repeat(3,1fr)"][style*="margin-bottom:20px"] > div > div:first-child,
  div[style*="grid-template-columns: repeat(3,1fr)"][style*="margin-bottom:20px"] > div > div:first-child {
    width: 36px !important;
    height: 36px !important;
    font-size: 14px !important;
    border-radius: 8px !important;
    flex-shrink: 0 !important;
  }
  div[style*="grid-template-columns:repeat(3,1fr)"][style*="margin-bottom:20px"] > div > div:last-child > div:first-child,
  div[style*="grid-template-columns: repeat(3,1fr)"][style*="margin-bottom:20px"] > div > div:last-child > div:first-child {
    font-size: 20px !important;
  }
  div[style*="grid-template-columns:repeat(3,1fr)"][style*="margin-bottom:20px"] > div > div:last-child > div:last-child,
  div[style*="grid-template-columns: repeat(3,1fr)"][style*="margin-bottom:20px"] > div > div:last-child > div:last-child {
    font-size: 11px !important;
  }
  /* Last odd stat spans full 2 columns */
  div[style*="grid-template-columns:repeat(3,1fr)"][style*="margin-bottom:20px"] > :last-child:nth-child(odd),
  div[style*="grid-template-columns: repeat(3,1fr)"][style*="margin-bottom:20px"] > :last-child:nth-child(odd) {
    grid-column: span 2 !important;
  }

  /* ─── KELOLA PENGGUNA: Paksa 3 kolom sejajar di mobile ─── */
  .users-stats-wrap {
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 6px !important;
  }
  .users-stats-wrap > div {
    padding: 10px 6px !important;
    gap: 5px !important;
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
  }
  .users-stats-wrap > div > div:first-child {
    width: 30px !important;
    height: 30px !important;
    font-size: 13px !important;
    border-radius: 8px !important;
    flex-shrink: 0 !important;
    margin-bottom: 2px !important;
  }
  .users-stats-wrap > div > div:last-child > div:first-child {
    font-size: 16px !important;
    font-weight: 700 !important;
    line-height: 1.1 !important;
  }
  .users-stats-wrap > div > div:last-child > div:last-child {
    font-size: 9px !important;
    line-height: 1.3 !important;
    white-space: normal !important;
    word-break: break-word !important;
    color: var(--slate-500) !important;
    margin-top: 1px !important;
  }
  /* Override span-2 fallback untuk users-stats-wrap */
  .users-stats-wrap > :last-child:nth-child(odd) {
    grid-column: span 1 !important;
  }

  /* ─── CUSTOM MOBILE LAYOUTS ─── */
  
  /* 1. Header (card-header) alignment & data count positioning on mobile */
  .card-header {
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 10px 14px !important;
    gap: 8px !important;
  }
  .card-header > div:first-child {
    flex: 1 !important;
    min-width: 0 !important;
    text-align: left !important;
  }
  .card-header span[style*="data ditemukan"] {
    margin-left: auto !important;
    font-size: 11px !important;
    background: var(--slate-100) !important;
    color: var(--slate-600) !important;
    padding: 2px 8px !important;
    border-radius: 6px !important;
    flex-shrink: 0 !important;
    white-space: nowrap !important;
  }
  
  /* 2. Page topbar and actions spacing reduction on mobile */
  .page-topbar {
    margin-bottom: 12px !important;
    gap: 8px !important;
  }
  
  /* 3. Biodata: Convert 2-column or multi-column grids/flex to stacked vertical layout */
  div[style*="grid-template-columns:1fr 1fr"][style*="gap:16px"][style*="margin-bottom:16px"],
  div[style*="grid-template-columns: 1fr 1fr"][style*="gap: 16px"][style*="margin-bottom: 16px"] {
    grid-template-columns: 1fr !important;
    gap: 12px !important;
  }
  
  /* Target the 4-column inline grid in detail/laporan pages */
  div[style*="display:grid"][style*="grid-template-columns:repeat(4,1fr)"],
  div[style*="display: grid"][style*="grid-template-columns: repeat(4,1fr)"],
  div[style*="display:grid"][style*="grid-template-columns: repeat(4,1fr)"],
  div[style*="display: grid"][style*="grid-template-columns:repeat(4,1fr)"] {
    grid-template-columns: 1fr !important;
    gap: 12px !important;
    padding: 14px 16px !important;
  }
  div[style*="display:grid"][style*="grid-template-columns:repeat(4,1fr)"] > div,
  div[style*="display: grid"][style*="grid-template-columns: repeat(4,1fr)"] > div {
    grid-column: span 1 !important;
  }
  
  /* Target details horizontal rows (with labels) in detail view cards */
  div[style*="display:flex"][style*="gap:12px"][style*="padding:10px 0"],
  div[style*="display: flex"][style*="gap: 12px"][style*="padding: 10px 0"],
  div[style*="display:flex"][style*="gap:12px"][style*="padding:8px 0"],
  div[style*="display: flex"][style*="gap: 12px"][style*="padding: 8px 0"],
  div[style*="display:flex"][style*="align-items:flex-start"][style*="gap:10px"][style*="padding:10px 0"],
  div[style*="display: flex"][style*="align-items: flex-start"][style*="gap: 10px"][style*="padding: 10px 0"] {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 4px !important;
    padding: 8px 0 !important;
  }
  
  div[style*="display:flex"][style*="gap:12px"][style*="padding:10px 0"] > span[style*="width:"],
  div[style*="display: flex"][style*="gap: 12px"][style*="padding: 10px 0"] > span[style*="width:"],
  div[style*="display:flex"][style*="gap:12px"][style*="padding:8px 0"] > span[style*="width:"],
  div[style*="display: flex"][style*="gap: 12px"][style*="padding: 8px 0"] > span[style*="width:"],
  div[style*="display:flex"][style*="align-items:flex-start"][style*="gap:10px"][style*="padding:10px 0"] > span[style*="width:"],
  div[style*="display: flex"][style*="align-items: flex-start"][style*="gap: 10px"][style*="padding: 10px 0"] > span[style*="width:"] {
    width: auto !important;
    flex-shrink: 1 !important;
  }
  
  /* 4. Hide or turn vertical dividers to horizontal lines */
  div[style*="width:1.5px"][style*="background:var(--slate-100)"],
  div[style*="width:1.5px"][style*="background: var(--slate-100)"],
  div[style*="width:1.5px"][style*="background:var(--slate-200)"],
  div[style*="width:1.5px"][style*="background: var(--slate-200)"] {
    width: 100% !important;
    height: 1px !important;
    margin: 8px 0 !important;
  }

  /* 5. Riwayat Pemeriksaan section header badge formatting */
  div[style*="display:flex"][style*="justify-content:space-between"][style*="align-items:center"][style*="border-bottom:1px solid"] {
    padding: 10px 14px !important;
    gap: 8px !important;
  }
  div[style*="display:flex"][style*="justify-content:space-between"][style*="align-items:center"][style*="border-bottom:1px solid"] > div:first-child {
    flex: 1 !important;
    min-width: 0 !important;
  }
  div[style*="display:flex"][style*="justify-content:space-between"][style*="align-items:center"][style*="border-bottom:1px solid"] > span {
    font-size: 10.5px !important;
    padding: 2px 8px !important;
    flex-shrink: 0 !important;
  }
  
  /* 6. Proportional PDF and Navigation buttons on mobile */
  div[style*="margin-left:auto"]:has(button[onclick="cetakPDF()"]),
  div[style*="margin-left: auto"]:has(button[onclick="cetakPDF()"]) {
    margin-left: 0 !important;
    width: 100% !important;
    margin-top: 8px !important;
  }
  div[style*="margin-left:auto"] button[onclick="cetakPDF()"],
  div[style*="margin-left: auto"] button[onclick="cetakPDF()"] {
    width: 100% !important;
    justify-content: center !important;
    padding: 8px 16px !important;
    font-size: 13px !important;
  }

  /* ─── RESPONSIVE TABLE: mobile-list / table-scroll swap ─── */
  .rt-wrap .table-scroll  { display: block !important; }
  .rt-wrap .mobile-list   { display: none !important; }

  /* ─── NEW MOBILE 2-COLUMN TABLE LAYOUT ─── */
  .col-hide-mobile {
    display: none !important;
  }
  
  .col-nama-data {
    display: table-cell !important;
    text-align: left !important;
  }
  
  th.col-nama-data {
    font-size: 0 !important;
  }
  th.col-nama-data::after {
    content: "Nama Data";
    font-size: 11.5px !important;
    font-weight: 700;
    color: var(--slate-500);
    text-transform: uppercase;
    letter-spacing: .6px;
  }
  
  .col-aksi {
    display: table-cell !important;
    text-align: center !important;
  }

  .rt-wrap .data-table {
    min-width: 100% !important;
    width: 100% !important;
  }
}

@media (max-width: 480px) {
  #category-options {
    grid-template-columns: 1fr !important;
  }
  div[style*="grid-template-columns:1fr 1fr 1fr"],
  div[style*="grid-template-columns:1fr 1fr 1fr;"],
  div[style*="grid-template-columns: 1fr 1fr 1fr"] {
    grid-template-columns: 1fr !important;
    gap: 8px !important;
  }
}

/* ===== GLOBAL MOBILE CARD LIST (rt-wrap pattern) ===== */
.mobile-list { display: none; }
.rec-card {
  background: #fff; border: 1.5px solid var(--slate-200); border-radius: 14px;
  padding: 14px 16px; margin-bottom: 10px;
}
.rec-card-header {
  display: flex; align-items: flex-start; justify-content: space-between;
  gap: 8px; margin-bottom: 10px;
}
.rec-name   { font-weight: 700; font-size: 14px; color: var(--slate-800); }
.rec-sub    { font-size: 11px; color: var(--slate-400); margin-top: 2px; }
.rec-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 8px 12px;
  font-size: 12px; color: var(--slate-700);
}
.rec-field label {
  display: block; font-size: 10px; font-weight: 600; color: var(--slate-400);
  text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px;
}
.rec-field .val { font-weight: 600; }
.rec-divider { border: none; border-top: 1px solid var(--slate-100); margin: 10px 0; }
.rec-footer  { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
.rec-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.no-badge {
  font-size: 10px; color: var(--slate-400); font-weight: 600;
  background: var(--slate-100); border-radius: 6px; padding: 2px 8px; flex-shrink: 0;
}


@media print {
  html, body {
    display: block !important;
    background: #ffffff !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    min-height: unset !important;
    overflow: visible !important;
  }

  .sidebar,
  .sidebar-overlay,
  .topnav,
  .alert,
  .btn {
    display: none !important;
  }

  .main {
    display: block !important;
    margin-left: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    min-height: unset !important;
    flex: unset !important;
  }

  .content {
    display: block !important;
    max-width: 100% !important;
    width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
    flex: unset !important;
  }
}
</style>
@stack('styles')
</head>
<body>

@include('layouts.sidebar')

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar(event)"></div>

<div class="main">
  @include('layouts.navbar')
  <div class="content">
      @if(session('success'))
        <div class="alert alert-success" id="flash-success">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger" id="flash-error">
          <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
      @endif
    @yield('content')
  </div>
</div>

<script>
  ['flash-success', 'flash-error'].forEach(function(id) {
    var el = document.getElementById(id);
    if (el) setTimeout(function() {
      el.style.transition = 'opacity 0.5s ease';
      el.style.opacity = '0';
      setTimeout(function() { el.remove(); }, 500);
    }, 10000);
  });
</script>

<script>
function toggleSidebar(e) {
  if (e) e.stopPropagation();
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const body = document.body;
  const html = document.documentElement;

  if (sidebar) {
    sidebar.classList.toggle('active');
    const isActive = sidebar.classList.contains('active');
    if (overlay) overlay.classList.toggle('active', isActive);

    if (isActive) {
      body.classList.add('sidebar-open');
      html.classList.add('sidebar-open');
    } else {
      body.classList.remove('sidebar-open');
      html.classList.remove('sidebar-open');
    }
  }
}

document.addEventListener('click', function(e) {
  const sidebar = document.querySelector('.sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  const overlay = document.getElementById('sidebarOverlay');
  const body = document.body;
  const html = document.documentElement;

  if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('active')) {
    if (!sidebar.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target))) {
      sidebar.classList.remove('active');
      if (overlay) overlay.classList.remove('active');
      body.classList.remove('sidebar-open');
      html.classList.remove('sidebar-open');
    }
  }
});
</script>

{{-- GLOBAL DETAIL MODAL --}}
<div id="globalDetailModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;flex-direction:column;">
  <div style="position:absolute;inset:0;background:rgba(15,23,42,.55);backdrop-filter:blur(4px);" onclick="closeGlobalDetailModal()"></div>
  
  <div style="position:relative;z-index:1;margin:20px 20px 0;width:calc(100% - 40px);max-width:500px;background:linear-gradient(135deg,#0f766e,#14a398);border-radius:20px 20px 0 0;padding:24px 24px 16px;color:#fff;animation:modalIn .22s ease;">
    <h3 id="globalDetailTitle" style="font-size:18px;font-weight:700;margin-bottom:4px;color:#fff;">Detail Data</h3>
    <p id="globalDetailSubtitle" style="font-size:12px;opacity:.8;margin:0;">Informasi lengkap data terdaftar</p>
  </div>

  <div style="position:relative;z-index:1;margin:0 20px 20px;width:calc(100% - 40px);max-width:500px;background:#fff;border-radius:0 0 20px 20px;padding:20px 24px 24px;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:modalIn .22s ease;max-height:65vh;overflow-y:auto;">
    <div id="globalDetailContent" style="display:flex;flex-direction:column;gap:4px;">
      <!-- Content populated by JS -->
    </div>
    <div style="margin-top:20px;text-align:right;">
      <button onclick="closeGlobalDetailModal()" class="btn btn-outline" style="width:100%;justify-content:center;">
        <i class="fas fa-times"></i> Tutup
      </button>
    </div>
  </div>
</div>

<script>
function showGlobalDetailModal(title, details) {
  document.getElementById('globalDetailTitle').textContent = title;
  const content = document.getElementById('globalDetailContent');
  content.innerHTML = '';
  
  for (const [key, value] of Object.entries(details)) {
    const row = document.createElement('div');
    row.style.display = 'flex';
    row.style.gap = '12px';
    row.style.padding = '10px 0';
    row.style.borderBottom = '1px solid #f1f5f9';
    
    const labelSpan = document.createElement('span');
    labelSpan.style.fontSize = '12px';
    labelSpan.style.color = '#94a3b8';
    labelSpan.style.width = '130px';
    labelSpan.style.flexShrink = '0';
    labelSpan.textContent = key;
    
    const valSpan = document.createElement('span');
    valSpan.style.fontSize = '13.5px';
    valSpan.style.fontWeight = '600';
    valSpan.style.color = '#334155';
    valSpan.style.flex = '1';
    valSpan.style.wordBreak = 'break-word';
    valSpan.innerHTML = value !== null && value !== undefined && value !== '' ? value : '-';
    
    row.appendChild(labelSpan);
    row.appendChild(valSpan);
    content.appendChild(row);
  }
  
  document.getElementById('globalDetailModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function handleDetail(event, title, details) {
  if (window.innerWidth <= 768) {
    event.preventDefault();
    showGlobalDetailModal(title, details);
  }
}

function closeGlobalDetailModal() {
  document.getElementById('globalDetailModal').style.display = 'none';
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeGlobalDetailModal();
});
</script>

@stack('scripts')
</body>
</html>