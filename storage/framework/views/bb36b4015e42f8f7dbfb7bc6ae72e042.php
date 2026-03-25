<?php $__env->startSection('page-title','Financeiro'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div><h2 class="section-title">Financeiro</h2><p class="section-subtitle">Controlo de ofertas, despesas e fluxo de caixa (Kwanza — AOA)</p></div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-2);">
      <select name="mes" class="form-select" style="height:36px;width:auto;">
        <?php for($m=1;$m<=12;$m++): ?><option value="<?php echo e($m); ?>" <?php echo e($mes==$m?'selected':''); ?>><?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?></option><?php endfor; ?>
      </select>
      <select name="ano" class="form-select" style="height:36px;width:auto;">
        <?php for($a=2023;$a<=date('Y');$a++): ?><option value="<?php echo e($a); ?>" <?php echo e($ano==$a?'selected':''); ?>><?php echo e($a); ?></option><?php endfor; ?>
      </select>
      <button type="submit" class="btn btn-secondary">Filtrar</button>
    </form>
    <button class="btn btn-ghost" onclick="openModal('modal-despesa')">+ Despesa</button>
    <a href="<?php echo e(route('relatorios.mensal')); ?>" class="btn btn-primary">Relatório Mensal</a>
  </div>
</div>

<div class="flow-grid">
  <div class="flow-card flow-card--in">
    <div class="flow-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
    <div><div class="flow-value"><?php echo e(number_format($totalReceitas,0,',','.')); ?> Kz</div><div class="flow-label">Receitas do período</div></div>
  </div>
  <div class="flow-card flow-card--out">
    <div class="flow-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg></div>
    <div><div class="flow-value"><?php echo e(number_format($totalDespesas,0,',','.')); ?> Kz</div><div class="flow-label">Despesas do período</div></div>
  </div>
  <div class="flow-card flow-card--balance">
    <div class="flow-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
    <div><div class="flow-value" style="color:<?php echo e($saldo>=0?'var(--color-primary-700)':'var(--color-danger-700)'); ?>;"><?php echo e(number_format($saldo,0,',','.')); ?> Kz</div><div class="flow-label">Saldo do período</div></div>
  </div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="card">
    <div class="card-header"><span class="card-title">Receitas vs Despesas (últimos 6 meses)</span></div>
    <div class="card-body">
      <?php $maxVal = collect($grafico)->max(fn($g) => max($g['receitas'],$g['despesas'])); ?>
      <div class="bar-chart">
        <?php $__currentLoopData = $grafico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $pr = $maxVal>0?round($g['receitas']/$maxVal*100):0; $pd = $maxVal>0?round($g['despesas']/$maxVal*100):0; ?>
        <div class="bar-group">
          <div style="display:flex;gap:2px;align-items:flex-end;height:100%;width:100%;">
            <div class="bar bar--primary" style="height:<?php echo e($pr); ?>%;flex:1;" title="<?php echo e(number_format($g['receitas'],0,',','.')); ?> Kz"></div>
            <div class="bar bar--accent"  style="height:<?php echo e($pd); ?>%;flex:1;" title="<?php echo e(number_format($g['despesas'],0,',','.')); ?> Kz"></div>
          </div>
          <div class="bar-label"><?php echo e($g['mes']); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div style="display:flex;gap:var(--space-5);margin-top:var(--space-3);">
        <span style="display:flex;align-items:center;gap:6px;font-size:var(--text-xs);color:var(--color-neutral-500);"><span style="width:10px;height:10px;background:var(--color-primary-500);border-radius:2px;display:inline-block;"></span>Receitas</span>
        <span style="display:flex;align-items:center;gap:6px;font-size:var(--text-xs);color:var(--color-neutral-500);"><span style="width:10px;height:10px;background:var(--color-accent-400);border-radius:2px;display:inline-block;"></span>Despesas</span>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><span class="card-title">Maiores Despesas do Período</span></div>
    <div class="card-body">
      <?php $totalD = $maiorDespesas->sum('valor'); ?>
      <?php $__currentLoopData = $maiorDespesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $pct = $totalD>0?round($d->valor/$totalD*100):0; ?>
      <div class="summary-row"><span class="sr-label"><?php echo e($d->descricao); ?></span><span class="sr-value"><?php echo e(number_format($d->valor,0,',','.')); ?> Kz</span></div>
      <div class="progress-bar" style="margin-bottom:var(--space-3);"><div class="progress-fill pf-primary" style="width:<?php echo e($pct); ?>%"></div></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php if($maiorDespesas->isEmpty()): ?><p style="color:var(--color-neutral-400);font-size:var(--text-sm);text-align:center;">Nenhuma despesa no período.</p><?php endif; ?>
      <div style="margin-top:var(--space-4);display:flex;gap:var(--space-3);">
        <a href="<?php echo e(route('financeiro.ofertas')); ?>" class="btn btn-sm btn-ghost">Ver ofertas →</a>
        <a href="<?php echo e(route('financeiro.despesas')); ?>" class="btn btn-sm btn-ghost">Ver despesas →</a>
      </div>
    </div>
  </div>
</div>

<?php $__env->startPush('modals'); ?>
<div class="modal-overlay" id="modal-despesa">
  <div class="modal">
    <div class="modal-header"><h3 class="modal-title">Nova Despesa</h3><button class="modal-close" onclick="closeModal('modal-despesa')"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>
    <form method="POST" action="<?php echo e(route('financeiro.despesas.store')); ?>"><?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group"><label class="form-label">Data <span class="req">*</span></label><input type="date" name="data" class="form-input" value="<?php echo e(date('Y-m-d')); ?>" required></div>
          <div class="form-group"><label class="form-label">Valor (Kz) <span class="req">*</span></label><input type="number" name="valor" class="form-input" placeholder="0.00" step="0.01" min="0" required></div>
          <div class="form-group col-span-2"><label class="form-label">Descrição <span class="req">*</span></label><input type="text" name="descricao" class="form-input" placeholder="Ex: Factura de energia eléctrica" required></div>
          <div class="form-group"><label class="form-label">Categoria</label>
            <select name="categoria" class="form-select"><option>Utilidades</option><option>Manutenção</option><option>Material</option><option>Eventos</option><option>Missões</option><option>Outros</option></select>
          </div>
          <div class="form-group"><label class="form-label">Forma de Pagamento</label>
            <select name="forma_pagamento" class="form-select"><option value="dinheiro">Dinheiro</option><option value="transferencia">Transferência Bancária</option><option value="multicaixa">Multicaixa / TPA</option><option value="cartao">Cartão</option><option value="cheque">Cheque</option></select>
          </div>
          <div class="form-group col-span-2"><label class="form-label">Observação</label><textarea name="observacao" class="form-textarea" style="min-height:70px;"></textarea></div>
        </div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" onclick="closeModal('modal-despesa')">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Despesa</button></div>
    </form>
  </div>
</div>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/financeiro/index.blade.php ENDPATH**/ ?>