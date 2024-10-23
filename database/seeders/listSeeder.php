<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShoppingList;
use App\Models\User;

class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user (you might want to create a specific user for this or get a random one)
        $user = User::first();

        if (!$user) {
            // If no user exists, create one
            $user = User::factory()->create();
        }

        // Create a shopping list
        ShoppingList::create([
            'name' => 'Wekelijkse Boodschappen', // Name of the shopping list
            'user_id' => $user->id, // Assign the user_id
        ]);
    }
}