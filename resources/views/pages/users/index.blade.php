@extends('layouts.app')
@section('page-title','Usuários')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Usuários</h2><p class="section-subtitle">Gerencie acessos ao sistema</p></div>
  <div class="section-actions"><a class="btn btn-primary" href="{{ route('usuarios.create') }}">Novo usuário</a></div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Email</th><th>Papel</th><th>Criado</th><th>Ações</th></tr></thead>
      <tbody>
        @foreach($users as $u)
          <tr>
            <td><strong>{{ $u->name }}</strong></td>
            <td>{{ $u->email }}</td>
            <td>{{ strtoupper($u->role) }}</td>
            <td>{{ $u->created_at->format('d/m/Y') }}</td>
            <td style="display:flex;gap:8px;">
              <a class="btn btn-sm btn-secondary" href="{{ route('usuarios.edit', $u) }}">Editar</a>
              <form method="POST" action="{{ route('usuarios.destroy', $u) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Remover usuário?')">Excluir</button></form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
