<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Garante que o papel 'root' existe
        $rootRole = Role::firstOrCreate([
            'name' => 'root',
            'slug' => 'root',
            'description' => 'Administrador do Sistema',
            'permissions' => ['*']
        ]);

        // Criar ou atualizar o usuário admin
        User::updateOrCreate(
            ['email' => 'root@expertfinancas.com.br'], // critério de busca
            [
                'name' => 'Expert Finanças',
                'password' => Hash::make('Expert@2024'),
                'role_id' => $rootRole->id,
                'ativo' => true,
            ]
        );
    }
}
