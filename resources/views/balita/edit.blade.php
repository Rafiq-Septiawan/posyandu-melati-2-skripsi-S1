@extends('layouts.app')
@section('title', 'Edit Data Balita')
@section('page_title', 'Edit Balita')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('balita.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Edit: {{ $balita->nama_balita }}</span>
</div>


{{-- FORM 1: DATA BALITA --}}
<form method="POST" action="{{ route('balita.update', $balita->id) }}" style="margin-bottom:16px;">
@csrf @method('PUT')
<input type="hidden" name="_section" value="balita">

{{-- Kirim field ortu sebagai hidden supaya validasi tidak gagal --}}
<input type="hidden" name="ibu_hamil_id" value="{{ $balita->ibu_hamil_id }}">
{{-- Hidden backup jenis_kelamin karena radio disabled tidak ikut terkirim --}}
<input type="hidden" name="jenis_kelamin" id="jk-hidden" value="{{ old('jenis_kelamin', $balita->jenis_kelamin) }}">

<div class="card">
  <div class="card-header header-flex">
    <div style="display:flex;align-items:center;gap:12px;">
      <div>
        <div class="card-title">Data Balita</div>
        <div class="card-subtitle" id="subtitle-balita">Klik Edit untuk mengubah</div>
      </div>
    </div>
    <button type="button" class="btn-edit" id="btn-edit-balita" onclick="toggleEdit('balita')">
      <i class="fas fa-pen"></i><span>Edit</span>
    </button>
  </div>

  <div class="form-section">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nama Balita <span class="required">*</span></label>
        <input type="text" name="nama_balita"
               class="form-control @error('nama_balita') is-invalid @enderror"
               value="{{ old('nama_balita', $balita->nama_balita) }}"
               placeholder="Nama lengkap balita" disabled>
        @error('nama_balita')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
        @php $jk = old('jenis_kelamin', $balita->jenis_kelamin); @endphp
        <div class="gender-picker">
          <label class="gender-option {{ $jk==='L' ? 'selected laki' : '' }} locked" id="opt-L">
            <input type="radio" name="jenis_kelamin_radio" value="L"
                   {{ $jk==='L' ? 'checked' : '' }} onchange="pickGender('L')" disabled>Laki-laki
          </label>
          <label class="gender-option {{ $jk==='P' ? 'selected perempuan' : '' }} locked" id="opt-P">
            <input type="radio" name="jenis_kelamin_radio" value="P"
                   {{ $jk==='P' ? 'checked' : '' }} onchange="pickGender('P')" disabled>Perempuan
          </label>
        </div>
        @error('jenis_kelamin')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">NIK Balita</label>
        <input type="text" id="nik" name="nik"
               class="form-control @error('nik') is-invalid @enderror"
               value="{{ old('nik', $balita->nik) }}"
               placeholder="16 digit NIK (opsional)" maxlength="16" disabled>
        @error('nik')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @else
          <div class="form-hint">Isi jika sudah memiliki NIK</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
               class="form-control @error('tanggal_lahir') is-invalid @enderror"
               value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($balita->tanggal_lahir)->format('Y-m-d')) }}"
               onchange="hitungUsia()"
               max="{{ now()->format('Y-m-d') }}" disabled>
        @error('tanggal_lahir')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        <div class="form-hint" id="usia-display">
          @php
            $usia = \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now());
            $th   = floor($usia/12); $bl = $usia%12;
            echo 'Usia: ' . ($th > 0 ? $th.' tahun '.$bl.' bulan' : $usia.' bulan');
          @endphp
        </div>
      </div>
    </div>
  </div>

  <div class="form-footer" id="footer-balita" style="display:none;">
    <button type="button" class="btn btn-outline" onclick="cancelEdit('balita')">
      <i class="fas fa-times"></i> Batal
    </button>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save"></i> Simpan
    </button>
  </div>
</div>
</form>

{{-- FORM 2: DATA IBU --}}
<form method="POST" action="{{ route('balita.update', $balita->id) }}">
@csrf @method('PUT')
<input type="hidden" name="_section" value="ortu">

{{-- Kirim field balita sebagai hidden supaya validasi tidak gagal --}}
<input type="hidden" name="nama_balita"   value="{{ $balita->nama_balita }}">
<input type="hidden" name="nik"           value="{{ $balita->nik }}">
<input type="hidden" name="tanggal_lahir" value="{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('Y-m-d') }}">
<input type="hidden" name="jenis_kelamin" value="{{ $balita->jenis_kelamin }}">

<div class="card">
  <div class="card-header header-flex">
    <div style="display:flex;align-items:center;gap:12px;">
      <div>
        <div class="card-title">Hubungan Ibu Hamil</div>
        <div class="card-subtitle" id="subtitle-ortu">Klik Edit untuk mengubah</div>
      </div>
    </div>
    <button type="button" class="btn-edit" id="btn-edit-ortu" onclick="toggleEdit('ortu')">
      <i class="fas fa-pen"></i><span>Edit</span>
    </button>
  </div>

  <div class="form-section">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="ibu_hamil_id">Pilih Ibu Hamil <span class="required">*</span></label>
        <select id="ibu_hamil_id" name="ibu_hamil_id" class="form-control" disabled required>
          <option value="">-- Pilih Ibu Hamil --</option>
          @foreach($ibuHamils as $ibu)
            <option value="{{ $ibu->id }}"
              {{ old('ibu_hamil_id', $balita->ibu_hamil_id) == $ibu->id ? 'selected' : '' }}>
              {{ $ibu->nama_ibu }} (NIK: {{ $ibu->nik }})
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <div class="form-footer" id="footer-ortu" style="display:none;">
    <button type="button" class="btn btn-outline" onclick="cancelEdit('ortu')">
      <i class="fas fa-times"></i> Batal
    </button>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save"></i> Simpan
    </button>
  </div>
</div>
</form>

@push('styles')
<style>
.form-control:disabled { background:#f8fafc; color:var(--slate-500,#64748b); cursor:not-allowed; opacity:1; }
.form-control.is-invalid { border-color:var(--rose-500); box-shadow:0 0 0 3px rgba(244,63,94,.1); }
.form-error { font-size:12px; color:var(--rose-500); margin-top:4px; display:flex; align-items:center; gap:4px; }
.gender-picker { display:flex; gap:10px; }
.gender-option { flex:1; display:flex; align-items:center; justify-content:center; gap:8px; padding:10px 16px; border-radius:10px; cursor:pointer; font-size:14px; font-weight:600; border:2px solid var(--slate-200); background:var(--white); color:var(--slate-500); transition:all .2s; user-select:none; }
.gender-option input[type="radio"] { display:none; }
.gender-option.selected.laki { border-color:#3b82f6; background:#eff6ff; color:#1d4ed8; }
.gender-option.selected.perempuan { border-color:#ec4899; background:#fdf2f8; color:#9d174d; }
.gender-option.locked { opacity:0.6; cursor:not-allowed; pointer-events:none; }
.header-flex { display:flex; justify-content:space-between; align-items:center; }
.btn-edit { display:flex; align-items:center; gap:6px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; padding:6px 12px; border-radius:999px; font-size:12.5px; font-weight:500; transition:all .2s; cursor:pointer; }
.btn-edit:hover { background:#d1fae5; }
.btn-edit.active { background:#fee2e2; color:#dc2626; border-color:#fecaca; }
</style>
@endpush

@push('scripts')
<script>
const sections = {
  balita: {
    fields:   ['nama_balita', 'nik', 'tanggal_lahir', 'jenis_kelamin_radio'],
    btn:      'btn-edit-balita',
    footer:   'footer-balita',
    subtitle: 'subtitle-balita',
  },
  ortu: {
    fields:   ['ibu_hamil_id'],
    btn:      'btn-edit-ortu',
    footer:   'footer-ortu',
    subtitle: 'subtitle-ortu',
  }
};

function toggleEdit(section) {
  const cfg      = sections[section];
  const btn      = document.getElementById(cfg.btn);
  const isActive = btn.classList.contains('active');

  if (!isActive) {
    cfg.fields.forEach(name => {
      document.querySelectorAll(`[name="${name}"]`).forEach(el => el.removeAttribute('disabled'));
    });
    if (section === 'balita') {
      document.querySelectorAll('.gender-option').forEach(el => el.classList.remove('locked'));
    }
    btn.classList.add('active');
    btn.innerHTML = '<i class="fas fa-xmark"></i><span>Batal</span>';
    document.getElementById(cfg.footer).style.display = 'flex';
    document.getElementById(cfg.subtitle).textContent = 'ubah data lalu klik Simpan';
  } else {
    cancelEdit(section);
  }
}

function cancelEdit(section) {
  const cfg = sections[section];
  const btn = document.getElementById(cfg.btn);

  cfg.fields.forEach(name => {
    document.querySelectorAll(`[name="${name}"]`).forEach(el => el.setAttribute('disabled', true));
  });
  if (section === 'balita') {
    document.querySelectorAll('.gender-option').forEach(el => el.classList.add('locked'));
  }
  btn.classList.remove('active');
  btn.innerHTML = '<i class="fas fa-pen"></i><span>Edit</span>';
  document.getElementById(cfg.footer).style.display = 'none';
  document.getElementById(cfg.subtitle).textContent = 'Klik Edit untuk mengubah';
}

function pickGender(val) {
  document.querySelectorAll('.gender-option').forEach(el => el.classList.remove('selected','laki','perempuan'));
  document.getElementById('opt-' + val).classList.add('selected', val === 'L' ? 'laki' : 'perempuan');
  // Update hidden input karena radio pakai name berbeda
  document.getElementById('jk-hidden').value = val;
}

function hitungUsia() {
  const tgl = new Date(document.getElementById('tanggal_lahir').value);
  if (isNaN(tgl)) return;
  const now   = new Date();
  const bulan = (now.getFullYear()-tgl.getFullYear())*12 + (now.getMonth()-tgl.getMonth());
  const th    = Math.floor(bulan/12); const bl = bulan%12;
  document.getElementById('usia-display').textContent =
    'Usia: ' + (th > 0 ? th+' tahun '+bl+' bulan' : bulan+' bulan');
}

  const nikInput = document.getElementById('nik');
  if (nikInput) {
    nikInput.addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  }

document.addEventListener('DOMContentLoaded', function() {
  @if($errors->has('nama_balita') || $errors->has('tanggal_lahir') || $errors->has('jenis_kelamin') || $errors->has('nik'))
    toggleEdit('balita');
  @elseif($errors->has('ibu_hamil_id'))
    toggleEdit('ortu');
  @endif
});
</script>
@endpush

@endsection