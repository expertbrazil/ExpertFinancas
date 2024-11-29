<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primeiro cria os papéis
        $this->call(RoleSeeder::class);
        
        // Depois cria o usuário admin
        $this->call(AdminSeeder::class);
    }
}
