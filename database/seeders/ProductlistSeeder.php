<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductList;
use App\Models\Product;

class ProductlistSeeder extends Seeder
{
    public function run()
    {

        // Get all product lists and products
        $productLists = ProductList::all();
        $products = Product::all();

        // Check if there are any product lists and products
        if ($productLists->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Attach products to each product list
        foreach ($productLists as $productList) {
            foreach ($products as $product) {
                // You can set a random quantity or any specific logic here
                $quantity = rand(1, 10); // Random quantity between 1 and 10

                $productList->products()->attach($product->id, ['quantity' => $quantity]);
            }
              
    }  
}