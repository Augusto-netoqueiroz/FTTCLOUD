<?php

namespace App\Services;

use App\Models\User;

class SipConfigService
{
    public function forUser(User $user): ?array
    {
        $endpoint = $user->endpoint; // ps_endpoints
        if (!$endpoint) return null;

        $auth = $endpoint->authRef; // ps_auths
        $transport = $endpoint->transportRef; // ps_transports

        // Dominio SIP: prioriza from_domain do endpoint, senão .env
        $domain = $endpoint->from_domain ?: config('sip.domain', env('SIP_DOMAIN', 'pbx.fttelecom.cloud'));

        // URL WSS: prioriza .env; se não, tenta derivar por padrão 8089/ws
        $wss = config('sip.wss', env('SIP_WSS'));
        if (!$wss) {
            $host = $transport?->external_signaling_address ?: $domain;
            $port = $transport?->external_signaling_port ?: 8089;
            $wss = "wss://{$host}:{$port}/ws";
        }

        // Usuário/senha do ramal
        $userName = $auth?->username;
        $pass = $auth?->password;

        if (!$userName || !$pass) return null;

        return [
            'wss'    => $wss,
            'domain' => $domain,
            'user'   => $userName,
            'pass'   => $pass,
            'displayName' => $user->name,
        ];
    }
}
