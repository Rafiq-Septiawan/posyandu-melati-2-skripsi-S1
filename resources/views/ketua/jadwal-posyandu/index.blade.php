@extends('layouts.app')

@section('title', 'Kelola Jadwal Posyandu — Posyandu Melati 2')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Kelola Jadwal Posyandu</h2>
        <p>Kelola jadwal pelaksanaan posyandu aktif, selesai, maupun dibatalkan.</p>
    </div>
    <div style="margin-left: auto;">
        <a href="{{ route('ketua.jadwal-posyandu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Jadwal Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-calendar-days" style="color: var(--teal-600);"></i>
        <div class="card-title">Daftar Jadwal Posyandu</div>
    </div>
    <div style="padding: 20px;">
        @if($jadwals->count() > 0)
            <div class="rt-wrap">
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-nama-data">Kegiatan</th>
                            <th class="col-hide-mobile">Tanggal</th>
                            <th class="col-hide-mobile">Waktu</th>
                            <th class="col-hide-mobile">Lokasi / Tempat</th>
                            <th class="col-hide-mobile">Status</th>
                            <th class="col-hide-mobile">Pembuat</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jadwal)
                            @php
                              $statusLabel = $jadwal->status === 'aktif' ? 'Aktif' : ($jadwal->status === 'selesai' ? 'Selesai' : 'Dibatalkan');
                            @endphp
                            <tr>
                                <td class="col-nama-data cell-name">{{ $jadwal->judul }}</td>
                                <td class="col-hide-mobile">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="col-hide-mobile">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }}</td>
                                <td class="col-hide-mobile">{{ $jadwal->lokasi }}</td>
                                <td class="col-hide-mobile">
                                    @if($jadwal->status === 'aktif')
                                        <span class="badge badge-teal">Aktif</span>
                                    @elseif($jadwal->status === 'selesai')
                                        <span class="badge badge-green">Selesai</span>
                                    @else
                                        <span class="badge badge-red">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="col-hide-mobile">{{ $jadwal->creator->nama ?? '-' }}</td>
                                <td class="col-aksi">
                                    <div class="action-btns" style="justify-content:center;">
                                        <a href="#" class="btn btn-view btn-sm" title="Detail"
                                           data-title="{{ $jadwal->judul }}"
                                           data-detail="{{ json_encode([
                                             'Nama Kegiatan' => $jadwal->judul,
                                             'Tanggal' => \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y'),
                                             'Waktu' => \Carbon\Carbon::parse($jadwal->jam)->format('H:i') . ' WIB',
                                             'Lokasi / Tempat' => $jadwal->lokasi,
                                             'Status' => $statusLabel,
                                             'Pembuat' => $jadwal->creator->nama ?? '-'
                                           ]) }}"
                                           onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('ketua.jadwal-posyandu.edit', $jadwal->id) }}" class="btn btn-edit btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('ketua.jadwal-posyandu.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ═══ MOBILE CARD LIST ═══ --}}
            <div class="mobile-list" style="padding:10px 14px;">
                @foreach($jadwals as $i => $jadwal)
                @php
                  $statusBadge = $jadwal->status === 'aktif' ? 'badge-teal' : ($jadwal->status === 'selesai' ? 'badge-green' : 'badge-red');
                  $statusLabel = $jadwal->status === 'aktif' ? 'Aktif' : ($jadwal->status === 'selesai' ? 'Selesai' : 'Dibatalkan');
                @endphp
                <div class="rec-card">
                    <div class="rec-card-header">
                        <div>
                            <div class="rec-name">{{ $jadwal->judul }}</div>
                            <div class="rec-sub">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                                &bull; {{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }}
                            </div>
                        </div>
                        <div class="rec-actions">
                            <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                            <a href="{{ route('ketua.jadwal-posyandu.edit', $jadwal->id) }}" class="btn btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('ketua.jadwal-posyandu.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <hr class="rec-divider">
                    <div class="rec-grid">
                        <div class="rec-field">
                            <label>Lokasi</label>
                            <div class="val" style="font-weight:400;">{{ $jadwal->lokasi }}</div>
                        </div>
                        <div class="rec-field">
                            <label>Pembuat</label>
                            <div class="val">{{ $jadwal->creator->nama ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>{{-- end rt-wrap --}}
            
            <div class="pagination-wrapper">
                {{ $jadwals->links('layouts.pagination') }}
            </div>
        @else
            <div style="text-align: center; padding: 40px 0; color: var(--slate-400);">
                <i class="fas fa-calendar-xmark" style="font-size: 40px; margin-bottom: 12px; color: var(--slate-300);"></i>
                <p>Belum ada jadwal posyandu yang dibuat.</p>
            </div>
        @endif
    </div>
</div>
@endsection

