@extends('layouts.app')
@section('page-title','Ofertas')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Ofertas</h2><p class="section-subtitle">Registo de ofertas por culto (AOA — Kwanza)</p></div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-2);">
      <select name="mes" class="form-select" style="height:36px;width:auto;">@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $mes==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>@endfor</select>
      <select name="ano" class="form-select" style="height:36px;width:auto;">@for($a=2023;$a<=date('Y');$a++)<option value="{{ $a }}" {{ $ano==$a?'selected':'' }}>{{ $a }}</option>@endfor</select>
      <button type="submit" class="btn btn-secondary">Filtrar</button>
    </form>
    <a href="{{ route('financeiro.index') }}" class="btn btn-ghost">← Visão Geral</a>
  </div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Pregador</th><th>Tipo</th><th>Dinheiro</th><th>Transferência / EMIS</th><th>Multicaixa / TPA</th><th>Total</th></tr></thead>
      <tbody>
        @forelse($ofertas as $o)
        <tr>
          <td><strong>{{ $o->evento->data->format('d/m/Y') }}</strong></td>
          <td>{{ $o->evento->pregador ?? '—' }}</td>
          <td>{{ $o->tipo }}</td>
          <td>{{ number_format($o->valor_dinheiro,0,',','.') }} Kz</td>
          <td>{{ number_format($o->valor_transferencia,0,',','.') }} Kz</td>
          <td>{{ number_format($o->valor_cartao,0,',','.') }} Kz</td>
          <td><strong>{{ number_format($o->valor_total,0,',','.') }} Kz</strong></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><p class="empty-state__title">Nenhuma oferta registada no período</p></div></td></tr>
        @endforelse
      </tbody>
      @if($ofertas->isNotEmpty())
      <tfoot><tr style="background:var(--color-primary-50);">
        <td colspan="6" style="padding:var(--space-3) var(--space-4);font-weight:600;font-size:var(--text-sm);color:var(--color-primary-700);">Total do Período</td>
        <td style="padding:var(--space-3) var(--space-4);font-family:var(--font-display);font-weight:700;color:var(--color-primary-700);">{{ number_format($totalMes,0,',','.') }} Kz</td>
      </tr></tfoot>
      @endif
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);">{{ $ofertas->links() }}</div>
</div>
@endsection
