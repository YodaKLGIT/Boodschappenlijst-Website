<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the test user
        User::updateOrCreate(
            ['email' => 'test@example.com'], // Check for existing email
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Create 10 random users with unique emails
        User::factory()->count(10)->create([
            'role' => 'user',
        ]);
    }
}
