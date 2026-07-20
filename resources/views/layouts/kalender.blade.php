@extends('layouts.app')

@section('title', 'Kalender')

@section('content')
<div id="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
  <div id="modal-box" style="background:#fff; border-radius:20px; padding:32px; width:100%; max-width:440px; margin:16px; box-shadow:0 24px 60px rgba(0,0,0,0.18); transform:translateY(20px); opacity:0; transition:all 0.25s cubic-bezier(.34,1.56,.64,1);">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
      <div>
        <div style="font-size:18px; font-weight:700; color:#0f172a; font-family:'Plus Jakarta Sans',sans-serif;">Tambah Jadwal</div>
        <div id="modal-date-label" style="font-size:13px; color:#64748b; margin-top:2px;"></div>
      </div>
      <button onclick="closeModal()" style="width:32px;height:32px;border-radius:50%;border:none;background:#f1f5f9;cursor:pointer;font-size:16px;color:#64748b;display:flex;align-items:center;justify-content:center;">×</button>
    </div>

    <div style="margin-bottom:16px;">
      <label style="font-size:12px;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:8px;">Nama Kegiatan</label>
      <input id="modal-title" type="text" placeholder="cth: Pemeriksaan Balita..."
        style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#0f172a;outline:none;transition:border .2s;box-sizing:border-box;"
        onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#e2e8f0'"
        onkeydown="if(event.key==='Enter') saveEvent()" />
    </div>

    <div style="margin-bottom:24px;">
      <label style="font-size:12px;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:10px;">Kategori</label>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;" id="category-options">
        <div class="cat-option selected" data-color="#0d9488" onclick="selectCategory(this)" style="padding:10px 12px;border-radius:10px;border:2px solid #0d9488;background:#f0fdfa;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .15s;">
          <span style="width:10px;height:10px;border-radius:50%;background:#0d9488;flex-shrink:0;"></span>
          <span style="font-size:13px;font-weight:500;color:#0f172a;">Pemeriksaan</span>
        </div>
        <div class="cat-option" data-color="#f59e0b" onclick="selectCategory(this)" style="padding:10px 12px;border-radius:10px;border:2px solid #e2e8f0;background:#fff;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .15s;">
          <span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></span>
          <span style="font-size:13px;font-weight:500;color:#0f172a;">Ibu Hamil</span>
        </div>
        <div class="cat-option" data-color="#3b82f6" onclick="selectCategory(this)" style="padding:10px 12px;border-radius:10px;border:2px solid #e2e8f0;background:#fff;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .15s;">
          <span style="width:10px;height:10px;border-radius:50%;background:#3b82f6;flex-shrink:0;"></span>
          <span style="font-size:13px;font-weight:500;color:#0f172a;">Imunisasi</span>
        </div>
        <div class="cat-option" data-color="#8b5cf6" onclick="selectCategory(this)" style="padding:10px 12px;border-radius:10px;border:2px solid #e2e8f0;background:#fff;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .15s;">
          <span style="width:10px;height:10px;border-radius:50%;background:#8b5cf6;flex-shrink:0;"></span>
          <span style="font-size:13px;font-weight:500;color:#0f172a;">Penyuluhan</span>
        </div>
      </div>
    </div>

    <div style="display:flex;gap:10px;">
      <button onclick="closeModal()" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:14px;font-weight:600;cursor:pointer;">Batal</button>
      <button onclick="saveEvent()" style="flex:2;padding:11px;border-radius:10px;border:none;background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;font-size:14px;font-weight:600;cursor:pointer;box-shadow:0 4px 12px rgba(13,148,136,.35);">Simpan Jadwal</button>
    </div>
  </div>
</div>

<div id="delete-overlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
  <div id="delete-box" style="background:#fff; border-radius:20px; padding:28px; width:100%; max-width:360px; margin:16px; box-shadow:0 24px 60px rgba(0,0,0,0.18); transform:translateY(20px); opacity:0; transition:all 0.25s cubic-bezier(.34,1.56,.64,1); text-align:center;">
    <div style="width:52px;height:52px;border-radius:50%;background:#fef2f2;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:22px;">🗑️</div>
    <div style="font-size:16px;font-weight:700;color:#0f172a;margin-bottom:8px;">Hapus Jadwal?</div>
    <div id="delete-title-label" style="font-size:14px;color:#64748b;margin-bottom:24px;"></div>
    <div style="display:flex;gap:10px;">
      <button onclick="closeDeleteModal()" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:14px;font-weight:600;cursor:pointer;">Batal</button>
      <button onclick="confirmDelete()" style="flex:1;padding:11px;border-radius:10px;border:none;background:#ef4444;color:#fff;font-size:14px;font-weight:600;cursor:pointer;">Hapus</button>
    </div>
  </div>
</div>

<div style="background:#fff; border-radius:20px; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04); overflow:hidden;">
  <div style="padding:20px 24px 0; border-bottom:1px solid #f1f5f9;">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;padding-bottom:16px;">
      <div style="display:flex;align-items:center;gap:12px;">
        <button onclick="history.back()" style="width:34px;height:34px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;font-size:15px;transition:all .15s;" onmouseover="this.style.background='#f1f5f9';this.style.borderColor='#cbd5e1'" onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
          <i class="fas fa-arrow-left"></i>
        </button>
        <div>
          <div style="font-size:17px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Kalender</div>
          <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Klik tanggal untuk tambah • Klik event untuk hapus</div>
        </div>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#0d9488;display:inline-block;"></span>Pemeriksaan</div>
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>Ibu Hamil</div>
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#3b82f6;display:inline-block;"></span>Imunisasi</div>
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#8b5cf6;display:inline-block;"></span>Penyuluhan</div>
      </div>
    </div>
  </div>
  <div style="padding:20px 24px 24px;">
    <div id="calendar"></div>
  </div>
</div>

@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<style>
  * { font-family: 'Plus Jakarta Sans', sans-serif; }
  .fc-header-toolbar {
    margin-bottom: 18px !important;
    align-items: center !important;
  }
  .fc-toolbar-title {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    letter-spacing: -.3px;
  }
  .fc-button, .fc-button-primary {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 9px !important;
    padding: 6px 14px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #374151 !important;
    box-shadow: none !important;
    transition: all .15s !important;
  }
  .fc-button:hover, .fc-button-primary:hover {
    background: #f1f5f9 !important;
    border-color: #cbd5e1 !important;
    color: #0f172a !important;
  }
  .fc-button-active, .fc-button-primary:not(:disabled).fc-button-active {
    background: linear-gradient(135deg, #0d9488, #0f766e) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 3px 10px rgba(13,148,136,.3) !important;
  }
  .fc-prev-button, .fc-next-button {
    width: 34px !important;
    padding: 6px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
  }
  .fc-today-button {
    background: #0f172a !important;
    border-color: #0f172a !important;
    color: #fff !important;
  }
  .fc-today-button:hover {
    background: #1e293b !important;
    border-color: #1e293b !important;
    color: #fff !important;
  }
  .fc-scrollgrid { border: none !important; }
  .fc-scrollgrid-sync-table { border: none !important; }
  .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9 !important; }
  .fc-col-header-cell {
    padding: 10px 0 !important;
    background: #f8fafc !important;
  }
  .fc-col-header-cell-cushion {
    font-size: 12px !important;
    font-weight: 700 !important;
    color: #94a3b8 !important;
    text-transform: uppercase !important;
    letter-spacing: .6px !important;
    text-decoration: none !important;
  }
  .fc-daygrid-day-number {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #475569 !important;
    padding: 8px 10px !important;
    text-decoration: none !important;
  }
  .fc-day-other .fc-daygrid-day-number { color: #cbd5e1 !important; }
  .fc-day-today {
    background: rgba(13,148,136,.06) !important;
  }
  .fc-day-today .fc-daygrid-day-number {
    background: #0d9488 !important;
    color: #fff !important;
    border-radius: 50% !important;
    width: 28px !important;
    height: 28px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 !important;
    margin: 6px !important;
  }
  .fc-daygrid-day:hover {
    background: rgba(13,148,136,.04) !important;
    cursor: pointer;
  }
  .fc-event {
    border: none !important;
    border-radius: 6px !important;
    padding: 3px 8px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    transition: opacity .15s, transform .15s !important;
    display: flex !important;
    align-items: center !important;
    gap: 4px !important;
  }
  .fc-event:hover {
    opacity: .85 !important;
    transform: scale(1.01) !important;
  }
  .fc-event-title { font-weight: 600 !important; }
  .fc-daygrid-event-harness { margin-bottom: 2px !important; }
  .fc-scroller { scrollbar-width: none; }
  .fc-scroller::-webkit-scrollbar { display: none; }
  .cat-option.selected {
    border-color: var(--sel-color, #0d9488) !important;
    background: color-mix(in srgb, var(--sel-color, #0d9488) 8%, #fff) !important;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
(function () {
  let calendar;
  let selectedDate = null;
  let selectedColor = '#0d9488';
  let eventToDelete = null;

  const STORAGE_KEY = 'posyandu_events';

  function loadEvents() {
    try {
      return JSON.parse(localStorage.getItem(STORAGE_KEY)) || defaultEvents();
    } catch { return defaultEvents(); }
  }

  function saveEvents() {
    const all = calendar.getEvents().map(e => ({
      id: e.id,
      title: e.title,
      start: e.startStr,
      color: e.backgroundColor
    }));
    localStorage.setItem(STORAGE_KEY, JSON.stringify(all));
  }

  function defaultEvents() {
    return [
      { id: uid(), title: 'Pemeriksaan Balita', start: '2026-05-05', color: '#0d9488' },
      { id: uid(), title: 'Posyandu Ibu Hamil',  start: '2026-05-10', color: '#f59e0b' }
    ];
  }

  function uid() {
    return Math.random().toString(36).slice(2, 10);
  }

  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'id',
      initialView: 'dayGridMonth',
      height: 'auto',

      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },

      buttonText: {
        today: 'Hari Ini',
        month: 'Bulan'
      },

      events: loadEvents(),

      dayMaxEvents: true,
      eventDisplay: 'block',

      dateClick: function (info) {
        openModal(info.dateStr);
      },

      eventClick: function (info) {
        info.jsEvent.stopPropagation();
        openDeleteModal(info.event);
      },

      eventDidMount: function (info) {
        const dot = document.createElement('span');
        dot.style.cssText = 'width:5px;height:5px;border-radius:50%;background:rgba(255,255,255,.7);flex-shrink:0;';
        info.el.querySelector('.fc-event-title') &&
          info.el.prepend(dot);
      }
    });

    calendar.render();
  });

  window.openModal = function (dateStr) {
    selectedDate = dateStr;
    const d = new Date(dateStr + 'T00:00:00');
    document.getElementById('modal-date-label').textContent =
      d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    document.getElementById('modal-title').value = '';

    selectedColor = '#0d9488';
    document.querySelectorAll('.cat-option').forEach(el => {
      el.classList.remove('selected');
      el.style.borderColor = '#e2e8f0';
      el.style.background = '#fff';
    });
    const first = document.querySelector('.cat-option');
    if (first) { first.classList.add('selected'); first.style.borderColor = '#0d9488'; first.style.background = '#f0fdfa'; }

    const overlay = document.getElementById('modal-overlay');
    const box     = document.getElementById('modal-box');
    overlay.style.display = 'flex';
    requestAnimationFrame(() => {
      box.style.opacity = '1';
      box.style.transform = 'translateY(0)';
    });
    setTimeout(() => document.getElementById('modal-title').focus(), 200);
  };

  window.closeModal = function () {
    const overlay = document.getElementById('modal-overlay');
    const box     = document.getElementById('modal-box');
    box.style.opacity = '0';
    box.style.transform = 'translateY(20px)';
    setTimeout(() => { overlay.style.display = 'none'; }, 220);
  };

  window.selectCategory = function (el) {
    selectedColor = el.dataset.color;
    document.querySelectorAll('.cat-option').forEach(opt => {
      opt.classList.remove('selected');
      opt.style.borderColor = '#e2e8f0';
      opt.style.background = '#fff';
    });
    el.classList.add('selected');
    el.style.borderColor = selectedColor;
    el.style.background = hexToRgba(selectedColor, 0.08);
  };

  window.saveEvent = function () {
    const title = document.getElementById('modal-title').value.trim();
    if (!title) {
      const input = document.getElementById('modal-title');
      input.style.borderColor = '#ef4444';
      input.focus();
      setTimeout(() => input.style.borderColor = '#e2e8f0', 1500);
      return;
    }
    calendar.addEvent({
      id: uid(),
      title: title,
      start: selectedDate,
      color: selectedColor
    });
    saveEvents();
    closeModal();
  };

  window.openDeleteModal = function (event) {
    eventToDelete = event;
    document.getElementById('delete-title-label').textContent = '"' + event.title + '"';

    const overlay = document.getElementById('delete-overlay');
    const box     = document.getElementById('delete-box');
    overlay.style.display = 'flex';
    requestAnimationFrame(() => {
      box.style.opacity = '1';
      box.style.transform = 'translateY(0)';
    });
  };

  window.closeDeleteModal = function () {
    const overlay = document.getElementById('delete-overlay');
    const box     = document.getElementById('delete-box');
    box.style.opacity = '0';
    box.style.transform = 'translateY(20px)';
    setTimeout(() => { overlay.style.display = 'none'; eventToDelete = null; }, 220);
  };

  window.confirmDelete = function () {
    if (eventToDelete) {
      eventToDelete.remove();
      saveEvents();
    }
    closeDeleteModal();
  };

  document.getElementById('modal-overlay').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
  });
  document.getElementById('delete-overlay').addEventListener('click', function (e) {
    if (e.target === this) closeDeleteModal();
  });

  function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1,3),16);
    const g = parseInt(hex.slice(3,5),16);
    const b = parseInt(hex.slice(5,7),16);
    return `rgba(${r},${g},${b},${alpha})`;
  }

})();
</script>
@endpush