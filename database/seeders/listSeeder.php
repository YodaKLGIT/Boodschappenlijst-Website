<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ListItem;
use App\Models\Product;

class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a random user
        $user = User::inRandomOrder()->first();

        if (!$user) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        // Create a single ListItem with a random user
        $listItem = ListItem::factory()->create([
            'user_id' => $user->id,
        ]);

        // Get some random existing products
        $products = Product::inRandomOrder()->limit(3)->get();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        // Attach the products to the ListItem
        $listItem->products()->attach($products->pluck('id')->toArray(), [
            'quantity' => fn() => rand(1, 5)
        ]);

        $this->command->info('ListItem seeded and associated with existing products successfully.');
    }
}
