@extends('layouts.app')
@section('title', 'Pemeriksaan Lanjutan Balita')
@section('page_title', 'Pemeriksaan Lanjutan Balita')

@push('styles')
<style>
.empty-state{text-align:center;padding:40px 20px;color:var(--slate-400);}
.empty-state i{font-size:36px;margin-bottom:10px;display:block;opacity:.4;}
.empty-state h3{font-size:14px;font-weight:700;color:var(--slate-500);margin-bottom:4px;}
.empty-state p{font-size:12px;}
.data-table{width:100%;border-collapse:collapse;font-size:12px;}
.data-table thead th{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#94a3b8;padding:8px 10px;background:#f8fafc;border-bottom:1px solid #f1f5f9;text-align:center;white-space:nowrap;vertical-align:middle;}
.data-table thead th:nth-child(2){text-align:left;}
.data-table tbody td{padding:8px 10px;border-bottom:1px solid #f8fafc;vertical-align:middle;text-align:center;color:#334155;}
.data-table tbody td:nth-child(2){text-align:left;}
.data-table tbody tr:last-child td{border-bottom:none;}
.data-table tbody tr:hover td{background:#fafbff;}
.cell-name{font-weight:600;font-size:12px;color:#1e293b;}
.cell-meta{font-size:11px;color:#94a3b8;margin-top:1px;}
.badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;white-space:nowrap;}
.badge-green{background:#dcfce7;color:#16a34a;}
.badge-orange{background:#ffedd5;color:#ea580c;}
.badge-red{background:#fee2e2;color:#dc2626;}
.badge-blue{background:#eff6ff;color:#2563eb;}
.badge-count{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:20px;height:20px;padding:0 6px;border-radius:999px;
  background:#ef4444;color:#fff;font-size:11px;font-weight:700;margin-left:6px;line-height:1;
}
.row-menunggu{background:#fffbeb!important;border-left:3px solid #f59e0b;}
.row-menunggu:hover{background:#fef3c7!important;}
</style>
@endpush

@section('content')

<div class="page-header">
  <div class="page-header-left">
    <h2>Pemeriksaan Lanjutan Balita</h2>
    <p>Antrian & riwayat pemeriksaan lanjutan oleh Bidan</p>
  </div>
  <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Pemeriksaan
  </a>
</div>

@php $isStatusTab = in_array(request('status'), ['belum', 'sudah', 'semua']); @endphp

<div class="tabs">
  <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index', array_filter(['search' => request('search'), 'status' => 'semua'])) }}"
     class="tab {{ request('status') === 'semua' ? 'active' : '' }}">
    <i class="fas fa-list"></i> Semua
    @if($totalSemua > 0)
      <span class="badge-count" style="background:#64748b;">{{ $totalSemua }}</span>
    @endif
  </a>
  <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index', array_filter(['search' => request('search'), 'status' => 'belum'])) }}"
     class="tab {{ request('status') === 'belum' ? 'active' : '' }}">
    <i class="fas fa-clock"></i> Menunggu Pemeriksaan
    @if($totalMenunggu > 0)
      <span class="badge-count">{{ $totalMenunggu }}</span>
    @endif
  </a>
  <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index', array_filter(['search' => request('search'), 'status' => 'sudah'])) }}"
     class="tab {{ request('status') === 'sudah' ? 'active' : '' }}">
    <i class="fas fa-check-circle"></i> Sudah Diperiksa
  </a>
</div>

<div class="card" style="margin-bottom:16px;">
  <form method="GET" action="{{ route('bidan.pemeriksaan-lanjutan-balita.index') }}"
        id="filter-form-plb"
        style="padding:12px 16px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    @if($isStatusTab)
      <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;">
      <i class="fas fa-calendar-day" style="color:#14a398;font-size:13px;"></i>
      <input type="date" name="tanggal" value="{{ request('tanggal') }}"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;font-weight:600;outline:none;cursor:pointer;"
             onchange="this.form.submit()">
    </div>
    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;flex:1;max-width:260px;">
      <i class="fas fa-search" style="color:#94a3b8;font-size:12px;flex-shrink:0;"></i>
      <input type="text" name="search" id="inp-search-plb" value="{{ request('search') }}"
             placeholder="Nama balita…"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;outline:none;width:100%;">
    </div>
    <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index', ['reset' => 1]) }}"
       class="btn btn-outline btn-sm">
      <i class="fas fa-times"></i> Reset
    </a>
  </form>
</div>

@php
$statusGiziMap = [
  'gizi baik'   => ['Gizi Baik',   'badge-green'],
  'gizi normal' => ['Gizi Normal', 'badge-green'],
  'gizi kurang' => ['Gizi Kurang', 'badge-orange'],
  'gizi buruk'  => ['Gizi Buruk',  'badge-red'],
  'stunting'    => ['Stunting',    'badge-red'],
  'gizi lebih'  => ['Gizi Lebih',  'badge-blue'],
];
@endphp

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Daftar Pemeriksaan Balita</div>
      <div class="card-subtitle">{{ $totalSemua }} data terdaftar · {{ $pemeriksaans->total() }} ditampilkan</div>
    </div>
  </div>
  <div class="rt-wrap">
  <div class="table-scroll">
    <table class="data-table">
      <thead>
        <tr>
          <th class="col-hide-mobile">No</th>
          <th class="col-nama-data">Nama Balita</th>
          <th class="col-hide-mobile">Tgl Periksa</th>
          <th class="col-hide-mobile">Kader</th>
          <th class="col-hide-mobile">Usia</th>
          <th class="col-hide-mobile">BB</th>
          <th class="col-hide-mobile">TB</th>
          <th class="col-hide-mobile">Keluhan</th>
          <th class="col-hide-mobile">Status Lanjutan</th>
          <th class="col-hide-mobile">Status Gizi</th>
          <th class="col-aksi">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaans as $i => $awal)
        @php
          $balita   = $awal->balita;
          $lanjutan = $awal->pemeriksaanLanjutan;
          $usia     = $awal->usia_balita ?? ($balita?->tanggal_lahir
              ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($awal->tanggal_periksa)
              : 0);
          $usiaLbl  = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
          $sgKey = strtolower(trim($lanjutan->status_gizi ?? ''));
          [$sgLabel, $sgBadge] = $statusGiziMap[$sgKey] ?? [$lanjutan->status_gizi ?? '-', 'badge-green'];
        @endphp
        <tr class="{{ !$lanjutan ? 'row-menunggu' : '' }}">
          <td class="col-hide-mobile">{{ ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1 }}</td>
          <td class="col-nama-data">
            <div class="cell-name">{{ $balita->nama_balita ?? '-' }}</div>
            <div class="cell-meta">NIK: {{ $balita->nik ?? '-' }}</div>
          </td>
          <td style="white-space:nowrap;" class="col-hide-mobile">{{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d M Y') }}</td>
          <td class="col-hide-mobile">{{ $awal->kader->nama ?? '-' }}</td>
          <td class="col-hide-mobile">{{ $usiaLbl }}</td>
          <td class="col-hide-mobile">{{ fmtAngka($awal->berat_badan) }} kg</td>
          <td class="col-hide-mobile">{{ fmtAngka($awal->tinggi_badan) }} cm</td>
          <td style="max-width:140px;text-align:center;" class="col-hide-mobile">
            @if($awal->keluhan)
              <div style="font-size:11px;color:#475569;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $awal->keluhan }}</div>
            @else
              <span style="font-size:11px;color:#cbd5e1;font-style:italic;">Tidak ada</span>
            @endif
          </td>
          <td class="col-hide-mobile">
            @if($lanjutan)
              <span class="badge badge-green">Sudah Diperiksa</span>
              <div class="cell-meta" style="margin-top:3px;">{{ \Carbon\Carbon::parse($lanjutan->tanggal_periksa)->translatedFormat('d M Y') }}</div>
            @else
              <span class="badge badge-orange">Menunggu Bidan</span>
            @endif
          </td>
          <td class="col-hide-mobile">
            @if($lanjutan)
              <span class="badge {{ $sgBadge }}">{{ $sgLabel }}</span>
            @else
              <span style="color:#cbd5e1;">-</span>
            @endif
          </td>
          <td class="col-aksi">
            <div style="display:flex;justify-content:center;gap:5px;">
              @if($lanjutan)
                @php
                  $detailLanjB = json_encode([
                    'Nama Balita'    => $balita->nama_balita ?? '-',
                    'Tanggal Periksa'=> \Carbon\Carbon::parse($lanjutan->tanggal_periksa)->translatedFormat('d M Y'),
                    'Usia'           => $usiaLbl,
                    'Berat Badan'    => fmtAngka($lanjutan->berat_badan).' kg',
                    'Tinggi Badan'   => fmtAngka($lanjutan->tinggi_badan).' cm',
                    'Status Gizi'    => $sgLabel,
                    'Tindak Lanjut'  => $lanjutan->tindak_lanjut ?? '-',
                    'Bidan'          => $lanjutan->bidan->nama ?? '-',
                    'Catatan'        => $lanjutan->catatan_bidan ?? '-',
                  ]);
                @endphp
                <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.show', $lanjutan) }}" class="btn btn-view btn-sm"
                   data-title="{{ $balita->nama_balita ?? '-' }}"
                   data-detail="{{ $detailLanjB }}"
                   onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))"><i class="fas fa-eye"></i></a>
                <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.edit', $lanjutan) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="confirmDelete('{{ route('bidan.pemeriksaan-lanjutan-balita.destroy', $lanjutan) }}','{{ $balita->nama_balita ?? 'ini' }}')">
                  <i class="fas fa-trash"></i>
                </button>
              @else
                <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.create', ['pemeriksaan_awal_id' => $awal->id]) }}"
                   class="btn btn-primary btn-sm"><i class="fas fa-stethoscope"></i> Periksa</a>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="11">
            <div class="empty-state">
              <i class="fas fa-baby"></i>
              <h3>Belum ada data pemeriksaan balita</h3>
              <p>Belum ada data dari kader.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ═══ MOBILE CARD LIST ═══ --}}
  <div class="mobile-list" style="padding:10px 14px;">
    @forelse($pemeriksaans as $i => $awal)
    @php
      $balita   = $awal->balita;
      $lanjutan = $awal->pemeriksaanLanjutan;
      $usia     = $awal->usia_balita ?? ($balita?->tanggal_lahir
          ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($awal->tanggal_periksa) : 0);
      $usiaLbl  = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
      $sgKey = strtolower(trim($lanjutan->status_gizi ?? ''));
      [$sgLabel, $sgBadge] = $statusGiziMap[$sgKey] ?? [$lanjutan->status_gizi ?? '-', 'badge-green'];
      $no = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    @endphp
    <div class="rec-card {{ !$lanjutan ? 'row-menunggu' : '' }}" style="{{ !$lanjutan ? 'border-left:3px solid #f59e0b;' : '' }}">
      <div class="rec-card-header">
        <div>
          <div class="rec-name">{{ $balita->nama_balita ?? '-' }}</div>
          <div class="rec-sub">{{ $usiaLbl }} &bull; {{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d M Y') }}</div>
        </div>
        <div class="rec-actions">
          <span class="no-badge">#{{ $no }}</span>
          @if($lanjutan)
            <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.show', $lanjutan) }}" class="btn btn-view btn-sm"><i class="fas fa-eye"></i></a>
            <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.edit', $lanjutan) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm"
                    onclick="confirmDelete('{{ route('bidan.pemeriksaan-lanjutan-balita.destroy', $lanjutan) }}','{{ $balita->nama_balita ?? 'ini' }}')">
              <i class="fas fa-trash"></i>
            </button>
          @else
            <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.create', ['pemeriksaan_awal_id' => $awal->id]) }}"
               class="btn btn-primary btn-sm"><i class="fas fa-stethoscope"></i> Periksa</a>
          @endif
        </div>
      </div>
      <hr class="rec-divider">
      <div class="rec-grid">
        <div class="rec-field">
          <label>BB / TB</label>
          <div class="val">{{ fmtAngka($awal->berat_badan) }} kg / {{ fmtAngka($awal->tinggi_badan) }} cm</div>
        </div>
        <div class="rec-field">
          <label>Kader</label>
          <div class="val">{{ $awal->kader->nama ?? '-' }}</div>
        </div>
        <div class="rec-field" style="grid-column:span 2;">
          <label>Status Lanjutan</label>
          <div class="val" style="font-weight:400;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            @if($lanjutan)
              <span class="badge badge-green">Sudah Diperiksa</span>
              @if($sgLabel && $sgLabel !== '-')
                <span class="badge {{ $sgBadge }}">{{ $sgLabel }}</span>
              @endif
            @else
              <span class="badge badge-orange">Menunggu Bidan</span>
            @endif
          </div>
        </div>
        @if($awal->keluhan)
        <div class="rec-field" style="grid-column:span 2;">
          <label>Keluhan</label>
          <div class="val" style="font-weight:400;">{{ \Illuminate\Support\Str::limit($awal->keluhan, 80) }}</div>
        </div>
        @endif
      </div>
    </div>
    @empty
    <div class="empty-state">
      <i class="fas fa-baby"></i>
      <h3>Belum ada data pemeriksaan balita</h3>
      <p>Belum ada data dari kader.</p>
    </div>
    @endforelse
  </div>
  </div>{{-- end rt-wrap --}}

  @if($pemeriksaans->hasPages())
  <div class="pagination-wrapper">
    <span class="page-info">Menampilkan {{ $pemeriksaans->firstItem() }}–{{ $pemeriksaans->lastItem() }} dari {{ $pemeriksaans->total() }} data</span>
    {{ $pemeriksaans->links('layouts.pagination') }}
  </div>
  @endif
</div>



<div id="delete-modal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
  <div style="position:absolute;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(2px);" onclick="closeDelete()"></div>
  <div style="position:relative;background:#fff;border-radius:14px;padding:20px;width:100%;max-width:340px;box-shadow:0 20px 60px rgba(0,0,0,.15);text-align:center;">
    <div style="width:44px;height:44px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
      <i class="fas fa-trash" style="font-size:16px;color:#ef4444;"></i>
    </div>
    <div style="font-size:15px;font-weight:800;color:#1e293b;margin-bottom:5px;">Hapus Data Pemeriksaan?</div>
    <div style="font-size:12px;color:#64748b;margin-bottom:14px;">Data pemeriksaan lanjutan <strong id="delete-nama"></strong> akan dihapus permanen.</div>
    <div style="display:flex;gap:8px;justify-content:center;">
      <button onclick="closeDelete()" class="btn btn-outline" style="flex:1;padding:7px 12px;">Batal</button>
      <form id="delete-form" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger" style="width:100%;padding:7px 12px;"><i class="fas fa-trash"></i> Hapus</button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(url, nama) {
  document.getElementById('delete-nama').textContent = nama;
  document.getElementById('delete-form').action = url;
  document.getElementById('delete-modal').style.display = 'flex';
}
function closeDelete() {
  document.getElementById('delete-modal').style.display = 'none';
}

const searchInputPlb = document.getElementById('inp-search-plb');
let searchTimerPlb;
if (searchInputPlb) {
  searchInputPlb.addEventListener('input', function(){
    clearTimeout(searchTimerPlb);
    searchTimerPlb = setTimeout(() => {
      sessionStorage.setItem('searchFocusPlb', '1');
      this.closest('form').submit();
    }, 700);
  });
  if (sessionStorage.getItem('searchFocusPlb')) {
    sessionStorage.removeItem('searchFocusPlb');
    searchInputPlb.focus();
    const len = searchInputPlb.value.length;
    searchInputPlb.setSelectionRange(len, len);
  }
}
</script>
@endpush