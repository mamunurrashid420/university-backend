<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'program_id' => Program::factory(),
            'department_id' => fn (array $attributes) => Program::find($attributes['program_id'])->department_id,
            'code' => strtoupper(fake()->lexify('??###')),
            'name' => fake()->words(3, true),
            'credits' => fake()->numberBetween(1, 4),
            'description' => fake()->optional()->paragraph(),
            'is_core' => fake()->boolean(70),
            'prerequisites' => null,
            'is_active' => true,
        ];
    }

    public function core(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_core' => true,
        ]);
    }

    public function elective(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_core' => false,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
