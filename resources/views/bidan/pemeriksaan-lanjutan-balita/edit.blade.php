@extends('layouts.app')
@section('title', 'Edit Pemeriksaan Lanjutan Balita')
@section('page_title', 'Edit Pemeriksaan Lanjutan Balita')
@section('content')
@php
  $balita      = $pem->pemeriksaanAwal->balita;
  $usia        = $balita->tanggal_lahir
                   ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($pem->tanggal_periksa ?? now())
                   : 0;
  $usiaLbl     = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';
  $jkBg        = ($balita->jenis_kelamin ?? '') === 'L'
                   ? 'linear-gradient(135deg,#1e40af,#1d4ed8)'
                   : 'linear-gradient(135deg,#9d174d,#db2777)';
  $namaIbu     = $balita->nama_ibu ?? $balita->ibuHamil?->nama_ibu ?? '-';
  $selectedIm  = $pem->imunisasi ? explode(',', $pem->imunisasi) : [];
  $currentGizi = old('status_gizi', $pem->status_gizi);
  $currentVita = old('vitamin_a', $pem->vitamin_a);
  $currentTL   = old('tindak_lanjut', $pem->tindak_lanjut);
  $tglPeriksa  = \Carbon\Carbon::parse($pem->pemeriksaanAwal->tanggal_periksa)->translatedFormat('Y-m-d');
  $imList      = ['BCG','Hepatitis B','DPT-HB-Hib 1','DPT-HB-Hib 2','DPT-HB-Hib 3',
                  'Polio 1','Polio 2','Polio 3','Polio 4','IPV',
                  'Campak/MR','PCV 1','PCV 2','PCV 3','Japanese Encephalitis'];
  $giziOpts    = [
    ['val'=>'baik',   'label'=>'Gizi Baik',  'bg'=>'#dcfce7','color'=>'#166534','border'=>'#86efac'],
    ['val'=>'kurang', 'label'=>'Kurang Gizi','bg'=>'#fff7ed','color'=>'#9a3412','border'=>'#fdba74'],
    ['val'=>'buruk',  'label'=>'Gizi Buruk', 'bg'=>'#fee2e2','color'=>'#991b1b','border'=>'#fca5a5'],
    ['val'=>'lebih',  'label'=>'Gizi Lebih', 'bg'=>'#dbeafe','color'=>'#1e40af','border'=>'#93c5fd'],
  ];
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
  <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index', ['tanggal' => $tglPeriksa]) }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Edit: {{ $balita->nama_balita ?? '-' }}</span>
</div>

{{-- Top Profile Banner --}}
<div style="background:{{ $jkBg }};border-radius:14px;padding:16px 20px;color:#fff;display:flex;align-items:center;gap:16px;margin-bottom:16px;">
  <div style="width:48px;height:48px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;border:1.5px solid rgba(255,255,255,.25);flex-shrink:0;">
    {{ strtoupper(substr($balita->nama_balita ?? 'X', 0, 1)) }}
  </div>
  <div style="flex:1;">
    <div style="font-size:17px;font-weight:700;">{{ $balita->nama_balita ?? '-' }}</div>
    <div style="font-size:12px;color:rgba(255,255,255,.85);margin-top:2px;display:flex;gap:16px;flex-wrap:wrap;">
      <span>{{ ($balita->jenis_kelamin ?? '') === 'L' ? '♂ Laki-laki' : '♀ Perempuan' }}</span>
      <span>Nama Ibu: {{ $namaIbu }}</span>
      <span>Tgl Lahir: {{ \Carbon\Carbon::parse($balita->tanggal_lahir ?? now())->format('d M Y') }}</span>
    </div>
  </div>
  <div style="margin-left:auto;text-align:right;background:rgba(255,255,255,.12);padding:6px 12px;border-radius:10px;border:1px solid rgba(255,255,255,.15);flex-shrink:0;">
    <div style="font-size:13.5px;font-weight:800;">{{ $usiaLbl }}</div>
    <div style="font-size:10px;color:rgba(255,255,255,.7);">usia saat periksa</div>
  </div>
</div>

<form method="POST" action="{{ route('bidan.pemeriksaan-lanjutan-balita.update', $pem) }}">
@csrf @method('PUT')
<input type="hidden" name="redirect_tanggal" value="{{ $tglPeriksa }}">

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:stretch;margin-bottom:16px;">
  <div class="card" style="display:flex;flex-direction:column;">
    <div class="card-header" style="padding:10px 16px;">
      <div class="card-title" style="font-size:14px;"><i class="fas fa-user-nurse" style="color:var(--teal-600);margin-right:6px;"></i>Data Pemeriksaan Kader</div>
    </div>
    <div style="padding:4px 16px 10px;">
      @foreach([
        ['Tgl Periksa Kader', \Carbon\Carbon::parse($pem->pemeriksaanAwal->tanggal_periksa)->format('d/m/Y'), 'fa-calendar'],
        ['Berat Badan', ($pem->pemeriksaanAwal->berat_badan).' kg', 'fa-weight'],
        ['Tinggi Badan', ($pem->pemeriksaanAwal->tinggi_badan ? (int)$pem->pemeriksaanAwal->tinggi_badan : '-').' cm', 'fa-ruler-vertical'],
      ] as [$lbl,$val,$ico])
      <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--slate-100);">
        <i class="fas {{ $ico }}" style="color:var(--slate-400);font-size:12.5px;width:14px;text-align:center;flex-shrink:0;"></i>
        <span style="width:120px;flex-shrink:0;font-size:12.5px;color:var(--slate-500);">{{ $lbl }}</span>
        <span style="flex:1;font-size:13px;font-weight:600;color:var(--slate-800);">{{ $val }}</span>
      </div>
      @endforeach

      <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--slate-100);">
        <i class="fas fa-baby" style="color:var(--slate-400);font-size:12.5px;width:14px;text-align:center;flex-shrink:0;"></i>
        <span style="width:120px;flex-shrink:0;font-size:12.5px;color:var(--slate-500);">Lingkar Kepala</span>
        <span style="flex:1;font-size:13px;font-weight:600;color:var(--slate-800);">
          <input type="hidden" id="lingkar_kepala" value="{{ $pem->pemeriksaanAwal->lingkar_kepala }}">
          {{ $pem->pemeriksaanAwal->lingkar_kepala ? (int)$pem->pemeriksaanAwal->lingkar_kepala : '-' }} cm
        </span>
      </div>

      <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--slate-100);">
        <i class="fas fa-ruler-horizontal" style="color:var(--slate-400);font-size:12.5px;width:14px;text-align:center;flex-shrink:0;"></i>
        <span style="width:120px;flex-shrink:0;font-size:12.5px;color:var(--slate-500);">Lingkar Lengan</span>
        <span style="flex:1;font-size:13px;font-weight:600;color:var(--slate-800);">
          {{ $pem->pemeriksaanAwal->lingkar_lengan ? (int)$pem->pemeriksaanAwal->lingkar_lengan : '-' }} cm
        </span>
      </div>

      <div style="display:flex;align-items:flex-start;gap:10px;padding:8px 0;">
        <i class="fas fa-comment-medical" style="color:var(--slate-400);font-size:12.5px;width:14px;text-align:center;flex-shrink:0;margin-top:2px;"></i>
        <span style="width:120px;flex-shrink:0;font-size:12.5px;color:var(--slate-500);">Keluhan</span>
        <span style="flex:1;font-size:13px;color:var(--slate-800);">{{ $pem->pemeriksaanAwal->keluhan ?? 'Tidak ada keluhan' }}</span>
      </div>

      {{-- Z-Score Live Card --}}
      <div id="zscore-live" style="margin-top:12px;"></div>
    </div>
  </div>

  {{-- ===== RIGHT COLUMN: Pemeriksaan Bidan ===== --}}
  <div class="card">
    <div class="card-header" style="padding:10px 16px;">
      <div class="card-title" style="font-size:14px;"><i class="fas fa-stethoscope" style="color:var(--indigo-600);margin-right:6px;"></i>Pemeriksaan Bidan</div>
    </div>
    <div class="form-section" style="padding-top:14px;">
      {{-- Row 1: Tanggal Pemeriksaan --}}
      <div class="form-group">
        <label class="form-label">Tanggal Pemeriksaan Bidan <span class="required">*</span></label>
        <input type="date" name="tanggal_periksa" max="{{ now()->format('Y-m-d') }}"
          class="form-control @error('tanggal_periksa') is-invalid @enderror"
          value="{{ old('tanggal_periksa', \Carbon\Carbon::parse($pem->tanggal_periksa)->format('Y-m-d')) }}">
        @error('tanggal_periksa')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      {{-- Row 2: Status Gizi --}}
      <div class="form-group">
        <label class="form-label">Status Gizi <span class="required">*</span></label>
        <div class="gizi-picker">
          @foreach($giziOpts as $g)
            <label class="gizi-option {{ $currentGizi===$g['val'] ? 'selected':'' }}"
                  id="gizi-{{ $g['val'] }}"
                  onclick="pickGizi('{{ $g['val'] }}', true)"
                  data-bg="{{ $g['bg'] }}" data-color="{{ $g['color'] }}" data-border="{{ $g['border'] }}"
                  style="{{ $currentGizi===$g['val'] ? 'border-color:'.$g['border'].';background:'.$g['bg'].';' : '' }}">
              <input type="radio" name="status_gizi" value="{{ $g['val'] }}"
                    {{ $currentGizi===$g['val'] ? 'checked':'' }}>
              <span class="gizi-label" style="{{ $currentGizi===$g['val'] ? 'color:'.$g['color'] : '' }}">{{ $g['label'] }}</span>
            </label>
          @endforeach
        </div>
        <div id="gizi-override-note" style="display:none;font-size:11px;color:var(--slate-400);margin-top:4px;">
          <i class="fas fa-info-circle"></i> Diubah manual oleh bidan
        </div>
        @error('status_gizi')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      {{-- Row 3: Imunisasi --}}
      <div class="form-group" style="border-top:1px solid var(--slate-100);padding-top:12px;">
        <label class="form-label">Imunisasi yang Diberikan</label>
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:6px;">
          @foreach($imList as $im)
            <div class="im-chip {{ in_array($im, $selectedIm) ? 'active':'' }}"
                 data-value="{{ $im }}" onclick="toggleImunisasi('{{ $im }}', this)">
              {{ $im }}
            </div>
          @endforeach
        </div>
        <input type="hidden" id="imunisasi" name="imunisasi" value="{{ old('imunisasi', $pem->imunisasi) }}">
        <div class="form-hint" style="margin-top:6px;">Klik chip untuk menambah/menghapus imunisasi</div>
      </div>

      {{-- Row 4: Vitamin A --}}
      <div class="form-group" style="border-top:1px solid var(--slate-100);padding-top:12px;margin-bottom:0;">
        <label class="form-label">Vitamin A <span class="required">*</span></label>
        <div class="vitamin-picker">
          @foreach([
            ['val'=>'diberikan',       'label'=>'Diberikan'],
            ['val'=>'tidak_diberikan', 'label'=>'Tidak Diberikan'],
            ['val'=>'belum_waktunya',  'label'=>'Belum Waktunya'],
          ] as $v)
            <label class="vitamin-option {{ $currentVita===$v['val'] ? 'selected':'' }}"
                   id="vita-{{ $v['val'] }}" onclick="pickVitamin('{{ $v['val'] }}')">
              <input type="radio" name="vitamin_a" value="{{ $v['val'] }}"
                     {{ $currentVita===$v['val'] ? 'checked':'' }}>
              <span>{{ $v['label'] }}</span>
            </label>
          @endforeach
        </div>
        @error('vitamin_a')<div class="form-error">{{ $message }}</div>@enderror
      </div>
    </div>
  </div>

</div>

{{-- Catatan & Tindak Lanjut --}}
<div class="card">
  <div class="card-header" style="padding:10px 16px;">
    <div class="card-title" style="font-size:14px;"><i class="fas fa-notes-medical" style="color:var(--indigo-600);margin-right:6px;"></i>Catatan &amp; Tindak Lanjut</div>
  </div>
  <div class="form-section" style="padding-top:14px; display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    <div class="form-group" style="margin-bottom:0;">
      <label class="form-label">Catatan Bidan</label>
      <textarea name="catatan_bidan" rows="5" class="form-control" style="resize:vertical;"
                placeholder="Catatan klinis…">{{ old('catatan_bidan', $pem->catatan_bidan) }}</textarea>
      <div style="display:flex;justify-content:space-between;margin-top:3px;">
        <div></div>
        <div id="catatan-count" style="font-size:12px;color:var(--slate-400);">{{ strlen(old('catatan_bidan', $pem->catatan_bidan ?? '')) }} / 255</div>
      </div>
      @error('catatan_bidan')<div class="form-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group" style="margin-bottom:0;">
      <label class="form-label">Tindak Lanjut <span class="required">*</span></label>
      <div class="tl-picker">
        @foreach([
          ['val'=>'kontrol',           'label'=>'Kontrol Rutin'],
          ['val'=>'rujukan_puskesmas', 'label'=>'Rujuk Puskesmas'],
          ['val'=>'rujukan_rs',        'label'=>'Rujuk RS'],
          ['val'=>'rawat_inap',        'label'=>'Rawat Inap'],
        ] as $tl)
          <label class="tl-option {{ $currentTL===$tl['val'] ? 'selected':'' }}"
                 id="tl-{{ $tl['val'] }}" onclick="pickTL('{{ $tl['val'] }}')">
            <input type="radio" name="tindak_lanjut" value="{{ $tl['val'] }}"
                   {{ $currentTL===$tl['val'] ? 'checked':'' }}>
            <span>{{ $tl['label'] }}</span>
          </label>
        @endforeach
      </div>
      @error('tindak_lanjut')<div class="form-error">{{ $message }}</div>@enderror
    </div>
  </div>
  <div class="form-footer" style="display:flex; justify-content:flex-end; gap:8px; border-top:1px solid var(--slate-100); padding:10px 16px; background:#fafafa;">
    <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index', ['tanggal' => $tglPeriksa]) }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Batal</a>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan </button>
  </div>
</div>

</form>

@push('styles')
<style>
.form-control.is-invalid{border-color:var(--rose-500);box-shadow:0 0 0 3px rgba(244,63,94,.1);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
.gizi-picker{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;}
.gizi-option{display:flex;align-items:center;justify-content:center;padding:8px 6px;border:2px solid var(--slate-200);border-radius:10px;cursor:pointer;transition:all .15s;background:#fff;text-align:center;}
.gizi-option input{display:none;}
.gizi-label{font-size:12px;font-weight:600;color:var(--slate-600);}
.vitamin-picker{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;}
.vitamin-option{display:flex;align-items:center;justify-content:center;padding:9px;border:2px solid var(--slate-200);border-radius:10px;cursor:pointer;transition:all .15s;background:#fff;font-size:12.5px;font-weight:600;color:var(--slate-600);text-align:center;}
.vitamin-option input{display:none;}
.vitamin-option.selected{border-color:var(--teal-400);background:var(--teal-50);color:var(--teal-700);}
.im-chip{display:inline-flex;align-items:center;padding:4px 10px;border:1.5px solid var(--slate-200);border-radius:20px;font-size:11.5px;font-weight:600;cursor:pointer;transition:all .15s;background:#fff;color:var(--slate-500);user-select:none;}
.im-chip.active{background:var(--teal-600);border-color:var(--teal-600);color:#fff;}
.tl-picker{display:grid;grid-template-columns:1fr 1fr;gap:8px;}
.tl-option{display:flex;align-items:center;gap:8px;padding:9px 12px;border:2px solid var(--slate-200);border-radius:10px;cursor:pointer;transition:all .15s;background:#fff;font-size:12.5px;font-weight:600;color:var(--slate-600);}
.tl-option input{display:none;}
.tl-option.selected{border-color:var(--teal-400);background:var(--teal-50);color:var(--teal-700);}
@media(max-width:900px){
  div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;}
  .form-section[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;}
}
</style>
@endpush

@push('scripts')
<script>
const WHO_BBU = {
  L: {
    0:{m:3.346,s:0.430},1:{m:4.465,s:0.553},2:{m:5.574,s:0.647},3:{m:6.376,s:0.710},
    4:{m:7.010,s:0.757},5:{m:7.510,s:0.793},6:{m:7.934,s:0.820},7:{m:8.297,s:0.843},
    8:{m:8.600,s:0.863},9:{m:8.857,s:0.882},10:{m:9.080,s:0.899},11:{m:9.276,s:0.914},
    12:{m:9.453,s:0.928},13:{m:9.617,s:0.942},14:{m:9.771,s:0.956},15:{m:9.917,s:0.970},
    16:{m:10.058,s:0.983},17:{m:10.196,s:1.011},18:{m:10.332,s:1.010},19:{m:10.466,s:1.023},
    20:{m:10.600,s:1.037},21:{m:10.733,s:1.050},22:{m:10.866,s:1.064},23:{m:10.999,s:1.078},
    24:{m:11.134,s:1.092},25:{m:11.269,s:1.106},26:{m:11.404,s:1.120},27:{m:11.539,s:1.134},
    28:{m:11.674,s:1.148},29:{m:11.809,s:1.162},30:{m:11.944,s:1.176},31:{m:12.078,s:1.190},
    32:{m:12.212,s:1.204},33:{m:12.346,s:1.218},34:{m:12.479,s:1.231},35:{m:12.611,s:1.245},
    36:{m:12.743,s:1.258},37:{m:12.874,s:1.272},38:{m:13.004,s:1.285},39:{m:13.133,s:1.298},
    40:{m:13.261,s:1.311},41:{m:13.388,s:1.324},42:{m:13.514,s:1.337},43:{m:13.639,s:1.350},
    44:{m:13.762,s:1.362},45:{m:13.885,s:1.375},46:{m:14.006,s:1.387},47:{m:14.126,s:1.399},
    48:{m:14.245,s:1.411},49:{m:14.363,s:1.423},50:{m:14.892,s:1.502},51:{m:15.021,s:1.515},
    52:{m:15.149,s:1.528},53:{m:15.276,s:1.540},54:{m:15.401,s:1.553},55:{m:15.526,s:1.565},
    56:{m:15.649,s:1.578},57:{m:15.771,s:1.590},58:{m:15.892,s:1.602},59:{m:16.012,s:1.614},
    60:{m:16.130,s:1.626}
  },
  P: {
    0:{m:3.232,s:0.397},1:{m:4.187,s:0.497},2:{m:5.130,s:0.580},3:{m:5.850,s:0.641},
    4:{m:6.423,s:0.689},5:{m:6.875,s:0.728},6:{m:7.268,s:0.760},7:{m:7.620,s:0.789},
    8:{m:7.934,s:0.814},9:{m:8.200,s:0.838},10:{m:8.452,s:0.860},11:{m:8.685,s:0.880},
    12:{m:8.900,s:0.900},13:{m:9.107,s:0.920},14:{m:9.306,s:0.939},15:{m:9.499,s:0.957},
    16:{m:9.686,s:0.975},17:{m:9.869,s:0.993},18:{m:10.048,s:1.011},19:{m:10.224,s:1.028},
    20:{m:10.397,s:1.046},21:{m:10.568,s:1.063},22:{m:10.737,s:1.080},23:{m:10.904,s:1.097},
    24:{m:11.070,s:1.114},25:{m:11.234,s:1.131},26:{m:11.397,s:1.148},27:{m:11.558,s:1.164},
    28:{m:11.718,s:1.181},29:{m:11.877,s:1.197},30:{m:12.034,s:1.213},31:{m:12.190,s:1.229},
    32:{m:12.345,s:1.245},33:{m:12.498,s:1.261},34:{m:12.650,s:1.276},35:{m:12.800,s:1.291},
    36:{m:12.949,s:1.307},37:{m:13.097,s:1.322},38:{m:13.243,s:1.337},39:{m:13.388,s:1.351},
    40:{m:13.531,s:1.366},41:{m:13.673,s:1.380},42:{m:13.814,s:1.394},43:{m:13.953,s:1.408},
    44:{m:14.091,s:1.422},45:{m:14.228,s:1.436},46:{m:14.363,s:1.449},47:{m:14.497,s:1.463},
    48:{m:14.630,s:1.476},49:{m:14.762,s:1.489},50:{m:14.892,s:1.502},51:{m:15.021,s:1.515},
    52:{m:15.149,s:1.528},53:{m:15.276,s:1.540},54:{m:15.401,s:1.553},55:{m:15.526,s:1.565},
    56:{m:15.649,s:1.578},57:{m:15.771,s:1.590},58:{m:15.892,s:1.602},59:{m:16.012,s:1.614},
    60:{m:16.130,s:1.626}
  }
};
const GIZI_CFG = {
  baik:   {bg:'#dcfce7',color:'#166534',border:'#86efac',label:'Gizi Baik'},
  kurang: {bg:'#fff7ed',color:'#9a3412',border:'#fdba74',label:'Kurang Gizi'},
  buruk:  {bg:'#fee2e2',color:'#991b1b',border:'#fca5a5',label:'Gizi Buruk'},
  lebih:  {bg:'#dbeafe',color:'#1e40af',border:'#93c5fd',label:'Gizi Lebih'},
};
const USIA_BULAN = {{ $usia }};
const JK_BALITA  = '{{ $balita->jenis_kelamin ?? 'L' }}';
const BB_KADER = {{ $pem->pemeriksaanAwal->berat_badan ?? 0 }};
let selectedImunisasi = {!! json_encode($selectedIm) !!};
let isManualOverride  = false;

function updateStatusGizi() {
    const el  = document.getElementById('zscore-live');
    const bb  = BB_KADER;
    if (!bb) { el.innerHTML = ''; return; }
    const ref = (WHO_BBU[JK_BALITA] || WHO_BBU['L'])[USIA_BULAN];
    if (!ref) return;
    const z      = (bb - ref.m) / ref.s;
    const status = z < -3 ? 'buruk' : z < -2 ? 'kurang' : z <= 2 ? 'baik' : 'lebih';
    const cfg    = GIZI_CFG[status];
    el.innerHTML = `<div style="background:${cfg.bg};border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px;font-size:13px;">
        <div style="font-size:20px;font-weight:800;color:${cfg.color};">${z >= 0 ? '+' : ''}${z.toFixed(2)}</div>
        <div>
            <div style="font-weight:700;color:${cfg.color};">${cfg.label}</div>
            <div style="font-size:11.5px;color:var(--slate-400);">BB/U Z-Score · Median WHO: ${ref.m} kg</div>
        </div>
    </div>`;
    if (!isManualOverride) pickGizi(status, false);
}

function pickGizi(val, manual = false) {
  if (manual) { isManualOverride = true; document.getElementById('gizi-override-note').style.display = 'block'; }
  document.querySelectorAll('.gizi-option').forEach(el => {
    el.classList.remove('selected'); el.style.borderColor = ''; el.style.background = '';
    el.querySelector('.gizi-label').style.color = '';
  });
  const el = document.getElementById('gizi-' + val);
  if (!el) return;
  el.classList.add('selected');
  el.style.borderColor = el.dataset.border;
  el.style.background  = el.dataset.bg;
  el.querySelector('.gizi-label').style.color = el.dataset.color;
  el.querySelector('input').checked = true;
}

function checkLK() {
  const v = parseFloat(document.getElementById('lingkar_kepala').value);
  const el = document.getElementById('lk-status');
  if (!v) { el.innerHTML = ''; return; }
  let lbl, color;
  if (v < 33)       { lbl = '(Mikrosefali)'; color = '#991b1b'; }
  else if (v <= 51) { lbl = '(Normal)';      color = '#166534'; }
  else              { lbl = '(Makrosefali)'; color = '#92400e'; }
  el.innerHTML = `<span style="color:${color};font-weight:750;">${lbl}</span>`;
}

function pickVitamin(val) {
  document.querySelectorAll('.vitamin-option').forEach(e => e.classList.remove('selected'));
  document.getElementById('vita-' + val)?.classList.add('selected');
}

function toggleImunisasi(nama, el) {
  el.classList.toggle('active');
  if (el.classList.contains('active')) { if (!selectedImunisasi.includes(nama)) selectedImunisasi.push(nama); }
  else { selectedImunisasi = selectedImunisasi.filter(i => i !== nama); }
  document.getElementById('imunisasi').value = selectedImunisasi.join(',');
}

function pickTL(val) {
  document.querySelectorAll('.tl-option').forEach(e => e.classList.remove('selected'));
  document.getElementById('tl-' + val)?.classList.add('selected');
}

document.addEventListener('DOMContentLoaded', () => {
  checkLK(); updateStatusGizi();
  const c = document.querySelector('textarea[name="catatan_bidan"]');
  if (c) {
    const cnt = document.getElementById('catatan-count');
    c.addEventListener('input', function() { cnt.textContent = this.value.length + ' / 255'; });
  }
});
</script>
@endpush
@endsection