@extends('layouts.app')
@section('page-title','Registar Classe Celestial')
@section('content')
<form method="POST" action="{{ route('celestial.store') }}">@csrf
<div class="section-header">
  <div>
    <h2 class="section-title">Registar Classe Celestial</h2>
    <p class="section-subtitle">Culto infantil — ocorre durante todo o período do culto + EBD</p>
  </div>
  <div class="section-actions">
    <a href="{{ route('celestial.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Registo</button>
  </div>
</div>

@if($errors->any())
<div class="alert alert-danger">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
  <ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="section-block" style="max-width:560px;">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    Contagem da Classe Celestial
  </div>

  <div class="form-group" style="margin-bottom:var(--space-5);">
    <label class="form-label">Culto correspondente <span class="req">*</span></label>
    <select name="evento_id" class="form-select" required>
      <option value="">— Seleccione o culto —</option>
      @foreach($cultos as $c)
        <option value="{{ $c->id }}" {{ old('evento_id') == $c->id ? 'selected' : '' }}>
          {{ $c->data->format('d/m/Y') }} — {{ $c->pregador }}
        </option>
      @endforeach
    </select>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);margin-bottom:var(--space-6);">
    <div class="count-wrap">
      <input type="number" name="total_criancas" class="count-big" value="{{ old('total_criancas', 0) }}" min="0" required>
      <div class="count-label">Total de Crianças</div>
    </div>
    <div class="count-wrap">
      <input type="number" name="total_professores" class="count-big" value="{{ old('total_professores', 0) }}" min="0" required>
      <div class="count-label">Professores / Auxiliares</div>
    </div>
  </div>

  <div class="form-group">
    <label class="form-label">Observações</label>
    <textarea name="observacoes" class="form-textarea" placeholder="Actividades realizadas, materiais utilizados, anotações...">{{ old('observacoes') }}</textarea>
  </div>
</div>
</form>
@endsection
