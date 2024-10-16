<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Ocean Blue',
                'strap_color' => '#0077BE',
                'body_color' => '#E0F7FA',
            ],
            [
                'name' => 'Forest Green',
                'strap_color' => '#228B22',
                'body_color' => '#E8F5E9',
            ],
            [
                'name' => 'Sunset Orange',
                'strap_color' => '#FF4500',
                'body_color' => '#FFF3E0',
            ],
            [
                'name' => 'Lavender Dream',
                'strap_color' => '#8E4585',
                'body_color' => '#F3E5F5',
            ],
            [
                'name' => 'Midnight Black',
                'strap_color' => '#000000',
                'body_color' => '#303030',
            ],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}

