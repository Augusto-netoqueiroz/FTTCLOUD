<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FT Telecom - Recuperar Senha</title>
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
        <div class="card" style="max-width: 420px; width:100%;">
            <h1 style="font-family:'Space Grotesk', sans-serif; color:var(--text-primary); margin-bottom: 20px; text-align:center;">Recuperar Senha</h1>
            <p style="color: var(--text-secondary); margin-bottom: 20px; text-align:center;">Digite seu e-mail para receber instruções de redefinição de senha.</p>
            <form action="/forgot-password" method="POST">
                <div class="form-group">
                    <label class="form-label" for="forgot-email">Email</label>
                    <input class="form-input" id="forgot-email" type="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Enviar</button>
            </form>
            <div style="margin-top: 20px; text-align:center;">
                <a class="auth-link" href="login.html">Voltar para Login</a>
            </div>
        </div>
    </div>
</body>
</html>