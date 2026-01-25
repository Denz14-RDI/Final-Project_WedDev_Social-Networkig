<?php
// ------------------------------------------------------------
// Admin User Seeder
// ------------------------------------------------------------
// This seeder ensures that an admin account always exists.
// It removes any existing admin with the same email,
// then creates a fresh admin user with default credentials.
// ------------------------------------------------------------

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    // --------------------
    // Run the seeder
    // --------------------
    // Delete any existing admin account with the same email.
    // Create a new admin user with fixed details.
    public function run(): void
    {
        // Remove existing admin if present
        User::where('email', 'admin@pup.edu.ph')->delete();

        // Create a new admin account
        User::create([
            'user_id'    => 1, 
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'username'   => 'admin',
            'email'      => 'admin@pup.edu.ph',
            'password'   => Hash::make('Admin12345'), // secure password hashing
            'role'       => 'admin',
        ]);
    }
}