<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create departments
        $departments = [
            ['code' => 'BBA', 'name' => 'BBA'],
            ['code' => 'CSE', 'name' => 'CSE'],
            ['code' => 'FD', 'name' => 'Fashion Design'],
            ['code' => 'AM', 'name' => 'Apparel Manufacturers'],
            ['code' => 'TE', 'name' => 'Textile Engineering'],
            ['code' => 'EE', 'name' => 'Electrical Engineering'],
            ['code' => 'SCM', 'name' => 'Supply Chain Management'],
            ['code' => 'IE', 'name' => 'Industrial Engineering'],
            ['code' => 'GD', 'name' => 'Graphics Design'],
            ['code' => 'DM', 'name' => 'Digital Marketing'],
            ['code' => 'AHCC', 'name' => 'Air Hostess & Cabin Crew'],
            ['code' => 'CAD', 'name' => 'Auto CAD'],
            ['code' => 'QMS', 'name' => 'Quality Management'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['code' => $dept['code']],
                ['name' => $dept['name'], 'is_active' => true]
            );
        }
    }
}
