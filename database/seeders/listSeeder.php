<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductList;

class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create a product list
        $productList = [
            'name' => 'Wekelijkse Boodschappen', // Name of the product list
        ];

        ProductList::insert($productList);
    }
}
