<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    public function definition(): array
    {
        $degreeType = fake()->randomElement(['bachelor', 'master', 'phd']);

        return [
            'department_id' => Department::factory(),
            'name' => fake()->sentence(3),
            'code' => strtoupper(fake()->unique()->lexify('??')),
            'degree_type' => $degreeType,
            'duration_years' => $degreeType === 'bachelor' ? 4 : ($degreeType === 'master' ? 2 : 3),
            'total_credits' => $degreeType === 'bachelor' ? 120 : ($degreeType === 'master' ? 60 : 90),
            'description' => fake()->optional()->paragraph(),
            'is_active' => true,
        ];
    }

    public function bachelor(): static
    {
        return $this->state(fn (array $attributes) => [
            'degree_type' => 'bachelor',
            'duration_years' => 4,
            'total_credits' => 120,
        ]);
    }

    public function master(): static
    {
        return $this->state(fn (array $attributes) => [
            'degree_type' => 'master',
            'duration_years' => 2,
            'total_credits' => 60,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
