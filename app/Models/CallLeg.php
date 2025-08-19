<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTenantScope;

/**
 * Model CallLeg
 *
 * Representa uma perna (leg) de uma chamada.  Cada leg refere‑se a um
 * canal específico no Asterisk e possui informações de início e fim.
 */
class CallLeg extends Model
{
    use HasFactory, HasTenantScope;

    protected $fillable = [
        'tenant_id',
        'call_id',
        'channel',
        'participant',
        'started_at',
        'ended_at',
        'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }
}