<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('next Sunday', 'next Sunday +7 days');
        $conclusion_date = fake()->dateTimeBetween($start_date, $start_date->format('Y-m-d').' +7 days');

        return [
            'title' => fake()->text(200),
            'description' => fake()->text(5000),
            'start_date' => $start_date->format("Y-m-d"),
            'conclusion_date' => $conclusion_date->format("Y-m-d"),
        ];
    }

}
