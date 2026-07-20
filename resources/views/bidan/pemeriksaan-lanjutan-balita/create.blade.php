@extends('layouts.app')
@section('title','Catat Pemeriksaan Lanjutan Balita')
@section('page_title','Pemeriksaan Lanjutan Balita')
@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
  <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Catat Pemeriksaan Lanjutan Balita</span>
</div>

<form method="POST" action="{{ route('bidan.pemeriksaan-lanjutan-balita.store') }}">
@csrf

<div style="display:flex; flex-direction:column; gap:16px;">

  {{-- CARD 1: Header & Pilih Balita --}}
  <div class="card" style="box-shadow: 0 1px 3px rgba(0,0,0,.05); border: 1px solid var(--slate-100);">
    <div class="card-header">
      <div>
        <div class="card-title">Pemeriksaan Lanjutan Balita</div>
        <div class="card-subtitle">Bidan: {{ auth()->user()->nama }}</div>
      </div>
    </div>
    <div class="form-section" style="padding-top:14px;">
      <div class="form-group" style="margin-bottom:12px;">
        <label class="form-label" for="pemeriksaan_awal_id">Nama Balita <span class="required">*</span></label>
        <select id="pemeriksaan_awal_id" name="pemeriksaan_awal_id" class="form-control @error('pemeriksaan_awal_id') is-invalid @enderror" onchange="loadDataAwal(this)">
          <option value="">-- Pilih Balita yang Sudah Diperiksa Kader --</option>
          @foreach($antrianList as $a)
            <option value="{{ $a->id }}"
                    data-nama="{{ $a->balita->nama_balita??'-' }}"
                    data-jk="{{ $a->balita->jenis_kelamin??'' }}"
                    data-lahir="{{ $a->balita->tanggal_lahir??'' }}"
                    data-bb="{{ $a->berat_badan }}"
                    data-tb="{{ $a->tinggi_badan }}"
                    data-lk="{{ $a->lingkar_kepala }}"
                    data-ll="{{ $a->lingkar_lengan }}"
                    data-keluhan="{{ $a->keluhan??'' }}"
                    data-tgl="{{ $a->tanggal_periksa }}"
                    data-kader="{{ $a->kader->nama??'-' }}"
                    {{ old('pemeriksaan_awal_id',$selectedAwal?->id)==$a->id?'selected':'' }}>
              {{ $a->balita->nama_balita??'-' }} ({{ $a->balita->jenis_kelamin==='L'?'Laki-laki':'Perempuan' }} · {{ $a->usia_balita??0 }} bulan · {{ \Carbon\Carbon::parse($a->tanggal_periksa)->translatedFormat('d M Y') }})
            </option>
          @endforeach
        </select>
        @error('pemeriksaan_awal_id')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>

      {{-- Placeholder --}}
      <div id="placeholder-box" style="background:var(--slate-50);border:1.5px dashed var(--slate-200);border-radius:10px;padding:20px;text-align:center;color:var(--slate-400);">
        <i class="fas fa-hand-pointer" style="font-size:20px;margin-bottom:6px;display:block;opacity:.3;"></i>
        <div style="font-size:12.5px;">Pilih data pemeriksaan balita untuk melihat detail dari kader</div>
      </div>

      {{-- Data awal box --}}
      <div id="data-awal-box" style="display:none;border:1px solid var(--teal-100);border-radius:10px;overflow:hidden;background:#fafdfd;">
        <div style="background:var(--teal-50);padding:8px 14px;display:flex;align-items:center;gap:6px;border-bottom:1px solid var(--teal-100);">
          <i class="fas fa-user-nurse" style="color:var(--teal-700);font-size:12px;"></i>
          <span style="font-size:11px;font-weight:700;color:var(--teal-800);text-transform:uppercase;letter-spacing:.5px;">Data Pemeriksaan Kader</span>
        </div>
        <div style="padding:12px 14px;display:grid;grid-template-columns:repeat(4,1fr);gap:10px 14px;">
          <div><div class="ro-label">Nama Balita</div><div class="ro-value" id="da-nama">—</div></div>
          <div><div class="ro-label">Jenis Kelamin</div><div class="ro-value" id="da-jk">—</div></div>
          <div><div class="ro-label">Usia Balita</div><div class="ro-value" id="da-usia">—</div></div>
          <div><div class="ro-label">Kader Pencatat</div><div class="ro-value" id="da-kader">—</div></div>
          <div><div class="ro-label">Tgl Periksa Kader</div><div class="ro-value" id="da-tgl">—</div></div>
          <div><div class="ro-label">Berat Badan</div><div class="ro-value" id="da-bb">—</div></div>
          <div><div class="ro-label">Tinggi Badan</div><div class="ro-value" id="da-tb">—</div></div>
          <div><div class="ro-label">Lingkar Lengan / Lingkar Kepala</div><div class="ro-value"><span id="da-ll">—</span> / <span id="da-lk">—</span> <span id="da-lk-status" style="font-size:10px;font-weight:700;"></span></div></div>
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

  {{-- CARD 2: Pemeriksaan Bidan --}}
  <div class="card" id="card-bidan-pemeriksaan" style="display:none; box-shadow: 0 1px 3px rgba(0,0,0,.05); border: 1px solid var(--slate-100);">
    <div class="card-header" style="padding:10px 18px;">
      <div class="card-title" style="font-size:14px;"><i class="fas fa-stethoscope" style="color:var(--indigo-600);margin-right:6px;"></i>Pemeriksaan Bidan</div>
    </div>
    <div class="form-section" style="padding-top:14px;">

      {{-- Row 1: Tanggal & Usia --}}
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Tanggal Pemeriksaan <span class="required">*</span></label>
          <input type="date" id="tanggal_periksa" name="tanggal_periksa"
                 class="form-control @error('tanggal_periksa') is-invalid @enderror"
                 value="{{ old('tanggal_periksa',now()->format('Y-m-d')) }}"
                 max="{{ now()->format('Y-m-d') }}"
                 onchange="hitungUsiaPeriksa();updateStatusGizi();">
          @error('tanggal_periksa')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Usia Balita Saat Diperiksa</label>
          <input type="text" id="usia_display" class="form-control" placeholder="Pilih balita dulu" readonly
                 style="background:var(--slate-50);color:var(--teal-700);font-weight:600;">
        </div>
      </div>

      {{-- Live Z-Score Result --}}
      <div id="zscore-panel" style="margin-bottom:14px;"></div>

      {{-- Status Gizi --}}
      <div class="form-group">
        <label class="form-label">Status Gizi <span class="required">*</span></label>
        <div class="gizi-picker">
          @foreach([
            ['Gizi Baik','Gizi Baik','#dcfce7','#166534','#86efac'],
            ['Gizi Kurang','Gizi Kurang','#fff7ed','#9a3412','#fdba74'],
            ['Gizi Buruk','Gizi Buruk','#fee2e2','#991b1b','#fca5a5'],
            ['Gizi Lebih','Gizi Lebih','#dbeafe','#1e40af','#93c5fd']
            ] as [$v,$lbl,$bg,$clr,$bdr])
          <label class="gizi-option {{ old('status_gizi')===$v?'selected':'' }}" id="gizi-{{ $v }}"
                 onclick="pickGizi('{{ $v }}',true)"
                 data-bg="{{ $bg }}" data-color="{{ $clr }}" data-border="{{ $bdr }}">
            <input type="radio" name="status_gizi" value="{{ $v }}" {{ old('status_gizi')===$v?'checked':'' }}>
            <span class="gizi-label">{{ $lbl }}</span>
          </label>
          @endforeach
        </div>
        <div id="gizi-override-note" style="display:none;font-size:11px;color:var(--slate-400);margin-top:4px;">
          <i class="fas fa-info-circle"></i> Diubah manual oleh bidan
        </div>
        @error('status_gizi')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>

      {{-- Referensi Status Gizi WHO --}}
      <div style="background:var(--slate-50);border:1px solid var(--slate-200);border-radius:10px;padding:14px 16px;margin-bottom:16px;">
        <div style="font-size:12px;font-weight:700;color:var(--slate-700);margin-bottom:10px;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-book-medical" style="color:var(--indigo-600);"></i>
          Referensi Status Gizi Balita — WHO 2006 (BB/U)
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:10px;">
          <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:8px 10px;">
            <div style="font-size:11px;font-weight:800;color:#991b1b;margin-bottom:2px;">Gizi Buruk</div>
            <div style="font-size:10.5px;font-weight:700;color:#991b1b;">Z-Score &lt; -3 SD</div>
            <div style="font-size:10px;color:#b91c1c;margin-top:3px;">Di bawah ambang batas normal WHO. Bidan dapat menentukan tindak lanjut yang sesuai.</div>
          </div>
          <div style="background:#fff7ed;border:1px solid #fdba74;border-radius:8px;padding:8px 10px;">
            <div style="font-size:11px;font-weight:800;color:#9a3412;margin-bottom:2px;">Gizi Kurang</div>
            <div style="font-size:10.5px;font-weight:700;color:#9a3412;">-3 SD s/d &lt; -2 SD</div>
            <div style="font-size:10px;color:#b45309;margin-top:3px;">Berat badan di bawah rentang normal WHO. Perlu pemantauan dan evaluasi lebih lanjut oleh bidan.</div>
          </div>
          <div style="background:#dcfce7;border:1px solid #86efac;border-radius:8px;padding:8px 10px;">
            <div style="font-size:11px;font-weight:800;color:#166534;margin-bottom:2px;">Gizi Baik</div>
            <div style="font-size:10.5px;font-weight:700;color:#166534;">-2 SD s/d +2 SD</div>
            <div style="font-size:10px;color:#15803d;margin-top:3px;">Berat badan normal sesuai usia. Pertahankan pola makan dan tumbuh kembang optimal.</div>
          </div>
          <div style="background:#dbeafe;border:1px solid #93c5fd;border-radius:8px;padding:8px 10px;">
            <div style="font-size:11px;font-weight:800;color:#1e40af;margin-bottom:2px;">Gizi Lebih</div>
            <div style="font-size:10.5px;font-weight:700;color:#1e40af;">&gt; +2 SD</div>
            <div style="font-size:10px;color:#1d4ed8;margin-top:3px;">Berat badan di atas normal. Perlu pemantauan pola makan dan aktivitas fisik anak.</div>
          </div>
        </div>
        <div style="font-size:10.5px;color:var(--slate-400);border-top:1px solid var(--slate-200);padding-top:8px;display:flex;align-items:flex-start;gap:6px;">
          <i class="fas fa-info-circle" style="color:var(--slate-400);margin-top:1px;flex-shrink:0;"></i>
          <span>Kalkulasi menggunakan indikator <strong>BB/U (Berat Badan menurut Umur)</strong> dari WHO Child Growth Standards 2006 sebagai referensi pengukuran standar. Z-Score dihitung otomatis berdasarkan data berat badan kader dan usia balita. Status gizi dapat diubah secara manual oleh bidan sesuai penilaian klinis.</span>
        </div>
      </div>

      {{-- Imunisasi --}}
      <div class="form-group" style="border-top:1px solid var(--slate-100);padding-top:12px;">
        <label class="form-label">Imunisasi yang Diberikan</label>
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:6px;">
          @php $imList=['BCG','Hepatitis B','DPT-HB-Hib 1','DPT-HB-Hib 2','DPT-HB-Hib 3','Polio 1','Polio 2','Polio 3','Polio 4','IPV','Campak/MR','PCV 1','PCV 2','PCV 3','Japanese Encephalitis']; $selIm=old('imunisasi')?explode(',',old('imunisasi')):[]; @endphp
          @foreach($imList as $im)
            <div class="im-chip {{ in_array($im,$selIm)?'active':'' }}" onclick="toggleImunisasi('{{ $im }}',this)">{{ $im }}</div>
          @endforeach
        </div>
        <input type="hidden" id="imunisasi" name="imunisasi" value="{{ old('imunisasi') }}">
        <div class="form-hint">Klik chip untuk pilih/batalkan imunisasi yang diberikan.</div>
      </div>

      {{-- Vitamin A --}}
      <div class="form-group" style="border-top:1px solid var(--slate-100);padding-top:12px;margin-bottom:0;">
        <label class="form-label">Vitamin A <span class="required">*</span></label>
        <div class="vitamin-picker">
          @foreach([['diberikan','Diberikan'],['tidak_diberikan','Tidak Diberikan'],['belum_waktunya','Belum Waktunya']] as [$v,$lbl])
          <label class="vitamin-option {{ old('vitamin_a')===$v?'selected':'' }}" id="vita-{{ $v }}" onclick="pickVitamin('{{ $v }}')">
            <input type="radio" name="vitamin_a" value="{{ $v }}" {{ old('vitamin_a')===$v?'checked':'' }}>
            <span>{{ $lbl }}</span>
          </label>
          @endforeach
        </div>
        @error('vitamin_a')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>

    </div>
  </div>

  {{-- CARD 3: Catatan & Tindak Lanjut --}}
  <div class="card" id="card-tindak-lanjut" style="display:none; box-shadow: 0 1px 3px rgba(0,0,0,.05); border: 1px solid var(--slate-100);">
    <div class="card-header" style="padding:10px 18px;">
      <div class="card-title" style="font-size:14px;"><i class="fas fa-notes-medical" style="color:var(--indigo-600);margin-right:6px;"></i>Catatan &amp; Tindak Lanjut</div>
    </div>
    <div class="form-section" style="padding-top:14px;">
      <div class="form-group">
        <label class="form-label">Catatan Bidan</label>
        <textarea id="catatan_bidan" name="catatan_bidan" rows="3" class="form-control"
                  placeholder="Tuliskan catatan klinis, tindakan, atau rekomendasi…">{{ old('catatan_bidan') }}</textarea>
        <div style="display:flex;justify-content:space-between;margin-top:3px;">
          <div class="form-hint">Rekam semua tindakan dan observasi penting</div>
          <div id="catatan-count" style="font-size:12px;color:var(--slate-400);">0 / 255</div>
        </div>
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label">Tindak Lanjut <span class="required">*</span></label>
        <div class="tl-picker" style="display:grid; grid-template-columns: repeat(4, 1fr); gap:8px;">
          @foreach([['kontrol','Kontrol Rutin'],['rujukan_puskesmas','Rujuk Puskesmas'],['rujukan_rs','Rujuk RS'],['rawat_inap','Rawat Inap']] as [$v,$lbl])
          <label class="tl-option {{ old('tindak_lanjut')===$v?'selected':'' }}" id="tl-{{ $v }}" onclick="pickTL('{{ $v }}')" style="padding:8px 10px; font-size:12.5px; border-radius:8px; border-width:1.5px; display:flex; justify-content:center; align-items:center; text-align:center;">
            <input type="radio" name="tindak_lanjut" value="{{ $v }}" {{ old('tindak_lanjut')===$v?'checked':'' }}>
            <span>{{ $lbl }}</span>
          </label>
          @endforeach
        </div>
        @error('tindak_lanjut')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-footer" style="padding:12px 16px; background:var(--slate-50); border-top:1px solid var(--slate-100); display:flex; justify-content:flex-end; gap:8px; border-bottom-left-radius:12px; border-bottom-right-radius:12px;">
      <a href="{{ route('bidan.pemeriksaan-lanjutan-balita.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Batal</a>
      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan </button>
    </div>
  </div>

</div>
</form>

@push('styles')
<style>
.ro-label{font-size:9.5px;color:var(--slate-400);margin-bottom:2px;font-weight:600;text-transform:uppercase;letter-spacing:.3px;}
.ro-value{font-size:12px;font-weight:700;color:var(--slate-700);}
.form-control.is-invalid{border-color:var(--rose-500);box-shadow:0 0 0 3px rgba(244,63,94,.1);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
.gizi-picker{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:10px;}
.gizi-option{display:flex;align-items:center;justify-content:center;padding:10px 8px;border:2px solid var(--slate-200);border-radius:8px;cursor:pointer;transition:all .15s;background:#fff;text-align:center;}
.gizi-option input{display:none;}
.gizi-label{font-size:12.5px;font-weight:600;color:var(--slate-600);}
.vitamin-picker{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;}
.vitamin-option{display:flex;align-items:center;justify-content:center;padding:9px;border:2px solid var(--slate-200);border-radius:8px;cursor:pointer;transition:all .15s;background:#fff;font-size:12.5px;font-weight:600;color:var(--slate-600);text-align:center;}
.vitamin-option input{display:none;}
.vitamin-option.selected{border-color:var(--teal-400);background:var(--teal-50);color:var(--teal-700);}
.im-chip{display:inline-flex;align-items:center;padding:4px 10px;border:1.5px solid var(--slate-200);border-radius:20px;font-size:11.5px;font-weight:600;cursor:pointer;transition:all .15s;background:#fff;color:var(--slate-500);user-select:none;}
.im-chip:hover{border-color:var(--teal-300);color:var(--teal-600);}
.im-chip.active{background:var(--teal-600);border-color:var(--teal-600);color:#fff;}
.tl-option{display:flex;align-items:center;gap:8px;cursor:pointer;transition:all .15s;background:#fff;font-weight:600;color:var(--slate-600);}
.tl-option input{display:none;}
.tl-option.selected{border-color:var(--teal-400);background:var(--teal-50);color:var(--teal-700);}
@media(max-width:768px){
  .gizi-picker{grid-template-columns:1fr 1fr!important;}
  .vitamin-picker{grid-template-columns:1fr!important;}
  .tl-picker{grid-template-columns:1fr 1fr!important;}
  div[style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:1fr 1fr!important;}
}
</style>
@endpush

@push('scripts')
<script>
const WHO_BBU={L:{0:{m:3.346,s:.430},1:{m:4.465,s:.553},2:{m:5.574,s:.647},3:{m:6.376,s:.710},4:{m:7.010,s:.757},5:{m:7.510,s:.793},6:{m:7.934,s:.820},7:{m:8.297,s:.843},8:{m:8.600,s:.863},9:{m:8.857,s:.882},10:{m:9.080,s:.899},11:{m:9.276,s:.914},12:{m:9.453,s:.928},13:{m:9.617,s:.942},14:{m:9.771,s:.956},15:{m:9.917,s:.970},16:{m:10.058,s:.983},17:{m:10.196,s:.997},18:{m:10.332,s:1.010},19:{m:10.466,s:1.023},20:{m:10.600,s:1.037},21:{m:10.733,s:1.050},22:{m:10.866,s:1.064},23:{m:10.999,s:1.078},24:{m:11.134,s:1.092},25:{m:11.269,s:1.106},26:{m:11.404,s:1.120},27:{m:11.539,s:1.134},28:{m:11.674,s:1.148},29:{m:11.809,s:1.162},30:{m:11.944,s:1.176},31:{m:12.078,s:1.190},32:{m:12.212,s:1.204},33:{m:12.346,s:1.218},34:{m:12.479,s:1.231},35:{m:12.611,s:1.245},36:{m:12.743,s:1.258},37:{m:12.874,s:1.272},38:{m:13.004,s:1.285},39:{m:13.133,s:1.298},40:{m:13.261,s:1.311},41:{m:13.388,s:1.324},42:{m:13.514,s:1.337},43:{m:13.639,s:1.350},44:{m:13.762,s:1.362},45:{m:13.885,s:1.375},46:{m:14.006,s:1.387},47:{m:14.126,s:1.399},48:{m:14.245,s:1.411},49:{m:14.363,s:1.423},50:{m:14.480,s:1.435},51:{m:14.596,s:1.447},52:{m:14.710,s:1.458},53:{m:14.824,s:1.470},54:{m:14.936,s:1.481},55:{m:15.047,s:1.492},56:{m:15.157,s:1.503},57:{m:15.266,s:1.514},58:{m:15.373,s:1.525},59:{m:15.480,s:1.536},60:{m:15.586,s:1.547}},P:{0:{m:3.232,s:.397},1:{m:4.187,s:.497},2:{m:5.130,s:.580},3:{m:5.850,s:.641},4:{m:6.423,s:.689},5:{m:6.875,s:.728},6:{m:7.268,s:.760},7:{m:7.620,s:.789},8:{m:7.934,s:.814},9:{m:8.200,s:.838},10:{m:8.452,s:.860},11:{m:8.685,s:.880},12:{m:8.900,s:.900},13:{m:9.107,s:.920},14:{m:9.306,s:.939},15:{m:9.499,s:.957},16:{m:9.686,s:.975},17:{m:9.869,s:.993},18:{m:10.048,s:1.011},19:{m:10.224,s:1.028},20:{m:10.397,s:1.046},21:{m:10.568,s:1.063},22:{m:10.737,s:1.080},23:{m:10.904,s:1.097},24:{m:11.070,s:1.114},25:{m:11.234,s:1.131},26:{m:11.397,s:1.148},27:{m:11.558,s:1.164},28:{m:11.718,s:1.181},29:{m:11.877,s:1.197},30:{m:12.034,s:1.213},31:{m:12.190,s:1.229},32:{m:12.345,s:1.245},33:{m:12.498,s:1.261},34:{m:12.650,s:1.276},35:{m:12.800,s:1.291},36:{m:12.949,s:1.307},37:{m:13.097,s:1.322},38:{m:13.243,s:1.337},39:{m:13.388,s:1.351},40:{m:13.531,s:1.366},41:{m:13.673,s:1.380},42:{m:13.814,s:1.394},43:{m:13.953,s:1.408},44:{m:14.091,s:1.422},45:{m:14.228,s:1.436},46:{m:14.363,s:1.449},47:{m:14.497,s:1.463},48:{m:14.630,s:1.476},49:{m:14.762,s:1.489},50:{m:14.892,s:1.502},51:{m:15.021,s:1.515},52:{m:15.149,s:1.528},53:{m:15.276,s:1.540},54:{m:15.401,s:1.553},55:{m:15.526,s:1.565},56:{m:15.649,s:1.578},57:{m:15.771,s:1.590},58:{m:15.892,s:1.602},59:{m:16.012,s:1.614},60:{m:16.130,s:1.626}}};
const GCFG={baik:{bg:'#dcfce7',color:'#166534',border:'#86efac',label:'Gizi Baik'},kurang:{bg:'#fff7ed',color:'#9a3412',border:'#fdba74',label:'Kurang Gizi'},buruk:{bg:'#fee2e2',color:'#991b1b',border:'#fca5a5',label:'Gizi Buruk'},lebih:{bg:'#dbeafe',color:'#1e40af',border:'#93c5fd',label:'Gizi Lebih'}};
let tglLahir=null,jkBalita=null,usiaBulan=null,bbKader=null,isManual=false;
let selIm={!! json_encode(old('imunisasi')?explode(',',old('imunisasi')):[]) !!};

function hitungUsiaPeriksa(){
  const tgl=document.getElementById('tanggal_periksa').value,el=document.getElementById('usia_display');
  if(!tglLahir||!tgl){el.value='';usiaBulan=null;return;}
  const l=new Date(tglLahir),p=new Date(tgl);
  const b=(p.getFullYear()-l.getFullYear())*12+(p.getMonth()-l.getMonth());
  usiaBulan=Math.max(0,Math.min(b,60));
  const th=Math.floor(b/12),bl=b%12;
  el.value=th>0?th+' tahun '+bl+' bulan':b+' bulan';
}

function updateStatusGizi(){
  const panel=document.getElementById('zscore-panel');
  if(!bbKader||usiaBulan===null||!jkBalita){panel.innerHTML='';return;}
  const ref=(WHO_BBU[jkBalita]||WHO_BBU.L)[usiaBulan];if(!ref)return;
  const z=(bbKader-ref.m)/ref.s,status=z<-3?'buruk':z<-2?'kurang':z<=2?'baik':'lebih',cfg=GCFG[status];
  panel.innerHTML=`<div style="background:${cfg.bg};border:1px solid ${cfg.border};border-radius:8px;padding:10px 14px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 3px rgba(0,0,0,.05);">
    <div style="font-size:22px;font-weight:800;color:${cfg.color};min-width:52px;text-align:center;">${z>=0?'+':''}${z.toFixed(2)}</div>
    <div>
      <div style="font-size:13px;font-weight:700;color:${cfg.color};">${cfg.label}</div>
      <div style="font-size:11px;color:var(--slate-500);">BB/U Z-Score · Median WHO: <strong>${ref.m} kg</strong> · Usia: <strong>${usiaBulan} bulan</strong></div>
    </div>
    <div style="margin-left:auto;font-size:10.5px;color:${cfg.color};background:rgba(255,255,255,.5);padding:4px 8px;border-radius:6px;border:1px solid ${cfg.border};white-space:nowrap;">Otomatis WHO 2006</div>
  </div>`;
  if(!isManual)pickGizi(status,false);
}

function loadDataAwal(sel){
  const o=sel.options[sel.selectedIndex];
  if(!o.value){
    document.getElementById('data-awal-box').style.display='none';
    document.getElementById('placeholder-box').style.display='block';
    tglLahir=null;jkBalita=null;usiaBulan=null;bbKader=null;
    document.getElementById('card-bidan-pemeriksaan').style.display='none';
    document.getElementById('card-tindak-lanjut').style.display='none';
    return;
  }
  tglLahir=o.dataset.lahir||null;
  jkBalita=o.dataset.jk||'L';
  isManual=false;
  bbKader=parseFloat(o.dataset.bb)||null;
  const lahirD=tglLahir?new Date(tglLahir):null,nowD=new Date();
  const u=lahirD?(nowD.getFullYear()-lahirD.getFullYear())*12+(nowD.getMonth()-lahirD.getMonth()):0;
  const th=Math.floor(u/12),bl=u%12;
  document.getElementById('da-nama').textContent=o.dataset.nama||'—';
  document.getElementById('da-jk').textContent=jkBalita==='L'?'Laki-laki':'Perempuan';
  document.getElementById('da-kader').textContent=o.dataset.kader||'—';
  document.getElementById('da-tgl').textContent=o.dataset.tgl?new Date(o.dataset.tgl).toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'}):'—';
  document.getElementById('da-usia').textContent=th>0?th+' th '+bl+' bln':u+' bln';
  document.getElementById('da-bb').textContent=(o.dataset.bb||'—')+' kg';
  document.getElementById('da-tb').textContent=(o.dataset.tb&&o.dataset.tb!='null'?parseInt(o.dataset.tb):'—')+' cm';
  document.getElementById('da-ll').textContent=(o.dataset.ll&&o.dataset.ll!='null'?parseInt(o.dataset.ll):'—')+' cm';
  document.getElementById('da-lk').textContent=(o.dataset.lk&&o.dataset.lk!='null'?parseInt(o.dataset.lk):'—')+' cm';
  document.getElementById('da-lk').textContent=(o.dataset.lk&&o.dataset.lk!='null'?parseInt(o.dataset.lk):'—')+' cm';
  const lkVal=parseFloat(o.dataset.lk);
  const lkStatusEl=document.getElementById('da-lk-status');
  if(lkVal&&lkStatusEl){
    let lbl,color;
    if(lkVal<33){lbl='(Mikrosefali)';color='#b91c1c';}else if(lkVal<=51){lbl='(Normal)';color='#15803d';}else{lbl='(Makrosefali)';color='#b45309';}
    lkStatusEl.innerHTML=`<span style="color:${color};font-weight:700;margin-left:4px;">${lbl}</span>`;
  }else if(lkStatusEl){lkStatusEl.innerHTML='';}
  const kel=o.dataset.keluhan||'';
  document.getElementById('da-keluhan-wrap').style.display=kel?'block':'none';
  document.getElementById('da-nokeluhan-wrap').style.display=kel?'none':'block';
  if(kel)document.getElementById('da-keluhan').textContent='"'+kel+'"';
  document.getElementById('placeholder-box').style.display='none';
  document.getElementById('data-awal-box').style.display='block';
  document.getElementById('card-bidan-pemeriksaan').style.display='block';
  document.getElementById('card-tindak-lanjut').style.display='block';
  hitungUsiaPeriksa();
  updateStatusGizi();
}

function pickGizi(val,manual=false){
  if(manual){isManual=true;document.getElementById('gizi-override-note').style.display='block';}
  document.querySelectorAll('.gizi-option').forEach(el=>{el.classList.remove('selected');el.style.borderColor='';el.style.background='';el.querySelector('.gizi-label').style.color='';});
  const el=document.getElementById('gizi-'+val);if(!el)return;
  el.classList.add('selected');el.style.borderColor=el.dataset.border;el.style.background=el.dataset.bg;
  el.querySelector('.gizi-label').style.color=el.dataset.color;el.querySelector('input').checked=true;
}
function pickVitamin(val){document.querySelectorAll('.vitamin-option').forEach(e=>e.classList.remove('selected'));document.getElementById('vita-'+val)?.classList.add('selected');}
function toggleImunisasi(nama,el){el.classList.toggle('active');if(el.classList.contains('active')){if(!selIm.includes(nama))selIm.push(nama);}else{selIm=selIm.filter(i=>i!==nama);}document.getElementById('imunisasi').value=selIm.join(',');}
function pickTL(val){document.querySelectorAll('.tl-option').forEach(e=>e.classList.remove('selected'));document.getElementById('tl-'+val)?.classList.add('selected');}
document.getElementById('catatan_bidan').addEventListener('input',function(){document.getElementById('catatan-count').textContent=this.value.length+' / 255';});
document.addEventListener('DOMContentLoaded',()=>{
  const sel=document.getElementById('pemeriksaan_awal_id');
  if(sel.value)loadDataAwal(sel);
  @if(old('status_gizi'))pickGizi('{{ old('status_gizi') }}',false);@endif
  @if(old('vitamin_a'))pickVitamin('{{ old('vitamin_a') }}');@endif
  @if(old('tindak_lanjut'))pickTL('{{ old('tindak_lanjut') }}');@endif
  selIm.forEach(n=>document.querySelectorAll('.im-chip').forEach(c=>{if(c.textContent.trim()===n)c.classList.add('active');}));
  @if($errors->any())
    document.getElementById('placeholder-box').style.display='none';
    document.getElementById('card-bidan-pemeriksaan').style.display='block';
    document.getElementById('card-tindak-lanjut').style.display='block';
  @endif
});
</script>
@endpush
@endsection