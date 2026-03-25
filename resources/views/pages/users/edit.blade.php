@extends('layouts.app')
@section('page-title','Editar Usuário')
@section('content')
<form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="section-block">@csrf @method('PUT')
  <h2 class="section-title" style="margin-bottom:12px;">Editar usuário</h2>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Nome</label><input class="form-input" name="name" required value="{{ old('name', $usuario->name) }}"></div>
    <div class="form-group"><label class="form-label">Email</label><input class="form-input" type="email" name="email" required value="{{ old('email', $usuario->email) }}"></div>
    <div class="form-group"><label class="form-label">Papel</label><select class="form-select" name="role"><option value="admin" @selected(old('role', $usuario->role)==='admin')>Admin</option><option value="editor" @selected(old('role', $usuario->role)==='editor')>Editor</option></select></div>
    <div class="form-group"><label class="form-label">Nova senha (opcional)</label><input class="form-input" type="password" name="password"></div>
    <div class="form-group"><label class="form-label">Confirmar nova senha</label><input class="form-input" type="password" name="password_confirmation"></div>
  </div>
  <div style="margin-top:12px;display:flex;gap:8px;"><a class="btn btn-secondary" href="{{ route('usuarios.index') }}">Cancelar</a><button class="btn btn-primary">Salvar alterações</button></div>
</form>
@endsection
