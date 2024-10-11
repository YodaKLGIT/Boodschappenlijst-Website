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
        

        //Create 10 random users with the role 'user'
        User::factory()->count(10)->create([
            'role' => 'user',
        ]);

    
        
    }
}
