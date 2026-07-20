@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan Ibu Hamil — Posyandu Melati 2')

@section('content')
<div class="page-header" style="flex-direction: column; align-items: flex-start; gap: 12px;">
    <a href="{{ route('orang-tua.dashboard') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <div class="page-header-left">
        <h2>Riwayat Pemeriksaan Ibu Hamil</h2>
        <p>Histori rekam medis pemeriksaan rutin kehamilan Anda.</p>
    </div>
</div>

@if($ibuHamil)
    @php
        $hphtOrtu      = \Carbon\Carbon::parse($ibuHamil->hpht);
        $taksiranOrtu  = $hphtOrtu->copy()->addDays(280);
        $usiaKehOrtu   = (int) $hphtOrtu->diffInWeeks(now());
        $trimesterOrtu = $usiaKehOrtu <= 12 ? 'I' : ($usiaKehOrtu <= 27 ? 'II' : 'III');
        $usiaIbuOrtu   = \Carbon\Carbon::parse($ibuHamil->tanggal_lahir)->age;
    @endphp

    <div class="pasien-header-ortu">
        <div class="pasien-avatar-lg-ortu">
            {{ strtoupper(substr($ibuHamil->nama_ibu, 0, 1)) }}
        </div>
        <div style="flex: 1; min-width: 0; position: relative; z-index: 1;">
            <div style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 4px;">{{ $ibuHamil->nama_ibu }}</div>
            <div class="pasien-meta-ortu">
                <span><i class="fas fa-id-card"></i> NIK: {{ $ibuHamil->nik }}</span>
                <span><i class="fas fa-person-pregnant"></i> G{{ $ibuHamil->gravida }}P{{ $ibuHamil->partus }}A{{ $ibuHamil->abortus }}</span>
                <span><i class="fas fa-baby"></i> Trimester {{ $trimesterOrtu }} · {{ $usiaKehOrtu }} minggu</span>
                @if($ibuHamil->no_hp)
                    <span><i class="fab fa-whatsapp"></i> {{ $ibuHamil->no_hp }}</span>
                @endif
            </div>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap; position: relative; z-index: 1;">
            @foreach([
                ['label'=>'Usia Ibu', 'val'=>$usiaIbuOrtu.' tahun', 'icon'=>'fa-user'],
                ['label'=>'Usia Kehamilan', 'val'=>$usiaKehOrtu.' minggu', 'icon'=>'fa-calendar-week'],
                ['label'=>'Taksiran Lahir', 'val'=>$taksiranOrtu->translatedFormat('d M Y'), 'icon'=>'fa-baby'],
            ] as $s)
            <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(6px); border: 1.5px solid rgba(255,255,255,0.25); border-radius: 12px; padding: 10px 16px; text-align: center; min-width: 110px;">
                <div style="font-size: 10px; color: rgba(255,255,255,0.7); margin-bottom: 3px; text-transform: uppercase; letter-spacing: .5px;">
                    <i class="fas {{ $s['icon'] }}" style="margin-right: 3px;"></i>{{ $s['label'] }}
                </div>
                <div style="font-size: 13px; font-weight: 700; color: #fff;">{{ $s['val'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Section -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-notes-medical" style="color: var(--teal-600);"></i>
            <div class="card-title">Histori Pemeriksaan</div>
        </div>
        <div style="padding: 20px;">
            @if($ibuHamil->pemeriksaanAwal->count() > 0)
                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Tgl Periksa</th>
                                <th style="text-align: center;">Usia Kehamilan</th>
                                <th style="text-align: center;">Berat Badan</th>
                                <th style="text-align: center;">Tekanan Darah</th>
                                <th style="text-align: center;">Pemeriksa Awal (Kader)</th>
                                <th style="text-align: center;">Status Bidan</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ibuHamil->pemeriksaanAwal()->latest('tanggal_periksa')->get() as $awal)
                                @php
                                    $lanjutan = $awal->pemeriksaanLanjutan;
                                @endphp
                                <tr>
                                    <td class="cell-name" style="text-align: center;">{{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d M Y') }}</td>
                                    <td style="text-align: center;">{{ $awal->usia_kehamilan ? $awal->usia_kehamilan . ' minggu' : '-' }}</td>
                                    <td style="text-align: center;">{{ fmtAngka($awal->berat_badan) }} kg</td>
                                    <td style="text-align: center;">{{ $awal->tekanan_darah }} mmHg</td>
                                    <td style="text-align: center;">{{ $awal->kader->nama ?? '-' }}</td>
                                    <td style="text-align: center;">
                                        @if($lanjutan)
                                            <span class="badge badge-green"><i class="fas fa-check-circle"></i> Selesai Bidan</span>
                                        @else
                                            <span class="badge badge-orange"><i class="fas fa-hourglass-half"></i> Menunggu Bidan</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-view btn-sm" onclick="showDetailModal({{ json_encode($awal) }}, {{ json_encode($lanjutan) }})">
                                            <i class="fas fa-circle-info"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 40px 0; color: var(--slate-400);">
                    <i class="fas fa-stethoscope" style="font-size: 40px; margin-bottom: 12px; color: var(--slate-300);"></i>
                    <p>Belum ada rekaman riwayat pemeriksaan awal untuk data Ibu Hamil ini.</p>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="card">
        <div style="text-align: center; padding: 50px 0; color: var(--slate-400);">
            <i class="fas fa-circle-info" style="font-size: 48px; margin-bottom: 16px; color: var(--slate-300);"></i>
            <h3 style="color: var(--slate-700); margin-bottom: 8px;">Profil Ibu Hamil Belum Dihubungkan</h3>
            <p>Silakan laporkan ke kader posyandu agar akun Anda dihubungkan dengan data NIK Ibu Hamil Anda.</p>
        </div>
    </div>
@endif

<!-- Modal Detail -->
<div id="detailModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #fff; border-radius: 16px; width: 100%; max-width: 600px; box-shadow: var(--shadow-lg); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1.5px solid var(--slate-100); display: flex; align-items: center; justify-content: space-between; background: var(--teal-900); color: #fff;">
            <h3 style="font-size: 15px; font-weight: 700;"><i class="fas fa-file-medical"></i> Rincian Pemeriksaan Ibu Hamil</h3>
            <button onclick="closeDetailModal()" style="background: none; border: none; color: #fff; font-size: 18px; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; max-height: 70vh; overflow-y: auto;">
            <h4 style="font-size: 12.5px; font-weight: 700; color: var(--teal-600); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Pemeriksaan Awal (Kader)</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; background: var(--slate-50); padding: 14px; border-radius: 10px;">
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">TANGGAL PERIKSA</div>
                    <div id="modal-awal-tanggal" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">USIA KEHAMILAN</div>
                    <div id="modal-awal-usia" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">BERAT BADAN</div>
                    <div id="modal-awal-bb" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">TEKANAN DARAH</div>
                    <div id="modal-awal-tensi" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">KELUHAN / KONDISI</div>
                    <div id="modal-awal-keluhan" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                </div>
            </div>

            <h4 style="font-size: 12.5px; font-weight: 700; color: var(--indigo-500); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Pemeriksaan Lanjutan (Bidan)</h4>
            <div id="modal-bidan-empty" style="text-align: center; padding: 20px; color: var(--slate-400); background: var(--slate-50); border-radius: 10px; border: 1.5px dashed var(--slate-200); margin-bottom: 10px;">
                <i class="fas fa-hourglass-half" style="font-size: 20px; margin-bottom: 8px;"></i>
                <p style="font-size: 12px;">Menunggu antrian pemeriksaan lanjutan dari Bidan.</p>
            </div>
            <div id="modal-bidan-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; background: #eef0ff; padding: 14px; border-radius: 10px; display: none;">
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">TANGGAL PERIKSA BIDAN</div>
                    <div id="modal-bidan-tanggal" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">LINGKAR LENGAN ATAS (LILA)</div>
                    <div id="modal-bidan-lila" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">TINGGI FUNDUS UTERI (TFU)</div>
                    <div id="modal-bidan-tfu" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">DETAK JANTUNG JANIN (DJJ)</div>
                    <div id="modal-bidan-djj" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">CATATAN BIDAN</div>
                    <div id="modal-bidan-catatan" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">TINDAK LANJUT</div>
                    <div id="modal-bidan-tindak" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                </div>
            </div>
        </div>
        <div style="padding: 14px 20px; border-top: 1.5px solid var(--slate-100); display: flex; justify-content: flex-end; background: var(--slate-50);">
            <button class="btn btn-outline btn-sm" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pasien-header-ortu {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        padding: 24px 28px;
        border-radius: 16px;
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14a398 100%);
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    .pasien-avatar-lg-ortu {
        width: 68px; height: 68px; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; font-weight: 800; color: #fff;
        background: rgba(255,255,255,0.2);
        border: 2.5px solid rgba(255,255,255,0.35);
        flex-shrink: 0; position: relative; z-index: 1;
    }
    .pasien-meta-ortu {
        display: flex; gap: 14px; flex-wrap: wrap; margin-top: 8px;
        font-size: 12px; color: rgba(255,255,255,0.8);
    }
    .pasien-meta-ortu span { display: flex; align-items: center; gap: 4px; }
    @media (max-width: 768px) {
        .pasien-header-ortu { padding: 16px !important; flex-direction: column; align-items: flex-start !important; }
        .pasien-avatar-lg-ortu { display: none; }
        .pasien-meta-ortu { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; width: 100%; }
        .pasien-header-ortu > div:last-child { width: 100%; display: grid; grid-template-columns: repeat(3,1fr); gap: 6px; margin-top: 4px; }
    }
</style>
@endpush

@push('scripts')
<script>
function showDetailModal(awal, lanjutan) {
    document.getElementById('modal-awal-tanggal').innerText = awal.tanggal_periksa ? formatDate(awal.tanggal_periksa) : '-';
    document.getElementById('modal-awal-usia').innerText = awal.usia_kehamilan ? awal.usia_kehamilan + ' minggu' : '-';
    document.getElementById('modal-awal-bb').innerText = awal.berat_badan ? awal.berat_badan + ' kg' : '-';
    document.getElementById('modal-awal-tensi').innerText = awal.tekanan_darah ? awal.tekanan_darah + ' mmHg' : '-';
    document.getElementById('modal-awal-keluhan').innerText = awal.keluhan || 'Tidak ada keluhan';

    const bEmpty = document.getElementById('modal-bidan-empty');
    const bContent = document.getElementById('modal-bidan-content');

    if (lanjutan) {
        bEmpty.style.display = 'none';
        bContent.style.display = 'grid';
        document.getElementById('modal-bidan-tanggal').innerText = lanjutan.tanggal_periksa ? formatDate(lanjutan.tanggal_periksa) : '-';
        document.getElementById('modal-bidan-lila').innerText = lanjutan.lila ? lanjutan.lila + ' cm' : '-';
        document.getElementById('modal-bidan-tfu').innerText = lanjutan.tfu ? lanjutan.tfu + ' cm' : '-';
        document.getElementById('modal-bidan-djj').innerText = lanjutan.djj ? lanjutan.djj + ' dpm' : '-';
        document.getElementById('modal-bidan-catatan').innerText = lanjutan.catatan_bidan || 'Tidak ada catatan';
        document.getElementById('modal-bidan-tindak').innerText = lanjutan.tindak_lanjut || 'Tidak ada';
    } else {
        bEmpty.style.display = 'block';
        bContent.style.display = 'none';
    }

    document.getElementById('detailModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

function formatDate(dateStr) {
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const d = new Date(dateStr);
    return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
}
</script>
@endpush
@endsection
