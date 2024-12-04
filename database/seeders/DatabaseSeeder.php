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
        $this->call([
            RootUserSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            // Outros seeders aqui...
        ]);
    }
}
