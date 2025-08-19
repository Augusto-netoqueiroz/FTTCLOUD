<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FT Telecom – Entrar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
    <div class="bg-animation">
        <div class="tech-grid"></div>
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <div class="main-container">
        <div class="card" style="max-width:400px; width:100%;">
            <h1 class="text-center mb-4" style="font-family:'Space Grotesk', sans-serif; color:var(--text-primary);">
                Entrar
            </h1>

            <form id="login-form">
                <?php echo csrf_field(); ?>
                <div class="form-group mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-input" id="email" type="email" name="email" placeholder="Digite seu e-mail" required />
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="password">Senha</label>
                    <input class="form-input" id="password" type="password" name="password" placeholder="Digite sua senha" required />
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <a class="auth-link" href="<?php echo e(url('/forgot')); ?>">Esqueceu sua senha?</a>
            </div>
            <div class="text-center mt-2">
                <span style="color:var(--text-secondary); font-size:0.9rem;">Não possui conta? </span>
                <a class="auth-link" href="<?php echo e(url('/register')); ?>">Registrar-se</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    <script src="<?php echo e(asset('js/ws-client.js')); ?>"></script>
    <script>
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const data = new URLSearchParams(new FormData(form));

        try {
            const resp = await fetch('<?php echo e(route('login')); ?>', {
                method: 'POST',
                credentials: 'include',            // envia e recebe cookies de sessão
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data.toString()
            });

            const json = await resp.json();

            if (resp.ok) {
                // Aqui assumimos que o cookie de sessão já foi gravado
                window.location.href = '/dashboard';
            } else {
                alert(json.message || 'Credenciais incorretas');
            }
        } catch (err) {
            console.error(err);
            alert('Erro de conexão, tente novamente');
        }
    });
    </script>
</body>
</html>
<?php /**PATH /var/www/html/fttelecom/resources/views/login.blade.php ENDPATH**/ ?>