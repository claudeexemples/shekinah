<?php $__env->startSection('page-title','Registar Classe Celestial'); ?>
<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('celestial.store')); ?>"><?php echo csrf_field(); ?>
<div class="section-header">
  <div>
    <h2 class="section-title">Registar Classe Celestial</h2>
    <p class="section-subtitle">Culto infantil — ocorre durante todo o período do culto + EBD</p>
  </div>
  <div class="section-actions">
    <a href="<?php echo e(route('celestial.index')); ?>" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Registo</button>
  </div>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
  <ul style="margin:0;padding-left:1rem;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
</div>
<?php endif; ?>

<div class="section-block" style="max-width:560px;">
  <div class="section-block-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    Contagem da Classe Celestial
  </div>

  <div class="form-group" style="margin-bottom:var(--space-5);">
    <label class="form-label">Culto correspondente <span class="req">*</span></label>
    <select name="evento_id" class="form-select" required>
      <option value="">— Seleccione o culto —</option>
      <?php $__currentLoopData = $cultos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($c->id); ?>" <?php echo e(old('evento_id') == $c->id ? 'selected' : ''); ?>>
          <?php echo e($c->data->format('d/m/Y')); ?> — <?php echo e($c->pregador); ?>

        </option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);margin-bottom:var(--space-6);">
    <div class="count-wrap">
      <input type="number" name="total_criancas" class="count-big" value="<?php echo e(old('total_criancas', 0)); ?>" min="0" required>
      <div class="count-label">Total de Crianças</div>
    </div>
    <div class="count-wrap">
      <input type="number" name="total_professores" class="count-big" value="<?php echo e(old('total_professores', 0)); ?>" min="0" required>
      <div class="count-label">Professores / Auxiliares</div>
    </div>
  </div>

  <div class="form-group">
    <label class="form-label">Observações</label>
    <textarea name="observacoes" class="form-textarea" placeholder="Actividades realizadas, materiais utilizados, anotações..."><?php echo e(old('observacoes')); ?></textarea>
  </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/celestial/create.blade.php ENDPATH**/ ?>