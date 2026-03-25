<?php $__env->startSection('page-title','Ofertas'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div><h2 class="section-title">Ofertas</h2><p class="section-subtitle">Registo de ofertas por culto (AOA — Kwanza)</p></div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-2);">
      <select name="mes" class="form-select" style="height:36px;width:auto;"><?php for($m=1;$m<=12;$m++): ?><option value="<?php echo e($m); ?>" <?php echo e($mes==$m?'selected':''); ?>><?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?></option><?php endfor; ?></select>
      <select name="ano" class="form-select" style="height:36px;width:auto;"><?php for($a=2023;$a<=date('Y');$a++): ?><option value="<?php echo e($a); ?>" <?php echo e($ano==$a?'selected':''); ?>><?php echo e($a); ?></option><?php endfor; ?></select>
      <button type="submit" class="btn btn-secondary">Filtrar</button>
    </form>
    <a href="<?php echo e(route('financeiro.index')); ?>" class="btn btn-ghost">← Visão Geral</a>
  </div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Pregador</th><th>Tipo</th><th>Dinheiro</th><th>Transferência / EMIS</th><th>Multicaixa / TPA</th><th>Total</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $ofertas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><strong><?php echo e($o->evento->data->format('d/m/Y')); ?></strong></td>
          <td><?php echo e($o->evento->pregador ?? '—'); ?></td>
          <td><?php echo e($o->tipo); ?></td>
          <td><?php echo e(number_format($o->valor_dinheiro,0,',','.')); ?> Kz</td>
          <td><?php echo e(number_format($o->valor_transferencia,0,',','.')); ?> Kz</td>
          <td><?php echo e(number_format($o->valor_cartao,0,',','.')); ?> Kz</td>
          <td><strong><?php echo e(number_format($o->valor_total,0,',','.')); ?> Kz</strong></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7"><div class="empty-state"><p class="empty-state__title">Nenhuma oferta registada no período</p></div></td></tr>
        <?php endif; ?>
      </tbody>
      <?php if($ofertas->isNotEmpty()): ?>
      <tfoot><tr style="background:var(--color-primary-50);">
        <td colspan="6" style="padding:var(--space-3) var(--space-4);font-weight:600;font-size:var(--text-sm);color:var(--color-primary-700);">Total do Período</td>
        <td style="padding:var(--space-3) var(--space-4);font-family:var(--font-display);font-weight:700;color:var(--color-primary-700);"><?php echo e(number_format($totalMes,0,',','.')); ?> Kz</td>
      </tr></tfoot>
      <?php endif; ?>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);"><?php echo e($ofertas->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/financeiro/ofertas.blade.php ENDPATH**/ ?>