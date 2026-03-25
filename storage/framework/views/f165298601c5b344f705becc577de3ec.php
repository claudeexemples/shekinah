<?php $__env->startSection('page-title', 'Cultos Dominicais'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div><h2 class="section-title">Cultos Dominicais</h2><p class="section-subtitle">Histórico de todos os cultos registados</p></div>
  <div class="section-actions"><a href="<?php echo e(route('cultos.create')); ?>" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Novo Culto</a></div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Pregador</th><th>Tema</th><th>Adultos</th><th>Adol.</th><th>Crianças</th><th>Total</th><th>Oferta (Kz)</th><th>Visitantes</th><th>Acções</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $cultos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><strong><?php echo e($c->data->translatedFormat('D, d/m/Y')); ?></strong></td>
          <td><?php echo e($c->pregador); ?></td>
          <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($c->tema_culto); ?></td>
          <td><?php echo e($c->presencaCulto?->adultos ?? '—'); ?></td>
          <td><?php echo e($c->presencaCulto?->adolescentes ?? '—'); ?></td>
          <td><?php echo e($c->presencaCulto?->criancas ?? '—'); ?></td>
          <td><strong><?php echo e($c->presencaCulto?->total ?? '—'); ?></strong></td>
          <td><?php echo e($c->oferta ? number_format($c->oferta->valor_total, 0, ',', '.') : '—'); ?></td>
          <td><?php echo e($c->visitantes->count()); ?></td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              <a href="<?php echo e(route('relatorios.dominical', $c)); ?>" class="btn btn-sm btn-ghost">Relatório</a>
              <a href="<?php echo e(route('cultos.edit', $c)); ?>" class="btn btn-sm btn-secondary">Editar</a>
              <form method="POST" action="<?php echo e(route('cultos.destroy', $c)); ?>" onsubmit="return confirm('Eliminar este culto?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-sm btn-danger">✕</button></form>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="10"><div class="empty-state"><div class="empty-state__icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg></div><p class="empty-state__title">Nenhum culto registado</p><p class="empty-state__desc">Clique em "Novo Culto" para começar.</p></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);border-top:1px solid var(--color-neutral-100);"><?php echo e($cultos->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/culto/index.blade.php ENDPATH**/ ?>