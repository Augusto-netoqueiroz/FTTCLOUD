<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FT TELECOM - Em Construção</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            /* Cores inspiradas no design original mas adaptadas para telecom */
            --primary-color: #0066ff;
            --secondary-color: #001a4d;
            --accent-color: #00ccff;
            --neon-blue: #00ffff;
            --neon-purple: #8a2be2;
            --gradient-primary: linear-gradient(135deg, #0066ff, #00ccff);
            --gradient-bg: linear-gradient(135deg, #000428 0%, #004e92 100%);
            --gradient-card: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            --text-primary: #ffffff;
            --text-secondary: #b3d9ff;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gradient-bg);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animações de fundo */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple));
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 10%;
            right: 30%;
            animation-delay: 1s;
        }

        .shape:nth-child(5) {
            width: 140px;
            height: 140px;
            bottom: 10%;
            right: 40%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0.1;
            }
            50% { 
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.2;
            }
        }

        /* Grid de fundo tech */
        .tech-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 204, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 204, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Container principal */
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        .construction-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .construction-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Logo e branding */
        .logo-section {
            margin-bottom: 40px;
            position: relative;
        }

        .logo-icon {
            width: 120px;
            height: 120px;
            background: var(--gradient-primary);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 
                0 20px 40px rgba(0, 102, 255, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            animation: pulse 2s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, var(--neon-blue), transparent);
            animation: rotate 4s linear infinite;
            opacity: 0.3;
        }

        .logo-icon i {
            font-size: 3.5rem;
            color: white;
            position: relative;
            z-index: 2;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .company-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--neon-blue), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            letter-spacing: -2px;
            text-transform: uppercase;
        }

        .tagline {
            font-size: 1.2rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 40px;
        }

        /* Seção principal */
        .main-content h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .main-content p {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* Barra de progresso */
        .progress-section {
            margin: 40px 0;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .progress-text {
            font-weight: 600;
            color: var(--text-primary);
        }

        .progress-percentage {
            font-weight: 700;
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .progress-bar-container {
            width: 100%;
            height: 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 10px;
            width: 0%;
            animation: progressFill 3s ease-out forwards;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: progressShine 2s infinite;
        }

        @keyframes progressFill {
            0% { width: 0%; }
            100% { width: 75%; }
        }

        @keyframes progressShine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Features em construção */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px 15px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-color);
        }

        .feature-item i {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            display: block;
        }

        .feature-item h3 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .feature-item p {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Botões de contato */
        .contact-section {
            margin-top: 40px;
        }

        .contact-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-contact {
            padding: 15px 30px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 102, 255, 0.4);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: var(--text-primary);
        }

        /* Footer */
        .footer-info {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-info p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin: 5px 0;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .construction-card {
                padding: 40px 25px;
                margin: 10px;
            }

            .company-name {
                font-size: 2.5rem;
            }

            .main-content h1 {
                font-size: 2rem;
            }

            .logo-icon {
                width: 100px;
                height: 100px;
            }

            .logo-icon i {
                font-size: 3rem;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .contact-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-contact {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .company-name {
                font-size: 2rem;
                letter-spacing: -1px;
            }

            .main-content h1 {
                font-size: 1.6rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .construction-card {
                padding: 30px 20px;
            }
        }

        /* Animação de entrada */
        .fade-in {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Animações de fundo -->
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

    <!-- Container principal -->
    <div class="main-container">
        <div class="construction-card fade-in">
            <!-- Logo e branding -->
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-code-slash"></i>
                </div>
                <h1 class="company-name">FT TELECOM</h1>
                <p class="tagline">Desenvolvimento de Software • Omnichannel • WhatsApp Business</p>
            </div>

            <!-- Conteúdo principal -->
            <div class="main-content">
                <h1>💻 Plataforma em Desenvolvimento</h1>
                <p>
                    Estamos criando soluções inovadoras em desenvolvimento de software, plataformas omnichannel 
                    e integração com WhatsApp Business. Nossa expertise técnica está sendo aplicada para 
                    desenvolver ferramentas que transformam a comunicação empresarial e a experiência do cliente.
                </p>

                <!-- Barra de progresso -->
                <div class="progress-section">
                    <div class="progress-label">
                        <span class="progress-text">Progresso do desenvolvimento</span>
                        <span class="progress-percentage">75%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar"></div>
                    </div>
                </div>

                <!-- Features em desenvolvimento -->
                <div class="features-grid">
                    <div class="feature-item">
                        <i class="bi bi-code-square"></i>
                        <h3>Desenvolvimento</h3>
                        <p>Software personalizado</p>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-diagram-3"></i>
                        <h3>Omnichannel</h3>
                        <p>Integração multicanal</p>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-whatsapp"></i>
                        <h3>WhatsApp API</h3>
                        <p>Automação e chatbots</p>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <h3>Cloud Solutions</h3>
                        <p>Infraestrutura escalável</p>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-robot"></i>
                        <h3>IA & Automação</h3>
                        <p>Inteligência artificial</p>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-graph-up-arrow"></i>
                        <h3>Analytics</h3>
                        <p>Dados e insights</p>
                    </div>
                </div>

                <!-- Botões de contato -->
                <div class="contact-section">
                    <div class="contact-buttons">
                        <a href="mailto:dev@fttelecom.com.br" class="btn-contact btn-primary">
                            <i class="bi bi-envelope"></i>
                            Entre em Contato
                        </a>
                        <a href="tel:+5511999999999" class="btn-contact btn-secondary">
                            <i class="bi bi-telephone"></i>
                            Ligue Agora
                        </a>
                    </div>
                </div>

                <!-- Informações de contato -->
                <div class="footer-info">
                    <p><strong>Previsão de lançamento:</strong> Dezembro 2025</p>
                    <p><strong>Email:</strong> dev@fttelecom.com.br</p>
                    <p><strong>WhatsApp Business:</strong>(61) 98150-3910</p>
                    <p><strong>Especialidades:</strong> Software Development • Omnichannel • WhatsApp API</p>
                    
                    <!-- Links sociais -->
                    <div class="social-links">
                        <a href="#" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" aria-label="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animação de digitação para o título
        document.addEventListener('DOMContentLoaded', function() {
            // Efeito de partículas no cursor
            document.addEventListener('mousemove', function(e) {
                createParticle(e.clientX, e.clientY);
            });

            function createParticle(x, y) {
                const particle = document.createElement('div');
                particle.style.position = 'fixed';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.width = '4px';
                particle.style.height = '4px';
                particle.style.background = 'var(--accent-color)';
                particle.style.borderRadius = '50%';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '9999';
                particle.style.opacity = '0.7';
                particle.style.animation = 'particleFade 1s ease-out forwards';
                
                document.body.appendChild(particle);
                
                setTimeout(() => {
                    if (particle.parentNode) {
                        particle.parentNode.removeChild(particle);
                    }
                }, 1000);
            }

            // Adicionar CSS para animação de partículas
            const style = document.createElement('style');
            style.textContent = `
                @keyframes particleFade {
                    0% {
                        opacity: 0.7;
                        transform: scale(1);
                    }
                    100% {
                        opacity: 0;
                        transform: scale(0) translateY(-20px);
                    }
                }
            `;
            document.head.appendChild(style);

            // Animação de contagem da porcentagem
            const percentage = document.querySelector('.progress-percentage');
            let count = 0;
            const target = 75;
            const increment = target / 100;

            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    count = target;
                    clearInterval(timer);
                }
                percentage.textContent = Math.floor(count) + '%';
            }, 30);

            // Adicionar efeito de hover nas feature items
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Efeito de ripple nos botões
            const buttons = document.querySelectorAll('.btn-contact');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // CSS para efeito ripple
            const rippleStyle = document.createElement('style');
            rippleStyle.textContent = `
                .btn-contact {
                    position: relative;
                    overflow: hidden;
                }
                
                .ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(0);
                    animation: rippleEffect 0.6s linear;
                    pointer-events: none;
                }
                
                @keyframes rippleEffect {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(rippleStyle);
        });
    </script>
</body>
</html>

