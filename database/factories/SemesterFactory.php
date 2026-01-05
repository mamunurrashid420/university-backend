<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semester>
 */
class SemesterFactory extends Factory
{
    public function definition(): array
    {
        $year = fake()->numberBetween(2020, 2030);
        $name = fake()->randomElement(['Spring', 'Summer', 'Fall']);

        return [
            'name' => $name,
            'year' => $year,
            'start_date' => fake()->optional()->date(),
            'end_date' => fake()->optional()->date(),
            'is_active' => true,
        ];
    }

    public function spring(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Spring',
        ]);
    }

    public function summer(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Summer',
        ]);
    }

    public function fall(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Fall',
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
