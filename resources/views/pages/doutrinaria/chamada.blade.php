@extends('layouts.app')
@section('page-title','Chamada — Classe Doutrinária')

@section('content')
<form method="POST" action="{{ route('doutrinaria.chamada.store') }}">
@csrf
<input type="hidden" name="turma_id" value="{{ $turmaActiva->id }}">

<div class="section-header">
  <div>
    <h2 class="section-title">Fazer Chamada</h2>
    <p class="section-subtitle">{{ $turmaActiva->nome }} · Prof. {{ $turmaActiva->professor }}</p>
  </div>
  <div class="section-actions">
    <a href="{{ route('doutrinaria.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Chamada</button>
  </div>
</div>

<div class="section-block">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Dados da Aula</div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Número da Aula <span class="req">*</span></label><input type="number" name="aula_numero" class="form-input" value="{{ $aulaActual }}" min="1" required style="max-width:120px;"></div>
    <div class="form-group"><label class="form-label">Data da Aula <span class="req">*</span></label><input type="date" name="data_aula" class="form-input" value="{{ date('Y-m-d') }}" required style="max-width:200px;"></div>
    <div class="form-group col-span-2"><label class="form-label">Tema da Aula</label><input type="text" name="tema_aula" class="form-input" placeholder="Ex: O Baptismo nas Águas — Significado e Propósito"></div>
  </div>
</div>

<div class="section-block">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/></svg>Lista de Presença — {{ $candidatos->count() }} candidatos</div>
  <div style="display:flex;flex-direction:column;gap:var(--space-3);margin-bottom:var(--space-5);">
    @foreach($candidatos as $c)
    <div class="candidate-row {{ $c->is_novo ? 'is-new' : '' }}" id="row-{{ $c->id }}">
      <input type="checkbox" class="cand-check" name="presentes[]" value="{{ $c->id }}" id="chk-{{ $c->id }}" onchange="updateCount()" checked>
      <label for="chk-{{ $c->id }}" style="display:flex;align-items:center;gap:var(--space-2);cursor:pointer;font-weight:600;color:var(--color-neutral-800);font-size:var(--text-sm);">
        {{ $c->nome }}
        @if($c->is_novo)<span class="badge badge-warning">Novo</span>@endif
        @if($c->em_risco)<span class="badge badge-danger">Risco</span>@endif
      </label>
      <span style="font-size:var(--text-xs);color:var(--color-neutral-400);">{{ $c->telefone ?? '—' }}</span>
      <span style="font-size:var(--text-xs);font-weight:600;color:var(--color-neutral-500);">{{ $c->percentual_presenca }}% freq.</span>
    </div>
    @endforeach
  </div>
  <div style="display:flex;align-items:center;justify-content:space-between;padding:var(--space-4) var(--space-5);background:var(--color-neutral-50);border:1px solid var(--color-neutral-200);border-radius:var(--radius-lg);">
    <div style="display:flex;gap:var(--space-8);">
      <div><span style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-success-700);" id="count-pres">{{ $candidatos->count() }}</span><span style="font-size:var(--text-sm);color:var(--color-neutral-500);margin-left:6px;">presentes</span></div>
      <div><span style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-danger-600);" id="count-aus">0</span><span style="font-size:var(--text-sm);color:var(--color-neutral-500);margin-left:6px;">ausentes</span></div>
    </div>
    <div style="display:flex;gap:var(--space-3);">
      <button type="button" class="btn btn-ghost btn-sm" onclick="selectAll(true)">Marcar todos</button>
      <button type="button" class="btn btn-ghost btn-sm" onclick="selectAll(false)">Desmarcar todos</button>
    </div>
  </div>
</div>
</form>
@endsection

@push('scripts')
<script>
const totalCandidatos = {{ $candidatos->count() }};
function updateCount() {
  const checks = document.querySelectorAll('.cand-check');
  let pres = 0;
  checks.forEach(c => {
    const row = document.getElementById('row-' + c.value);
    if (c.checked) { pres++; row?.classList.remove('absent'); }
    else { row?.classList.add('absent'); }
  });
  document.getElementById('count-pres').textContent = pres;
  document.getElementById('count-aus').textContent  = totalCandidatos - pres;
}
function selectAll(state) {
  document.querySelectorAll('.cand-check').forEach(c => c.checked = state);
  updateCount();
}
updateCount();
</script>
@endpush
