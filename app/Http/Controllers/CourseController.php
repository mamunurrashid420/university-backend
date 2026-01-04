<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCourseIsActiveRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = Course::with(['program', 'department'])
            ->orderBy('name')
            ->get();

        return response()->json($courses);
    }

    public function updateIsActive(UpdateCourseIsActiveRequest $request, Course $course): JsonResponse
    {
        $course->update([
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'message' => 'Course status updated successfully',
            'course' => $course->load(['program', 'department']),
        ]);
    }
}
