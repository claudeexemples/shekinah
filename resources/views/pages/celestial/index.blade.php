@extends('layouts.app')
@section('page-title','Classe Celestial')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Classe Celestial</h2><p class="section-subtitle">Culto infantil — ocorre durante o culto + EBD</p></div>
  <div class="section-actions"><a href="{{ route('celestial.create') }}" class="btn btn-primary">+ Novo Registo</a></div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Crianças</th><th>Professores / Auxiliares</th><th>Observações</th><th>Acções</th></tr></thead>
      <tbody>
        @forelse($registros as $r)
        <tr>
          <td><strong>{{ $r->evento->data->translatedFormat('D, d/m/Y') }}</strong></td>
          <td><strong>{{ $r->total_criancas }}</strong></td>
          <td>{{ $r->total_professores }}</td>
          <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->observacoes ?? '—' }}</td>
          <td>
            <form method="POST" action="{{ route('celestial.destroy', $r) }}" onsubmit="return confirm('Eliminar registo?')">@csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="empty-state"><p class="empty-state__title">Nenhum registo encontrado</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);">{{ $registros->links() }}</div>
</div>
@endsection
