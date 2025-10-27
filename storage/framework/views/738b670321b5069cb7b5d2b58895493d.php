<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-semibold">Convites</h1>
      <p class="text-sm text-gray-500">Gerencie convites pendentes da empresa <?php echo e($tenant->name); ?>.</p>
    </div>
  </div>

  <form method="post" action="<?php echo e(route('invites.store')); ?>" class="bg-white p-4 rounded shadow mb-6">
    <?php echo csrf_field(); ?>
    <div class="grid md:grid-cols-3 gap-3">
      <div>
        <label class="block text-sm">E-mail</label>
        <input name="email" type="email" class="border rounded w-full px-3 py-2" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div>
        <label class="block text-sm">Permissão</label>
        <select name="role" class="border rounded w-full px-3 py-2">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Convidar</button>
      </div>
    </div>
  </form>

  <div class="bg-white rounded shadow">
    <table class="w-full text-left">
      <thead>
        <tr><th class="p-3">E-mail</th><th class="p-3">Permissão</th><th class="p-3">Expira</th><th class="p-3 w-40">Ações</th></tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $invites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="border-t">
          <td class="p-3"><?php echo e($i->email); ?></td>
          <td class="p-3"><?php echo e($i->role); ?></td>
          <td class="p-3"><?php echo e($i->expires_at?->diffForHumans() ?? '—'); ?></td>
          <td class="p-3">
            <div class="flex items-center gap-2">
              <code class="text-xs"><?php echo e(route('invites.accept', $i->token)); ?></code>
              <form method="post" action="<?php echo e(route('invites.destroy',$i)); ?>" onsubmit="return confirm('Remover convite?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="px-2 py-1 border rounded">Remover</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td class="p-3 text-slate-500" colspan="4">Nenhum convite.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/fttelecom/resources/views/invites/index.blade.php ENDPATH**/ ?>