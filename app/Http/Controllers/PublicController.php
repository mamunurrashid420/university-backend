<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use App\Models\Semester;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    public function getDropdownData(): JsonResponse
    {
        $semesters = Semester::where('is_active', true)
            ->orderBy('year', 'desc')
            ->orderByRaw("CASE name WHEN 'Spring' THEN 1 WHEN 'Summer' THEN 2 WHEN 'Fall' THEN 3 END")
            ->get();

        $departments = Department::orderBy('name')
            ->get();

        $programs = Program::orderBy('name')
            ->get(['id', 'department_id', 'name', 'code', 'major', 'degree_type', 'duration_years', 'total_credits', 'is_active']);

        return response()->json([
            'semesters' => $semesters,
            'departments' => $departments,
            'programs' => $programs,
        ]);
    }
}
