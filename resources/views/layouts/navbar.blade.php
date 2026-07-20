<header class="topnav">
  <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar(event)">
    <i class="fas fa-bars"></i>
  </button>

  <div class="topnav-brand">
    <img src="{{ asset('images/LOGO_POSYANDU.png') }}" alt="Logo" class="topnav-brand-logo">
    <div class="topnav-brand-text">
      <span class="topnav-brand-name">Posyandu</span>
      <span class="topnav-brand-accent">Melati 2</span>
    </div>
    <span class="topnav-brand-divider"></span>
    <span class="topnav-brand-tagline">Sistem Informasi Pencatatan Data Ibu Hamil dan Balita</span>
  </div>

  <div class="search-bar-wrapper" id="topnavSearch" style="width:260px;position:relative;">
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Cari nama / NIK…" id="globalSearch" autocomplete="off">
      <button type="button" class="search-close-btn" id="searchCloseBtn" onclick="toggleMobileSearch(event)" style="display:none;">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="gs-dropdown" id="gsDropdown"></div>
  </div>

  <div class="topnav-actions">
    <button class="icon-btn mobile-search-toggle" id="mobileSearchToggle" onclick="toggleMobileSearch(event)" title="Cari" style="display:none;">
      <i class="fas fa-search"></i>
    </button>

    <div class="icon-btn" title="Notifikasi" style="position:relative;" id="notif-btn" onclick="toggleNotif(event)">
      <i class="fas fa-bell"></i>
      <div class="notif-dot" id="notif-dot" style="display:none;"></div>
      <span class="notif-badge" id="notif-badge" style="display:none;"></span>
    </div>

    <div class="notif-dropdown" id="notif-dropdown">
      <div class="notif-header" style="display:flex;align-items:center;justify-content:space-between;gap:8px;padding:12px 16px;border-bottom:1.5px solid #f1f5f9;">
        <div style="display:flex;flex-direction:column;">
          <span style="font-size:14px;font-weight:700;color:#1e293b;">Notifikasi</span>
          <span id="notif-count-label" style="font-size:11px;color:#94a3b8;"></span>
        </div>
        <button id="mark-all-read-btn" onclick="markAllRead(event)" style="background:none;border:none;color:#0f8075;font-size:11px;font-weight:700;cursor:pointer;padding:4px 8px;border-radius:6px;transition:background 0.15s;display:none;">
          Tandai Semua Dibaca
        </button>
      </div>
      <div id="notif-list">
        <div class="notif-empty">
          <i class="fas fa-bell-slash"></i>
          <div>Tidak ada notifikasi</div>
        </div>
      </div>
    </div>

    <a href="{{ route('kalender') }}" class="icon-btn" title="Kalender">
      <i class="fas fa-calendar-alt"></i>
    </a>
  </div>
</header>

<style>
/* ── Topnav shell ── */
.topnav {
  background: #fff;
  padding: 0 32px;
  height: 64px;
  display: flex;
  align-items: center;
  gap: 20px;
  border-bottom: 1.5px solid #e9f0ef;
  position: sticky;
  top: 0;
  z-index: 50;
}

/* ── Brand kiri ── */
.topnav-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  flex: 1;
  min-width: 0;
}

.topnav-brand-icon {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  background: linear-gradient(135deg, #0f8075, #14a398);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.topnav-brand-icon i {
  font-size: 15px;
  color: #fff;
}

.topnav-brand-text {
  display: flex;
  align-items: baseline;
  gap: 4px;
  flex-shrink: 0;
}
.topnav-brand-name {
  font-size: 14px;
  font-weight: 600;
  color: #334155;
  letter-spacing: -.01em;
}
.topnav-brand-accent {
  font-size: 14px;
  font-weight: 800;
  color: #0f8075;
  letter-spacing: -.02em;
}

.topnav-brand-divider {
  width: 1px;
  height: 18px;
  background: #e2e8f0;
  flex-shrink: 0;
}
.topnav-brand-tagline {
  font-size: 11.5px;
  color: #94a3b8;
  font-weight: 500;
  letter-spacing: .01em;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* ── Kanan: search, notif, calendar — tidak diubah ── */
.topnav-actions { display:flex; align-items:center; gap:8px; position:relative; }
.icon-btn { width:38px; height:38px; border-radius:8px; background:#f1f5f9; border:1.5px solid #e2e8f0; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b; font-size:15px; position:relative; transition:all .2s; text-decoration:none; }
.icon-btn:hover { background:#edfaf9; border-color:#5dd8cd; color:#0f8075; }
.notif-dot { width:8px; height:8px; background:#f43f5e; border-radius:50%; position:absolute; top:5px; right:5px; border:2px solid #fff; }
.notif-badge { position:absolute; top:-4px; right:-4px; background:#f43f5e; color:#fff; font-size:10px; font-weight:700; border-radius:20px; padding:1px 5px; border:2px solid #fff; min-width:18px; text-align:center; line-height:14px; }
.search-bar { display:flex; align-items:center; gap:8px; background:#f1f5f9; border:1.5px solid #e2e8f0; border-radius:12px; padding:8px 14px; transition:border-color .2s; }
.search-bar:focus-within { border-color:#2ec4b6; }
.search-bar input { border:none; background:transparent; font-family:'DM Sans',sans-serif; font-size:13px; color:#334155; outline:none; width:100%; }
.search-bar input::placeholder { color:#94a3b8; }
.search-bar i { color:#94a3b8; font-size:13px; }
.notif-dropdown { display:none; position:absolute; top:48px; right:46px; width:340px; background:#fff; border-radius:14px; box-shadow:0 8px 32px rgba(0,0,0,.14); border:1.5px solid #e2e8f0; z-index:999; overflow:hidden; }
.notif-dropdown.open { display:block; animation:fadeSlideIn .18s ease; }
.notif-item { display:flex; align-items:flex-start; gap:12px; padding:12px 16px; border-bottom:1px solid #f1f5f9; transition:background .15s; cursor:pointer; }
.notif-item.unread { background:#f0fdf4; }
.notif-item.unread:hover { background:#dcfce7; }
.notif-item.read { background:#fff; }
.notif-item.read:hover { background:#f8fafc; }
.notif-item:last-child { border-bottom:none; }
.notif-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }
.notif-title { font-size:12px; font-weight:700; color:#1e293b; }
.notif-desc { font-size:11.5px; color:#64748b; line-height:1.4; margin-top:2px; }
.notif-time { font-size:10px; color:#94a3b8; margin-top:3px; }
.notif-action-btn:hover { text-decoration:underline !important; }
.notif-empty { padding:32px 16px; text-align:center; color:#94a3b8; font-size:13px; display:flex; flex-direction:column; align-items:center; gap:8px; }
.notif-empty i { font-size:28px; opacity:.4; }
.notif-list-scroll { max-height:380px; overflow-y:auto; }
@keyframes fadeSlideIn { from{opacity:0;transform:translateY(8px);} to{opacity:1;transform:translateY(0);} }

/* ── Sidebar toggle (mobile) ── */
.sidebar-toggle { display:none; background:none; border:none; color:#64748b; font-size:18px; cursor:pointer; padding:8px; border-radius:8px; transition:background .2s; }
.sidebar-toggle:hover { background:#f1f5f9; color:#0f8075; }

.topnav-brand-logo {
  width: 30px;
  height: 30px;
  object-fit: contain;
  border-radius: 50%;
  flex-shrink: 0;
  display: block;
}

@media (max-width: 768px) {
  .topnav {
    padding: 0 16px;
    gap: 12px;
  }
  .sidebar-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    padding: 6px;
  }
  
  .topnav-brand-name,
  .topnav-brand-accent {
    font-size: 13.5px;
  }

  .topnav-brand-divider,
  .topnav-brand-tagline {
    display: none !important;
  }

  .search-bar {
    position: absolute;
    top: 50%;
    left: 12px;
    right: 12px;
    transform: translateY(-50%);
    width: auto !important;
    background: #fff;
    z-index: 110;
    display: none;
    align-items: center;
    justify-content: space-between;
    height: 44px;
    border-radius: 10px;
    border: 1.5px solid #0f8075;
    padding: 0 14px;
    box-shadow: 0 4px 12px rgba(15, 128, 117, 0.15);
  }
  .search-bar.active {
    display: flex !important;
    animation: fadeSlideIn 0.15s ease;
  }
  .search-bar input {
    display: block !important;
    flex: 1;
    font-size: 14px;
    padding: 4px 8px;
    background: transparent;
  }
  .search-close-btn {
    display: flex !important;
    background: none;
    border: none;
    color: #64748b;
    font-size: 16px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    padding: 4px;
    transition: color 0.15s;
  }
  .search-close-btn:hover {
    color: #f43f5e;
  }

  .mobile-search-toggle {
    display: flex !important;
  }

  .topnav-actions {
    gap: 8px !important;
  }
  .icon-btn {
    width: 36px !important;
    height: 36px !important;
    font-size: 14px !important;
    border-radius: 8px !important;
  }

  .notif-dropdown {
    right: -40px;
    width: calc(100vw - 32px);
    max-width: 320px;
    top: 48px;
  }
}

@media (max-width: 480px) {
  .topnav {
    padding: 0 12px;
    gap: 8px;
  }
  .topnav-brand-name,
  .topnav-brand-accent {
    font-size: 12.5px;
  }
  .topnav-brand-logo {
    width: 26px;
    height: 26px;
  }
  .topnav-actions {
    gap: 6px !important;
  }
  .icon-btn {
    width: 34px !important;
    height: 34px !important;
    font-size: 13.5px !important;
  }
}

/* ── Search wrapper (mobile override) ── */
@media (max-width: 768px) {
  .search-bar-wrapper {
    position: absolute !important;
    top: 50% !important;
    left: 12px !important;
    right: 12px !important;
    transform: translateY(-50%) !important;
    width: auto !important;
    z-index: 110 !important;
    display: none;
  }
  .search-bar-wrapper.active {
    display: block !important;
    animation: fadeSlideIn 0.15s ease;
  }
  .search-bar-wrapper .search-bar {
    background: #fff;
    border: 1.5px solid #0f8075;
    padding: 0 14px;
    height: 44px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(15, 128, 117, 0.15);
    display: flex;
    align-items: center;
  }
  .search-bar-wrapper .search-bar input {
    display: block !important;
    flex: 1;
    font-size: 14px;
    padding: 4px 8px;
    background: transparent;
  }
  .search-bar-wrapper .search-close-btn {
    display: flex !important;
    background: none;
    border: none;
    color: #64748b;
    font-size: 16px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    padding: 4px;
    transition: color 0.15s;
  }
  .search-bar-wrapper .search-close-btn:hover { color: #f43f5e; }
}

/* ── Global Search Dropdown ── */
.gs-dropdown {
  display: none;
  position: absolute;
  top: calc(100% + 6px);
  left: 0;
  right: 0;
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: 14px;
  box-shadow: 0 8px 32px rgba(0,0,0,.12);
  z-index: 9999;
  overflow: hidden;
  max-height: 420px;
  overflow-y: auto;
}
.gs-dropdown.open { display: block; animation: fadeSlideIn .18s ease; }
.gs-group-title {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #2ec4b6;
  padding: 10px 14px 4px;
  background: #f8fafc;
  border-bottom: 1px solid #f1f5f9;
}
.gs-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 14px;
  cursor: pointer;
  text-decoration: none;
  border-bottom: 1px solid #f8fafc;
  transition: background .13s;
}
.gs-item:last-child { border-bottom: none; }
.gs-item:hover { background: #edfaf9; }
.gs-item-icon {
  width: 30px;
  height: 30px;
  border-radius: 8px;
  background: #e6f7f6;
  color: #0f8075;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  flex-shrink: 0;
}
.gs-item-text { flex: 1; min-width: 0; }
.gs-item-label { font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.gs-item-sub { font-size: 11px; color: #94a3b8; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.gs-empty { padding: 20px 14px; text-align: center; font-size: 13px; color: #94a3b8; }

</style>

<script>
let notifOpen = false;

function toggleNotif(e) {
  e.stopPropagation();
  notifOpen = !notifOpen;
  document.getElementById('notif-dropdown').classList.toggle('open', notifOpen);
  if (notifOpen) fetchNotif();
}

function toggleMobileSearch(e) {
  if (e) e.stopPropagation();
  const searchBar = document.getElementById('topnavSearch');
  if (searchBar) {
    searchBar.classList.toggle('active');
    const isActive = searchBar.classList.contains('active');
    if (isActive) {
      const inp = searchBar.querySelector('input');
      if (inp) inp.focus();
    }
  }
}

document.addEventListener('click', function(e) {
  const notifBtn = document.getElementById('notif-btn');
  if (notifBtn && !notifBtn.contains(e.target)) {
    notifOpen = false;
    const notifDropdown = document.getElementById('notif-dropdown');
    if (notifDropdown) notifDropdown.classList.remove('open');
  }

  const searchBar = document.getElementById('topnavSearch');
  const toggleBtn = document.getElementById('mobileSearchToggle');
  if (window.innerWidth <= 768 && searchBar && searchBar.classList.contains('active')) {
    if (!searchBar.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target))) {
      searchBar.classList.remove('active');
    }
  }
});

function fetchNotif() {
  fetch('{{ route("notifikasi.index") }}', {
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
  })
  .then(r => r.json())
  .then(data => {
    const count = data.count;
    const dot   = document.getElementById('notif-dot');
    const badge = document.getElementById('notif-badge');
    const label = document.getElementById('notif-count-label');
    const list  = document.getElementById('notif-list');
    const markAllBtn = document.getElementById('mark-all-read-btn');

    if (count > 0) {
      dot.style.display   = 'block';
      badge.style.display = 'block';
      badge.textContent   = count > 99 ? '99+' : count;
      label.textContent   = count + ' notifikasi belum dibaca';
      if (markAllBtn) markAllBtn.style.display = 'inline-block';
    } else {
      dot.style.display   = 'none';
      badge.style.display = 'none';
      label.textContent   = 'Tidak ada notifikasi baru';
      if (markAllBtn) markAllBtn.style.display = 'none';
    }

    if (data.items.length === 0) {
      list.innerHTML = `<div class="notif-empty"><i class="fas fa-bell-slash"></i><div>Tidak ada notifikasi</div></div>`;
      return;
    }

    list.innerHTML = '<div class="notif-list-scroll">' +
      data.items.map(item => `
        <div class="notif-item ${item.is_read ? 'read' : 'unread'}" onclick="handleNotifClick(event, ${item.id}, '${item.link}')" style="position: relative;">
          <div class="notif-icon" style="background:${item.bg};color:${item.color};">
            <i class="fas ${item.icon}"></i>
          </div>
          <div style="flex:1; min-width:0;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:6px; margin-bottom:2px;">
              <span class="notif-title" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;">${item.judul}</span>
              ${!item.is_read ? '<span style="width:6px; height:6px; border-radius:50%; background:#2ec4b6; display:inline-block; flex-shrink:0;"></span>' : ''}
            </div>
            <div class="notif-desc">${item.text}</div>
            <div style="display:flex; align-items:center; justify-content:space-between; gap:6px; margin-top:4px;">
              ${item.time ? `<span class="notif-time" style="display:inline-flex; align-items:center; gap:3px; margin-top:0;"><i class="fas fa-clock"></i>${item.time}</span>` : '<span></span>'}
              <a href="${item.link}" onclick="event.stopPropagation();" class="notif-action-btn" style="font-size:10px; color:#0f8075; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:2px;">
                Buka <i class="fas fa-arrow-right" style="font-size:8px;"></i>
              </a>
            </div>
          </div>
        </div>
      `).join('') +
    '</div>';
  })
  .catch(err => console.error('Notif fetch error:', err));
}

function handleNotifClick(e, id, link) {
  if (e) e.preventDefault();
  
  if (!id) {
    window.location.href = link;
    return;
  }

  fetch(`/notifikasi/${id}/read`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    }
  })
  .then(r => r.json())
  .then(() => {
    window.location.href = link;
  })
  .catch(err => {
    console.error('Error marking as read:', err);
    window.location.href = link;
  });
}

function markAllRead(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  
  fetch('/notifikasi/mark-all-read', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    }
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      fetchNotif();
    }
  })
  .catch(err => console.error('Error marking all as read:', err));
}

document.addEventListener('DOMContentLoaded', function() {
  fetchNotif();
  setInterval(fetchNotif, 60000);
});

// ── Global Search Autocomplete ──────────────────────────────────────────────
(function () {
  const inp      = document.getElementById('globalSearch');
  const dropdown = document.getElementById('gsDropdown');
  if (!inp || !dropdown) return;

  let debounceTimer = null;
  let lastQuery     = '';

  const categoryMeta = {
    halaman:  { title: 'Halaman',    iconColor: '#0f8075', iconBg: '#e6f7f6' },
    balita:   { title: 'Balita',     iconColor: '#6366f1', iconBg: '#eef0ff' },
    ibu_hamil:{ title: 'Ibu Hamil', iconColor: '#f59e0b', iconBg: '#fef3e2' },
    user:     { title: 'Pengguna',   iconColor: '#14a398', iconBg: '#e6f7f6' },
  };

  function openDropdown()  { dropdown.classList.add('open'); }
  function closeDropdown() { dropdown.classList.remove('open'); dropdown.innerHTML = ''; }

  function renderResults(data) {
    dropdown.innerHTML = '';
    const order   = ['halaman', 'balita', 'ibu_hamil', 'user'];
    let   hasAny  = false;

    order.forEach(function (cat) {
      const items = data[cat];
      if (!items || items.length === 0) return;
      hasAny = true;
      const meta = categoryMeta[cat];

      const groupTitle = document.createElement('div');
      groupTitle.className = 'gs-group-title';
      groupTitle.textContent = meta.title;
      dropdown.appendChild(groupTitle);

      items.forEach(function (item) {
        const a = document.createElement('a');
        a.href      = item.url;
        a.className = 'gs-item';

        const iconWrap = document.createElement('div');
        iconWrap.className = 'gs-item-icon';
        iconWrap.style.background = meta.iconBg;
        iconWrap.style.color      = meta.iconColor;
        iconWrap.innerHTML = '<i class="fas ' + item.icon + '"></i>';

        const textWrap = document.createElement('div');
        textWrap.className = 'gs-item-text';

        const labelEl = document.createElement('div');
        labelEl.className   = 'gs-item-label';
        labelEl.textContent = item.label;

        textWrap.appendChild(labelEl);

        if (item.sub) {
          const subEl = document.createElement('div');
          subEl.className   = 'gs-item-sub';
          subEl.textContent = item.sub;
          textWrap.appendChild(subEl);
        }

        a.appendChild(iconWrap);
        a.appendChild(textWrap);
        dropdown.appendChild(a);
      });
    });

    if (!hasAny) {
      const empty = document.createElement('div');
      empty.className   = 'gs-empty';
      empty.textContent = 'Data tidak ditemukan';
      dropdown.appendChild(empty);
    }

    openDropdown();
  }

  function doSearch(q) {
    if (q.length < 2) { closeDropdown(); return; }
    fetch('{{ route("search.global") }}?q=' + encodeURIComponent(q), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': (document.querySelector('meta[name=csrf-token]') || {}).content || ''
      }
    })
    .then(function (r) { return r.json(); })
    .then(function (data) { if (inp.value.trim() === q) renderResults(data); })
    .catch(function () { closeDropdown(); });
  }

  inp.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    const q = inp.value.trim();
    if (q === '') { closeDropdown(); lastQuery = ''; return; }
    if (q === lastQuery) return;
    lastQuery = q;
    debounceTimer = setTimeout(function () { doSearch(q); }, 300);
  });

  inp.addEventListener('focus', function () {
    if (inp.value.trim().length >= 2 && dropdown.innerHTML !== '') openDropdown();
  });

  document.addEventListener('click', function (e) {
    const wrapper = document.getElementById('topnavSearch');
    if (wrapper && !wrapper.contains(e.target)) closeDropdown();
  });
})();
</script>