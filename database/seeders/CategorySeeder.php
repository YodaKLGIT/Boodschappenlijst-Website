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
        $categories = [
            [
                'name' => 'Daily',
                'description' => '...',
            ],
            [
                'name' => 'Vegatables',
                'description' => '...',
            ],
        ];
            // Insert posts into the database using the Post model
            Category::insert($categories);
    }
}
