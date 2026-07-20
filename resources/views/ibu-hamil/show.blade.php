@extends('layouts.app')
@section('title', 'Detail Ibu Hamil — ' . $ibuHamil->nama_ibu)
@section('page_title', 'Detail Ibu Hamil')

@section('content')

@php
  $hpht          = \Carbon\Carbon::parse($ibuHamil->hpht);
  $taksiran      = $hpht->copy()->addDays(280);
  $usiaKehamilan = (int) $hpht->diffInWeeks(now());
  $trimester     = $usiaKehamilan <= 12 ? 'I' : ($usiaKehamilan <= 27 ? 'II' : 'III');
  $usia          = \Carbon\Carbon::parse($ibuHamil->tanggal_lahir)->age;

  $pemeriksaanTerakhir = $ibuHamil->pemeriksaanLanjutan->sortByDesc('tanggal_periksa')->first()
                      ?? $ibuHamil->pemeriksaanAwal->sortByDesc('tanggal_periksa')->first();

  $tindakLanjutTerakhir = $ibuHamil->pemeriksaanLanjutan->sortByDesc('tanggal_periksa')->first()->tindak_lanjut ?? null;

  $risikoStatus = 'normal';
  $statusLabel  = 'Kondisi Normal';
  $statusIcon   = 'fa-circle-check';

  if ($tindakLanjutTerakhir === 'rujukan_rs' || $tindakLanjutTerakhir === 'rawat_inap') {
    $risikoStatus = 'tinggi';
    $statusLabel  = 'Risiko Tinggi';
    $statusIcon   = 'fa-triangle-exclamation';
  } elseif ($tindakLanjutTerakhir === 'rujukan_puskesmas') {
    $risikoStatus = 'perhatian';
    $statusLabel  = 'Perlu Perhatian';
    $statusIcon   = 'fa-circle-exclamation';
  } elseif ($tindakLanjutTerakhir === 'kontrol') {
    $risikoStatus = 'stabil';
    $statusLabel  = 'Kontrol Rutin';
    $statusIcon   = 'fa-rotate';
  } elseif ($ibuHamil->pemeriksaanLanjutan->count() === 0 && $ibuHamil->pemeriksaanAwal->count() === 0) {
    $risikoStatus = 'normal';
    $statusLabel  = 'Belum Ada Pemeriksaan';
    $statusIcon   = 'fa-clock';
  }

  $bannerGradient = match($risikoStatus) {
    'tinggi'    => 'linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%)',
    'perhatian' => 'linear-gradient(135deg, #d97706 0%, #b45309 50%, #92400e 100%)',
    'stabil'    => 'linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%)',
    default     => 'linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14a398 100%)',
  };

  $bannerAccent = match($risikoStatus) {
    'tinggi'    => 'rgba(252,165,165,0.15)',
    'perhatian' => 'rgba(253,230,138,0.15)',
    'stabil'    => 'rgba(147,197,253,0.15)',
    default     => 'rgba(153,246,228,0.15)',
  };

  $statusBadgeBg = match($risikoStatus) {
    'tinggi'    => 'rgba(254,226,226,0.25)',
    'perhatian' => 'rgba(254,243,199,0.25)',
    'stabil'    => 'rgba(219,234,254,0.25)',
    default     => 'rgba(204,251,241,0.25)',
  };

  $sudahDiubah = $ibuHamil->updated_at->ne($ibuHamil->created_at) && isset($ibuHamil->updatedBy);
  $listAwal      = $ibuHamil->pemeriksaanAwal->sortBy('tanggal_periksa')->values();
  $listLanjutan  = $ibuHamil->pemeriksaanLanjutan->sortBy('tanggal_periksa')->values();
  $totalAwal     = $listAwal->count();
  $totalLanjutan = $listLanjutan->count();
@endphp

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('ibu-hamil.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ {{ $ibuHamil->nama_ibu }}</span>
</div>


<div class="pasien-header" style="background:{{ $bannerGradient }};margin-bottom:20px;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:{{ $bannerAccent }};pointer-events:none;"></div>
  <div style="position:absolute;bottom:-60px;right:80px;width:240px;height:240px;border-radius:50%;background:{{ $bannerAccent }};pointer-events:none;"></div>

  <div class="pasien-avatar-lg" style="background:rgba(255,255,255,0.2);border:2.5px solid rgba(255,255,255,0.35);font-size:28px;font-weight:800;color:#fff;flex-shrink:0;position:relative;z-index:1;">
    {{ strtoupper(substr($ibuHamil->nama_ibu, 0, 1)) }}
  </div>

  <div style="flex:1;min-width:0;position:relative;z-index:1;">
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
      <div style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-.3px;">{{ $ibuHamil->nama_ibu }}</div>
      <span style="background:{{ $statusBadgeBg }};border:1.5px solid rgba(255,255,255,0.3);color:#fff;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:.3px;backdrop-filter:blur(4px);">
        <i class="fas {{ $statusIcon }}" style="margin-right:4px;"></i>{{ $statusLabel }}
      </span>
    </div>
    <div class="pasien-meta" style="color:rgba(255,255,255,0.75);">
      <span><i class="fas fa-id-card" style="margin-right:4px;"></i>NIK: {{ $ibuHamil->nik }}</span>
      <span><i class="fas fa-person-pregnant" style="margin-right:4px;"></i>G{{ $ibuHamil->gravida }}P{{ $ibuHamil->partus }}A{{ $ibuHamil->abortus }}</span>
      <span><i class="fas fa-baby" style="margin-right:4px;"></i>Trimester {{ $trimester }} · {{ $usiaKehamilan }} minggu</span>
      @if($ibuHamil->no_hp)
        <span><i class="fab fa-whatsapp" style="margin-right:4px;"></i>{{ $ibuHamil->no_hp }}</span>
      @endif
    </div>
  </div>

  <div style="display:flex;gap:10px;flex-wrap:wrap;position:relative;z-index:1;">
    @foreach([
      ['label'=>'Usia Ibu',       'val'=>$usia.' tahun',                      'icon'=>'fa-user'],
      ['label'=>'Usia Kehamilan', 'val'=>$usiaKehamilan.' minggu',             'icon'=>'fa-calendar-week'],
      ['label'=>'Taksiran Lahir', 'val'=>$taksiran->translatedFormat('d M Y'), 'icon'=>'fa-baby'],
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

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="fas fa-id-card" style="color:#14a398;margin-right:8px;"></i>Data Pribadi</div>
    </div>
    <div style="padding:16px;">
      @foreach([
        ['Nama Lengkap',  $ibuHamil->nama_ibu],
        ['NIK',           $ibuHamil->nik],
        ['Tanggal Lahir', \Carbon\Carbon::parse($ibuHamil->tanggal_lahir)->translatedFormat('d F Y').' ('.$usia.' tahun)'],
        ['No. HP',        $ibuHamil->no_hp ?? '-'],
        ['Alamat',        $ibuHamil->alamat ?? '-'],
        ['Terdaftar',     $ibuHamil->created_at->translatedFormat('d F Y')],
      ] as [$label, $val])
      <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f1f5f9;">
        <span style="font-size:12px;color:#94a3b8;width:130px;flex-shrink:0;">{{ $label }}</span>
        <span style="font-size:13px;font-weight:600;color:#334155;flex:1;">{{ $val }}</span>
      </div>
      @endforeach
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="fas fa-heart-pulse" style="color:#f43f5e;margin-right:8px;"></i>Data Obstetri</div>
    </div>
    <div style="padding:16px;">
      @foreach([
        ['Status Obstetri', 'G'.$ibuHamil->gravida.' P'.$ibuHamil->partus.' A'.$ibuHamil->abortus],
        ['Gravida (G)',     $ibuHamil->gravida.'× kehamilan'],
        ['Partus (P)',      $ibuHamil->partus.'× persalinan'],
        ['Abortus (A)',     $ibuHamil->abortus.'× abortus'],
        ['HPHT',            $hpht->translatedFormat('d F Y')],
        ['Taksiran Lahir',  $taksiran->translatedFormat('d F Y')],
      ] as [$label, $val])
      <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f1f5f9;">
        <span style="font-size:12px;color:#94a3b8;width:130px;flex-shrink:0;">{{ $label }}</span>
        <span style="font-size:13px;font-weight:600;color:#334155;flex:1;">{{ $val }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>

<div class="card" style="margin-bottom:16px;">
  <div class="card-header">
    <div class="card-title"><i class="fas fa-clock-rotate-left" style="color:#6366f1;margin-right:8px;"></i>Riwayat Pencatatan</div>
  </div>
  <div style="padding:20px;display:flex;flex-direction:column;gap:12px;">

    <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">
      <i class="fas fa-pen-to-square" style="margin-right:4px;"></i> Dicatat Oleh
    </div>
    @if(isset($ibuHamil->createdBy) && $ibuHamil->createdBy)
    <div style="display:flex;align-items:center;gap:14px;padding:14px;background:#f0fdfa;border:1.5px solid #99f6e4;border-radius:12px;">
      <div style="width:44px;height:44px;background:linear-gradient(135deg,#0d9488,#0f766e);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
        {{ strtoupper(substr($ibuHamil->createdBy->nama ?? $ibuHamil->createdBy->name ?? 'A', 0, 1)) }}
      </div>
      <div>
        <div style="font-weight:700;color:#134e4a;font-size:14px;">
          <span style="font-size:11px;font-weight:600;color:#0d9488;">{{ $ibuHamil->createdBy->role === 'ketua' ? 'Ketua Posyandu' : ucfirst($ibuHamil->createdBy->role ?? 'Pengguna') }}:</span>
          {{ $ibuHamil->createdBy->nama ?? $ibuHamil->createdBy->name ?? '-' }}
        </div>
        <div style="font-size:12px;color:#334155;margin-top:3px;">
          <i class="fas fa-clock" style="margin-right:3px;"></i>
          {{ $ibuHamil->created_at->translatedFormat('d F Y — H:i') }} WIB
        </div>
      </div>
    </div>
    @else
    <div style="display:flex;align-items:center;gap:12px;padding:14px;background:#f0fdfa;border:1.5px solid #99f6e4;border-radius:12px;">
      <div style="width:44px;height:44px;background:linear-gradient(135deg,#0d9488,#0f766e);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fas fa-user" style="color:#fff;font-size:16px;"></i>
      </div>
      <div>
        <div style="font-weight:700;color:#0f172a;font-size:14px;">
          <span style="font-size:11px;font-weight:600;color:#0f766e;">{{ $ibuHamil->createdBy->role === 'ketua' ? 'Ketua Posyandu' : ucfirst($ibuHamil->createdBy->role ?? 'Pengguna') }}:</span>
          {{ $ibuHamil->createdBy->nama ?? $ibuHamil->createdBy->name ?? 'Ketua Posyandu' }}
        </div>
        <div style="font-size:12px;color:#334155;margin-top:3px;">
          <i class="fas fa-clock" style="margin-right:3px;"></i>
          {{ $ibuHamil->created_at->translatedFormat('d F Y — H:i') }} WIB
        </div>
      </div>
    </div>
    @endif

    <div style="border-top:1.5px dashed #e2e8f0;"></div>

    <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">
      <i class="fas fa-clock-rotate-left" style="margin-right:4px;"></i> Terakhir Diubah
    </div>

    @if($sudahDiubah)
    <div style="display:flex;align-items:center;gap:14px;padding:14px;background:#fffbeb;border:1.5px solid #fcd34d;border-radius:12px;">
      <div style="width:44px;height:44px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
        {{ strtoupper(substr($ibuHamil->updatedBy->nama ?? $ibuHamil->updatedBy->name ?? 'U', 0, 1)) }}
      </div>
      <div>
        <div style="font-weight:700;color:#78350f;font-size:14px;">
          <span style="font-size:11px;font-weight:600;color:#d97706;">{{ ucfirst($ibuHamil->updatedBy->role ?? 'Pengguna') }}:</span>
          {{ $ibuHamil->updatedBy->nama ?? $ibuHamil->updatedBy->name ?? '-' }}
        </div>
        <div style="font-size:12px;color:#92400e;margin-top:3px;">
          <i class="fas fa-clock" style="margin-right:3px;"></i>
          {{ $ibuHamil->updated_at->translatedFormat('d F Y — H:i') }} WIB
        </div>
      </div>
    </div>
    @else
    <div style="display:flex;align-items:center;gap:12px;padding:14px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;">
      <div style="width:44px;height:44px;background:linear-gradient(135deg,#94a3b8,#64748b);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fas fa-check" style="color:#fff;font-size:16px;"></i>
      </div>
      <div>
        <div style="font-size:13px;font-weight:600;color:#64748b;">Belum pernah diubah</div>
        <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Data masih original sejak dicatat</div>
      </div>
    </div>
    @endif

  </div>
</div>

<div class="card" style="margin-bottom:16px;">
  <div class="card-header">
    <div>
      <div class="card-title"><i class="fas fa-clipboard-list" style="color:#14a398;margin-right:8px;"></i>Riwayat Pemeriksaan Awal (Kader)</div>
      <div class="card-subtitle">{{ $ibuHamil->pemeriksaanAwal->count() }} data</div>
    </div>
  </div>
  @if($ibuHamil->pemeriksaanAwal->count())
  <div class="table-scroll">
  <table class="dtable">
    <thead>
      <tr>
        <th>No</th><th>Tanggal</th><th>Usia Kehamilan</th>
        <th>BB</th><th>Tekanan Darah</th>
        <th>Kader</th><th style="text-align:left;">Keluhan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($listAwal as $i => $p)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->translatedFormat('d M Y') }}</td>
        <td>{{ $p->usia_kehamilan ?? '-' }} minggu</td>
        <td>{{ $p->berat_badan ? $p->berat_badan.' kg' : '-' }}</td>
        <td>{{ $p->tekanan_darah ?? '-' }}</td>
        <td>{{ $p->kader->nama ?? '-' }}</td>
        <td style="text-align:left;">{{ $p->keluhan ?? '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  @else
  <div class="empty-mini"><i class="fas fa-inbox"></i> Belum ada data pemeriksaan awal</div>
  @endif
</div>

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title"><i class="fas fa-stethoscope" style="color:#6366f1;margin-right:8px;"></i>Riwayat Pemeriksaan Lanjutan (Bidan)</div>
      <div class="card-subtitle">{{ $ibuHamil->pemeriksaanLanjutan->count() }} data</div>
    </div>
  </div>
  @if($ibuHamil->pemeriksaanLanjutan->count())
  <div class="table-scroll">
  <table class="dtable">
    <thead>
      <tr>
        <th>No</th><th>Tanggal</th>
        <th>LILA</th><th>TFU</th><th>DJJ</th>
        <th>Tindak Lanjut</th><th>Bidan</th>
        <th style="text-align:left;">Catatan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($listLanjutan as $i => $p)
      @php
        $tlLabel = match($p->tindak_lanjut) {
          'kontrol'           => 'Kontrol Rutin',
          'rujukan_puskesmas' => 'Rujuk Puskesmas',
          'rujukan_rs'        => 'Rujuk RS',
          'rawat_inap'        => 'Rawat Inap',
          default             => '-',
        };
        $tlColor = match($p->tindak_lanjut) {
          'kontrol'           => '#2563eb',
          'rujukan_puskesmas' => '#d97706',
          'rujukan_rs'        => '#dc2626',
          'rawat_inap'        => '#9333ea',
          default             => '#94a3b8',
        };
        $tlBg = match($p->tindak_lanjut) {
          'kontrol'           => '#eff6ff',
          'rujukan_puskesmas' => '#fffbeb',
          'rujukan_rs'        => '#fef2f2',
          'rawat_inap'        => '#faf5ff',
          default             => '#f8fafc',
        };
      @endphp
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->translatedFormat('d M Y') }}</td>
        <td>{{ $p->lila ? $p->lila.' cm' : '-' }}</td>
        <td>{{ $p->tfu ? $p->tfu.' cm' : '-' }}</td>
        <td>{{ $p->djj ? $p->djj.' x/mnt' : '-' }}</td>
        <td>
          <span style="background:{{ $tlBg }};color:{{ $tlColor }};padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;">
            {{ $tlLabel }}
          </span>
        </td>
        <td>{{ $p->bidan->nama ?? '-' }}</td>
        <td style="text-align:left;max-width:200px;">{{ $p->catatan_bidan ?? '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  @else
  <div class="empty-mini"><i class="fas fa-inbox"></i> Belum ada data pemeriksaan lanjutan</div>
  @endif
</div>


@endsection

@push('styles')
<style>
.card{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden;margin-bottom:0;}
.card-header{display:flex;align-items:center;justify-content:space-between;padding:14px 18px 12px;border-bottom:1px solid #f1f5f9;}
.card-title{font-size:14px;font-weight:700;color:#1e293b;}
.card-subtitle{font-size:11px;color:#94a3b8;margin-top:2px;}
.pasien-header{
  display:flex;align-items:center;gap:20px;flex-wrap:wrap;
  padding:24px 28px;border-radius:16px;
}
.pasien-avatar-lg{
  width:68px;height:68px;border-radius:18px;
  display:flex;align-items:center;justify-content:center;
  font-size:26px;font-weight:800;
}
.pasien-meta{display:flex;gap:14px;flex-wrap:wrap;margin-top:8px;font-size:12px;}
.pasien-meta span{display:flex;align-items:center;gap:4px;}
.btn{display:inline-flex;align-items:center;gap:6px;border-radius:8px;font-size:13px;font-weight:600;padding:7px 14px;cursor:pointer;text-decoration:none;transition:all .15s;border:none;}
.btn-outline{border:1.5px solid #e2e8f0;color:#475569;background:#fff;}
.btn-outline:hover{background:#f8fafc;}
.btn-sm{font-size:12px;padding:5px 12px;}
.table-scroll{overflow-x:auto;}
.dtable{width:100%;border-collapse:collapse;font-size:13px;}
.dtable thead th{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#94a3b8;padding:10px 14px;background:#f8fafc;border-bottom:1px solid #f1f5f9;text-align:center;white-space:nowrap;}
.dtable tbody td{padding:11px 14px;border-bottom:1px solid #f8fafc;vertical-align:middle;text-align:center;color:#334155;}
.dtable tbody tr:last-child td{border-bottom:none;}
.dtable tbody tr:hover td{background:#fafbff;}
.empty-mini{text-align:center;padding:28px;color:#94a3b8;font-size:13px;}
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
@media(max-width:600px){
  /* Keep layout optimized from 768px */
}
</style>

@endpush
