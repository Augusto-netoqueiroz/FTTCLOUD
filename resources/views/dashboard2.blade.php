<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FT Telecom - Dashboard</title>
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

    <!-- Layout dashboard -->
    <div class="dashboard">
        <!-- Barra lateral -->
        <aside class="sidebar">
            <h2>FT TELECOM</h2>
            <ul class="menu">
                <li><a href="#" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="#"><i class="bi bi-telephone"></i> Chamadas</a></li>
                <li><a href="#"><i class="bi bi-disc"></i> Gravações</a></li>
                <li><a href="#"><i class="bi bi-people"></i> Usuários</a></li>
                <li><a href="#"><i class="bi bi-building"></i> Tenants</a></li>
                <li><a href="#"><i class="bi bi-box-seam"></i> Planos</a></li>
                <li><a href="#"><i class="bi bi-gear"></i> Configurações</a></li>
                <li><a href="#"><i class="bi bi-bar-chart"></i> Relatórios</a></li>
            </ul>
            <div>
                <a href="#" class="btn btn-secondary" style="width:100%; justify-content:center;"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </aside>

        <!-- Conteúdo principal -->
        <div class="content">
            <div class="dashboard-header">
                <h1>Visão Geral</h1>
                <div>
                    <span>Olá, Admin</span>
                    <a href="#" class="btn btn-primary" style="margin-left:15px;"><i class="bi bi-plus-circle"></i> Nova Chamada</a>
                </div>
            </div>
            <!-- Cartões estatísticos -->
            <div class="cards">
                <div class="card-stat">
                    <h3>125</h3>
                    <span>Chamadas Hoje</span>
                </div>
                <div class="card-stat">
                    <h3>58</h3>
                    <span>Chamadas Ativas</span>
                </div>
                <div class="card-stat">
                    <h3>12</h3>
                    <span>Gravações Pendentes</span>
                </div>
                <div class="card-stat">
                    <h3>32</h3>
                    <span>Usuários Online</span>
                </div>
            </div>

            <!-- Tabela de chamadas recentes -->
            <div style="margin-top:40px;">
                <h2 style="margin-bottom:20px; font-family:'Space Grotesk', sans-serif;">Últimas Chamadas</h2>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse: collapse; background: rgba(255,255,255,0.05); border-radius: 12px;">
                        <thead>
                            <tr>
                                <th style="padding:10px 15px; text-align:left; color:var(--text-primary); font-weight:600;">Número</th>
                                <th style="padding:10px 15px; text-align:left; color:var(--text-primary); font-weight:600;">Agente</th>
                                <th style="padding:10px 15px; text-align:left; color:var(--text-primary); font-weight:600;">Início</th>
                                <th style="padding:10px 15px; text-align:left; color:var(--text-primary); font-weight:600;">Duração</th>
                                <th style="padding:10px 15px; text-align:left; color:var(--text-primary); font-weight:600;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-top:1px solid rgba(255,255,255,0.1);">
                                <td style="padding:10px 15px; color: var(--text-secondary);">+55 11 9999-9999</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">João Silva</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">10:20</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">05:23</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">Encerrada</td>
                            </tr>
                            <tr style="border-top:1px solid rgba(255,255,255,0.1);">
                                <td style="padding:10px 15px; color: var(--text-secondary);">+55 61 98150-3910</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">Maria Souza</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">10:10</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">02:10</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">Ativa</td>
                            </tr>
                            <tr style="border-top:1px solid rgba(255,255,255,0.1);">
                                <td style="padding:10px 15px; color: var(--text-secondary);">+55 21 3456-7890</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">Carlos Pereira</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">09:55</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">12:05</td>
                                <td style="padding:10px 15px; color: var(--text-secondary);">Encerrada</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>