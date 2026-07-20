@extends('layouts.app')
@section('title', 'Detail Pemeriksaan Ibu Hamil')
@section('page_title', 'Detail Pemeriksaan')

@section('content')

@php
  $ibu  = $pem->ibuHamil;
  $uk   = $pem->usia_kehamilan;
  $trim = $uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III');
  [$sistolik, $diastolik] = explode('/', $pem->tekanan_darah . '/0');
  $sistolik  = (int)trim($sistolik);
  $diastolik = (int)trim($diastolik);
  $tdNormal  = $sistolik < 140 && $diastolik < 90;
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('kader.pemeriksaan-awal-ibu-hamil.index', ['tanggal' => $pem->tanggal_periksa]) }}" class="btn btn-outline btn-sm">    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Detail Pemeriksaan</span>
</div>

<div class="pasien-header" style="margin-bottom:20px;">
  <div class="pasien-avatar-lg">
    {{ strtoupper(substr($ibu->nama_ibu ?? 'X', 0, 1)) }}
  </div>
  <div>
    <div class="pasien-name">{{ $ibu->nama_ibu ?? '-' }}</div>
    <div class="pasien-meta">
      @if($ibu && $ibu->gravida !== null)
        <span><i class="fas fa-venus"></i> G{{ $ibu->gravida }}P{{ $ibu->partus }}A{{ $ibu->abortus }}</span>
      @endif
      @if($ibu && $ibu->no_hp)
        <span><i class="fab fa-whatsapp"></i> {{ $ibu->no_hp }}</span>
      @endif
      @if($ibu && $ibu->hpht)
        <span><i class="fas fa-calendar"></i> HPHT: {{ \Carbon\Carbon::parse($ibu->hpht)->translatedFormat('d F Y') }}</span>
      @endif
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

  <div class="card">
    <div class="card-header">
      <div class="card-title">Data Pemeriksaan</div>
      <div class="card-subtitle">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('l, d F Y') }}</div>
    </div>
    <div class="pemeriksaan-grid">

      <div class="pemeriksaan-item">
        <div class="pem-label">Tanggal Periksa</div>
        <div class="pem-value" style="font-size:16px;">
          {{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d F Y') }}
        </div>
      </div>

      <div class="pemeriksaan-item">
        <div class="pem-label">Usia Kehamilan</div>
        <div class="pem-value">
          {{ $uk ?? '-' }} <span class="pem-unit">minggu</span>
        </div>
        <div class="pem-status">
          <span class="badge {{ ['I'=>'badge-orange','II'=>'badge-teal','III'=>'badge-blue'][$trim] ?? 'badge-teal' }}">
            Trimester {{ $trim }}
          </span>
        </div>
      </div>

      <div class="pemeriksaan-item">
        <div class="pem-label">Berat Badan</div>
        <div class="pem-value">
          {{ fmtAngka($pem->berat_badan) }} <span class="pem-unit">kg</span>
        </div>
      </div>

      <div class="pemeriksaan-item">
        <div class="pem-label">Tekanan Darah</div>
        <div class="pem-value" style="font-size:20px;">
          {{ $pem->tekanan_darah }} <span class="pem-unit">mmHg</span>
        </div>
        <div class="pem-status">
          <span class="badge {{ $tdNormal ? 'badge-green' : 'badge-red' }}">
            {{ $tdNormal ? 'Normal' : 'Tinggi' }}
          </span>
        </div>
      </div>

    </div>
    <div style="padding:0 20px 20px;">
  <div class="pem-label" style="margin-bottom:8px;">Keluhan</div>
  @if($pem->keluhan)
    <div style="background:var(--slate-50);border:1.5px solid var(--slate-200);border-radius:10px;padding:14px;font-size:13.5px;color:var(--slate-700);line-height:1.6;">{{ $pem->keluhan }}</div>
  @else
    <div style="color:var(--slate-300);font-style:italic;font-size:13px;">Tidak ada keluhan</div>
  @endif
</div>

  </div>

  @php
  $sudahDiubah = $pem->updated_at->ne($pem->created_at) && $pem->updatedBy;
@endphp
<div class="card">
  <div class="card-header">
    <div class="card-title">Riwayat Pencatatan</div>
  </div>
  <div style="padding:20px;display:flex;flex-direction:column;gap:12px;">

    <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">
      <i class="fas fa-pen-to-square" style="margin-right:4px;"></i> Dicatat Oleh
    </div>
    <div style="display:flex;align-items:center;gap:14px;padding:14px;background:var(--teal-50);border:1.5px solid var(--teal-200);border-radius:12px;">
      <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--teal-400),var(--teal-600));border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
        {{ strtoupper(substr($pem->kader->nama ?? 'K', 0, 1)) }}
      </div>
      <div>
        <div style="font-weight:700;color:var(--slate-800);font-size:14px;">
          <span style="font-size:11px;font-weight:600;color:var(--teal-600);">Kader:</span>
          {{ $pem->kader->nama ?? '-' }}
        </div>
        <div style="font-size:12px;color:var(--slate-400);margin-top:3px;">
          <i class="fas fa-clock" style="margin-right:3px;"></i>
          {{ $pem->created_at->translatedFormat('d F Y — H:i') }} WIB
        </div>
      </div>
    </div>

    <div style="border-top:1.5px dashed var(--slate-200);"></div>

    <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">
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
            {{ $pem->updated_at->translatedFormat('d F Y — H:i') }} WIB
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
