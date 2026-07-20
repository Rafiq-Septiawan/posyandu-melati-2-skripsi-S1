@extends('layouts.app')

@section('title', 'Notifikasi Saya — Posyandu Melati 2')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Notifikasi Saya</h2>
        <p>Pemberitahuan terkini mengenai jadwal posyandu dan perkembangan kesehatan.</p>
    </div>
    <div style="margin-left: auto;">
        <a href="{{ route('orang-tua.dashboard') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-bell" style="color: var(--teal-600);"></i>
        <div class="card-title">Daftar Notifikasi</div>
    </div>
    <div style="padding: 20px;">
        @if($notifikasis->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 14px;">
                @foreach($notifikasis as $notif)
                    @php
                        $iconClass = 'fa-bell';
                        $iconColor = '#14a398';
                        $iconBg = '#e6f7f6';
                        
                        if($notif->tipe === 'jadwal') {
                            $iconClass = 'fa-calendar-days';
                            $iconColor = '#f59e0b';
                            $iconBg = '#fef3e2';
                        } elseif ($notif->tipe === 'pemeriksaan') {
                            $iconClass = 'fa-stethoscope';
                            $iconColor = '#6366f1';
                            $iconBg = '#eef0ff';
                        }
                    @endphp
                    <div style="display: flex; gap: 16px; align-items: flex-start; padding: 16px; border-radius: 12px; border: 1px solid var(--slate-200); background: {{ $notif->is_read ? '#fff' : '#f0fdf4' }}; transition: background 0.2s;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: {{ $iconBg }}; color: {{ $iconColor }}; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                            <i class="fas {{ $iconClass }}"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 4px;">
                                <h4 style="font-size: 14px; font-weight: 700; color: var(--slate-800);">
                                    {{ $notif->judul }}
                                    @if(!$notif->is_read)
                                        <span class="badge badge-teal" style="font-size: 9px; padding: 1px 6px; margin-left: 6px;">Baru</span>
                                    @endif
                                </h4>
                                <span style="font-size: 11.5px; color: var(--slate-400);">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p style="font-size: 13px; color: var(--slate-600); line-height: 1.5; white-space: normal; word-break: break-word;">{{ $notif->pesan }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-wrapper">
                {{ $notifikasis->links('layouts.pagination') }}
            </div>
        @else
            <div style="text-align: center; padding: 40px 0; color: var(--slate-400);">
                <i class="fas fa-bell-slash" style="font-size: 40px; margin-bottom: 12px; color: var(--slate-300);"></i>
                <p>Belum ada notifikasi masuk untuk Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection
