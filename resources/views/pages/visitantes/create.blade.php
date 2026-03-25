@extends('layouts.app')
@section('page-title','Registar Visitante')
@section('content')
<form method="POST" action="{{ route('visitantes.store') }}">@csrf
<div class="section-header">
  <div><h2 class="section-title">Registar Visitante</h2><p class="section-subtitle">Cadastrar novo visitante para acompanhamento pastoral</p></div>
  <div class="section-actions"><a href="{{ route('visitantes.index') }}" class="btn btn-secondary">Cancelar</a><button type="submit" class="btn btn-primary">Guardar Visitante</button></div>
</div>
@if($errors->any())<div class="alert alert-danger"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg><ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<div class="section-block" style="max-width:720px;">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Dados do Visitante</div>
  <div class="form-grid">
    <div class="form-group col-span-2"><label class="form-label">Nome completo <span class="req">*</span></label><input type="text" name="nome" class="form-input" placeholder="Ex: Maria Conceição dos Santos" value="{{ old('nome') }}" required></div>
    <div class="form-group"><label class="form-label">Telefone</label><input type="tel" name="telefone" class="form-input" placeholder="9XX XXX XXX" value="{{ old('telefone') }}"></div>
    <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-input" placeholder="email@exemplo.com" value="{{ old('email') }}"></div>
    <div class="form-group"><label class="form-label">Data da visita <span class="req">*</span></label><input type="date" name="data_visita" class="form-input" value="{{ old('data_visita', date('Y-m-d')) }}" required></div>
    <div class="form-group"><label class="form-label">Tipo</label>
      <select name="tipo" class="form-select">
        <option value="adulto" {{ old('tipo')=='adulto'?'selected':'' }}>Adulto</option>
        <option value="adolescente" {{ old('tipo')=='adolescente'?'selected':'' }}>Adolescente</option>
        <option value="crianca" {{ old('tipo')=='crianca'?'selected':'' }}>Criança</option>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Bairro / Município</label><input type="text" name="bairro" class="form-input" placeholder="Ex: Rangel, Cazenga, Viana..." value="{{ old('bairro') }}"></div>
    <div class="form-group"><label class="form-label">Província</label>
      <select name="provincia" class="form-select">
        @foreach(['Luanda','Benguela','Huambo','Huíla','Cabinda','Kwanza Norte','Kwanza Sul','Malanje','Uíge','Zaire','Moxico','Lunda Norte','Lunda Sul','Bié','Cuando Cubango','Cunene','Namibe','Bengo'] as $prov)
        <option value="{{ $prov }}" {{ old('provincia','Luanda')==$prov?'selected':'' }}>{{ $prov }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group col-span-2"><label class="form-label">Como conheceu a igreja</label>
      <select name="como_conheceu" class="form-select">
        <option>Convite de familiar</option><option>Convite de amigo</option>
        <option>Redes sociais</option><option>Transmissão online (YouTube/Facebook)</option>
        <option>Passou pela frente</option><option>Buscador online</option><option>Outro</option>
      </select>
    </div>
    <div class="form-group col-span-2" style="flex-direction:row;align-items:center;gap:12px;">
      <input type="checkbox" name="primeira_visita" value="1" id="chk-pv" style="width:18px;height:18px;" {{ old('primeira_visita',1)?'checked':'' }}>
      <label for="chk-pv" class="form-label" style="cursor:pointer;margin:0;">É a primeira vez que visita a nossa igreja</label>
    </div>
    <div class="form-group col-span-2"><label class="form-label">Observações</label><textarea name="observacoes" class="form-textarea" placeholder="Informações adicionais relevantes para o acompanhamento pastoral...">{{ old('observacoes') }}</textarea></div>
  </div>
</div>
</form>
@endsection
