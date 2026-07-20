@extends('layouts.app')
@section('title', 'Pemeriksaan Lanjutan Ibu Hamil')
@section('page_title', 'Pemeriksaan Lanjutan Ibu Hamil')

@push('styles')
<style>
.empty-state{text-align:center;padding:48px 20px;color:var(--slate-400);}
.empty-state i{font-size:40px;margin-bottom:12px;display:block;opacity:.4;}
.empty-state h3{font-size:15px;font-weight:700;color:var(--slate-500);margin-bottom:6px;}
.empty-state p{font-size:13px;}
.data-table th,.data-table td{text-align:center;vertical-align:middle;}
.data-table td:nth-child(2){text-align:left;}
.row-menunggu{background:#fffbeb!important;border-left:3px solid #f59e0b;}
.row-menunggu:hover{background:#fef3c7!important;}
.badge-antrian{
  display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;
  background:#fff7ed;color:#f59e0b;border:1px solid #fcd34d;
  border-radius:999px;padding:1px 7px;margin-left:6px;vertical-align:middle;
}
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
    <h2>Pemeriksaan Lanjutan Ibu Hamil</h2>
    <p>Antrian & riwayat pemeriksaan lanjutan oleh Bidan</p>
  </div>
  <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Pemeriksaan
  </a>
</div>

@php $isStatusTab = in_array(request('status'), ['belum', 'sudah', 'semua']); @endphp

<div class="tabs">
  <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', array_filter(['search' => request('search'), 'status' => 'semua'])) }}"
     class="tab {{ request('status') === 'semua' ? 'active' : '' }}">
    <i class="fas fa-list"></i> Semua
    @if($totalSemua > 0)
      <span class="badge-count" style="background:#64748b;">{{ $totalSemua }}</span>
    @endif
  </a>
  <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', array_filter(['search' => request('search'), 'status' => 'belum'])) }}"
     class="tab {{ request('status') === 'belum' ? 'active' : '' }}">
    <i class="fas fa-clock"></i> Menunggu Pemeriksaan
    @if($totalMenunggu > 0)
      <span class="badge-count">{{ $totalMenunggu }}</span>
    @endif
  </a>
  <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', array_filter(['search' => request('search'), 'status' => 'sudah'])) }}"
     class="tab {{ request('status') === 'sudah' ? 'active' : '' }}">
    <i class="fas fa-check-circle"></i> Sudah Diperiksa
  </a>
</div>

<div class="card" style="margin-bottom:20px;">
  <form method="GET" action="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index') }}"
        id="filter-form-plih"
        style="padding:14px 20px;display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
    @if($isStatusTab)
      <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;">
      <i class="fas fa-calendar-day" style="color:#14a398;font-size:13px;"></i>
      <input type="date" name="tanggal" value="{{ request('tanggal') }}"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;font-weight:600;outline:none;cursor:pointer;"
             onchange="this.form.submit()">
    </div>
    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;flex:1;max-width:280px;">
      <i class="fas fa-search" style="color:#94a3b8;font-size:12px;flex-shrink:0;"></i>
      <input type="text" name="search" id="inp-search-plih" value="{{ request('search') }}"
             placeholder="Nama ibu hamil…"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;outline:none;width:100%;">
    </div>
    <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', ['reset' => 1]) }}"
       class="btn btn-outline btn-sm">
      <i class="fas fa-times"></i> Reset
    </a>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Daftar Pemeriksaan Ibu Hamil</div>
      <div class="card-subtitle">{{ $totalSemua }} data terdaftar · {{ $pemeriksaans->total() }} ditampilkan</div>
    </div>
  </div>
  <div class="rt-wrap">
  <div class="table-scroll">
    <table class="data-table">
      <thead>
        <tr>
          <th class="col-hide-mobile">No</th>
          <th class="col-nama-data">Nama Ibu Hamil</th>
          <th class="col-hide-mobile">Tgl Periksa</th>
          <th class="col-hide-mobile">Kader Pemeriksa</th>
          <th class="col-hide-mobile">Usia Kehamilan</th>
          <th class="col-hide-mobile">Berat Badan</th>
          <th class="col-hide-mobile">Tekanan Darah</th>
          <th class="col-hide-mobile">Keluhan</th>
          <th class="col-hide-mobile">Status Lanjutan</th>
          <th class="col-aksi">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaans as $i => $awal)
        @php
          $ibu      = $awal->ibuHamil;
          $lanjutan = $awal->pemeriksaanLanjutan;
          $uk       = $lanjutan->usia_kehamilan ?? $awal->usia_kehamilan ?? 0;
          $trim     = $lanjutan->trimester ?? ($uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III'));
          $trimColors = ['I'=>'badge-orange','II'=>'badge-teal','III'=>'badge-blue'];
        @endphp
        <tr class="{{ !$lanjutan ? 'row-menunggu' : '' }}">
          <td class="col-hide-mobile">{{ ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1 }}</td>
          <td class="col-nama-data">
            <div class="cell-name">
              {{ $ibu->nama_ibu ?? '-' }}
              @if(!$lanjutan)
                <span class="badge-antrian"><i class="fas fa-clock"></i> Antrian</span>
              @endif
            </div>
            <div class="cell-meta">{{ \Carbon\Carbon::parse($ibu->tanggal_lahir ?? now())->translatedFormat('d F Y') }}</div>
          </td>
          <td class="col-hide-mobile">{{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d F Y') }}</td>
          <td class="col-hide-mobile">{{ $awal->kader->nama ?? '-' }}</td>
          <td class="col-hide-mobile">
            <div class="cell-name">{{ $uk }} minggu</div>
            @if($uk)
              <div style="margin-top:4px;"><span class="badge {{ $trimColors[$trim] ?? 'badge-teal' }}">Trimester {{ $trim }}</span></div>
            @endif
          </td>
          <td class="col-hide-mobile">{{ fmtAngka($awal->berat_badan) }} kg</td>
          <td class="col-hide-mobile">{{ $awal->tekanan_darah }}</td>
          <td style="max-width:160px;" class="col-hide-mobile">
            @if($awal->keluhan)
              <div style="font-size:13px;color:var(--slate-600);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $awal->keluhan }}</div>
            @else
              <span style="font-size:12px;color:var(--slate-300);font-style:italic;">Tidak ada keluhan</span>
            @endif
          </td>
          <td class="col-hide-mobile">
            @if($lanjutan)
              <span class="badge badge-green">Sudah Diperiksa</span>
              <div class="cell-meta" style="margin-top:4px;">{{ \Carbon\Carbon::parse($lanjutan->tanggal_periksa)->translatedFormat('d F Y') }}</div>
            @else
              <span class="badge badge-orange">Menunggu Bidan</span>
            @endif
          </td>
          <td class="col-aksi">
            <div style="display:flex;justify-content:center;gap:6px;">
              @if($lanjutan)
                @php
                  $detailLanjIH = json_encode([
                    'Nama Ibu'       => $ibu->nama_ibu ?? '-',
                    'Trimester'      => 'Trimester '.$trim,
                    'Usia Kehamilan' => $uk.' minggu',
                    'LILA'           => $lanjutan->lila ? $lanjutan->lila.' cm' : '-',
                    'TFU'            => $lanjutan->tfu ? $lanjutan->tfu.' cm' : '-',
                    'DJJ'            => $lanjutan->djj ? $lanjutan->djj.' x/mnt' : '-',
                    'Tindak Lanjut'  => $lanjutan->tindak_lanjut ?? '-',
                    'Bidan'          => $lanjutan->bidan->nama ?? '-',
                    'Catatan'        => $lanjutan->catatan_bidan ?? '-',
                  ]);
                @endphp
                <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.show', $lanjutan) }}" class="btn btn-view btn-sm"
                   data-title="{{ $ibu->nama_ibu ?? '-' }}"
                   data-detail="{{ $detailLanjIH }}"
                   onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))"><i class="fas fa-eye"></i></a>
                <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.edit', $lanjutan) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="confirmDelete('{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.destroy', $lanjutan) }}','{{ $ibu->nama_ibu ?? 'ini' }}')">
                  <i class="fas fa-trash"></i>
                </button>
              @else
                <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.create', ['pemeriksaan_awal_id'=>$awal->id]) }}"
                   class="btn btn-primary btn-sm"><i class="fas fa-stethoscope"></i> Periksa</a>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="10">
            <div class="empty-state">
              <i class="fas fa-notes-medical"></i>
              <h3>Belum ada data pemeriksaan</h3>
              <p>Belum ada data pemeriksaan awal dari kader.</p>
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
      $ibu      = $awal->ibuHamil;
      $lanjutan = $awal->pemeriksaanLanjutan;
      $uk       = $lanjutan->usia_kehamilan ?? $awal->usia_kehamilan ?? 0;
      $trim     = $lanjutan->trimester ?? ($uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III'));
      $trimColors = ['I'=>'badge-orange','II'=>'badge-teal','III'=>'badge-blue'];
      $no = ($pemeriksaans->currentPage()-1)*$pemeriksaans->perPage()+$i+1;
    @endphp
    <div class="rec-card {{ !$lanjutan ? 'row-menunggu' : '' }}" style="{{ !$lanjutan ? 'border-left:3px solid #f59e0b;' : '' }}">
      <div class="rec-card-header">
        <div>
          <div class="rec-name">
            {{ $ibu->nama_ibu ?? '-' }}
            @if(!$lanjutan)<span class="badge-antrian" style="font-size:9px;"><i class="fas fa-clock"></i> Antrian</span>@endif
          </div>
          <div class="rec-sub">{{ $uk }} minggu &bull; {{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d M Y') }}</div>
        </div>
        <div class="rec-actions">
          <span class="no-badge">#{{ $no }}</span>
          @if($lanjutan)
            <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.show', $lanjutan) }}" class="btn btn-view btn-sm"><i class="fas fa-eye"></i></a>
            <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.edit', $lanjutan) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm"
                    onclick="confirmDelete('{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.destroy', $lanjutan) }}','{{ $ibu->nama_ibu ?? 'ini' }}')">
              <i class="fas fa-trash"></i>
            </button>
          @else
            <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.create', ['pemeriksaan_awal_id'=>$awal->id]) }}"
               class="btn btn-primary btn-sm"><i class="fas fa-stethoscope"></i> Periksa</a>
          @endif
        </div>
      </div>
      <hr class="rec-divider">
      <div class="rec-grid">
        <div class="rec-field">
          <label>BB / Tensi</label>
          <div class="val">{{ fmtAngka($awal->berat_badan) }} kg / {{ $awal->tekanan_darah }}</div>
        </div>
        <div class="rec-field">
          <label>Kader</label>
          <div class="val">{{ $awal->kader->nama ?? '-' }}</div>
        </div>
        <div class="rec-field" style="grid-column:span 2;">
          <label>Status Lanjutan</label>
          <div class="val" style="font-weight:400;display:flex;gap:6px;flex-wrap:wrap;">
            @if($lanjutan)
              <span class="badge badge-green">Sudah Diperiksa</span>
              <span class="badge {{ $trimColors[$trim] ?? 'badge-teal' }}">Trimester {{ $trim }}</span>
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
      <i class="fas fa-notes-medical"></i>
      <h3>Belum ada data pemeriksaan</h3>
      <p>Belum ada data pemeriksaan awal dari kader.</p>
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
  <div style="position:relative;background:#fff;border-radius:20px;padding:32px 28px;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.15);text-align:center;">
    <div style="width:64px;height:64px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
      <i class="fas fa-trash" style="font-size:24px;color:#ef4444;"></i>
    </div>
    <div style="font-size:18px;font-weight:800;color:#1e293b;margin-bottom:8px;">Hapus Data Pemeriksaan?</div>
    <div style="font-size:13px;color:#64748b;margin-bottom:24px;">
      Data pemeriksaan lanjutan <strong id="delete-nama"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </div>
    <div style="display:flex;gap:10px;justify-content:center;">
      <button type="button" onclick="closeDelete()" class="btn btn-outline" style="flex:1;">Batal</button>
      <form id="delete-form" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger" style="width:100%;"><i class="fas fa-trash"></i> Ya, Hapus</button>
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

const searchInputPlih = document.getElementById('inp-search-plih');
let searchTimerPlih;
if (searchInputPlih) {
  searchInputPlih.addEventListener('input', function(){
    clearTimeout(searchTimerPlih);
    searchTimerPlih = setTimeout(() => {
      sessionStorage.setItem('searchFocusPlih', '1');
      this.closest('form').submit();
    }, 700);
  });
  if (sessionStorage.getItem('searchFocusPlih')) {
    sessionStorage.removeItem('searchFocusPlih');
    searchInputPlih.focus();
    const len = searchInputPlih.value.length;
    searchInputPlih.setSelectionRange(len, len);
  }
}
</script>
@endpush