{{-- ===================== CULTO INDEX ===================== --}}
{{-- resources/views/pages/culto/index.blade.php --}}
@extends('layouts.app')
@section('page-title', 'Cultos Dominicais')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Cultos Dominicais</h2><p class="section-subtitle">Histórico de todos os cultos registados</p></div>
  <div class="section-actions"><a href="{{ route('cultos.create') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Novo Culto</a></div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Pregador</th><th>Tema</th><th>Adultos</th><th>Adol.</th><th>Crianças</th><th>Total</th><th>Oferta (Kz)</th><th>Visitantes</th><th>Acções</th></tr></thead>
      <tbody>
        @forelse($cultos as $c)
        <tr>
          <td><strong>{{ $c->data->translatedFormat('D, d/m/Y') }}</strong></td>
          <td>{{ $c->pregador }}</td>
          <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $c->tema_culto }}</td>
          <td>{{ $c->presencaCulto?->adultos ?? '—' }}</td>
          <td>{{ $c->presencaCulto?->adolescentes ?? '—' }}</td>
          <td>{{ $c->presencaCulto?->criancas ?? '—' }}</td>
          <td><strong>{{ $c->presencaCulto?->total ?? '—' }}</strong></td>
          <td>{{ number_format($c->total_ofertas, 0, ',', '.') }}</td>
          <td>{{ $c->visitantes->count() }}</td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              <a href="{{ route('relatorios.dominical', $c) }}" class="btn btn-sm btn-ghost">Relatório</a>
              <a href="{{ route('cultos.edit', $c) }}" class="btn btn-sm btn-secondary">Editar</a>
              <form method="POST" action="{{ route('cultos.destroy', $c) }}" onsubmit="return confirm('Eliminar este culto?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">✕</button></form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="10"><div class="empty-state"><div class="empty-state__icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg></div><p class="empty-state__title">Nenhum culto registado</p><p class="empty-state__desc">Clique em "Novo Culto" para começar.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);border-top:1px solid var(--color-neutral-100);">{{ $cultos->links() }}</div>
</div>
@endsection
