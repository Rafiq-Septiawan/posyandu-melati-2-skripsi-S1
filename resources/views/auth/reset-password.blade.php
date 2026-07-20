<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — Posyandu Melati 2</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
body {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    min-height: 100dvh;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #0d3b38 0%, #0f8075 50%, #2ec4b6 100%);
    padding: 20px;
    overflow-x: hidden;
    overflow-y: auto;
    position: relative;
}
.deco { position:fixed; border-radius:50%; background:rgba(255,255,255,.06); pointer-events: none; z-index: 0; }
.deco-1 { width:500px; height:500px; top:-150px; left:-150px; }
.deco-2 { width:300px; height:300px; bottom:-80px; right:-80px; }

.card {
    position: relative; background: #fff; border-radius: 24px;
    width: 100%; max-width: 440px;
    box-shadow: 0 32px 80px rgba(0,0,0,.2);
    overflow: hidden;
    animation: cardIn .4s cubic-bezier(.34,1.2,.64,1);
}
.card-top {
    background: linear-gradient(135deg, #0f4f4a, #0f8075);
    padding: 36px 36px 28px; text-align: center; color: #fff;
    position: relative; overflow: hidden;
}
.card-top::before {
    content:''; position:absolute; width:200px; height:200px;
    background:rgba(255,255,255,.06); border-radius:50%;
    top:-60px; right:-60px;
}
.icon-wrap {
    width: 60px; height: 60px;
    background: rgba(255,255,255,.15);
    border: 1.5px solid rgba(255,255,255,.25);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; margin: 0 auto 16px;
}
.card-top h1 { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
.card-top p  { font-size: 13px; color: rgba(255,255,255,.75); line-height: 1.6; }

.card-body { padding: 28px 32px 32px; }

.alert {
    border-radius: 10px; padding: 12px 14px; font-size: 13px;
    display: flex; align-items: flex-start; gap: 10px; margin-bottom: 20px;
}
.alert-danger { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }
.alert i { margin-top: 1px; flex-shrink: 0; }

.form-group { margin-bottom: 18px; }
label { display:block; font-size:13px; font-weight:600; color:#475569; margin-bottom:6px; }
.input-wrap { position: relative; }
.input-wrap .icon-left { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px; pointer-events:none; }
input[type=password], input[type=text] {
    width: 100%; padding: 12px 42px 12px 40px;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-family: inherit; font-size: 14px; color: #1e293b;
    outline: none; transition: border-color .2s, box-shadow .2s;
}
input:focus { border-color: #2ec4b6; box-shadow: 0 0 0 3px rgba(46,196,182,.12); }
input::placeholder { color: #94a3b8; }
.toggle-pw {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #94a3b8; font-size: 14px; padding: 0; transition: color .2s;
}
.toggle-pw:hover { color: #0f8075; }

/* Strength bar */
.strength-bar { height: 4px; background: #e2e8f0; border-radius: 4px; margin-top: 8px; overflow: hidden; }
.strength-fill { height: 100%; border-radius: 4px; width: 0; transition: width .3s, background .3s; }
.strength-label { font-size: 11px; font-weight: 600; margin-top: 4px; }

/* Match hint */
.match-hint { font-size: 12px; margin-top: 5px; }

.btn-submit {
    width: 100%; padding: 13px;
    background: linear-gradient(135deg, #0f8075, #14a398);
    color: #fff; border: none; border-radius: 10px;
    font-family: inherit; font-size: 15px; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .25s; box-shadow: 0 4px 16px rgba(15,128,117,.3);
    margin-top: 4px;
}
.btn-submit:hover { background: linear-gradient(135deg,#0e6660,#0f8075); transform: translateY(-1px); }

.back-link {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    margin-top: 20px; font-size: 13.5px; color: #64748b;
    text-decoration: none; transition: color .2s;
}
.back-link:hover { color: #0f8075; }

@keyframes cardIn { from{opacity:0;transform:translateY(24px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
</style>
</head>
<body>
<div class="deco deco-1"></div>
<div class="deco deco-2"></div>

<div class="card">
    <div class="card-top">
        <div class="icon-wrap"><i class="fas fa-lock-open"></i></div>
        <h1>Buat Password Baru</h1>
        <p>Masukkan password baru untuk akun <strong>{{ $email }}</strong></p>
    </div>

    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label>Password Baru <span style="color:#f43f5e;">*</span></label>
                <div class="input-wrap">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" name="password" id="password"
                        placeholder="Minimal 8 karakter" required autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="togglePw('password','eye1')">
                        <i class="fas fa-eye" id="eye1"></i>
                    </button>
                </div>
                <div class="strength-bar"><div class="strength-fill" id="sFill"></div></div>
                <div class="strength-label" id="sLabel" style="color:#94a3b8;"></div>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password <span style="color:#f43f5e;">*</span></label>
                <div class="input-wrap">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" name="password_confirmation" id="pw2"
                        placeholder="Ulangi password baru" required autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="togglePw('pw2','eye2')">
                        <i class="fas fa-eye" id="eye2"></i>
                    </button>
                </div>
                <div class="match-hint" id="matchHint"></div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-check"></i> Simpan Password Baru
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke halaman login
        </a>
    </div>
</div>

<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
}

document.getElementById('password').addEventListener('input', function () {
    const v = this.value;
    let score = 0;
    if (v.length >= 8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    const levels = [
        {w:'0%',   bg:'#e2e8f0', label:''},
        {w:'25%',  bg:'#f43f5e', label:'Lemah'},
        {w:'50%',  bg:'#f59e0b', label:'Cukup'},
        {w:'75%',  bg:'#3b82f6', label:'Kuat'},
        {w:'100%', bg:'#22c55e', label:'Sangat Kuat'},
    ];
    document.getElementById('sFill').style.width      = levels[score].w;
    document.getElementById('sFill').style.background = levels[score].bg;
    document.getElementById('sLabel').textContent     = v.length ? levels[score].label : '';
    document.getElementById('sLabel').style.color     = levels[score].bg;
});

document.getElementById('pw2').addEventListener('input', function () {
    const pw   = document.getElementById('password').value;
    const hint = document.getElementById('matchHint');
    if (!this.value) { hint.innerHTML = ''; return; }
    hint.innerHTML = this.value === pw
        ? '<span style="color:#16a34a"><i class="fas fa-check-circle"></i> Password cocok</span>'
        : '<span style="color:#dc2626"><i class="fas fa-times-circle"></i> Password tidak cocok</span>';
});
</script>
</body>
</html>