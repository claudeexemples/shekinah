<?php $__env->startSection('page-title','Relatório Mensal'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header no-print">
  <div>
    <h2 class="section-title">Relatório Mensal</h2>
    <p class="section-subtitle"><?php echo e(\Carbon\Carbon::create($ano,$mes)->translatedFormat('F \d\e Y')); ?></p>
  </div>
  <div class="section-actions">
    <form method="GET" style="display:flex;gap:var(--space-2);">
      <select name="mes" class="form-select" style="height:36px;width:auto;"><?php for($m=1;$m<=12;$m++): ?><option value="<?php echo e($m); ?>" <?php echo e($mes==$m?'selected':''); ?>><?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?></option><?php endfor; ?></select>
      <select name="ano" class="form-select" style="height:36px;width:auto;"><?php for($a=2023;$a<=date('Y');$a++): ?><option value="<?php echo e($a); ?>" <?php echo e($ano==$a?'selected':''); ?>><?php echo e($a); ?></option><?php endfor; ?></select>
      <button type="submit" class="btn btn-secondary">Ver</button>
    </form>
    <button class="btn btn-primary no-print" onclick="window.print()">🖨️ Imprimir</button>
  </div>
</div>

<div class="kpi-grid" style="grid-template-columns:repeat(4,1fr);">
  <div class="kpi-card kpi-card--primary"><div class="kpi-card__value"><?php echo e(round($presencaMedia)); ?></div><div class="kpi-card__label">Média de presença</div><div class="kpi-card__sub"><?php echo e($cultos->count()); ?> cultos</div></div>
  <div class="kpi-card kpi-card--warning"><div class="kpi-card__value"><?php echo e($totalVisitantes); ?></div><div class="kpi-card__label">Total visitantes</div></div>
  <div class="kpi-card kpi-card--success"><div class="kpi-card__value"><?php echo e(number_format($totalOfertas,0,',','.')); ?> Kz</div><div class="kpi-card__label">Total de ofertas</div></div>
  <div class="kpi-card kpi-card--danger"><div class="kpi-card__value"><?php echo e(number_format($totalDespesas,0,',','.')); ?> Kz</div><div class="kpi-card__label">Total de despesas</div></div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="card">
    <div class="card-header"><span class="card-title">Presença por Domingo</span></div>
    <div class="card-body">
      <?php $maxPres = $cultos->max(fn($c) => $c->presencaCulto?->total ?? 0); ?>
      <div class="bar-chart">
        <?php $__currentLoopData = $cultos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $t = $c->presencaCulto?->total ?? 0; $p = $maxPres>0?round($t/$maxPres*100):0; ?>
        <div class="bar-group"><div class="bar bar--primary" style="height:<?php echo e($p); ?>%" title="<?php echo e($t); ?>"></div><div class="bar-label"><?php echo e($c->data->format('d/m')); ?></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Resumo do Mês</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Cultos realizados</span><span class="sr-value"><?php echo e($cultos->count()); ?></span></div>
      <div class="summary-row"><span class="sr-label">Maior presença</span><span class="sr-value"><?php echo e($cultos->max(fn($c) => $c->presencaCulto?->total ?? 0)); ?></span></div>
      <div class="summary-row"><span class="sr-label">Menor presença</span><span class="sr-value"><?php echo e($cultos->min(fn($c) => $c->presencaCulto?->total ?? 0)); ?></span></div>
      <div class="summary-row"><span class="sr-label">Saldo financeiro</span><span class="sr-value" style="color:<?php echo e(($totalOfertas-$totalDespesas)>=0?'var(--color-success-700)':'var(--color-danger-700)'); ?>;font-family:var(--font-display);"><?php echo e(number_format($totalOfertas-$totalDespesas,0,',','.')); ?> Kz</span></div>
      <?php if($turmaActiva): ?>
      <div class="summary-row"><span class="sr-label">Candidatos baptismo</span><span class="sr-value"><?php echo e($turmaActiva->candidatos->count()); ?> (freq. média <?php echo e($turmaActiva->frequencia_media); ?>%)</span></div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/relatorios/mensal.blade.php ENDPATH**/ ?>