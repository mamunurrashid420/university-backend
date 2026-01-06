<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdmissionRequest;
use App\Models\Admission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Admission::with(['semester', 'department', 'program'])
            ->orderBy('created_at', 'desc');

        if ($request->has('per_page')) {
            $perPage = (int) $request->input('per_page', 15);
            $admissions = $query->paginate($perPage);

            return response()->json($admissions);
        }

        $admissions = $query->get();

        return response()->json($admissions);
    }

    public function store(StoreAdmissionRequest $request): JsonResponse
    {
        $admission = Admission::create($request->validated());

        return response()->json([
            'message' => 'Admission form submitted successfully',
            'admission' => $admission->load(['semester', 'department', 'program']),
        ], 201);
    }

    public function show(Admission $admission): JsonResponse
    {
        return response()->json($admission->load(['semester', 'department', 'program']));
    }
}
