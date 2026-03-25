@extends('layouts.app')
@section('page-title', 'Novo Registo de Culto')

@section('content')
<form method="POST" action="{{ route('cultos.store') }}" id="culto-form">
@csrf

<div class="section-header">
  <div>
    <h2 class="section-title">Novo Registo de Culto</h2>
    <p class="section-subtitle">Preencha as informações do culto dominical</p>
  </div>
  <div class="section-actions">
    <a href="{{ route('cultos.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      Guardar Registo
    </button>
  </div>
</div>

@if($errors->any())
<div class="alert alert-danger">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
  <ul style="margin:0;padding-left:var(--space-4);">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

{{-- Informações Gerais --}}
<div class="section-block">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    Informações Gerais
  </div>
  <div class="form-grid">
    <div class="form-group">
      <label class="form-label">Data do Culto <span class="req">*</span></label>
      <input type="date" name="data" class="form-input" value="{{ old('data', date('Y-m-d')) }}" required>
    </div>
    <div class="form-group">
      <label class="form-label">Hora de Início</label>
      <input type="time" name="horario_inicio" class="form-input" value="{{ old('horario_inicio', '09:00') }}">
    </div>
    <div class="form-group">
      <label class="form-label">Hora de Término</label>
      <input type="time" name="horario_fim" class="form-input" value="{{ old('horario_fim', '11:30') }}">
    </div>
    <div class="form-group">
      <label class="form-label">Pregador <span class="req">*</span></label>
      <input type="text" name="pregador" class="form-input" placeholder="Ex: Pr. António Mukendi" value="{{ old('pregador') }}" required>
    </div>
    <div class="form-group col-span-2">
      <label class="form-label">Tema do Culto</label>
      <input type="text" name="tema_culto" class="form-input" placeholder="Ex: O Poder da Ressurreição" value="{{ old('tema_culto') }}">
    </div>
  </div>
</div>

{{-- Contagem --}}
<div class="section-block">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
    Contagem de Presença
  </div>
  <div class="grid-4">
    <div class="count-wrap">
      <input type="number" name="adultos" id="qt-adultos" class="count-big" value="{{ old('adultos', 0) }}" min="0" oninput="calcTotal()">
      <div class="count-label">Adultos</div>
    </div>
    <div class="count-wrap">
      <input type="number" name="adolescentes" id="qt-adol" class="count-big" value="{{ old('adolescentes', 0) }}" min="0" oninput="calcTotal()">
      <div class="count-label">Adolescentes</div>
    </div>
    <div class="count-wrap">
      <input type="number" name="criancas" id="qt-cri" class="count-big" value="{{ old('criancas', 0) }}" min="0" oninput="calcTotal()">
      <div class="count-label">Crianças</div>
    </div>
    <div class="count-wrap">
      <input type="number" id="qt-total" class="count-big" readonly value="{{ old('adultos', 0) + old('adolescentes', 0) + old('criancas', 0) }}">
      <div class="count-label" style="color:var(--color-primary-600);">Total Automático</div>
    </div>
  </div>
</div>

{{-- Visitantes --}}
<div class="section-block">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    Visitantes Destacados
  </div>
  <div id="visitor-list"></div>
  <button type="button" class="btn btn-ghost" style="margin-top:var(--space-4);" onclick="addVisitor()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Adicionar Visitante
  </button>
</div>

{{-- Ofertas --}}
<div class="section-block">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
    Ofertas do Culto <span style="font-size:var(--text-sm);color:var(--color-neutral-400);font-weight:400;">(múltiplos tipos)</span>
  </div>
  <div id="offers-list"></div>
  <button type="button" class="btn btn-ghost" onclick="addOffer()">+ Adicionar tipo de oferta</button>
</div>

{{-- Observações --}}
<div class="section-block">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    Observações
  </div>
  <div class="form-group">
    <textarea name="observacoes" class="form-textarea" placeholder="Anotações, comunicados, momentos especiais do culto...">{{ old('observacoes') }}</textarea>
  </div>
</div>

</form>
@endsection

@push('scripts')
<script>
let vc = 0;

function calcTotal() {
  const a = parseInt(document.getElementById('qt-adultos').value) || 0;
  const b = parseInt(document.getElementById('qt-adol').value) || 0;
  const c = parseInt(document.getElementById('qt-cri').value) || 0;
  document.getElementById('qt-total').value = a + b + c;
}



let oc = 0;
function addOffer() {
  const list = document.getElementById('offers-list');
  const div = document.createElement('div');
  div.className = 'section-block';
  div.style.marginBottom = '12px';
  div.innerHTML = `
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Tipo</label>
        <select name="ofertas[${oc}][tipo]" class="form-select">
          <option>Oferta de Louvor</option><option>Dízimos e Ofertas</option><option>Missões</option><option>Oferta de Gratidão</option><option>Oferta Especial</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">Dinheiro</label><input type="number" step="0.01" min="0" name="ofertas[${oc}][valor_dinheiro]" class="form-input"></div>
      <div class="form-group"><label class="form-label">Transferência</label><input type="number" step="0.01" min="0" name="ofertas[${oc}][valor_transferencia]" class="form-input"></div>
      <div class="form-group"><label class="form-label">TPA</label><input type="number" step="0.01" min="0" name="ofertas[${oc}][valor_cartao]" class="form-input"></div>
      <div class="form-group col-span-2"><label class="form-label">Observação</label><input type="text" name="ofertas[${oc}][observacao]" class="form-input"></div>
    </div>
    <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()">Remover</button>
  `;
  list.appendChild(div);
  oc++;
}
addOffer();

function addVisitor() {
  vc++;
  const list = document.getElementById('visitor-list');
  const div  = document.createElement('div');
  div.className = 'visitor-row';
  div.dataset.vc = vc;
  div.innerHTML = `
    <div class="form-group">
      <label class="form-label">Nome</label>
      <input type="text" name="visitantes[${vc}][nome]" class="form-input" placeholder="Nome completo">
    </div>
    <div class="form-group">
      <label class="form-label">Telefone</label>
      <input type="tel" name="visitantes[${vc}][telefone]" class="form-input" placeholder="9XX XXX XXX">
    </div>
    <div class="form-group">
      <label class="form-label">Bairro</label>
      <input type="text" name="visitantes[${vc}][bairro]" class="form-input" placeholder="Ex: Rangel, Cazenga...">
    </div>
    <button type="button" class="visitor-remove" onclick="this.closest('.visitor-row').remove()" title="Remover">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
    </button>
  `;
  list.appendChild(div);
}
</script>
@endpush
