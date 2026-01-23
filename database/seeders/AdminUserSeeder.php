<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Always wipe existing admin if needed
        User::where('email', 'admin@pup.edu.ph')->delete();

        User::create([
            'user_id'    => 1, 
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'username'   => 'admin',
            'email'      => 'admin@pup.edu.ph',
            'password'   => Hash::make('Admin12345'),
            'role'       => 'admin',
        ]);
    }
}