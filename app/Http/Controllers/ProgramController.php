<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProgramIsActiveRequest;
use App\Models\Program;
use Illuminate\Http\JsonResponse;

class ProgramController extends Controller
{
    public function index(): JsonResponse
    {
        $programs = Program::with('department')
            ->orderBy('name')
            ->get();

        return response()->json($programs);
    }

    public function updateIsActive(UpdateProgramIsActiveRequest $request, Program $program): JsonResponse
    {
        $program->update([
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'message' => 'Program status updated successfully',
            'program' => $program->load('department'),
        ]);
    }
}
