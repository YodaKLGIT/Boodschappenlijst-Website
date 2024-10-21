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
            'strap_color' => $this->faker->hexColor(), // Random hex color
            'body_color' => $this->faker->hexColor(),  // Random hex color
            'content_bg_color' => $this->faker->hexColor(), // Random hex color
            'hover_color' => $this->faker->randomElement(['blue-700', 'green-700', 'red-700', 'pink-700', 'purple-700']), // Random Tailwind color class
            'count_circle_color' => $this->faker->hexColor(), // Random hex color
        ];
    }

    /**
     * Define a default theme.
     *
     * @return array
     */
    public function defaultTheme(): array
    {
        return [
            'name' => 'Default Theme',
            'strap_color' => '#0077BE', // Example default color
            'body_color' => '#E0F7FA', // Example default color
            'content_bg_color' => '#FFFFFF', // Example default color
            'hover_color' => 'blue-700', // Example default Tailwind color class
            'count_circle_color' => '#005588', // Example default color
        ];
    }
}
