<?php if($paginator->hasPages()): ?>
<nav style="display:flex;align-items:center;justify-content:space-between;padding:var(--space-2) 0;">
    <div style="font-size:var(--text-sm);color:var(--color-neutral-500);">
        A mostrar <?php echo e($paginator->firstItem()); ?>–<?php echo e($paginator->lastItem()); ?> de <?php echo e($paginator->total()); ?> registos
    </div>
    <div style="display:flex;gap:var(--space-1);">
        <?php if($paginator->onFirstPage()): ?>
            <span style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-300);">‹</span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-600);text-decoration:none;">‹</a>
        <?php endif; ?>

        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span style="padding:6px 10px;font-size:var(--text-sm);color:var(--color-neutral-400);"><?php echo e($element); ?></span>
            <?php endif; ?>
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span style="padding:6px 10px;background:var(--color-primary-600);color:white;border-radius:var(--radius-md);font-size:var(--text-sm);font-weight:600;"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-600);text-decoration:none;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-600);text-decoration:none;">›</a>
        <?php else: ?>
            <span style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-300);">›</span>
        <?php endif; ?>
    </div>
</nav>
<?php endif; ?>
<?php /**PATH /home/cj/Transferências/shekinah (2)/shekinah/resources/views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>