@extends('layouts.app')
@section('title', 'Detail '.$balita->nama_balita)
@section('page_title', 'Detail Balita')

@section('content')
<div>
  <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    <a href="{{ route('ketua.laporan.balita') }}" class="btn btn-outline btn-sm">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <span style="color:var(--slate-300);">/</span>
    <span style="font-size:13.5px;font-weight:600;color:var(--slate-600);">
      Riwayat — {{ $balita->nama_balita }}
    </span>
    <div style="margin-left:auto;">
      <button onclick="cetakPDF()" class="btn btn-primary btn-sm">
        <i class="fas fa-print"></i> Cetak PDF
      </button>
    </div>
  </div>

  <div class="card" style="margin-bottom:20px;">
    <div style="padding:20px 24px 0;">
      @php $isCowok = $balita->jenis_kelamin === 'L'; @endphp
      <div style="display:flex;align-items:center;gap:14px;">
        <div>
          <div style="font-size:18px;font-weight:700;color:var(--slate-700);">{{ $balita->nama_balita }}</div>
          @php $usiaBln = \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now()); @endphp
          <div style="display:flex;gap:8px;align-items:center;margin-top:4px;flex-wrap:wrap;">
            <span style="font-size:12px;color:var(--slate-400);">NIK: {{ $balita->nik ?? '-' }}</span>
            <span style="width:4px;height:4px;border-radius:50%;background:var(--slate-300);display:inline-block;"></span>
            <span class="badge {{ $isCowok ? 'badge-teal' : 'badge-purple' }}">{{ $isCowok ? 'Laki-laki' : 'Perempuan' }}</span>
            <span style="width:4px;height:4px;border-radius:50%;background:var(--slate-300);display:inline-block;"></span>
            <span style="font-size:12px;color:var(--slate-400);">
              {{ $usiaBln >= 12 ? floor($usiaBln/12).' th '.($usiaBln%12).' bln' : $usiaBln.' bln' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div style="border-top:1px solid var(--slate-100);margin:16px 24px 0;"></div>

    @php
      $infoFields = [
        ['Tanggal Lahir',   \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d F Y')],
        ['Nama Ibu',        $balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-'],
        ['No. HP Ortu',     $balita->ibuHamil->no_hp ?? '-'],
        ['Terdaftar',       \Carbon\Carbon::parse($balita->created_at)->translatedFormat('d F Y'), false, 1, 'fa-calendar-plus'],
        ['Alamat Ibu',      $balita->ibuHamil->alamat ?? '-', false, 2],
        ['Terakhir Update', \Carbon\Carbon::parse($balita->updated_at)->translatedFormat('d F Y'), false, 2, 'fa-calendar-check'],
      ];
    @endphp
    <div style="padding:16px 24px 20px;display:grid;grid-template-columns:repeat(4,1fr);gap:16px 20px;">
      @foreach($infoFields as $f)
      <div style="{{ isset($f[3]) && $f[3] > 1 ? 'grid-column:span '.$f[3].';' : '' }}">
        <div style="font-size:11px;color:var(--slate-400);margin-bottom:3px;">
          @if(isset($f[4]))<i class="fas {{ $f[4] }}" style="margin-right:3px;"></i>@endif{{ $f[0] }}
        </div>
        <div style="font-size:13px;color:var(--slate-700);font-weight:{{ isset($f[2]) && $f[2] ? '700' : '500' }};">
          {{ $f[1] }}
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="card">
    <div style="padding:18px 24px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--slate-100);">
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--slate-700);display:flex;align-items:center;gap:8px;">
          <i class="fas fa-history" style="color:var(--teal-600);"></i> Riwayat Pemeriksaan
        </div>
        <div style="font-size:12px;color:var(--slate-400);margin-top:2px;">Semua pemeriksaan awal & lanjutan</div>
      </div>
      <span style="background:var(--teal-100);color:var(--teal-700);font-size:12px;font-weight:700;padding:4px 12px;border-radius:20px;">
        {{ $riwayat->count() }} pemeriksaan
      </span>
    </div>

    @forelse($riwayat as $i => $pem)
    @php
      $lanjutan  = $pem->pemeriksaanLanjutan;
      $no        = $riwayat->count() - $i;
      $tlMap     = [
        'kontrol'           => ['Kontrol Rutin',   'badge-teal'],
        'rujukan_puskesmas' => ['Rujuk Puskesmas', 'badge-orange'],
        'rujukan_rs'        => ['Rujuk RS',         'badge-red'],
        'rawat_inap'        => ['Rawat Inap',       'badge-purple'],
      ];
      [$tlLabel, $tlBadge] = $tlMap[$lanjutan->tindak_lanjut ?? ''] ?? [($lanjutan->tindak_lanjut ?? '-'), 'badge-teal'];
      $sg      = strtolower($lanjutan->status_gizi ?? '');
      $sgBadge =
          str_contains($sg, 'baik') ? 'badge-green' :
          (str_contains($sg, 'normal') ? 'badge-green' :
          (str_contains($sg, 'kurang') ? 'badge-orange' :
          (str_contains($sg, 'buruk') ? 'badge-red' :
          (str_contains($sg, 'stunting') ? 'badge-red' :
          (str_contains($sg, 'lebih') ? 'badge-blue' :
          'badge-teal')))));
    @endphp

    <div style="padding:20px 24px;{{ !$loop->last ? 'border-bottom:1px solid var(--slate-100);' : '' }}">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
        <div style="flex:1;">
          <div style="font-weight:700;font-size:14px;color:var(--slate-700);">Pemeriksaan ke-{{ $no }}</div>
          <div style="font-size:12px;color:var(--slate-400);display:flex;gap:10px;flex-wrap:wrap;margin-top:1px;">
            <span><i class="fas fa-clock" style="margin-right:3px;"></i>Dicatat {{ \Carbon\Carbon::parse($pem->created_at)->translatedFormat('d F Y') }}</span>
          </div>
        </div>
        @if($lanjutan)
          <span class="badge {{ $tlBadge }}">{{ $tlLabel }}</span>
        @else
          <span class="badge badge-orange">Menunggu Bidan</span>
        @endif
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div style="background:#f0fdfa;border:1px solid #99f6e4;border-radius:10px;padding:14px 18px;">
          <div style="font-size:10px;font-weight:700;color:var(--slate-500);text-transform:uppercase;letter-spacing:.8px;display:flex;align-items:center;gap:6px;margin-bottom:12px;">
            <i class="fas fa-user-nurse" style="color:var(--teal-600);"></i> Kader
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            @foreach([
              ['Kader Pemeriksa', $pem->kader->nama ?? '-'],
              ['Usia Balita',     ($pem->usia_balita ?? '-').' bulan'],
              ['Berat Badan',     $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-'],
              ['Tinggi Badan',    $pem->tinggi_badan !== null ? fmtAngka($pem->tinggi_badan).' cm' : '-'],
              ['Lingkar Kepala',  $pem->lingkar_kepala !== null ? fmtAngka($pem->lingkar_kepala).' cm' : '-'],
              ['Lingkar Lengan',  $pem->lingkar_lengan !== null ? fmtAngka($pem->lingkar_lengan).' cm' : '-'],
            ] as [$k, $v])
            <div>
              <div style="font-size:10px;color:var(--slate-400);margin-bottom:2px;">{{ $k }}</div>
              <div style="font-size:13px;font-weight:600;color:var(--slate-700);">{{ $v }}</div>
            </div>
            @endforeach
            @if($pem->keluhan)
            <div style="grid-column:span 2;">
              <div style="font-size:10px;color:var(--slate-400);margin-bottom:2px;">Keluhan</div>
              <div style="font-size:13px;font-weight:600;color:var(--slate-700);">{{ $pem->keluhan }}</div>
            </div>
            @endif
          </div>
        </div>

        @if($lanjutan)
        <div style="background:#f0fdfa;border:1px solid #99f6e4;border-radius:10px;padding:14px 18px;">
          <div style="font-size:10px;font-weight:700;color:var(--slate-500);text-transform:uppercase;letter-spacing:.8px;display:flex;align-items:center;gap:6px;margin-bottom:12px;">
            <i class="fas fa-stethoscope" style="color:var(--teal-600);"></i> Bidan
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            @foreach([
              ['Bidan Pemeriksa', $lanjutan->bidan->nama ?? '-'],
              ['Tanggal Periksa', \Carbon\Carbon::parse($lanjutan->tanggal_periksa)->translatedFormat('d F Y')],
              ['Imunisasi',       $lanjutan->imunisasi ?? '-'],
              ['Vitamin A',       $lanjutan->vitamin_a ?? '-'],
            ] as [$k, $v])
            <div>
              <div style="font-size:10px;color:var(--slate-400);margin-bottom:2px;">{{ $k }}</div>
              <div style="font-size:13px;font-weight:600;color:var(--slate-700);">{{ $v }}</div>
            </div>
            @endforeach
            <div style="grid-column:span 2;">
              <div style="font-size:10px;color:var(--slate-400);margin-bottom:2px;">Status Gizi</div>
              <span class="badge {{ $sgBadge }}">{{ $lanjutan->status_gizi ?? '-' }}</span>
            </div>
            @if($lanjutan->catatan_bidan)
            <div style="grid-column:span 2;">
              <div style="font-size:10px;color:var(--slate-400);margin-bottom:2px;">Catatan Bidan</div>
              <div style="font-size:13px;font-weight:600;color:var(--slate-700);">{{ $lanjutan->catatan_bidan }}</div>
            </div>
            @endif
          </div>
        </div>
        @else
        <div style="background:var(--slate-50);border-radius:10px;padding:14px 18px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;min-height:140px;">
          <i class="fas fa-clock" style="font-size:28px;color:var(--slate-300);"></i>
          <span style="font-size:13px;color:var(--slate-400);font-weight:500;">Belum diperiksa bidan</span>
        </div>
        @endif
      </div>
    </div>

    @empty
    <div style="text-align:center;padding:48px;color:var(--slate-400);">
      <i class="fas fa-baby" style="font-size:36px;opacity:.4;display:block;margin-bottom:10px;"></i>
      <div style="font-weight:600;color:var(--slate-500);">Belum ada riwayat pemeriksaan</div>
    </div>
    @endforelse
  </div>
</div>

@push('scripts')
<script>
function cetakPDF() {
  const namaBalita   = @json($balita->nama_balita);
  const nikBalita    = @json($balita->nik ?? '-');
  const namaIbu      = @json($balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-');
  const noHp         = @json($balita->ibuHamil->no_hp ?? '-');
  const jenisKelamin = @json($balita->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
  const alamat       = @json($balita->ibuHamil->alamat ?? '-');
  const tglLahir     = @json(\Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d F Y'));

  @php
    $usiaBlnNow = \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now());
    $thNow = floor($usiaBlnNow / 12);
    $blNow = $usiaBlnNow % 12;
    $usiaStr = $thNow > 0 ? $thNow.' tahun '.$blNow.' bulan' : $usiaBlnNow.' bulan';
  @endphp
  const usiaSekarang = @json($usiaStr);
  const dicetak      = @json(now()->translatedFormat('d F Y, H:i'));

  let barisRiwayat = '';
  @forelse($riwayat as $i => $pem)
  @php
    $lanjutan  = $pem->pemeriksaanLanjutan;
    $noPem     = $riwayat->count() - $i;
    $tlMapP    = ['kontrol'=>'Kontrol Rutin','rujukan_puskesmas'=>'Rujuk Puskesmas','rujukan_rs'=>'Rujuk RS','rawat_inap'=>'Rawat Inap'];
    $tlLabelP  = $tlMapP[$lanjutan->tindak_lanjut ?? ''] ?? ($lanjutan->tindak_lanjut ?? '-');
    $vitA      = ($lanjutan && $lanjutan->vitamin_a && $lanjutan->vitamin_a !== 'tidak_diberikan')
                  ? ucwords(str_replace('_', ' ', $lanjutan->vitamin_a))
                  : null;
  @endphp
  barisRiwayat += `
    <tr>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:top;">{{ $noPem }}</td>
      <td style="padding:6px 5px;border:1px solid #cbd5e1;vertical-align:top;">
        <div style="font-weight:600;">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->translatedFormat('d M Y') }}</div>
        <div style="font-size:9px;color:#64748b;">Kader: {{ $pem->kader->nama ?? '-' }}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:top;">{{ $pem->usia_balita ?? '-' }} bln</td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:top;">
        <div>{{ $pem->berat_badan !== null ? fmtAngka($pem->berat_badan).' kg' : '-' }}</div>
        <div style="font-size:9px;color:#64748b;">{{ $pem->tinggi_badan !== null ? fmtAngka($pem->tinggi_badan).' cm' : '-' }}</div>
      </td>
      <td style="padding:6px 5px;text-align:center;border:1px solid #cbd5e1;vertical-align:top;">
        <div>LK: {{ $pem->lingkar_kepala !== null ? fmtAngka($pem->lingkar_kepala).' cm' : '-' }}</div>
        <div style="font-size:9px;color:#64748b;">LILA: {{ $pem->lingkar_lengan !== null ? fmtAngka($pem->lingkar_lengan).' cm' : '-' }}</div>
      </td>
      <td style="padding:6px 5px;border:1px solid #cbd5e1;vertical-align:top;">
        @if($lanjutan)
          <div style="margin-bottom:3px;"><strong>Gizi:</strong> {{ $lanjutan->status_gizi ?? '-' }}</div>
          @if($lanjutan->imunisasi)<div style="font-size:9px;color:#1e40af;">Imunisasi: {{ $lanjutan->imunisasi }}</div>@endif
          @if($vitA)<div style="font-size:9px;color:#b45309;">Vit A: {{ $vitA }}</div>@endif
        @else
          <span style="color:#94a3b8;font-style:italic;font-size:9px;">Belum diperiksa bidan</span>
        @endif
      </td>
      <td style="padding:6px 5px;border:1px solid #cbd5e1;vertical-align:top;">
        @if($lanjutan)
          <div style="margin-bottom:3px;"><strong>Tindak Lanjut:</strong> {{ $tlLabelP }}</div>
          @if($lanjutan->catatan_bidan)<div style="color:#475569;font-style:italic;font-size:9px;">"{{ $lanjutan->catatan_bidan }}"</div>@endif
        @else
          <span style="color:#94a3b8;font-style:italic;">-</span>
        @endif
        @if($pem->keluhan)<div style="margin-top:3px;font-size:9px;color:#b91c1c;">Keluhan: {{ $pem->keluhan }}</div>@endif
      </td>
    </tr>
  `;
  @empty
  barisRiwayat = `
    <tr>
      <td colspan="7" style="padding:12px;text-align:center;color:#64748b;border:1px solid #cbd5e1;font-style:italic;">
        Belum ada riwayat pemeriksaan.
      </td>
    </tr>
  `;
  @endforelse

  const html = `
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8">
      <title>Cetak — ${namaBalita}</title>
      <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background:#fff; color:#000; padding: 0; }
        @page { size: A4 portrait; margin: 12mm 15mm; }
        table { width:100%; border-collapse:collapse; }
        th, td { font-size:10px; }
      </style>
    </head>
    <body>

      {{-- Header --}}
      <div style="text-align:center;margin-bottom:16px;border-bottom:2px solid #1e293b;padding-bottom:12px;">
        <div style="font-size:20px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:1px;">POSYANDU MELATI 2</div>
        <div style="font-size:13px;font-weight:600;color:#475569;margin-top:4px;">LEMBAR HASIL PEMERIKSAAN KESEHATAN BALITA</div>
        <div style="font-size:10px;color:#64748b;margin-top:4px;">Dicetak: ${dicetak} WIB</div>
      </div>

      {{-- Identitas --}}
      <div style="font-size:11px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">I. Identitas Balita</div>
      <table style="margin-bottom:18px;font-size:11px;">
        <tr>
          <td style="width:18%;padding:3px 0;color:#475569;">Nama Balita</td>
          <td style="width:1%;padding:3px 0;color:#475569;">:</td>
          <td style="width:31%;padding:3px 0;font-weight:600;color:#1e293b;">${namaBalita}</td>
          <td style="width:18%;padding:3px 0;color:#475569;">Nama Ibu</td>
          <td style="width:1%;padding:3px 0;color:#475569;">:</td>
          <td style="width:31%;padding:3px 0;font-weight:600;color:#1e293b;">${namaIbu}</td>
        </tr>
        <tr>
          <td style="padding:3px 0;color:#475569;">NIK Balita</td>
          <td style="padding:3px 0;color:#475569;">:</td>
          <td style="padding:3px 0;color:#1e293b;">${nikBalita}</td>
          <td style="padding:3px 0;color:#475569;">No. HP Ortu</td>
          <td style="padding:3px 0;color:#475569;">:</td>
          <td style="padding:3px 0;color:#1e293b;">${noHp}</td>
        </tr>
        <tr>
          <td style="padding:3px 0;color:#475569;">Jenis Kelamin</td>
          <td style="padding:3px 0;color:#475569;">:</td>
          <td style="padding:3px 0;color:#1e293b;">${jenisKelamin}</td>
          <td style="padding:3px 0;color:#475569;">Alamat</td>
          <td style="padding:3px 0;color:#475569;">:</td>
          <td style="padding:3px 0;color:#1e293b;">${alamat}</td>
        </tr>
        <tr>
          <td style="padding:3px 0;color:#475569;">Tanggal Lahir</td>
          <td style="padding:3px 0;color:#475569;">:</td>
          <td style="padding:3px 0;color:#1e293b;">${tglLahir}</td>
          <td style="padding:3px 0;color:#475569;">Usia Sekarang</td>
          <td style="padding:3px 0;color:#475569;">:</td>
          <td style="padding:3px 0;font-weight:600;color:#1e293b;">${usiaSekarang}</td>
        </tr>
      </table>

      {{-- Riwayat Pemeriksaan --}}
      <div style="font-size:11px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">II. Riwayat Pemeriksaan</div>
      <table style="margin-bottom:20px;">
        <thead>
          <tr style="background:#f1f5f9;">
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:4%;">No</th>
            <th style="padding:7px 5px;text-align:left;border:1px solid #cbd5e1;width:14%;">Tanggal</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:8%;">Usia</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:11%;">BB / TB</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:12%;">LK / LILA</th>
            <th style="padding:7px 5px;text-align:center;border:1px solid #cbd5e1;width:20%;">Status Gizi & Imunisasi</th>
            <th style="padding:7px 5px;text-align:left;border:1px solid #cbd5e1;width:31%;">Hasil & Catatan Bidan</th>
          </tr>
        </thead>
        <tbody>${barisRiwayat}</tbody>
      </table>

      {{-- Footer --}}
      <div style="margin-top:30px;display:flex;justify-content:space-between;font-size:10px;color:#64748b;">
        <div>
          <div>* Dokumen ini dicetak otomatis dari Sistem Informasi Posyandu Melati 2.</div>
          <div>* Harap dibawa setiap kali melakukan kunjungan pemeriksaan.</div>
        </div>
        <div style="text-align:center;width:180px;">
          <div style="margin-bottom:45px;">Posyandu Melati 2</div>
          <div style="font-weight:700;border-top:1px solid #64748b;padding-top:4px;">Kader / Bidan Pemeriksa</div>
        </div>
      </div>

    </body>
    </html>
  `;

  const existing = document.getElementById('print-frame');
  if (existing) existing.remove();

  const iframe = document.createElement('iframe');
  iframe.id = 'print-frame';
  iframe.style.cssText = 'position:fixed;top:-9999px;left:-9999px;width:0;height:0;border:0;';
  document.body.appendChild(iframe);

  iframe.contentDocument.open();
  iframe.contentDocument.write(html);
  iframe.contentDocument.close();

  iframe.onload = function() {
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
  };
}
</script>
@endpush

@endsection