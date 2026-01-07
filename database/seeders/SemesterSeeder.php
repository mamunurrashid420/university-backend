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
        Semester::updateOrCreate(
            [
                'name' => 'Spring',
                'year' => 2026,
            ],
            [
                'is_active' => true,
            ]
        );
    }
}
