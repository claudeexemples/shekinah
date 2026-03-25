@extends('layouts.app')
@section('page-title','Detalhes da EBD')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">EBD — {{ $ebd->evento->data->translatedFormat('D, d/m/Y') }}</h2></div>
  <div class="section-actions"><a href="{{ route('ebd.index') }}" class="btn btn-secondary">← Voltar</a></div>
</div>
<div class="card" style="max-width:600px;">
  <div class="card-body">
    <div class="summary-row"><span class="sr-label">Data</span><span class="sr-value">{{ $ebd->evento->data->translatedFormat('l, d/m/Y') }}</span></div>
    <div class="summary-row"><span class="sr-label">Professor(a)</span><span class="sr-value">{{ $ebd->professor }}</span></div>
    <div class="summary-row"><span class="sr-label">Tema</span><span class="sr-value">{{ $ebd->tema }}</span></div>
    <div class="summary-row"><span class="sr-label">Total de Presentes</span><span class="sr-value" style="font-family:var(--font-display);font-size:var(--text-2xl);color:var(--color-primary-700);">{{ $ebd->total_presentes }}</span></div>
    @if($ebd->observacoes)<div class="summary-row"><span class="sr-label">Observações</span><span class="sr-value">{{ $ebd->observacoes }}</span></div>@endif
  </div>
</div>
@endsection
