<?php $__env->startSection('content'); ?>
<h1>Gerenciar Tenants e Usuários</h1>


<form method="POST" action="<?php echo e(route('register-tenant')); ?>">
    <?php echo csrf_field(); ?>
    <h3>Novo Tenant</h3>
    <input type="text" name="tenant_name" placeholder="Nome da empresa" required class="form-input">
    <input type="text" name="subdomain" placeholder="Slug interno" required class="form-input">
    <input type="text" name="name" placeholder="Nome do usuário admin" required class="form-input">
    <input type="email" name="email" placeholder="Email do admin" required class="form-input">
    <input type="password" name="password" placeholder="Senha" required class="form-input">
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required class="form-input">
    <button class="btn btn-primary" type="submit">Criar Empresa</button>
</form>


<form method="POST" action="<?php echo e(route('register-user')); ?>" style="margin-top:40px;">
    <?php echo csrf_field(); ?>
    <h3>Novo Usuário</h3>
    <input type="text" name="name" placeholder="Nome" required class="form-input">
    <input type="email" name="email" placeholder="Email" required class="form-input">
    <input type="password" name="password" placeholder="Senha" required class="form-input">
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required class="form-input">
    <button class="btn btn-primary" type="submit">Criar Usuário</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/fttelecom/resources/views/manage.blade.php ENDPATH**/ ?>