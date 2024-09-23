<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Voeg voorbeeld merken toe aan de 'brands' tabel
        DB::table('brands')->insert([
            ['name' => 'Nike', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adidas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Puma', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Under Armour', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
