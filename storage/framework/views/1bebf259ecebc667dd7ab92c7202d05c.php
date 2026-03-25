<?php $__env->startSection('page-title','Classe Celestial'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div><h2 class="section-title">Classe Celestial</h2><p class="section-subtitle">Culto infantil — ocorre durante o culto + EBD</p></div>
  <div class="section-actions"><a href="<?php echo e(route('celestial.create')); ?>" class="btn btn-primary">+ Novo Registo</a></div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Data</th><th>Crianças</th><th>Professores / Auxiliares</th><th>Observações</th><th>Acções</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><strong><?php echo e($r->evento->data->translatedFormat('D, d/m/Y')); ?></strong></td>
          <td><strong><?php echo e($r->total_criancas); ?></strong></td>
          <td><?php echo e($r->total_professores); ?></td>
          <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($r->observacoes ?? '—'); ?></td>
          <td>
            <form method="POST" action="<?php echo e(route('celestial.destroy', $r)); ?>" onsubmit="return confirm('Eliminar registo?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="5"><div class="empty-state"><p class="empty-state__title">Nenhum registo encontrado</p></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);"><?php echo e($registros->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/celestial/index.blade.php ENDPATH**/ ?>