@extends('layouts.app')
@section('title', 'Pemeriksaan Lanjutan Ibu Hamil')
@section('page_title', 'Pemeriksaan Lanjutan Ibu Hamil')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
  <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Catat Pemeriksaan Lanjutan</span>
</div>

<form method="POST" action="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.store') }}">
@csrf

<div style="display:flex; flex-direction:column; gap:16px;">

  {{-- CARD 1: Header + Pilih Pemeriksaan Awal --}}
  <div class="card" style="box-shadow:0 1px 3px rgba(0,0,0,.05);border:1px solid var(--slate-100);">
    <div class="card-header">
      <div>
        <div class="card-title">Catat Pemeriksaan Lanjutan Ibu Hamil</div>
        <div class="card-subtitle">Bidan: {{ auth()->user()->nama }}</div>
      </div>
    </div>
    <div class="form-section" style="padding-top:14px;">
      <div class="form-group" style="margin-bottom:12px;">
        <label class="form-label" for="pemeriksaan_awal_id">Data Pemeriksaan Kader <span class="required">*</span></label>
        <select id="pemeriksaan_awal_id" name="pemeriksaan_awal_id"
                class="form-control @error('pemeriksaan_awal_id') is-invalid @enderror"
                onchange="loadDataAwal(this)">
          <option value="">Pilih Ibu Hamil yang Sudah Diperiksa Kader</option>
          @foreach($antrianList as $antrian)
            @php $ibu = $antrian->ibuHamil; $gpa = 'G'.($ibu->gravida??0).'P'.($ibu->partus??0).'A'.($ibu->abortus??0); @endphp
            <option value="{{ $antrian->id }}"
                    data-ibu="{{ $ibu->nama_ibu??'-' }}" data-gpa="{{ $gpa }}"
                    data-hpht="{{ $ibu->hpht??'' }}" data-uk="{{ $antrian->usia_kehamilan??0 }}"
                    data-bb="{{ $antrian->berat_badan }}" data-td="{{ $antrian->tekanan_darah }}"
                    data-keluhan="{{ $antrian->keluhan??'' }}" data-tgl="{{ $antrian->tanggal_periksa }}"
                    data-kader="{{ $antrian->kader->nama??'-' }}"
                    {{ (old('pemeriksaan_awal_id', $selectedAwal?->id) == $antrian->id) ? 'selected' : '' }}>
              {{ $ibu->nama_ibu??'-' }} — Periksa: {{ \Carbon\Carbon::parse($antrian->tanggal_periksa)->format('d M Y') }}
            </option>
          @endforeach
        </select>
        @error('pemeriksaan_awal_id')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>

      {{-- Placeholder --}}
      <div id="placeholder-box" style="background:var(--slate-50);border:1.5px dashed var(--slate-200);border-radius:10px;padding:20px;text-align:center;color:var(--slate-400);">
        <i class="fas fa-hand-pointer" style="font-size:20px;margin-bottom:6px;display:block;opacity:.3;"></i>
        <div style="font-size:12.5px;">Pilih data pemeriksaan kader untuk melihat detail</div>
      </div>

      {{-- Data Kader Box --}}
      <div id="data-awal-box" style="display:none;border:1px solid var(--teal-100);border-radius:10px;overflow:hidden;background:#fafdfd;">
        <div style="background:var(--teal-50);padding:8px 14px;display:flex;align-items:center;gap:6px;border-bottom:1px solid var(--teal-100);">
          <i class="fas fa-user-nurse" style="color:var(--teal-700);font-size:12px;"></i>
          <span style="font-size:11px;font-weight:700;color:var(--teal-800);text-transform:uppercase;letter-spacing:.5px;">Data dari Kader</span>
        </div>
        <div style="padding:12px 14px;display:grid;grid-template-columns:repeat(4,1fr);gap:10px 14px;">
          <div><div class="ro-label">Nama Ibu</div><div class="ro-value" id="da-nama">—</div></div>
          <div><div class="ro-label">G/P/A</div><div class="ro-value" id="da-gpa">—</div></div>
          <div><div class="ro-label">Usia Kehamilan</div><div class="ro-value kd-accent" id="da-uk">—</div></div>
          <div><div class="ro-label">Trimester</div><div class="ro-value" id="da-trim">—</div></div>
          <div><div class="ro-label">Berat Badan</div><div class="ro-value" id="da-bb">—</div></div>
          <div><div class="ro-label">Tekanan Darah</div><div style="display:flex;align-items:center;gap:4px;"><div class="ro-value" id="da-td">—</div><span style="font-size:11px;color:#0d9488;font-weight:700;">mmHg</span></div></div>
          <div><div class="ro-label">Tgl Periksa Kader</div><div class="ro-value" id="da-tgl">—</div></div>
          <div><div class="ro-label">Dicatat oleh Kader</div><div class="ro-value" id="da-kader">—</div></div>
        </div>
        <div id="da-keluhan-wrap" style="display:none;background:var(--amber-50);border-top:1px solid var(--amber-100);padding:8px 14px;font-size:12.5px;">
          <span style="font-weight:700;color:var(--amber-800);margin-right:6px;">Keluhan:</span>
          <span style="color:var(--amber-900);" id="da-keluhan">—</span>
        </div>
        <div id="da-nokeluhan-wrap" style="display:none;background:var(--slate-50);border-top:1px solid var(--slate-100);padding:8px 14px;font-size:12px;color:var(--slate-500);">
          <i class="fas fa-check-circle" style="color:var(--teal-600);margin-right:4px;"></i> Tidak ada keluhan dari kader
        </div>
      </div>
    </div>
  </div>

  {{-- CARD 2: Pemeriksaan Bidan & Obstetri --}}
  <div class="card" id="card-obstetri" style="display:none;box-shadow:0 1px 3px rgba(0,0,0,.05);border:1px solid var(--slate-100);">
    <div class="card-header" style="padding:10px 18px;">
      <div class="card-title" style="font-size:14px;"><i class="fas fa-stethoscope" style="color:var(--indigo-600);margin-right:6px;"></i>Pemeriksaan Bidan &amp; Obstetri</div>
    </div>
    <div class="form-section" style="padding-top:14px;">

      {{-- Tanggal --}}
      <div class="form-group" style="max-width:280px;margin-bottom:16px;">
        <label class="form-label" for="tanggal_periksa">Tanggal Pemeriksaan <span class="required">*</span></label>
        <input type="date" id="tanggal_periksa" name="tanggal_periksa"
               class="form-control @error('tanggal_periksa') is-invalid @enderror"
               value="{{ old('tanggal_periksa', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}">
        @error('tanggal_periksa')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>

      {{-- LILA, TFU, DJJ --}}
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;border-top:1px solid var(--slate-100);padding-top:14px;">

        {{-- LILA --}}
        <div class="form-group" style="margin-bottom:0;position:relative;">
          <label class="form-label" for="lila">Lingkar Lengan Atas (LILA) <span class="required">*</span></label>
          <div style="position:relative;">
            <input type="number" id="lila" name="lila" step="1" placeholder="Contoh: 26.5"
                   class="form-control @error('lila') is-invalid @enderror"
                   value="{{ old('lila') }}"
                   oninput="checkLILA()"
                   onfocus="showRef('lila-ref')"
                   onblur="hideRef('lila-ref')"
                   style="padding-right:42px;">
            <span class="unit-lbl">cm</span>
          </div>
          <div id="lila-status" class="field-status"></div>
          @error('lila')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
          {{-- LILA Reference Panel --}}
          <div id="lila-ref" class="ref-panel" style="display:none;">
            <div class="ref-panel-title"><i class="fas fa-book-medical"></i> Referensi LILA — WHO / Kemenkes RI</div>
            <div class="ref-grid">
              <div class="ref-item ref-danger">
                <div class="ref-item-title">KEK (Kurang Energi Kronis)</div>
                <div class="ref-item-range">&lt; 23,5 cm</div>
                <div class="ref-item-desc">Ibu hamil berisiko melahirkan bayi BBLR. Perlu penanganan gizi segera dan konseling nutrisi intensif.</div>
              </div>
              <div class="ref-item ref-normal">
                <div class="ref-item-title">Normal</div>
                <div class="ref-item-range">23,5 – 28,5 cm</div>
                <div class="ref-item-desc">Status gizi ibu hamil dalam batas normal. Pertahankan pola makan seimbang dan pemantauan rutin.</div>
              </div>
              <div class="ref-item ref-warning">
                <div class="ref-item-title">Overweight / Obesitas</div>
                <div class="ref-item-range">&gt; 28,5 cm</div>
                <div class="ref-item-desc">Berat badan berlebih berisiko terhadap komplikasi kehamilan seperti preeklamsia. Pantau asupan kalori.</div>
              </div>
            </div>
            <div class="ref-note"><i class="fas fa-info-circle"></i> Berdasarkan Pedoman Gizi Seimbang Kemenkes RI & standar WHO untuk ibu hamil.</div>
          </div>
        </div>

        {{-- TFU --}}
        <div class="form-group" style="margin-bottom:0;position:relative;">
          <label class="form-label" for="tfu">Tinggi Fundus Uteri (TFU)</label>
          <div style="position:relative;">
            <input type="number" id="tfu" name="tfu" step="1" placeholder="Contoh: 30"
                   class="form-control @error('tfu') is-invalid @enderror"
                   value="{{ old('tfu') }}"
                   onfocus="showRef('tfu-ref')"
                   onblur="hideRef('tfu-ref')"
                   style="padding-right:42px;">
            <span class="unit-lbl">cm</span>
          </div>
          @error('tfu')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
          {{-- TFU Reference Panel --}}
          <div id="tfu-ref" class="ref-panel" style="display:none;">
            <div class="ref-panel-title"><i class="fas fa-book-medical"></i> Referensi TFU — McDonald's Rule</div>
            <div style="overflow-x:auto;">
              <table class="ref-table">
                <thead><tr><th>Usia Kehamilan</th><th>TFU Normal</th><th>Keterangan</th></tr></thead>
                <tbody>
                  <tr><td>12 minggu</td><td>±12 cm</td><td>Setinggi simfisis pubis</td></tr>
                  <tr><td>16 minggu</td><td>±16 cm</td><td>Antara simfisis & pusat</td></tr>
                  <tr><td>20 minggu</td><td>±20 cm</td><td>Setinggi umbilikus</td></tr>
                  <tr><td>24 minggu</td><td>±24 cm</td><td>2 jari di atas pusat</td></tr>
                  <tr><td>28 minggu</td><td>±26–28 cm</td><td>3 jari di atas pusat</td></tr>
                  <tr><td>32 minggu</td><td>±29–32 cm</td><td>Antara pusat & prosesus xiphoid</td></tr>
                  <tr><td>36 minggu</td><td>±32–34 cm</td><td>Setinggi prosesus xiphoid</td></tr>
                  <tr><td>40 minggu</td><td>±33–37 cm</td><td>Turun ke bawah prosesus xiphoid</td></tr>
                </tbody>
              </table>
            </div>
            <div class="ref-note"><i class="fas fa-info-circle"></i> Estimasi: TFU (cm) ≈ Usia kehamilan (minggu) pada 20–36 minggu. Variasi normal ±2 cm.</div>
          </div>
        </div>

        {{-- DJJ --}}
        <div class="form-group" style="margin-bottom:0;position:relative;">
          <label class="form-label" for="djj">Detak Jantung Janin (DJJ)</label>
          <div style="display:flex;align-items:center;gap:6px;">
            <input type="number" id="djj" name="djj" step="1" placeholder="Contoh: 142"
                   class="form-control @error('djj') is-invalid @enderror"
                   value="{{ old('djj') }}"
                   oninput="checkDJJ()"
                   onfocus="showRef('djj-ref')"
                   onblur="hideRef('djj-ref')">
            <span style="font-size:12px;color:var(--slate-400);white-space:nowrap;">bpm</span>
          </div>
          <div id="djj-status" class="field-status"></div>
          @error('djj')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
          {{-- DJJ Reference Panel --}}
          <div id="djj-ref" class="ref-panel" style="display:none;">
            <div class="ref-panel-title"><i class="fas fa-book-medical"></i> Referensi DJJ — Standar WHO / ACOG</div>
            <div class="ref-grid ref-grid-2">
              <div class="ref-item ref-danger">
                <div class="ref-item-title">Bradikardi</div>
                <div class="ref-item-range">&lt; 120 bpm</div>
                <div class="ref-item-desc">DJJ terlalu lambat. Dapat mengindikasikan hipoksia janin, kompresi tali pusat, atau masalah jantung janin. Segera evaluasi lebih lanjut.</div>
              </div>
              <div class="ref-item ref-normal">
                <div class="ref-item-title">Normal</div>
                <div class="ref-item-range">120 – 160 bpm</div>
                <div class="ref-item-desc">Denyut jantung janin dalam batas normal. Menunjukkan kondisi janin yang baik dan reaktif.</div>
              </div>
              <div class="ref-item ref-warning">
                <div class="ref-item-title">Takikardi</div>
                <div class="ref-item-range">&gt; 160 bpm</div>
                <div class="ref-item-desc">DJJ terlalu cepat. Dapat disebabkan oleh infeksi, anemia, atau kondisi janin yang tertekan. Perlu pemantauan ketat.</div>
              </div>
            </div>
            <div class="ref-note"><i class="fas fa-info-circle"></i> Berdasarkan standar WHO & American College of Obstetricians and Gynecologists (ACOG). Pemeriksaan dengan Doppler atau stetoskop Pinard.</div>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- CARD 3: Catatan + Tindak Lanjut --}}
  <div class="card" id="card-diagnosa" style="display:none;box-shadow:0 1px 3px rgba(0,0,0,.05);border:1px solid var(--slate-100);">
    <div class="card-header" style="padding:10px 18px;">
      <div class="card-title" style="font-size:14px;"><i class="fas fa-notes-medical" style="color:var(--indigo-600);margin-right:6px;"></i>Catatan &amp; Tindak Lanjut</div>
    </div>
    <div class="form-section" style="padding-top:14px;">
      <div class="form-group">
        <label class="form-label" for="catatan_bidan">Catatan / Tindakan Bidan</label>
        <textarea id="catatan_bidan" name="catatan_bidan" rows="3"
                  class="form-control @error('catatan_bidan') is-invalid @enderror"
                  placeholder="Tuliskan catatan, hasil pemeriksaan, tindakan yang dilakukan…">{{ old('catatan_bidan') }}</textarea>
        <div style="display:flex;justify-content:space-between;margin-top:3px;">
          <div></div>
          <div id="catatan-count" style="font-size:12px;color:var(--slate-400);">0 / 255</div>
        </div>
        @error('catatan_bidan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label">Tindak Lanjut <span class="required">*</span></label>
        <div class="tl-picker" style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;">
          @foreach([['kontrol','Kontrol Rutin'],['rujukan_puskesmas','Rujuk Puskesmas'],['rujukan_rs','Rujuk RS'],['rawat_inap','Rawat Inap']] as [$val,$label])
          <label class="tl-option {{ old('tindak_lanjut')===$val?'selected':'' }}" id="tl-{{ $val }}" onclick="pickTL('{{ $val }}')" style="padding:8px 10px;font-size:12.5px;border-radius:8px;border-width:1.5px;display:flex;justify-content:center;align-items:center;text-align:center;">
            <input type="radio" name="tindak_lanjut" value="{{ $val }}" {{ old('tindak_lanjut')===$val?'checked':'' }}>
            <span>{{ $label }}</span>
          </label>
          @endforeach
        </div>
        @error('tindak_lanjut')<div class="form-error" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-footer" style="padding:12px 16px;background:var(--slate-50);border-top:1px solid var(--slate-100);display:flex;justify-content:flex-end;gap:8px;border-bottom-left-radius:12px;border-bottom-right-radius:12px;">
      <a href="{{ route('bidan.pemeriksaan-lanjutan-ibu-hamil.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Batal</a>
      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan </button>
    </div>
  </div>

</div>
</form>

@push('styles')
<style>
.ro-label{font-size:9.5px;color:var(--slate-400);margin-bottom:2px;font-weight:600;text-transform:uppercase;letter-spacing:.3px;}
.ro-value{font-size:12px;font-weight:700;color:var(--slate-700);}
.kd-accent{color:var(--teal-600)!important;}
.unit-lbl{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--slate-400);}
.field-status{font-size:11px;min-height:16px;margin-top:3px;}
.form-control.is-invalid{border-color:var(--rose-500);box-shadow:0 0 0 3px rgba(244,63,94,.1);}
.form-error{font-size:12px;color:var(--rose-500);display:flex;align-items:center;gap:4px;margin-top:3px;}
.tl-option{display:flex;align-items:center;gap:8px;cursor:pointer;transition:all .15s;background:#fff;font-weight:600;color:var(--slate-600);border:1.5px solid var(--slate-200);border-radius:8px;}
.tl-option input{display:none;}
.tl-option.selected{border-color:var(--teal-400);background:var(--teal-50);color:var(--teal-700);}

/* Reference Panels */
.ref-panel{position:absolute;top:calc(100% + 6px);left:0;right:0;z-index:200;background:#fff;border:1px solid var(--slate-200);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.12);padding:12px 14px;animation:refFadeIn .18s ease;}
@keyframes refFadeIn{from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:translateY(0);}}
.ref-panel-title{font-size:11.5px;font-weight:700;color:var(--indigo-700);margin-bottom:10px;display:flex;align-items:center;gap:6px;border-bottom:1px solid var(--slate-100);padding-bottom:8px;}
.ref-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:7px;margin-bottom:8px;}
.ref-grid-2{grid-template-columns:repeat(3,1fr)!important;}
.ref-item{border-radius:8px;padding:8px 10px;}
.ref-item-title{font-size:11px;font-weight:800;margin-bottom:2px;}
.ref-item-range{font-size:10.5px;font-weight:700;margin-bottom:3px;}
.ref-item-desc{font-size:10px;line-height:1.4;}
.ref-danger{background:#fee2e2;border:1px solid #fca5a5;}
.ref-danger .ref-item-title,.ref-danger .ref-item-range{color:#991b1b;}
.ref-danger .ref-item-desc{color:#b91c1c;}
.ref-normal{background:#dcfce7;border:1px solid #86efac;}
.ref-normal .ref-item-title,.ref-normal .ref-item-range{color:#166534;}
.ref-normal .ref-item-desc{color:#15803d;}
.ref-warning{background:#fff7ed;border:1px solid #fdba74;}
.ref-warning .ref-item-title,.ref-warning .ref-item-range{color:#9a3412;}
.ref-warning .ref-item-desc{color:#b45309;}
.ref-note{font-size:10px;color:var(--slate-400);border-top:1px solid var(--slate-100);padding-top:7px;display:flex;align-items:flex-start;gap:5px;line-height:1.4;}
.ref-note i{flex-shrink:0;margin-top:1px;}
/* TFU Table */
.ref-table{width:100%;border-collapse:collapse;font-size:10.5px;margin-bottom:8px;}
.ref-table th{background:var(--indigo-50);color:var(--indigo-700);font-weight:700;padding:5px 8px;text-align:left;border:1px solid var(--indigo-100);}
.ref-table td{padding:4px 8px;border:1px solid var(--slate-100);color:var(--slate-700);}
.ref-table tr:nth-child(even) td{background:var(--slate-50);}

@media(max-width:768px){
  div[style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important;}
  div[style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:1fr 1fr!important;}
  .tl-picker{grid-template-columns:1fr 1fr!important;}
  .ref-grid{grid-template-columns:1fr!important;}
}
</style>
@endpush

@push('scripts')
<script>
let hphtData = null;
const cards = ['card-obstetri','card-diagnosa'];
let refTimers = {};

function showRef(id) {
  clearTimeout(refTimers[id]);
  const el = document.getElementById(id);
  if (el) el.style.display = 'block';
}

function hideRef(id) {
  refTimers[id] = setTimeout(() => {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
  }, 180);
}

function loadDataAwal(sel) {
  const opt = sel.options[sel.selectedIndex];
  if (!opt.value) {
    document.getElementById('data-awal-box').style.display = 'none';
    document.getElementById('placeholder-box').style.display = 'block';
    cards.forEach(id => document.getElementById(id).style.display = 'none');
    return;
  }
  hphtData = opt.dataset.hpht || null;
  const uk = parseInt(opt.dataset.uk || 0);
  document.getElementById('da-nama').textContent  = opt.dataset.ibu   || '—';
  document.getElementById('da-gpa').textContent   = opt.dataset.gpa   || '—';
  document.getElementById('da-kader').textContent = opt.dataset.kader || '—';
  document.getElementById('da-uk').textContent    = (opt.dataset.uk || '0') + ' minggu';
  document.getElementById('da-trim').textContent  = 'Trimester ' + (uk<=12?'I':uk<=27?'II':'III');
  document.getElementById('da-tgl').textContent   = opt.dataset.tgl ? new Date(opt.dataset.tgl).toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'}) : '—';
  document.getElementById('da-bb').textContent    = (opt.dataset.bb || '—') + ' kg';
  document.getElementById('da-td').textContent    = opt.dataset.td   || '—';
  const k = opt.dataset.keluhan || '';
  document.getElementById('da-keluhan-wrap').style.display = k ? 'block' : 'none';
  document.getElementById('da-nokeluhan-wrap').style.display = k ? 'none' : 'block';
  if (k) document.getElementById('da-keluhan').textContent = k;
  document.getElementById('placeholder-box').style.display = 'none';
  document.getElementById('data-awal-box').style.display   = 'block';
  cards.forEach(id => document.getElementById(id).style.display = 'block');
}

function pickTL(val) {
  document.querySelectorAll('.tl-option').forEach(el => el.classList.remove('selected'));
  const el = document.getElementById('tl-' + val);
  if (el) { el.classList.add('selected'); el.querySelector('input').checked = true; }
}

function checkLILA() {
  const v = parseFloat(document.getElementById('lila').value), el = document.getElementById('lila-status');
  if (!v) return void(el.innerHTML='');
  const [lbl,col] = v<23.5 ? ['KEK — Perlu intervensi gizi','#991b1b'] : v<=28.5 ? ['Normal','#166534'] : ['Overweight','#92400e'];
  el.innerHTML = `<span style="font-weight:700;color:${col};">${lbl}</span>`;
}

function checkDJJ() {
  const v = parseInt(document.getElementById('djj').value), el = document.getElementById('djj-status');
  if (!v) return void(el.innerHTML='');
  const [lbl,col] = v<120 ? ['Bradikardi — Evaluasi segera','#991b1b'] : v<=160 ? ['Normal (120–160 bpm)','#166534'] : ['Takikardi — Perlu pemantauan','#92400e'];
  el.innerHTML = `<span style="font-weight:700;color:${col};">${lbl}</span>`;
}

// Keep panel open when hovering over it
['lila-ref','tfu-ref','djj-ref'].forEach(id => {
  const el = document.getElementById(id);
  if (!el) return;
  el.addEventListener('mouseenter', () => clearTimeout(refTimers[id]));
  el.addEventListener('mouseleave', () => hideRef(id));
});

document.getElementById('catatan_bidan').addEventListener('input', function() {
  document.getElementById('catatan-count').textContent = this.value.length + ' / 255';
});

document.addEventListener('DOMContentLoaded', () => {
  const sel = document.getElementById('pemeriksaan_awal_id');
  if (sel.value) loadDataAwal(sel);
  @if(old('tindak_lanjut')) pickTL('{{ old('tindak_lanjut') }}'); @endif
  @if($errors->any())
    cards.forEach(id => { const el=document.getElementById(id); if(el) el.style.display='block'; });
    document.getElementById('placeholder-box').style.display='none';
  @endif
});
</script>
@endpush
@endsection