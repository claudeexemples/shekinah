@extends('layouts.app')
@section('page-title','Relatório Dominical')
@section('content')
<div class="section-header no-print">
  <div><h2 class="section-title">Relatório Dominical</h2><p class="section-subtitle">{{ $culto->data->translatedFormat('l, d \d\e F \d\e Y') }}</p></div>
  <div class="section-actions">
    <a href="{{ route('relatorios.index') }}" class="btn btn-secondary no-print">← Voltar</a>
    <a href="{{ route('relatorios.dominical.pdf', $culto) }}" class="btn btn-ghost no-print">📄 Exportar PDF</a>
    <button class="btn btn-primary no-print" onclick="window.print()">🖨️ Imprimir</button>
  </div>
</div>

<div class="print-header">
  <div style="font-family:var(--font-display);font-size:22px;font-weight:700;color:#1e2335;">Igreja Shekinah — Relatório Dominical</div>
  <div style="color:#6b7591;margin-top:4px;">{{ $culto->data->translatedFormat('l, d \d\e F \d\e Y') }}</div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-5);">
  <div class="report-section" style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-6);">
    <div style="font-family:var(--font-display);font-size:var(--text-base);font-weight:600;color:var(--color-neutral-800);margin-bottom:var(--space-4);display:flex;align-items:center;gap:8px;"><span style="width:4px;height:18px;background:var(--color-primary-500);border-radius:var(--radius-full);display:inline-block;"></span>Informações do Culto</div>
    <div class="summary-row"><span class="sr-label">Data</span><span class="sr-value">{{ $culto->data->translatedFormat('D, d/m/Y') }}</span></div>
    <div class="summary-row"><span class="sr-label">Horário</span><span class="sr-value">{{ $culto->horario_inicio ? substr($culto->horario_inicio,0,5).'h – '.substr($culto->horario_fim,0,5).'h' : '—' }}</span></div>
    <div class="summary-row"><span class="sr-label">Pregador</span><span class="sr-value">{{ $culto->pregador }}</span></div>
    <div class="summary-row"><span class="sr-label">Tema</span><span class="sr-value">{{ $culto->tema_culto ?? '—' }}</span></div>
  </div>
  <div class="report-section" style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-6);">
    <div style="font-family:var(--font-display);font-size:var(--text-base);font-weight:600;color:var(--color-neutral-800);margin-bottom:var(--space-4);display:flex;align-items:center;gap:8px;"><span style="width:4px;height:18px;background:var(--color-primary-500);border-radius:var(--radius-full);display:inline-block;"></span>Presença</div>
    <div class="summary-row"><span class="sr-label">Adultos</span><span class="sr-value">{{ $culto->presencaCulto?->adultos ?? 0 }}</span></div>
    <div class="summary-row"><span class="sr-label">Adolescentes</span><span class="sr-value">{{ $culto->presencaCulto?->adolescentes ?? 0 }}</span></div>
    <div class="summary-row"><span class="sr-label">Crianças (Celestial)</span><span class="sr-value">{{ $culto->presencaCulto?->criancas ?? 0 }}</span></div>
    <div class="summary-row"><span class="sr-label" style="font-weight:600;">Total</span><span class="sr-value" style="font-family:var(--font-display);font-size:var(--text-xl);color:var(--color-primary-700);">{{ $culto->presencaCulto?->total ?? 0 }}</span></div>
  </div>
</div>

<div class="grid-3" style="margin-bottom:var(--space-5);">
  <div style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-5);">
    <div style="font-family:var(--font-display);font-size:var(--text-sm);font-weight:600;margin-bottom:var(--space-3);color:var(--color-neutral-800);">EBD</div>
    @if($culto->ebdRegistro)
    <div class="summary-row"><span class="sr-label">Professor</span><span class="sr-value" style="font-size:var(--text-xs);">{{ $culto->ebdRegistro->professor }}</span></div>
    <div class="summary-row"><span class="sr-label">Tema</span><span class="sr-value" style="font-size:var(--text-xs);">{{ $culto->ebdRegistro->tema }}</span></div>
    <div class="summary-row"><span class="sr-label">Presentes</span><span class="sr-value">{{ $culto->ebdRegistro->total_presentes }}</span></div>
    @else<p style="color:var(--color-neutral-400);font-size:var(--text-sm);">Não registada</p>@endif
  </div>
  <div style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-5);">
    <div style="font-family:var(--font-display);font-size:var(--text-sm);font-weight:600;margin-bottom:var(--space-3);color:var(--color-neutral-800);">Classe Celestial</div>
    @if($culto->celestialRegistro)
    <div class="summary-row"><span class="sr-label">Crianças</span><span class="sr-value">{{ $culto->celestialRegistro->total_criancas }}</span></div>
    <div class="summary-row"><span class="sr-label">Professores</span><span class="sr-value">{{ $culto->celestialRegistro->total_professores }}</span></div>
    @else<p style="color:var(--color-neutral-400);font-size:var(--text-sm);">Não registada</p>@endif
  </div>
  <div style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-5);">
    <div style="font-family:var(--font-display);font-size:var(--text-sm);font-weight:600;margin-bottom:var(--space-3);color:var(--color-neutral-800);">Ofertas</div>
    @if($culto->ofertas->isNotEmpty())
      @foreach($culto->ofertas as $o)
      <div class="summary-row"><span class="sr-label">{{ $o->tipo }}</span><span class="sr-value">{{ number_format($o->valor_total,0,',','.') }} Kz</span></div>
      @endforeach
      <div class="summary-row"><span class="sr-label" style="font-weight:600;">Total</span><span class="sr-value" style="color:var(--color-success-700);font-weight:700;">{{ number_format($culto->total_ofertas,0,',','.') }} Kz</span></div>
    @else<p style="color:var(--color-neutral-400);font-size:var(--text-sm);">Não registada</p>@endif
  </div>
</div>

@if($culto->visitantes->isNotEmpty())
<div style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-6);margin-bottom:var(--space-5);">
  <div style="font-family:var(--font-display);font-size:var(--text-base);font-weight:600;margin-bottom:var(--space-4);">Visitantes ({{ $culto->visitantes->count() }})</div>
  <table class="table"><thead><tr><th>Nome</th><th>Telefone</th><th>Bairro</th><th>Tipo</th><th>1ª Visita</th><th>Como Conheceu</th></tr></thead>
  <tbody>@foreach($culto->visitantes as $v)<tr><td><strong>{{ $v->nome }}</strong></td><td>{{ $v->telefone ?? '—' }}</td><td>{{ $v->bairro ?? '—' }}</td><td>{{ $v->tipo_label }}</td><td>{!! $v->primeira_visita ? '<span class="badge badge-primary">Sim</span>' : 'Não' !!}</td><td>{{ $v->como_conheceu ?? '—' }}</td></tr>@endforeach</tbody></table>
</div>
@endif

@if($turmaActiva)
<div style="background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-6);">
  <div style="font-family:var(--font-display);font-size:var(--text-base);font-weight:600;margin-bottom:var(--space-4);">Classe Bíblica Doutrinária</div>
  <div class="summary-row"><span class="sr-label">Turma activa</span><span class="sr-value">{{ $turmaActiva->nome }}</span></div>
  <div class="summary-row"><span class="sr-label">Aula actual</span><span class="sr-value">{{ $turmaActiva->aula_atual }}/{{ $turmaActiva->total_aulas_previstas }}</span></div>
  <div class="summary-row"><span class="sr-label">Candidatos</span><span class="sr-value">{{ $turmaActiva->candidatos->count() }}</span></div>
  <div class="summary-row"><span class="sr-label">Frequência média</span><span class="sr-value">{{ $turmaActiva->frequencia_media }}%</span></div>
</div>
@endif
@endsection
