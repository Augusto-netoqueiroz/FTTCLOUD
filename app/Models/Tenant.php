<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Tenant
 *
 * Representa um inquilino (cliente) no sistema.  Cada tenant possui
 * um subdomínio único usado para resolução nas requisições.
 */
class Tenant extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'subdomain',
        'database',
    ];

    /**
     * Um tenant possui muitos usuários.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}