@extends('layouts.app')
@section('page-title','Editar Culto')
@section('content')
<form method="POST" action="{{ route('cultos.update', $culto) }}">
@csrf @method('PUT')
<div class="section-header">
  <div><h2 class="section-title">Editar Culto</h2><p class="section-subtitle">{{ $culto->data->translatedFormat('D, d/m/Y') }}</p></div>
  <div class="section-actions">
    <a href="{{ route('cultos.show', $culto) }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Alterações</button>
  </div>
</div>
<div class="section-block">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Informações Gerais</div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Data <span class="req">*</span></label><input type="date" name="data" class="form-input" value="{{ old('data', $culto->data->format('Y-m-d')) }}" required></div>
    <div class="form-group"><label class="form-label">Hora de Início</label><input type="time" name="horario_inicio" class="form-input" value="{{ old('horario_inicio', $culto->horario_inicio) }}"></div>
    <div class="form-group"><label class="form-label">Hora de Término</label><input type="time" name="horario_fim" class="form-input" value="{{ old('horario_fim', $culto->horario_fim) }}"></div>
    <div class="form-group"><label class="form-label">Pregador <span class="req">*</span></label><input type="text" name="pregador" class="form-input" value="{{ old('pregador', $culto->pregador) }}" required></div>
    <div class="form-group col-span-2"><label class="form-label">Tema do Culto</label><input type="text" name="tema_culto" class="form-input" value="{{ old('tema_culto', $culto->tema_culto) }}"></div>
  </div>
</div>
<div class="section-block">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Contagem de Presença</div>
  <div class="grid-3">
    <div class="count-wrap"><input type="number" name="adultos" id="qt-adultos" class="count-big" value="{{ old('adultos', $culto->presencaCulto?->adultos ?? 0) }}" min="0" oninput="calcTotal()"><div class="count-label">Adultos</div></div>
    <div class="count-wrap"><input type="number" name="adolescentes" id="qt-adol" class="count-big" value="{{ old('adolescentes', $culto->presencaCulto?->adolescentes ?? 0) }}" min="0" oninput="calcTotal()"><div class="count-label">Adolescentes</div></div>
    <div class="count-wrap"><input type="number" name="criancas" id="qt-cri" class="count-big" value="{{ old('criancas', $culto->presencaCulto?->criancas ?? 0) }}" min="0" oninput="calcTotal()"><div class="count-label">Crianças</div></div>
  </div>
</div>
<div class="section-block">
  <div class="form-group"><label class="form-label">Observações</label><textarea name="observacoes" class="form-textarea">{{ old('observacoes', $culto->observacoes) }}</textarea></div>
</div>
</form>
@endsection
@push('scripts')
<script>
function calcTotal() {
  // display only — total not stored as column
}
</script>
@endpush
