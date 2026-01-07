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
            ['code' => 'TE'],
            ['name' => 'Textile Engineering', 'is_active' => true]
        );

        $eeDept = Department::firstOrCreate(
            ['code' => 'EE'],
            ['name' => 'Electrical Engineering', 'is_active' => true]
        );

        $scmDept = Department::firstOrCreate(
            ['code' => 'SCM'],
            ['name' => 'Supply Chain Management', 'is_active' => true]
        );

        $ieDept = Department::firstOrCreate(
            ['code' => 'IE'],
            ['name' => 'Industrial Engineering', 'is_active' => true]
        );

        $gdDept = Department::firstOrCreate(
            ['code' => 'GD'],
            ['name' => 'Graphics Design', 'is_active' => true]
        );

        $dmDept = Department::firstOrCreate(
            ['code' => 'DM'],
            ['name' => 'Digital Marketing', 'is_active' => true]
        );

        $ahccDept = Department::firstOrCreate(
            ['code' => 'AHCC'],
            ['name' => 'Air Hostess & Cabin Crew', 'is_active' => true]
        );

        $cadDept = Department::firstOrCreate(
            ['code' => 'CAD'],
            ['name' => 'Auto CAD', 'is_active' => true]
        );

        $qmsDept = Department::firstOrCreate(
            ['code' => 'QMS'],
            ['name' => 'Quality Management', 'is_active' => true]
        );

        // Undergraduate Programs
        Program::updateOrCreate(
            ['code' => 'AMT'],
            [
                'department_id' => $amtDept->id,
                'name' => 'BSc in Apparel Manufacturing and Technology',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 160,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'FDT'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'BSc in Fashion Design and Technology',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 160,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CSE'],
            [
                'department_id' => $cseDept->id,
                'name' => 'BSc in Computer Science and Engineering',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 138,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'BBA'],
            [
                'department_id' => $bbaDept->id,
                'name' => 'Bachelor of Business Administration',
                'degree_type' => 'bachelor',
                'duration_years' => 4,
                'total_credits' => 126,
                'is_active' => true,
            ]
        );

        // Graduate Programs
        Program::updateOrCreate(
            ['code' => 'MBA-FDT'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'MBA in Fashion Design and Technology',
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
            ['code' => 'EX-MBA-AM'],
            [
                'department_id' => $amtDept->id,
                'name' => 'Ex-MBA in Apparel Merchandising',
                'degree_type' => 'master',
                'duration_years' => 1,
                'total_credits' => 36,
                'is_active' => true,
            ]
        );

        // Diploma Programs (1 year)
        Program::updateOrCreate(
            ['code' => 'DFD'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'Diploma in Fashion Design',
                'degree_type' => 'diploma',
                'duration_years' => 1,
                'total_credits' => 36,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'DAM'],
            [
                'department_id' => $amtDept->id,
                'name' => 'Diploma in Apparel Merchandising',
                'degree_type' => 'diploma',
                'duration_years' => 1,
                'total_credits' => 36,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'DSCM'],
            [
                'department_id' => $scmDept->id,
                'name' => 'Diploma in Supply Chain Management',
                'degree_type' => 'diploma',
                'duration_years' => 1,
                'total_credits' => 36,
                'is_active' => true,
            ]
        );

        // Diploma Programs (4 years - BTEB)
        Program::updateOrCreate(
            ['code' => 'DCST'],
            [
                'department_id' => $cseDept->id,
                'name' => 'Diploma in Computer Science and Technology',
                'degree_type' => 'diploma',
                'duration_years' => 4,
                'total_credits' => 120,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'DTE'],
            [
                'department_id' => $textileDept->id,
                'name' => 'Diploma in Textile Engineering',
                'degree_type' => 'diploma',
                'duration_years' => 4,
                'total_credits' => 120,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'DEE'],
            [
                'department_id' => $eeDept->id,
                'name' => 'Diploma in Electrical Engineering',
                'degree_type' => 'diploma',
                'duration_years' => 4,
                'total_credits' => 120,
                'is_active' => true,
            ]
        );

        // Certificate Programs
        Program::updateOrCreate(
            ['code' => 'CERT-AM-6M'],
            [
                'department_id' => $amtDept->id,
                'name' => 'Certificate in Apparel Merchandising',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-FD-6M'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'Certificate in Fashion Design',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-IE-6M'],
            [
                'department_id' => $ieDept->id,
                'name' => 'Certificate in Industrial Engineering and Work Study',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-PCAD-3M'],
            [
                'department_id' => $cadDept->id,
                'name' => 'Certificate in Pattern CAD (3 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-PCAD-6M'],
            [
                'department_id' => $cadDept->id,
                'name' => 'Certificate in Pattern CAD (6 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-P3D-3M'],
            [
                'department_id' => $cadDept->id,
                'name' => 'Certificate in Pattern 3D Design',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-DM-3M'],
            [
                'department_id' => $dmDept->id,
                'name' => 'Certificate in Digital Marketing',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-AHCC-3M'],
            [
                'department_id' => $ahccDept->id,
                'name' => 'Certificate in Air-Hostess & Cabin-Crew (3 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-AHCC-6M'],
            [
                'department_id' => $ahccDept->id,
                'name' => 'Certificate in Air-Hostess & Cabin-Crew (6 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-AUTOCAD-3M'],
            [
                'department_id' => $cadDept->id,
                'name' => 'Certificate in Auto CAD 2D & 3D (3 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-AUTOCAD-6M'],
            [
                'department_id' => $cadDept->id,
                'name' => 'Certificate in Auto CAD 2D & 3D (6 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-GD-3M'],
            [
                'department_id' => $gdDept->id,
                'name' => 'Certificate in Graphics Design (3 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-GD-6M'],
            [
                'department_id' => $gdDept->id,
                'name' => 'Certificate in Graphics Design (6 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.5,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-BB-3M'],
            [
                'department_id' => $fashionDept->id,
                'name' => 'Certificate in Block & Batiks',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-SCM-4M'],
            [
                'department_id' => $scmDept->id,
                'name' => 'Certificate in Supply Chain Management',
                'degree_type' => 'certificate',
                'duration_years' => 0.33,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-SMO-1M'],
            [
                'department_id' => $amtDept->id,
                'name' => 'Certificate in Sewing Machine Operation (1 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.083,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-SMO-2M'],
            [
                'department_id' => $amtDept->id,
                'name' => 'Certificate in Sewing Machine Operation (2 Month)',
                'degree_type' => 'certificate',
                'duration_years' => 0.167,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );

        Program::updateOrCreate(
            ['code' => 'CERT-QMS-3M'],
            [
                'department_id' => $qmsDept->id,
                'name' => 'Certificate in Quality Management System',
                'degree_type' => 'certificate',
                'duration_years' => 0.25,
                'total_credits' => 0,
                'is_active' => true,
            ]
        );
    }
}
