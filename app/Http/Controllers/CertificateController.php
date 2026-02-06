<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates (admin only).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Certificate::query()->orderBy('created_at', 'desc');

        if ($request->has('per_page')) {
            $perPage = (int) $request->input('per_page', 15);
            $certificates = $query->paginate($perPage);

            return response()->json($certificates);
        }

        $certificates = $query->get();

        return response()->json($certificates);
    }

    /**
     * Store a newly created certificate (admin only).
     */
    public function store(StoreCertificateRequest $request): JsonResponse
    {
        $certificate = Certificate::create($request->validated());

        return response()->json([
            'message' => 'Certificate created successfully',
            'certificate' => $certificate,
        ], 201);
    }

    /**
     * Display the specified certificate (admin only).
     */
    public function show(Certificate $certificate): JsonResponse
    {
        return response()->json($certificate);
    }

    /**
     * Update the specified certificate (admin only).
     */
    public function update(UpdateCertificateRequest $request, Certificate $certificate): JsonResponse
    {
        $certificate->update($request->validated());

        return response()->json([
            'message' => 'Certificate updated successfully',
            'certificate' => $certificate,
        ]);
    }

    /**
     * Remove the specified certificate (admin only).
     */
    public function destroy(Certificate $certificate): JsonResponse
    {
        $certificate->delete();

        return response()->json([
            'message' => 'Certificate deleted successfully',
        ]);
    }

    /**
     * Verify a certificate by roll, registration number, and passing year (public).
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'roll' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'passing_year' => ['required', 'integer'],
        ]);

        $certificate = Certificate::where('roll', $request->roll)
            ->where('registration_number', $request->registration_number)
            ->where('passing_year', $request->passing_year)
            ->first();

        if (! $certificate) {
            return response()->json([
                'message' => 'Certificate not found',
            ], 404);
        }

        return response()->json([
            'name' => $certificate->name,
            'father_name' => $certificate->father_name,
            'mother_name' => $certificate->mother_name,
            'roll' => $certificate->roll,
            'registration_number' => $certificate->registration_number,
            'program' => $certificate->program,
            'batch' => $certificate->batch,
            'session' => $certificate->session,
            'cgpa_or_class' => $certificate->cgpa_or_class,
            'passing_year' => $certificate->passing_year,
        ]);
    }
}
