<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'view courses']);
        Permission::create(['name' => 'manage courses']);

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $adminRole->givePermissionTo(['view courses', 'manage courses']);
        $userRole->givePermissionTo('view courses');
    }
}
