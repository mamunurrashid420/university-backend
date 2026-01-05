<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Semester::orderBy('year', 'desc')
            ->orderByRaw("CASE name WHEN 'Spring' THEN 1 WHEN 'Summer' THEN 2 WHEN 'Fall' THEN 3 END");

        if ($request->has('per_page')) {
            $perPage = (int) $request->input('per_page', 15);
            $semesters = $query->paginate($perPage);

            return response()->json($semesters);
        }

        $semesters = $query->get();

        return response()->json($semesters);
    }

    public function store(StoreSemesterRequest $request): JsonResponse
    {
        $semester = Semester::create([
            'name' => $request->name,
            'year' => $request->year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'message' => 'Semester created successfully',
            'semester' => $semester,
        ], 201);
    }

    public function show(Semester $semester): JsonResponse
    {
        return response()->json($semester);
    }

    public function update(UpdateSemesterRequest $request, Semester $semester): JsonResponse
    {
        $semester->update($request->validated());

        return response()->json([
            'message' => 'Semester updated successfully',
            'semester' => $semester->fresh(),
        ]);
    }

    public function destroy(Semester $semester): JsonResponse
    {
        $semester->delete();

        return response()->json([
            'message' => 'Semester deleted successfully',
        ]);
    }
}
