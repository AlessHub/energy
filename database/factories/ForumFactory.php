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
            'image' => $this->faker->image(public_path('covers/forums'), 640, 480, null, false),
            'autor' => $this->faker->name,
            'user_id' => User::factory(),
        ];
    }
}
