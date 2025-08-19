<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FT Telecom - Registro</title>
    <!-- Importação de fontes Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Ícones Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Fundo animado com grid e formas flutuantes -->
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
        <div class="card" style="max-width: 500px; width:100%;">
            <h1 style="font-family:'Space Grotesk', sans-serif; color:var(--text-primary); margin-bottom: 20px; text-align:center;">Criar Conta</h1>
            <form action="/register" method="POST">
                <div class="form-group">
                    <label class="form-label" for="name">Nome</label>
                    <input class="form-input" id="name" type="text" name="name" placeholder="Seu nome completo" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="reg-email">Email</label>
                    <input class="form-input" id="reg-email" type="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="reg-password">Senha</label>
                    <input class="form-input" id="reg-password" type="password" name="password" placeholder="Digite sua senha" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirme a Senha</label>
                    <input class="form-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirme sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Registrar</button>
            </form>
            <div style="margin-top: 20px; text-align:center;">
                <span style="color: var(--text-secondary); font-size:0.9rem;">Já possui conta? </span><a class="auth-link" href="login.html">Entrar</a>
            </div>
        </div>
    </div>
</body>
</html>