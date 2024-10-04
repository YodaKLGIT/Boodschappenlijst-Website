<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShoppingList;
use App\Models\Product;

class ProductlistSeeder extends Seeder
{
    public function run()
    {
        // Get all shopping lists and products
        $shoppingLists = ShoppingList::all();
        $products = Product::all();

        // Check if there are any shopping lists and products
        if ($shoppingLists->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Attach products to each shopping list
        foreach ($shoppingLists as $shoppingList) {
            foreach ($products as $product) {
                // You can set a random quantity or any specific logic here
                $quantity = rand(1, 10); // Random quantity between 1 and 10

                $shoppingList->products()->attach($product->id, ['quantity' => $quantity]);
            }
        }
    }
}