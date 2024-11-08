<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\ListItem;
use App\Models\User;

class NoteSeeder extends Seeder
{
    public function run()
    {
        $productlists = ListItem::all();
        $users = User::all();

        foreach ($productlists as $productlist) {
            Note::create([
                'title' => 'Shopping List Note',
                'description' => 'Remember to check for discounts on fruits and vegetables.',
                'user_id' => $users->random()->id,
                'list_id' => $productlist->id,
            ]);
        }
    }
}