@extends('layouts.app')
@section('title', 'Catat Pemeriksaan Balita')
@section('page_title', 'Pemeriksaan Awal Balita')

@section('content')
<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('kader.pemeriksaan-awal-balita.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Catat Pemeriksaan Balita Baru</span>
</div>


<div style="display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;">
<form method="POST" action="{{ route('kader.pemeriksaan-awal-balita.store') }}">
@csrf
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Form Pemeriksaan Awal Balita</div>
      <div class="card-subtitle">Diisi oleh Kader : {{ auth()->user()->nama }}</div>
    </div>
  </div>

  <div class="section-divider">Pilih Balita</div>
  <div class="form-section">
    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label" for="balita_id">Nama Balita <span class="required">*</span></label>
        <select id="balita_id" name="balita_id" class="form-control @error('balita_id') is-invalid @enderror" onchange="loadBalitaData(this)">
          <option value="">Pilih Balita</option>
          @foreach($balitas as $b)
            <option value="{{ $b->id }}" data-lahir="{{ $b->tanggal_lahir }}" data-jk="{{ $b->jenis_kelamin }}"
                    data-ibu="{{ $b->ibuHamil->nama_ibu ?? '-' }}" data-hp="{{ $b->ibuHamil->no_hp ?? '-' }}"
                    {{ old('balita_id', $selectedBalita?->id) == $b->id ? 'selected' : '' }}>
              {{ $b->nama_balita }} ({{ $b->jenis_kelamin==='L'?'Laki-laki':'Perempuan' }} · {{ (int)\Carbon\Carbon::parse($b->tanggal_lahir)->diffInMonths(now()) }} bulan)
            </option>
          @endforeach
        </select>
        @error('balita_id')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div id="balita-info-box" style="display:none;background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:14px 18px;margin-top:4px;">
      <div style="font-size:11px;font-weight:700;color:#9a3412;text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;"><i class="fas fa-info-circle"></i> Info Balita</div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
        <div><div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Jenis Kelamin</div><div style="font-size:13.5px;font-weight:600;" id="info-jk">—</div></div>
        <div><div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Tanggal Lahir</div><div style="font-size:13.5px;font-weight:600;" id="info-lahir">—</div></div>
        <div><div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Usia Saat Ini</div><div style="font-size:13.5px;font-weight:700;color:#9a3412;" id="info-usia">—</div></div>
        <div><div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Nama Ibu</div><div style="font-size:13.5px;font-weight:600;" id="info-ibu">—</div></div>
        <div><div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">No. HP Orang Tua</div><div style="font-size:13.5px;font-weight:600;" id="info-hp">—</div></div>
        <div><div style="font-size:11px;color:var(--slate-500);margin-bottom:2px;">Usia Saat Periksa</div><div style="font-size:13.5px;font-weight:700;color:var(--teal-700);" id="info-usia-periksa">—</div></div>
      </div>
    </div>
  </div>

  <div class="section-divider">Data Pemeriksaan</div>
  <div class="form-section">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="tanggal_periksa">Tanggal Pemeriksaan <span class="required">*</span></label>
        <input type="date" id="tanggal_periksa" name="tanggal_periksa"
               class="form-control @error('tanggal_periksa') is-invalid @enderror"
               value="{{ old('tanggal_periksa', now()->format('Y-m-d')) }}"
               max="{{ now()->format('Y-m-d') }}" onchange="hitungUsiaPeriksa()">
        @error('tanggal_periksa')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Usia Balita Saat Periksa</label>
        <input type="text" id="usia_display" class="form-control" placeholder="Pilih balita & tanggal dulu" readonly style="background:var(--slate-50);color:var(--slate-500);">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="berat_badan">Berat Badan <span class="required">*</span></label>
        <div style="position:relative;">
          <input type="number" id="berat_badan" name="berat_badan" step="0.1" placeholder="Contoh: 9.5"
                 class="form-control @error('berat_badan') is-invalid @enderror"
                 value="{{ old('berat_badan') }}" style="padding-right:42px;">
          <span class="unit-badge">kg</span>
        </div>
        @error('berat_badan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="tinggi_badan">Tinggi / Panjang Badan <span class="required">*</span></label>
        <div style="position:relative;">
          <input type="number" id="tinggi_badan" name="tinggi_badan" step="0.1" placeholder="Contoh: 75.5"
                 class="form-control @error('tinggi_badan') is-invalid @enderror"
                 value="{{ old('tinggi_badan') }}" style="padding-right:42px;">
          <span class="unit-badge">cm</span>
        </div>
        <div class="form-hint">Gunakan panjang badan (tiduran) untuk usia &lt; 2 tahun</div>
        @error('tinggi_badan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="lingkar_kepala">Lingkar Kepala (LK)</label>
        <div style="position:relative;">
          <input type="number" id="lingkar_kepala" name="lingkar_kepala" step="1" placeholder="Contoh: 45"
                 class="form-control @error('lingkar_kepala') is-invalid @enderror"
                 value="{{ old('lingkar_kepala') }}" style="padding-right:42px;">
          <span class="unit-badge">cm</span>
        </div>
        @error('lingkar_kepala')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="lingkar_lengan">Lingkar Lengan (LL/LILA)</label>
        <div style="position:relative;">
          <input type="number" id="lingkar_lengan" name="lingkar_lengan" step="1" placeholder="Contoh: 13"
                 class="form-control @error('lingkar_lengan') is-invalid @enderror"
                 value="{{ old('lingkar_lengan') }}" style="padding-right:42px;">
          <span class="unit-badge">cm</span>
        </div>
        @error('lingkar_lengan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-row form-row-1">
      <div class="form-group">
        <label class="form-label" for="keluhan">Keluhan</label>
        <textarea id="keluhan" name="keluhan" rows="3" maxlength="255"
                  class="form-control @error('keluhan') is-invalid @enderror"
                  placeholder="Tuliskan keluhan balita atau orang tua (jika ada)…&#10;Contoh: Demam, batuk, nafsu makan berkurang, diare, dll.">{{ old('keluhan') }}</textarea>
        <div style="display:flex;justify-content:space-between;margin-top:4px;">
          <div class="form-hint">Kosongkan jika tidak ada keluhan</div>
          <div id="keluhan-count" style="font-size:12px;color:var(--slate-400);">{{ strlen(old('keluhan', '')) }} / 255</div>
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

{{-- Panel referensi WHO --}}
<div style="display:flex;flex-direction:column;gap:14px;">
  <div class="card" style="position:sticky;top:80px;">
    <div class="card-header">
      <div class="card-title" style="font-size:13px;">Referensi BB Normal (WHO)</div>
    </div>
    <div style="padding:14px 16px;">
      <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">Berat Badan per Usia</div>
      @php
        $bbRef=[['0 bln','3.3','3.2'],['3 bln','6.0','5.4'],['6 bln','7.9','7.3'],['9 bln','9.2','8.6'],
                ['12 bln','10.2','9.5'],['18 bln','11.5','10.8'],['24 bln','12.7','12.0'],
                ['36 bln','14.7','14.2'],['48 bln','17.0','16.3'],['60 bln','19.2','18.2']];
      @endphp
      <table style="width:100%;border-collapse:collapse;font-size:12px;">
        <thead><tr style="background:var(--slate-50);">
          <th style="padding:6px 8px;text-align:left;color:var(--slate-500);font-size:11px;">Usia</th>
          <th style="padding:6px 8px;text-align:center;color:#1d4ed8;font-size:11px;">Laki-laki</th>
          <th style="padding:6px 8px;text-align:center;color:#db2777;font-size:11px;">Perempuan</th>
        </tr></thead>
        <tbody>
          @foreach($bbRef as [$u,$l,$p])
          <tr style="border-bottom:1px solid var(--slate-100);">
            <td style="padding:5px 8px;color:var(--slate-600);">{{ $u }}</td>
            <td style="padding:5px 8px;text-align:center;font-weight:600;color:#1d4ed8;">{{ $l }} kg</td>
            <td style="padding:5px 8px;text-align:center;font-weight:600;color:#db2777;">{{ $p }} kg</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div style="font-size:10.5px;color:var(--slate-400);margin-top:8px;text-align:center;">Sumber: WHO Child Growth Standards (median)</div>
    </div>
  </div>
</div>
</div>

@push('styles')
<style>
.form-control.is-invalid{border-color:var(--rose-500);box-shadow:0 0 0 3px rgba(244,63,94,.1);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
.unit-badge{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--slate-400);}
</style>
@endpush

@push('scripts')
<script>
let tglLahirSelected=null;
function loadBalitaData(sel){
  const opt=sel.options[sel.selectedIndex];
  if(!opt.value){document.getElementById('balita-info-box').style.display='none';tglLahirSelected=null;return;}
  tglLahirSelected=opt.dataset.lahir||null;
  const lahir=new Date(tglLahirSelected),now=new Date();
  const b=(now.getFullYear()-lahir.getFullYear())*12+(now.getMonth()-lahir.getMonth());
  const th=Math.floor(b/12),bl=b%12;
  document.getElementById('info-jk').textContent=opt.dataset.jk==='L'?'Laki-laki':'Perempuan';
  document.getElementById('info-lahir').textContent=new Date(tglLahirSelected).toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'});
  document.getElementById('info-usia').textContent=th>0?th+' tahun '+bl+' bulan':b+' bulan';
  document.getElementById('info-ibu').textContent=opt.dataset.ibu||'—';
  document.getElementById('info-hp').textContent=opt.dataset.hp||'—';
  document.getElementById('balita-info-box').style.display='block';
  hitungUsiaPeriksa();
}
function hitungUsiaPeriksa(){
  const tgl=document.getElementById('tanggal_periksa').value;
  const el=document.getElementById('usia_display'),ei=document.getElementById('info-usia-periksa');
  if(!tglLahirSelected||!tgl){el.value='';if(ei)ei.textContent='—';return;}
  const lahir=new Date(tglLahirSelected),p=new Date(tgl);
  const b=(p.getFullYear()-lahir.getFullYear())*12+(p.getMonth()-lahir.getMonth());
  const th=Math.floor(b/12),bl=b%12,lbl=th>0?th+' tahun '+bl+' bulan':b+' bulan';
  el.value=lbl;if(ei)ei.textContent=lbl;
}
document.getElementById('keluhan').addEventListener('input',function(){
  document.getElementById('keluhan-count').textContent=this.value.length+' / 255';
});
document.addEventListener('DOMContentLoaded',()=>{const s=document.getElementById('balita_id');if(s.value)loadBalitaData(s);});
</script>
@endpush
@endsection