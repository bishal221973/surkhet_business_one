<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::create([
            'name' => 'Super Admin',
            'email'=>'superadmin@example.com',
            'email_verified_at' => now(),
            'password'=>Hash::make('password'),
            'phone'=>'9814668499'
        ]);

        $role = Role::create(['name' => 'super-admin']);

        $user->assignRole($role);
    }
}
