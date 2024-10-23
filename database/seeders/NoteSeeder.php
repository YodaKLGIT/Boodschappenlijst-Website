<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Shoppinglist;
use App\Models\User;

class NoteSeeder extends Seeder
{
    public function run()
    {
        $shoppinglists = Shoppinglist::all();
        $users = User::all();

        foreach ($shoppinglists as $shoppinglist) {
            Note::create([
                'title' => 'Shopping List Note',
                'description' => 'Remember to check for discounts on fruits and vegetables.',
                'user_id' => $users->random()->id,
                'shoppinglist_id' => $shoppinglist->id,
            ]);
        }
    }
}