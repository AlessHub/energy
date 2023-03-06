<?php

namespace Database\Factories;
use App\Models\Forum;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Forum>
 */
class ForumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'cover' => $this->faker->imageUrl,
            'autor' => $this->faker->name,
            'user_id' => User::factory(),
        ];
    }
}
