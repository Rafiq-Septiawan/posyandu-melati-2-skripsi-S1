@extends('layouts.app')
@section('title', 'Edit Data Ibu Hamil')
@section('page_title', 'Edit Ibu Hamil')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('ibu-hamil.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Edit: {{ $ibuHamil->nama_ibu }}</span>
</div>


{{-- FORM 1: IDENTITAS --}}
<form method="POST" action="{{ route('ibu-hamil.update', $ibuHamil) }}" style="margin-bottom:16px;">
@csrf @method('PUT')
<input type="hidden" name="_section" value="identitas">

{{-- Kirim field kehamilan sebagai hidden supaya validasi tidak gagal --}}
<input type="hidden" name="gravida" value="{{ $ibuHamil->gravida }}">
<input type="hidden" name="partus"  value="{{ $ibuHamil->partus }}">
<input type="hidden" name="abortus" value="{{ $ibuHamil->abortus }}">
<input type="hidden" name="hpht"    value="{{ $ibuHamil->hpht }}">

<div class="card">
  <div class="card-header header-flex">
    <div style="display:flex;align-items:center;gap:12px;">
      <div>
        <div class="card-title">Identitas Diri</div>
        <div class="card-subtitle" id="subtitle-identitas">Klik Edit untuk mengubah</div>
      </div>
    </div>
    <button type="button" class="btn-edit" id="btn-edit-identitas" onclick="toggleEdit('identitas')">
      <i class="fas fa-pen"></i><span>Edit</span>
    </button>
  </div>

  <div class="form-section">
    <div class="form-row" style="margin-bottom: 16px;">
      <div class="form-group" style="grid-column: span 2;">
        <label class="form-label">Hubungkan dengan Akun Orang Tua <span style="font-weight:normal;color:var(--slate-400);">(Opsional)</span></label>
        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" disabled>
          <option value="">-- Pilih Akun Orang Tua --</option>
          @foreach($orangTuaList as $ot)
            <option value="{{ $ot->id }}" {{ old('user_id', $ibuHamil->user_id) == $ot->id ? 'selected' : '' }}>
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
        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
        <input type="text" name="nama_ibu"
               class="form-control @error('nama_ibu') is-invalid @enderror"
               value="{{ old('nama_ibu', $ibuHamil->nama_ibu) }}"
               placeholder="Nama lengkap" disabled>
        @error('nama_ibu')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">NIK <span class="required">*</span></label>
        <input type="text" id="nik" name="nik"
               class="form-control @error('nik') is-invalid @enderror"
               value="{{ old('nik', $ibuHamil->nik) }}"
               maxlength="16" placeholder="16 digit NIK" disabled>
        @error('nik')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
        <input type="date" name="tanggal_lahir"
               class="form-control @error('tanggal_lahir') is-invalid @enderror"
               value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($ibuHamil->tanggal_lahir)->format('Y-m-d')) }}"
               disabled>
        @error('tanggal_lahir')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">No. HP / WhatsApp</label>
        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
               value="{{ old('no_hp', $ibuHamil->no_hp) }}"
               placeholder="08xxx" disabled>
        @error('no_hp')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
        <textarea name="alamat" rows="3"
                  class="form-control @error('alamat') is-invalid @enderror"
                  placeholder="Alamat lengkap" disabled>{{ old('alamat', $ibuHamil->alamat) }}</textarea>
        @error('alamat')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-footer" id="footer-identitas" style="display:none;">
    <button type="button" class="btn btn-outline" onclick="cancelEdit('identitas')">
      <i class="fas fa-times"></i> Batal
    </button>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save"></i> Simpan
    </button>
  </div>
</div>
</form>

{{-- FORM 2: KEHAMILAN --}}
<form method="POST" action="{{ route('ibu-hamil.update', $ibuHamil) }}">
@csrf @method('PUT')
<input type="hidden" name="_section" value="kehamilan">

{{-- Kirim field identitas sebagai hidden supaya validasi tidak gagal --}}
<input type="hidden" name="user_id"       value="{{ $ibuHamil->user_id }}">
<input type="hidden" name="nama_ibu"      value="{{ $ibuHamil->nama_ibu }}">
<input type="hidden" name="nik"           value="{{ $ibuHamil->nik }}">
<input type="hidden" name="tanggal_lahir" value="{{ \Carbon\Carbon::parse($ibuHamil->tanggal_lahir)->format('Y-m-d') }}">
<input type="hidden" name="alamat"        value="{{ $ibuHamil->alamat }}">
<input type="hidden" name="no_hp"         value="{{ $ibuHamil->no_hp }}">

<div class="card">
  <div class="card-header header-flex">
    <div style="display:flex;align-items:center;gap:12px;">
      <div>
        <div class="card-title">Data Kehamilan</div>
        <div class="card-subtitle" id="subtitle-kehamilan">Klik Edit untuk mengubah</div>
      </div>
    </div>
    <button type="button" class="btn-edit" id="btn-edit-kehamilan" onclick="toggleEdit('kehamilan')">
      <i class="fas fa-pen"></i><span>Edit</span>
    </button>
  </div>

  <div class="form-section">
    <div class="form-row form-row-3">
      <div class="form-group">
        <label class="form-label">
          Gravida (G) <span class="required">*</span>
          <span class="badge-help" data-help="Jumlah total kehamilan termasuk yang sedang berlangsung.">?</span>
        </label>
        <input type="number" name="gravida" id="gravida"
               class="form-control @error('gravida') is-invalid @enderror"
               placeholder="1" min="1"
               value="{{ old('gravida', $ibuHamil->gravida) }}"
               oninput="updateStatus()" disabled>
        @error('gravida')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">
          Partus (P)
          <span class="badge-help" data-help="Jumlah persalinan yang pernah dialami ibu.">?</span>
        </label>
        <input type="number" name="partus" id="partus"
               class="form-control @error('partus') is-invalid @enderror"
               placeholder="0" min="0"
               value="{{ old('partus', $ibuHamil->partus) }}"
               oninput="updateStatus()" disabled>
        @error('partus')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">
          Abortus (A)
          <span class="badge-help" data-help="Jumlah keguguran yang pernah dialami ibu.">?</span>
        </label>
        <input type="number" name="abortus" id="abortus"
               class="form-control @error('abortus') is-invalid @enderror"
               placeholder="0" min="0"
               value="{{ old('abortus', $ibuHamil->abortus) }}"
               oninput="updateStatus()" disabled>
        @error('abortus')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>

    <div id="status-preview" style="background:var(--teal-50);border:1.5px solid var(--teal-200);border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
      <i class="fas fa-info-circle" style="color:var(--teal-600);"></i>
      <span style="font-size:13.5px;color:var(--teal-800);">Status kehamilan:
        <strong id="status-text">G{{ $ibuHamil->gravida }}P{{ $ibuHamil->partus }}A{{ $ibuHamil->abortus }}</strong>
      </span>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">
          HPHT <span class="required">*</span>
          <span class="badge-help" data-help="Hari Pertama Haid Terakhir untuk menghitung usia kehamilan dan taksiran persalinan.">?</span>
        </label>
        <input type="date" name="hpht" id="hpht"
               class="form-control @error('hpht') is-invalid @enderror"
               value="{{ old('hpht', $ibuHamil->hpht) }}"
               disabled>
        <div class="form-hint">Hari Pertama Haid Terakhir</div>
        @error('hpht')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-footer" id="footer-kehamilan" style="display:none;">
    <button type="button" class="btn btn-outline" onclick="cancelEdit('kehamilan')">
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
.form-control:disabled{background:#f8fafc;color:var(--slate-500,#64748b);cursor:not-allowed;opacity:1;}
textarea:disabled{background:#f8fafc;color:var(--slate-500,#64748b);cursor:not-allowed;resize:none;}
.form-control.is-invalid{border-color:var(--rose-500);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
.badge-help{display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px;border-radius:50%;background:#e2e8f0;color:#475569;font-size:11px;font-weight:700;cursor:pointer;margin-left:4px;}
.badge-help:hover{background:#cbd5e1;}
.tooltip-help{position:absolute;background:#1f2937;color:#fff;font-size:12px;padding:8px 10px;border-radius:6px;max-width:220px;line-height:1.4;box-shadow:0 4px 12px rgba(0,0,0,.2);z-index:999;opacity:0;transform:translateY(5px);transition:all .2s;}
.tooltip-help.show{opacity:1;transform:translateY(0);}
.header-flex{display:flex;justify-content:space-between;align-items:center;}
.btn-edit{display:flex;align-items:center;gap:6px;background:#ecfdf5;color:#047857;border:1px solid #a7f3d0;padding:6px 12px;border-radius:999px;font-size:12.5px;font-weight:500;transition:all 0.2s ease;cursor:pointer;}
.btn-edit:hover{background:#d1fae5;}
.btn-edit.active{background:#fee2e2;color:#dc2626;border-color:#fecaca;}
</style>
@endpush

@push('scripts')
<script>
const sections = {
  identitas: {
    fields:   ['user_id','nama_ibu','nik','tanggal_lahir','no_hp','alamat'],
    btn:      'btn-edit-identitas',
    footer:   'footer-identitas',
    subtitle: 'subtitle-identitas',
  },
  kehamilan: {
    fields:   ['gravida','partus','abortus','hpht'],
    btn:      'btn-edit-kehamilan',
    footer:   'footer-kehamilan',
    subtitle: 'subtitle-kehamilan',
  }
};

function toggleEdit(section) {
  const cfg    = sections[section];
  const btn    = document.getElementById(cfg.btn);
  const isActive = btn.classList.contains('active');
  if (!isActive) {
    cfg.fields.forEach(name => {
      document.querySelectorAll(`[name="${name}"]`).forEach(el => el.removeAttribute('disabled'));
    });
    btn.classList.add('active');
    btn.innerHTML = '<i class="fas fa-xmark"></i><span>Batal</span>';
    document.getElementById(cfg.footer).style.display = 'flex';
    document.getElementById(cfg.subtitle).textContent = 'Ubah data lalu klik Simpan';
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
  btn.classList.remove('active');
  btn.innerHTML = '<i class="fas fa-pen"></i><span>Edit</span>';
  document.getElementById(cfg.footer).style.display = 'none';
  document.getElementById(cfg.subtitle).textContent = 'Klik Edit untuk mengubah';
}

  const nikInput = document.getElementById('nik');
  if (nikInput) {
    nikInput.addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  }

document.addEventListener('DOMContentLoaded', function() {
  updateStatus();
  @if($errors->has('nama_ibu') || $errors->has('nik') || $errors->has('tanggal_lahir') || $errors->has('alamat') || $errors->has('no_hp'))
    toggleEdit('identitas');
  @elseif($errors->has('gravida') || $errors->has('partus') || $errors->has('abortus') || $errors->has('hpht'))
    toggleEdit('kehamilan');
  @endif
});

function updateStatus() {
  const g = document.getElementById('gravida')?.value || 0;
  const p = document.getElementById('partus')?.value  || 0;
  const a = document.getElementById('abortus')?.value || 0;
  document.getElementById('status-text').textContent = 'G'+g+'P'+p+'A'+a;
}

document.querySelectorAll('.badge-help').forEach(el => {
  let tooltip;
  function show() {
    tooltip = document.createElement('div');
    tooltip.className = 'tooltip-help';
    tooltip.innerText = el.dataset.help;
    document.body.appendChild(tooltip);
    const r = el.getBoundingClientRect();
    tooltip.style.top  = (r.top - tooltip.offsetHeight - 8 + window.scrollY) + 'px';
    tooltip.style.left = (r.left + r.width/2 - tooltip.offsetWidth/2) + 'px';
    setTimeout(() => tooltip.classList.add('show'), 10);
  }
  function hide() { if (tooltip) { tooltip.remove(); tooltip = null; } }
  el.addEventListener('mouseenter', show);
  el.addEventListener('mouseleave', hide);
  el.addEventListener('click', e => { e.stopPropagation(); tooltip ? hide() : show(); });
  document.addEventListener('click', hide);
});
</script>
@endpush

@endsection