@extends('layouts.app')
@section('page-title','Novo Usuário')
@section('content')
<form method="POST" action="{{ route('usuarios.store') }}" class="section-block">@csrf
  <h2 class="section-title" style="margin-bottom:12px;">Novo usuário</h2>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Nome</label><input class="form-input" name="name" required value="{{ old('name') }}"></div>
    <div class="form-group"><label class="form-label">Email</label><input class="form-input" type="email" name="email" required value="{{ old('email') }}"></div>
    <div class="form-group"><label class="form-label">Papel</label><select class="form-select" name="role"><option value="admin">Admin</option><option value="editor">Editor</option></select></div>
    <div class="form-group"><label class="form-label">Senha</label><input class="form-input" type="password" name="password" required></div>
    <div class="form-group"><label class="form-label">Confirmar senha</label><input class="form-input" type="password" name="password_confirmation" required></div>
  </div>
  <div style="margin-top:12px;display:flex;gap:8px;"><a class="btn btn-secondary" href="{{ route('usuarios.index') }}">Cancelar</a><button class="btn btn-primary">Salvar</button></div>
</form>
@endsection
