@extends('layouts.app')

@section('title', 'Jadwal Posyandu — Posyandu Melati 2')

@section('content')
<div class="page-header" style="flex-direction: column; align-items: flex-start; gap: 12px;">
    <a href="{{ route('orang-tua.dashboard') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <div class="page-header-left">
        <h2>Jadwal Kegiatan Posyandu</h2>
        <p>Lihat tanggal dan lokasi pelaksanaan posyandu terbaru untuk wilayah Anda.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-calendar-days" style="color: var(--teal-600);"></i>
        <div class="card-title">Daftar Jadwal Mendatang</div>
    </div>
    <div style="padding: 20px;">
        @if($jadwals->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px;">
                @foreach($jadwals as $jadwal)
                    <div style="background: #fff; border: 1.5px solid var(--slate-200); border-radius: 12px; padding: 18px; position: relative; box-shadow: var(--shadow-sm);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                            <span class="badge badge-teal" style="font-weight: 700;">{{ strtoupper($jadwal->status) }}</span>
                            <span style="font-size: 12px; color: var(--slate-400);"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</span>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--slate-800); margin-bottom: 8px;">{{ $jadwal->judul }}</h4>
                        <div style="font-size: 13px; color: var(--slate-500); margin-bottom: 6px;">
                            <i class="fas fa-calendar-day" style="width: 16px; color: var(--teal-500);"></i>
                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                        </div>
                        <div style="font-size: 13px; color: var(--slate-500); margin-bottom: 8px;">
                            <i class="fas fa-map-marker-alt" style="width: 16px; color: var(--rose-500);"></i>
                            {{ $jadwal->lokasi }}
                        </div>
                        @if($jadwal->keterangan)
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed var(--slate-200); font-size: 12.5px; color: var(--slate-600); line-height: 1.4; white-space: normal; word-break: break-word;">
                                <strong>Keterangan:</strong> {{ $jadwal->keterangan }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-wrapper">
                {{ $jadwals->links('layouts.pagination') }}
            </div>
        @else
            <div style="text-align: center; padding: 40px 0; color: var(--slate-400);">
                <i class="fas fa-calendar-xmark" style="font-size: 40px; margin-bottom: 12px; color: var(--slate-300);"></i>
                <p>Belum ada informasi jadwal posyandu terbaru.</p>
            </div>
        @endif
    </div>
</div>
@endsection
