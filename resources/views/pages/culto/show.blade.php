@extends('layouts.app')
@section('page-title','Detalhes do Culto')
@section('content')
<div class="section-header">
  <div>
    <h2 class="section-title">Culto — {{ $culto->data->translatedFormat('D, d/m/Y') }}</h2>
    <p class="section-subtitle">{{ $culto->pregador }} · {{ $culto->tema_culto }}</p>
  </div>
  <div class="section-actions">
    <a href="{{ route('cultos.index') }}" class="btn btn-secondary">← Voltar</a>
    <a href="{{ route('relatorios.dominical', $culto) }}" class="btn btn-ghost">Relatório</a>
    <a href="{{ route('cultos.edit', $culto) }}" class="btn btn-primary">Editar</a>
  </div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="card">
    <div class="card-header"><span class="card-title">Informações do Culto</span><span class="badge badge-success">Registado</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Data</span><span class="sr-value">{{ $culto->data->translatedFormat('l, d/m/Y') }}</span></div>
      <div class="summary-row"><span class="sr-label">Horário</span><span class="sr-value">{{ $culto->horario_inicio ? substr($culto->horario_inicio,0,5).'h às '.substr($culto->horario_fim,0,5).'h' : '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Pregador</span><span class="sr-value">{{ $culto->pregador }}</span></div>
      <div class="summary-row"><span class="sr-label">Tema</span><span class="sr-value">{{ $culto->tema_culto ?? '—' }}</span></div>
      @if($culto->observacoes)<div class="summary-row"><span class="sr-label">Observações</span><span class="sr-value">{{ $culto->observacoes }}</span></div>@endif
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Presença</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Adultos</span><span class="sr-value">{{ $culto->presencaCulto?->adultos ?? 0 }}</span></div>
      <div class="summary-row"><span class="sr-label">Adolescentes</span><span class="sr-value">{{ $culto->presencaCulto?->adolescentes ?? 0 }}</span></div>
      <div class="summary-row"><span class="sr-label">Crianças (Celestial)</span><span class="sr-value">{{ $culto->presencaCulto?->criancas ?? 0 }}</span></div>
      <div class="summary-row"><span class="sr-label" style="font-weight:600;">Total</span><span class="sr-value" style="font-family:var(--font-display);font-size:var(--text-2xl);color:var(--color-primary-700);">{{ $culto->presencaCulto?->total ?? 0 }}</span></div>
    </div>
  </div>
</div>

@if($culto->ofertas->isNotEmpty())
<div class="card" style="margin-bottom:var(--space-6);">
  <div class="card-header">
    <span class="card-title">Ofertas ({{ $culto->ofertas->count() }} tipos)</span>
    <span class="badge badge-success">Total: {{ number_format($culto->total_ofertas,0,',','.') }} Kz</span>
  </div>
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Tipo</th><th>Dinheiro</th><th>Transferência</th><th>Multicaixa/TPA</th><th>Total</th></tr></thead>
      <tbody>
        @foreach($culto->ofertas as $o)
          <tr>
            <td><strong>{{ $o->tipo }}</strong></td>
            <td>{{ number_format($o->valor_dinheiro,0,',','.') }} Kz</td>
            <td>{{ number_format($o->valor_transferencia,0,',','.') }} Kz</td>
            <td>{{ number_format($o->valor_cartao,0,',','.') }} Kz</td>
            <td><strong style="color:var(--color-success-700);">{{ number_format($o->valor_total,0,',','.') }} Kz</strong></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@if($culto->visitantes->isNotEmpty())
<div class="card">
  <div class="card-header"><span class="card-title">Visitantes ({{ $culto->visitantes->count() }})</span></div>
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Telefone</th><th>Bairro</th><th>Tipo</th><th>1ª Visita</th><th>Como Conheceu</th><th>Estado</th></tr></thead>
      <tbody>
        @foreach($culto->visitantes as $v)
        <tr><td><strong>{{ $v->nome }}</strong></td><td>{{ $v->telefone ?? '—' }}</td><td>{{ $v->bairro ?? '—' }}</td><td>{{ $v->tipo_label }}</td><td>{!! $v->primeira_visita ? '<span class="badge badge-primary">Sim</span>' : 'Não' !!}</td><td>{{ $v->como_conheceu ?? '—' }}</td><td><span class="badge {{ $v->status_badge_class }}">{{ $v->status_label }}</span></td></tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection
