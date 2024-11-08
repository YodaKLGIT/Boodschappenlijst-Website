<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ListItem;
use App\Models\User;


class UserlistSeeder extends Seeder
{
    public function run()
    {
        // Get all users and shopping lists
        $users = User::all();
        $shoppingLists = ListItem::all();

        // Check if there are any users and shopping lists
        if ($users->isEmpty() || $shoppingLists->isEmpty()) {
            return;
        }

        // Assign each user to 1 or more random shopping lists
        foreach ($users as $user) {
            // Randomly choose a number of shopping lists to attach
            $randomLists = $shoppingLists->random(rand(1, 3))->pluck('id')->toArray();

            // Attach the user to the selected shopping lists
            $user->shoppingLists()->attach($randomLists);
        }
    }
}