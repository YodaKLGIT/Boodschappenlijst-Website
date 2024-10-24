<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update the test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            UserSeeder::class, 
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            ThemeSeeder:: class,
            ListSeeder::class,     
        ]);
    }
}