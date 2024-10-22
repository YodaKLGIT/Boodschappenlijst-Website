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
     * Define a common set of valid Tailwind CSS hover colors
     */
   

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
            'hover_color' => $this->faker->hexColor(), // Use the common colors
            'count_circle_color' => $this->faker->hexColor(), // Random hex color
        ];
    }

    /**
     * Define a default theme.
     *
     * @return array
     */
}
