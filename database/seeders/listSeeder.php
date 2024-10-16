<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ListItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Theme;

class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 ListItems with unique names
        $listItems = ListItem::factory()
            ->count(5)
            ->create();

        // Get all users
        $users = User::inRandomOrder()->limit(3)->get();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        // Get all themes
        $themes = Theme::all();

        if ($themes->isEmpty()) {
            $this->command->info('No themes found. Please run ThemeSeeder first.');
            return;
        }

        // Get some random existing products
        $products = Product::inRandomOrder()->limit(3)->get();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        // Attach users, themes, and products to each ListItem
        foreach ($listItems as $listItem) {
            // Attach users
            $listItem->users()->attach($users->pluck('id'));

            // Attach a random theme
            $randomTheme = $themes->random();
            $listItem->themes()->attach($randomTheme->id);

            // Attach products
            $productData = $products->mapWithKeys(function ($product) {
                return [$product->id => ['quantity' => rand(1, 5)]];
            })->toArray();

            $listItem->products()->attach($productData);
        }

        $this->command->info('5 ListItems created with unique names, linked with users, associated with existing products, and assigned random themes successfully.');
    }
}
