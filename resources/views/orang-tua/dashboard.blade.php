@extends('layouts.app')

@section('title', 'Dashboard Orang Tua — Posyandu Melati 2')

@push('styles')
<style>
    .dashboard-layout-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; margin-bottom: 24px; }
    @media (max-width: 1024px) { .dashboard-layout-grid { grid-template-columns: 1fr; gap: 16px; } }

    .info-grid-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 480px) { .info-grid-2col { grid-template-columns: 1fr; gap: 12px; } }

    .balita-desktop-table { display: block; }
    .balita-mobile-list { display: none; flex-direction: column; gap: 12px; }
    @media (max-width: 768px) {
        .balita-desktop-table { display: none; }
        .balita-mobile-list { display: flex; }
    }

    .balita-mobile-card { background: #fff; border: 1px solid var(--slate-200); border-radius: 12px; padding: 16px; display: flex; flex-direction: column; gap: 12px; }
    .balita-mobile-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--slate-100); padding-bottom: 10px; }
    .balita-mobile-name { font-size: 14.5px; font-weight: 700; color: var(--slate-800); }
    .balita-mobile-body { display: flex; flex-direction: column; gap: 8px; }
    .balita-info-row { display: flex; justify-content: space-between; align-items: flex-start; font-size: 12.5px; }
    .balita-info-row .info-label { color: var(--slate-500); font-weight: 500; }
    .balita-info-row .info-value { color: var(--slate-800); font-weight: 600; text-align: right; }
    .balita-info-row .text-muted { color: var(--slate-400); font-weight: normal; }
    .balita-mobile-footer { margin-top: 4px; }

    .schedule-list { display: flex; flex-direction: column; gap: 12px; }
    .schedule-item-custom { background: #fffdf9; border: 1px solid #fef3c7; border-left: 4px solid var(--amber-500); border-radius: 10px; padding: 14px 16px; transition: transform 0.2s, box-shadow 0.2s; }
    .schedule-item-custom:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.08); }
    .schedule-badge-row { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
    .schedule-time { font-size: 11px; color: var(--slate-400); display: flex; align-items: center; gap: 4px; }
    .schedule-title { font-size: 14px; font-weight: 700; color: var(--slate-800); margin-bottom: 6px; }
    .schedule-detail { font-size: 12px; color: var(--slate-500); display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
    .schedule-detail:last-child { margin-bottom: 0; }
    .schedule-detail i { width: 14px; font-size: 12px; }
    .schedule-detail .icon-calendar { color: var(--amber-500); }
    .schedule-detail .icon-location { color: var(--rose-500); }

    .welcome-banner-ortu { background: linear-gradient(135deg, #0a3d39, #0f766e 50%, #14b8a6); border-radius: 16px; padding: 20px 24px; color: #fff; margin-bottom: 20px; display: flex; align-items: center; gap: 16px; }

    @media (max-width: 576px) {
        .btn-mobile-full { width: 100% !important; justify-content: center !important; }
    }
</style>
@endpush

@section('content')
<div class="welcome-banner-ortu">
    <div>
        <div style="font-size:18px;font-weight:800;">Halo, {{ $user->nama }}</div>
        <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:3px;">Berikut ringkasan kesehatan keluarga Anda hari ini.</div>
    </div>
</div>

<div class="dashboard-layout-grid">
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div class="card">
            <div class="card-header" style="background: var(--teal-50); border-bottom: 1.5px solid var(--teal-100);">
                <i class="fas fa-person-pregnant" style="color: var(--teal-600); font-size: 18px;"></i>
                <div class="card-title" style="color: var(--teal-900);">Status Kehamilan Ibu</div>
            </div>
            <div style="padding: 20px;">
                @if($ibuHamil)
                    <div class="info-grid-2col">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="font-size: 12px; color: var(--slate-400); font-weight: 700; text-transform: uppercase;">Nama Ibu</div>
                            <div style="font-size: 15px; font-weight: 700; color: var(--slate-800);">{{ $ibuHamil->nama_ibu }}</div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="font-size: 12px; color: var(--slate-400); font-weight: 700; text-transform: uppercase;">NIK Ibu</div>
                            <div style="font-size: 15px; font-weight: 600; color: var(--slate-800);">{{ $ibuHamil->nik }}</div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="font-size: 12px; color: var(--slate-400); font-weight: 700; text-transform: uppercase;">Hari Pertama Haid Terakhir (HPHT)</div>
                            <div style="font-size: 14px; color: var(--slate-700);">{{ \Carbon\Carbon::parse($ibuHamil->hpht)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="font-size: 12px; color: var(--slate-400); font-weight: 700; text-transform: uppercase;">Status Kehamilan</div>
                            <div style="font-size: 14px; color: var(--slate-700);">
                                <span class="badge badge-teal">G{{ $ibuHamil->gravida }} P{{ $ibuHamil->partus }} A{{ $ibuHamil->abortus }}</span>
                                <div style="font-size: 11.5px; color: var(--slate-400); margin-top: 6px; line-height: 1.5;">
                                    Kehamilan ke-{{ $ibuHamil->gravida }}, sudah melahirkan {{ $ibuHamil->partus }} kali, keguguran {{ $ibuHamil->abortus }} kali.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                        <a href="{{ route('orang-tua.riwayat.ibu-hamil') }}" class="btn btn-primary btn-sm btn-mobile-full">
                            <i class="fas fa-eye"></i> Lihat Riwayat Pemeriksaan Ibu
                        </a>
                    </div>
                @else
                    <div style="text-align: center; padding: 20px 0; color: var(--slate-400);">
                        <i class="fas fa-circle-info" style="font-size: 32px; margin-bottom: 12px; color: var(--slate-300);"></i>
                        <p style="font-size: 13.5px;">Akun Orang Tua Anda belum dihubungkan ke data Ibu Hamil oleh Kader.</p>
                        <p style="font-size: 12px; margin-top: 4px;">Silakan hubungi Kader di posyandu untuk menghubungkan NIK Ibu dengan akun Anda.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="background: var(--slate-50);">
                <i class="fas fa-baby" style="color: var(--indigo-500); font-size: 18px;"></i>
                <div class="card-title">Data Tumbuh Kembang Balita</div>
            </div>
            <div style="padding: 20px;">
                @if($balitas->count() > 0)
                    <div class="table-scroll balita-desktop-table">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Nama Balita</th>
                                    <th style="text-align: center;">NIK</th>
                                    <th style="text-align: center; width: 80px;">Jenis Kelamin</th>
                                    <th style="text-align: center;">Tgl Lahir / Usia</th>
                                    <th style="text-align: center;">Pemeriksaan Terakhir</th>
                                    <th style="text-align: center; width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($balitas as $balita)
                                    @php
                                        $terakhir = $balita->pemeriksaanAwal()->latest('tanggal_periksa')->first();
                                        $lanjutan = $terakhir?->pemeriksaanLanjutan;
                                    @endphp
                                    <tr>
                                        <td style="text-align: left; font-weight: 600; color: var(--slate-800);">{{ $balita->nama_balita }}</td>
                                        <td style="text-align: center;">{{ $balita->nik ?: '-' }}</td>
                                        <td style="text-align: center;">
                                            <span class="badge {{ $balita->jenis_kelamin === 'L' ? 'badge-blue' : 'badge-red' }}">{{ $balita->jenis_kelamin }}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <div>{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d M Y') }}</div>
                                            <div class="cell-meta">{{ floor(\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now())) }} bulan</div>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($terakhir)
                                                <div>{{ \Carbon\Carbon::parse($terakhir->tanggal_periksa)->translatedFormat('d M Y') }}</div>
                                                <div class="cell-meta">{{ fmtAngka($terakhir->berat_badan) }} kg / {{ fmtAngka($terakhir->tinggi_badan) }} cm</div>
                                            @else
                                                <span style="color: var(--slate-400); font-size: 12.5px;">Belum pernah periksa</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-view btn-sm" onclick="showDetailModalBalita({{ json_encode($balita) }}, {{ json_encode($terakhir) }}, {{ json_encode($lanjutan) }})">
                                                <i class="fas fa-circle-info"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="balita-mobile-list">
                        @foreach($balitas as $balita)
                            @php
                                $terakhir = $balita->pemeriksaanAwal()->latest('tanggal_periksa')->first();
                                $lanjutan = $terakhir?->pemeriksaanLanjutan;
                            @endphp
                            <div class="balita-mobile-card">
                                <div class="balita-mobile-header">
                                    <span class="balita-mobile-name">{{ $balita->nama_balita }}</span>
                                    <span class="badge {{ $balita->jenis_kelamin === 'L' ? 'badge-blue' : 'badge-red' }}">{{ $balita->jenis_kelamin }}</span>
                                </div>
                                <div class="balita-mobile-body">
                                    <div class="balita-info-row">
                                        <span class="info-label">NIK</span>
                                        <span class="info-value">{{ $balita->nik ?: '-' }}</span>
                                    </div>
                                    <div class="balita-info-row">
                                        <span class="info-label">Tgl Lahir / Usia</span>
                                        <span class="info-value">
                                            {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d M Y') }}
                                            <span class="text-muted">({{ floor(\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now())) }} bulan)</span>
                                        </span>
                                    </div>
                                    <div class="balita-info-row">
                                        <span class="info-label">Pemeriksaan Terakhir</span>
                                        <span class="info-value">
                                            @if($terakhir)
                                                <div style="font-weight: 600; color: var(--slate-800);">{{ \Carbon\Carbon::parse($terakhir->tanggal_periksa)->translatedFormat('d M Y') }}</div>
                                                <div style="color: var(--teal-600); font-weight: 600; font-size: 12.5px; margin-top: 2px;">{{ fmtAngka($terakhir->berat_badan) }} kg / {{ fmtAngka($terakhir->tinggi_badan) }} cm</div>
                                            @else
                                                <span style="color: var(--slate-400);">Belum pernah periksa</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="balita-mobile-footer">
                                    <button type="button" class="btn btn-view btn-sm btn-mobile-full" onclick="showDetailModalBalita({{ json_encode($balita) }}, {{ json_encode($terakhir) }}, {{ json_encode($lanjutan) }})">
                                        <i class="fas fa-circle-info"></i> Detail
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 20px 0; color: var(--slate-400);">
                        <i class="fas fa-child" style="font-size: 32px; margin-bottom: 12px; color: var(--slate-300);"></i>
                        <p style="font-size: 13.5px;">Belum ada data balita yang terdaftar atas nama Anda.</p>
                        <p style="font-size: 12px; margin-top: 4px;">Data balita akan muncul otomatis jika Ibu Hamil di atas sudah terhubung.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div class="card">
            <div class="card-header" style="background: var(--amber-50); border-bottom: 1.5px solid var(--amber-100);">
                <i class="fas fa-calendar-alt" style="color: var(--amber-500); font-size: 18px;"></i>
                <div class="card-title" style="color: var(--amber-900);">Jadwal Posyandu Terdekat</div>
            </div>
            <div style="padding: 20px;">
                @if($jadwalMendatang->count() > 0)
                    <div class="schedule-list">
                        @foreach($jadwalMendatang as $jadwal)
                            <div class="schedule-item-custom">
                                <div class="schedule-badge-row">
                                    <span class="badge badge-orange">{{ strtoupper($jadwal->status) }}</span>
                                    <span class="schedule-time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</span>
                                </div>
                                <div class="schedule-title">{{ $jadwal->judul }}</div>
                                <div class="schedule-detail">
                                    <i class="fas fa-calendar-day icon-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <div class="schedule-detail">
                                    <i class="fas fa-map-marker-alt icon-location"></i>
                                    <span>{{ $jadwal->lokasi }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('jadwal-posyandu.public') }}" class="btn btn-outline btn-sm btn-mobile-full" style="justify-content: center; width: 100%; margin-top: 12px;">
                        Lihat Semua Jadwal
                    </a>
                @else
                    <div style="text-align: center; padding: 20px 0; color: var(--slate-400); font-size: 13px;">
                        <i class="fas fa-calendar-times" style="font-size: 32px; margin-bottom: 12px; color: var(--slate-300); display: block;"></i>
                        Belum ada jadwal posyandu mendatang.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Balita -->
<div id="detailModalBalita" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #fff; border-radius: 16px; width: 100%; max-width: 600px; box-shadow: var(--shadow-lg); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1.5px solid var(--slate-100); display: flex; align-items: center; justify-content: space-between; background: var(--teal-900); color: #fff;">
            <h3 style="font-size: 15px; font-weight: 700;"><i class="fas fa-file-medical"></i> Rincian Pemeriksaan Balita</h3>
            <button onclick="closeDetailModalBalita()" style="background: none; border: none; color: #fff; font-size: 18px; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; max-height: 70vh; overflow-y: auto;">
            <div id="modalBalita-empty" style="text-align: center; padding: 20px; color: var(--slate-400); background: var(--slate-50); border-radius: 10px; border: 1.5px dashed var(--slate-200);">
                <i class="fas fa-stethoscope" style="font-size: 20px; margin-bottom: 8px;"></i>
                <p style="font-size: 12px;">Belum ada data pemeriksaan untuk balita ini.</p>
            </div>

            <div id="modalBalita-content" style="display: none;">
                <h4 style="font-size: 12.5px; font-weight: 700; color: var(--teal-600); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Pemeriksaan Awal (Kader)</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; background: var(--slate-50); padding: 14px; border-radius: 10px;">
                    <div>
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">TANGGAL PERIKSA</div>
                        <div id="modalBalita-tanggal" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">USIA BALITA</div>
                        <div id="modalBalita-usia" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">BERAT BADAN</div>
                        <div id="modalBalita-bb" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">TINGGI BADAN</div>
                        <div id="modalBalita-tb" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">LINGKAR KEPALA</div>
                        <div id="modalBalita-lk" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">LINGKAR LENGAN</div>
                        <div id="modalBalita-ll" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">KELUHAN</div>
                        <div id="modalBalita-keluhan" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                    </div>
                </div>

                <h4 style="font-size: 12.5px; font-weight: 700; color: var(--indigo-500); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Pemeriksaan Lanjutan (Bidan)</h4>
                <div id="modalBalita-bidan-empty" style="text-align: center; padding: 20px; color: var(--slate-400); background: var(--slate-50); border-radius: 10px; border: 1.5px dashed var(--slate-200);">
                    <i class="fas fa-hourglass-half" style="font-size: 20px; margin-bottom: 8px;"></i>
                    <p style="font-size: 12px;">Menunggu antrian pemeriksaan lanjutan dari Bidan.</p>
                </div>
                <div id="modalBalita-bidan-content" style="display: none; grid-template-columns: 1fr 1fr; gap: 14px; background: #eef0ff; padding: 14px; border-radius: 10px;">
                    <div>
                        <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">STATUS GIZI</div>
                        <div id="modalBalita-gizi" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">IMUNISASI</div>
                        <div id="modalBalita-imunisasi" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">VITAMIN A</div>
                        <div id="modalBalita-vitamina" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">CATATAN BIDAN</div>
                        <div id="modalBalita-catatan" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">TINDAK LANJUT</div>
                        <div id="modalBalita-tindak" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 14px 20px; border-top: 1.5px solid var(--slate-100); display: flex; justify-content: flex-end; background: var(--slate-50);">
            <button class="btn btn-outline btn-sm" onclick="closeDetailModalBalita()">Tutup</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showDetailModalBalita(balita, terakhir, lanjutan) {
    const empty = document.getElementById('modalBalita-empty');
    const content = document.getElementById('modalBalita-content');

    if (!terakhir) {
        empty.style.display = 'block';
        content.style.display = 'none';
        document.getElementById('detailModalBalita').style.display = 'flex';
        return;
    }

    empty.style.display = 'none';
    content.style.display = 'block';

    document.getElementById('modalBalita-tanggal').innerText = terakhir.tanggal_periksa ? formatDateBalita(terakhir.tanggal_periksa) : '-';
    document.getElementById('modalBalita-usia').innerText = terakhir.usia_balita ? terakhir.usia_balita + ' bulan' : '-';
    document.getElementById('modalBalita-bb').innerText = terakhir.berat_badan ? terakhir.berat_badan + ' kg' : '-';
    document.getElementById('modalBalita-tb').innerText = terakhir.tinggi_badan ? terakhir.tinggi_badan + ' cm' : '-';
    document.getElementById('modalBalita-lk').innerText = terakhir.lingkar_kepala ? terakhir.lingkar_kepala + ' cm' : '-';
    document.getElementById('modalBalita-ll').innerText = terakhir.lingkar_lengan ? terakhir.lingkar_lengan + ' cm' : '-';
    document.getElementById('modalBalita-keluhan').innerText = terakhir.keluhan || 'Tidak ada keluhan';

    const bEmpty = document.getElementById('modalBalita-bidan-empty');
    const bContent = document.getElementById('modalBalita-bidan-content');

    if (lanjutan) {
        bEmpty.style.display = 'none';
        bContent.style.display = 'grid';
        document.getElementById('modalBalita-gizi').innerText = lanjutan.status_gizi || '-';
        document.getElementById('modalBalita-imunisasi').innerText = lanjutan.imunisasi || '-';
        document.getElementById('modalBalita-vitamina').innerText = lanjutan.vitamin_a || '-';
        document.getElementById('modalBalita-catatan').innerText = lanjutan.catatan_bidan || 'Tidak ada catatan';
        document.getElementById('modalBalita-tindak').innerText = lanjutan.tindak_lanjut || 'Tidak ada';
    } else {
        bEmpty.style.display = 'block';
        bContent.style.display = 'none';
    }

    document.getElementById('detailModalBalita').style.display = 'flex';
}

function closeDetailModalBalita() {
    document.getElementById('detailModalBalita').style.display = 'none';
}

function formatDateBalita(dateStr) {
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const d = new Date(dateStr);
    return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
}
</script>
@endpush
@endsection