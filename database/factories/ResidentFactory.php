<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fio' => fake()->name(),
            'area' => fake()->numberBetween(600, 2000),
            'start_date' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d H:i:s'),
        ];
    }
}
