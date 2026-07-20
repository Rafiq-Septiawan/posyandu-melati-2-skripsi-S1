@extends('layouts.app')
@section('title', 'Laporan Pemeriksaan Balita')

@push('styles')
<style>
/* ── Filter compact ── */
.filter-compact {
  padding: 12px 20px;
}
.filter-compact .filter-row {
  display: flex;
  gap: 10px;
  align-items: flex-end;
  flex-wrap: nowrap;
}
.filter-compact .form-group {
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.filter-compact .form-label {
  font-size: 11px;
  font-weight: 600;
  color: var(--slate-500);
  white-space: nowrap;
}
.filter-compact .form-control {
  height: 36px;
  font-size: 13px;
  padding: 0 10px;
}
.filter-compact .search-bar {
  height: 36px;
}
.filter-compact .search-bar input {
  font-size: 13px;
}
.filter-compact .fg-bulan  { width: 140px; flex-shrink: 0; }
.filter-compact .fg-tahun  { width: 90px;  flex-shrink: 0; }
.filter-compact .fg-search { flex: 1; min-width: 160px; }
.filter-compact .fg-actions {
  display: flex;
  gap: 8px;
  flex-shrink: 0;
  padding-bottom: 0;
}
.filter-compact .fg-actions .btn {
  height: 36px;
  white-space: nowrap;
  font-size: 13px;
}

/* ── Base ── */
.btn-success { background:#dcfce7;color:#166534;border:none; }
.btn-success:hover { background:#bbf7d0; }

/* ── Top bar ── */
.page-topbar {
  display:flex;align-items:center;gap:8px;margin-bottom:20px;flex-wrap:wrap;
}
.page-topbar .actions {
  margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;
}

/* Stats styling consolidated globally in layouts/app.blade.php */

/* ── Table (desktop) ── */
.table-scroll { overflow-x:auto;-webkit-overflow-scrolling:touch; }
.table-scroll .data-table { min-width:1200px; }
.data-table th { padding:9px 10px;font-size:10.5px;white-space:nowrap;text-align:center; }
.data-table td { padding:10px 10px;font-size:12.5px;vertical-align:middle;text-align:center; }
.data-table td:nth-child(2),.data-table th:nth-child(2) { text-align:left; }

/* ── Cell helpers ── */
.bb-tb { display:flex;flex-direction:column;align-items:center;gap:2px; }
.bb-val { font-size:12px;font-weight:600;color:var(--slate-700); }
.tb-val { font-size:10.5px;color:var(--slate-400);background:var(--slate-100);border-radius:3px;padding:1px 4px; }
.lkll  { display:flex;flex-direction:column;gap:1px;align-items:center;font-size:11px;color:var(--slate-600); }
.lkll span { display:flex;align-items:center;gap:3px; }
.lkll .lbl { font-size:9.5px;color:var(--slate-400);font-weight:600; }
.hasil-ukur { display:flex;flex-direction:column;align-items:center;gap:2px;font-size:11px;color:var(--slate-600); }
.cell-name  { font-weight:600;color:var(--slate-800);font-size:12.5px; }
.cell-meta  { font-size:11px;color:var(--slate-400);margin-top:1px; }
.empty-state { text-align:center;padding:40px;color:var(--slate-400); }
.empty-state i { font-size:32px;margin-bottom:8px;display:block;opacity:.4; }
.card-header {
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;
}

/* ────────────────────────────────────────────
   MOBILE CARD LIST  (replaces horizontal table)
──────────────────────────────────────────── */
.mobile-list { display:none; }

.rec-card {
  background:#fff;border:1.5px solid var(--slate-200);border-radius:14px;
  padding:14px 16px;margin-bottom:12px;
}
.rec-card-header {
  display:flex;align-items:flex-start;justify-content:space-between;
  gap:8px;margin-bottom:10px;
}
.rec-card-header .no-badge {
  font-size:10px;color:var(--slate-400);font-weight:600;
  background:var(--slate-100);border-radius:6px;padding:2px 8px;flex-shrink:0;
}
.rec-name   { font-weight:700;font-size:14px;color:var(--slate-800); }
.rec-sub    { font-size:11px;color:var(--slate-400);margin-top:1px; }

.rec-grid {
  display:grid;grid-template-columns:1fr 1fr;gap:8px 12px;
  font-size:12px;color:var(--slate-700);
}
.rec-field label {
  display:block;font-size:10px;font-weight:600;color:var(--slate-400);
  text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px;
}
.rec-field .val { font-weight:600; }

.rec-divider {
  border:none;border-top:1px solid var(--slate-100);margin:10px 0;
}
.rec-footer {
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;
}

/* ── Responsive breakpoints ── */
/* Removed local max-width:1100px stats query */

@media(max-width:767px){
    .filter-compact .filter-row {
    flex-wrap: wrap;
  }
  .filter-compact .fg-bulan,
  .filter-compact .fg-tahun  { width: calc(50% - 5px); }
  .filter-compact .fg-search { width: 100%; flex-basis: 100%; }
  .filter-compact .fg-actions { width: 100%; }
  .filter-compact .fg-actions .btn { flex: 1; justify-content: center; }
  .page-topbar { flex-direction:column;align-items:flex-start; }
  .page-topbar .actions {
    margin-left:0;width:100%;
    display:grid;grid-template-columns:1fr 1fr;gap:8px;
  }
  .page-topbar .actions .btn { width:100%;justify-content:center;text-align:center; }
  /* stats: 2-col removed */
  .filter-form-inner {
    flex-direction:column !important;align-items:stretch !important;
  }
  .filter-form-inner .form-group,
  .filter-form-inner .search-bar { width:100% !important; }
  .filter-form-inner .btn { width:100%; }
  .table-scroll { display:none; }
  .mobile-list  { display:block; }
  .pagination-wrapper { flex-wrap:wrap;gap:6px;justify-content:flex-end;align-items:center; }
  .page-info { margin-right:auto !important; }
  .page-topbar .actions .laporan-nav-btn { grid-column:span 2; }
  /* Stats grid 2-col on mobile removed */
}

@media(max-width:400px){
    .filter-compact .fg-bulan,
  .filter-compact .fg-tahun { width: 100%; }
  /* Stats grid grid-columns removed */
  .rec-grid  { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')

<div class="page-topbar">
  <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
    <span style="font-size:18px;font-weight:700;color:var(--slate-700);">Laporan Pemeriksaan Balita</span>
  </div>
  <div class="actions">
    <a href="{{ route('ketua.laporan.ibu-hamil', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
       class="btn btn-outline btn-sm laporan-nav-btn">
      <i class="fas fa-person-pregnant"></i> Laporan Ibu Hamil
    </a>
    <a href="{{ route('ketua.laporan.balita.export', ['bulan'=>$bulan,'tahun'=>$tahun,'search'=>request('search')]) }}"
       class="btn btn-success btn-sm">
      <i class="fas fa-file-excel"></i> Export Excel
    </a>
    <button onclick="cetakPDF()" class="btn btn-primary btn-sm">
      <i class="fas fa-print"></i> Cetak PDF
    </button>
  </div>
</div>

{{-- Filter --}}
<div class="card" style="margin-bottom:20px;">
  <form method="GET" action="{{ route('ketua.laporan.balita') }}" class="filter-compact">
    <div class="filter-row">

      <div class="form-group fg-bulan">
        <label class="form-label">Bulan</label>
        <select name="bulan" class="form-control">
          @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ $bulan==$m ? 'selected' : '' }}>
              {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group fg-tahun">
        <label class="form-label">Tahun</label>
        <select name="tahun" class="form-control">
          @foreach(range(now()->year, now()->year-3) as $y)
            <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>{{ $y }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group fg-search">
        <label class="form-label">Cari Nama Balita</label>
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" name="search" value="{{ request('search') }}"
                 placeholder="Nama balita…">
        </div>
      </div>

      <div class="fg-actions">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-filter"></i> Terapkan
        </button>
        @if(request('search'))
          <a href="{{ route('ketua.laporan.balita', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
             class="btn btn-outline">
            <i class="fas fa-times"></i>
          </a>
        @endif
      </div>

    </div>
  </form>
</div>

{{-- Stats --}}
<div class="dashboard-stats-grid">
  @php
    $giziConfig = [
      ['label'=>'Total Pemeriksaan',   'val'=>$stats['total'],       'cardClass'=>'card-teal',   'iconClass'=>'icon-teal',   'icon'=>'fa-clipboard-list'],
      ['label'=>'Gizi Normal / Baik',  'val'=>$stats['gizi_normal'], 'cardClass'=>'card-green',  'iconClass'=>'icon-green',  'icon'=>'fa-check-circle'],
      ['label'=>'Gizi Kurang',         'val'=>$stats['gizi_kurang'], 'cardClass'=>'card-amber',  'iconClass'=>'icon-amber',  'icon'=>'fa-exclamation-triangle'],
      ['label'=>'Gizi Buruk/Stunting', 'val'=>$stats['gizi_buruk'],  'cardClass'=>'card-rose',   'iconClass'=>'icon-rose',   'icon'=>'fa-times-circle'],
    ];
  @endphp
  @foreach($giziConfig as $g)
  <div class="stat-card {{ $g['cardClass'] }}">
    <div class="stat-icon {{ $g['iconClass'] }}"><i class="fas {{ $g['icon'] }}"></i></div>
    <div class="stat-value">{{ $g['val'] }}</div>
    <div class="stat-label">{{ $g['label'] }}</div>
    <div class="stat-delta" style="color:var(--slate-400);">{{ \Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y') }}</div>
  </div>
  @endforeach
</div>

<!-- Status Gizi Donut Chart removed (duplicate of statistics cards above) -->

{{-- Card wrapper --}}
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Rekap Pemeriksaan Balita</div>
      <div class="card-subtitle">
        Periode: {{ \Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y') }}
      </div>
    </div>
    <span style="font-size:13px;color:var(--slate-500);">{{ $pemeriksaans->total() }} data ditemukan</span>
  </div>

  {{-- ═══ DESKTOP TABLE ═══ --}}
  <div class="table-scroll">
    <table class="data-table">
      <thead>
        <tr>
          <th class="col-hide-mobile">No</th>
          <th class="col-nama-data">Nama Balita</th>
          <th class="col-hide-mobile">Orang Tua</th>
          <th class="col-hide-mobile">Tanggal Periksa</th>
          <th class="col-hide-mobile">Hasil Ukur</th>
          <th class="col-hide-mobile">Keluhan</th>
          <th class="col-hide-mobile">Status Gizi</th>
          <th class="col-hide-mobile">Status Pemeriksaan</th>
          <th class="col-hide-mobile">Tindak Lanjut</th>
          <th class="col-aksi">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaans as $i => $pem)
        @php
          $b        = $pem->balita;
          $lanjutan = $pem->pemeriksaanLanjutan;
          $sg = strtolower($lanjutan->status_gizi ?? '');
        @endphp
        <tr>
          <td style="color:var(--slate-400);font-size:11px;" class="col-hide-mobile">
            {{ ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1 }}
          </td>
          <td class="col-nama-data">
            <div class="cell-name">{{ $b->nama_balita ?? '-' }}</div>
            <div class="cell-meta">{{ ($b->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
          </td>
          <td class="col-hide-mobile">
            <div class="cell-name">{{ $b->ibuHamil->nama_ibu ?? $b->nama_ibu ?? '-' }}</div>
            <div class="cell-meta">{{ $b->ibuHamil->no_hp ?? '-' }}</div>
          </td>
          <td style="white-space:nowrap;" class="col-hide-mobile">
            <div class="cell-name">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}</div>
            <div class="cell-meta">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->diffForHumans() }}</div>
          </td>
          <td class="col-hide-mobile">
            <div class="hasil-ukur">
              <div>BB/TB : {{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }} / {{ $pem->tinggi_badan !== null ? fmtAngka($pem->tinggi_badan).' cm' : '-' }}</div>
              <div>LK/LL : {{ $pem->lingkar_kepala !== null ? fmtAngka($pem->lingkar_kepala).' cm' : '-' }} / {{ $pem->lingkar_lengan !== null ? fmtAngka($pem->lingkar_lengan).' cm' : '-' }}</div>
            </div>
          </td>
          <td style="max-width:110px;" class="col-hide-mobile">
            <span style="font-size:11.5px;color:var(--slate-600);">
              {{ $pem->keluhan ? \Illuminate\Support\Str::limit($pem->keluhan,40) : 'Tidak ada keluhan' }}
            </span>
          </td>
          <td class="col-hide-mobile">
            @php
              $sgMap = [
                'gizi baik'   => ['Gizi Baik',   'badge-green'],
                'gizi normal' => ['Gizi Normal',  'badge-green'],
                'gizi kurang' => ['Gizi Kurang',  'badge-orange'],
                'gizi buruk'  => ['Gizi Buruk',   'badge-red'],
                'stunting'    => ['Stunting',      'badge-red'],
                'gizi lebih'  => ['Gizi Lebih',   'badge-blue'],
              ];
              [$sgLabel, $sgBadge] = $sgMap[$sg] ?? ($sg ? [$lanjutan->status_gizi, 'badge-teal'] : [null, null]);
            @endphp
            @if($sgLabel)
              <span class="badge {{ $sgBadge }}">{{ $sgLabel }}</span>
            @else
              <span class="badge" style="background:var(--slate-100);color:var(--slate-400);">Belum Diperiksa</span>
            @endif
          </td>
          <td class="col-hide-mobile">
            @if($lanjutan)
              <span class="badge badge-green"><i class="fas fa-check-circle" style="margin-right:4px;"></i>Lengkap</span>
            @else
              <span class="badge badge-orange">Menunggu Bidan</span>
            @endif
          </td>
          <td class="col-hide-mobile">
            @if($lanjutan && $lanjutan->tindak_lanjut)
              @php
                $tlMap = [
                  'kontrol'           => ['Kontrol Rutin',   'badge-teal'],
                  'rujukan_puskesmas' => ['Rujuk Puskesmas', 'badge-orange'],
                  'rujukan_rs'        => ['Rujuk RS',        'badge-red'],
                  'rawat_inap'        => ['Rawat Inap',      'badge-purple'],
                ];
                [$tlLabel,$tlBadge] = $tlMap[$lanjutan->tindak_lanjut] ?? [$lanjutan->tindak_lanjut,'badge-teal'];
              @endphp
              <span class="badge {{ $tlBadge }}" style="white-space:nowrap;">{{ $tlLabel }}</span>
            @else
              <span class="badge badge-orange" style="white-space:nowrap;">Menunggu Bidan</span>
            @endif
          </td>
          <td class="col-aksi">
            @php
              $detailBalita = json_encode([
                'Nama Balita'  => $b->nama_balita ?? '-',
                'Jenis Kelamin'=> ($b->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan',
                'Orang Tua'    => $b->ibuHamil->nama_ibu ?? $b->nama_ibu ?? '-',
                'Tanggal Periksa' => \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y'),
                'BB / TB'      => ($pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-').' / '.($pem->tinggi_badan !== null ? fmtAngka($pem->tinggi_badan).' cm' : '-'),
                'LK / LL'      => ($pem->lingkar_kepala !== null ? fmtAngka($pem->lingkar_kepala).' cm' : '-').' / '.($pem->lingkar_lengan !== null ? fmtAngka($pem->lingkar_lengan).' cm' : '-'),
                'Status Gizi'  => $sgLabel ?? 'Belum Diperiksa',
                'Status'       => $lanjutan ? 'Lengkap' : 'Menunggu Bidan',
              ]);
            @endphp
            <a href="{{ route('ketua.laporan.balita.detail', $b->id) }}"
               class="btn btn-view btn-sm" title="Lihat Detail"
               data-title="{{ $b->nama_balita ?? '-' }}"
               data-detail="{{ $detailBalita }}"
               onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))">
              <i class="fas fa-eye"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="10">
            <div class="empty-state">
              <i class="fas fa-baby"></i>
              <h3>Tidak ada data pemeriksaan</h3>
              <p>Tidak ada pemeriksaan balita pada periode ini.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ═══ MOBILE CARD LIST ═══ --}}
  <div class="mobile-list" style="padding:12px 14px;">
    @forelse($pemeriksaans as $i => $pem)
    @php
      $b        = $pem->balita;
      $lanjutan = $pem->pemeriksaanLanjutan;
      $usia     = $b ? \Carbon\Carbon::parse($b->tanggal_lahir)->diffInMonths(now()) : null;
      $usiaLabel = $usia !== null
        ? ($usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln')
        : '-';
      $sg = strtolower($lanjutan->status_gizi ?? '');
      $no = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    @endphp
    <div class="rec-card">
      {{-- Header: no + name + action --}}
      <div class="rec-card-header">
        <div>
          <div class="rec-name">{{ $b->nama_balita ?? '-' }}</div>
          <div class="rec-sub">
            {{ ($b->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}
            &bull; {{ $usiaLabel }}
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
          <span class="no-badge">#{{ $no }}</span>
          <a href="{{ route('ketua.laporan.balita.detail', $b->id) }}"
             class="btn btn-view btn-sm" title="Detail">
            <i class="fas fa-eye"></i>
          </a>
        </div>
      </div>

      <hr class="rec-divider">

      {{-- Grid info --}}
      <div class="rec-grid">
        <div class="rec-field">
          <label>Orang Tua</label>
          <div class="val">{{ $b->ibuHamil->nama_ibu ?? $b->nama_ibu ?? '-' }}</div>
          <div style="font-size:11px;color:var(--slate-400);">{{ $b->ibuHamil->no_hp ?? '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Tgl Periksa</label>
          <div class="val">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}</div>
        </div>
        <div class="rec-field">
          <label>BB / TB</label>
          <div class="val">
            {{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }}
            / {{ $pem->tinggi_badan !== null ? fmtAngka($pem->tinggi_badan).' cm' : '-' }}
          </div>
        </div>
        <div class="rec-field">
          <label>LK / LL</label>
          <div class="val">
            {{ $pem->lingkar_kepala !== null ? fmtAngka($pem->lingkar_kepala).' cm' : '-' }}
            / {{ $pem->lingkar_lengan !== null ? fmtAngka($pem->lingkar_lengan).' cm' : '-' }}
          </div>
        </div>
        <div class="rec-field">
          <label>Kader</label>
          <div class="val">{{ $pem->kader->nama ?? '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Bidan</label>
          <div class="val">{{ $lanjutan && $lanjutan->bidan ? $lanjutan->bidan->nama : '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Imunisasi</label>
          <div class="val">{{ $lanjutan->imunisasi ?? '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Vitamin A</label>
          <div class="val">
            @if($lanjutan && $lanjutan->vitamin_a)
              <span class="badge badge-teal">{{ $lanjutan->vitamin_a }}</span>
            @else
              -
            @endif
          </div>
        </div>
      </div>

      @if($pem->keluhan)
      <div style="margin-top:8px;background:var(--slate-50);border-radius:8px;padding:8px 10px;">
        <span style="font-size:10px;font-weight:600;color:var(--slate-400);text-transform:uppercase;letter-spacing:.4px;">Keluhan</span>
        <div style="font-size:12px;color:var(--slate-600);margin-top:2px;">
          {{ \Illuminate\Support\Str::limit($pem->keluhan,80) }}
        </div>
      </div>
      @endif

      <hr class="rec-divider">

      <div class="rec-footer">
        {{-- Status Gizi --}}
        @if(str_contains($sg,'normal')||str_contains($sg,'baik'))
          <span class="badge badge-green">{{ $lanjutan->status_gizi }}</span>
        @elseif(str_contains($sg,'kurang'))
          <span class="badge badge-orange">{{ $lanjutan->status_gizi }}</span>
        @elseif(str_contains($sg,'stunting')||str_contains($sg,'buruk'))
          <span class="badge badge-red">{{ $lanjutan->status_gizi }}</span>
        @elseif(str_contains($sg,'lebih'))
          <span class="badge badge-blue">{{ $lanjutan->status_gizi }}</span>
        @elseif($sg)
          <span class="badge badge-teal">{{ $lanjutan->status_gizi }}</span>
        @else
          <span class="badge" style="background:var(--slate-100);color:var(--slate-400);">Belum diisi</span>
        @endif

        {{-- Tindak Lanjut --}}
        @if($lanjutan && $lanjutan->tindak_lanjut)
          @php
            $tlMap = [
              'kontrol'           => ['Kontrol Rutin',   'badge-teal'],
              'rujukan_puskesmas' => ['Rujuk Puskesmas', 'badge-orange'],
              'rujukan_rs'        => ['Rujuk RS',        'badge-red'],
              'rawat_inap'        => ['Rawat Inap',      'badge-purple'],
            ];
            [$tlLabel,$tlBadge] = $tlMap[$lanjutan->tindak_lanjut] ?? [$lanjutan->tindak_lanjut,'badge-teal'];
          @endphp
          <span class="badge {{ $tlBadge }}">{{ $tlLabel }}</span>
        @else
          <span class="badge badge-orange">Menunggu Bidan</span>
        @endif

        {{-- Pemeriksaan Lanjutan --}}
        @if($lanjutan)
          <span class="badge badge-green"><i class="fas fa-check" style="margin-right:3px;"></i>Lanjutan</span>
        @else
          <span class="badge" style="background:var(--slate-100);color:var(--slate-400);">Belum Lanjutan</span>
        @endif
      </div>
    </div>
    @empty
    <div class="empty-state">
      <i class="fas fa-baby"></i>
      <h3>Tidak ada data pemeriksaan</h3>
      <p>Tidak ada pemeriksaan balita pada periode ini.</p>
    </div>
    @endforelse
  </div>

  @if($pemeriksaans->hasPages())
  <div class="pagination-wrapper">
    <span class="page-info">
      Menampilkan {{ $pemeriksaans->firstItem() }}–{{ $pemeriksaans->lastItem() }}
      dari {{ $pemeriksaans->total() }} data
    </span>
    {{ $pemeriksaans->links('layouts.pagination') }}
  </div>
  @endif
</div>

@push('scripts')
<script>
function cetakPDF() {
  const periode   = @json(\Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y'));
  const dicetak   = @json(now()->translatedFormat('d F Y, H:i'));
  const total     = @json($stats['total']);
  const giziNorm  = @json($stats['gizi_normal']);
  const giziKurang= @json($stats['gizi_kurang']);
  const giziBuruk = @json($stats['gizi_buruk']);

  let baris = '';
  @forelse($pemeriksaans as $i => $pem)
  @php
    $b         = $pem->balita;
    $lanjutan  = $pem->pemeriksaanLanjutan;
    $no        = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    $namaOrtu  = $b->ibuHamil->nama_ibu ?? $b->nama_ibu ?? '-';
    $jk        = ($b->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan';
    $tlMapP    = [
      'kontrol'           => 'Kontrol Rutin',
      'rujukan_puskesmas' => 'Rujuk Puskesmas',
      'rujukan_rs'        => 'Rujuk RS',
      'rawat_inap'        => 'Rawat Inap',
    ];
    $tlLabelP  = $lanjutan && $lanjutan->tindak_lanjut
      ? ($tlMapP[$lanjutan->tindak_lanjut] ?? $lanjutan->tindak_lanjut)
      : 'Menunggu Bidan';
    $statusGizi = $lanjutan->status_gizi ?? '-';
    $keluhan    = $pem->keluhan ? \Illuminate\Support\Str::limit($pem->keluhan, 40) : 'Tidak ada keluhan';
    $tglPeriksa = \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y');
    $tglRelatif = \Carbon\Carbon::parse($pem->tanggal_periksa)->diffForHumans();
  @endphp
  baris += `
    <tr>
      <td style="padding:5px 4px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;">{{ $no }}</td>
      <td style="padding:5px 4px;border:1px solid #cbd5e1;vertical-align:middle;">
        <div style="font-weight:600;">{{ $b->nama_balita ?? '-' }}</div>
        <div style="font-size:9px;color:#64748b;">{{ $jk }}</div>
      </td>
      <td style="padding:5px 4px;border:1px solid #cbd5e1;vertical-align:middle;">
        <div style="font-weight:600;">{{ $namaOrtu }}</div>
        <div style="font-size:9px;color:#64748b;">{{ $b->ibuHamil->no_hp ?? '-' }}</div>
      </td>
      <td style="padding:5px 4px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;white-space:nowrap;">
        <div>${@json($tglPeriksa)}</div>
        <div style="font-size:9px;color:#64748b;">${@json($tglRelatif)}</div>
      </td>
      <td style="padding:5px 4px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;font-size:9px;line-height:1.3;white-space:nowrap;">
        <div>BB/TB : {{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }} / {{ $pem->tinggi_badan !== null ? fmtAngka($pem->tinggi_badan).' cm' : '-' }}</div>
        <div>LK/LL : {{ $pem->lingkar_kepala !== null ? fmtAngka($pem->lingkar_kepala).' cm' : '-' }} / {{ $pem->lingkar_lengan !== null ? fmtAngka($pem->lingkar_lengan).' cm' : '-' }}</div>
      </td>
      <td style="padding:5px 4px;border:1px solid #cbd5e1;vertical-align:middle;font-size:9px;">{{ $keluhan }}</td>
      <td style="padding:5px 4px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;">{{ $statusGizi }}</td>
      <td style="padding:5px 4px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;white-space:nowrap;">
        <div>Pem. Awal: Sudah</div>
        <div>Pem. Lanjutan: {{ $lanjutan ? 'Sudah' : 'Belum' }}</div>
      </td>
      <td style="padding:5px 4px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;font-size:9px;white-space:nowrap;">{{ $tlLabelP }}</td>
    </tr>
  `;
  @empty
  baris = `
    <tr>
      <td colspan="9" style="padding:16px;text-align:center;color:#64748b;border:1px solid #cbd5e1;font-style:italic;">
        Tidak ada data pemeriksaan pada periode ini.
      </td>
    </tr>
  `;
  @endforelse

  const html = `
    <!DOCTYPE html><html lang="id"><head>
      <meta charset="UTF-8">
      <title>Laporan Balita — ${periode}</title>
      <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:Arial,sans-serif;background:#fff;color:#000;}
        @page{size:A4 landscape;margin:10mm 12mm;}
        table{width:100%;border-collapse:collapse;}
        th,td{font-size:9px;}
      </style>
    </head><body>
      <div style="text-align:center;margin-bottom:14px;border-bottom:2px solid #1e293b;padding-bottom:10px;">
        <div style="font-size:18px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:1px;">POSYANDU MELATI 2</div>
        <div style="font-size:12px;font-weight:600;color:#475569;margin-top:4px;">LAPORAN PEMERIKSAAN BALITA</div>
        <div style="font-size:11px;color:#475569;margin-top:2px;">Periode: ${periode}</div>
        <div style="font-size:9px;color:#64748b;margin-top:3px;">Dicetak: ${dicetak} WIB</div>
      </div>
      <div style="display:flex;gap:12px;margin-bottom:14px;">
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:8px 12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#1e293b;">${total}</div>
          <div style="font-size:9px;color:#64748b;margin-top:2px;">Total Pemeriksaan</div>
        </div>
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:8px 12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#166534;">${giziNorm}</div>
          <div style="font-size:9px;color:#64748b;margin-top:2px;">Gizi Normal / Baik</div>
        </div>
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:8px 12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#9a3412;">${giziKurang}</div>
          <div style="font-size:9px;color:#64748b;margin-top:2px;">Gizi Kurang</div>
        </div>
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:8px 12px;text-align:center;">
          <div style="font-size:18px;font-weight:700;color:#991b1b;">${giziBuruk}</div>
          <div style="font-size:9px;color:#64748b;margin-top:2px;">Gizi Buruk / Stunting</div>
        </div>
      </div>
      <div style="font-size:10px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Rekap Pemeriksaan Balita</div>
      <table>
        <thead>
          <tr style="background:#f1f5f9;">
            <th style="padding:6px 4px;text-align:center;border:1px solid #cbd5e1;width:3%;">No</th>
            <th style="padding:6px 4px;text-align:left;border:1px solid #cbd5e1;width:13%;">Nama Balita</th>
            <th style="padding:6px 4px;text-align:left;border:1px solid #cbd5e1;width:13%;">Orang Tua</th>
            <th style="padding:6px 4px;text-align:center;border:1px solid #cbd5e1;width:10%;">Tanggal Periksa</th>
            <th style="padding:6px 4px;text-align:center;border:1px solid #cbd5e1;width:16%;">Hasil Ukur</th>
            <th style="padding:6px 4px;text-align:left;border:1px solid #cbd5e1;width:12%;">Keluhan</th>
            <th style="padding:6px 4px;text-align:center;border:1px solid #cbd5e1;width:10%;">Status Gizi</th>
            <th style="padding:6px 4px;text-align:center;border:1px solid #cbd5e1;width:11%;">Status</th>
            <th style="padding:6px 4px;text-align:center;border:1px solid #cbd5e1;width:12%;">Tindak Lanjut</th>
          </tr>
        </thead>
        <tbody>${baris}</tbody>
      </table>
      <div style="margin-top:24px;display:flex;justify-content:space-between;font-size:9px;color:#64748b;">
        <div>
          <div>* Dokumen ini dicetak otomatis dari Sistem Informasi Posyandu Melati 2.</div>
          <div>* Data yang ditampilkan sesuai filter periode yang dipilih.</div>
        </div>
        <div style="text-align:center;width:160px;">
          <div style="margin-bottom:40px;">Posyandu Melati 2</div>
          <div style="font-weight:700;border-top:1px solid #64748b;padding-top:4px;">Penanggung Jawab</div>
        </div>
      </div>
    </body></html>
  `;

  const w = window.open('', '_blank', 'width=1200,height=750');
  w.document.write(html);
  w.document.close();
  w.onload = function(){ w.focus(); w.print(); };
}
</script>

@endpush

@endsection