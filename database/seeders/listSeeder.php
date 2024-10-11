<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\User;
use App\Models\Note;
use App\Models\ProductList; // Zorg ervoor dat de naam correct is


class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        foreach ($notes as $noteData) {
            Note::create($noteData);
        }

        // Voeg enkele shopping lists toe
        $productLists = [
            ['name' => 'Weekly Groceries', 'date' => '2024-09-01'],
            ['name' => 'Party Supplies', 'date' => '2024-09-10'],
        ];

        foreach ($productLists as $listData) {
            $list = ProductList::create($listData);

            // Koppel de eerste gebruiker aan de shopping list
            $list->users()->attach(1); // Koppel Alice aan de eerste shopping list
            $list->users()->attach(2); // Koppel Bob aan de tweede shopping list

            // Koppel notities aan de shopping list
            $noteIds = Note::pluck('id')->toArray(); // Haal alle notitie-ID's op
            $list->notes()->createMany(array_map(fn($id) => ['name' => "Note for list $id"], $noteIds));

            // Koppel producten aan de shopping list
            $list->products()->attach([
                1 => ['quantity' => 5], // Voorbeeld: 5 stuks van product met ID 1
                2 => ['quantity' => 3], // Voorbeeld: 3 stuks van product met ID 2
            ]);
        }

        // Step 1: Create a product list
        $productList = [
            'name' => 'Wekelijkse Boodschappen', // Name of the product list
        ];

        ProductList::insert($productList);
    }
}
