<?php

use App\Models\Department;
use App\Models\Program;
use App\Models\Semester;

use function Pest\Laravel\getJson;

test('returns dropdown data with correct structure', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful()
        ->assertJsonStructure([
            'semesters' => [
                '*' => ['id', 'name', 'year', 'start_date', 'end_date', 'is_active'],
            ],
            'departments' => [
                '*' => ['id', 'code', 'name', 'description', 'is_active'],
            ],
            'programs' => [
                '*' => ['id', 'department_id', 'name', 'code', 'major', 'degree_type', 'duration_years', 'total_credits', 'is_active'],
            ],
        ]);
});

test('returns only active semesters', function () {
    $activeSemester = Semester::factory()->active()->create();
    $inactiveSemester = Semester::factory()->inactive()->create();

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $semesters = $response->json('semesters');
    expect($semesters)->toHaveCount(1)
        ->and($semesters[0]['id'])->toBe($activeSemester->id);
});

test('returns all departments regardless of active status', function () {
    $activeDepartment = Department::factory()->create(['is_active' => true]);
    $inactiveDepartment = Department::factory()->inactive()->create();

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $departments = $response->json('departments');
    expect($departments)->toHaveCount(2);
});

test('returns all programs regardless of active status', function () {
    $department = Department::factory()->create();
    $activeProgram = Program::factory()->create(['department_id' => $department->id, 'is_active' => true]);
    $inactiveProgram = Program::factory()->inactive()->create(['department_id' => $department->id]);

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $programs = $response->json('programs');
    expect($programs)->toHaveCount(2);
});

test('programs include department_id field', function () {
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $programs = $response->json('programs');
    expect($programs[0])->toHaveKey('department_id')
        ->and($programs[0]['department_id'])->toBe($department->id);
});

test('semesters are ordered by year desc then by name', function () {
    $semester1 = Semester::factory()->active()->create(['year' => 2024, 'name' => 'Fall']);
    $semester2 = Semester::factory()->active()->create(['year' => 2024, 'name' => 'Spring']);
    $semester3 = Semester::factory()->active()->create(['year' => 2025, 'name' => 'Spring']);

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $semesters = $response->json('semesters');
    expect($semesters[0]['id'])->toBe($semester3->id) // 2025 first
        ->and($semesters[1]['id'])->toBe($semester2->id) // 2024 Spring before Fall
        ->and($semesters[2]['id'])->toBe($semester1->id);
});

test('departments are ordered by name', function () {
    $dept1 = Department::factory()->create(['name' => 'Zebra Department']);
    $dept2 = Department::factory()->create(['name' => 'Alpha Department']);

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $departments = $response->json('departments');
    expect($departments[0]['id'])->toBe($dept2->id)
        ->and($departments[1]['id'])->toBe($dept1->id);
});

test('programs are ordered by name', function () {
    $department = Department::factory()->create();
    $program1 = Program::factory()->create(['department_id' => $department->id, 'name' => 'Zebra Program']);
    $program2 = Program::factory()->create(['department_id' => $department->id, 'name' => 'Alpha Program']);

    $response = getJson('/api/public/dropdowns');

    $response->assertSuccessful();
    $programs = $response->json('programs');
    expect($programs[0]['id'])->toBe($program2->id)
        ->and($programs[1]['id'])->toBe($program1->id);
});
