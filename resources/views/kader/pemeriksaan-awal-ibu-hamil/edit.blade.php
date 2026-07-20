@extends('layouts.app')
@section('title', 'Edit Pemeriksaan Ibu Hamil')
@section('page_title', 'Edit Pemeriksaan Awal')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index', ['tanggal' => $pem->tanggal_periksa]) }}" class="btn btn-outline btn-sm">    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Edit Pemeriksaan: {{ $pem->ibuHamil->nama_ibu ?? '-' }}</span>
</div>

<form method="POST" action="{{ route('kader.pemeriksaan-awal-ibu-hamil.update', $pem) }}">
@csrf @method('PUT')

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Edit Pemeriksaan Awal Ibu Hamil</div>
      <div class="card-subtitle">
        Dicatat pada {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}
      </div>
    </div>
  </div>

  <div class="section-divider">Ibu Hamil</div>
  <div class="form-section">
    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label">Nama Ibu Hamil <span class="required">*</span></label>
        <select name="ibu_hamil_id"
                class="form-control @error('ibu_hamil_id') is-invalid @enderror"
                id="ibu_hamil_id" onchange="loadIbuData(this)">
          <option value="">-- Pilih Ibu Hamil --</option>
          @foreach($ibuHamils as $ibu)
            <option value="{{ $ibu->id }}"
                    data-hpht="{{ $ibu->hpht }}"
                    data-status="{{ $ibu->status_kehamilan }}"
                    data-nik="{{ $ibu->nik }}"
                    {{ (old('ibu_hamil_id', $pem->ibu_hamil_id) == $ibu->id) ? 'selected' : '' }}>
              {{ $ibu->nama_ibu }}
            </option>
          @endforeach
        </select>
        @error('ibu_hamil_id')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
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
               max="{{ now()->format('Y-m-d') }}"
               onchange="hitungUK()">
        @error('tanggal_periksa')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">Usia Kehamilan Saat Periksa</label>
        <input type="text" id="usia_kehamilan_display" class="form-control"
               value="{{ $pem->usia_kehamilan }} minggu"
               readonly style="background:var(--slate-50);color:var(--slate-500);">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Berat Badan <span class="required">*</span></label>
        <div style="position:relative;">
          <input type="number" name="berat_badan" step="0.1"
                 class="form-control @error('berat_badan') is-invalid @enderror"
                 value="{{ old('berat_badan', $pem->berat_badan) }}"
                 placeholder="Contoh: 58.5"
                 style="padding-right:44px;">
          <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--slate-400);">kg</span>
        </div>
        @error('berat_badan')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label">Tekanan Darah <span class="required">*</span></label>
        @php
          $tdOld = old('tekanan_darah', $pem->tekanan_darah);
          $parts = explode('/', $tdOld . '/');
          $sis   = trim($parts[0] ?? '');
          $dias  = trim($parts[1] ?? '');
        @endphp
        <div style="display:flex;align-items:center;gap:8px;">
          <div style="position:relative;flex:1;">
            <input type="number" id="sistolik" placeholder="120"
                   class="form-control @error('tekanan_darah') is-invalid @enderror"
                   value="{{ $sis }}" oninput="updateTD()">
            <span style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:10px;color:var(--slate-400);">sistol</span>
          </div>
          <span style="font-weight:700;color:var(--slate-400);font-size:18px;">/</span>
          <div style="position:relative;flex:1;">
            <input type="number" id="diastolik" placeholder="80"
                   class="form-control @error('tekanan_darah') is-invalid @enderror"
                   value="{{ $dias }}" oninput="updateTD()">
            <span style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:10px;color:var(--slate-400);">diastol</span>
          </div>
          <span style="font-size:12px;color:var(--slate-400);white-space:nowrap;">mmHg</span>
        </div>
        <input type="hidden" id="tekanan_darah" name="tekanan_darah" value="{{ $tdOld }}">
        <div id="td-status" style="margin-top:6px;font-size:12px;"></div>
        @error('tekanan_darah')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label">Keluhan Ibu</label>
        <textarea name="keluhan" rows="4" maxlength="255"
                  class="form-control @error('keluhan') is-invalid @enderror"
                  placeholder="Tuliskan keluhan ibu hamil (jika ada)…">{{ old('keluhan', $pem->keluhan) }}</textarea>
        <div style="display:flex;justify-content:space-between;margin-top:4px;">
          <div class="form-hint">Kosongkan jika tidak ada keluhan</div>
          <div id="keluhan-count" style="font-size:12px;color:var(--slate-400);">{{ strlen(old('keluhan', $pem->keluhan ?? '')) }} / 255</div>
        </div>
        @error('keluhan')
          <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-footer">
    <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index') }}" class="btn btn-outline">
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
.form-control.is-invalid{border-color:var(--rose-500);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
</style>
@endpush

@push('scripts')
<script>
let hphtSelected = '{{ $pem->ibuHamil->hpht ?? '' }}';

function loadIbuData(sel) {
  const opt = sel.options[sel.selectedIndex];
  hphtSelected = opt.dataset.hpht || null;
  hitungUK();
}
function hitungUK() {
  const tgl = document.getElementById('tanggal_periksa').value;
  const el  = document.getElementById('usia_kehamilan_display');
  if (!hphtSelected || !tgl) { el.value = ''; return; }
  const hpht = new Date(hphtSelected);
  const per  = new Date(tgl);
  const minggu = Math.floor((per - hpht) / (1000*60*60*24*7));
  const trim = minggu <= 12 ? 'I' : minggu <= 27 ? 'II' : 'III';
  el.value = minggu + ' minggu (Trimester ' + trim + ')';
}
function updateTD() {
  const s = parseInt(document.getElementById('sistolik').value)  || 0;
  const d = parseInt(document.getElementById('diastolik').value) || 0;
  const hidden = document.getElementById('tekanan_darah');
  const status = document.getElementById('td-status');
  if (s && d) {
    hidden.value = s + '/' + d;
    let lbl, color;
    if (s < 90 || d < 60)       { lbl='Hipotensi';      color='#1d4ed8'; }
    else if (s < 120 && d < 80) { lbl='Normal';          color='#166534'; }
    else if (s < 140 && d < 90) { lbl='Pre-Hipertensi'; color='#92400e'; }
    else                         { lbl='Hipertensi ⚠️';  color='#991b1b'; }
    status.innerHTML = `<span style="font-weight:700;color:${color};">${lbl}</span>`;
  }
}
document.addEventListener('DOMContentLoaded', () => { hitungUK(); updateTD();
  const k = document.querySelector('textarea[name="keluhan"]');
  if (k) {
    const cnt = document.getElementById('keluhan-count');
    k.addEventListener('input', function() { cnt.textContent = this.value.length + ' / 255'; });
  }
});
</script>
@endpush

@endsection