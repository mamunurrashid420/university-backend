<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create departments
        $amtDept = Department::firstOrCreate(
            ['code' => 'AM'],
            ['name' => 'Apparel Manufacturers', 'is_active' => true]
        );

        $fashionDept = Department::firstOrCreate(
            ['code' => 'FD'],
            ['name' => 'Fashion Design', 'is_active' => true]
        );

        $cseDept = Department::firstOrCreate(
            ['code' => 'CSE'],
            ['name' => 'CSE', 'is_active' => true]
        );

        $bbaDept = Department::firstOrCreate(
            ['code' => 'BBA'],
            ['name' => 'BBA', 'is_active' => true]
        );

        $textileDept = Department::firstOrCreate(
            ['code' => 'TM'],
            ['name' => 'Textile Management', 'is_active' => true]
        );

        // Undergraduate Programs
        Program::updateOrCreate(
            ['code' => 'AMT'],
            [
                'department_id' => $amtDept->id,
                'name' => 'BSc (Hons) in Apparel Manufacturing and Technology',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 120,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'FDT'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'BSc (Hons) in Fashion Design and Technology',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 120,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CSE'],
            [
                'department_id' => $cseDept->id,
                'name' => 'BSc in Computer Science & Engineering',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 120,
                'is_active' => true,
            ]
        );

        // BBA with majors
        $bbaMajors = ['Accounting', 'Finance', 'Management', 'Marketing'];

        foreach ($bbaMajors as $major) {
            $code = 'BBA-'.strtoupper(substr($major, 0, 3));
            Program::updateOrCreate(
                ['code' => $code],
                [
                    'department_id' => $bbaDept->id,
                    'name' => 'Bachelor of Business Administration',
                    'major' => $major,
                    'degree_type' => 'bachelor',
                    'duration_years' => 4,
                    'total_credits' => 120,
                    'is_active' => true,
                ]
            );
        }

        // Graduate Programs
        Program::updateOrCreate(
            ['code' => 'MBA-FD'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'MBA in Fashion Design',
                'degree_type' => 'master',
                'duration_years' => 2,
                'total_credits' => 60,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'MBA-AM'],
            [
                'department_id' => $amtDept->id,
                'name' => 'MBA in Apparel Merchandising',
                'degree_type' => 'master',
                'duration_years' => 2,
                'total_credits' => 60,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'MBA-TM'],
            [
                'department_id' => $textileDept->id,
                'name' => 'MBA In Textile Management',
                'degree_type' => 'master',
                'duration_years' => 2,
                'total_credits' => 60,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'MSC-CE'],
            [
                'department_id' => $cseDept->id,
                'name' => 'MSC In Computer Engineering',
                'degree_type' => 'master',
                'duration_years' => 2,
                'total_credits' => 60,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'MBA-BA'],
            [
                'department_id' => $bbaDept->id,
                'name' => 'MBA in Business Administration',
                'degree_type' => 'master',
                'duration_years' => 2,
                'total_credits' => 60,
                'is_active' => true,
            ]
        );
    }
}
