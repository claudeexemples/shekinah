<!DOCTYPE html>
<html lang="pt-AO">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Entrar — Shekinah</title>
  <style>
    body{font-family:system-ui,sans-serif;background:#f5f7fb;margin:0;display:grid;place-items:center;min-height:100vh;padding:1rem}
    .card{width:min(420px,100%);background:#fff;border:1px solid #e4e8f0;border-radius:16px;padding:1.25rem}
    .field{display:flex;flex-direction:column;gap:.4rem;margin-bottom:.9rem}
    input{height:42px;border:1px solid #cdd2de;border-radius:10px;padding:0 .8rem}
    button{height:42px;border:none;border-radius:10px;background:#4f46e5;color:#fff;font-weight:600;width:100%}
    .error{background:#fff1f2;border:1px solid #ffe4e6;padding:.7rem;border-radius:10px;color:#be123c;font-size:.9rem;margin-bottom:.8rem}
  </style>
</head>
<body>
  <form method="POST" action="{{ route('login.attempt') }}" class="card">
    @csrf
    <h2>Entrar no Shekinah</h2>
    @if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
    <div class="field">
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="field">
      <label>Senha</label>
      <input type="password" name="password" required>
    </div>
    <div style="margin-bottom:.9rem;"><label><input type="checkbox" name="remember"> Manter sessão</label></div>
    <button type="submit">Iniciar sessão</button>
  </form>
</body>
</html>
