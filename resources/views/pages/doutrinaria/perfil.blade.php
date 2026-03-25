@extends('layouts.app')
@section('page-title','Perfil do Candidato')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">{{ $c->nome }}</h2><p class="section-subtitle">Candidato ao Baptismo · {{ $turma->nome }}</p></div>
  <div class="section-actions"><a href="{{ route('doutrinaria.index') }}" class="btn btn-secondary">← Voltar</a></div>
</div>

@if($c->em_risco)
<div class="alert alert-danger">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg>
  <div><strong>Atenção:</strong> {{ $c->nome }} está com <strong>{{ $c->percentual_presenca }}%</strong> de frequência — abaixo do mínimo de 75%.</div>
</div>
@endif

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="card">
    <div class="card-header"><span class="card-title">Informações</span><span class="badge {{ $c->status_badge_class }}">{{ $c->status_label }}</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Telefone</span><span class="sr-value">{{ $c->telefone ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Bairro</span><span class="sr-value">{{ $c->bairro ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Matrícula</span><span class="sr-value">{{ $c->data_matricula->format('d/m/Y') }}</span></div>
      @if($c->is_novo)<div class="summary-row"><span class="sr-label">Categoria</span><span class="sr-value"><span class="badge badge-warning">Novo candidato</span></span></div>@endif
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Estatísticas</span></div>
    <div class="card-body">
      <div style="text-align:center;margin-bottom:var(--space-4);">
        <div style="font-family:var(--font-display);font-size:3rem;font-weight:700;color:{{ $c->percentual_presenca >= 75 ? 'var(--color-success-700)' : 'var(--color-danger-600)' }};">{{ $c->percentual_presenca }}%</div>
        <div style="font-size:var(--text-sm);color:var(--color-neutral-500);">de frequência</div>
      </div>
      <div class="progress-bar" style="height:8px;margin-bottom:var(--space-4);"><div class="progress-fill {{ $c->percentual_presenca >= 75 ? 'pf-success' : 'pf-danger' }}" style="width:{{ $c->percentual_presenca }}%"></div></div>
      <div class="summary-row"><span class="sr-label">Presenças</span><span class="sr-value" style="color:var(--color-success-700);">{{ $c->total_presencas }}</span></div>
      <div class="summary-row"><span class="sr-label">Faltas</span><span class="sr-value" style="color:var(--color-danger-600);">{{ $c->total_faltas }}</span></div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Histórico por Aula</span></div>
  <div class="card-body">
    <div class="att-timeline" style="margin-bottom:var(--space-4);">
      @for($i=1;$i<=$turma->total_aulas_previstas;$i++)
        @php $p=$c->presencas->firstWhere('aula_numero',$i); @endphp
        @if($p)<div class="att-dot {{ $p->presente ? 'att-dot--present' : 'att-dot--absent' }}" title="Aula {{ $i }}: {{ $p->presente ? 'Presente' : 'Ausente' }}"></div>
        @else<div class="att-dot att-dot--future" title="Aula {{ $i }}: Não realizada"></div>@endif
      @endfor
    </div>
    <div style="display:flex;gap:var(--space-4);">
      <span style="display:flex;align-items:center;gap:6px;font-size:var(--text-xs);color:var(--color-neutral-500);"><span style="width:12px;height:12px;background:var(--color-success-400);border-radius:3px;display:inline-block;"></span>Presente</span>
      <span style="display:flex;align-items:center;gap:6px;font-size:var(--text-xs);color:var(--color-neutral-500);"><span style="width:12px;height:12px;background:var(--color-danger-200);border-radius:3px;display:inline-block;"></span>Ausente</span>
      <span style="display:flex;align-items:center;gap:6px;font-size:var(--text-xs);color:var(--color-neutral-500);"><span style="width:12px;height:12px;background:var(--color-neutral-200);border-radius:3px;display:inline-block;"></span>Não realizada</span>
    </div>
  </div>
</div>
@endsection
