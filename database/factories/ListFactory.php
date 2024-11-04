<?php

namespace Database\Factories;

use App\Models\ListItem;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ListItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'is_favorite' => $this->faker->boolean(30),
            'theme_id' => Theme::all()->random()->id,
        ];
    }
}
