<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific brands
        $specificBrands = [
            [
                'name' => 'Heinz',
                'description' => 'Thick & Rich ketchup made from red ripe tomatoes',
            ],
            [
                'name' => 'Unox',
                'description' => 'Unox is a leading manufacturer of commercial ovens',
            ],
        ];

        foreach ($specificBrands as $brandData) {
            Brand::factory()->create($brandData);
        }
    }
}
