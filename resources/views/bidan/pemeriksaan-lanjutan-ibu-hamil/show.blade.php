@extends('layouts.app')
@section('title','Detail Pemeriksaan Lanjutan — '.($pem->pemeriksaanAwal->ibuHamil->nama_ibu ?? '-'))
@section('page_title','Detail Pemeriksaan Lanjutan Ibu Hamil')

@section('content')
@php
  $ibu  = $pem->pemeriksaanAwal->ibuHamil;
  $awal = $pem->pemeriksaanAwal;
  $uk   = $pem->pemeriksaanAwal->usia_kehamilan ?? 0;
  $trim = $uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III');

  $bannerMap = [
      'I'   => ['#0d3b38', '#0f766e'],
      'II'  => ['#1e3a8a', '#2563eb'],
      'III' => ['#7f1d1d', '#dc2626'],
  ];

  $colors = $bannerMap[$trim] ?? ['#475569','#64748b'];
  $c1 = $colors[0];
  $c2 = $colors[1];

  $tlMap = [
    'Kontrol rutin'     => ['label'=>'Kontrol Rutin',   'icon'=>'fa-calendar-check','color'=>'#059669','bg'=>'#d1fae5'],
    'Rujukan puskesmas' => ['label'=>'Rujuk Puskesmas', 'icon'=>'fa-clinic-medical','color'=>'#d97706','bg'=>'#fef3c7'],
    'Rujukan RS'        => ['label'=>'Rujuk RS',        'icon'=>'fa-hospital',      'color'=>'#dc2626','bg'=>'#fee2e2'],
    'Rawat inap'        => ['label'=>'Rawat Inap',      'icon'=>'fa-bed',           'color'=>'#7c3aed','bg'=>'#ede9fe'],
  ];

  $tl = $tlMap[$pem->tindak_lanjut] ?? null;

  $backUrl = request('ref') ? urldecode(request('ref'))
             : route('bidan.pemeriksaan-lanjutan-ibu-hamil.index');

  $sudahDiubah = $pem->updated_at && $pem->created_at
    && $pem->updated_at->ne($pem->created_at)
    && $pem->updatedBy;
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ $backUrl }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ {{ $ibu->nama_ibu ?? '-' }}</span>
</div>


<div style="background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});border-radius:18px;padding:24px 28px;color:#fff;display:flex;align-items:center;gap:20px;margin-bottom:20px;position:relative;overflow:hidden;">
  <div style="position:absolute;right:-40px;bottom:-40px;width:160px;height:160px;background:rgba(255,255,255,.06);border-radius:50%;"></div>
  <div style="position:absolute;right:80px;top:-20px;width:80px;height:80px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
  <div style="width:62px;height:62px;border-radius:16px;background:rgba(255,255,255,.22);display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;flex-shrink:0;border:2px solid rgba(255,255,255,.3);">
    {{ strtoupper(substr($ibu->nama_ibu ?? 'X', 0, 1)) }}
  </div>
  <div style="flex:1;">
    <div style="font-size:20px;font-weight:800;letter-spacing:-.3px;">{{ $ibu->nama_ibu ?? '-' }}</div>
    <div style="font-size:12.5px;color:rgba(255,255,255,.75);margin-top:5px;display:flex;gap:20px;flex-wrap:wrap;">
      @if(!empty($ibu->tanggal_lahir))
        <span>Tgl. Lahir: {{ \Carbon\Carbon::parse($ibu->tanggal_lahir)->translatedFormat('d F Y') }}</span>
      @endif
    </div>
    <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;">
      @if($trim)
        <span style="background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.35);padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;">Trimester {{ $trim }}</span>
      @endif
      <span style="background:rgba(255,255,255,.13);border:1.5px solid rgba(255,255,255,.2);padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;">{{ $awal->usia_kehamilan ?? '-' }} Minggu</span>
      @if($tl)
        <span style="background:rgba(255,255,255,.18);border:1.5px solid rgba(255,255,255,.25);padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;">
          <i class="fas {{ $tl['icon'] }}" style="margin-right:5px;opacity:.8;"></i>{{ $tl['label'] }}
        </span>
      @endif
    </div>
  </div>
  <div style="text-align:right;flex-shrink:0;">
    <div style="font-size:11px;color:rgba(255,255,255,.55);margin-bottom:3px;">Bidan Pemeriksa</div>
    <div style="font-size:13.5px;font-weight:700;">{{ $pem->bidan->nama ?? '-' }}</div>
    <div style="font-size:11px;color:rgba(255,255,255,.55);margin-top:8px;">Tanggal Periksa</div>
    <div style="font-size:13px;font-weight:600;">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

  <div class="card">
    <div class="card-header" style="display:flex;align-items:center;gap:10px;padding:14px 18px;">
      <div style="width:32px;height:32px;border-radius:9px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-user-nurse" style="color:#059669;font-size:13px;"></i>
      </div>
      <div>
        <div style="font-size:13px;font-weight:700;color:var(--slate-800);">Pemeriksaan Awal</div>
        <div style="font-size:11px;color:var(--slate-400);">oleh Kader · {{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d F Y') }}</div>
      </div>
    </div>
    <div style="padding:6px 18px 14px;">
      @foreach([
        ['Kader Pemeriksa', $awal->kader->nama ?? '-',               'fa-user'],
        ['Usia Kehamilan',  ($awal->usia_kehamilan ?? '-').' minggu','fa-calendar'],
        ['Berat Badan',     fmtAngka($awal->berat_badan ?? null).' kg',       'fa-weight'],
        ['Tekanan Darah',   ($awal->tekanan_darah ?? '-').' mmHg',   'fa-heartbeat'],
        ['Keluhan',         $awal->keluhan ?? 'Tidak ada keluhan',   'fa-comment-medical'],
      ] as [$lbl, $val, $ico])
      <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 0;border-bottom:1px solid var(--slate-100);">
        <i class="fas {{ $ico }}" style="color:var(--slate-400);font-size:13px;margin-top:2px;width:14px;text-align:center;flex-shrink:0;"></i>
        <span style="width:130px;flex-shrink:0;font-size:13px;color:var(--slate-500);">{{ $lbl }}</span>
        <span style="flex:1;font-size:14px;font-weight:600;color:var(--slate-800);">{{ $val }}</span>
      </div>
      @endforeach
    </div>
  </div>

  <div class="card">
    <div class="card-header" style="display:flex;align-items:center;gap:10px;padding:14px 18px;">
      <div style="width:32px;height:32px;border-radius:9px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-stethoscope" style="color:#6366f1;font-size:13px;"></i>
      </div>
      <div>
        <div style="font-size:13px;font-weight:700;color:var(--slate-800);">Pemeriksaan Lanjutan</div>
        <div style="font-size:11px;color:var(--slate-400);">oleh Bidan · {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}</div>
      </div>
    </div>
    <div style="padding:6px 18px 14px;">
      @foreach([
        ['LILA', fmtAngka($pem->lila ?? null).' cm', 'fa-ruler-horizontal'],
        ['TFU',  fmtAngka($pem->tfu  ?? null).' cm', 'fa-arrows-alt-v'],
        ['DJJ',  ($pem->djj  ?? '-').' bpm', 'fa-drum'],
      ] as [$lbl, $val, $ico])
      <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 0;border-bottom:1px solid var(--slate-100);">
        <i class="fas {{ $ico }}" style="color:var(--slate-400);font-size:13px;margin-top:2px;width:14px;text-align:center;flex-shrink:0;"></i>
        <span style="width:130px;flex-shrink:0;font-size:13px;color:var(--slate-500);">{{ $lbl }}</span>
        <span style="flex:1;font-size:14px;font-weight:600;color:var(--slate-800);">{{ $val }}</span>
      </div>
      @endforeach
      <div style="display:flex;align-items:center;gap:10px;padding:10px 0;">
        <i class="fas fa-directions" style="color:var(--slate-400);font-size:13px;width:14px;text-align:center;flex-shrink:0;"></i>
        <span style="width:130px;flex-shrink:0;font-size:13px;color:var(--slate-500);">Tindak Lanjut</span>
        @if($tl)
          <span style="background:{{ $tl['bg'] }};color:{{ $tl['color'] }};padding:3px 12px;border-radius:20px;font-size:12px;font-weight:700;">
            <i class="fas {{ $tl['icon'] }}" style="margin-right:4px;"></i>{{ $tl['label'] }}
          </span>
        @else
          <span style="font-size:14px;font-weight:600;color:var(--slate-400);">-</span>
        @endif
      </div>
    </div>
  </div>

</div>

@if($pem->catatan_bidan)
<div class="card" style="margin-bottom:16px;">
  <div class="card-header" style="display:flex;align-items:center;gap:10px;padding:14px 18px;">
    <div style="width:32px;height:32px;border-radius:9px;background:#fffbeb;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-notes-medical" style="color:#f59e0b;font-size:13px;"></i>
    </div>
    <div style="font-size:13px;font-weight:700;color:var(--slate-800);">Catatan Bidan</div>
  </div>
  <div style="padding:16px 18px;font-size:14px;line-height:1.75;color:var(--slate-700);">{{ $pem->catatan_bidan }}</div>
</div>
@endif

<div class="card">
  <div class="card-header" style="display:flex;align-items:center;gap:10px;padding:14px 18px;">
    <div style="width:32px;height:32px;border-radius:9px;background:#f0f9ff;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-clock-rotate-left" style="color:#0ea5e9;font-size:13px;"></i>
    </div>
    <div style="font-size:13px;font-weight:700;color:var(--slate-800);">Riwayat Pencatatan</div>
  </div>
  <div style="padding:20px;display:flex;gap:16px;flex-wrap:wrap;">

    <div style="flex:1;min-width:220px;">
      <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;">
        <i class="fas fa-pen-to-square" style="margin-right:4px;"></i> Dicatat Oleh
      </div>
      <div style="display:flex;align-items:center;gap:14px;padding:14px;background:var(--teal-50);border:1.5px solid var(--teal-200);border-radius:12px;">
        <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--teal-400),var(--teal-600));border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
          {{ strtoupper(substr($pem->bidan->nama ?? 'B', 0, 1)) }}
        </div>
        <div>
          <div style="font-weight:700;color:var(--slate-800);font-size:14px;">
            <span style="font-size:11px;font-weight:600;color:var(--teal-600);">Bidan:</span>
            {{ $pem->bidan->nama ?? '-' }}
          </div>
          <div style="font-size:12px;color:var(--slate-400);margin-top:3px;">
            <i class="fas fa-clock" style="margin-right:3px;"></i>
            {{ $pem->created_at ? $pem->created_at->translatedFormat('d F Y — H:i') : '-' }} WIB
          </div>
        </div>
      </div>
    </div>

    <div style="width:1.5px;background:var(--slate-100);border-radius:2px;align-self:stretch;"></div>

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
              <span style="font-size:11px;font-weight:600;color:#d97706;">{{ ucfirst($pem->updatedBy->role ?? 'Pengguna') }}:</span>
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
@media(max-width:900px){div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;}}
</style>
@endpush