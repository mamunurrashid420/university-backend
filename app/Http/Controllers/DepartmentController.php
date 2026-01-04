<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDepartmentIsActiveRequest;
use App\Models\Department;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        $departments = Department::orderBy('name')
            ->get();

        return response()->json($departments);
    }

    public function updateIsActive(UpdateDepartmentIsActiveRequest $request, Department $department): JsonResponse
    {
        $department->update([
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'message' => 'Department status updated successfully',
            'department' => $department,
        ]);
    }
}
