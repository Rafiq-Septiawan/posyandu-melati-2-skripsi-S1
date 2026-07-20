<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Akun — Posyandu Melati 2</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'DM Sans', sans-serif;
  min-height: 100vh;
  min-height: 100dvh;
  display: flex;
  background: #0d3b38;
}

/* ── LEFT PANEL ── */
.left-panel {
  width: 48%;
  background: linear-gradient(150deg, #0d3b38 0%, #0f8075 50%, #2ec4b6 100%);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: clamp(24px, 5vh, 52px) clamp(24px, 3vw, 48px);
  position: relative;
  overflow: hidden;
}

.deco-circle { position:absolute; border-radius:50%; background:rgba(255,255,255,.05); }
.deco-1 { width:400px; height:400px; top:-100px; left:-120px; }
.deco-2 { width:280px; height:280px; bottom:-80px; right:-60px; }
.deco-3 { width:150px; height:150px; top:50%; left:60%; background:rgba(255,255,255,.08); }

/* ── FIX: Logo desktop lebih besar ── */
.left-logo {
  width: clamp(80px, 9vw, 130px);
  height: clamp(80px, 9vw, 130px);
  background: #fff;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: clamp(16px, 3vh, 32px);
  border: 1.5px solid rgba(255,255,255,.2);
  box-shadow: 0 8px 32px rgba(0,0,0,.15);
  animation: floatBlob 4s ease-in-out infinite;
  padding: 2px;
}

.left-title {
  font-family: 'Merriweather', serif;
  font-size: clamp(22px, 3vw, 30px);
  color: #fff;
  text-align: center;
  line-height: 1.3;
  margin-bottom: clamp(8px, 1.5vh, 12px);
}
.left-title span { color: #a0ebe6; }

.left-subtitle {
  font-size: clamp(12px, 1.2vw, 15px);
  color: rgba(255,255,255,.7);
  text-align: center;
  line-height: 1.7;
  max-width: 320px;
  margin-bottom: clamp(20px, 3.5vh, 40px);
}

.feature-cards { display:flex; flex-direction:column; gap:10px; width:100%; max-width:320px; }
.feature-card {
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 12px;
  padding: clamp(10px, 1.5vh, 14px) 16px;
  display: flex; align-items: center; gap: 12px;
  backdrop-filter: blur(6px);
  transition: background .2s;
}
.feature-card:hover { background: rgba(255,255,255,.15); }
.feature-icon { width:32px; height:32px; background:rgba(255,255,255,.15); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:14px; color:#a0ebe6; flex-shrink:0; }
.feature-text strong { display:block; font-size:clamp(12px,1.1vw,13.5px); font-weight:600; color:#fff; }
.feature-text span { font-size:clamp(11px,1vw,12px); color:rgba(255,255,255,.6); }

/* ── MOBILE HEADER (logo di mobile) ── */
.mobile-header {
  display: none;
  flex-direction: column;
  align-items: center;
  margin-bottom: 28px;
  padding-top: 8px;
}
.mobile-logo-wrap {
  width: 80px;
  height: 80px;
  background: #fff;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  border: 2px solid #e2e8f0;
  box-shadow: 0 4px 20px rgba(15,128,117,.18);
  margin-bottom: 12px;
  padding: 3px;
}
.mobile-logo-wrap img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  border-radius: 50%;
  mix-blend-mode: multiply;
}
.mobile-brand-name {
  font-family: 'Merriweather', serif;
  font-size: 18px;
  font-weight: 700;
  color: #0d3b38;
  text-align: center;
  line-height: 1.3;
}
.mobile-brand-name span {
  color: #0f8075;
}
.mobile-brand-sub {
  font-size: 12px;
  color: #64748b;
  text-align: center;
  margin-top: 4px;
}

@keyframes floatBlob {
  0%,100% { transform: translateY(0); }
  50%      { transform: translateY(-10px); }
}

/* ── RIGHT PANEL ── */
.right-panel {
  flex: 1;
  background: #f5f7fa;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: clamp(24px, 4vh, 48px) clamp(20px, 4vw, 60px);
  overflow-y: auto;
}
.form-card {
  width: 100%;
  max-width: 440px;
  background: #fff;
  border-radius: 20px;
  padding: clamp(28px, 4vh, 44px) clamp(24px, 3vw, 40px);
  box-shadow: 0 8px 40px rgba(0,0,0,.09);
}
.form-card h2 {
  font-family: 'Merriweather', serif;
  font-size: clamp(18px, 2vw, 24px);
  color: #0d3b38;
  margin-bottom: 6px;
}
.form-card .subtitle {
  font-size: 13.5px;
  color: #6b7280;
  margin-bottom: 28px;
}
.form-group { margin-bottom: 18px; }
.form-group label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 7px;
}
.input-wrap { position: relative; }
.input-wrap i.prefix {
  position: absolute;
  left: 14px; top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  font-size: 14px;
  pointer-events: none;
}
.input-wrap input {
  width: 100%;
  padding: 11px 14px 11px 40px;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  font-size: 14px;
  font-family: inherit;
  color: #111827;
  outline: none;
  transition: border-color .2s;
  background: #fafafa;
}
.input-wrap input:focus { border-color: #0f8075; background: #fff; }
.input-wrap .toggle-eye {
  position: absolute;
  right: 14px; top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #9ca3af;
  font-size: 14px;
  border: none; background: none;
  padding: 0;
}
.input-wrap .toggle-eye:hover { color: #0f8075; }

.error-msg {
  color: #e53e3e;
  font-size: 12px;
  margin-top: 5px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.alert-error {
  background: #fff5f5;
  border: 1px solid #fed7d7;
  border-radius: 10px;
  padding: 12px 14px;
  margin-bottom: 20px;
  font-size: 13px;
  color: #c53030;
  display: flex;
  align-items: flex-start;
  gap: 9px;
}

.btn-register {
  width: 100%;
  padding: 13px;
  background: linear-gradient(135deg, #0d3b38, #0f8075);
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 600;
  font-family: inherit;
  cursor: pointer;
  transition: opacity .2s, transform .1s;
  margin-top: 6px;
}
.btn-register:hover { opacity: .92; }
.btn-register:active { transform: scale(.99); }

.login-link {
  text-align: center;
  margin-top: 20px;
  font-size: 13px;
  color: #6b7280;
}
.login-link a { color: #0f8075; font-weight: 600; text-decoration: none; }
.login-link a:hover { text-decoration: underline; }

.note-box {
  background: #f0fdf9;
  border: 1px solid #6ee7b7;
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 12.5px;
  color: #065f46;
  margin-bottom: 22px;
  display: flex;
  gap: 9px;
  align-items: flex-start;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
  .left-panel { display: none; }

  .right-panel {
    padding: 24px 20px 32px;
    justify-content: flex-start;
    background: linear-gradient(180deg, #edfaf9 0%, #f8fafc 120px);
  }
  .mobile-header {
    display: flex;
  }
  .mobile-divider {
    width: 100%;
    max-width: 440px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #cbd5e1, transparent);
    margin-bottom: 24px;
  }
  .form-card {
    max-width: 100%;
    padding: clamp(20px, 3vh, 32px) clamp(16px, 2.5vw, 24px);
    box-shadow: 0 4px 20px rgba(0,0,0,.05);
  }
}
</style>
</head>
<body>

<!-- LEFT PANEL -->
<div class="left-panel">
  <div class="deco-circle deco-1"></div>
  <div class="deco-circle deco-2"></div>
  <div class="deco-circle deco-3"></div>
  <div class="left-logo">
    <img src="{{ asset('images/LOGO_POSYANDU.png') }}" alt="Logo Posyandu Melati 2"
         style="width:100%;height:100%;object-fit:contain;border-radius:50%;mix-blend-mode:multiply;">
  </div>
  <div class="left-title">Posyandu<br><span>Melati 2</span></div>
  <p class="left-subtitle">Sistem informasi pencatatan data ibu hamil dan balita berbasis web yang modern dan terintegrasi.</p>
  <div class="feature-cards">
    <div class="feature-card">
      <div class="feature-icon"><i class="fas fa-person-pregnant"></i></div>
      <div class="feature-text"><strong>Data Ibu Hamil</strong><span>Pantau kesehatan ibu hamil secara berkala</span></div>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><i class="fas fa-baby"></i></div>
      <div class="feature-text"><strong>Tumbuh Kembang Balita</strong><span>Catat BB, TB, dan status gizi balita</span></div>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
      <div class="feature-text"><strong>Laporan Otomatis</strong><span>Generate laporan PDF & Excel seketika</span></div>
    </div>
  </div>
</div>

<!-- RIGHT PANEL -->
<div class="right-panel">
  <div class="mobile-header">
    <div class="mobile-logo-wrap">
      <img src="{{ asset('images/LOGO_POSYANDU.png') }}" alt="Logo Posyandu Melati 2">
    </div>
    <div class="mobile-brand-name">Posyandu <span>Melati 2</span></div>
    <div class="mobile-brand-sub">Sistem Informasi Pencatatan Ibu Hamil & Balita</div>
  </div>
  <div class="mobile-divider"></div>

  <div class="form-card">
    <h2>Buat Akun Baru</h2>
    <p class="subtitle">Pendaftaran untuk Orang Tua / Wali</p>

    @if($errors->any())
    <div class="alert-error">
      <i class="fas fa-circle-exclamation" style="margin-top:1px;flex-shrink:0"></i>
      <div>
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    </div>
    @endif

    <div class="note-box">
      <i class="fas fa-circle-info" style="flex-shrink:0;margin-top:1px"></i>
      <span>Gunakan <strong>nomor WhatsApp aktif</strong> sebagai username login Anda.</span>
    </div>

    <form action="{{ route('register.process') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <div class="input-wrap">
          <i class="fas fa-user prefix"></i>
          <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
                 value="{{ old('nama') }}" autocomplete="name" required>
        </div>
        @error('nama')
          <div class="error-msg"><i class="fas fa-triangle-exclamation"></i>{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="no_hp">Nomor WhatsApp</label>
        <div class="input-wrap">
          <i class="fas fa-phone prefix"></i>
          <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789"
                 value="{{ old('no_hp') }}" autocomplete="tel" required>
        </div>
        @error('no_hp')
          <div class="error-msg"><i class="fas fa-triangle-exclamation"></i>{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock prefix"></i>
          <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                 autocomplete="new-password" required>
          <button type="button" class="toggle-eye" onclick="togglePassword('password', this)" tabindex="-1">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
        @error('password')
          <div class="error-msg"><i class="fas fa-triangle-exclamation"></i>{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock prefix"></i>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 placeholder="Ulangi password" autocomplete="new-password" required>
          <button type="button" class="toggle-eye" onclick="togglePassword('password_confirmation', this)" tabindex="-1">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-register">
        <i class="fas fa-user-plus" style="margin-right:8px"></i>Daftar Sekarang
      </button>
    </form>

    <div class="login-link">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
  </div>
</div>

<script>
function togglePassword(fieldId, btn) {
  const input = document.getElementById(fieldId);
  const icon = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('fa-eye-slash', 'fa-eye');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye', 'fa-eye-slash');
  }
}
</script>
</body>
</html>
