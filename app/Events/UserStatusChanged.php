<?php

namespace App\Events;

use App\Models\UserSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $tenantId;
    public int $userId;
    public string $status;
    public ?int $sessionId;
    public ?string $startedAt;
    public ?string $endedAt;

    /**
     * Recebe a sessão diretamente (compatível com as chamadas atuais do controller).
     */
    public function __construct(UserSession $session)
    {
        $this->tenantId  = (int) $session->tenant_id;
        $this->userId    = (int) $session->user_id;
        $this->status    = (string) $session->status;
        $this->sessionId = $session->id ? (int) $session->id : null;

        // Normaliza datas para string ISO 8601 quando possível
        $this->startedAt = $session->started_at
            ? (method_exists($session->started_at, 'toIso8601String') ? $session->started_at->toIso8601String() : (string) $session->started_at)
            : null;

        $this->endedAt = $session->ended_at
            ? (method_exists($session->ended_at, 'toIso8601String') ? $session->ended_at->toIso8601String() : (string) $session->ended_at)
            : null;
    }

    /**
     * Canal de broadcast. Se quiser privacidade por usuário, troque para PrivateChannel e
     * implemente a autorização do canal.
     */
    public function broadcastOn(): array
    {
        return [new Channel("tenant.{$this->tenantId}.users")];
    }

    public function broadcastAs(): string
    {
        return 'user.status.changed';
    }

    /**
     * Payload enviado ao frontend.
     */
    public function broadcastWith(): array
    {
        return [
            'tenant_id'  => $this->tenantId,
            'user_id'    => $this->userId,
            'status'     => $this->status,
            'session_id' => $this->sessionId,
            'started_at' => $this->startedAt,
            'ended_at'   => $this->endedAt,
        ];
    }
}
