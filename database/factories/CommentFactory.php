<?php

namespace Database\Factories;
use App\Models\Forum;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'content' => fake()->sentence(),
        'autor' => fake()->name(),
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'forum_id' => \App\Models\Forum::inRandomOrder()->first()->id,
        ];
    }
}
