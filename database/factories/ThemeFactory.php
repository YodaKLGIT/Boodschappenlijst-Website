<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Theme::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'strap_color' => $this->faker->hexColor() ?? 'bg-black-800',
            'body_color' => $this->faker->hexColor() ?? 'bg-pink-100',
            'content_bg_color' => $this->faker->hexColor() ?? 'bg-white',
            'hover_color' => $this->faker->hexColor() ?? 'bg-pink-200',
            'count_circle_color' => $this->faker->hexColor() ?? 'bg-gray-800',
        ];
    }
}
