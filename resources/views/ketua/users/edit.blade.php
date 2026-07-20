@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('ketua.users.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Edit: {{ $user->nama }}</span>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;">

  {{-- ── Form ── --}}
  <form method="POST" action="{{ route('ketua.users.update', $user) }}">
    @csrf
    @method('PUT')

    <div class="card">

      <div class="card-header">
        <div>
          <div class="card-title">Edit Data Pengguna</div>
          <div class="card-subtitle">{{ $user->nama }} · Terdaftar {{ $user->created_at->format('d M Y') }}</div>
        </div>
      </div>

      {{-- Data Akun --}}
      <div class="section-divider">Data Akun</div>
      <div class="form-section">

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="nama"
              class="form-control @error('nama') is-invalid @enderror"
              value="{{ old('nama', $user->nama) }}"
              placeholder="Nama lengkap">
            @error('nama')
              <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email"
              class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email', $user->email) }}"
              placeholder="email@domain.com">
            @error('email')
              <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">No HP / WhatsApp <span class="required">*</span></label>
            <input type="text" name="no_hp"
              class="form-control @error('no_hp') is-invalid @enderror"
              value="{{ old('no_hp', $user->no_hp) }}"
              placeholder="08xxxxxxxxxx"
              oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            @error('no_hp')
              <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
          </div>
        </div>

      </div>

      {{-- Ubah Password --}}
      <div class="section-divider">Ubah Password</div>
      <div class="form-section">

        <div style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:10px;padding:12px 14px;margin-bottom:16px;display:flex;gap:10px;font-size:13px;color:#92400e;">
          <i class="fas fa-info-circle" style="margin-top:1px;"></i>
          <span>Kosongkan password jika tidak ingin mengubah password.</span>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <div style="position:relative;">
              <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Kosongkan jika tidak diubah">
              <button type="button" class="toggle-pw" onclick="togglePw('password','eye1')">
                <i class="fas fa-eye" id="eye1"></i>
              </button>
            </div>
            @error('password')
              <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Password Baru</label>
            <div style="position:relative;">
              <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password baru">
              <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eye2')">
                <i class="fas fa-eye" id="eye2"></i>
              </button>
            </div>
            <div id="pw-match" style="font-size:12px;margin-top:4px;"></div>
          </div>
        </div>

      </div>

      <div class="form-footer">
        <a href="{{ route('ketua.users.index') }}" class="btn btn-outline">
          <i class="fas fa-times"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan
        </button>
      </div>

    </div>
  </form>

  {{-- ── Info Pengguna (sidebar) ── --}}
  <div class="card" style="position:sticky;top:80px;">
    <div class="card-header">
      <div class="card-title">Info Pengguna</div>
    </div>
    <div style="padding:20px;">

      @php
        $avatarBg = [
          'ketua' => 'linear-gradient(135deg,#a855f7,#7c3aed)',
          'kader' => 'linear-gradient(135deg,#14a398,#0e6660)',
          'bidan' => 'linear-gradient(135deg,#3b82f6,#1d4ed8)',
          'orang_tua' => 'linear-gradient(135deg,#f97316,#c2410c)',
        ][$user->role] ?? 'var(--teal-600)';
      @endphp

      <div style="text-align:center;">
        <div style="width:64px;height:64px;border-radius:16px;background:{{ $avatarBg }};display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:#fff;margin:0 auto 10px;">
          {{ strtoupper(substr($user->nama, 0, 1)) }}
        </div>
        <div style="font-size:15px;font-weight:700;color:var(--slate-800);">{{ $user->nama }}</div>
        <div style="font-size:12.5px;color:var(--slate-400);margin-top:2px;">{{ $user->email }}</div>
        <div style="font-size:12.5px;color:var(--slate-400);margin-top:2px;">{{ $user->no_hp ?? '-' }}</div>
      </div>

    </div>
  </div>

</div>

@push('styles')
<style>
.form-control.is-invalid { border-color: var(--rose-500); }
.form-error { font-size:12px; color:var(--rose-500); margin-top:4px; display:flex; align-items:center; gap:4px; }
.toggle-pw { position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:var(--slate-400); cursor:pointer; font-size:14px; }
.toggle-pw:hover { color:var(--teal-600); }
</style>
@endpush

@push('scripts')
<script>
function togglePw(id, iconId) {
  const el = document.getElementById(id);
  const ic = document.getElementById(iconId);
  el.type = el.type === 'password' ? 'text' : 'password';
  ic.className = el.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

document.getElementById('password_confirmation').addEventListener('input', function () {
  const pw = document.getElementById('password').value;
  const el = document.getElementById('pw-match');
  if (!this.value) { el.innerHTML = ''; return; }
  el.innerHTML = pw === this.value
    ? '<span style="color:#22c55e;"><i class="fas fa-check-circle"></i> Password cocok</span>'
    : '<span style="color:#ef4444;"><i class="fas fa-times-circle"></i> Password tidak cocok</span>';
});
</script>
@endpush

@endsection