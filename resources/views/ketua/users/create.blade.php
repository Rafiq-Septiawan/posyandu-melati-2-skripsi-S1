@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')

@section('content')

<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
  <a href="{{ route('ketua.users.index') }}" class="btn btn-outline btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span style="color:var(--slate-400);font-size:13px;">/ Tambah Pengguna Baru</span>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:16px;align-items:start;">

  {{-- FORM UTAMA --}}
  <form method="POST" action="{{ route('ketua.users.store') }}" id="formUser">
  @csrf
    <div class="card">
      <div class="card-header">
        <div>
          <div class="card-title">Buat Akun Pengguna Baru</div>
          <div class="card-subtitle">Isi data login untuk Ketua, Kader, Bidan, atau Orang Tua</div>
        </div>
      </div>

      <div class="section-divider">Pilih Jabatan</div>
      <div class="form-section">
        <div class="form-group">
          <label class="form-label">Jabatan <span class="required">*</span></label>
          <div class="role-picker">
            <label class="role-option {{ old('role')==='ketua' ? 'selected' : '' }}" id="role-ketua">
              <input type="radio" name="role" value="ketua"
                     {{ old('role')==='ketua' ? 'checked' : '' }}
                     onchange="pickRole('ketua')">
              <div class="role-icon" style="background:#f3e8ff;color:#7e22ce;">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="role-label">Ketua</div>
              <div class="role-desc">Akses penuh ke semua fitur</div>
            </label>

            <label class="role-option {{ old('role','kader')==='kader' ? 'selected' : '' }}" id="role-kader">
              <input type="radio" name="role" value="kader"
                     {{ old('role','kader')==='kader' ? 'checked' : '' }}
                     onchange="pickRole('kader')">
              <div class="role-icon" style="background:var(--teal-100);color:var(--teal-700);">
                <i class="fas fa-user-nurse"></i>
              </div>
              <div class="role-label">Kader Posyandu</div>
              <div class="role-desc">Pemeriksaan awal ibu & balita</div>
            </label>

            <label class="role-option {{ old('role')==='bidan' ? 'selected' : '' }}" id="role-bidan">
              <input type="radio" name="role" value="bidan"
                     {{ old('role')==='bidan' ? 'checked' : '' }}
                     onchange="pickRole('bidan')">
              <div class="role-icon" style="background:#dbeafe;color:#1d4ed8;">
                <i class="fas fa-stethoscope"></i>
              </div>
              <div class="role-label">Bidan</div>
              <div class="role-desc">Pemeriksaan lanjutan & diagnosa</div>
            </label>

            <label class="role-option {{ old('role')==='orang_tua' ? 'selected' : '' }}" id="role-orang_tua">
              <input type="radio" name="role" value="orang_tua"
                     {{ old('role')==='orang_tua' ? 'checked' : '' }}
                     onchange="pickRole('orang_tua')">
              <div class="role-icon" style="background:#ffedd5;color:#ea580c;">
                <i class="fas fa-child"></i>
              </div>
              <div class="role-label">Orang Tua</div>
              <div class="role-desc">Melihat riwayat pemeriksaan ibu & balita</div>
            </label>
          </div>
          @error('role')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
        </div>
      </div>

    <div class="section-divider">Data Akun</div>
    <div class="form-section">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="name">
            Nama Lengkap <span class="required">*</span>
          </label>
          <input type="text" id="nama" name="nama"
                 class="form-control @error('nama') is-invalid @enderror"
                 placeholder="Contoh: Bidan Sari Dewi"
                 value="{{ old('nama') }}" autofocus
                 oninput="updatePreview()">
          @error('nama')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="email">
            Email <span class="required">*</span>
          </label>
          <input type="email" id="email" name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 placeholder="nama@posyandu-melati2.id"
                 value="{{ old('email') }}"
                 oninput="updatePreview()">
          @error('email')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="no_hp">
            No HP / WhatsApp <span class="required">*</span>
          </label>
          <input type="text"
                id="no_hp"
                name="no_hp"
                class="form-control @error('no_hp') is-invalid @enderror"
                placeholder="08xxxxxxxxxx"
                value="{{ old('no_hp') }}"
                oninput="updatePreview()">
          @error('no_hp')
            <div class="form-error">
              <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="password">
            Password <span class="required">*</span>
          </label>
          <div style="position:relative;">
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Minimal 8 karakter">
            <button type="button" class="toggle-pw" onclick="togglePw('password','eye1')">
              <i class="fas fa-eye" id="eye1"></i>
            </button>
          </div>
          @error('password')
            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
          @enderror
          <div id="pw-strength" style="margin-top:6px;"></div>
        </div>
        <div class="form-group">
          <label class="form-label" for="password_confirmation">
            Konfirmasi Password <span class="required">*</span>
          </label>
          <div style="position:relative;">
            <input type="password" id="password_confirmation"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Ulangi password">
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
        <i class="fas fa-user-plus"></i> Buat Akun
      </button>
    </div>
  </div>
  </form>

  {{-- PREVIEW CARD --}}
  <div>
    <div class="card" style="position:sticky;top:80px;">
      <div class="card-header">
        <div class="card-title">Preview Akun</div>
      </div>
      <div style="padding:20px;">
        {{-- Avatar --}}
        <div style="text-align:center;margin-bottom:16px;">
          <div id="prev-avatar"
               style="width:72px;height:72px;border-radius:18px;background:var(--teal-100);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:var(--teal-700);margin:0 auto 10px;">
            ?
          </div>
          <div id="prev-name" style="font-size:16px;font-weight:700;color:var(--slate-800);">—</div>
          <div id="prev-email" style="font-size:12.5px;color:var(--slate-400);margin-top:2px;">—</div>
        </div>

        {{-- Role Badge --}}
        <div style="text-align:center;margin-bottom:16px;">
          <span id="prev-role-badge" class="badge badge-teal">
            <i class="fas fa-user-nurse"></i> Kader Posyandu
          </span>
        </div>

        {{-- Akses Info --}}
        <div id="prev-akses" style="background:var(--slate-50);border-radius:10px;padding:12px 14px;">
          <div style="font-size:11px;font-weight:700;color:var(--slate-400);text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;">Hak Akses</div>
          <ul id="akses-list" style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:6px;font-size:12.5px;color:var(--slate-600);">
            <li><i class="fas fa-check" style="color:#22c55e;margin-right:6px;"></i>Dashboard Kader</li>
            <li><i class="fas fa-check" style="color:#22c55e;margin-right:6px;"></i>Lihat Data Ibu Hamil & Balita</li>
            <li><i class="fas fa-check" style="color:#22c55e;margin-right:6px;"></i>Pemeriksaan Awal Ibu Hamil</li>
            <li><i class="fas fa-check" style="color:#22c55e;margin-right:6px;"></i>Pemeriksaan Awal Balita</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>{{-- /grid --}}

@push('styles')
<style>
.form-control.is-invalid{border-color:var(--rose-500);box-shadow:0 0 0 3px rgba(244,63,94,.1);}
.form-error{font-size:12px;color:var(--rose-500);margin-top:4px;display:flex;align-items:center;gap:4px;}
.toggle-pw{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--slate-400);cursor:pointer;font-size:14px;transition:color .2s;}
.toggle-pw:hover{color:var(--teal-600);}

/* Role Picker */
.role-picker{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px;}
.role-option{display:flex;flex-direction:column;align-items:center;text-align:center;gap:8px;padding:16px 12px;border:2px solid var(--slate-200);border-radius:12px;cursor:pointer;transition:all .2s;background:var(--white);}
.role-option input[type="radio"]{display:none;}
.role-option:hover{border-color:var(--slate-300);background:var(--slate-50);}
.role-option.selected{border-color:var(--teal-400);background:var(--teal-50);}
.role-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;}
.role-label{font-size:13px;font-weight:700;color:var(--slate-700);}
.role-desc{font-size:11px;color:var(--slate-400);line-height:1.4;}
</style>
@endpush

@push('scripts')
<script>
const aksesMap = {
  ketua: [
    'Dashboard Ketua',
    'Kelola Semua Pengguna',
    'Data Ibu Hamil & Balita',
    'Semua Laporan & Cetak',
  ],
  kader: [
    'Dashboard Kader',
    'Lihat Data Ibu Hamil & Balita',
    'Pemeriksaan Awal Ibu Hamil',
    'Pemeriksaan Awal Balita',
    'Laporan Pemeriksaan & Cetak',
  ],
  bidan: [
    'Dashboard Bidan',
    'Lihat Data Ibu Hamil & Balita',
    'Pemeriksaan Lanjutan Ibu Hamil',
    'Pemeriksaan Lanjutan Balita',
    'Laporan Pemeriksaan & Cetak',
  ],
  orang_tua: [
    'Dashboard Orang Tua',
    'Lihat Riwayat Ibu Hamil Sendiri',
    'Lihat Riwayat Balita Sendiri',
    'Menerima Notifikasi Jadwal',
  ],
};
const badgeMap = {
  ketua: '<i class="fas fa-shield-alt"></i> Ketua',
  kader: '<i class="fas fa-user-nurse"></i> Kader Posyandu',
  bidan: '<i class="fas fa-stethoscope"></i> Bidan',
  orang_tua: '<i class="fas fa-child"></i> Orang Tua',
};
const badgeClassMap = {
  ketua: 'badge badge-purple',
  kader: 'badge badge-teal',
  bidan: 'badge badge-blue',
  orang_tua: 'badge badge-orange',
};
const avatarBgMap = {
  ketua: 'linear-gradient(135deg,#a855f7,#7c3aed)',
  kader: 'linear-gradient(135deg,#14a398,#0e6660)',
  bidan: 'linear-gradient(135deg,#3b82f6,#1d4ed8)',
  orang_tua: 'linear-gradient(135deg,#f97316,#c2410c)',
};

let currentRole = '{{ old('role', 'kader') }}';

function pickRole(role) {
  currentRole = role;
  document.querySelectorAll('.role-option').forEach(el => el.classList.remove('selected'));
  document.getElementById('role-' + role).classList.add('selected');
  updatePreview();
}

function updatePreview() {
  const name  = document.getElementById('nama').value || '—';
  const email = document.getElementById('email').value || '—';
  const init  = name !== '—' ? name.charAt(0).toUpperCase() : '?';

  document.getElementById('prev-avatar').textContent = init;
  document.getElementById('prev-avatar').style.background = avatarBgMap[currentRole] || 'var(--teal-100)';
  document.getElementById('prev-avatar').style.color = '#fff';
  document.getElementById('prev-name').textContent = name;
  document.getElementById('prev-email').textContent = email;

  const badge = document.getElementById('prev-role-badge');
  badge.className = 'badge ' + (badgeClassMap[currentRole] || 'badge-teal');
  badge.innerHTML = badgeMap[currentRole] || currentRole;

  const list = document.getElementById('akses-list');
  list.innerHTML = (aksesMap[currentRole] || []).map(a =>
    '<li><i class="fas fa-check" style="color:#22c55e;margin-right:6px;"></i>' + a + '</li>'
  ).join('');
}

// Password strength
document.getElementById('password').addEventListener('input', function() {
  const val = this.value;
  const el = document.getElementById('pw-strength');
  if (!val) { el.innerHTML=''; return; }
  let strength = 0;
  if (val.length >= 8) strength++;
  if (/[A-Z]/.test(val)) strength++;
  if (/[0-9]/.test(val)) strength++;
  if (/[^A-Za-z0-9]/.test(val)) strength++;
  const labels = ['','Lemah','Cukup','Kuat','Sangat Kuat'];
  const colors = ['','#ef4444','#f59e0b','#22c55e','#16a34a'];
  el.innerHTML = `<div style="display:flex;align-items:center;gap:8px;">
    <div style="display:flex;gap:3px;">${[1,2,3,4].map(n=>`<div style="width:32px;height:4px;border-radius:2px;background:${n<=strength?colors[strength]:'var(--slate-200)'};"></div>`).join('')}</div>
    <span style="font-size:11.5px;font-weight:600;color:${colors[strength]};">${labels[strength]}</span>
  </div>`;
  checkMatch();
});

document.getElementById('password_confirmation').addEventListener('input', checkMatch);

function checkMatch() {
  const pw  = document.getElementById('password').value;
  const pw2 = document.getElementById('password_confirmation').value;
  const el  = document.getElementById('pw-match');
  if (!pw2) { el.innerHTML=''; return; }
  if (pw === pw2) {
    el.innerHTML='<span style="color:#22c55e;"><i class="fas fa-check-circle"></i> Password cocok</span>';
  } else {
    el.innerHTML='<span style="color:#ef4444;"><i class="fas fa-times-circle"></i> Password tidak cocok</span>';
  }
}

function togglePw(id, iconId) {
  const el = document.getElementById(id);
  const ic = document.getElementById(iconId);
  if (el.type==='password') { el.type='text'; ic.className='fas fa-eye-slash'; }
  else { el.type='password'; ic.className='fas fa-eye'; }
}

// Init
pickRole(currentRole);
</script>
@endpush

@endsection