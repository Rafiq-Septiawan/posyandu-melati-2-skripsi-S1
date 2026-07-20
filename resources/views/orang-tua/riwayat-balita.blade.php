@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan Balita — Posyandu Melati 2')

@section('content')
<div class="page-header" style="flex-direction: column; align-items: flex-start; gap: 12px;">
    <a href="{{ route('orang-tua.dashboard') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <div class="page-header-left">
        <h2>Riwayat Pemeriksaan Balita</h2>
        <p>Pantau data pertumbuhan, imunisasi, dan catatan bidan bagi buah hati Anda.</p>
    </div>
</div>

@if($balitas->count() > 0)
    @foreach($balitas as $balita)
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header" style="background: var(--slate-50); display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--slate-200);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="avatar-table" style="background: {{ $balita->jenis_kelamin === 'L' ? 'var(--indigo-500)' : 'var(--rose-400)' }}; width: 40px; height: 40px; font-size: 16px;">
                        {{ strtoupper(substr($balita->nama_balita, 0, 1)) }}
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: var(--slate-800);">{{ $balita->nama_balita }}</h3>
                        <p style="font-size: 11.5px; color: var(--slate-400);">NIK: {{ $balita->nik ?: '-' }} | Jenis Kelamin: {{ $balita->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <span class="badge badge-teal" style="font-size: 12px; font-weight: 700;">
                        Usia: {{ floor(\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now())) }} Bulan
                    </span>
                    <p style="font-size: 11px; color: var(--slate-400); margin-top: 2px;">Lahir: {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                </div>
            </div>
            <div style="padding: 20px;">
                @php
                    $awals = $balita->pemeriksaanAwal()->latest('tanggal_periksa')->get();
                @endphp
                @if($awals->count() > 0)
                    <div class="table-scroll">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Tgl Periksa</th>
                                    <th style="text-align: center;">Usia Balita</th>
                                    <th style="text-align: center;">Berat Badan</th>
                                    <th style="text-align: center;">Tinggi Badan</th>
                                    <th style="text-align: center;">Lingkar Kepala</th>
                                    <th style="text-align: center;">Lingkar Lengan</th>
                                    <th style="text-align: center;">Status Bidan</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($awals as $awal)
                                    @php
                                        $lanjutan = $awal->pemeriksaanLanjutan;
                                    @endphp
                                    <tr>
                                        <td class="cell-name" style="text-align: center;">{{ \Carbon\Carbon::parse($awal->tanggal_periksa)->translatedFormat('d M Y') }}</td>
                                        <td style="text-align: center;">{{ $awal->usia_balita ? $awal->usia_balita . ' bulan' : '-' }}</td>
                                        <td style="text-align: center;">{{ fmtAngka($awal->berat_badan) }} kg</td>
                                        <td style="text-align: center;">{{ fmtAngka($awal->tinggi_badan) }} cm</td>
                                        <td style="text-align: center;">{{ $awal->lingkar_kepala ? fmtAngka($awal->lingkar_kepala) . ' cm' : '-' }}</td>
                                        <td style="text-align: center;">{{ $awal->lingkar_lengan ? fmtAngka($awal->lingkar_lengan) . ' cm' : '-' }}</td>
                                        <td style="text-align: center;">
                                            @if($lanjutan)
                                                <span class="badge badge-green"><i class="fas fa-check-circle"></i> Selesai Bidan</span>
                                            @else
                                                <span class="badge badge-orange"><i class="fas fa-hourglass-half"></i> Menunggu Bidan</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-view btn-sm" onclick="showDetailModalBalita({{ json_encode($awal) }}, {{ json_encode($lanjutan) }}, '{{ $balita->nama_balita }}')">
                                                <i class="fas fa-circle-info"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 24px 0; color: var(--slate-400); font-size: 13.5px;">
                        <i class="fas fa-circle-exclamation" style="font-size: 24px; margin-bottom: 8px; color: var(--slate-300);"></i>
                        <p>Belum ada rekaman riwayat pemeriksaan awal dari kader untuk balita ini.</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@else
    <div class="card">
        <div style="text-align: center; padding: 50px 0; color: var(--slate-400);">
            <i class="fas fa-circle-info" style="font-size: 48px; margin-bottom: 16px; color: var(--slate-300);"></i>
            <h3 style="color: var(--slate-700); margin-bottom: 8px;">Tidak Ada Data Balita Terhubung</h3>
            <p>Silakan hubungi kader posyandu untuk melengkapi profil Ibu Hamil Anda dan menghubungkan data balita.</p>
        </div>
    </div>
@endif

<!-- Modal Detail Balita -->
<div id="detailModalBalita" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #fff; border-radius: 16px; width: 100%; max-width: 600px; box-shadow: var(--shadow-lg); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1.5px solid var(--slate-100); display: flex; align-items: center; justify-content: space-between; background: var(--teal-900); color: #fff;">
            <h3 style="font-size: 15px; font-weight: 700;"><i class="fas fa-file-medical"></i> Rincian Pemeriksaan Balita — <span id="modal-balita-nama"></span></h3>
            <button onclick="closeDetailModalBalita()" style="background: none; border: none; color: #fff; font-size: 18px; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div style="padding: 20px; max-height: 70vh; overflow-y: auto;">
            <h4 style="font-size: 12.5px; font-weight: 700; color: var(--teal-600); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Pemeriksaan Fisik (Kader)</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; background: var(--slate-50); padding: 14px; border-radius: 10px;">
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">TANGGAL PERIKSA</div>
                    <div id="modal-awal-tanggal" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">USIA PEMERIKSAAN</div>
                    <div id="modal-awal-usia" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">BERAT / TINGGI BADAN</div>
                    <div id="modal-awal-bbtb" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">LINGKAR KEPALA / LENGAN</div>
                    <div id="modal-awal-lingkar" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: var(--slate-400); font-weight: 600;">KELUHAN / KONDISI FISIK</div>
                    <div id="modal-awal-keluhan" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                </div>
            </div>

            <h4 style="font-size: 12.5px; font-weight: 700; color: var(--indigo-500); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Tindakan & Medis (Bidan)</h4>
            <div id="modal-bidan-empty" style="text-align: center; padding: 20px; color: var(--slate-400); background: var(--slate-50); border-radius: 10px; border: 1.5px dashed var(--slate-200); margin-bottom: 10px;">
                <i class="fas fa-hourglass-half" style="font-size: 20px; margin-bottom: 8px;"></i>
                <p style="font-size: 12px;">Menunggu antrian pemeriksaan lanjutan / imunisasi dari Bidan.</p>
            </div>
            <div id="modal-bidan-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; background: #eef0ff; padding: 14px; border-radius: 10px; display: none;">
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">TANGGAL TINDAKAN</div>
                    <div id="modal-bidan-tanggal" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">STATUS GIZI</div>
                    <div id="modal-bidan-gizi" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">IMUNISASI DIBERIKAN</div>
                    <div id="modal-bidan-imunisasi" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">VITAMIN A</div>
                    <div id="modal-bidan-vit" style="font-size: 13.5px; font-weight: 600; color: var(--slate-800);">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">CATATAN KESEHATAN BIDAN</div>
                    <div id="modal-bidan-catatan" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: var(--slate-500); font-weight: 600;">TINDAK LANJUT / SARAN</div>
                    <div id="modal-bidan-tindak" style="font-size: 13px; color: var(--slate-700); margin-top: 2px;">-</div>
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
function showDetailModalBalita(awal, lanjutan, namaBalita) {
    document.getElementById('modal-balita-nama').innerText = namaBalita;
    document.getElementById('modal-awal-tanggal').innerText = awal.tanggal_periksa ? formatDate(awal.tanggal_periksa) : '-';
    document.getElementById('modal-awal-usia').innerText = awal.usia_balita ? awal.usia_balita + ' bulan' : '-';
    document.getElementById('modal-awal-bbtb').innerText = (awal.berat_badan || '-') + ' kg / ' + (awal.tinggi_badan || '-') + ' cm';
    document.getElementById('modal-awal-lingkar').innerText = (awal.lingkar_kepala || '-') + ' cm / ' + (awal.lingkar_lengan || '-') + ' cm';
    document.getElementById('modal-awal-keluhan').innerText = awal.keluhan || 'Tidak ada keluhan';

    const bEmpty = document.getElementById('modal-bidan-empty');
    const bContent = document.getElementById('modal-bidan-content');

    if (lanjutan) {
        bEmpty.style.display = 'none';
        bContent.style.display = 'grid';
        document.getElementById('modal-bidan-tanggal').innerText = lanjutan.tanggal_periksa ? formatDate(lanjutan.tanggal_periksa) : '-';
        document.getElementById('modal-bidan-gizi').innerText = lanjutan.status_gizi || '-';
        document.getElementById('modal-bidan-imunisasi').innerText = lanjutan.imunisasi || 'Tidak ada tindakan imunisasi';
        document.getElementById('modal-bidan-vit').innerText = lanjutan.vitamin_a || 'Tidak diberikan';
        document.getElementById('modal-bidan-catatan').innerText = lanjutan.catatan_bidan || 'Tidak ada catatan';
        document.getElementById('modal-bidan-tindak').innerText = lanjutan.tindak_lanjut || 'Tidak ada';
    } else {
        bEmpty.style.display = 'block';
        bContent.style.display = 'none';
    }

    document.getElementById('detailModalBalita').style.display = 'flex';
}

function closeDetailModalBalita() {
    document.getElementById('detailModalBalita').style.display = 'none';
}

function formatDate(dateStr) {
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const d = new Date(dateStr);
    return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
}
</script>
@endpush
@endsection
