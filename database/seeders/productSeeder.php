<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ShoppingList; // Verander List naar ShoppingList
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Voeg enkele merken toe
        $brands = [
            ['name' => 'Brand A', 'description' => 'High quality brand A'],
            ['name' => 'Brand B', 'description' => 'Reliable brand B'],
            ['name' => 'Brand C', 'description' => 'Popular brand C'],
        ];

        foreach ($brands as $brandData) {
            $brand = Brand::create($brandData);
        }

        // Voeg enkele categorieën toe
        $categories = [
            ['name' => 'Fruit', 'description' => 'Fresh and organic fruits'],
            ['name' => 'Dairy', 'description' => 'Milk, cheese, and more'],
            ['name' => 'Beverages', 'description' => 'Drinks and refreshments'],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
        }

        // Voeg enkele lijsten toe
        $lists = [
            ['name' => 'Weekly Groceries', 'date' => '2024-09-01'],
            ['name' => 'Party Supplies', 'date' => '2024-09-10'],
        ];

        foreach ($lists as $listData) {
            $list = ShoppingList::create($listData); // Verander List naar ShoppingList
        }

        // Voeg producten toe
        $products = [
            ['name' => 'Bananas', 'description' => 'A bunch of ripe bananas', 'brand_id' => 1, 'category_id' => 1],
            ['name' => 'Milk', 'description' => '1L of fresh milk', 'brand_id' => 2, 'category_id' => 2],
            ['name' => 'Orange Juice', 'description' => 'Freshly squeezed juice', 'brand_id' => 3, 'category_id' => 3],
            ['name' => 'Cheese', 'description' => '200g of cheddar cheese', 'brand_id' => 1, 'category_id' => 2],
            ['name' => 'Apples', 'description' => 'Crisp red apples', 'brand_id' => 2, 'category_id' => 1],
            // Voeg 15 andere producten toe op een vergelijkbare manier
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
            

            $product->lists()->attach([1, 2]); 
        }
    }
}
