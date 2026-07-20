@extends('layouts.app')
@section('title', 'Tambah Ibu Hamil')
@section('page_title', 'Tambah Ibu Hamil')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('ibu-hamil.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Tambah Ibu Hamil Baru</span>
</div>


<form method="POST" action="{{ route('ibu-hamil.store') }}" id="formIbuHamil">
@csrf

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Data Identitas Ibu</div>
      <div class="card-subtitle">Isi data pribadi ibu hamil</div>
    </div>
  </div>

  <div class="section-divider">Identitas Diri</div>
  <div class="form-section">
    <div class="form-row" style="margin-bottom: 16px;">
      <div class="form-group" style="grid-column: span 2;">
        <label class="form-label" for="user_id">Hubungkan dengan Akun Orang Tua <span style="font-weight:normal;color:var(--slate-400);">(Opsional)</span></label>
        <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
          <option value="">-- Pilih Akun Orang Tua --</option>
          @foreach($orangTuaList as $ot)
            <option value="{{ $ot->id }}" {{ old('user_id') == $ot->id ? 'selected' : '' }}>
              {{ $ot->nama }} (No WA: {{ $ot->no_hp }})
            </option>
          @endforeach
        </select>
        <div class="form-hint">Pilih akun Orang Tua yang sudah terdaftar untuk memberikan hak akses login.</div>
        @error('user_id')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="nama_ibu">Nama Lengkap <span class="required">*</span></label>
        <input type="text" id="nama_ibu" name="nama_ibu" required
               class="form-control @error('nama_ibu') is-invalid @enderror"
               placeholder="Contoh: Dwi Mulya"
               value="{{ old('nama_ibu') }}" autofocus>
        @error('nama_ibu')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="nik">NIK <span class="required">*</span></label>
        <input type="text" id="nik" name="nik" required
               class="form-control @error('nik') is-invalid @enderror"
               placeholder="16 digit NIK" maxlength="16"
               value="{{ old('nik') }}">
        @error('nik')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
               class="form-control @error('tanggal_lahir') is-invalid @enderror"
               value="{{ old('tanggal_lahir') }}"
               onchange="hitungUsia()">
        @error('tanggal_lahir')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
        <div class="form-hint" id="usia-display">Usia akan dihitung otomatis</div>
      </div>
      <div class="form-group">
        <label class="form-label" for="no_hp">No. HP / WhatsApp</label>
        <input type="text" id="no_hp" name="no_hp"
               class="form-control"
               placeholder="Contoh: 08123456789"
               value="{{ old('no_hp') }}">
      </div>
    </div>

    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label" for="alamat">Alamat Lengkap <span class="required">*</span></label>
        <textarea id="alamat" name="alamat" required rows="3"
                  class="form-control @error('alamat') is-invalid @enderror"
                  placeholder="Jl. Nama Jalan No. X, RT/RW, Kelurahan, Kecamatan">{{ old('alamat') }}</textarea>
        @error('alamat')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="section-divider">Data Kehamilan</div>
  <div class="form-section">
    <div class="form-row form-row-3">
      <div class="form-group">
        <label class="form-label" for="gravida">
          Gravida (G) <span class="required">*</span>
          <span class="badge-help" data-help="jumlah total kehamilan yang pernah dialami ibu termasuk yang sedang berlangsung.">?</span>
        </label>
        <input type="number" id="gravida" name="gravida" required
               class="form-control @error('gravida') is-invalid @enderror"
               placeholder="1" min="1"
               value="{{ old('gravida', 1) }}"
               oninput="updateStatus()">
        @error('gravida')
          <div class="form-error">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="partus">
          Partus (P) <span class="required">*</span>
          <span class="badge-help" data-help="Jumlah persalinan yang pernah dialami ibu.">?</span>
        </label>
        <input type="number" id="partus" name="partus" required
               class="form-control"
               placeholder="0" min="0"
               value="{{ old('partus', 0) }}"
               oninput="updateStatus()">
      </div>
      <div class="form-group">
        <label class="form-label" for="abortus">
          Abortus (A) <span class="required">*</span>
          <span class="badge-help" data-help="Jumlah keguguran yang pernah dialami ibu.">?</span>
        </label>
        <input type="number" id="abortus" name="abortus" required
               class="form-control"
               placeholder="0" min="0"
               value="{{ old('abortus', 0) }}"
               oninput="updateStatus()">
      </div>
    </div>

    {{-- Status Preview --}}
    <div id="status-preview" style="background:var(--teal-50);border:1.5px solid var(--teal-200);border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
      <i class="fas fa-info-circle" style="color:var(--teal-600);"></i>
      <span style="font-size:13.5px;color:var(--teal-800);">Status kehamilan:
        <strong id="status-text">G{{ old('gravida',1) }}P{{ old('partus',0) }}A{{ old('abortus',0) }}</strong>
      </span>
    </div>

    <div class="form-row">
      <div class="form-group">
          <label class="form-label" for="hpht">
            HPHT <span class="required">*</span>
            <span class="badge-help"
                  data-help="Hari Pertama Haid Terakhir yang digunakan untuk menghitung usia kehamilan dan perkiraan tanggal persalinan.">
              ?
            </span>
          </label>
        <input type="date" id="hpht" name="hpht" required
               class="form-control @error('hpht') is-invalid @enderror"
               value="{{ old('hpht') }}"
               onchange="hitungUsiaKehamilan()">
        <div class="form-hint">Hari Pertama Haid Terakhir</div>
        @error('hpht')
          <div class="form-error">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-footer">
    <a href="{{ route('ibu-hamil.index') }}" class="btn btn-outline">
      <i class="fas fa-times"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary" id="btn-submit">
      <i class="fas fa-save"></i> Simpan
    </button>
  </div>
</div>
</form>

@push('styles')
<style>
.required{
  color:#ef4444;
  font-weight:700;
}
.form-control:required:invalid{
  border-color:#fda4af;
}
.form-control:required:focus:invalid{
  box-shadow:0 0 0 3px rgba(244,63,94,.12);
}
.form-control.is-invalid { border-color:var(--rose-500); box-shadow:0 0 0 3px rgba(244,63,94,.1); }
.form-error { font-size:12px; color:var(--rose-500); margin-top:4px; display:flex; align-items:center; gap:4px; }
.tooltip-help {
position: absolute;
background: #1f2937;
color: white;
font-size: 12px;
padding: 8px 10px;
border-radius: 6px;
max-width: 220px;
line-height: 1.4;
box-shadow: 0 4px 12px rgba(0,0,0,0.2);
z-index: 999;
opacity: 0;
transform: translateY(5px);
transition: all .2s ease;
}

.tooltip-help.show {
opacity: 1;
transform: translateY(0);
}

.badge-help {
display:inline-flex;
align-items:center;
justify-content:center;
width:18px;
height:18px;
border-radius:50%;
background:#e2e8f0;
color:#475569;
font-size:11px;
font-weight:700;
cursor:pointer;
margin-left:4px;
}

.badge-help:hover{
background:#cbd5f5;
}
</style>
@endpush

@push('scripts')
<script>
function updateStatus() {
  const g = document.getElementById('gravida').value || 0;
  const p = document.getElementById('partus').value || 0;
  const a = document.getElementById('abortus').value || 0;
  document.getElementById('status-text').textContent = 'G' + g + 'P' + p + 'A' + a;
}

function hitungUsia() {
  const tgl = new Date(document.getElementById('tanggal_lahir').value);
  if (!tgl) return;
  const today = new Date();
  let usia = today.getFullYear() - tgl.getFullYear();
  const m = today.getMonth() - tgl.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < tgl.getDate())) usia--;
  document.getElementById('usia-display').textContent = 'Usia: ' + usia + ' tahun';
}

document.querySelectorAll('.badge-help').forEach(el => {
let tooltip;
function showTooltip() {
const text = el.dataset.help;

tooltip = document.createElement('div');
tooltip.className = 'tooltip-help';
tooltip.innerText = text;

document.body.appendChild(tooltip);

const rect = el.getBoundingClientRect();
tooltip.style.top = (rect.top - tooltip.offsetHeight - 8 + window.scrollY) + 'px';
tooltip.style.left = (rect.left + rect.width/2 - tooltip.offsetWidth/2) + 'px';

setTimeout(()=>{
tooltip.classList.add('show');
},10);

}

function hideTooltip(){
if(tooltip){
tooltip.remove();
tooltip = null;
}
}

el.addEventListener('mouseenter', showTooltip);
el.addEventListener('mouseleave', hideTooltip);

el.addEventListener('click', function(e){
e.stopPropagation();

if(tooltip){
hideTooltip();
}else{
showTooltip();
}
});

document.addEventListener('click', hideTooltip);

});

// Init on load
@if(old('hpht')) hitungUsiaKehamilan(); @endif
@if(old('tanggal_lahir')) hitungUsia(); @endif

document.getElementById('nik').addEventListener('input', function(e) {
  this.value = this.value.replace(/[^0-9]/g, '');
});

document.getElementById('formIbuHamil').addEventListener('submit', function(){
  const btn = document.getElementById('btn-submit');
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endpush

@endsection