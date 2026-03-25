<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="quick-actions">
  <a href="<?php echo e(route('cultos.create')); ?>" class="qa-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
    Registar Culto
  </a>
  <a href="<?php echo e(route('ebd.create')); ?>" class="qa-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 016.5 2H20v20H6.5a2.5 2.5 0 010-5H20"/></svg>
    Registar EBD
  </a>
  <a href="<?php echo e(route('doutrinaria.chamada')); ?>" class="qa-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
    Fazer Chamada
  </a>
  <a href="<?php echo e(route('visitantes.create')); ?>" class="qa-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    Novo Visitante
  </a>
  <a href="<?php echo e(route('financeiro.despesas')); ?>" class="qa-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
    Lançar Despesa
  </a>
</div>


<div class="kpi-grid">
  <div class="kpi-card kpi-card--primary">
    <div class="kpi-card__header">
      <div class="kpi-card__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
    </div>
    <div class="kpi-card__value"><?php echo e($ultimoCulto?->presencaCulto?->total ?? '—'); ?></div>
    <div class="kpi-card__label">Presentes no último culto</div>
    <div class="kpi-card__sub">
      <?php if($ultimoCulto): ?>
        <?php echo e($ultimoCulto->data->translatedFormat('D, d/m/Y')); ?> · <?php echo e($ultimoCulto->pregador); ?>

      <?php else: ?> Nenhum culto registado <?php endif; ?>
    </div>
  </div>

  <div class="kpi-card kpi-card--success">
    <div class="kpi-card__header">
      <div class="kpi-card__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
      </div>
    </div>
    <div class="kpi-card__value"><?php echo e(number_format($totalOfertasMes, 0, ',', '.')); ?> Kz</div>
    <div class="kpi-card__label">Ofertas do mês</div>
    <div class="kpi-card__sub"><?php echo e(now()->translatedFormat('F Y')); ?></div>
  </div>

  <div class="kpi-card kpi-card--warning">
    <div class="kpi-card__header">
      <div class="kpi-card__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
    </div>
    <div class="kpi-card__value"><?php echo e($totalVisitantesMes); ?></div>
    <div class="kpi-card__label">Visitantes este mês</div>
    <div class="kpi-card__sub"><?php echo e($visitantesPendentes->count()); ?> aguardam acompanhamento</div>
  </div>

  <div class="kpi-card kpi-card--secondary">
    <div class="kpi-card__header">
      <div class="kpi-card__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      </div>
    </div>
    <div class="kpi-card__value"><?php echo e($turmaActiva?->candidatos->count() ?? 0); ?></div>
    <div class="kpi-card__label">Candidatos ao baptismo</div>
    <div class="kpi-card__sub"><?php echo e($turmaActiva?->nome ?? 'Nenhuma turma activa'); ?></div>
  </div>
</div>


<div class="grid-2" style="margin-bottom:var(--space-6);">

  
  <div class="card">
    <div class="card-header">
      <span class="card-title">Presença — Últimos Cultos</span>
    </div>
    <div class="card-body">
      <div class="bar-chart">
        <?php $__currentLoopData = $ultimosCultos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $total = $c->presencaCulto?->total ?? 0; $max = $ultimosCultos->max(fn($x) => $x->presencaCulto?->total ?? 0); $pct = $max > 0 ? round($total / $max * 100) : 0; ?>
          <div class="bar-group">
            <div class="bar bar--primary" style="height:<?php echo e($pct); ?>%" title="<?php echo e($total); ?> presentes"></div>
            <div class="bar-label"><?php echo e($c->data->format('d/m')); ?></div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>

  
  <div class="card">
    <div class="card-header">
      <span class="card-title">Último Culto Dominical</span>
      <?php if($ultimoCulto): ?> <span class="badge badge-success">Registado</span> <?php endif; ?>
    </div>
    <div class="card-body">
      <?php if($ultimoCulto): ?>
        <div class="summary-row"><span class="sr-label">Data</span><span class="sr-value"><?php echo e($ultimoCulto->data->translatedFormat('D, d/m/Y')); ?></span></div>
        <div class="summary-row"><span class="sr-label">Pregador</span><span class="sr-value"><?php echo e($ultimoCulto->pregador); ?></span></div>
        <div class="summary-row"><span class="sr-label">Tema</span><span class="sr-value"><?php echo e($ultimoCulto->tema_culto); ?></span></div>
        <div class="summary-row"><span class="sr-label">Adultos</span><span class="sr-value"><?php echo e($ultimoCulto->presencaCulto?->adultos ?? 0); ?></span></div>
        <div class="summary-row"><span class="sr-label">Adolescentes</span><span class="sr-value"><?php echo e($ultimoCulto->presencaCulto?->adolescentes ?? 0); ?></span></div>
        <div class="summary-row"><span class="sr-label">Crianças (Celestial)</span><span class="sr-value"><?php echo e($ultimoCulto->presencaCulto?->criancas ?? 0); ?></span></div>
        <div class="summary-row">
          <span class="sr-label" style="font-weight:600;">Total</span>
          <span class="sr-value" style="font-family:var(--font-display);font-size:var(--text-xl);color:var(--color-primary-700);"><?php echo e($ultimoCulto->presencaCulto?->total ?? 0); ?></span>
        </div>
        <div class="summary-row">
          <span class="sr-label">Oferta arrecadada</span>
          <span class="sr-value" style="color:var(--color-success-700);"><?php echo e(number_format($ultimoCulto->oferta?->valor_total ?? 0, 2, ',', '.')); ?> Kz</span>
        </div>
      <?php else: ?>
        <div class="empty-state" style="padding:var(--space-8);">
          <div class="empty-state__icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg></div>
          <p class="empty-state__desc">Nenhum culto registado ainda.</p>
          <a href="<?php echo e(route('cultos.create')); ?>" class="btn btn-primary btn-sm">Registar Culto</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>


<div class="grid-2" style="margin-bottom:var(--space-6);">

  
  <div class="card">
    <div class="card-header">
      <span class="card-title">Visitantes — Acompanhamento Pendente</span>
      <a href="<?php echo e(route('visitantes.index')); ?>" class="btn btn-sm btn-ghost">Ver todos</a>
    </div>
    <div class="card-body" style="padding-top:var(--space-2);">
      <?php $__empty_1 = true; $__currentLoopData = $visitantesPendentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div style="display:flex;align-items:center;gap:var(--space-3);padding:var(--space-3) 0;border-bottom:1px solid var(--color-neutral-100);">
        <div style="width:36px;height:36px;border-radius:var(--radius-full);background:linear-gradient(135deg,var(--color-accent-500),var(--color-danger-500));display:flex;align-items:center;justify-content:center;font-size:var(--text-sm);font-weight:600;color:white;flex-shrink:0;">
          <?php echo e(strtoupper(substr($v->nome, 0, 1)).strtoupper(substr(strstr($v->nome,' '), 1, 1))); ?>

        </div>
        <div style="flex:1;">
          <div style="font-size:var(--text-sm);font-weight:600;color:var(--color-neutral-800);"><?php echo e($v->nome); ?></div>
          <div style="font-size:var(--text-xs);color:var(--color-neutral-400);"><?php echo e($v->primeira_visita ? '1ª visita' : 'Recorrente'); ?> · <?php echo e($v->data_visita->format('d/m/Y')); ?></div>
        </div>
        <form method="POST" action="<?php echo e(route('visitantes.acompanhar', $v)); ?>">
          <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
          <button type="submit" class="btn btn-sm btn-ghost" title="Marcar acompanhado">✓</button>
        </form>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p style="color:var(--color-neutral-400);font-size:var(--text-sm);text-align:center;padding:var(--space-6) 0;">Nenhum visitante pendente. 🎉</p>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="card">
    <div class="card-header">
      <span class="card-title">Financeiro — <?php echo e(now()->translatedFormat('F Y')); ?></span>
      <a href="<?php echo e(route('financeiro.index')); ?>" class="btn btn-sm btn-ghost">Ver relatório</a>
    </div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Total de receitas</span><span class="sr-value" style="color:var(--color-success-700);"><?php echo e(number_format($totalOfertasMes, 2, ',', '.')); ?> Kz</span></div>
      <div class="summary-row"><span class="sr-label">Total de despesas</span><span class="sr-value" style="color:var(--color-danger-600);"><?php echo e(number_format($totalDespesasMes, 2, ',', '.')); ?> Kz</span></div>
      <div class="summary-row">
        <span class="sr-label" style="font-weight:600;">Saldo do mês</span>
        <span class="sr-value" style="font-family:var(--font-display);font-size:var(--text-xl);color:<?php echo e($saldoMes >= 0 ? 'var(--color-primary-700)' : 'var(--color-danger-700)'); ?>;"><?php echo e(number_format($saldoMes, 2, ',', '.')); ?> Kz</span>
      </div>
    </div>
  </div>
</div>


<?php if($turmaActiva): ?>
<div class="card">
  <div class="card-header">
    <span class="card-title">Classe Bíblica Doutrinária — <?php echo e($turmaActiva->nome); ?></span>
    <div style="display:flex;gap:var(--space-3);">
      <a href="<?php echo e(route('doutrinaria.chamada')); ?>" class="btn btn-sm btn-primary">Fazer Chamada</a>
      <a href="<?php echo e(route('doutrinaria.index')); ?>" class="btn btn-sm btn-ghost">Ver módulo</a>
    </div>
  </div>
  <div class="card-body">
    <div class="grid-3">
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-primary-700);"><?php echo e($turmaActiva->candidatos->count()); ?></div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">candidatos</div></div>
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-success-600);"><?php echo e($turmaActiva->frequencia_media); ?>%</div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">frequência média</div></div>
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-accent-600);"><?php echo e($candidatosRisco->count()); ?></div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">em risco (&lt;75%)</div></div>
    </div>
    <?php $__currentLoopData = $candidatosRisco; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $risco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="alert alert-warning" style="margin-top:var(--space-4);margin-bottom:0;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <div><strong><?php echo e($risco->nome); ?></strong> está com <?php echo e($risco->percentual_presenca); ?>% de frequência — abaixo do mínimo de 75%.</div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/dashboard/index.blade.php ENDPATH**/ ?>