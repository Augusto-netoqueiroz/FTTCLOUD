<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\HasTenantScope;

/**
 * Model User
 *
 * Representa um usuário autenticável da aplicação.  Os usuários são
 * associados a um tenant (inquilino) por meio da coluna `tenant_id`.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasTenantScope;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
    ];

    /**
     * Os atributos que devem permanecer ocultos ao serializar.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos em tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamento com o tenant proprietário.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function endpoint()
{
    return $this->belongsTo(\App\Models\PsEndpoint::class, 'extension_id', 'id');
}
}