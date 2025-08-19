<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Roadmap do Projeto SaaS FTTELECOM</title>
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
    <script>mermaid.initialize({startOnLoad: true});</script>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; line-height: 1.5; }
        h1, h2, h3 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        code { background-color: #f8f8f8; padding: 2px 4px; border-radius: 4px; }
        .legend { font-style: italic; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <h1>Roadmap do Projeto SaaS FTTELECOM</h1>
    <p>
        Este documento compila o <strong>estado atual</strong> do desenvolvimento do SaaS multi‑tenant FTTELECOM e descreve o <strong>roteiro detalhado</strong> das próximas etapas, de acordo com o roteiro detalhado e as melhores práticas descritas anteriormente. A meta é construir uma plataforma escalável em Laravel 11 com integração completa a Asterisk, billing e demais componentes.
    </p>

    <h2>1. Progresso Atual</h2>
    <table>
        <thead>
            <tr>
                <th>Área</th>
                <th>Tarefa</th>
                <th>Status</th>
                <th>Percentual (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td><strong>Projeto de Base</strong></td><td>Estrutura inicial do projeto criada (diretórios <code>app/</code>, <code>config/</code>, <code>routes/</code>, <code>database/</code> etc.)</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Criação de <code>composer.json</code>, <code>.env.example</code> e arquivos de boot (<code>artisan</code>, <code>bootstrap/app.php</code>, <code>public/index.php</code>)</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Configurações básicas (<code>config/app.php</code>, <code>config/database.php</code>, etc.)</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td><strong>Multi‑tenancy</strong></td><td>Implementação do trait <code>HasTenantScope</code></td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Criação do <code>TenantMiddleware</code> (ajustado para usar usuário autenticado)</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Criação do <code>TenantServiceProvider</code> e registro no <code>app.php</code></td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Criação de migrations e modelos para <code>tenants</code>, <code>users</code>, <code>calls</code>, <code>call_legs</code> e <code>recordings</code></td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td><strong>Autenticação e RBAC</strong></td><td>Configuração do Sanctum para autenticação</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Controladores de autenticação (<code>AuthController</code>) com registro de tenant e login</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Instalação e configuração básica do <code>spatie/laravel-permission</code> com migrations customizadas</td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td><strong>Persistência</strong></td><td>Migrations para chamadas, pernas e gravações com <code>tenant_id</code></td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td><strong>Ambiente</strong></td><td>Criação do banco <code>fttelecom</code> e execução de <code>migrate --seed</code></td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td></td><td>Ajuste do Apache para servir a aplicação via <code>public/</code></td><td>✔️ Concluído</td><td>100%</td></tr>
            <tr><td><strong>Integração Asterisk</strong></td><td>Serviços/Jobs de integração ARI/AMI e processamento de eventos</td><td>🚧 A fazer</td><td>0%</td></tr>
            <tr><td><strong>WebRTC e WebSockets</strong></td><td>Configuração do Laravel Reverb/Echo, canais e broadcast</td><td>🚧 A fazer</td><td>0%</td></tr>
            <tr><td><strong>Gravações</strong></td><td>Integração com S3/MinIO para gravações, policies de ciclo de vida</td><td>🚧 A fazer</td><td>0%</td></tr>
            <tr><td><strong>Billing e Planos</strong></td><td>Implementação de módulos de planos, métricas de uso e integração Stripe</td><td>🚧 A fazer</td><td>0%</td></tr>
            <tr><td><strong>Observabilidade</strong></td><td>Health checks, métricas Prometheus/Grafana, logs estruturados</td><td>🚧 A fazer</td><td>0%</td></tr>
            <tr><td><strong>DevOps</strong></td><td>Pipelines CI/CD (tests, build, deploy), infraestrutura como código</td><td>🚧 A fazer</td><td>0%</td></tr>
            <tr><td><strong>Testes</strong></td><td>Testes unitários, integração com Asterisk (mock), testes de carga</td><td>🚧 A fazer</td><td>0%</td></tr>
        </tbody>
    </table>
    <p class="legend"><strong>Lenda:</strong> ✔️ Concluído | 🚧 A fazer</p>

    <h2>2. Diagrama de Arquitetura</h2>
    <p>A seguir apresentamos um diagrama de alto nível representando os principais componentes do sistema e o fluxo de dados. Para maior clareza, a integração com Asterisk, broker de mensagens e storage externo são mostrados de forma simplificada.</p>
    <pre class="mermaid">
flowchart LR
    subgraph Frontend
        A[Frontend Web/Mobile]
    end

    subgraph API
        B[Laravel API]
        B --> B2{Middleware\nAuth + Tenant}
        B2 --> B3[Controladores (Auth, Calls, Tenants)]
        B3 --> B4[Models c/ HasTenantScope]
    end

    subgraph Persistência
        D1[(Database MySQL/PostgreSQL)]
        D2[(S3/MinIO)]
    end

    subgraph Telefonia
        E1[(SIP Proxy\nKamailio/OpenSIPS)]
        E2[(Asterisk Cluster)]
    end

    subgraph Mensageria
        F[(Broker\nRedis/RabbitMQ)]
    end

    A -- HTTP/HTTPS --> B
    B4 <---> D1
    B3 -- Jobs/Events --> F
    F -- Eventos de Chamada --> B3
    B3 -- API ARI/AMI --> E2
    E1 -- SIP/WebRTC --> E2
    E2 -- Mídia --> D2
    A -- WebSockets/WebRTC --> B
    </pre>

    <h2>3. Roteiro Detalhado (Próximas Etapas)</h2>
    <ol>
        <li><strong>Integração com Asterisk</strong>
            <ul>
                <li>Criar serviços ou jobs que consumam ARI/AMI para iniciar, transferir e encerrar chamadas.</li>
                <li>Configurar um broker (Redis ou RabbitMQ) para desacoplar os eventos do Asterisk; publicar eventos de chamadas para jobs no Laravel.</li>
                <li>Modelar a persistência de metadados (eventos de chamada) nas tabelas <code>calls</code> e <code>call_legs</code>.</li>
            </ul>
        </li>
        <li><strong>Comunicação em Tempo Real</strong>
            <ul>
                <li>Configurar Laravel Reverb (ou Pusher) para WebSockets.</li>
                <li>Implementar broadcasting via Laravel Echo para status de chamadas, notificações e chat.</li>
                <li>Proteger conexões WebRTC com DTLS-SRTP, ICE, e tokens de curta duração.</li>
            </ul>
        </li>
        <li><strong>WebRTC e Gravações</strong>
            <ul>
                <li>Configurar suporte WebRTC no Asterisk ou via gateway dedicado.</li>
                <li>Armazenar gravações no storage S3/MinIO com criptografia, versionamento e políticas de ciclo de vida.</li>
                <li>Expor API para download/reprodução de gravações de forma segura.</li>
            </ul>
        </li>
        <li><strong>Billing e Gestão de Planos</strong>
            <ul>
                <li>Criar modelos e migrations para planos, assinaturas e métricas de uso (minutos, canais, armazenamento).</li>
                <li>Integrar com Stripe para cobranças recorrentes e processamento de webhooks.</li>
                <li>Implementar feature flags por plano usando pacotes como <code>spatie/laravel-feature-flags</code>.</li>
            </ul>
        </li>
        <li><strong>Observabilidade e Resiliência</strong>
            <ul>
                <li>Implementar endpoints de health check (<code>/health</code>) e expor métricas via Prometheus.</li>
                <li>Configurar dashboards Grafana para monitorar CPU, memória, latência de chamadas e uso por tenant.</li>
                <li>Adicionar retry com backoff para jobs falhos e circuit breakers em integrações críticas.</li>
            </ul>
        </li>
        <li><strong>Testes</strong>
            <ul>
                <li>Escrever testes unitários para modelos e controllers.</li>
                <li>Criar mocks para ARI/AMI e realizar testes de integração simulando chamadas.</li>
                <li>Implementar testes de carga por tenant para identificar problemas de noisy‑neighbor.</li>
            </ul>
        </li>
        <li><strong>DevOps e Infraestrutura</strong>
            <ul>
                <li>Criar pipelines de CI/CD (GitHub Actions/GitLab CI) com lint, testes e deploy automatizado.</li>
                <li>Provisionar ambiente usando Terraform ou Ansible, incluindo clusters Kubernetes ou VMs com failover e backups.</li>
                <li>Configurar backups automáticos do banco e do storage de gravações.</li>
            </ul>
        </li>
    </ol>

    <h2>4. Conclusão</h2>
    <p>
        O projeto já possui uma base sólida com multi‑tenancy, autenticação, RBAC básico, persistência de chamadas e estrutura de bancos de dados. O próximo passo é evoluir para a integração com Asterisk e os serviços de telefonia, adicionar comunicação em tempo real, billing e observabilidade, conforme o roteiro acima.  Este roadmap deve ser revisado e ajustado à medida que as etapas forem concluídas e novas necessidades surgirem.
    </p>
</body>
</html>
