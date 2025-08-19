<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Trait HasTenantScope
 *
 * Este trait aplica automaticamente um escopo global baseado em
 * `tenant_id` em todos os modelos que o utilizam.  Além disso,
 * preenche o `tenant_id` ao criar um novo registro, caso a
 * instância do tenant esteja disponível em `app('tenant')`.
 */
trait HasTenantScope
{
    /**
     * Register the global scope and set the tenant_id on creating.
     */
    public static function bootHasTenantScope(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = app()->bound('tenant') ? app('tenant') : null;
            if ($tenant) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenant->id);
            }
        });

        static::creating(function (Model $model) {
            $tenant = app()->bound('tenant') ? app('tenant') : null;
            if ($tenant && empty($model->tenant_id)) {
                $model->tenant_id = $tenant->id;
            }
        });
    }
}