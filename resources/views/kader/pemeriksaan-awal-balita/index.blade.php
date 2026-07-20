@extends('layouts.app')
@section('title', 'Pemeriksaan Awal Balita')
@section('page_title', 'Pemeriksaan Awal Balita')

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
    <h2>Pemeriksaan Awal Balita</h2>
    <p>Data pemeriksaan yang Anda catat sebagai Kader</p>
  </div>
  <a href="{{ route('kader.pemeriksaan-awal-balita.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Catat Pemeriksaan
  </a>
</div>

@php $isPeriodeTab = in_array(request('periode'), ['semua','hari_ini','bulan_ini']); @endphp

<div class="tabs">
  <a href="{{ route('kader.pemeriksaan-awal-balita.index', array_filter(['search' => request('search'), 'periode' => 'semua'])) }}"
     class="tab {{ request('periode') === 'semua' ? 'active' : '' }}">
    <i class="fas fa-list"></i> Semua
    @if($totalSemua > 0)
      <span class="badge-count" style="background:#64748b;">{{ $totalSemua }}</span>
    @endif
  </a>
  <a href="{{ route('kader.pemeriksaan-awal-balita.index', array_filter(['search' => request('search'), 'periode' => 'hari_ini'])) }}"
     class="tab {{ request('periode') === 'hari_ini' ? 'active' : '' }}">
    <i class="fas fa-calendar-day"></i> Hari Ini
    @if($totalHariIni > 0)
      <span class="badge-count">{{ $totalHariIni }}</span>
    @endif
  </a>
  <a href="{{ route('kader.pemeriksaan-awal-balita.index', array_filter(['search' => request('search'), 'periode' => 'bulan_ini'])) }}"
     class="tab {{ request('periode') === 'bulan_ini' ? 'active' : '' }}">
    <i class="fas fa-calendar-alt"></i> Bulan Ini
    @if($totalBulanIni > 0)
      <span class="badge-count" style="background:#14a398;">{{ $totalBulanIni }}</span>
    @endif
  </a>
</div>

<div class="card" style="margin-bottom:20px;">
  <form method="GET" action="{{ route('kader.pemeriksaan-awal-balita.index') }}"
        id="filter-form-pab"
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
      <input type="text" name="search" id="inp-search-pab" value="{{ request('search') }}"
             placeholder="Nama balita…"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;outline:none;width:100%;">
    </div>

    <a href="{{ route('kader.pemeriksaan-awal-balita.index', ['reset' => 1]) }}"
       class="btn btn-outline btn-sm">
      <i class="fas fa-times"></i> Reset
    </a>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Daftar Pemeriksaan Awal Balita</div>
      <div class="card-subtitle">{{ $totalSemua }} data terdaftar · {{ $pemeriksaans->total() }} ditampilkan</div>
    </div>
  </div>
  <div class="rt-wrap">
  <div class="table-scroll">
  <table class="data-table">
    <thead>
      <tr>
        <th class="col-hide-mobile">No</th>
        <th class="col-hide-mobile">Tanggal</th>
        <th class="col-nama-data">Nama Balita</th>
        <th class="col-hide-mobile">Usia</th>
        <th class="col-hide-mobile">BB</th>
        <th class="col-hide-mobile">TB</th>
        <th class="col-hide-mobile">LK</th>
        <th class="col-hide-mobile">LL</th>
        <th class="col-hide-mobile">Keluhan</th>
        <th class="col-aksi">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pemeriksaans as $i => $pem)
      @php
        $balita  = $pem->balita;
        $usia    = $pem->usia_balita ?? ($balita
            ? (int)\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($pem->tanggal_periksa)
            : 0);
        $usiaLbl = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
      @endphp
      <tr>
        <td class="col-hide-mobile">{{ ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1 }}</td>
        <td class="col-hide-mobile">
          <div class="cell-name">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}</div>
          <div class="cell-meta">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('l') }}</div>
        </td>
        <td class="col-nama-data">
          <div class="cell-name">{{ $balita->nama_balita ?? '-' }}</div>
          <div class="cell-meta">{{ ($balita->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
        </td>
        <td class="col-hide-mobile">
          <div class="cell-name">{{ $usiaLbl }}</div>
          <div class="cell-meta">Lahir: {{ $balita ? \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d M Y') : '-' }}</div>
        </td>
        <td class="col-hide-mobile">{{ fmtAngka($pem->berat_badan) }} kg</td>
        <td class="col-hide-mobile">{{ fmtAngka($pem->tinggi_badan) }} cm</td>
        <td class="col-hide-mobile">{{ $pem->lingkar_kepala ? fmtAngka($pem->lingkar_kepala).' cm' : '-' }}</td>
        <td class="col-hide-mobile">{{ $pem->lingkar_lengan ? fmtAngka($pem->lingkar_lengan).' cm' : '-' }}</td>
        <td style="max-width:140px;" class="col-hide-mobile">
          @if($pem->keluhan)
            <div style="font-size:13px;color:var(--slate-600);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $pem->keluhan }}</div>
          @else
            <span style="font-size:12px;color:var(--slate-300);font-style:italic;">Tidak ada</span>
          @endif
        </td>
        <td class="col-aksi">
          <div style="display:flex;justify-content:center;gap:6px;">
            @php
              $detailPemB = json_encode([
                'Nama Balita'    => $balita->nama_balita ?? '-',
                'Tanggal Periksa'=> \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y'),
                'Usia'           => $usiaLbl,
                'Berat Badan'    => fmtAngka($pem->berat_badan).' kg',
                'Tinggi Badan'   => fmtAngka($pem->tinggi_badan).' cm',
                'Lingkar Kepala' => $pem->lingkar_kepala ? fmtAngka($pem->lingkar_kepala).' cm' : '-',
                'Lingkar Lengan' => $pem->lingkar_lengan ? fmtAngka($pem->lingkar_lengan).' cm' : '-',
                'Keluhan'        => $pem->keluhan ?? '-',
              ]);
            @endphp
            <a href="{{ route('kader.pemeriksaan-awal-balita.show', $pem) }}"
               class="btn btn-view btn-sm" title="Detail"
               data-title="{{ $balita->nama_balita ?? '-' }}"
               data-detail="{{ $detailPemB }}"
               onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('kader.pemeriksaan-awal-balita.edit', $pem) }}"
               class="btn btn-primary btn-sm" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-danger btn-sm" title="Hapus"
              onclick="openDelete('{{ route('kader.pemeriksaan-awal-balita.destroy', $pem) }}', '{{ $balita->nama_balita ?? '-' }}')">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="10">
          <div class="empty-state">
            <i class="fas fa-baby"></i>
            <h3>Belum ada data pemeriksaan balita</h3>
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
      $balita  = $pem->balita;
      $usia    = $pem->usia_balita ?? ($balita
          ? (int)\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($pem->tanggal_periksa) : 0);
      $usiaLbl = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
      $no = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    @endphp
    <div class="rec-card">
      <div class="rec-card-header">
        <div>
          <div class="rec-name">{{ $balita->nama_balita ?? '-' }}</div>
          <div class="rec-sub">
            {{ ($balita->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}
            &bull; {{ $usiaLbl }}
            &bull; {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}
          </div>
        </div>
        <div class="rec-actions">
          <span class="no-badge">#{{ $no }}</span>
          <a href="{{ route('kader.pemeriksaan-awal-balita.show', $pem) }}" class="btn btn-view btn-sm"><i class="fas fa-eye"></i></a>
          <a href="{{ route('kader.pemeriksaan-awal-balita.edit', $pem) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
          <button type="button" class="btn btn-danger btn-sm"
            onclick="openDelete('{{ route('kader.pemeriksaan-awal-balita.destroy', $pem) }}', '{{ $balita->nama_balita ?? '-' }}')">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
      <hr class="rec-divider">
      <div class="rec-grid">
        <div class="rec-field">
          <label>BB / TB</label>
          <div class="val">{{ fmtAngka($pem->berat_badan) }} kg / {{ fmtAngka($pem->tinggi_badan) }} cm</div>
        </div>
        <div class="rec-field">
          <label>LK / LL</label>
          <div class="val">{{ $pem->lingkar_kepala ? fmtAngka($pem->lingkar_kepala).' cm' : '-' }} / {{ $pem->lingkar_lengan ? fmtAngka($pem->lingkar_lengan).' cm' : '-' }}</div>
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
      <i class="fas fa-baby"></i>
      <h3>Belum ada data pemeriksaan balita</h3>
      <p>Klik "Catat Pemeriksaan" untuk mulai mencatat.</p>
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

const searchInputPab = document.getElementById('inp-search-pab');
let searchTimerPab;
if (searchInputPab) {
  searchInputPab.addEventListener('input', function(){
    clearTimeout(searchTimerPab);
    searchTimerPab = setTimeout(() => {
      sessionStorage.setItem('searchFocusPab', '1');
      this.closest('form').submit();
    }, 700);
  });
  if (sessionStorage.getItem('searchFocusPab')) {
    sessionStorage.removeItem('searchFocusPab');
    searchInputPab.focus();
    const len = searchInputPab.value.length;
    searchInputPab.setSelectionRange(len, len);
  }
}
</script>
@endpush