@extends('layouts.app')
@section('page-title','Perfil do Visitante')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">{{ $visitante->nome }}</h2><p class="section-subtitle">Visitante · {{ $visitante->data_visita->format('d/m/Y') }}</p></div>
  <div class="section-actions">
    <a href="{{ route('visitantes.index') }}" class="btn btn-secondary">← Voltar</a>
    @if($visitante->status === 'pendente')
    <form method="POST" action="{{ route('visitantes.acompanhar', $visitante) }}" style="display:inline;">@csrf @method('PATCH')
      <button type="submit" class="btn btn-success">✓ Marcar Acompanhado</button>
    </form>
    @endif
  </div>
</div>
<div class="grid-2">
  <div class="card">
    <div class="card-header"><span class="card-title">Dados do Visitante</span><span class="badge {{ $visitante->status_badge_class }}">{{ $visitante->status_label }}</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Telefone</span><span class="sr-value">{{ $visitante->telefone ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Email</span><span class="sr-value">{{ $visitante->email ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Tipo</span><span class="sr-value">{{ $visitante->tipo_label }}</span></div>
      <div class="summary-row"><span class="sr-label">Bairro</span><span class="sr-value">{{ $visitante->bairro ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Município</span><span class="sr-value">{{ $visitante->municipio ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Província</span><span class="sr-value">{{ $visitante->provincia ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">Como conheceu</span><span class="sr-value">{{ $visitante->como_conheceu ?? '—' }}</span></div>
      <div class="summary-row"><span class="sr-label">1ª Visita</span><span class="sr-value">{{ $visitante->primeira_visita ? 'Sim' : 'Não' }}</span></div>
      <div class="summary-row"><span class="sr-label">Data da visita</span><span class="sr-value">{{ $visitante->data_visita->translatedFormat('D, d/m/Y') }}</span></div>
      @if($visitante->observacoes)<div class="summary-row"><span class="sr-label">Observações</span><span class="sr-value">{{ $visitante->observacoes }}</span></div>@endif
    </div>
  </div>
</div>
@endsection
