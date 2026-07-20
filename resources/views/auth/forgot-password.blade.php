<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password — Posyandu Melati 2</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
body {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0d3b38 0%, #0f8075 50%, #2ec4b6 100%);
    padding: 20px;
    position: relative;
    overflow-x: hidden;
    overflow-y: auto;
}
.deco { position:fixed; border-radius:50%; background:rgba(255,255,255,.06); pointer-events: none; z-index: 0; }
.deco-1 { width:500px; height:500px; top:-150px; left:-150px; }
.deco-2 { width:300px; height:300px; bottom:-80px; right:-80px; }
.deco-3 { width:180px; height:180px; top:40%; right:20%; background:rgba(255,255,255,.04); }

.card {
    position: relative;
    background: #fff;
    border-radius: 24px;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 32px 80px rgba(0,0,0,.2);
    overflow: hidden;
    animation: cardIn .4s cubic-bezier(.34,1.2,.64,1);
}
.card-top {
    background: linear-gradient(135deg, #0f4f4a, #0f8075);
    padding: 36px 36px 28px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
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

/* Alert */
.alert {
    border-radius: 10px; padding: 12px 14px;
    font-size: 13px; display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 20px;
}
.alert-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; }
.alert-danger  { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }
.alert i { margin-top: 1px; flex-shrink: 0; }

/* Form */
.form-group { margin-bottom: 20px; }
label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
.input-wrap { position: relative; }
.input-wrap i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px; pointer-events:none; }
input[type=email] {
    width: 100%; padding: 12px 14px 12px 40px;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-family: inherit; font-size: 14px; color: #1e293b;
    outline: none; transition: border-color .2s, box-shadow .2s;
}
input[type=email]:focus { border-color: #2ec4b6; box-shadow: 0 0 0 3px rgba(46,196,182,.12); }
input::placeholder { color: #94a3b8; }

.btn-submit {
    width: 100%; padding: 13px;
    background: linear-gradient(135deg, #0f8075, #14a398);
    color: #fff; border: none; border-radius: 10px;
    font-family: inherit; font-size: 15px; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .25s;
    box-shadow: 0 4px 16px rgba(15,128,117,.3);
}
.btn-submit:hover { background: linear-gradient(135deg,#0e6660,#0f8075); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(15,128,117,.4); }

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
<div class="deco deco-3"></div>

<div class="card">
    <div class="card-top">
        <div class="icon-wrap"><i class="fas fa-key"></i></div>
        <h1>Lupa Password?</h1>
        <p>Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.</p>
    </div>

    <div class="card-body">

        @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

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

        @if(!session('status'))
        <form method="POST" action="{{ route('password.forgot.send') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email <span style="color:#f43f5e;">*</span></label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email"
                        placeholder="email@posyandu-melati2.id"
                        value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Kirim Link Reset Password
            </button>
        </form>
        @endif

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke halaman login
        </a>
    </div>
</div>
</body>
</html>