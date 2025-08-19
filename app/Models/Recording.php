<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTenantScope;

/**
 * Model Recording
 *
 * Representa a gravação de uma chamada.  As gravações são
 * armazenadas em object storage externo e referenciadas pelo campo
 * `file_path`.  Metadados adicionais podem ser armazenados em
 * formato JSON em `metadata`.
 */
class Recording extends Model
{
    use HasFactory, HasTenantScope;

    protected $fillable = [
        'tenant_id',
        'call_id',
        'file_path',
        'recorded_at',
        'duration',
        'metadata',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'metadata'    => 'array',
    ];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }
}