<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FrontendUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Frontend User',
            'email' => 'frontenduser@example.com',
            'password' => Hash::make('UserPassword123'),
            'role' => 'user', // Assuming 'role' column exists and 'user' is for front end users
            'email_verified_at' => now(),
        ]);
    }
}
