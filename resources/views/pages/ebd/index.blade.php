{{-- EBD INDEX --}}
{{-- resources/views/pages/ebd/index.blade.php --}}
@extends('layouts.app')
@section('page-title','EBD — Escola Bíblica Dominical')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">EBD — Escola Bíblica Dominical</h2><p class="section-subtitle">Aula única para toda a igreja</p></div>
  <div class="section-actions"><a href="{{ route('ebd.create') }}" class="btn btn-primary">+ Nova EBD</a></div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Professor(a)</th><th>Tema</th><th>Presentes</th><th>Acções</th></tr></thead>
      <tbody>
        @forelse($registros as $r)
        <tr>
          <td><strong>{{ $r->evento->data->translatedFormat('D, d/m/Y') }}</strong></td>
          <td>{{ $r->professor }}</td>
          <td>{{ $r->tema }}</td>
          <td><strong>{{ $r->total_presentes }}</strong></td>
          <td>
            <form method="POST" action="{{ route('ebd.destroy', $r) }}" onsubmit="return confirm('Eliminar registo?')">@csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="empty-state"><p class="empty-state__title">Nenhuma EBD registada</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);">{{ $registros->links() }}</div>
</div>
@endsection
