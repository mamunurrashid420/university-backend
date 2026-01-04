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
            ['code' => 'THM', 'name' => 'Tourism & Hospitality Management'],
            ['code' => 'ECE', 'name' => 'Electronics & Communication Engineering'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['code' => $dept['code']],
                ['name' => $dept['name'], 'is_active' => true]
            );
        }
    }
}
