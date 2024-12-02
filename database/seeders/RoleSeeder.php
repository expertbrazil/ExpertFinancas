<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Criar papel de administrador
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrador do sistema com acesso total'
        ]);

        // Criar todas as permissões
        $permissions = [
            // Financeiro
            'financeiro.receitas',
            'financeiro.despesas',
            'financeiro.fluxo-caixa',
            'financeiro.conciliacao',
            
            // Relatórios
            'relatorios.clientes',
            'relatorios.faturas',
            'relatorios.tickets',
            'relatorios.financeiro',
            
            // Configurações
            'configuracoes.empresa',
            'configuracoes.usuarios',
            'configuracoes.permissoes',
            'configuracoes.notificacoes',
            'configuracoes.integracao',
            'configuracoes.backup',
            'configuracoes.logs',
            
            // Módulos existentes
            'clientes.view',
            'clientes.create',
            'clientes.edit',
            'clientes.delete',
            'faturas.view',
            'faturas.create',
            'faturas.edit',
            'faturas.delete',
            'documentos.view',
            'documentos.create',
            'documentos.edit',
            'documentos.delete'
        ];

        // Criar permissões e associar ao papel de admin
        foreach ($permissions as $permissionName) {
            $permission = Permission::create([
                'name' => $permissionName,
                'description' => 'Permissão para ' . str_replace('.', ' ', $permissionName)
            ]);
            
            $adminRole->permissions()->attach($permission->id);
        }
    }
}
