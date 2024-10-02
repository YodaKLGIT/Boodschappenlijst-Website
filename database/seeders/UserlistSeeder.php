<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ShoppingList;

class UserListSeeder extends Seeder
{
    public function run()
    {
        // Get all users and shopping lists
        $users = User::all();
        $shoppingLists = ShoppingList::all();

        // Check if there are any users and shopping lists
        if ($users->isEmpty() || $shoppingLists->isEmpty()) {
            return;
        }

        // Assign each user to a random shopping list
        foreach ($users as $user) {
            // Attach the user to 1 or more shopping lists (randomly)
            $user->shoppingLists()->attach(
                $shoppingLists->random(rand(1, $shoppingLists->count()))->pluck('id')->toArray()
            );
        }
    }
}
