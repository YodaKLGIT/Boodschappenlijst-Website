<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing brands and categories
        $brands = Brand::all();
        $categories = Category::all();

        // Ensure we have brands and categories
        if ($brands->isEmpty() || $categories->isEmpty()) {
            throw new \Exception('Please run BrandSeeder and CategorySeeder before ProductSeeder');
        }

        $products = [
            ['name' => 'Bananas', 'description' => 'A bunch of ripe bananas', 'image_url' => 'images/banana.png'],
            ['name' => 'Milk', 'description' => '1L of fresh milk', 'image_url' => 'images/milk.png'],
            ['name' => 'Orange Juice', 'description' => 'Freshly squeezed juice', 'image_url' => 'images/orangeJuice.png'],
            ['name' => 'Cheese', 'description' => '200g of cheddar cheese', 'image_url' => 'images/cheese.png'],
            ['name' => 'Apples', 'description' => 'Crisp red apples', 'image_url' => 'images/apples.png'],
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'brand_id' => $brands->random()->id,
                'category_id' => $categories->random()->id,
            ]));
        }

        // Create additional random products
    }
}
