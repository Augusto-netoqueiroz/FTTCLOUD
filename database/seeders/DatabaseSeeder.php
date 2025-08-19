<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * DatabaseSeeder
 *
 * Cria papéis e permissões padrão para a aplicação.  Este seeder
 * não cria tenants ou usuários; estes são criados via endpoints.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Papéis padrão
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // Permissões básicas
        $permissions = [
            'manage-users',
            'manage-calls',
            'view-reports',
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
            // Atribui permissões ao papel admin
            $adminRole->givePermissionTo($permission);
        }
    }
}