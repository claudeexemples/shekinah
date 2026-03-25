@extends('layouts.app')
@section('page-title','Registar EBD')
@section('content')
<form method="POST" action="{{ route('ebd.store') }}">@csrf
<div class="section-header">
  <div><h2 class="section-title">Registar EBD</h2><p class="section-subtitle">Escola Bíblica Dominical — aula única para toda a igreja</p></div>
  <div class="section-actions">
    <a href="{{ route('ebd.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar EBD</button>
  </div>
</div>
@if($errors->any())<div class="alert alert-danger"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg><ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<div class="section-block" style="max-width:700px;">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 016.5 2H20v20H6.5a2.5 2.5 0 010-5H20"/></svg>Dados da Aula</div>
  <div class="form-grid">
    <div class="form-group">
      <label class="form-label">Culto correspondente <span class="req">*</span></label>
      <select name="evento_id" class="form-select" required>
        <option value="">— Seleccione o culto —</option>
        @foreach($cultos as $c)<option value="{{ $c->id }}">{{ $c->data->format('d/m/Y') }} — {{ $c->pregador }}</option>@endforeach
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Professor(a) <span class="req">*</span></label>
      <input type="text" name="professor" class="form-input" placeholder="Nome do professor" value="{{ old('professor') }}" required>
    </div>
    <div class="form-group col-span-2">
      <label class="form-label">Tema da Aula <span class="req">*</span></label>
      <input type="text" name="tema" class="form-input" placeholder="Ex: Fundamentos da Fé Cristã" value="{{ old('tema') }}" required>
    </div>
  </div>
  <div class="divider"></div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);margin-bottom:var(--space-5);">
    <div class="count-wrap">
      <input type="number" name="total_presentes" id="ebd-pres" class="count-big" value="{{ old('total_presentes',0) }}" min="0" oninput="calcEbd()">
      <div class="count-label">Total de Presentes</div>
    </div>
    <div class="count-wrap">
      <input type="number" id="ebd-pct" class="count-big" readonly>
      <div class="count-label" style="color:var(--color-primary-600);">% em relação ao culto</div>
    </div>
  </div>
  <div class="alert alert-info">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    Percentagem calculada automaticamente com base no total do culto dominical seleccionado. Total de referência: <strong id="ref-total">{{ $ultimoCultoTotal }}</strong> presentes.
  </div>
  <div class="form-group">
    <label class="form-label">Observações</label>
    <textarea name="observacoes" class="form-textarea" placeholder="Anotações sobre a aula...">{{ old('observacoes') }}</textarea>
  </div>
</div>
</form>
@endsection
@push('scripts')
<script>
const refTotal = {{ $ultimoCultoTotal }};
function calcEbd() {
  const p = parseInt(document.getElementById('ebd-pres').value) || 0;
  document.getElementById('ebd-pct').value = refTotal > 0 ? Math.round(p/refTotal*100) + '%' : '—';
}
</script>
@endpush
