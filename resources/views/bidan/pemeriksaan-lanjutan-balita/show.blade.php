@extends('layouts.app')
@section('title','Detail Pemeriksaan Lanjutan — '.$pem->pemeriksaanAwal->balita->nama_balita ?? '-')
@section('page_title','Detail Pemeriksaan Lanjutan Balita')

@section('content')
@php
  $balita = $pem->pemeriksaanAwal->balita ?? $pem->balita;
  $awal   = $pem->pemeriksaanAwal;
  $usia   = $balita?->tanggal_lahir
              ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($pem->tanggal_periksa)
              : 0;
  $usiaLbl = $usia >= 12 ? floor($usia/12).' th '.($usia%12).' bln' : $usia.' bln';

  $_sgRaw = strtolower(trim($pem->status_gizi ?? ''));

  $statusGiziMap = [
      'gizi baik'   => ['Gizi Baik', '#16a34a'],
      'gizi kurang' => ['Gizi Kurang', '#f59e0b'],
      'gizi buruk'  => ['Gizi Buruk', '#ef4444'],
      'gizi lebih'  => ['Gizi Lebih', '#3b82f6'],
  ];
  [$giziLabel, $giziColor] = $statusGiziMap[$_sgRaw] ?? [$pem->status_gizi ?? '-', '#94a3b8'];

  $vitaminMap = [
    'diberikan'       => 'Diberikan',
    'tidak_diberikan' => 'Tidak Diberikan',
    'belum_waktunya'  => 'Belum Waktunya',
  ];
  $vitaminLabel = $vitaminMap[$pem->vitamin_a] ?? ($pem->vitamin_a ?? '-');

  $dataAwal = [
    ['Tanggal Periksa Awal', \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d F Y')],
    ['Kader Pemeriksa',      $awal?->kader?->nama ?? '-'],
    ['Usia Balita',          $usiaLbl],
    ['Berat Badan',          ($awal->berat_badan ?? '-').' kg'],
    ['Tinggi Badan',         ($awal->tinggi_badan ? (int)$awal->tinggi_badan : '-').' cm'],
    ['Lingkar Kepala',       ($awal->lingkar_kepala ? (int)$awal->lingkar_kepala : '-').' cm'],
    ['Lingkar Lengan',       ($awal->lingkar_lengan ? (int)$awal->lingkar_lengan : '-').' cm'],
    ['Keluhan',              $awal->keluhan ?? 'Tidak ada keluhan'],
  ];

  $dataLanjutan = [
    ['Tanggal Periksa Bidan', \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y')],
    ['Bidan Pemeriksa',       $pem->bidan?->nama ?? '-'],
    ['Status Gizi',           $giziLabel],
    ['Imunisasi',             $pem->imunisasi ?? '-'],
    ['Vitamin A',             $vitaminLabel],
    ['Tindak Lanjut',         $pem->tindak_lanjut ?? '-'],
  ];

  $isBoy = ($balita->jenis_kelamin ?? 'P') === 'L';

  if ($_sgRaw === 'gizi buruk') {
    $bannerGradient = 'linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%)';
    $bannerAccent   = 'rgba(252,165,165,0.15)';
    $statusLabel    = 'Gizi Buruk — Stunting';
    $statusIcon     = 'fa-triangle-exclamation';
    $statusBadgeBg  = 'rgba(254,226,226,0.25)';
  } elseif ($_sgRaw === 'gizi kurang') {
    $bannerGradient = 'linear-gradient(135deg, #d97706 0%, #b45309 50%, #92400e 100%)';
    $bannerAccent   = 'rgba(253,230,138,0.15)';
    $statusLabel    = 'Gizi Kurang';
    $statusIcon     = 'fa-circle-exclamation';
    $statusBadgeBg  = 'rgba(254,243,199,0.25)';
  } elseif ($_sgRaw === 'gizi baik') {
    $bannerGradient = 'linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14a398 100%)';
    $bannerAccent   = 'rgba(153,246,228,0.15)';
    $statusLabel    = 'Gizi Baik';
    $statusIcon     = 'fa-circle-check';
    $statusBadgeBg  = 'rgba(204,251,241,0.25)';
  } elseif ($_sgRaw === 'gizi lebih') {
    $bannerGradient = 'linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%)';
    $bannerAccent   = 'rgba(147,197,253,0.15)';
    $statusLabel    = 'Gizi Lebih';
    $statusIcon     = 'fa-circle-exclamation';
    $statusBadgeBg  = 'rgba(219,234,254,0.25)';
  } elseif ($isBoy) {
    $bannerGradient = 'linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%)';
    $bannerAccent   = 'rgba(147,197,253,0.15)';
    $statusLabel    = 'Belum Ada Pemeriksaan';
    $statusIcon     = 'fa-clock';
    $statusBadgeBg  = 'rgba(219,234,254,0.25)';
  } else {
    $bannerGradient = 'linear-gradient(135deg, #db2777 0%, #be185d 50%, #9d174d 100%)';
    $bannerAccent   = 'rgba(251,207,232,0.15)';
    $statusLabel    = 'Belum Ada Pemeriksaan';
    $statusIcon     = 'fa-clock';
    $statusBadgeBg  = 'rgba(252,231,243,0.25)';
  }

  $sudahDiubah = $pem->updated_at && $pem->created_at
    && $pem->updated_at->ne($pem->created_at)
    && $pem->updatedBy;
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ url()->previous() }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ {{ $balita->nama_balita ?? '-' }}</span>
</div>

{{-- ── BANNER ──────────────────────────────────────────── --}}
<div class="pasien-header" style="background:{{ $bannerGradient }};margin-bottom:20px;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:{{ $bannerAccent }};pointer-events:none;"></div>
  <div style="position:absolute;bottom:-60px;right:80px;width:240px;height:240px;border-radius:50%;background:{{ $bannerAccent }};pointer-events:none;"></div>

  <div class="pasien-avatar-lg" style="background:rgba(255,255,255,0.2);border:2.5px solid rgba(255,255,255,0.35);font-size:26px;font-weight:800;color:#fff;flex-shrink:0;position:relative;z-index:1;">
    {{ strtoupper(substr($balita->nama_balita ?? 'B', 0, 1)) }}
  </div>

  <div style="flex:1;min-width:0;position:relative;z-index:1;">
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
      <div style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-.3px;">{{ $balita->nama_balita ?? '-' }}</div>
      <span style="background:{{ $statusBadgeBg }};border:1.5px solid rgba(255,255,255,0.3);color:#fff;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:.3px;backdrop-filter:blur(4px);">
        <i class="fas {{ $statusIcon }}" style="margin-right:4px;"></i>{{ $statusLabel }}
      </span>
    </div>
    <div class="pasien-meta" style="color:rgba(255,255,255,0.75);">
      <span>
        <i class="fas fa-{{ $isBoy ? 'mars' : 'venus' }}" style="margin-right:4px;"></i>
        {{ $isBoy ? 'Laki-laki' : 'Perempuan' }}
      </span>
      <span><i class="fas fa-birthday-cake" style="margin-right:4px;"></i>{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
      <span><i class="fas fa-person" style="margin-right:4px;"></i>Ibu: {{ $balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-' }}</span>
      @if($balita->ibuHamil?->no_hp)
        <span><i class="fab fa-whatsapp" style="margin-right:4px;"></i>{{ $balita->ibuHamil->no_hp }}</span>
      @endif
    </div>
  </div>

  <div style="display:flex;gap:10px;flex-wrap:wrap;position:relative;z-index:1;">
    @foreach([
      ['label'=>'Usia',        'val'=>$usiaLbl,    'icon'=>'fa-cake-candles'],
      ['label'=>'Status Gizi', 'val'=>$giziLabel,  'icon'=>'fa-weight-scale'],
      ['label'=>'Tanggal Periksa','val'=>\Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y'),'icon'=>'fa-calendar'],
    ] as $s)
    <div style="background:rgba(255,255,255,0.15);backdrop-filter:blur(6px);border:1.5px solid rgba(255,255,255,0.25);border-radius:12px;padding:10px 16px;text-align:center;min-width:110px;">
      <div style="font-size:10px;color:rgba(255,255,255,0.7);margin-bottom:3px;text-transform:uppercase;letter-spacing:.5px;">
        <i class="fas {{ $s['icon'] }}" style="margin-right:3px;"></i>{{ $s['label'] }}
      </div>
      <div style="font-size:13px;font-weight:700;color:#fff;">{{ $s['val'] }}</div>
    </div>
    @endforeach
  </div>
</div>

{{-- ── 2 kolom detail ─────────────────────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="fas fa-user-nurse" style="color:var(--teal-500);margin-right:6px;"></i> Pemeriksaan Awal oleh Kader</div>
    </div>
    <div style="padding:16px;">
      @foreach($dataAwal as [$label, $val])
      <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid var(--slate-100);">
        <span style="width:150px;flex-shrink:0;font-size:12px;color:var(--slate-400);">{{ $label }}</span>
        <strong style="flex:1;font-size:13px;font-weight:600;color:var(--slate-700);">{{ $val }}</strong>
      </div>
      @endforeach
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="fas fa-stethoscope" style="color:#6366f1;margin-right:6px;"></i> Pemeriksaan Lanjutan oleh Bidan</div>
    </div>
    <div style="padding:16px;">
      @foreach($dataLanjutan as [$label, $val])
      <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid var(--slate-100);">
        <span style="width:150px;flex-shrink:0;font-size:12px;color:var(--slate-400);">{{ $label }}</span>
        <strong style="flex:1;font-size:13px;font-weight:600;color:var(--slate-700);">{{ $val }}</strong>
      </div>
      @endforeach
    </div>
  </div>

</div>

@if($pem->catatan_bidan)
<div class="card" style="margin-bottom:16px;">
  <div class="card-header">
    <div class="card-title"><i class="fas fa-notes-medical" style="color:#f59e0b;margin-right:6px;"></i> Catatan Bidan</div>
  </div>
  <div style="padding:18px;font-size:13px;line-height:1.7;color:var(--slate-600);">{{ $pem->catatan_bidan }}</div>
</div>
@endif

{{-- ── Riwayat Pencatatan ──────────────────────────────────────────────────── --}}
<div class="card">
  <div class="card-header" style="display:flex;align-items:center;gap:10px;padding:14px 18px;">
    <div style="width:32px;height:32px;border-radius:9px;background:#f0f9ff;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-clock-rotate-left" style="color:#0ea5e9;font-size:13px;"></i>
    </div>
    <div style="font-size:13px;font-weight:700;color:var(--slate-800);">Riwayat Pencatatan</div>
  </div>
  <div style="padding:20px;display:flex;gap:16px;flex-wrap:wrap;">

    {{-- Dicatat Oleh --}}
    <div style="flex:1;min-width:220px;">
      <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;">
        <i class="fas fa-pen-to-square" style="margin-right:4px;"></i> Dicatat Oleh
      </div>
      <div style="display:flex;align-items:center;gap:14px;padding:14px;background:var(--teal-50);border:1.5px solid var(--teal-200);border-radius:12px;">
        <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--teal-400),var(--teal-600));border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
          {{ strtoupper(substr($pem->createdBy->nama ?? $pem->bidan->nama ?? 'B', 0, 1)) }}
        </div>
        <div>
          <div style="font-weight:700;color:var(--slate-800);font-size:14px;">
            <span style="font-size:11px;color:var(--teal-600);font-weight:600;">Bidan:</span>
            {{ $pem->createdBy->nama ?? $pem->bidan->nama ?? '-' }}
          </div>
          <div style="font-size:12px;color:var(--slate-400);margin-top:3px;">
            <i class="fas fa-clock" style="margin-right:3px;"></i>
            {{ $pem->created_at ? $pem->created_at->translatedFormat('d F Y — H:i') : '-' }} WIB
          </div>
        </div>
      </div>
    </div>

    <div style="width:1.5px;background:var(--slate-100);border-radius:2px;align-self:stretch;"></div>

    {{-- Terakhir Diubah --}}
    <div style="flex:1;min-width:220px;">
      <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;">
        <i class="fas fa-clock-rotate-left" style="margin-right:4px;"></i> Terakhir Diubah
      </div>
      @if($sudahDiubah)
        <div style="display:flex;align-items:center;gap:14px;padding:14px;background:#fffbeb;border:1.5px solid #fcd34d;border-radius:12px;">
          <div style="width:44px;height:44px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
            {{ strtoupper(substr($pem->updatedBy->nama ?? 'U', 0, 1)) }}
          </div>
          <div>
            <div style="font-weight:700;color:#78350f;font-size:14px;">
              <span style="font-size:11px;color:#d97706;font-weight:600;">{{ ucfirst($pem->updatedBy->role ?? 'Bidan') }}:</span>
              {{ $pem->updatedBy->nama }}
            </div>
            <div style="font-size:12px;color:#92400e;margin-top:3px;">
              <i class="fas fa-clock" style="margin-right:3px;"></i>
              {{ $pem->updated_at ? $pem->updated_at->translatedFormat('d F Y — H:i') : '-' }} WIB
            </div>
          </div>
        </div>
      @else
        <div style="display:flex;align-items:center;gap:12px;padding:14px;background:var(--slate-50);border:1.5px solid var(--slate-200);border-radius:12px;">
          <div style="width:44px;height:44px;background:linear-gradient(135deg,#94a3b8,#64748b);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-check" style="color:#fff;font-size:16px;"></i>
          </div>
          <div>
            <div style="font-size:13px;font-weight:600;color:var(--slate-500);">Belum pernah diubah</div>
            <div style="font-size:12px;color:var(--slate-400);margin-top:2px;">Data masih original sejak dicatat</div>
          </div>
        </div>
      @endif
    </div>

  </div>
</div>

@endsection

@push('styles')
<style>
.card{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden;margin-bottom:0;}
.card-header{padding:14px 18px 12px;border-bottom:1px solid var(--slate-100);}
.card-title{font-size:14px;font-weight:700;color:var(--slate-800);}
.btn{display:inline-flex;align-items:center;gap:6px;border-radius:8px;font-size:13px;font-weight:600;padding:7px 14px;cursor:pointer;text-decoration:none;transition:all .15s;border:none;}
.btn-outline{border:1.5px solid #e2e8f0;color:#475569;background:#fff;}
.btn-outline:hover{background:#f8fafc;}
.btn-sm{font-size:12px;padding:5px 12px;}

.pasien-header{display:flex;align-items:center;gap:20px;flex-wrap:wrap;padding:24px 28px;border-radius:16px;}
.pasien-avatar-lg{width:68px;height:68px;border-radius:18px;display:flex;align-items:center;justify-content:center;}
.pasien-meta{display:flex;gap:14px;flex-wrap:wrap;margin-top:8px;font-size:12px;}
.pasien-meta span{display:flex;align-items:center;gap:4px;}

@media(max-width:900px){
  div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;}
  .pasien-header{flex-direction:column;align-items:flex-start;gap:16px;}
  .pasien-header > div:last-child{width:100%;}
  .pasien-header > div:last-child > div{flex:1;min-width:calc(50% - 5px);}
}
@media(max-width:768px){
  .pasien-header{padding:12px 14px!important;gap:10px!important;align-items:stretch!important;}
  .pasien-avatar-lg{display:none!important;}
  .pasien-header > div[style*="flex:1"]{width:100%!important;flex:none!important;}
  .pasien-header > div[style*="flex:1"] > div:first-child{display:flex!important;flex-wrap:wrap!important;align-items:center!important;gap:8px!important;margin-bottom:6px!important;}
  .pasien-header > div[style*="flex:1"] > div:first-child > div{font-size:18px!important;font-weight:800!important;}
  .pasien-header > div[style*="flex:1"] > div:first-child > span{padding:3px 10px!important;font-size:10px!important;border-radius:12px!important;}
  .pasien-meta{
    display:grid!important;
    grid-template-columns:1fr 1fr!important;
    gap:6px 12px!important;
    margin-top:6px!important;
    width:100%!important;
    box-sizing:border-box!important;
  }
  .pasien-meta span{
    display:flex!important;
    align-items:center!important;
    font-size:11px!important;
    line-height:1.3!important;
    color:rgba(255,255,255,0.85)!important;
    white-space:nowrap!important;
    overflow:hidden!important;
    text-overflow:ellipsis!important;
  }
  .pasien-meta span i{
    width:14px!important;
    text-align:center!important;
    margin-right:6px!important;
    flex-shrink:0!important;
    font-size:11.5px!important;
    opacity:0.9!important;
  }
  .pasien-header > div[style*="gap:10px"]{
    display:grid!important;
    grid-template-columns:repeat(3,1fr)!important;
    gap:6px!important;
    width:100%!important;
    margin-top:4px!important;
  }
  .pasien-header > div[style*="gap:10px"] > div{
    min-width:0!important;
    padding:6px 4px!important;
    border-radius:8px!important;
    text-align:center!important;
  }
  .pasien-header > div[style*="gap:10px"] > div div:first-child{
    font-size:8px!important;
    margin-bottom:2px!important;
    letter-spacing:0.1px!important;
  }
  .pasien-header > div[style*="gap:10px"] > div div:last-child{
    font-size:11px!important;
    white-space:nowrap!important;
    overflow:hidden!important;
    text-overflow:ellipsis!important;
  }
}
</style>
@endpush