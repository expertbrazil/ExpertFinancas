<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar ou atualizar o usuário root
        User::updateOrCreate(
            ['email' => 'root@expertfinance.com.br'],
            [
                'name' => 'Root User',
                'email' => 'root@expertfinance.com.br',
                'password' => Hash::make('Expert@2025'),
                'role' => 'root',
                'is_root' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
