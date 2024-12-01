<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateAdminRole extends Command
{
    protected $signature = 'admin:update-role';
    protected $description = 'Update admin user role';

    public function handle()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        
        if (!$adminRole) {
            $this->error('Admin role not found');
            return Command::FAILURE;
        }

        $admin = User::where('email', 'root@expertfinancas.com.br')->first();
        
        if (!$admin) {
            $this->error('Admin user not found');
            return Command::FAILURE;
        }

        $admin->update(['role_id' => $adminRole->id]);

        $this->info('Admin role updated successfully');
        return Command::SUCCESS;
    }
}
