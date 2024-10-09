<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShoppingList; 


class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Step 1: Create a shopping list
        $shoppingList = [
            'name' => 'Wekelijkse Boodschappen', // Name of the shopping list
        ];

        ShoppingList::insert($shoppingList);
        
    }
}
