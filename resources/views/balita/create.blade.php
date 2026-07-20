@extends('layouts.app')
@section('title', 'Tambah Data Balita')
@section('page_title', 'Tambah Balita')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('balita.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Tambah Data Balita Baru</span>
</div>


<form method="POST" action="{{ route('balita.store') }}">
@csrf

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Data Balita Baru</div>
      <div class="card-subtitle">Isi formulir data balita dengan lengkap</div>
    </div>
  </div>

  <div class="section-divider">Data Balita</div>
  <div class="form-section">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="nama_balita">
          Nama Balita <span class="required">*</span>
        </label>
        <input type="text" id="nama_balita" name="nama_balita"
               class="form-control @error('nama_balita') is-invalid @enderror"
               placeholder="Nama lengkap balita"
               value="{{ old('nama_balita') }}" autofocus>
        @error('nama_balita')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="jenis_kelamin">
          Jenis Kelamin <span class="required">*</span>
        </label>
        <div class="gender-picker">
          <label class="gender-option {{ old('jenis_kelamin')==='L' ? 'selected' : '' }}" id="opt-L">
            <input type="radio" name="jenis_kelamin" value="L"
                   {{ old('jenis_kelamin')==='L' ? 'checked' : '' }}
                   onchange="pickGender('L')">Laki-laki
          </label>
          <label class="gender-option {{ old('jenis_kelamin')==='P' ? 'selected' : '' }}" id="opt-P">
            <input type="radio" name="jenis_kelamin" value="P"
                   {{ old('jenis_kelamin')==='P' ? 'checked' : '' }}
                   onchange="pickGender('P')">Perempuan
          </label>
        </div>
        @error('jenis_kelamin')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="nik">NIK Balita</label>
        <input type="text" id="nik" name="nik"
               class="form-control @error('nik') is-invalid @enderror"
               placeholder="16 digit NIK (opsional)"
               maxlength="16"
               value="{{ old('nik') }}">
        @error('nik')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @else
          <div class="form-hint">Isi jika sudah memiliki NIK</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="tanggal_lahir">
          Tanggal Lahir <span class="required">*</span>
        </label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
               class="form-control @error('tanggal_lahir') is-invalid @enderror"
               value="{{ old('tanggal_lahir') }}"
               onchange="hitungUsia()"
               max="{{ now()->format('Y-m-d') }}">
        @error('tanggal_lahir')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
        <div class="form-hint" id="usia-display">Usia akan dihitung otomatis</div>
      </div>
    </div>
  </div>

  <div class="section-divider">Data Ibu</div>
  <div class="form-section">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="ibu_hamil_id">
          Pilih Ibu Hamil <span class="required">*</span>
        </label>
        <select id="ibu_hamil_id" name="ibu_hamil_id" class="form-control @error('ibu_hamil_id') is-invalid @enderror" onchange="pilihIbu(this)" required>
            <option value="">-- Pilih Ibu Hamil --</option>
            @foreach($ibuHamils as $ibu)
                <option value="{{ $ibu->id }}"
                    data-nama="{{ $ibu->nama_ibu }}"
                    {{ old('ibu_hamil_id') == $ibu->id ? 'selected' : '' }}>
                    {{ $ibu->nama_ibu }} (NIK: {{ $ibu->nik }})
                </option>
            @endforeach
        </select>
        @error('ibu_hamil_id')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div id="preview-section" style="display:none;padding:0 24px 20px;">
    <div style="background:linear-gradient(135deg,#0f4f4a,#0f8075);border-radius:12px;padding:16px 20px;color:#fff;display:flex;align-items:center;gap:16px;">
      <div id="prev-avatar"
           style="width:48px;height:48px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;flex-shrink:0;">
        ?
      </div>
      <div>
        <div id="prev-nama" style="font-size:16px;font-weight:700;">—</div>
        <div id="prev-detail" style="font-size:12.5px;color:rgba(255,255,255,.75);margin-top:3px;">—</div>
      </div>
    </div>
  </div>

  <div class="form-footer">
    <a href="{{ route('balita.index') }}" class="btn btn-outline">
      <i class="fas fa-times"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary">
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
.form-control.is-invalid { border-color:var(--rose-500); box-shadow:0 0 0 3px rgba(244,63,94,.1); }
.form-error { font-size:12px; color:var(--rose-500); margin-top:4px; display:flex; align-items:center; gap:4px; }
.gender-picker { display:flex; gap:10px; }
.gender-option {
  flex:1; display:flex; align-items:center; justify-content:center; gap:8px;
  padding:10px 16px; border-radius:10px; cursor:pointer; font-size:14px; font-weight:600;
  border:2px solid var(--slate-200); background:var(--white); color:var(--slate-500);
  transition:all .2s; user-select:none;
}
.gender-option input[type="radio"] { display:none; }
.gender-option:hover { border-color:var(--slate-300); }
.gender-option.selected.laki {
  border-color:#3b82f6; background:#eff6ff; color:#1d4ed8;
}
.gender-option.selected.perempuan {
  border-color:#ec4899; background:#fdf2f8; color:#9d174d;
}
</style>
@endpush

@push('scripts')
<script>
function pickGender(val) {
  document.querySelectorAll('.gender-option').forEach(el => {
    el.classList.remove('selected','laki','perempuan');
  });
  const el = document.getElementById('opt-' + val);
  el.classList.add('selected', val === 'L' ? 'laki' : 'perempuan');
  updatePreview();
}

function hitungUsia() {
  const tgl = new Date(document.getElementById('tanggal_lahir').value);
  if (isNaN(tgl)) return;
  const now = new Date();
  const bulan = (now.getFullYear() - tgl.getFullYear()) * 12 + (now.getMonth() - tgl.getMonth());
  const tahun = Math.floor(bulan / 12);
  const sisaBulan = bulan % 12;
  const label = tahun > 0 ? tahun + ' tahun ' + sisaBulan + ' bulan' : bulan + ' bulan';
  document.getElementById('usia-display').textContent = 'Usia: ' + label;
  updatePreview();
}

function pilihIbu(select) {
    updatePreview();
}

function updatePreview() {
  const nama = document.getElementById('nama_balita').value;
  const select = document.getElementById('ibu_hamil_id');
  const opt = select.options[select.selectedIndex];
  const ibu = opt && opt.value ? opt.dataset.nama : '';
  const usia = document.getElementById('usia-display').textContent;
  const jk   = document.querySelector('input[name=jenis_kelamin]:checked')?.value;

  if (!nama) { document.getElementById('preview-section').style.display='none'; return; }
  document.getElementById('preview-section').style.display='block';

  const avatar = document.getElementById('prev-avatar');
  avatar.textContent = nama.charAt(0).toUpperCase();
  if (jk === 'L') avatar.style.background='linear-gradient(135deg,#3b82f6,#1d4ed8)';
  else if (jk === 'P') avatar.style.background='linear-gradient(135deg,#f472b6,#db2777)';
  else avatar.style.background='rgba(255,255,255,.2)';

  document.getElementById('prev-nama').textContent = nama;
  let detail = [];
  if (jk === 'L') detail.push('Laki-laki');
  else if (jk === 'P') detail.push('Perempuan');
  if (usia !== 'Usia akan dihitung otomatis') detail.push(usia);
  if (ibu) detail.push('Ibu: ' + ibu);
  document.getElementById('prev-detail').textContent = detail.join(' · ') || '—';
}

document.getElementById('nama_balita').addEventListener('input', updatePreview);

document.getElementById('nik').addEventListener('input', function(e) {
  this.value = this.value.replace(/[^0-9]/g, '');
});

@if(old('jenis_kelamin'))
  pickGender('{{ old('jenis_kelamin') }}');
@endif
@if(old('tanggal_lahir'))
  hitungUsia();
@endif

const selectIbu = document.getElementById('ibu_hamil_id');
if (selectIbu && selectIbu.value) {
  pilihIbu(selectIbu);
}
</script>
@endpush

@endsection