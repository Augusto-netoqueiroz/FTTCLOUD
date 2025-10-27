<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Configurações da Empresa</h1>

  <form method="post" action="<?php echo e(route('tenant.settings.update')); ?>" class="space-y-4 bg-white p-4 rounded shadow">
    <?php echo csrf_field(); ?>
    <div>
      <label class="block text-sm">Nome</label>
      <input name="name" class="border rounded w-full px-3 py-2" value="<?php echo e(old('name', $tenant->name)); ?>" required>
      <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
      <label class="block text-sm">Subdomínio</label>
      <div class="flex items-center gap-2">
        <input name="subdomain" class="border rounded w-full px-3 py-2" value="<?php echo e(old('subdomain', $tenant->subdomain)); ?>" required>
        <span class="text-sm text-slate-600">.fttelecom.cloud</span>
      </div>
      <?php $__errorArgs = ['subdomain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Salvar</button>
  </form>

  <div class="mt-6 bg-white p-4 rounded shadow">
    <div class="font-medium mb-2">Plano</div>
    <div class="text-slate-700"><?php echo e($tenant->plan ?? 'free'); ?></div>
    
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/fttelecom/resources/views/tenant/settings.blade.php ENDPATH**/ ?>