@extends('layouts.app')
@section('title', 'Data Balita')

@push('styles')
<style>
.empty-state{text-align:center;padding:40px 20px;color:var(--slate-400);}
.empty-state i{font-size:36px;margin-bottom:10px;display:block;opacity:.4;}
.empty-state h3{font-size:15px;font-weight:700;color:var(--slate-500);margin-bottom:6px;}
.empty-state p{font-size:13px;}
.table-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;}
.table-scroll .data-table{min-width:860px;}
.data-table th,.data-table td{text-align:center;vertical-align:middle;white-space:nowrap;}
.data-table td:nth-child(2){text-align:left;white-space:normal;min-width:140px;}
.data-table th:nth-child(2){white-space:normal;min-width:140px;}
select.form-control{padding:8px 10px;border-radius:8px;border:1.5px solid var(--slate-200);font-size:13px;font-family:inherit;color:var(--slate-700);outline:none;transition:border-color .2s;}
select.form-control:focus{border-color:var(--teal-400);}
.badge-count{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:20px;height:20px;padding:0 6px;border-radius:999px;
  background:#ef4444;color:#fff;font-size:11px;font-weight:700;margin-left:6px;line-height:1;
}
@keyframes slideDown{from{opacity:0;transform:translateY(-10px);}to{opacity:1;transform:translateY(0);}}
@keyframes modalIn{from{opacity:0;transform:scale(.95) translateY(10px);}to{opacity:1;transform:scale(1) translateY(0);}}
</style>
@endpush

@section('content')

<div class="page-header">
  <div class="page-header-left">
    <h2>Data Balita</h2>
    <p>Total {{ $balitas->total() }} balita terdaftar</p>
  </div>
  <a href="{{ route('balita.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Balita
  </a>
</div>

@php $isTab = in_array(request('tab'), ['semua', 'L', 'P']); @endphp

<div class="tabs">
  <a href="{{ route('balita.index', array_filter(['search' => request('search'), 'sort' => request('sort'), 'tab' => 'semua'])) }}"
     class="tab {{ request('tab') === 'semua' ? 'active' : '' }}">
    <i class="fas fa-users"></i> Semua
    @if($totalSemua > 0)
      <span class="badge-count" style="background:#64748b;">{{ $totalSemua }}</span>
    @endif
  </a>
  <a href="{{ route('balita.index', array_filter(['search' => request('search'), 'sort' => request('sort'), 'tab' => 'L'])) }}"
     class="tab {{ request('tab') === 'L' ? 'active' : '' }}">
    </i> Laki-laki
    @if($totalLakiLaki > 0)
      <span class="badge-count" style="background:#2563eb;">{{ $totalLakiLaki }}</span>
    @endif
  </a>
  <a href="{{ route('balita.index', array_filter(['search' => request('search'), 'sort' => request('sort'), 'tab' => 'P'])) }}"
     class="tab {{ request('tab') === 'P' ? 'active' : '' }}">
    </i> Perempuan
    @if($totalPerempuan > 0)
      <span class="badge-count" style="background:#db2777;">{{ $totalPerempuan }}</span>
    @endif
  </a>
</div>

<div class="card" style="margin-bottom:16px;">
  <form method="GET" action="{{ route('balita.index') }}" id="filter-form"
        style="padding:10px 16px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    <input type="hidden" name="sort" value="{{ request('sort') }}">
    @if($isTab)
      <input type="hidden" name="tab" value="{{ request('tab') }}">
    @endif
    @php $fTanggal = request('tanggal', now()->toDateString()); @endphp
    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;">
      <i class="fas fa-calendar-day" style="color:#14a398;font-size:13px;"></i>
      <input type="date" id="inp-tanggal" name="tanggal" value="{{ $fTanggal }}"
             class="form-control" style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;font-weight:600;outline:none;cursor:pointer;">
    </div>
    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:8px 14px;flex:1;max-width:280px;">
      <i class="fas fa-search" style="color:#94a3b8;font-size:12px;flex-shrink:0;"></i>
      <input type="text" name="search" id="inp-search" value="{{ request('search') }}"
             placeholder="Cari nama, NIK, atau nama ibu…"
             style="border:none;background:transparent;padding:0;font-size:13px;color:#1e293b;outline:none;width:100%;">
    </div>
    <a href="{{ route('balita.index', ['reset' => 1]) }}"
       class="btn btn-outline btn-sm" style="align-self:flex-end;">
      <i class="fas fa-times"></i> Reset
    </a>
  </form>
</div>

<div class="card">
  <div class="card-header" style="flex-wrap:wrap;gap:10px;">
    <div>
      <div class="card-title">Daftar Balita</div>
      <div class="card-subtitle">{{ $totalSemua }} data terdaftar · {{ $balitas->total() }} ditampilkan</div>
    </div>
    <form method="GET" action="{{ route('balita.index') }}" style="display:flex;gap:8px;align-items:center;">
      @foreach(request()->except('sort') as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <select name="sort" onchange="this.form.submit()" class="form-control" style="width:160px;">
        <option value="">Urutkan</option>
        <option value="nama_asc"  {{ request('sort')=='nama_asc'  ?'selected':'' }}>Nama A-Z</option>
        <option value="nama_desc" {{ request('sort')=='nama_desc' ?'selected':'' }}>Nama Z-A</option>
        <option value="tgl_baru"  {{ request('sort')=='tgl_baru'  ?'selected':'' }}>Lahir Terbaru</option>
        <option value="tgl_lama"  {{ request('sort')=='tgl_lama'  ?'selected':'' }}>Lahir Terlama</option>
      </select>
    </form>
  </div>

  <div class="rt-wrap">
  <div class="table-scroll">
    <table class="data-table">
      <thead>
        <tr>
          <th class="col-hide-mobile">No</th>
          <th style="text-align:left;" class="col-nama-data">Nama Balita</th>
          <th class="col-hide-mobile">NIK</th>
          <th class="col-hide-mobile">Tanggal Lahir</th>
          <th class="col-hide-mobile">Usia</th>
          <th class="col-hide-mobile">Jenis Kelamin</th>
          <th class="col-hide-mobile">Nama Ibu</th>
          <th class="col-hide-mobile">No. HP Orang Tua</th>
          <th class="col-aksi">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($balitas as $i => $balita)
        @php
          $isBoy   = $balita->jenis_kelamin === 'L';
          $usia    = abs((int)\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now(), false));
          $usiaLbl = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
        @endphp
        <tr>
          <td style="color:var(--slate-400);font-size:12px;" class="col-hide-mobile">{{ ($balitas->currentPage()-1)*$balitas->perPage()+$i+1 }}</td>
          <td class="col-nama-data">
            <div style="font-weight:600;color:var(--slate-800);">{{ $balita->nama_balita }}</div>
            <div style="font-size:12px;color:var(--slate-400);">{{ $balita->alamat ?? ($balita->ibuHamil->alamat ?? '-') }}</div>
          </td>
          <td style="font-size:12.5px;" class="col-hide-mobile">{{ $balita->nik ?? '—' }}</td>
          <td class="col-hide-mobile">{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d M Y') }}</td>
          <td class="col-hide-mobile">{{ $usiaLbl }}</td>
          <td class="col-hide-mobile">
            @if($isBoy)
              <span class="badge badge-blue">Laki-laki</span>
            @else
              <span class="badge" style="background:#fce7f3;color:#9d174d;">Perempuan</span>
            @endif
          </td>
          <td class="col-hide-mobile">{{ $balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-' }}</td>
          <td class="col-hide-mobile">{{ $balita->ibuHamil->no_hp ?? '-' }}</td>
          <td class="col-aksi">
            @php
              $detailBalita = json_encode([
                'Nama Balita'      => $balita->nama_balita,
                'NIK'              => $balita->nik ?? '-',
                'Tanggal Lahir'    => \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d F Y'),
                'Usia'             => $usiaLbl,
                'Jenis Kelamin'    => $isBoy ? 'Laki-laki' : 'Perempuan',
                'Nama Ibu'         => $balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-',
                'No. HP Orang Tua' => $balita->ibuHamil->no_hp ?? '-',
                'Alamat'           => $balita->alamat ?? ($balita->ibuHamil->alamat ?? '-'),
              ]);
            @endphp
            <div style="display:flex;justify-content:center;gap:6px;">
              <a href="{{ route('balita.show', $balita->id) }}" class="btn btn-view btn-sm" title="Detail"
                 data-title="{{ $balita->nama_balita }}"
                 data-detail="{{ $detailBalita }}"
                 onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))"><i class="fas fa-eye"></i></a>
              <a href="{{ route('balita.edit', $balita->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
              <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                      onclick="openDeleteModal('{{ route('balita.destroy', $balita->id) }}','{{ addslashes($balita->nama_balita) }}')">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9">
            <div class="empty-state">
              <i class="fas fa-baby"></i>
              <h3>Belum ada data balita</h3>
              <p>Klik tombol "Tambah Balita" untuk menambahkan data baru.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ═══ MOBILE CARD LIST ═══ --}}
  <div class="mobile-list" style="padding:10px 14px;">
    @forelse($balitas as $i => $balita)
    @php
      $isBoy   = $balita->jenis_kelamin === 'L';
      $usia    = abs((int)\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now(), false));
      $usiaLbl = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
      $no = ($balitas->currentPage()-1)*$balitas->perPage()+$i+1;
    @endphp
    <div class="rec-card">
      <div class="rec-card-header">
        <div>
          <div class="rec-name">{{ $balita->nama_balita }}</div>
          <div class="rec-sub">
            {{ $isBoy ? 'Laki-laki' : 'Perempuan' }} &bull; {{ $usiaLbl }}
          </div>
        </div>
        <div class="rec-actions">
          <span class="no-badge">#{{ $no }}</span>
          <a href="{{ route('balita.show', $balita->id) }}" class="btn btn-view btn-sm"><i class="fas fa-eye"></i></a>
          <a href="{{ route('balita.edit', $balita->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
          <button type="button" class="btn btn-danger btn-sm"
                  onclick="openDeleteModal('{{ route('balita.destroy', $balita->id) }}','{{ addslashes($balita->nama_balita) }}')">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
      <hr class="rec-divider">
      <div class="rec-grid">
        <div class="rec-field">
          <label>NIK</label>
          <div class="val">{{ $balita->nik ?? '—' }}</div>
        </div>
        <div class="rec-field">
          <label>Tanggal Lahir</label>
          <div class="val">{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d M Y') }}</div>
        </div>
        <div class="rec-field">
          <label>Nama Ibu</label>
          <div class="val">{{ $balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-' }}</div>
        </div>
        <div class="rec-field">
          <label>No. HP Ortu</label>
          <div class="val">{{ $balita->ibuHamil->no_hp ?? '-' }}</div>
        </div>
        <div class="rec-field" style="grid-column:span 2;">
          <label>Alamat</label>
          <div class="val" style="font-weight:400;">{{ $balita->alamat ?? ($balita->ibuHamil->alamat ?? '-') }}</div>
        </div>
      </div>
    </div>
    @empty
    <div class="empty-state">
      <i class="fas fa-baby"></i>
      <h3>Belum ada data balita</h3>
      <p>Klik tombol "Tambah Balita" untuk menambahkan data baru.</p>
    </div>
    @endforelse
  </div>
  </div>{{-- end rt-wrap --}}

  @if($balitas->hasPages())
  <div class="pagination-wrapper">
    <span class="page-info">Menampilkan {{ $balitas->firstItem() }}–{{ $balitas->lastItem() }} dari {{ $balitas->total() }} data</span>
    {{ $balitas->links('layouts.pagination') }}
  </div>
  @endif
</div>

{{-- DELETE MODAL --}}
<div id="modalDelete" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;flex-direction:column;">
  <div style="position:absolute;inset:0;background:rgba(15,23,42,.55);backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>

  <div style="position:relative;z-index:1;margin:20px 20px 0;width:calc(100% - 40px);max-width:400px;background:linear-gradient(135deg,#991b1b,#dc2626);border-radius:20px 20px 0 0;padding:28px 28px 20px;text-align:center;color:#fff;animation:modalIn .22s ease;">
    <div style="width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 12px;border:1.5px solid rgba(255,255,255,.2);">
      <i class="fas fa-trash-alt"></i>
    </div>
    <h3 style="font-size:17px;font-weight:700;margin-bottom:4px;color:#fff;">Hapus Data Balita</h3>
    <p style="font-size:12.5px;opacity:.8;margin:0;">Tindakan ini tidak dapat dibatalkan</p>
  </div>

  <div style="position:relative;z-index:1;margin:0 20px 20px;width:calc(100% - 40px);max-width:400px;background:#fff;border-radius:0 0 20px 20px;padding:22px 24px 24px;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:modalIn .22s ease;">
    <div style="background:#fee2e2;border:1.5px solid #fecaca;border-radius:10px;padding:14px 16px;margin-bottom:16px;">
      <p style="font-size:13px;color:#991b1b;margin-bottom:8px;">Data balita berikut akan dihapus permanen:</p>
      <div style="display:flex;align-items:center;gap:10px;">
        <div id="dAvatar" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;flex-shrink:0;background:linear-gradient(135deg,#f87171,#dc2626);"></div>
        <div>
          <div id="dNama" style="font-weight:700;font-size:14px;color:#1e293b;"></div>
          <div style="font-size:12px;color:#94a3b8;">Balita</div>
        </div>
      </div>
    </div>
    <p style="font-size:12px;color:#94a3b8;margin-bottom:18px;text-align:center;">
      <i class="fas fa-exclamation-triangle" style="color:#f59e0b;"></i>
      Seluruh riwayat pemeriksaan balita ini juga akan terhapus.
    </p>
    <div style="display:flex;gap:10px;">
      <button onclick="closeDeleteModal()" class="btn btn-outline" style="flex:1;justify-content:center;">
        <i class="fas fa-times"></i> Batal
      </button>
      <form id="formDelete" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit" class="btn" style="width:100%;justify-content:center;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;box-shadow:0 4px 14px rgba(220,38,38,.3);">
          <i class="fas fa-trash-alt"></i> Hapus
        </button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('inp-tanggal').addEventListener('change', function(){
  document.getElementById('filter-form').submit();
});

function openDeleteModal(url, nama) {
  document.getElementById('dAvatar').textContent = nama.charAt(0).toUpperCase();
  document.getElementById('dNama').textContent   = nama;
  document.getElementById('formDelete').action   = url;
  document.getElementById('modalDelete').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
  document.getElementById('modalDelete').style.display = 'none';
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });

const searchInput = document.getElementById('inp-search') ?? document.querySelector('#filter-form input[name="search"]');
let searchTimer;
searchInput.addEventListener('input', function(){
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    sessionStorage.setItem('searchFocus', '1');
    document.getElementById('filter-form').submit();
  }, 700);
});

if (sessionStorage.getItem('searchFocus')) {
  sessionStorage.removeItem('searchFocus');
  const inp = document.getElementById('inp-search') ?? document.querySelector('#filter-form input[name="search"]');
  if (inp) { inp.focus(); const len = inp.value.length; inp.setSelectionRange(len, len); }
}
</script>
@endpush