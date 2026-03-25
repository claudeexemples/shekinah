@extends('layouts.app')
@section('page-title','Despesas')
@section('content')
<div class="section-header">
  <div><h2 class="section-title">Despesas</h2><p class="section-subtitle">Lançamento e controlo de despesas (AOA — Kwanza)</p></div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-2);">
      <select name="mes" class="form-select" style="height:36px;width:auto;">@for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $mes==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>@endfor</select>
      <select name="ano" class="form-select" style="height:36px;width:auto;">@for($a=2023;$a<=date('Y');$a++)<option value="{{ $a }}" {{ $ano==$a?'selected':'' }}>{{ $a }}</option>@endfor</select>
      <button type="submit" class="btn btn-secondary">Filtrar</button>
    </form>
    <button class="btn btn-primary" onclick="openModal('modal-despesa')">+ Nova Despesa</button>
  </div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Descrição</th><th>Categoria</th><th>Forma Pagamento</th><th>Valor</th><th>Acções</th></tr></thead>
      <tbody>
        @forelse($despesas as $d)
        <tr>
          <td>{{ $d->data->format('d/m/Y') }}</td>
          <td><strong>{{ $d->descricao }}</strong></td>
          <td><span class="badge badge-neutral">{{ $d->categoria }}</span></td>
          <td>{{ $d->forma_pagamento_label }}</td>
          <td><strong>{{ number_format($d->valor,0,',','.') }} Kz</strong></td>
          <td>
            <form method="POST" action="{{ route('financeiro.despesas.destroy', $d) }}" onsubmit="return confirm('Eliminar despesa?')">@csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state"><p class="empty-state__title">Nenhuma despesa no período</p></div></td></tr>
        @endforelse
      </tbody>
      @if($despesas->isNotEmpty())
      <tfoot><tr style="background:var(--color-danger-50);">
        <td colspan="4" style="padding:var(--space-3) var(--space-4);font-weight:600;font-size:var(--text-sm);color:var(--color-danger-700);">Total do Período</td>
        <td style="padding:var(--space-3) var(--space-4);font-family:var(--font-display);font-weight:700;color:var(--color-danger-700);">{{ number_format($totalMes,0,',','.') }} Kz</td>
        <td></td>
      </tr></tfoot>
      @endif
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);">{{ $despesas->links() }}</div>
</div>
@push('modals')
<div class="modal-overlay" id="modal-despesa">
  <div class="modal">
    <div class="modal-header"><h3 class="modal-title">Nova Despesa</h3><button class="modal-close" onclick="closeModal('modal-despesa')"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>
    <form method="POST" action="{{ route('financeiro.despesas.store') }}">@csrf
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group"><label class="form-label">Data <span class="req">*</span></label><input type="date" name="data" class="form-input" value="{{ date('Y-m-d') }}" required></div>
          <div class="form-group"><label class="form-label">Valor (Kz) <span class="req">*</span></label><input type="number" name="valor" class="form-input" placeholder="0.00" step="0.01" min="0" required></div>
          <div class="form-group col-span-2"><label class="form-label">Descrição <span class="req">*</span></label><input type="text" name="descricao" class="form-input" placeholder="Ex: Factura de energia eléctrica" required></div>
          <div class="form-group"><label class="form-label">Categoria</label><select name="categoria" class="form-select"><option>Utilidades</option><option>Manutenção</option><option>Material</option><option>Eventos</option><option>Missões</option><option>Outros</option></select></div>
          <div class="form-group"><label class="form-label">Forma de Pagamento</label><select name="forma_pagamento" class="form-select"><option value="dinheiro">Dinheiro</option><option value="transferencia">Transferência Bancária</option><option value="multicaixa">Multicaixa / TPA</option><option value="cartao">Cartão</option></select></div>
          <div class="form-group col-span-2"><label class="form-label">Observação</label><textarea name="observacao" class="form-textarea" style="min-height:70px;"></textarea></div>
        </div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" onclick="closeModal('modal-despesa')">Cancelar</button><button type="submit" class="btn btn-primary">Guardar</button></div>
    </form>
  </div>
</div>
@endpush
@endsection
