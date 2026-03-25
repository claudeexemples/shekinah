@extends('layouts.app')
@section('page-title','Relatórios')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Relatórios</h2><p class="section-subtitle">Relatórios dominicais e mensais para acompanhamento pastoral</p></div>
  <div class="section-actions">
    <a href="{{ route('relatorios.mensal') }}" class="btn btn-primary">Relatório Mensal</a>
  </div>
</div>
<div class="card">
  <div class="card-header"><span class="card-title">Seleccionar Culto para Relatório Dominical</span></div>
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Pregador</th><th>Tema</th><th>Total Presentes</th><th>Oferta</th><th>Acção</th></tr></thead>
      <tbody>
        @forelse($cultos as $c)
        <tr>
          <td><strong>{{ $c->data->translatedFormat('D, d/m/Y') }}</strong></td>
          <td>{{ $c->pregador }}</td>
          <td>{{ $c->tema_culto ?? '—' }}</td>
          <td>{{ $c->presencaCulto?->total ?? '—' }}</td>
          <td>{{ number_format($c->total_ofertas,0,',','.') }} Kz</td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              <a href="{{ route('relatorios.dominical', $c) }}" class="btn btn-sm btn-primary">Ver Relatório</a>
              <a href="{{ route('relatorios.dominical.pdf', $c) }}" class="btn btn-sm btn-ghost">PDF</a>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state"><p class="empty-state__title">Nenhum culto registado</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
