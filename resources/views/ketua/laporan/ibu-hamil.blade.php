@extends('layouts.app')
@section('title', 'Laporan Pemeriksaan Ibu Hamil')
@section('page_title', 'Laporan Ibu Hamil')

@push('styles')
<style>
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

/* ── Top bar ── */
.page-topbar {
  display:flex;align-items:center;gap:8px;margin-bottom:20px;flex-wrap:wrap;
}
.page-topbar .actions {
  margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;
}

/* Stats styling consolidated globally in layouts/app.blade.php */

/* ── Table ── */
.empty-state { text-align:center;padding:48px 20px;color:var(--slate-400); }
.empty-state i { font-size:36px;margin-bottom:10px;display:block;opacity:.4; }
.empty-state h3 { font-size:15px;font-weight:700;color:var(--slate-500);margin-bottom:4px; }
.empty-state p  { font-size:13px; }
.data-table th,.data-table td { text-align:center;vertical-align:middle; }
.data-table td:nth-child(2),.data-table th:nth-child(2) { text-align:left; }
.card-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px; }
.btn-success { background:#dcfce7;color:#166534;border:none; }
.btn-success:hover { background:#bbf7d0; }

/* ────────────────────────────────────────────
   MOBILE CARD LIST
──────────────────────────────────────────── */
.mobile-list { display:none; }

.rec-card {
  background:#fff;border:1.5px solid var(--slate-200);border-radius:14px;
  padding:14px 16px;margin-bottom:12px;
}
.rec-card-header {
  display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:10px;
}
.rec-card-header .no-badge {
  font-size:10px;color:var(--slate-400);font-weight:600;
  background:var(--slate-100);border-radius:6px;padding:2px 8px;flex-shrink:0;
}
.rec-name { font-weight:700;font-size:14px;color:var(--slate-800); }
.rec-sub  { font-size:11px;color:var(--slate-400);margin-top:1px; }

.rec-grid {
  display:grid;grid-template-columns:1fr 1fr;gap:8px 12px;
  font-size:12px;color:var(--slate-700);
}
.rec-field label {
  display:block;font-size:10px;font-weight:600;color:var(--slate-400);
  text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px;
}
.rec-field .val { font-weight:600; }
.rec-divider { border:none;border-top:1px solid var(--slate-100);margin:10px 0; }
.rec-footer  { display:flex;align-items:center;flex-wrap:wrap;gap:6px; }

/* ── Responsive ── */
/* Removed local max-width:900px stats query */

@media(max-width:767px){
    .filter-compact .filter-row {
      flex-wrap: wrap;
    }
    .filter-compact .fg-bulan,
    .filter-compact .fg-tahun  { width: calc(50% - 5px); }
    .filter-compact .fg-search { width: 100%; flex-basis: 100%; }
    .filter-compact .fg-actions { width: 100%; }
    .filter-compact .fg-actions .btn { flex: 1; justify-content: center; }
  /* topbar */
  .page-topbar { flex-direction:column;align-items:flex-start; }
  .page-topbar .actions {
    margin-left:0;width:100%;
    display:grid;grid-template-columns:1fr 1fr;gap:8px;
  }
  .page-topbar .actions .btn { width:100%;justify-content:center;text-align:center; }

  /* stats: 2-col removed */

  /* filter */
  .filter-form-inner {
    flex-direction:column !important;align-items:stretch !important;
  }
  .filter-form-inner .form-group,
  .filter-form-inner .search-bar { width:100% !important; }
  .filter-form-inner .btn { width:100%; }

  /* hide table, show cards */
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

  /* Stats grid 1-col removed */
  .rec-grid { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')

<div class="page-topbar">
  <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
    <span style="font-size:18px;font-weight:700;color:var(--slate-700);">Laporan Pemeriksaan Ibu Hamil</span>
  </div>
  <div class="actions">
    <a href="{{ route('ketua.laporan.balita', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
       class="btn btn-outline btn-sm laporan-nav-btn">
      <i class="fas fa-baby"></i> Laporan Balita
    </a>
    <a href="{{ route('ketua.laporan.ibu-hamil.export', ['bulan'=>$bulan,'tahun'=>$tahun,'search'=>request('search')]) }}"
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
  <form method="GET" action="{{ route('ketua.laporan.ibu-hamil') }}" class="filter-compact">
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
        <label class="form-label">Cari Nama Ibu</label>
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" name="search" value="{{ request('search') }}"
                 placeholder="Nama ibu hamil…">
        </div>
      </div>

      <div class="fg-actions">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-filter"></i> Terapkan
        </button>
        @if(request('search'))
          <a href="{{ route('ketua.laporan.ibu-hamil', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
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
    $statsConfig = [
      ['val'=>$stats['total'],   'label'=>'Total Pemeriksaan', 'cardClass'=>'card-teal',  'iconClass'=>'icon-teal',  'icon'=>'fa-clipboard-list'],
      ['val'=>$stats['normal'],  'label'=>'Awal & Lanjutan',   'cardClass'=>'card-green', 'iconClass'=>'icon-green', 'icon'=>'fa-check-circle'],
      ['val'=>$stats['rujukan'], 'label'=>'Pemeriksaan Awal',  'cardClass'=>'card-amber', 'iconClass'=>'icon-amber', 'icon'=>'fa-clock'],
    ];
  @endphp
  @foreach($statsConfig as $s)
  <div class="stat-card {{ $s['cardClass'] }}">
    <div class="stat-icon {{ $s['iconClass'] }}"><i class="fas {{ $s['icon'] }}"></i></div>
    <div class="stat-value">{{ $s['val'] }}</div>
    <div class="stat-label">{{ $s['label'] }}</div>
    <div class="stat-delta" style="color:var(--slate-400);">{{ \Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y') }}</div>
  </div>
  @endforeach
</div>

<!-- Status Pemeriksaan Donut Chart removed (duplicate of statistics cards above) -->

{{-- Card wrapper --}}
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Rekap Pemeriksaan Ibu Hamil</div>
      <div class="card-subtitle">
        Periode: {{ \Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y') }}
      </div>
    </div>
    <span style="font-size:13px;color:var(--slate-500);">
      {{ $pemeriksaans->total() }} data ditemukan
    </span>
  </div>

  {{-- ═══ DESKTOP TABLE ═══ --}}
  <div class="table-scroll">
    <table class="data-table">
      <thead>
        <tr>
          <th class="col-hide-mobile">No</th>
          <th class="col-nama-data">Nama Ibu</th>
          <th class="col-hide-mobile">Status Kehamilan</th>
          <th class="col-hide-mobile">Tanggal Periksa</th>
          <th class="col-hide-mobile">Hasil Periksa</th>
          <th class="col-hide-mobile">Status Pemeriksaan</th>
          <th class="col-hide-mobile">Tindak Lanjut</th>
          <th class="col-aksi">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaans as $i => $pem)
        @php
          $ibu      = $pem->ibuHamil;
          $lanjutan = $pem->pemeriksaanLanjutan;
        @endphp
        <tr>
          <td style="color:var(--slate-400);font-size:12px;" class="col-hide-mobile">
            {{ ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1 }}
          </td>
          <td class="col-nama-data">
            <div class="cell-name">{{ $ibu->nama_ibu ?? '-' }}</div>
            <div class="cell-meta">NIK: {{ $ibu->nik ?? '-' }}</div>
          </td>
          <td class="col-hide-mobile">
            @if($ibu && $ibu->gravida !== null)
              <span class="badge badge-purple">G{{ $ibu->gravida }}P{{ $ibu->partus }}A{{ $ibu->abortus }}</span>
            @else
              <span class="badge" style="background:var(--slate-100);color:var(--slate-400);">-</span>
            @endif
            <div class="cell-meta" style="margin-top:4px;">
              {{ $ibu && $ibu->hpht ? (int)\Carbon\Carbon::parse($ibu->hpht)->diffInWeeks(now()).' minggu' : '-' }}
            </div>
          </td>
          <td class="col-hide-mobile">
            <div class="cell-name">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}</div>
            <div class="cell-meta">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->diffForHumans() }}</div>
          </td>
          <td class="col-hide-mobile">
            <div style="display:flex; flex-direction:column; align-items:center; gap:2px; font-size:11.5px; color:var(--slate-600);">
              <div>BB/TD : {{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }} / {{ $pem->tekanan_darah ?? '-' }}</div>
              <div>LILA/TFU/DJJ : {{ $lanjutan && $lanjutan->lila !== null ? fmtAngka($lanjutan->lila) : '-' }} / {{ $lanjutan && $lanjutan->tfu !== null ? fmtAngka($lanjutan->tfu) : '-' }} / {{ $lanjutan && $lanjutan->djj !== null ? (int)$lanjutan->djj : '-' }}</div>
            </div>
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
                [$tlLabel, $tlBadge] = $tlMap[$lanjutan->tindak_lanjut] ?? [$lanjutan->tindak_lanjut, 'badge-teal'];
              @endphp
              <span class="badge {{ $tlBadge }}" style="white-space:nowrap;">{{ $tlLabel }}</span>
            @else
              <span class="badge badge-orange" style="white-space:nowrap;">Menunggu Bidan</span>
            @endif
          </td>
          <td class="col-aksi">
            @php
              $detailIbu = json_encode([
                'Nama Ibu'       => $ibu->nama_ibu ?? '-',
                'NIK'            => $ibu->nik ?? '-',
                'Status Obstetri'=> ($ibu && $ibu->gravida !== null) ? 'G'.$ibu->gravida.' P'.$ibu->partus.' A'.$ibu->abortus : '-',
                'Tanggal Periksa'=> \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y'),
                'BB / TD'        => ($pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-').' / '.($pem->tekanan_darah ?? '-'),
                'LILA/TFU/DJJ'   => ($lanjutan && $lanjutan->lila !== null ? fmtAngka($lanjutan->lila).' cm' : '-').' / '.($lanjutan && $lanjutan->tfu !== null ? fmtAngka($lanjutan->tfu).' cm' : '-').' / '.($lanjutan && $lanjutan->djj !== null ? (int)$lanjutan->djj.' x/mnt' : '-'),
                'Status'         => $lanjutan ? 'Lengkap' : 'Menunggu Bidan',
              ]);
            @endphp
            <a href="{{ route('ketua.laporan.ibu-hamil.detail', $ibu->id) }}"
               class="btn btn-view btn-sm" title="Detail"
               data-title="{{ $ibu->nama_ibu ?? '-' }}"
               data-detail="{{ $detailIbu }}"
               onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))">
              <i class="fas fa-eye"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8">
            <div class="empty-state">
              <i class="fas fa-file-medical"></i>
              <h3>Tidak ada data pemeriksaan</h3>
              <p>Tidak ada pemeriksaan ibu hamil pada
                {{ \Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y') }}.
              </p>
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
      $ibu      = $pem->ibuHamil;
      $lanjutan = $pem->pemeriksaanLanjutan;
      $no       = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
      $statusObs = $ibu && $ibu->gravida !== null
        ? 'G'.$ibu->gravida.'P'.$ibu->partus.'A'.$ibu->abortus
        : '-';
      $usiaHamil = $ibu && $ibu->hpht
        ? (int)\Carbon\Carbon::parse($ibu->hpht)->diffInWeeks(now()).' minggu'
        : '-';
    @endphp
    <div class="rec-card">
      {{-- Header --}}
      <div class="rec-card-header">
        <div>
          <div class="rec-name">{{ $ibu->nama_ibu ?? '-' }}</div>
          <div class="rec-sub">
            NIK: {{ $ibu->nik ?? '-' }}
            &bull;
            <span class="badge badge-purple" style="font-size:10px;padding:1px 6px;">
              {{ $statusObs }}
            </span>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
          <span class="no-badge">#{{ $no }}</span>
          <a href="{{ route('ketua.laporan.ibu-hamil.detail', $ibu->id) }}"
             class="btn btn-view btn-sm" title="Detail">
            <i class="fas fa-eye"></i>
          </a>
        </div>
      </div>

      <hr class="rec-divider">

      <div class="rec-grid">
        <div class="rec-field">
          <label>Usia Kehamilan</label>
          <div class="val">{{ $usiaHamil }}</div>
        </div>
        <div class="rec-field">
          <label>Tgl Periksa</label>
          <div class="val">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}</div>
          <div style="font-size:11px;color:var(--slate-400);">
            {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->diffForHumans() }}
          </div>
        </div>
        <div class="rec-field">
          <label>Berat Badan</label>
          <div class="val">{{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Tekanan Darah</label>
          <div class="val">{{ $pem->tekanan_darah ?? '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Kader Pemeriksa</label>
          <div class="val">{{ $pem->kader->nama ?? '-' }}</div>
        </div>
        <div class="rec-field">
          <label>Bidan Pemeriksa</label>
          <div class="val">{{ $lanjutan && $lanjutan->bidan ? $lanjutan->bidan->nama : '-' }}</div>
        </div>
      </div>

      <hr class="rec-divider">

      <div class="rec-footer">
        {{-- Pemeriksaan Awal --}}
        <span class="badge badge-green">
          <i class="fas fa-check" style="margin-right:3px;"></i>Pem. Awal
        </span>

        {{-- Pemeriksaan Lanjutan --}}
        @if($lanjutan)
          <span class="badge badge-green">
            <i class="fas fa-check" style="margin-right:3px;"></i>Sudah Lanjutan
          </span>
        @else
          <span class="badge" style="background:var(--slate-100);color:var(--slate-400);">Belum Lanjutan</span>
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
        @endif
      </div>
    </div>
    @empty
    <div class="empty-state">
      <i class="fas fa-file-medical"></i>
      <h3>Tidak ada data pemeriksaan</h3>
      <p>Tidak ada pemeriksaan ibu hamil pada periode ini.</p>
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
  const periode  = @json(\Carbon\Carbon::createFromDate($tahun,$bulan,1)->locale('id')->translatedFormat('F Y'));
  const dicetak  = @json(now()->translatedFormat('d F Y, H:i'));
  const total    = @json($stats['total']);
  const normal   = @json($stats['normal']);
  const rujukan  = @json($stats['rujukan']);

  let baris = '';
  @forelse($pemeriksaans as $i => $pem)
  @php
    $ibu      = $pem->ibuHamil;
    $lanjutan = $pem->pemeriksaanLanjutan;
    $no       = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    $statusObs = $ibu && $ibu->gravida !== null
      ? 'G'.$ibu->gravida.'P'.$ibu->partus.'A'.$ibu->abortus
      : '-';
    $usiaHamil = $ibu && $ibu->hpht
      ? (int)\Carbon\Carbon::parse($ibu->hpht)->diffInWeeks(now()).' minggu'
      : '-';
    $tlMapP = [
      'kontrol'           => 'Kontrol Rutin',
      'rujukan_puskesmas' => 'Rujuk Puskesmas',
      'rujukan_rs'        => 'Rujuk RS',
      'rawat_inap'        => 'Rawat Inap',
    ];
    $tlLabelP  = $lanjutan && $lanjutan->tindak_lanjut ? ($tlMapP[$lanjutan->tindak_lanjut] ?? $lanjutan->tindak_lanjut) : 'Menunggu Bidan';
    $tglPeriksa = \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y');
    $tglRelatif = \Carbon\Carbon::parse($pem->tanggal_periksa)->diffForHumans();
  @endphp
  baris += `
    <tr>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;">{{ $no }}</td>
      <td style="padding:6px 5px;border:1px solid #cbd5e1;vertical-align:middle;">
        <div style="font-weight:600;font-size:10px;">{{ $ibu->nama_ibu ?? '-' }}</div>
        <div style="font-size:9px;color:#64748b;">NIK: {{ $ibu->nik ?? '-' }}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;">
        <div style="font-weight:600;">{{ $statusObs }}</div>
        <div style="font-size:9px;color:#64748b;">{{ $usiaHamil }}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;white-space:nowrap;">
        <div>${@json($tglPeriksa)}</div>
        <div style="font-size:9px;color:#64748b;">${@json($tglRelatif)}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;font-size:9px;line-height:1.3;white-space:nowrap;">
        <div>BB/TD : {{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }} / {{ $pem->tekanan_darah ?? '-' }}</div>
        <div>LILA/TFU/DJJ : {{ $lanjutan && $lanjutan->lila !== null ? fmtAngka($lanjutan->lila) : '-' }} / {{ $lanjutan && $lanjutan->tfu !== null ? fmtAngka($lanjutan->tfu) : '-' }} / {{ $lanjutan && $lanjutan->djj !== null ? (int)$lanjutan->djj : '-' }}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;white-space:nowrap;">
        <div>Pem. Awal: Sudah</div>
        <div>Pem. Lanjutan: {{ $lanjutan ? 'Sudah' : 'Belum' }}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:middle;white-space:nowrap;">
        {{ $tlLabelP }}
      </td>
    </tr>
  `;
  @empty
  baris = `
    <tr>
      <td colspan="7" style="padding:16px;text-align:center;color:#64748b;border:1px solid #cbd5e1;font-style:italic;">
        Tidak ada data pemeriksaan pada periode ini.
      </td>
    </tr>
  `;
  @endforelse

  const html = `
    <!DOCTYPE html><html lang="id"><head>
      <meta charset="UTF-8">
      <title>Laporan Ibu Hamil — ${periode}</title>
      <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:Arial,sans-serif;background:#fff;color:#000;}
        @page{size:A4 landscape;margin:12mm 15mm;}
        table{width:100%;border-collapse:collapse;}
        th,td{font-size:10px;}
      </style>
    </head><body>
      <div style="text-align:center;margin-bottom:16px;border-bottom:2px solid #1e293b;padding-bottom:12px;">
        <div style="font-size:20px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:1px;">POSYANDU MELATI 2</div>
        <div style="font-size:13px;font-weight:600;color:#475569;margin-top:4px;">LAPORAN PEMERIKSAAN IBU HAMIL</div>
        <div style="font-size:11px;color:#475569;margin-top:2px;">Periode: ${periode}</div>
        <div style="font-size:10px;color:#64748b;margin-top:4px;">Dicetak: ${dicetak} WIB</div>
      </div>
      <div style="display:flex;gap:16px;margin-bottom:16px;">
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:10px 14px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#1e293b;">${total}</div>
          <div style="font-size:10px;color:#64748b;margin-top:2px;">Total Pemeriksaan</div>
        </div>
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:10px 14px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#166534;">${normal}</div>
          <div style="font-size:10px;color:#64748b;margin-top:2px;">Awal & Lanjutan</div>
        </div>
        <div style="flex:1;border:1px solid #cbd5e1;border-radius:8px;padding:10px 14px;text-align:center;">
          <div style="font-size:20px;font-weight:700;color:#991b1b;">${rujukan}</div>
          <div style="font-size:10px;color:#64748b;margin-top:2px;">Pemeriksaan Awal</div>
        </div>
      </div>
      <div style="font-size:11px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Rekap Pemeriksaan Ibu Hamil</div>
      <table>
        <thead>
          <tr style="background:#f1f5f9;">
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:4%;">No</th>
            <th style="padding:7px 5px;text-align:left;border:1px solid #cbd5e1;width:20%;">Nama Ibu</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:14%;">Status Kehamilan</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:14%;">Tanggal Periksa</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:20%;">Hasil Periksa</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:14%;">Status</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:14%;">Tindak Lanjut</th>
          </tr>
        </thead>
        <tbody>${baris}</tbody>
      </table>
      <div style="margin-top:30px;display:flex;justify-content:space-between;font-size:10px;color:#64748b;">
        <div>
          <div>* Dokumen ini dicetak otomatis dari Sistem Informasi Posyandu Melati 2.</div>
          <div>* Data yang ditampilkan sesuai filter periode yang dipilih.</div>
        </div>
        <div style="text-align:center;width:180px;">
          <div style="margin-bottom:45px;">Posyandu Melati 2</div>
          <div style="font-weight:700;border-top:1px solid #64748b;padding-top:4px;">Penanggung Jawab</div>
        </div>
      </div>
    </body></html>
  `;

  const w = window.open('', '_blank', 'width=1100,height=700');
  w.document.write(html);
  w.document.close();
  w.onload = function(){ w.focus(); w.print(); };
}
</script>

<!-- Status Pemeriksaan Donut Chart script removed -->
@endpush


@endsection