<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Program;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admission>
 */
class AdmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = Department::factory();

        // Use existing semester if available, otherwise create one ensuring uniqueness
        $existingSemester = Semester::inRandomOrder()->first();
        if ($existingSemester) {
            $semester = $existingSemester;
        } else {
            $semesterAttributes = Semester::factory()->make()->getAttributes();
            $semester = Semester::firstOrCreate(
                [
                    'name' => $semesterAttributes['name'],
                    'year' => $semesterAttributes['year'],
                ],
                $semesterAttributes
            );
        }

        return [
            'semester_id' => $semester->id,
            'department_id' => $department,
            'program_id' => Program::factory()->for($department),
            'full_name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'hear_about_us' => fake()->optional()->randomElement(['Website', 'Social Media', 'Friend/Relative', 'Advertisement', 'Other']),
            'father_name' => fake()->optional()->name('male'),
            'mother_name' => fake()->optional()->name('female'),
            'assisted_by' => fake()->optional()->name(),
            'ssc_roll' => fake()->numerify('##########'),
            'ssc_registration_no' => fake()->numerify('##########'),
            'ssc_gpa' => fake()->randomFloat(2, 2.0, 5.0),
            'ssc_grade' => fake()->optional()->randomElement(['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'F']),
            'ssc_board' => fake()->optional()->randomElement(['Dhaka', 'Chittagong', 'Rajshahi', 'Comilla', 'Sylhet', 'Barisal', 'Jessore', 'Dinajpur']),
            'ssc_passing_year' => fake()->optional()->numberBetween(2010, 2024),
            'hsc_roll' => fake()->optional()->numerify('##########'),
            'hsc_registration_no' => fake()->optional()->numerify('##########'),
            'hsc_gpa' => fake()->optional()->randomFloat(2, 2.0, 5.0),
            'hsc_grade' => fake()->optional()->randomElement(['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'F']),
            'hsc_board' => fake()->optional()->randomElement(['Dhaka', 'Chittagong', 'Rajshahi', 'Comilla', 'Sylhet', 'Barisal', 'Jessore', 'Dinajpur']),
            'hsc_passing_year' => fake()->optional()->numberBetween(2012, 2024),
            'honors_roll' => fake()->optional()->numerify('##########'),
            'honors_registration_no' => fake()->optional()->numerify('##########'),
            'honors_gpa' => fake()->optional()->randomFloat(2, 2.0, 4.0),
            'honors_grade' => fake()->optional()->randomElement(['First Class', 'Second Class', 'Third Class', 'Pass']),
            'honors_board' => fake()->optional()->word(),
            'honors_passing_year' => fake()->optional()->numberBetween(2016, 2024),
            'honors_institution' => fake()->optional()->company(),
        ];
    }
}
