<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Voeg producten toe
        $products = [
            ['name' => 'Bananas', 'description' => 'A bunch of ripe bananas', 'brand_id' => 1, 'category_id' => 1, 'image_url' => 'images/banana.png'],
            ['name' => 'Milk', 'description' => '1L of fresh milk', 'brand_id' => 2, 'category_id' => 2,'image_url' => 'images/milk.png' ],
            ['name' => 'Orange Juice', 'description' => 'Freshly squeezed juice', 'brand_id' => 2, 'category_id' => 2, 'image_url' => 'images/orangeJuice.png'],
            ['name' => 'Cheese', 'description' => '200g of cheddar cheese', 'brand_id' => 1, 'category_id' => 2,'image_url' => 'images/cheese.png'],
            ['name' => 'Apples', 'description' => 'Crisp red apples', 'brand_id' => 2, 'category_id' => 1,'image_url' => 'images/apples.png'],
            // Voeg 15 andere producten toe op een vergelijkbare manier
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
        }
    }
}
