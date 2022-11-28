<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 2; $i++) {
            if ($i == 0) {
                $email = 'super.admin@gmail.com';
                $name = 'Super Admin';
                $role = 'super_admin';
            } else {
                $role = 'admin';
                $email = 'admin@gmail.com';
                $name = 'Admin';
            }
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('12345678'),
                'role_user' => $role,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
