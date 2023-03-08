<?php

namespace Database\Factories;
use App\Models\Advice;
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\advice>
 */
class AdviceFactory extends Factory
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
            'value' => fake()->numberBetween(1, 10),
            'type' => fake()->randomElement(['positive', 'negative']),
        ];
    }
}
