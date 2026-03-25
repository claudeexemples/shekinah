<?php $__env->startSection('page-title','Detalhes do Culto'); ?>
<?php $__env->startSection('content'); ?>
<div class="section-header">
  <div>
    <h2 class="section-title">Culto — <?php echo e($culto->data->translatedFormat('D, d/m/Y')); ?></h2>
    <p class="section-subtitle"><?php echo e($culto->pregador); ?> · <?php echo e($culto->tema_culto); ?></p>
  </div>
  <div class="section-actions">
    <a href="<?php echo e(route('cultos.index')); ?>" class="btn btn-secondary">← Voltar</a>
    <a href="<?php echo e(route('relatorios.dominical', $culto)); ?>" class="btn btn-ghost">Relatório</a>
    <a href="<?php echo e(route('cultos.edit', $culto)); ?>" class="btn btn-primary">Editar</a>
  </div>
</div>

<div class="grid-2" style="margin-bottom:var(--space-6);">
  <div class="card">
    <div class="card-header"><span class="card-title">Informações do Culto</span><span class="badge badge-success">Registado</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Data</span><span class="sr-value"><?php echo e($culto->data->translatedFormat('l, d/m/Y')); ?></span></div>
      <div class="summary-row"><span class="sr-label">Horário</span><span class="sr-value"><?php echo e($culto->horario_inicio ? substr($culto->horario_inicio,0,5).'h às '.substr($culto->horario_fim,0,5).'h' : '—'); ?></span></div>
      <div class="summary-row"><span class="sr-label">Pregador</span><span class="sr-value"><?php echo e($culto->pregador); ?></span></div>
      <div class="summary-row"><span class="sr-label">Tema</span><span class="sr-value"><?php echo e($culto->tema_culto ?? '—'); ?></span></div>
      <?php if($culto->observacoes): ?><div class="summary-row"><span class="sr-label">Observações</span><span class="sr-value"><?php echo e($culto->observacoes); ?></span></div><?php endif; ?>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Presença</span></div>
    <div class="card-body">
      <div class="summary-row"><span class="sr-label">Adultos</span><span class="sr-value"><?php echo e($culto->presencaCulto?->adultos ?? 0); ?></span></div>
      <div class="summary-row"><span class="sr-label">Adolescentes</span><span class="sr-value"><?php echo e($culto->presencaCulto?->adolescentes ?? 0); ?></span></div>
      <div class="summary-row"><span class="sr-label">Crianças (Celestial)</span><span class="sr-value"><?php echo e($culto->presencaCulto?->criancas ?? 0); ?></span></div>
      <div class="summary-row"><span class="sr-label" style="font-weight:600;">Total</span><span class="sr-value" style="font-family:var(--font-display);font-size:var(--text-2xl);color:var(--color-primary-700);"><?php echo e($culto->presencaCulto?->total ?? 0); ?></span></div>
    </div>
  </div>
</div>

<?php if($culto->oferta): ?>
<div class="card" style="margin-bottom:var(--space-6);">
  <div class="card-header"><span class="card-title">Oferta</span></div>
  <div class="card-body">
    <div class="grid-4">
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-xl);font-weight:700;color:var(--color-neutral-800);"><?php echo e(number_format($culto->oferta->valor_dinheiro,0,',','.')); ?> Kz</div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">Dinheiro</div></div>
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-xl);font-weight:700;color:var(--color-neutral-800);"><?php echo e(number_format($culto->oferta->valor_transferencia,0,',','.')); ?> Kz</div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">Transferência/EMIS</div></div>
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-xl);font-weight:700;color:var(--color-neutral-800);"><?php echo e(number_format($culto->oferta->valor_cartao,0,',','.')); ?> Kz</div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">Multicaixa/TPA</div></div>
      <div style="text-align:center;"><div style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-success-700);"><?php echo e(number_format($culto->oferta->valor_total,0,',','.')); ?> Kz</div><div style="font-size:var(--text-xs);color:var(--color-neutral-500);">Total Arrecadado</div></div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if($culto->visitantes->isNotEmpty()): ?>
<div class="card">
  <div class="card-header"><span class="card-title">Visitantes (<?php echo e($culto->visitantes->count()); ?>)</span></div>
  <div class="table-wrapper">
    <table class="table">
      <thead><tr><th>Nome</th><th>Telefone</th><th>Bairro</th><th>Tipo</th><th>1ª Visita</th><th>Como Conheceu</th><th>Estado</th></tr></thead>
      <tbody>
        <?php $__currentLoopData = $culto->visitantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr><td><strong><?php echo e($v->nome); ?></strong></td><td><?php echo e($v->telefone ?? '—'); ?></td><td><?php echo e($v->bairro ?? '—'); ?></td><td><?php echo e($v->tipo_label); ?></td><td><?php echo e($v->primeira_visita ? '<span class="badge badge-primary">Sim</span>' : 'Não'); ?></td><td><?php echo e($v->como_conheceu ?? '—'); ?></td><td><span class="badge <?php echo e($v->status_badge_class); ?>"><?php echo e($v->status_label); ?></span></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/pages/culto/show.blade.php ENDPATH**/ ?>