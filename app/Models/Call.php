<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTenantScope;

/**
 * Model Call
 *
 * Representa uma chamada telefônica.  Cada chamada possui
 * múltiplas pernas (CallLeg) e zero ou mais gravações.  O campo
 * `metadata` permite armazenar informações adicionais em formato JSON.
 */
class Call extends Model
{
    use HasFactory, HasTenantScope;

    protected $fillable = [
        'tenant_id',
        'direction',
        'status',
        'started_at',
        'ended_at',
        'duration',
        'metadata',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
        'metadata'   => 'array',
    ];

    public function legs()
    {
        return $this->hasMany(CallLeg::class);
    }

    public function recordings()
    {
        return $this->hasMany(Recording::class);
    }
}