<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id, // Set role_id explicitly
        ]);
        $admin->assignRole($adminRole);

        $users = User::factory()->count(10)->create();
        foreach ($users as $user) {
            $user->update(['role_id' => $userRole->id]); // Set role_id explicitly
            $user->assignRole($userRole);
        }
    }
}
