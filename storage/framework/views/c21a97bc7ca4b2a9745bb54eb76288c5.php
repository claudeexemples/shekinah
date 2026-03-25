<?php $__env->startSection('page-title','Classe Bíblica Doutrinária'); ?>

<?php $__env->startSection('content'); ?>

<div class="section-header">
  <div>
    <h2 class="section-title">Classe Bíblica Doutrinária</h2>
    <?php if($turmaActiva): ?>
      <p class="section-subtitle">Turma activa: <strong><?php echo e($turmaActiva->nome); ?></strong> · Aula <?php echo e($turmaActiva->aula_atual); ?>/<?php echo e($turmaActiva->total_aulas_previstas); ?></p>
    <?php else: ?>
      <p class="section-subtitle">Nenhuma turma activa</p>
    <?php endif; ?>
  </div>
  <div class="section-actions">
    <?php if($turmaActiva): ?>
      <button class="btn btn-ghost" onclick="openModal('modal-novo-candidato')">+ Candidato</button>
      <a href="<?php echo e(route('doutrinaria.candidatos')); ?>" class="btn btn-secondary">Candidatos</a>
      <a href="<?php echo e(route('doutrinaria.chamada')); ?>" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
        Fazer Chamada
      </a>
    <?php endif; ?>
    <a href="<?php echo e(route('doutrinaria.turmas.create')); ?>" class="btn <?php echo e($turmaActiva ? 'btn-ghost' : 'btn-primary'); ?>">+ Nova Turma</a>
  </div>
</div>

<?php if($turmaActiva): ?>

<div class="kpi-grid" style="grid-template-columns:repeat(4,1fr);">
  <div class="kpi-card kpi-card--primary">
    <div class="kpi-card__header"><div class="kpi-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div></div>
    <div class="kpi-card__value"><?php echo e($turmaActiva->candidatos->count()); ?></div>
    <div class="kpi-card__label">Candidatos</div>
  </div>
  <div class="kpi-card kpi-card--success">
    <div class="kpi-card__header"><div class="kpi-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div></div>
    <div class="kpi-card__value"><?php echo e($turmaActiva->frequencia_media); ?>%</div>
    <div class="kpi-card__label">Frequência média</div>
  </div>
  <div class="kpi-card kpi-card--warning">
    <div class="kpi-card__header"><div class="kpi-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg></div></div>
    <div class="kpi-card__value"><?php echo e($turmaActiva->candidatos_em_risco->count()); ?></div>
    <div class="kpi-card__label">Em risco (&lt;75%)</div>
  </div>
  <div class="kpi-card kpi-card--secondary">
    <div class="kpi-card__header"><div class="kpi-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div></div>
    <div class="kpi-card__value"><?php echo e($turmaActiva->aula_atual); ?>/<?php echo e($turmaActiva->total_aulas_previstas); ?></div>
    <div class="kpi-card__label">Progresso</div>
  </div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="section-block" style="margin-bottom:0;">
    <div class="section-block-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>Informações da Turma</div>
    <div class="summary-row"><span class="sr-label">Nome</span><span class="sr-value"><?php echo e($turmaActiva->nome); ?></span></div>
    <div class="summary-row"><span class="sr-label">Professor</span><span class="sr-value"><?php echo e($turmaActiva->professor); ?></span></div>
    <div class="summary-row"><span class="sr-label">Sala</span><span class="sr-value"><?php echo e($turmaActiva->sala ?? '—'); ?></span></div>
    <div class="summary-row"><span class="sr-label">Início</span><span class="sr-value"><?php echo e($turmaActiva->data_inicio->format('d/m/Y')); ?></span></div>
    <?php if($turmaActiva->data_batismo_prevista): ?>
    <div class="summary-row"><span class="sr-label">Baptismo previsto</span><span class="sr-value" style="color:var(--color-primary-700);font-family:var(--font-display);"><?php echo e($turmaActiva->data_batismo_prevista->format('d/m/Y')); ?></span></div>
    <?php endif; ?>
    <div style="margin-top:var(--space-4);">
      <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);margin-bottom:var(--space-2);"><span style="color:var(--color-neutral-500);">Progresso das aulas</span><span style="font-weight:600;"><?php echo e($turmaActiva->progresso); ?>%</span></div>
      <div class="progress-bar"><div class="progress-fill pf-primary" style="width:<?php echo e($turmaActiva->progresso); ?>%"></div></div>
    </div>
  </div>
  <div>
    <?php $__currentLoopData = $turmaActiva->candidatos_em_risco; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $risco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="alert alert-warning">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <div><strong><?php echo e($risco->nome); ?></strong> — <?php echo e($risco->percentual_presenca); ?>% de frequência.
        <a href="<?php echo e(route('doutrinaria.candidatos.perfil', $risco)); ?>" style="color:inherit;text-decoration:underline;margin-left:6px;">Ver perfil →</a>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if($turmaActiva->candidatos_em_risco->isEmpty()): ?>
    <div class="alert alert-success"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg><span>Todos os candidatos estão com frequência adequada. 🎉</span></div>
    <?php endif; ?>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <span class="card-title">Candidatos</span>
    <a href="<?php echo e(route('doutrinaria.candidatos')); ?>" class="btn btn-sm btn-ghost">Ver todos →</a>
  </div>
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Bairro</th><th>Presenças</th><th>Faltas</th><th>Frequência</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php $__currentLoopData = $turmaActiva->candidatos->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $cls = $c->percentual_presenca >= 90 ? 'badge-success' : ($c->percentual_presenca >= 75 ? 'badge-primary' : ($c->percentual_presenca >= 60 ? 'badge-warning' : 'badge-danger')); ?>
        <tr>
          <td><strong><?php echo e($c->nome); ?></strong><?php if($c->is_novo): ?> <span class="badge badge-warning" style="margin-left:6px;">Novo</span><?php endif; ?></td>
          <td><?php echo e($c->bairro ?? '—'); ?></td>
          <td><?php echo e($c->total_presencas); ?></td>
          <td><?php echo e($c->total_faltas); ?></td>
          <td><span class="badge <?php echo e($cls); ?>"><?php echo e($c->percentual_presenca); ?>%</span></td>
          <td><span class="badge <?php echo e($c->status_badge_class); ?>"><?php echo e($c->status_label); ?></span></td>
          <td><a href="<?php echo e(route('doutrinaria.candidatos.perfil', $c)); ?>" class="btn btn-sm btn-ghost">Perfil</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>

<?php else: ?>
<div class="card"><div class="card-body"><div class="empty-state">
  <div class="empty-state__icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
  <p class="empty-state__title">Nenhuma turma activa</p>
  <p class="empty-state__desc">Crie uma nova turma para iniciar a Classe Bíblica Doutrinária.</p>
  <a href="<?php echo e(route('doutrinaria.turmas.create')); ?>" class="btn btn-primary">Criar Nova Turma</a>
</div></div></div>
<?php endif; ?>

<?php $__env->startPush('modals'); ?>
<div class="modal-overlay" id="modal-novo-candidato">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title">Novo Candidato ao Baptismo</h3>
      <button class="modal-close" onclick="closeModal('modal-novo-candidato')"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <form method="POST" action="<?php echo e(route('doutrinaria.candidatos.store')); ?>"><?php echo csrf_field(); ?>
      <input type="hidden" name="turma_id" value="<?php echo e($turmaActiva?->id); ?>">
      <div class="modal-body">
        <div class="form-grid">
          <div class="form-group col-span-2"><label class="form-label">Nome completo <span class="req">*</span></label><input type="text" name="nome" class="form-input" placeholder="Ex: Maria Conceição dos Santos" required></div>
          <div class="form-group"><label class="form-label">Telefone</label><input type="tel" name="telefone" class="form-input" placeholder="9XX XXX XXX"></div>
          <div class="form-group"><label class="form-label">Data de nascimento</label><input type="date" name="data_nascimento" class="form-input"></div>
          <div class="form-group"><label class="form-label">Data de matrícula <span class="req">*</span></label><input type="date" name="data_matricula" class="form-input" value="<?php echo e(date('Y-m-d')); ?>" required></div>
          <div class="form-group"><label class="form-label">Bairro</label><input type="text" name="bairro" class="form-input" placeholder="Ex: Rangel, Cazenga..."></div>
          <div class="form-group col-span-2" style="flex-direction:row;align-items:center;gap:12px;">
            <input type="checkbox" name="is_novo" value="1" id="chk-novo" style="width:18px;height:18px;">
            <label for="chk-novo" class="form-label" style="cursor:pointer;margin:0;">Marcar como <strong>novo candidato</strong> (destaque na chamada)</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-novo-candidato')">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Candidato</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/doutrinaria/index.blade.php ENDPATH**/ ?>