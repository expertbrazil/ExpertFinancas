<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create admin user';

    public function handle()
    {
        // Create admin role if it doesn't exist
        $role = Role::firstOrCreate(
            ['id' => 1],
            ['name' => 'Administrador']
        );

        $user = User::create([
            'name' => 'Administrador',
            'email' => 'root@expertfinancas.com.br',
            'password' => Hash::make('Expert@2024'),
            'role_id' => $role->id,
        ]);

        $this->info('Admin user created successfully');
        return Command::SUCCESS;
    }
}
