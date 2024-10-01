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
        $brands = [
            [
                'name' => 'Heinz',
                'description' => 'Thick & Rich ketchup made from red ripe tomatoes',
            ],
            [
                'name' => 'Unox',
                'description' => 'Unox is a leading manufacturer of commercial ovens',
            ],
        ];
        // Insert posts into the database using the Post model
        Brand::insert($brands);
    }
}
