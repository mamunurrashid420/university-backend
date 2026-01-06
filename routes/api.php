<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SemesterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public routes
Route::get('/public/dropdowns', [PublicController::class, 'getDropdownData']);
Route::post('/admissions', [AdmissionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/tokens/create', [AuthController::class, 'createToken']);
    Route::get('/tokens', [AuthController::class, 'tokens']);
    Route::delete('/tokens/{id}', [AuthController::class, 'revokeToken']);

    Route::get('/programs', [ProgramController::class, 'index']);
    Route::patch('/programs/{program}/is-active', [ProgramController::class, 'updateIsActive']);

    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::patch('/departments/{department}/is-active', [DepartmentController::class, 'updateIsActive']);

    Route::get('/courses', [CourseController::class, 'index']);
    Route::patch('/courses/{course}/is-active', [CourseController::class, 'updateIsActive']);

    Route::apiResource('semesters', SemesterController::class);

    Route::get('/admissions', [AdmissionController::class, 'index']);
    Route::get('/admissions/{admission}', [AdmissionController::class, 'show']);
});
