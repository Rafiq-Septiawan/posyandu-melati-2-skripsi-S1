@extends('layouts.app')
@section('title', 'Pemeriksaan Awal Ibu Hamil')
@section('page_title', 'Pemeriksaan Awal Ibu Hamil')

@push('styles')
<style>
.empty-state{text-align:center;padding:48px 20px;color:var(--slate-400);}
.empty-state i{font-size:40px;margin-bottom:12px;display:block;opacity:.4;}
.empty-state h3{font-size:15px;font-weight:700;color:var(--slate-500);margin-bottom:6px;}
.empty-state p{font-size:13px;}
.data-table th,.data-table td{text-align:center;vertical-align:middle;}
.badge-count{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:20px;height:20px;padding:0 6px;border-radius:999px;
  background:#ef4444;color:#fff;font-size:11px;font-weight:700;margin-left:6px;line-height:1;
}
</style>
@endpush

@section('content')

<div class="page-header">
  <div class="page-header-left">
    <h2>Pemeriksaan Awal Ibu Hamil</h2>
    <p>Data pemeriksaan yang Anda catat sebagai Kader</p>
  </div>
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Catat Pemeriksaan
  </a>
</div>

@php $isPeriodeTab = in_array(request('periode'), ['semua','hari_ini','bulan_ini']); @endphp

<div class="tabs">
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index', array_filter(['search' => request('search'), 'periode' => 'semua'])) }}"
     class="tab {{ request('periode') === 'semua' ? 'active' : '' }}">
    <i class="fas fa-list"></i> Semua
    @if($totalSemua > 0)
      <span class="badge-count" style="background:#64748b;">{{ $totalSemua }}</span>
    @endif
  </a>
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index', array_filter(['search' => request('search'), 'periode' => 'hari_ini'])) }}"
     class="tab {{ request('periode') === 'hari_ini' ? 'active' : '' }}">
    <i class="fas fa-calendar-day"></i> Hari Ini
    @if($totalHariIni > 0)
      <span class="badge-count">{{ $totalHariIni }}</span>
    @endif
  </a>
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index', array_filter(['search' => request('search'), 'periode' => 'bulan_ini'])) }}"
     class="tab {{ request('periode') === 'bulan_ini' ? 'active' : '' }}">
    <i class="fas fa-calendar-alt"></i> Bulan Ini
    @if($totalBulanIni > 0)
      <span class="badge-count" style="background:#14a398;">{{ $totalBulanIni }}</span>
    @endif
  </a>
</div>

<div class="card" style="margin-bottom:20px;">
  <form method="GET" action="{{ route('kader.pemeriksaan-awal-ibu-hamil.index') }}"
        id="filter-form"
        style="padding:14px 20px;display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
    @if($isPeriodeTab)
      <input type="hidden" name="periode" value="{{ request('periode') }}">
    @endif

    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;">
      <i class="fas fa-calendar-day" style="color:#14a398;font-size:13px;"></i>
      <input type="date" name="tanggal" value="{{ request('tanggal') }}"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;font-weight:600;outline:none;cursor:pointer;"
             onchange="this.form.submit()">
    </div>

    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;flex:1;max-width:280px;">
      <i class="fas fa-search" style="color:#94a3b8;font-size:12px;flex-shrink:0;"></i>
      <input type="text" name="search" id="inp-search-paih" value="{{ request('search') }}"
             placeholder="Nama ibu hamil…"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;outline:none;width:100%;">
    </div>

    <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index', ['reset' => 1]) }}"
       class="btn btn-outline btn-sm">
      <i class="fas fa-times"></i> Reset
    </a>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Daftar Pemeriksaan Awal</div>
      <div class="card-subtitle">{{ $totalSemua }} data terdaftar · {{ $pemeriksaans->total() }} ditampilkan</div>
    </div>
  </div>

  <div class="rt-wrap">
  <div class="table-scroll">
  <table class="data-table">
    <thead>
      <tr>
        <th class="col-hide-mobile">No</th>
        <th class="col-hide-mobile">Tanggal Pemeriksaan</th>
        <th class="col-nama-data">Nama Ibu Hamil</th>
        <th class="col-hide-mobile">Usia Kehamilan</th>
        <th class="col-hide-mobile">Berat Badan</th>
        <th class="col-hide-mobile">Tekanan Darah</th>
        <th class="col-hide-mobile">Keluhan</th>
        <th class="col-aksi">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pemeriksaans as $i => $pem)
      @php
        $ibu  = $pem->ibuHamil;
        $uk   = $pem->usia_kehamilan;
        $trim = $uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III');
      @endphp
      <tr>
        <td class="col-hide-mobile">{{ ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1 }}</td>
        <td class="col-hide-mobile">
          <div class="cell-name">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}</div>
          <div class="cell-meta">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('l') }}</div>
        </td>
        <td class="col-nama-data">
          <div class="cell-name">{{ $ibu->nama_ibu ?? '-' }}</div>
          @if($ibu && $ibu->gravida !== null)
            <div class="cell-meta">G{{ $ibu->gravida }}P{{ $ibu->partus }}A{{ $ibu->abortus }}</div>
          @endif
        </td>
        <td class="col-hide-mobile">
          <div class="cell-name">{{ $uk ?? '-' }} minggu</div>
        </td>
        <td class="col-hide-mobile">
          <div class="cell-name">{{ fmtAngka($pem->berat_badan) }} kg</div>
        </td>
        <td class="col-hide-mobile">
          <div class="cell-name">{{ $pem->tekanan_darah }} mmHg</div>
        </td>
        <td style="max-width:180px;" class="col-hide-mobile">
          @if($pem->keluhan)
            <div style="font-size:13px;color:var(--slate-600);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
              {{ $pem->keluhan }}
            </div>
          @else
            <span style="font-size:12px;color:var(--slate-300);font-style:italic;">Tidak ada keluhan</span>
          @endif
        </td>
        <td class="col-aksi">
          <div style="display:flex;justify-content:center;gap:6px;">
            @php
              $detailPemIH = json_encode([
                'Nama Ibu'        => $ibu->nama_ibu ?? '-',
                'Tanggal Periksa' => \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y'),
                'Usia Kehamilan'  => ($uk ?? '-').' minggu',
                'Berat Badan'     => fmtAngka($pem->berat_badan).' kg',
                'Tekanan Darah'   => $pem->tekanan_darah.' mmHg',
                'Keluhan'         => $pem->keluhan ?? '-',
              ]);
            @endphp
            <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.show', $pem) }}"
               class="btn btn-view btn-sm" title="Detail"
               data-title="{{ $ibu->nama_ibu ?? '-' }}"
               data-detail="{{ $detailPemIH }}"
               onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.edit', $pem) }}"
               class="btn btn-primary btn-sm" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-danger btn-sm" title="Hapus"
              onclick="openDelete('{{ route('kader.pemeriksaan-awal-ibu-hamil.destroy', $pem) }}', '{{ $ibu->nama_ibu ?? '-' }}')">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8">
          <div class="empty-state">
            <i class="fas fa-stethoscope"></i>
            <h3>Belum ada data pemeriksaan</h3>
            <p>Klik "Catat Pemeriksaan" untuk mulai mencatat.</p>
          </div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  </div>

  {{-- ═══ MOBILE CARD LIST ═══ --}}
  <div class="mobile-list" style="padding:10px 14px;">
    @forelse($pemeriksaans as $i => $pem)
    @php
      $ibu  = $pem->ibuHamil;
      $uk   = $pem->usia_kehamilan;
      $trim = $uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III');
      $trimColors = ['I'=>'badge-orange','II'=>'badge-teal','III'=>'badge-blue'];
      $no = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    @endphp
    <div class="rec-card">
      <div class="rec-card-header">
        <div>
          <div class="rec-name">{{ $ibu->nama_ibu ?? '-' }}</div>
          <div class="rec-sub">
            @if($ibu && $ibu->gravida !== null)G{{ $ibu->gravida }}P{{ $ibu->partus }}A{{ $ibu->abortus }} &bull; @endif
            {{ $uk }} minggu &bull; {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}
          </div>
        </div>
        <div class="rec-actions">
          <span class="no-badge">#{{ $no }}</span>
          <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.show', $pem) }}" class="btn btn-view btn-sm"><i class="fas fa-eye"></i></a>
          <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.edit', $pem) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
          <button type="button" class="btn btn-danger btn-sm"
            onclick="openDelete('{{ route('kader.pemeriksaan-awal-ibu-hamil.destroy', $pem) }}', '{{ $ibu->nama_ibu ?? '-' }}')">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
      <hr class="rec-divider">
      <div class="rec-grid">
        <div class="rec-field">
          <label>Berat Badan</label>
          <div class="val">{{ fmtAngka($pem->berat_badan) }} kg</div>
        </div>
        <div class="rec-field">
          <label>Tekanan Darah</label>
          <div class="val">{{ $pem->tekanan_darah }} mmHg</div>
        </div>
        <div class="rec-field" style="grid-column:span 2;">
          <label>Trimester</label>
          <div class="val" style="font-weight:400;"><span class="badge {{ $trimColors[$trim] ?? 'badge-teal' }}">Trimester {{ $trim }} ({{ $uk }} minggu)</span></div>
        </div>
        @if($pem->keluhan)
        <div class="rec-field" style="grid-column:span 2;">
          <label>Keluhan</label>
          <div class="val" style="font-weight:400;">{{ \Illuminate\Support\Str::limit($pem->keluhan, 80) }}</div>
        </div>
        @endif
      </div>
    </div>
    @empty
    <div class="empty-state">
      <i class="fas fa-stethoscope"></i>
      <h3>Belum ada data pemeriksaan</h3>
      <p>Klik "Catat Pemeriksaan" untuk mulai mencatat.</p>
    </div>
    @endforelse
  </div>
  </div>{{-- end rt-wrap --}}

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



<div id="delete-modal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
  <div style="position:absolute;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(2px);" onclick="closeDelete()"></div>
  <div style="position:relative;background:#fff;border-radius:16px;padding:20px;width:100%;max-width:360px;box-shadow:0 20px 60px rgba(0,0,0,.15);text-align:center;">
    <div style="width:48px;height:48px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
      <i class="fas fa-trash" style="font-size:18px;color:#ef4444;"></i>
    </div>
    <div style="font-size:16px;font-weight:800;color:#1e293b;margin-bottom:6px;">Hapus Data Pemeriksaan?</div>
    <div style="font-size:12.5px;color:#64748b;margin-bottom:16px;">
      Data pemeriksaan <strong id="delete-nama"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </div>
    <div style="display:flex;gap:8px;justify-content:center;">
      <button type="button" onclick="closeDelete()" class="btn btn-outline" style="flex:1;padding:8px 12px;">Batal</button>
      <form id="delete-form" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger" style="width:100%;padding:8px 12px;">
          <i class="fas fa-trash"></i> Ya, Hapus
        </button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function openDelete(url, nama) {
  document.getElementById('delete-nama').textContent = nama;
  document.getElementById('delete-form').action = url;
  document.getElementById('delete-modal').style.display = 'flex';
}
function closeDelete() {
  document.getElementById('delete-modal').style.display = 'none';
}

const searchInputPaih = document.getElementById('inp-search-paih');
let searchTimerPaih;
if (searchInputPaih) {
  searchInputPaih.addEventListener('input', function(){
    clearTimeout(searchTimerPaih);
    searchTimerPaih = setTimeout(() => {
      sessionStorage.setItem('searchFocusPaih', '1');
      this.closest('form').submit();
    }, 700);
  });
  if (sessionStorage.getItem('searchFocusPaih')) {
    sessionStorage.removeItem('searchFocusPaih');
    searchInputPaih.focus();
    const len = searchInputPaih.value.length;
    searchInputPaih.setSelectionRange(len, len);
  }
}
</script>
@endpush