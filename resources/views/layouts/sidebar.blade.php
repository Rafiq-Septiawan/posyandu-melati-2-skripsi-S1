@php
$waitingIbu = \App\Models\PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', now()->month)
    ->whereYear('tanggal_periksa', now()->year)
    ->doesntHave('pemeriksaanLanjutan')
    ->count();
$waitingBalita = \App\Models\PemeriksaanAwalBalita::whereMonth('tanggal_periksa', now()->month)
    ->whereYear('tanggal_periksa', now()->year)
    ->doesntHave('pemeriksaanLanjutan')
    ->count();
@endphp

<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="brand-logo">
      <img src="{{ asset('images/LOGO_POSYANDU.png') }}" alt="Logo"
        style="width:42px;height:42px;object-fit:contain;border-radius:50%;">
    </div>
    <div class="brand-name">Posyandu Melati 2</div>
    <!-- <div class="brand-sub">Sistem Informasi Kesehatan</div> -->
  </div>

  <nav class="sidebar-nav">
    @if(auth()->user()->role === 'ketua')

      <div class="nav-section-label">Utama</div>
      <a href="{{ route('ketua.dashboard') }}"
         class="nav-item {{ request()->routeIs('ketua.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>

      <div class="nav-section-label">Data Master</div>
      <a href="{{ route('ibu-hamil.index') }}"
         class="nav-item {{ request()->routeIs('ibu-hamil.*') ? 'active' : '' }}">
        <i class="fas fa-person-pregnant"></i> Data Ibu Hamil
      </a>
      <a href="{{ route('balita.index') }}"
         class="nav-item {{ request()->routeIs('balita.*') ? 'active' : '' }}">
        <i class="fas fa-baby"></i> Data Balita
      </a>
      <a href="{{ route('ketua.users.index') }}"
         class="nav-item {{ request()->routeIs('ketua.users.*') ? 'active' : '' }}">
        <i class="fas fa-users-cog"></i> Kelola Pengguna
      </a>

      <div class="nav-section-label">Jadwal</div>
      <a href="{{ route('ketua.jadwal-posyandu.index') }}"
         class="nav-item {{ request()->routeIs('ketua.jadwal-posyandu.*') ? 'active' : '' }}">
        <i class="fas fa-calendar-days"></i> Jadwal Posyandu
      </a>

      <div class="nav-section-label">Pemeriksaan Awal</div>
      <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index') }}"
         class="nav-item {{ request()->routeIs('kader.pemeriksaan-awal-ibu-hamil.*') ? 'active' : '' }}">
        <i class="fas fa-stethoscope"></i> Pemeriksaan Ibu Hamil
      </a>
      <a href="{{ route('kader.pemeriksaan-awal-balita.index') }}"
         class="nav-item {{ request()->routeIs('kader.pemeriksaan-awal-balita.*') ? 'active' : '' }}">
        <i class="fas fa-child"></i> Pemeriksaan Balita
      </a>

      <div class="nav-section-label">Pemeriksaan Lanjutan</div>
      <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index') }}"
         class="nav-item {{ request()->routeIs('bidan.pemeriksaan-lanjutan-ibu-hamil.*') ? 'active' : '' }}">
        <i class="fas fa-notes-medical"></i>
        <span style="flex:1;">Pemeriksaan Lanjutan Ibu Hamil</span>
        @if($waitingIbu > 0)
          <span class="nav-badge">{{ $waitingIbu > 99 ? '99+' : $waitingIbu }}</span>
        @endif
      </a>
      <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index') }}"
         class="nav-item {{ request()->routeIs('bidan.pemeriksaan-lanjutan-balita.*') ? 'active' : '' }}">
        <i class="fas fa-syringe"></i>
        <span style="flex:1;">Pemeriksaan Lanjutan Balita</span>
        @if($waitingBalita > 0)
          <span class="nav-badge">{{ $waitingBalita > 99 ? '99+' : $waitingBalita }}</span>
        @endif
      </a>

      <div class="nav-section-label">Laporan</div>
      <a href="{{ route('ketua.laporan.ibu-hamil') }}"
         class="nav-item {{ request()->is('ketua/laporan/ibu-hamil*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i> Laporan Pemeriksaan Ibu Hamil
      </a>
      <a href="{{ route('ketua.laporan.balita') }}"
         class="nav-item {{ request()->is('ketua/laporan/balita*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i> Laporan Pemeriksaan Balita
      </a>

    @elseif(auth()->user()->role === 'kader')

      <div class="nav-section-label">Utama</div>
      <a href="{{ route('kader.dashboard') }}"
         class="nav-item {{ request()->routeIs('kader.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>

      <div class="nav-section-label">Data Pasien</div>
      <a href="{{ route('ibu-hamil.index') }}"
         class="nav-item {{ request()->routeIs('ibu-hamil.*') ? 'active' : '' }}">
        <i class="fas fa-person-pregnant"></i> Data Ibu Hamil
      </a>
      <a href="{{ route('balita.index') }}"
         class="nav-item {{ request()->routeIs('balita.*') ? 'active' : '' }}">
        <i class="fas fa-baby"></i> Data Balita
      </a>

      <div class="nav-section-label">Pemeriksaan Awal</div>
      <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index') }}"
         class="nav-item {{ request()->routeIs('kader.pemeriksaan-awal-ibu-hamil.*') ? 'active' : '' }}">
        <i class="fas fa-stethoscope"></i> Pemeriksaan Ibu Hamil
      </a>
      <a href="{{ route('kader.pemeriksaan-awal-balita.index') }}"
         class="nav-item {{ request()->routeIs('kader.pemeriksaan-awal-balita.*') ? 'active' : '' }}">
        <i class="fas fa-child"></i> Pemeriksaan Balita
      </a>

      <div class="nav-section-label">Laporan</div>
      <a href="{{ route('ketua.laporan.ibu-hamil') }}"
         class="nav-item {{ request()->is('ketua/laporan/ibu-hamil*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i> Laporan Pemeriksaan Ibu Hamil
      </a>
      <a href="{{ route('ketua.laporan.balita') }}"
         class="nav-item {{ request()->is('ketua/laporan/balita*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i> Laporan Pemeriksaan Balita
      </a>

    @elseif(auth()->user()->role === 'bidan')

      <div class="nav-section-label">Utama</div>
      <a href="{{ route('bidan.dashboard') }}"
         class="nav-item {{ request()->routeIs('bidan.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>

      <div class="nav-section-label">Pemeriksaan Lanjutan</div>
      <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index') }}"
         class="nav-item {{ request()->routeIs('bidan.pemeriksaan-lanjutan-ibu-hamil.*') ? 'active' : '' }}">
        <i class="fas fa-notes-medical"></i>
        <span style="flex:1;">Pemeriksaan Lanjutan Ibu Hamil</span>
        @if($waitingIbu > 0)
          <span class="nav-badge">{{ $waitingIbu > 99 ? '99+' : $waitingIbu }}</span>
        @endif
      </a>
      <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index') }}"
         class="nav-item {{ request()->routeIs('bidan.pemeriksaan-lanjutan-balita.*') ? 'active' : '' }}">
        <i class="fas fa-syringe"></i>
        <span style="flex:1;">Pemeriksaan Lanjutan Balita</span>
        @if($waitingBalita > 0)
          <span class="nav-badge">{{ $waitingBalita > 99 ? '99+' : $waitingBalita }}</span>
        @endif
      </a>

      <div class="nav-section-label">Laporan</div>
      <a href="{{ route('ketua.laporan.ibu-hamil') }}"
         class="nav-item {{ request()->is('ketua/laporan/ibu-hamil*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i> Laporan Pemeriksaan Ibu Hamil
      </a>
      <a href="{{ route('ketua.laporan.balita') }}"
         class="nav-item {{ request()->is('ketua/laporan/balita*') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i> Laporan Pemeriksaan Balita
      </a>

    @elseif(auth()->user()->role === 'orang_tua')

      <div class="nav-section-label">Utama</div>
      <a href="{{ route('orang-tua.dashboard') }}"
         class="nav-item {{ request()->routeIs('orang-tua.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>

      <div class="nav-section-label">Riwayat Saya</div>
      <a href="{{ route('orang-tua.riwayat.ibu-hamil') }}"
         class="nav-item {{ request()->routeIs('orang-tua.riwayat.ibu-hamil') ? 'active' : '' }}">
        <i class="fas fa-person-pregnant"></i> Riwayat Ibu Hamil
      </a>
      <a href="{{ route('orang-tua.riwayat.balita') }}"
         class="nav-item {{ request()->routeIs('orang-tua.riwayat.balita') ? 'active' : '' }}">
        <i class="fas fa-baby"></i> Riwayat Balita
      </a>

      <div class="nav-section-label">Lainnya</div>
      <a href="{{ route('jadwal-posyandu.public') }}"
         class="nav-item {{ request()->routeIs('jadwal-posyandu.public') ? 'active' : '' }}">
        <i class="fas fa-calendar-alt"></i> Jadwal Posyandu
      </a>

    @endif
  </nav>

  <div class="sidebar-footer">
    <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</div>
    <div class="user-info">
      <div class="name">{{ auth()->user()->nama }}</div>
      <div class="role">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
      </button>
    </form>
  </div>
</aside>

<style>
.sidebar { width:var(--sidebar-w,260px); background:#0d3b38; display:flex; flex-direction:column; position:fixed; left:0; top:0; bottom:0; z-index:100; overflow-y:auto; }
.sidebar-brand { padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,.08); display: flex; flex-direction: column; align-items: center; text-align: center; }
.brand-logo { width:46px; height:46px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; padding:2px; margin-bottom:12px; box-shadow:0 4px 12px rgba(0,0,0,.2); }
.brand-name { font-size:14px; font-weight:700; color:#fff; line-height:1.3; }
.brand-sub { font-size:11px; color:#5dd8cd; margin-top:2px; }
.sidebar-nav { padding:16px 0; flex:1; }
.nav-section-label { font-size:10px; font-weight:600; color:#2ec4b6; letter-spacing:1.2px; text-transform:uppercase; padding:12px 24px 6px; }
.nav-item { display:flex; align-items:center; gap:12px; padding:10px 24px; color:rgba(255,255,255,.6); font-size:13.5px; font-weight:500; text-decoration:none; border-left:3px solid transparent; transition:all .2s; }
.nav-item:hover { color:#fff; background:rgba(255,255,255,.06); }
.nav-item.active { color:#5dd8cd; background:rgba(46,196,182,.12); border-left-color:#2ec4b6; }
.nav-item i { width:18px; text-align:center; font-size:14px; }

/* ── Badge antrian sidebar ── */
.nav-badge {
  min-width: 18px;
  height: 18px;
  padding: 0 5px;
  border-radius: 999px;
  background: #ef4444;
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  line-height: 1;
  box-shadow: 0 1px 4px rgba(239,68,68,.4);
}

@keyframes badge-pulse {
  0%, 100% { box-shadow: 0 2px 8px rgba(239, 68, 68, .5); }
  50%       { box-shadow: 0 2px 16px rgba(239, 68, 68, .85); }
}

.sidebar-footer { padding:16px 24px; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:12px; }
.avatar-sm { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#2ec4b6,#818cf8); display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#fff; flex-shrink:0; }
.user-info .name { font-size:13px; font-weight:600; color:#fff; }
.user-info .role { font-size:11px; color:#5dd8cd; }
.logout-form { margin-left:auto; }
.logout-btn { background:none; border:none; color:rgba(255,255,255,.4); cursor:pointer; font-size:14px; transition:color .2s; padding:4px; }
.logout-btn:hover { color:#fb7185; }
</style>