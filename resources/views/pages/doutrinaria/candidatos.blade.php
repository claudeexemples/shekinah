@extends('layouts.app')
@section('page-title','Candidatos ao Baptismo')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Candidatos ao Baptismo</h2><p class="section-subtitle">{{ $turmaActiva?->nome ?? 'Turma activa' }}</p></div>
  <div class="section-actions">
    <form method="GET" class="search-bar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" name="busca" placeholder="Buscar candidato..." value="{{ request('busca') }}"></form>
    <a href="{{ route('doutrinaria.index') }}" class="btn btn-secondary">← Turma</a>
  </div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Telefone</th><th>Bairro</th><th>Matrícula</th><th>Presenças</th><th>Faltas</th><th>Frequência</th><th>Status</th><th>Acções</th></tr></thead>
      <tbody>
        @forelse($candidatos as $c)
        @php $cls=$c->percentual_presenca>=90?'badge-success':($c->percentual_presenca>=75?'badge-primary':($c->percentual_presenca>=60?'badge-warning':'badge-danger')); @endphp
        <tr>
          <td><strong>{{ $c->nome }}</strong>@if($c->is_novo)<span class="badge badge-warning" style="margin-left:6px;">Novo</span>@endif</td>
          <td>{{ $c->telefone ?? '—' }}</td>
          <td>{{ $c->bairro ?? '—' }}</td>
          <td>{{ $c->data_matricula->format('d/m/Y') }}</td>
          <td>{{ $c->total_presencas }}</td>
          <td>{{ $c->total_faltas }}</td>
          <td><span class="badge {{ $cls }}">{{ $c->percentual_presenca }}%</span></td>
          <td><span class="badge {{ $c->status_badge_class }}">{{ $c->status_label }}</span></td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              <a href="{{ route('doutrinaria.candidatos.perfil', $c) }}" class="btn btn-sm btn-ghost">Perfil</a>
              <form method="POST" action="{{ route('doutrinaria.candidatos.destroy', $c) }}" onsubmit="return confirm('Eliminar candidato?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">✕</button></form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9"><div class="empty-state"><p class="empty-state__title">Nenhum candidato encontrado</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);">{{ $candidatos->links() }}</div>
</div>
@endsection
