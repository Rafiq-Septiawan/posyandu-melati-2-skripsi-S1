@extends('layouts.app')
@section('title', 'Edit Pemeriksaan Balita')
@section('page_title', 'Edit Pemeriksaan Awal Balita')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('kader.pemeriksaan-awal-balita.index', ['tanggal' => $pem->tanggal_periksa]) }}" class="btn btn-outline btn-sm">    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Edit Pemeriksaan: {{ $pem->balita->nama_balita ?? '-' }}</span>
</div>

<form method="POST" action="{{ route('kader.pemeriksaan-awal-balita.update', $pem) }}">
@csrf @method('PUT')
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Edit Pemeriksaan Awal Balita</div>
      <div class="card-subtitle">Dicatat pada {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}</div>
    </div>
  </div>

  <div class="section-divider">Balita</div>
  <div class="form-section">
    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label">Nama Balita <span class="required">*</span></label>
        <select name="balita_id" id="balita_id" class="form-control @error('balita_id') is-invalid @enderror" onchange="loadBalitaData(this)">
          <option value="">Pilih Balita</option>
          @foreach($balitas as $b)
            <option value="{{ $b->id }}" data-lahir="{{ $b->tanggal_lahir }}" data-jk="{{ $b->jenis_kelamin }}"
                    {{ old('balita_id',$pem->balita_id)==$b->id?'selected':'' }}>
              {{ $b->nama_balita }} ({{ $b->jenis_kelamin==='L'?'Laki-Laki':'Perempuan' }} · {{ (int)\Carbon\Carbon::parse($b->tanggal_lahir)->diffInMonths(now()) }} bln)
            </option>
          @endforeach
        </select>
        @error('balita_id')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
  </div>

  <div class="section-divider">Data Pemeriksaan</div>
  <div class="form-section">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tanggal Pemeriksaan <span class="required">*</span></label>
        <input type="date" name="tanggal_periksa" id="tanggal_periksa"
               class="form-control @error('tanggal_periksa') is-invalid @enderror"
               value="{{ old('tanggal_periksa', \Carbon\Carbon::parse($pem->tanggal_periksa)->format('Y-m-d')) }}"
               max="{{ now()->format('Y-m-d') }}" onchange="hitungUsia()">
        @error('tanggal_periksa')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Usia Saat Periksa</label>
        <input type="text" id="usia_display" class="form-control" readonly style="background:var(--slate-50);color:var(--slate-500);">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Berat Badan <span class="required">*</span></label>
        <div style="position:relative;">
          <input type="number" name="berat_badan" step="0.1" placeholder="kg"
                 class="form-control @error('berat_badan') is-invalid @enderror"
                 value="{{ old('berat_badan',$pem->berat_badan) }}" style="padding-right:42px;">
          <span class="unit-badge">kg</span>
        </div>
        @error('berat_badan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Tinggi / Panjang Badan <span class="required">*</span></label>
        <div style="position:relative;">
          <input type="number" name="tinggi_badan" step="0.1" placeholder="cm"
                 class="form-control @error('tinggi_badan') is-invalid @enderror"
                 value="{{ old('tinggi_badan',$pem->tinggi_badan) }}" style="padding-right:42px;">
          <span class="unit-badge">cm</span>
        </div>
        <div class="form-hint">Panjang badan (tiduran) untuk usia &lt; 2 tahun</div>
        @error('tinggi_badan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Lingkar Kepala (LK)</label>
        <div style="position:relative;">
          <input type="number" name="lingkar_kepala" step="1" placeholder="Contoh: 45"
                 class="form-control @error('lingkar_kepala') is-invalid @enderror"
                 value="{{ old('lingkar_kepala',$pem->lingkar_kepala) }}" style="padding-right:42px;">
          <span class="unit-badge">cm</span>
        </div>
        @error('lingkar_kepala')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Lingkar Lengan (LL/LILA)</label>
        <div style="position:relative;">
          <input type="number" name="lingkar_lengan" step="1" placeholder="Contoh: 13"
                 class="form-control @error('lingkar_lengan') is-invalid @enderror"
                 value="{{ old('lingkar_lengan',$pem->lingkar_lengan) }}" style="padding-right:42px;">
          <span class="unit-badge">cm</span>
        </div>
        @error('lingkar_lengan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label">Keluhan</label>
        <textarea name="keluhan" rows="3" maxlength="255"
                  class="form-control @error('keluhan') is-invalid @enderror"
                  placeholder="Keluhan balita atau orang tua (jika ada)…">{{ old('keluhan',$pem->keluhan) }}</textarea>
        <div style="display:flex;justify-content:space-between;margin-top:4px;">
          <div class="form-hint">Kosongkan jika tidak ada keluhan</div>
          <div id="keluhan-count" style="font-size:12px;color:var(--slate-400);">{{ strlen(old('keluhan', $pem->keluhan ?? '')) }} / 255</div>
        </div>
        @error('keluhan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
  </div>

  <div class="form-footer">
    <a href="{{ route('kader.pemeriksaan-awal-balita.index') }}" class="btn btn-outline"><i class="fas fa-times"></i> Batal</a>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
  </div>
</div>
</form>

@push('styles')
<style>
.form-control.is-invalid{border-color:var(--rose-500);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
.unit-badge{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--slate-400);}
</style>
@endpush

@push('scripts')
<script>
let tglLahirSelected='{{ $pem->balita->tanggal_lahir ?? '' }}';
function loadBalitaData(sel){tglLahirSelected=sel.options[sel.selectedIndex].dataset.lahir||null;hitungUsia();}
function hitungUsia(){
  const tgl=document.getElementById('tanggal_periksa').value,el=document.getElementById('usia_display');
  if(!tglLahirSelected||!tgl){el.value='';return;}
  const lahir=new Date(tglLahirSelected),p=new Date(tgl);
  const b=(p.getFullYear()-lahir.getFullYear())*12+(p.getMonth()-lahir.getMonth());
  const th=Math.floor(b/12),bl=b%12;
  el.value=th>0?th+' tahun '+bl+' bulan':b+' bulan';
}
document.addEventListener('DOMContentLoaded', () => {
  hitungUsia();
  const k = document.querySelector('textarea[name="keluhan"]');
  if (k) {
    const cnt = document.getElementById('keluhan-count');
    k.addEventListener('input', function() { cnt.textContent = this.value.length + ' / 255'; });
  }
});
</script>
@endpush
@endsection