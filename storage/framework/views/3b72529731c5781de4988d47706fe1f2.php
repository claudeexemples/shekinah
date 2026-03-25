<?php $__env->startSection('page-title','Visitantes'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div><h2 class="section-title">Gestão de Visitantes</h2><p class="section-subtitle">Acompanhamento e follow-up pastoral</p></div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-3);">
      <div class="search-bar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" name="busca" placeholder="Buscar visitante..." value="<?php echo e(request('busca')); ?>"></div>
      <select name="status" class="form-select" style="height:36px;width:auto;" onchange="this.form.submit()">
        <option value="">Todos os estados</option>
        <option value="pendente" <?php echo e(request('status')=='pendente'?'selected':''); ?>>Pendente</option>
        <option value="acompanhado" <?php echo e(request('status')=='acompanhado'?'selected':''); ?>>Acompanhado</option>
        <option value="convertido" <?php echo e(request('status')=='convertido'?'selected':''); ?>>Convertido</option>
      </select>
    </form>
    <a href="<?php echo e(route('visitantes.create')); ?>" class="btn btn-primary">+ Novo Visitante</a>
  </div>
</div>

<div class="kpi-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:var(--space-6);">
  <div class="kpi-card kpi-card--primary" style="padding:var(--space-4);"><div class="kpi-card__value"><?php echo e($kpis['total']); ?></div><div class="kpi-card__label">Total registados</div></div>
  <div class="kpi-card kpi-card--warning" style="padding:var(--space-4);"><div class="kpi-card__value"><?php echo e($kpis['pendentes']); ?></div><div class="kpi-card__label">Pendentes</div></div>
  <div class="kpi-card kpi-card--success" style="padding:var(--space-4);"><div class="kpi-card__value"><?php echo e($kpis['acompanhados']); ?></div><div class="kpi-card__label">Acompanhados</div></div>
  <div class="kpi-card kpi-card--secondary" style="padding:var(--space-4);"><div class="kpi-card__value"><?php echo e($kpis['convertidos']); ?></div><div class="kpi-card__label">Convertidos</div></div>
</div>

<div class="card">
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Telefone</th><th>Bairro</th><th>Data</th><th>Tipo</th><th>1ª Visita</th><th>Como Conheceu</th><th>Estado</th><th>Acções</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $visitantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><strong><?php echo e($v->nome); ?></strong></td>
          <td><?php echo e($v->telefone ?? '—'); ?></td>
          <td><?php echo e($v->bairro ?? '—'); ?></td>
          <td><?php echo e($v->data_visita->format('d/m/Y')); ?></td>
          <td><?php echo e($v->tipo_label); ?></td>
          <td><?php echo e($v->primeira_visita ? '<span class="badge badge-primary">Sim</span>' : '<span class="badge badge-neutral">Não</span>'); ?></td>
          <td><?php echo e($v->como_conheceu ?? '—'); ?></td>
          <td><span class="badge <?php echo e($v->status_badge_class); ?>"><?php echo e($v->status_label); ?></span></td>
          <td>
            <div style="display:flex;gap:var(--space-2);">
              <?php if($v->status === 'pendente'): ?>
              <form method="POST" action="<?php echo e(route('visitantes.acompanhar', $v)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button type="submit" class="btn btn-sm btn-success">✓ Acompanhado</button></form>
              <?php endif; ?>
              <form method="POST" action="<?php echo e(route('visitantes.destroy', $v)); ?>" onsubmit="return confirm('Eliminar visitante?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-sm btn-danger">✕</button></form>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="9"><div class="empty-state"><div class="empty-state__icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><p class="empty-state__title">Nenhum visitante encontrado</p><a href="<?php echo e(route('visitantes.create')); ?>" class="btn btn-primary btn-sm">Registar Visitante</a></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div style="padding:var(--space-4) var(--space-6);"><?php echo e($visitantes->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/visitantes/index.blade.php ENDPATH**/ ?>