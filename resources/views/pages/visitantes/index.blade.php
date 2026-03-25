@extends('layouts.app')
@section('page-title','Visitantes')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Gestão de Visitantes</h2><p class="section-subtitle">Acompanhamento e follow-up pastoral</p></div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-3);">
      <div class="search-bar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" name="busca" placeholder="Buscar visitante..." value="{{ request('busca') }}"></div>
      <select name="status" class="form-select" style="height:36px;width:auto;" onchange="this.form.submit()">
        <option value="">Todos os estados</option>
        <option value="pendente" {{ request('status')=='pendente'?'selected':'' }}>Pendente</option>
        <option value="acompanhado" {{ request('status')=='acompanhado'?'selected':'' }}>Acompanhado</option>
        <option value="convertido" {{ request('status')=='convertido'?'selected':'' }}>Convertido</option>
      </select>
    </form>
    <a href="{{ route('visitantes.create') }}" class="btn btn-primary">+ Novo Visitante</a>
  </div>
</div>

<div class="kpi-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:var(--space-6);">
  <div class="kpi-card kpi-card--primary" style="padding:var(--space-4);"><div class="kpi-card__value">{{ $kpis['total'] }}</div><div class="kpi-card__label">Total registados</div></div>
  <div class="kpi-card kpi-card--warning" style="padding:var(--space-4);"><div class="kpi-card__value">{{ $kpis['pendentes'] }}</div><div class="kpi-card__label">Pendentes</div></div>
  <div class="kpi-card kpi-card--success" style="padding:var(--space-4);"><div class="kpi-card__value">{{ $kpis['acompanhados'] }}</div><div class="kpi-card__label">Acompanhados</div></div>
  <div class="kpi-card kpi-card--secondary" style="padding:var(--space-4);"><div class="kpi-card__value">{{ $kpis['convertidos'] }}</div><div class="kpi-card__label">Convertidos</div></div>
</div>

<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Telefone</th><th>Bairro</th><th>Data</th><th>Tipo</th><th>1ª Visita</th><th>Como Conheceu</th><th>Estado</th><th>Acções</th></tr></thead>
      <tbody>
        @forelse($visitantes as $v)
        <tr>
          <td><strong>{{ $v->nome }}</strong></td>
          <td>{{ $v->telefone ?? '—' }}</td>
          <td>{{ $v->bairro ?? '—' }}</td>
          <td>{{ $v->data_visita->format('d/m/Y') }}</td>
          <td>{{ $v->tipo_label }}</td>
          <td>{{ $v->primeira_visita ? '<span class="badge badge-primary">Sim</span>' : '<span class="badge badge-neutral">Não</span>' }}</td>
          <td>{{ $v->como_conheceu ?? '—' }}</td>
          <td><span class="badge {{ $v->status_badge_class }}">{{ $v->status_label }}</span></td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              @if($v->status === 'pendente')
              <form method="POST" action="{{ route('visitantes.acompanhar', $v) }}">@csrf @method('PATCH')<button type="submit" class="btn btn-sm btn-success">✓ Acompanhado</button></form>
              @endif
              <form method="POST" action="{{ route('visitantes.destroy', $v) }}" onsubmit="return confirm('Eliminar visitante?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">✕</button></form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9"><div class="empty-state"><div class="empty-state__icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><p class="empty-state__title">Nenhum visitante encontrado</p><a href="{{ route('visitantes.create') }}" class="btn btn-primary btn-sm">Registar Visitante</a></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);">{{ $visitantes->links() }}</div>
</div>
@endsection
