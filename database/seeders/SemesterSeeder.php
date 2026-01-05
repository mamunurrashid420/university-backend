<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = (int) date('Y');
        $years = range($currentYear - 2, $currentYear + 2);
        $semesterNames = ['Spring', 'Summer', 'Fall'];

        foreach ($years as $year) {
            foreach ($semesterNames as $name) {
                Semester::updateOrCreate(
                    [
                        'name' => $name,
                        'year' => $year,
                    ],
                    [
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
