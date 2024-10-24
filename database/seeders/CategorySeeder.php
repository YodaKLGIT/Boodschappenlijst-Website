<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific categories
        $specificCategories = [
            [
                'name' => 'Daily',
                'description' => 'Everyday essentials',
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Fresh produce and greens',
            ],
        ];

        foreach ($specificCategories as $categoryData) {
            Category::factory()->create($categoryData);
        }
    }
}
