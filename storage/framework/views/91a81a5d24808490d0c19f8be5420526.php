<?php $__env->startSection('page-title','Relatórios'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div><h2 class="section-title">Relatórios</h2><p class="section-subtitle">Relatórios dominicais e mensais para acompanhamento pastoral</p></div>
  <div class="section-actions">
    <a href="<?php echo e(route('relatorios.mensal')); ?>" class="btn btn-primary">Relatório Mensal</a>
  </div>
</div>
<div class="card">
  <div class="card-header"><span class="card-title">Seleccionar Culto para Relatório Dominical</span></div>
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Pregador</th><th>Tema</th><th>Total Presentes</th><th>Oferta</th><th>Acção</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $cultos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><strong><?php echo e($c->data->translatedFormat('D, d/m/Y')); ?></strong></td>
          <td><?php echo e($c->pregador); ?></td>
          <td><?php echo e($c->tema_culto ?? '—'); ?></td>
          <td><?php echo e($c->presencaCulto?->total ?? '—'); ?></td>
          <td><?php echo e($c->oferta ? number_format($c->oferta->valor_total,0,',','.').' Kz' : '—'); ?></td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              <a href="<?php echo e(route('relatorios.dominical', $c)); ?>" class="btn btn-sm btn-primary">Ver Relatório</a>
              <a href="<?php echo e(route('relatorios.dominical.pdf', $c)); ?>" class="btn btn-sm btn-ghost">PDF</a>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6"><div class="empty-state"><p class="empty-state__title">Nenhum culto registado</p></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/relatorios/index.blade.php ENDPATH**/ ?>