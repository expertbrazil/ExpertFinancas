<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'Acesso total ao sistema',
                'permissions' => [
                    'users.view',
                    'users.create',
                    'users.edit',
                    'users.delete',
                    'finances.view',
                    'finances.create',
                    'finances.edit',
                    'finances.delete',
                    'reports.view',
                    'reports.create',
                    'reports.export',
                    'tickets.admin',
                    'clientes.manage'
                ]
            ],
            [
                'name' => 'Usuário',
                'slug' => 'user',
                'description' => 'Acesso limitado ao sistema',
                'permissions' => [
                    'finances.view',
                    'finances.create',
                    'finances.edit',
                    'reports.view',
                    'tickets.view',
                    'tickets.respond'
                ]
            ],
            [
                'name' => 'Cliente',
                'slug' => 'cliente',
                'description' => 'Acesso ao portal do cliente',
                'permissions' => [
                    'dashboard.view',
                    'faturas.view',
                    'faturas.download',
                    'documentos.view',
                    'documentos.download',
                    'tickets.create',
                    'tickets.view',
                    'tickets.respond',
                    'perfil.edit'
                ]
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                [
                    'name' => $role['name'],
                    'description' => $role['description'],
                    'permissions' => $role['permissions']
                ]
            );
        }
    }
}
