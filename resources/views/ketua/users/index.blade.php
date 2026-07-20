@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('page_title', 'Kelola Pengguna')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-header-left">
        <h2>Kelola Pengguna</h2>
        <p>Manajemen akun Ketua Posyandu, Kader, Bidan, dan Orang Tua.</p>
    </div>
    <a href="{{ route('ketua.users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Tambah Pengguna
    </a>
</div>

{{-- STAT MINI --}}
<div class="users-stats-wrap" style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;">
    @foreach([
        ['role'=>'ketua', 'label'=>'Ketua',          'icon'=>'fa-shield-alt',  'bg'=>'#f3e8ff',        'color'=>'#7e22ce'],
        ['role'=>'kader', 'label'=>'Kader Posyandu', 'icon'=>'fa-user-nurse',  'bg'=>'var(--teal-100)','color'=>'var(--teal-700)'],
        ['role'=>'bidan', 'label'=>'Bidan',           'icon'=>'fa-stethoscope','bg'=>'#dbeafe',        'color'=>'#1d4ed8'],
        ['role'=>'orang_tua', 'label'=>'Orang Tua',   'icon'=>'fa-child',      'bg'=>'#ffedd5',        'color'=>'#ea580c'],
    ] as $s)
    <div style="background:#fff;border:1.5px solid var(--slate-200);border-radius:12px;padding:16px 20px;display:flex;align-items:center;gap:14px;">
        <div style="width:40px;height:40px;background:{{ $s['bg'] }};border-radius:10px;display:flex;align-items:center;justify-content:center;color:{{ $s['color'] }};font-size:16px;flex-shrink:0;">
            <i class="fas {{ $s['icon'] }}"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:700;color:var(--slate-800);">{{ $counts[$s['role']] ?? 0 }}</div>
            <div style="font-size:12px;color:var(--slate-500);">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- FILTER TABS --}}
<div class="tabs">
    <a href="{{ route('ketua.users.index') }}"                          class="tab {{ !request('role')          ? 'active':'' }}">Semua Pengguna</a>
    <a href="{{ route('ketua.users.index',['role'=>'ketua']) }}"        class="tab {{ request('role')==='ketua' ? 'active':'' }}">Ketua</a>
    <a href="{{ route('ketua.users.index',['role'=>'kader']) }}"        class="tab {{ request('role')==='kader' ? 'active':'' }}">Kader</a>
    <a href="{{ route('ketua.users.index',['role'=>'bidan']) }}"        class="tab {{ request('role')==='bidan' ? 'active':'' }}">Bidan</a>
    <a href="{{ route('ketua.users.index',['role'=>'orang_tua']) }}"    class="tab {{ request('role')==='orang_tua' ? 'active':'' }}">Orang Tua</a>
</div>

{{-- TABLE CARD --}}
<div class="card">
    <div class="card-header" style="flex-wrap:wrap;gap:10px;">
        <form method="GET" action="{{ route('ketua.users.index') }}" style="display:flex;gap:10px;flex:1;flex-wrap:wrap;align-items:center;">
            @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
            <div class="search-bar" style="width:280px;">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari nama atau email…" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-outline btn-sm"><i class="fas fa-search"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('ketua.users.index', request()->except('search')) }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>

    <div class="rt-wrap">
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:48px;" class="col-hide-mobile">No</th>
                    <th class="col-nama-data">Nama Pengguna</th>
                    <th class="col-hide-mobile">Email</th>
                    <th class="col-hide-mobile">Kontak</th>
                    <th class="col-hide-mobile">Jabatan</th>
                    <th class="col-hide-mobile">Terdaftar</th>
                    <th class="col-hide-mobile">Status</th>
                    <th style="width:120px;" class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                    @php
                        $rc = [
                            'ketua' => ['label'=>'Ketua',         'badge'=>'badge-purple','icon'=>'fa-shield-alt', 'bg'=>'linear-gradient(135deg,#a855f7,#7c3aed)'],
                            'kader' => ['label'=>'Kader Posyandu','badge'=>'badge-teal',  'icon'=>'fa-user-nurse', 'bg'=>'linear-gradient(135deg,#14a398,#0e6660)'],
                            'bidan' => ['label'=>'Bidan',          'badge'=>'badge-blue',  'icon'=>'fa-stethoscope','bg'=>'linear-gradient(135deg,#3b82f6,#1d4ed8)'],
                            'orang_tua' => ['label'=>'Orang Tua',  'badge'=>'badge-orange','icon'=>'fa-child',      'bg'=>'linear-gradient(135deg,#f97316,#c2410c)'],
                        ][$user->role] ?? ['label'=>$user->role,'badge'=>'badge-orange','icon'=>'fa-user','bg'=>'var(--slate-400)'];
                    @endphp
                    <tr>
                        <td style="color:var(--slate-400);font-size:12px;font-weight:600;" class="col-hide-mobile">
                            {{ ($users->currentPage()-1)*$users->perPage()+$i+1 }}
                        </td>
                        <td class="col-nama-data">
                            <div class="cell-with-avatar">
                                <div class="avatar-table" style="background:{{ $rc['bg'] }}">{{ strtoupper(substr($user->nama,0,1)) }}</div>
                                <div>
                                    <div class="cell-name">
                                        {{ $user->nama }}
                                        @if($user->id===auth()->id())
                                            <span style="font-size:10px;background:var(--teal-100);color:var(--teal-700);padding:1px 7px;border-radius:10px;font-weight:700;margin-left:4px;">Anda</span>
                                        @endif
                                    </div>
                                    <div class="cell-meta">ID: #{{ str_pad($user->id,4,'0',STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13.5px;color:var(--slate-700);" class="col-hide-mobile">{{ $user->email }}</td>
                        <td style="font-size:13.5px;color:var(--slate-700);" class="col-hide-mobile">{{ $user->no_hp ?? '-' }}</td>
                        <td class="col-hide-mobile"><span class="badge {{ $rc['badge'] }}"><i class="fas {{ $rc['icon'] }}"></i> {{ $rc['label'] }}</span></td>
                        <td class="col-hide-mobile">
                            <div class="cell-name">{{ $user->created_at->translatedFormat('d F Y') }}</div>
                            <div class="cell-meta">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="col-hide-mobile"><span class="badge badge-green"><span style="width:6px;height:6px;background:#22c55e;border-radius:50%;display:inline-block;"></span> Aktif</span></td>
                        <td class="col-aksi">
                            <div style="display:flex;justify-content:center;gap:6px;">
                                <a href="#" class="btn btn-view btn-sm" title="Detail"
                                   data-title="{{ $user->nama }}"
                                   data-detail="{{ json_encode([
                                     'Nama Lengkap' => $user->nama,
                                     'Email' => $user->email,
                                     'No. HP' => $user->no_hp ?? '-',
                                     'Jabatan' => $rc['label'],
                                     'Terdaftar' => $user->created_at->translatedFormat('d F Y'),
                                     'Status' => 'Aktif'
                                   ]) }}"
                                   onclick="handleDetail(event, this.getAttribute('data-title'), JSON.parse(this.getAttribute('data-detail')))"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('ketua.users.edit',$user->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id!==auth()->id())
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                        onclick="openDeleteModal({{ $user->id }},'{{ addslashes($user->nama) }}','{{ $rc['label'] }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm" style="background:var(--slate-100);color:var(--slate-300);cursor:not-allowed;" disabled title="Tidak bisa hapus akun sendiri">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>Belum ada pengguna</h3>
                            <p>Klik "Tambah Pengguna" untuk membuat akun baru.</p>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ═══ MOBILE CARD LIST ═══ --}}
    <div class="mobile-list" style="padding:10px 14px;">
        @forelse($users as $i => $user)
        @php
            $rc = [
                'ketua'     => ['label'=>'Ketua',         'badge'=>'badge-purple','icon'=>'fa-shield-alt', 'bg'=>'linear-gradient(135deg,#a855f7,#7c3aed)'],
                'kader'     => ['label'=>'Kader Posyandu','badge'=>'badge-teal',  'icon'=>'fa-user-nurse', 'bg'=>'linear-gradient(135deg,#14a398,#0e6660)'],
                'bidan'     => ['label'=>'Bidan',          'badge'=>'badge-blue',  'icon'=>'fa-stethoscope','bg'=>'linear-gradient(135deg,#3b82f6,#1d4ed8)'],
                'orang_tua' => ['label'=>'Orang Tua',     'badge'=>'badge-orange','icon'=>'fa-child',      'bg'=>'linear-gradient(135deg,#f97316,#c2410c)'],
            ][$user->role] ?? ['label'=>$user->role,'badge'=>'badge-orange','icon'=>'fa-user','bg'=>'var(--slate-400)'];
            $no = ($users->currentPage()-1)*$users->perPage()+$i+1;
        @endphp
        <div class="rec-card">
            <div class="rec-card-header">
                <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                    <div class="avatar-table" style="background:{{ $rc['bg'] }};flex-shrink:0;">{{ strtoupper(substr($user->nama,0,1)) }}</div>
                    <div style="min-width:0;">
                        <div class="rec-name">
                            {{ $user->nama }}
                            @if($user->id===auth()->id())
                                <span style="font-size:10px;background:var(--teal-100);color:var(--teal-700);padding:1px 6px;border-radius:8px;font-weight:700;margin-left:4px;">Anda</span>
                            @endif
                        </div>
                        <div class="rec-sub"><span class="badge {{ $rc['badge'] }}" style="font-size:10px;padding:1px 6px;"><i class="fas {{ $rc['icon'] }}"></i> {{ $rc['label'] }}</span></div>
                    </div>
                </div>
                <div class="rec-actions">
                    <span class="no-badge">#{{ $no }}</span>
                    <a href="{{ route('ketua.users.edit',$user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    @if($user->id!==auth()->id())
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="openDeleteModal({{ $user->id }},'{{ addslashes($user->nama) }}','{{ $rc['label'] }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endif
                </div>
            </div>
            <hr class="rec-divider">
            <div class="rec-grid">
                <div class="rec-field" style="grid-column:span 2;">
                    <label>Email</label>
                    <div class="val" style="font-weight:400;word-break:break-all;">{{ $user->email }}</div>
                </div>
                <div class="rec-field">
                    <label>No. HP</label>
                    <div class="val">{{ $user->no_hp ?? '-' }}</div>
                </div>
                <div class="rec-field">
                    <label>Terdaftar</label>
                    <div class="val" style="font-weight:400;">{{ $user->created_at->translatedFormat('d F Y') }}</div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h3>Belum ada pengguna</h3>
            <p>Klik "Tambah Pengguna" untuk membuat akun baru.</p>
        </div>
        @endforelse
    </div>
    </div>{{-- end rt-wrap --}}

    @if($users->hasPages())
        <div class="pagination-wrapper">
            <span class="page-info">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna</span>
            {{ $users->links('layouts.pagination') }}
        </div>
    @endif
</div>

{{-- ══════════ MODAL HAPUS ══════════ --}}
<div id="modalDelete" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(15,23,42,.55);backdrop-filter:blur(4px);" onclick="closeDeleteModal()"></div>
    <div class="modal-box" style="background:linear-gradient(135deg,#991b1b,#dc2626);">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Pengguna</h3>
        <p>Tindakan ini tidak dapat dibatalkan</p>
    </div>
    <div class="modal-body">
        <div class="modal-info" style="background:#fee2e2;border-color:#fecaca;">
            <p style="font-size:13px;color:#991b1b;margin-bottom:8px;">Akun berikut akan dihapus permanen:</p>
            <div style="display:flex;align-items:center;gap:10px;">
                <div id="dAvatar" class="modal-avatar" style="background:linear-gradient(135deg,#f87171,#dc2626);"></div>
                <div>
                    <div id="dNama" style="font-weight:700;font-size:14px;color:#1e293b;"></div>
                    <div id="dRole" style="font-size:12px;color:#94a3b8;"></div>
                </div>
            </div>
        </div>
        <p style="font-size:12px;color:#94a3b8;margin-bottom:18px;text-align:center;">
            <i class="fas fa-exclamation-triangle" style="color:#f59e0b;"></i>
            User tidak akan bisa login setelah dihapus.
        </p>
        <div style="display:flex;gap:10px;">
            <button onclick="closeDeleteModal()" class="btn btn-outline" style="flex:1;justify-content:center;"><i class="fas fa-times"></i> Batal</button>
            <form id="formDelete" method="POST" style="flex:1;">
                @csrf @method('DELETE')
                <button type="submit" class="btn" style="width:100%;justify-content:center;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;box-shadow:0 4px 14px rgba(220,38,38,.3);">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .empty-state{text-align:center;padding:48px 20px;color:var(--slate-400);}
    .empty-state i{font-size:40px;margin-bottom:12px;display:block;opacity:.4;}
    .empty-state h3{font-size:15px;font-weight:700;color:var(--slate-500);margin-bottom:6px;}
    .empty-state p{font-size:13px;}
    .data-table th,.data-table td{text-align:center;vertical-align:middle;}
    .data-table td:nth-child(2),.data-table th:nth-child(2){text-align:left;}
    .modal-box{position:relative;padding:28px 28px 20px;text-align:center;color:#fff;border-radius:20px 20px 0 0;}
    .modal-icon{width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 12px;border:1.5px solid rgba(255,255,255,.2);}
    .modal-box h3{font-size:17px;font-weight:700;margin-bottom:4px;}
    .modal-box p{font-size:12.5px;opacity:.8;}
    .modal-body{position:relative;background:#fff;border-radius:0 0 20px 20px;padding:22px 24px 24px;width:100%;max-width:400px;margin:0 20px;}
    .modal-info{border:1.5px solid;border-radius:10px;padding:14px 16px;margin-bottom:16px;}
    .modal-avatar{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;flex-shrink:0;}
    #modalDelete{flex-direction:column;}
    #modalDelete > div:nth-child(2),#modalDelete > div:nth-child(3){max-width:400px;width:calc(100% - 40px);}
    #modalDelete > div:nth-child(2){position:relative;z-index:1;margin:20px 20px 0;}
    #modalDelete > div:nth-child(3){margin:0 20px 20px;}
    @keyframes modalIn{from{opacity:0;transform:scale(.95) translateY(10px);}to{opacity:1;transform:scale(1) translateY(0);}}
    #modalDelete .modal-box,#modalDelete .modal-body{animation:modalIn .22s ease;}
</style>
@endpush

@push('scripts')
<script>
function openDeleteModal(id, nama, role) {
    document.getElementById('dAvatar').textContent = nama.charAt(0).toUpperCase();
    document.getElementById('dNama').textContent   = nama;
    document.getElementById('dRole').textContent   = role;
    document.getElementById('formDelete').action   = '/ketua/users/' + id;
    const m = document.getElementById('modalDelete');
    m.style.display = 'flex'; document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('modalDelete').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeDeleteModal(); }
});
</script>
@endpush

@endsection