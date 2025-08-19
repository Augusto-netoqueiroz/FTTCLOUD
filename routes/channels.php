<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Aqui você pode registrar todos os canais de broadcast que sua
| aplicação suporta.  O Laravel Reverb/Echo utilizará estes canais
| para transmitir eventos em tempo real aos clientes autenticados.
*/

// Exemplo de canal para status de chamada
Broadcast::channel('call.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('tenant.{tenantId}.users', function ($user, $tenantId) {
    return (int) $user->tenant_id === (int) $tenantId;
});

Broadcast::channel('tenants.{tenantId}.users.status', function ($user, $tenantId) {
    // Permita somente usuários do mesmo tenant (adicione RBAC se necessário)
    return (int) $user->tenant_id === (int) $tenantId;
});