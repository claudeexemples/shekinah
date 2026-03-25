@extends('layouts.app')
@section('page-title','Nova Turma Doutrinária')
@section('content')
<form method="POST" action="{{ route('doutrinaria.turmas.store') }}">@csrf
<div class="section-header">
  <div><h2 class="section-title">Nova Turma Doutrinária</h2><p class="section-subtitle">Criar e activar uma nova turma de candidatos ao baptismo</p></div>
  <div class="section-actions"><a href="{{ route('doutrinaria.index') }}" class="btn btn-secondary">Cancelar</a><button type="submit" class="btn btn-primary">Criar Turma</button></div>
</div>
<div class="alert alert-warning"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg><div>Ao criar uma nova turma, a turma activa actual será <strong>desactivada automaticamente</strong>.</div></div>
<div class="section-block" style="max-width:700px;">
  <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Dados da Turma</div>
  <div class="form-grid">
    <div class="form-group col-span-2"><label class="form-label">Nome da Turma <span class="req">*</span></label><input type="text" name="nome" class="form-input" placeholder="Ex: Turma Pentecostes 2025" value="{{ old('nome') }}" required></div>
    <div class="form-group"><label class="form-label">Professor <span class="req">*</span></label><input type="text" name="professor" class="form-input" placeholder="Nome do professor" value="{{ old('professor') }}" required></div>
    <div class="form-group"><label class="form-label">Sala</label><input type="text" name="sala" class="form-input" placeholder="Ex: Sala 2 — Piso Superior" value="{{ old('sala') }}"></div>
    <div class="form-group"><label class="form-label">Data de Início <span class="req">*</span></label><input type="date" name="data_inicio" class="form-input" value="{{ old('data_inicio', date('Y-m-d')) }}" required></div>
    <div class="form-group"><label class="form-label">Data de Fim Prevista</label><input type="date" name="data_fim_prevista" class="form-input" value="{{ old('data_fim_prevista') }}"></div>
    <div class="form-group"><label class="form-label">Total de Aulas Previstas</label><input type="number" name="total_aulas" class="form-input" value="{{ old('total_aulas', 12) }}" min="1" max="52"></div>
    <div class="form-group"><label class="form-label">Data do Baptismo Prevista</label><input type="date" name="data_batismo_prevista" class="form-input" value="{{ old('data_batismo_prevista') }}"></div>
  </div>
</div>
</form>
@endsection
