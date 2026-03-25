@extends('layouts.app')
@section('page-title','Relatório Mensal')
@section('content')
<div class="section-header no-print">
  <div>
    <h2 class="section-title">Relatório Mensal</h2>
    <p class="section-subtitle">{{ \Carbon\Carbon::create($ano,$mes)->translatedFormat('F \d\e Y') }}</p>
  </div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-2);">
      <select name="mes" class="form-select" style="height:36px;width:auto;">@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $mes==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>@endfor</select>
      <select name="ano" class="form-select" style="height:36px;width:auto;">@for($a=2023;$a<=date('Y');$a++)<option value="{{ $a }}" {{ $ano==$a?'selected':'' }}>{{ $a }}</option>@endfor</select>
      <button type="submit" class="btn btn-secondary">Ver</button>
    </form>
    <button class="btn btn-primary no-print" onclick="window.print()">🖨️ Imprimir</button>
  </div>
</div>

<div class="kpi-grid" style="grid-template-columns:repeat(4,1fr);">
  <div class="kpi-card kpi-card--primary"><div class="kpi-card__value">{{ round($presencaMedia) }}</div><div class="kpi-card__label">Média de presença</div><div class="kpi-card__sub">{{ $cultos->count() }} cultos</div></div>
  <div class="kpi-card kpi-card--warning"><div class="kpi-card__value">{{ $totalVisitantes }}</div><div class="kpi-card__label">Total visitantes</div></div>
  <div class="kpi-card kpi-card--success"><div class="kpi-card__value">{{ number_format($totalOfertas,0,',','.') }} Kz</div><div class="kpi-card__label">Total de ofertas</div></div>
  <div class="kpi-card kpi-card--danger"><div class="kpi-card__value">{{ number_format($totalDespesas,0,',','.') }} Kz</div><div class="kpi-card__label">Total de despesas</div></div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="card">
    <div class="card-header"><span class="card-title">Presença por Domingo</span></div>
    <div class="card-body">
      @php $maxPres = $cultos->max(fn($c) => $c->presencaCulto?->total ?? 0); @endphp
      <div class="bar-chart">
        @foreach($cultos as $c)
        @php $t = $c->presencaCulto?->total ?? 0; $p = $maxPres>0?round($t/$maxPres*100):0; @endphp
        <div class="bar-group"><div class="bar bar--primary" style="height:{{ $p }}%" title="{{ $t }}"></div><div class="bar-label">{{ $c->data->format('d/m') }}</div></div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Resumo do Mês</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Cultos realizados</span><span class="sr-value">{{ $cultos->count() }}</span></div>
      <div class="summary-row"><span class="sr-label">Maior presença</span><span class="sr-value">{{ $cultos->max(fn($c) => $c->presencaCulto?->total ?? 0) }}</span></div>
      <div class="summary-row"><span class="sr-label">Menor presença</span><span class="sr-value">{{ $cultos->min(fn($c) => $c->presencaCulto?->total ?? 0) }}</span></div>
      <div class="summary-row"><span class="sr-label">Saldo financeiro</span><span class="sr-value" style="color:{{ ($totalOfertas-$totalDespesas)>=0?'var(--color-success-700)':'var(--color-danger-700)' }};font-family:var(--font-display);">{{ number_format($totalOfertas-$totalDespesas,0,',','.') }} Kz</span></div>
      @if($turmaActiva)
      <div class="summary-row"><span class="sr-label">Candidatos baptismo</span><span class="sr-value">{{ $turmaActiva->candidatos->count() }} (freq. média {{ $turmaActiva->frequencia_media }}%)</span></div>
      @endif
    </div>
  </div>
</div>
@endsection
