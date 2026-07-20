@extends('layouts.app')
@section('title', 'Catat Pemeriksaan Ibu Hamil')
@section('page_title', 'Pemeriksaan Awal Ibu Hamil')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Catat Pemeriksaan Baru</span>
</div>


<div style="display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;">

  <form method="POST" action="{{ route('kader.pemeriksaan-awal-ibu-hamil.store') }}" id="formPem">
  @csrf

  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Form Pemeriksaan Awal Ibu Hamil</div>
        <div class="card-subtitle">Diisi oleh Kader · {{ auth()->user()->nama }}</div>
      </div>
    </div>

    <div class="section-divider">Pilih Ibu Hamil</div>
    <div class="form-section">
      <div class="form-row form-row-1">
        <div class="form-group">
          <label class="form-label" for="ibu_hamil_id">
            Nama Ibu Hamil <span class="required">*</span>
          </label>
          <select id="ibu_hamil_id" name="ibu_hamil_id"
                  class="form-control @error('ibu_hamil_id') is-invalid @enderror"
                  onchange="loadIbuData(this)">
            <option value="">Pilih Ibu Hamil</option>
            @foreach($ibuHamils as $ibu)
              <option value="{{ $ibu->id }}"
                      data-hpht="{{ $ibu->hpht }}"
                      data-nik="{{ $ibu->nik }}"
                      data-hp="{{ $ibu->no_hp }}"
                      data-gravida="{{ $ibu->gravida ?? 0 }}"
                      data-partus="{{ $ibu->partus ?? 0 }}"
                      data-abortus="{{ $ibu->abortus ?? 0 }}"
                      {{ (old('ibu_hamil_id', $selectedIbu?->id) == $ibu->id) ? 'selected' : '' }}>
                {{ $ibu->nama_ibu }}
              </option>
            @endforeach
          </select>
          @error('ibu_hamil_id')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
        </div>
      </div>

      <div id="ibu-info-box" style="display:none;background:var(--teal-50);border:1.5px solid var(--teal-200);border-radius:12px;padding:14px 18px;margin-top:4px;">
        <div style="font-size:11px;font-weight:700;color:var(--teal-600);text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;">
          <i class="fas fa-info-circle"></i> Info Ibu Hamil
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
          <div>
            <div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">NIK</div>
            <div style="font-size:13.5px;font-weight:600;color:var(--slate-800);" id="info-nik">—</div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">No. HP</div>
            <div style="font-size:13.5px;font-weight:600;color:var(--slate-800);" id="info-hp">—</div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Status Kehamilan</div>
            <div style="font-size:13.5px;font-weight:600;color:var(--teal-700);" id="info-status">—</div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">HPHT</div>
            <div style="font-size:13.5px;font-weight:600;color:var(--slate-800);" id="info-hpht">—</div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Usia Kehamilan Sekarang</div>
            <div style="font-size:13.5px;font-weight:600;color:var(--teal-700);" id="info-uk">—</div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Taksiran Persalinan</div>
            <div style="font-size:13.5px;font-weight:600;color:var(--slate-800);" id="info-taksiran">—</div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-divider">Data Pemeriksaan</div>
    <div class="form-section">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="tanggal_periksa">
            Tanggal Pemeriksaan <span class="required">*</span>
          </label>
          <input type="date" id="tanggal_periksa" name="tanggal_periksa"
                 class="form-control @error('tanggal_periksa') is-invalid @enderror"
                 value="{{ old('tanggal_periksa', now()->format('Y-m-d')) }}"
                 max="{{ now()->format('Y-m-d') }}"
                 onchange="hitungUK()">
          @error('tanggal_periksa')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Usia Kehamilan Saat Periksa</label>
          <input type="text" id="usia_kehamilan_display" class="form-control"
                 placeholder="Otomatis dari HPHT"
                 readonly
                 style="background:var(--slate-50);color:var(--slate-500);">
          <div class="form-hint">Dihitung dari HPHT ibu</div>
        </div>
      </div>

      <div class="form-row">
        {{-- Berat Badan --}}
        <div class="form-group">
          <label class="form-label" for="berat_badan">
            Berat Badan <span class="required">*</span>
          </label>
          <div style="position:relative;">
            <input type="number" id="berat_badan" name="berat_badan" step="0.1"
                   class="form-control @error('berat_badan') is-invalid @enderror"
                   placeholder="Contoh: 58.5"
                   value="{{ old('berat_badan') }}"
                   style="padding-right:44px;">
            <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--slate-400);">kg</span>
          </div>
          @error('berat_badan')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
        </div>

        {{-- Tekanan Darah --}}
        <div class="form-group">
          <label class="form-label">Tekanan Darah <span class="required">*</span></label>
          <div style="display:flex;align-items:center;gap:8px;">
            <div style="flex:1;">
              <input type="number" id="sistolik" placeholder="Sistolik (mis. 120)"
                     class="form-control @error('tekanan_darah') is-invalid @enderror"
                     min="60" max="250"
                     value="{{ old('sistolik') }}"
                     oninput="updateTD()">
            </div>
            <span style="font-weight:700;color:var(--slate-400);font-size:18px;">/</span>
            <div style="flex:1;">
              <input type="number" id="diastolik" placeholder="Diastolik (mis. 80)"
                     class="form-control @error('tekanan_darah') is-invalid @enderror"
                     min="40" max="150"
                     value="{{ old('diastolik') }}"
                     oninput="updateTD()">
            </div>
            <span style="font-size:12px;color:var(--slate-400);white-space:nowrap;">mmHg</span>
          </div>
          <input type="hidden" id="tekanan_darah" name="tekanan_darah"
                 value="{{ old('tekanan_darah') }}">
          {{-- Status TD + error sejajar di bawah input --}}
          <div style="min-height:20px;margin-top:6px;">
            <div id="td-status" style="font-size:12px;"></div>
            @error('tekanan_darah')
              <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="form-row form-row-1">
        <div class="form-group">
          <label class="form-label" for="keluhan">Keluhan Ibu</label>
          <textarea id="keluhan" name="keluhan" rows="4" maxlength="255"
                    class="form-control @error('keluhan') is-invalid @enderror"
                    placeholder="Tuliskan keluhan ibu hamil (jika ada)…&#10;Contoh: Mual, pusing, sakit pinggang, bengkak pada kaki, dll.">{{ old('keluhan') }}</textarea>
          <div style="display:flex;justify-content:space-between;margin-top:4px;">
            <div class="form-hint">Kosongkan jika tidak ada keluhan</div>
            <div id="keluhan-count" style="font-size:12px;color:var(--slate-400);">{{ strlen(old('keluhan', '')) }} / 255</div>
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

  <div style="display:flex;flex-direction:column;gap:14px;">
    <div class="card" style="position:sticky;top:80px;">
      <div class="card-header">
        <div class="card-title" style="font-size:13px;">Panduan Tekanan Darah</div>
      </div>
      <div style="padding:16px;">
        @php
          $tdGuide = [
            ['range'=>'< 90/60',          'label'=>'Hipotensi',      'badge'=>'badge-blue',   'desc'=>'Tekanan darah rendah'],
            ['range'=>'90–119 / 60–79',   'label'=>'Normal',         'badge'=>'badge-green',  'desc'=>'Ideal untuk ibu hamil'],
            ['range'=>'120–139 / 80–89',  'label'=>'Pre-Hipertensi', 'badge'=>'badge-orange', 'desc'=>'Perlu diperhatikan'],
            ['range'=>'≥ 140 / ≥ 90',     'label'=>'Hipertensi',     'badge'=>'badge-red',    'desc'=>'Perlu dirujuk'],
          ];
        @endphp
        @foreach($tdGuide as $g)
        <div style="display:flex;align-items:flex-start;gap:10px;padding:8px 0;border-bottom:1px solid var(--slate-100);">
          <span class="badge {{ $g['badge'] }}" style="white-space:nowrap;flex-shrink:0;font-size:11px;">{{ $g['label'] }}</span>
          <div>
            <div style="font-size:12px;font-weight:600;color:var(--slate-700);">{{ $g['range'] }} mmHg</div>
            <div style="font-size:11px;color:var(--slate-400);">{{ $g['desc'] }}</div>
          </div>
        </div>
        @endforeach
      </div>
      <div style="padding:0 16px 16px;">
        <div style="font-size:11px;font-weight:700;color:var(--slate-500);text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;margin-top:4px;">
          Kenaikan BB Normal
        </div>
        @php
          $bbGuide = [
            ['trim'=>'Trimester I (0–12 minggu)',   'naik'=>'1–2 kg total'],
            ['trim'=>'Trimester II (13–27 minggu)', 'naik'=>'0.5 kg/minggu'],
            ['trim'=>'Trimester III (28–40 minggu)','naik'=>'0.5 kg/minggu'],
          ];
        @endphp
        @foreach($bbGuide as $b)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid var(--slate-100);font-size:12px;">
          <span style="color:var(--slate-600);">{{ $b['trim'] }}</span>
          <span style="font-weight:700;color:var(--teal-700);">{{ $b['naik'] }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

@push('styles')
<style>
.form-control.is-invalid { border-color:var(--rose-500); box-shadow:0 0 0 3px rgba(244,63,94,.1); }
.form-error { font-size:12px; color:var(--rose-500); margin-top:4px; display:flex; align-items:center; gap:4px; }
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button { -webkit-appearance:none; margin:0; }
input[type=number] { -moz-appearance:textfield; }
</style>
@endpush

@push('scripts')
<script>
let hphtSelected = null;

function loadIbuData(sel) {
  const opt = sel.options[sel.selectedIndex];
  if (!opt.value) {
    document.getElementById('ibu-info-box').style.display = 'none';
    hphtSelected = null;
    return;
  }

  hphtSelected = opt.dataset.hpht || null;

  document.getElementById('info-nik').textContent = opt.dataset.nik || '—';
  document.getElementById('info-hp').textContent  = opt.dataset.hp  || '—';

  const g = opt.dataset.gravida || '0';
  const p = opt.dataset.partus  || '0';
  const a = opt.dataset.abortus || '0';
  document.getElementById('info-status').textContent = 'G' + g + 'P' + p + 'A' + a;

  document.getElementById('info-hpht').textContent = formatTgl(hphtSelected);

  if (hphtSelected) {
    const taksiran = new Date(hphtSelected);
    taksiran.setDate(taksiran.getDate() + 280);
    document.getElementById('info-taksiran').textContent = formatTgl(taksiran.toISOString().split('T')[0]);
  } else {
    document.getElementById('info-taksiran').textContent = '—';
  }

  document.getElementById('ibu-info-box').style.display = 'block';
  hitungUK();
}

function hitungUK() {
  const tglPeriksa = document.getElementById('tanggal_periksa').value;
  const el     = document.getElementById('usia_kehamilan_display');
  const elInfo = document.getElementById('info-uk');

  if (!hphtSelected || !tglPeriksa) {
    el.value = '';
    if (elInfo) elInfo.textContent = '—';
    return;
  }

  const hpht    = new Date(hphtSelected);
  const periksa = new Date(tglPeriksa);
  const diffMs  = periksa - hpht;

  if (diffMs < 0) { el.value = 'Tanggal tidak valid'; return; }

  const minggu = Math.floor(diffMs / (1000*60*60*24*7));
  const hari   = Math.floor((diffMs % (1000*60*60*24*7)) / (1000*60*60*24));
  const trim   = minggu <= 12 ? 'I' : minggu <= 27 ? 'II' : 'III';
  const label  = minggu + ' minggu ' + hari + ' hari (Trimester ' + trim + ')';

  el.value = label;
  if (elInfo) elInfo.textContent = label;
}

function updateTD() {
  const s      = parseInt(document.getElementById('sistolik').value)  || 0;
  const d      = parseInt(document.getElementById('diastolik').value) || 0;
  const hidden = document.getElementById('tekanan_darah');
  const status = document.getElementById('td-status');

  if (s && d) {
    hidden.value = s + '/' + d;
    let lbl, color;
    if (s < 90 || d < 60)       { lbl = 'Hipotensi';      color = '#1d4ed8'; }
    else if (s < 120 && d < 80) { lbl = 'Normal';          color = '#166534'; }
    else if (s < 140 && d < 90) { lbl = 'Pre-Hipertensi'; color = '#92400e'; }
    else                         { lbl = 'Hipertensi ⚠️';  color = '#991b1b'; }
    status.innerHTML = '<span style="font-weight:700;color:' + color + ';">' + lbl + '</span>';
  } else {
    hidden.value     = '';
    status.innerHTML = '';
  }
}

function formatTgl(str) {
  if (!str) return '—';
  const d = new Date(str);
  if (isNaN(d)) return str;
  return d.toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' });
}

document.getElementById('keluhan').addEventListener('input', function() {
  document.getElementById('keluhan-count').textContent = this.value.length + ' / 255';
});

document.addEventListener('DOMContentLoaded', () => {
  const sel = document.getElementById('ibu_hamil_id');
  if (sel.value) loadIbuData(sel);

  const td = '{{ old('tekanan_darah') }}';
  if (td && td.includes('/')) {
    const parts = td.split('/');
    document.getElementById('sistolik').value  = parts[0];
    document.getElementById('diastolik').value = parts[1];
    updateTD();
  }
});
</script>
@endpush

@endsection