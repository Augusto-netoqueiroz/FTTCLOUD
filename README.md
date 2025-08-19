# FTTelecom SaaS

Este repositório contém um esqueleto completo de aplicação SaaS desenvolvido com **Laravel 11** focado em comunicação por voz via **Asterisk** e multi‑tenancy.

O objetivo deste projeto é fornecer uma base sólida para a criação de um produto SaaS multi‑tenant.  As principais características incluem:

* **Multi‑tenancy** utilizando um único banco de dados com coluna `tenant_id` para particionamento horizontal.  Um middleware resolve o inquilino pelo subdomínio e injeta a instância em `app('tenant')`.  Todos os modelos usam um *trait* global (`HasTenantScope`) para garantir que todas as consultas sejam filtradas automaticamente pelo `tenant_id`.
* **Autenticação via API** utilizando Laravel Sanctum.  Usuários são associados a um tenant e podem se registrar e autenticar via JSON Web Tokens fornecidos pelo Sanctum.
* **Integração com telefonia (Asterisk)** com tabelas dedicadas para registros de chamadas (`calls`), perna de chamadas (`call_legs`) e gravações (`recordings`).  Estes modelos já incluem o escopo multi‑tenant e servem como base para integrações futuras com ARI/AMI e WebRTC.
* **Estrutura de diretórios** enxuta conforme o *slim skeleton* do Laravel 11, com adição de arquivos e pastas voltados para a estratégia SaaS: `app/Traits/HasTenantScope.php`, `app/Http/Middleware/TenantMiddleware.php`, `app/Providers/TenantServiceProvider.php`, e rotas separadas para APIs multi‑tenant.
* **Migrations e seeds** prontos para criar todas as tabelas necessárias, incluindo tenants, usuários, chamadas, gravações e um sistema básico de funções/permissões.  Todas as tabelas aplicam o `tenant_id` como chave estrangeira quando apropriado.

Para utilizar esta base você precisará de um ambiente com PHP 8.2 ou superior, Composer e um servidor MySQL ou PostgreSQL.  A estrutura aqui apresentada não inclui a pasta `vendor` nem os arquivos gerados automaticamente pelo instalador do Laravel; esses devem ser instalados via Composer.  Veja a seção **Instalação** abaixo para mais detalhes.

## Instalação

1. Garanta que você tenha **PHP 8.2+**, **Composer** e um servidor de banco de dados MySQL/PostgreSQL disponíveis.
2. Clone este repositório em `/var/www/html/fttelecom` (ou outro diretório de sua preferência):

   ```bash
   git clone <repositorio> /var/www/html/fttelecom
   cd /var/www/html/fttelecom
   ```

3. Instale as dependências do Laravel:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure as variáveis de ambiente no arquivo `.env` (conexão com banco de dados, host, portas etc.).

5. Crie o banco de dados `fttelecom` no seu servidor SQL e, em seguida, execute as migrations e seeders:

   ```bash
   php artisan migrate --seed
   ```

6. Inicie o servidor de desenvolvimento:

   ```bash
   php artisan serve
   ```

## Resolução de Tenant

Este projeto utiliza subdomínios para identificar os tenants.  Quando uma requisição chega, o middleware `TenantMiddleware` extrai o subdomínio do host (por exemplo, `acme.example.com` define o subdomínio `acme`) e busca a entrada correspondente na tabela `tenants` (campo `subdomain`).  Se encontrar, a instância é registrada em `app('tenant')` e utilizada pelo escopo global para filtrar todas as queries.

Para testar localmente você pode editar seu arquivo `/etc/hosts` adicionando entradas apontando diferentes subdomínios para `localhost`, por exemplo:

```
127.0.0.1   acme.localhost
127.0.0.1   beta.localhost
```

No arquivo `.env` configure `APP_URL` como `http://acme.localhost:8000` para que as URL assinadas sejam geradas corretamente.

## Licença

Este projeto é fornecido como um ponto de partida e não inclui nenhuma garantia de produção.  Sinta‑se livre para adaptar e estender conforme suas necessidades.