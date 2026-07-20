<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Posyandu Melati 2</title>
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

/* ── RIGHT PANEL ── */
.right-panel {
  flex: 1;
  background: #f8fafc;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: clamp(24px, 5vh, 60px) clamp(24px, 3vw, 48px);
  position: relative;
}
.right-panel::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 4px;
  background: linear-gradient(90deg, #2ec4b6, #0f8075);
}

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

.login-box { width:100%; max-width:420px; animation: fadeUp .4s ease; }
.login-header { margin-bottom: clamp(16px, 3vh, 32px); }
.login-greeting { font-size:13px; font-weight:600; color:#0f8075; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
.login-title { font-size:clamp(20px, 2.5vw, 26px); font-weight:700; color:#1e293b; }

/* Alert */
.alert-error {
  background: #fff5f5;
  border-left: 4px solid #ef4444;
  border-radius: 10px;
  padding: 14px 16px;
  margin-bottom: 20px;
  animation: slideDown .3s cubic-bezier(.34,1.56,.64,1);
}
.alert-success-box {
  background: #f0fdf4;
  border-left: 4px solid #22c55e;
  border-radius: 10px;
  padding: 14px 16px;
  margin-bottom: 20px;
  animation: slideDown .3s cubic-bezier(.34,1.56,.64,1);
}
.alert-inner { display:flex; align-items:center; gap:12px; width:100%; }
.alert-icon-wrap { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.alert-icon-wrap.red   { background:#fee2e2; }
.alert-icon-wrap.green { background:#dcfce7; }
.alert-icon-wrap.red   i { color:#ef4444; font-size:13px; }
.alert-icon-wrap.green i { color:#16a34a; font-size:13px; }
.alert-body { flex:1; }
.alert-title { font-size:13px; font-weight:700; margin-bottom:2px; }
.alert-title.red   { color:#991b1b; }
.alert-title.green { color:#166534; }
.alert-msg { font-size:12.5px; line-height:1.5; }
.alert-msg.red   { color:#b91c1c; }
.alert-msg.green { color:#15803d; }
.alert-close { background:none; border:none; font-size:13px; cursor:pointer; padding:2px; flex-shrink:0; transition:color .2s; align-self:flex-start; }
.form-group { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.form-label { font-size:13px; font-weight:600; color:#475569; }
.input-wrapper { position:relative; }
.input-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px; pointer-events:none; }
.form-input { width:100%; padding:11px 14px 11px 40px; border:1.5px solid #e2e8f0; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1e293b; background:#fff; outline:none; transition:border-color .2s,box-shadow .2s; }
.form-input:focus { border-color:#2ec4b6; box-shadow:0 0 0 3px rgba(46,196,182,.12); }
.form-input::placeholder { color:#94a3b8; }
.toggle-password { position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#94a3b8; cursor:pointer; font-size:14px; background:none; border:none; padding:0; transition:color .2s; }
.toggle-password:hover { color:#0f8075; }
.form-options { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.remember-me { display:flex; align-items:center; gap:8px; cursor:pointer; font-size:13.5px; color:#64748b; }
.remember-me input[type="checkbox"] { width:16px; height:16px; accent-color:#0f8075; cursor:pointer; }
.forgot-link { font-size:13px; font-weight:600; color:#0f8075; text-decoration:none; transition:color .2s; }
.forgot-link:hover { color:#0e6660; text-decoration:underline; }

.btn-login { width:100%; padding:12px; background:linear-gradient(135deg,#0f8075,#14a398); color:#fff; border:none; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:15px; font-weight:700; cursor:pointer; transition:all .25s; display:flex; align-items:center; justify-content:center; gap:10px; box-shadow:0 4px 16px rgba(15,128,117,.3); }
.btn-login:hover { background:linear-gradient(135deg,#0e6660,#0f8075); box-shadow:0 6px 20px rgba(15,128,117,.4); transform:translateY(-1px); }

.login-footer { margin-top:clamp(16px,3vh,32px); text-align:center; font-size:12px; color:#94a3b8; }
.login-footer strong { color:#475569; }

@keyframes fadeUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes floatBlob{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes slideDown{ from{opacity:0;transform:translateY(-10px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }

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
    max-width: 420px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #cbd5e1, transparent);
    margin-bottom: 24px;
  }

  .login-box { max-width: 100%; }

  .login-header { margin-bottom: 20px; }
}
</style>
</head>
<body>

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

<div class="right-panel">
  <div class="mobile-header">
    <div class="mobile-logo-wrap">
      <img src="{{ asset('images/LOGO_POSYANDU.png') }}" alt="Logo Posyandu Melati 2">
    </div>
    <div class="mobile-brand-name">Posyandu <span>Melati 2</span></div>
    <div class="mobile-brand-sub">Sistem Informasi Pencatatan Ibu Hamil & Balita</div>
  </div>
  <div class="mobile-divider"></div>

  <div class="login-box">
    <div class="login-header">
      <div class="login-greeting">Selamat Datang</div>
      <h1 class="login-title">Masuk ke Sistem</h1>
    </div>

    @if($errors->any() || session('error'))
    <div class="alert-error" id="alertError">
      <div class="alert-inner">
        <div class="alert-icon-wrap red"><i class="fas fa-lock"></i></div>
        <div class="alert-body">
          <div class="alert-title red">Login Gagal</div>
          <div class="alert-msg red">Email atau password yang Anda masukkan salah. Silakan coba lagi.</div>
        </div>
        <button class="alert-close" onclick="dismissAlert('alertError')" style="color:#fca5a5;"><i class="fas fa-times"></i></button>
      </div>
    </div>
    @endif

    @if(session('success'))
    <div class="alert-success-box" id="alertSuccess">
      <div class="alert-inner">
        <div class="alert-icon-wrap green"><i class="fas fa-check-circle"></i></div>
        <div class="alert-body">
          <div class="alert-title green">Berhasil</div>
          <div class="alert-msg green">{{ session('success') }}</div>
        </div>
        <button class="alert-close" onclick="dismissAlert('alertSuccess')" style="color:#86efac;"><i class="fas fa-times"></i></button>
      </div>
    </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
      @csrf
      <div class="form-group">
        <label class="form-label" for="email">Email / Nomor WhatsApp</label>
        <div class="input-wrapper">
          <i class="fas fa-user input-icon"></i>
          <input type="text" id="email" name="email" class="form-input"
                 placeholder="Email atau No. WhatsApp" value="{{ old('email') }}" required autofocus>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" id="password" name="password" class="form-input"
                 placeholder="Masukkan password" required>
          <button type="button" class="toggle-password" onclick="togglePassword()">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <div class="form-options">
        <label class="remember-me">
          <input type="checkbox" name="remember"> Ingat saya
        </label>
        <a href="{{ route('password.forgot') }}" class="forgot-link">
          <i class="fas fa-key" style="font-size:11px;"></i> Lupa password?
        </a>
      </div>

      <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
      </button>
    </form>

    <div class="login-footer">
      <strong>Posyandu Melati 2</strong> &copy; {{ date('Y') }}<br>
      Sistem Informasi Pencatatan Ibu Hamil &amp; Balita
    </div>
    <div style="text-align:center;margin-top:14px;font-size:13px;color:#6b7280;">
      Orang Tua / Wali baru? <a href="{{ route('register') }}" style="color:#0f8075;font-weight:600;text-decoration:none;">Daftar di sini</a>
    </div>
  </div>
</div>

<script>
function togglePassword() {
  const input = document.getElementById('password');
  const icon  = document.getElementById('eyeIcon');
  input.type = input.type === 'password' ? 'text' : 'password';
  icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
function dismissAlert(id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.style.transition = 'opacity .25s, transform .25s';
  el.style.opacity = '0';
  el.style.transform = 'translateY(-8px) scale(.97)';
  setTimeout(() => el.remove(), 280);
}
</script>
</body>
</html>