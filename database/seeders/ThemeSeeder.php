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
                'hover_color' => '#B3E5FC',
                'count_circle_color' => '#005588',
            ],
            [
                'name' => 'Forest Green',
                'strap_color' => '#228B22',
                'body_color' => '#E8F5E9',
                'hover_color' => '#C8E6C9',
                'count_circle_color' => '#1B5E20',
            ],
            [
                'name' => 'Sunset Orange',
                'strap_color' => '#FF4500',
                'body_color' => '#FFF3E0',
                'hover_color' => '#FFE0B2',
                'count_circle_color' => '#D84315',
            ],
            [
                'name' => 'Lavender Dream',
                'strap_color' => '#8E4585',
                'body_color' => '#F3E5F5',
                'hover_color' => '#E1BEE7',
                'count_circle_color' => '#6A1B9A',
            ],
            [
                'name' => 'Mint Breeze',
                'strap_color' => '#3EB489',
                'body_color' => '#E0FFF0',
                'hover_color' => '#B2DFDB',
                'count_circle_color' => '#2D8B6D',
            ],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}
