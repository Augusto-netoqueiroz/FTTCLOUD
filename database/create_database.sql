-- Criação do banco de dados principal para a aplicação FTTelecom
-- Execute este script com um usuário que tenha permissão de criar bancos

CREATE DATABASE IF NOT EXISTS fttelecom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE fttelecom;

-- As tabelas serão criadas pelas migrations do Laravel.  Para
-- executá‑las, utilize o comando `php artisan migrate` após
-- configurar o arquivo .env com as credenciais corretas.