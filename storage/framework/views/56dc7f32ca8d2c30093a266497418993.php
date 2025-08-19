<?php $__env->startSection('content'); ?>
    <h1 style="font-family:'Space Grotesk', sans-serif; color:var(--text-primary); margin-bottom:20px;">Dashboard</h1>

    <div class="cards">
        <div class="card-stat">
            <h3><?php echo e($callsToday ?? 0); ?></h3>
            <span>Chamadas hoje</span>
        </div>
        <div class="card-stat">
            <h3><?php echo e($activeCalls ?? 0); ?></h3>
            <span>Chamadas ativas</span>
        </div>
        <div class="card-stat">
            <h3><?php echo e($pendingRecordings ?? 0); ?></h3>
            <span>Gravações pendentes</span>
        </div>
        <div class="card-stat">
            <h3><?php echo e($onlineUsers ?? 0); ?></h3>
            <span>Usuários online</span>
        </div>
    </div>

    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/fttelecom/resources/views/dashboard.blade.php ENDPATH**/ ?>