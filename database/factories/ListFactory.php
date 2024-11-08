<?php

namespace Database\Factories;

use App\Models\ListItem;
use App\Models\User;
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
        // Fetch a random user ID
        $user = User::inRandomOrder()->first();

        if (!$user) {
            throw new \Exception('No users found. Please ensure UserSeeder is run first.');
        }

        return [
            'name' => $this->faker->unique()->words(3, true),
            'user_id' => $user->id, // Ensure a user_id is set
            'is_favorite' => $this->faker->boolean(30),
            'theme_id' => Theme::inRandomOrder()->first()->id ?? null, // Set a random theme_id if needed
        ];
    }
}
