<?php

use App\Models\Admission;
use App\Models\Department;
use App\Models\Program;
use App\Models\Semester;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

test('can submit admission form with required fields', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertSuccessful()
        ->assertJsonStructure([
            'message',
            'admission' => [
                'id',
                'semester_id',
                'department_id',
                'program_id',
                'full_name',
                'phone_number',
                'email',
            ],
        ]);

    expect(Admission::count())->toBe(1);
    $admission = Admission::first();
    expect($admission->full_name)->toBe('John Doe')
        ->and($admission->email)->toBe('john@example.com')
        ->and($admission->ssc_gpa)->toBe(4.5);
});

test('validates required fields', function () {
    $response = postJson('/api/admissions', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors([
            'semester_id',
            'department_id',
            'program_id',
            'full_name',
            'phone_number',
            'email',
            'ssc_roll',
            'ssc_registration_no',
            'ssc_gpa',
        ]);
});

test('validates program belongs to selected department', function () {
    $semester = Semester::factory()->active()->create();
    $department1 = Department::factory()->create();
    $department2 = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department1->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department2->id, // Different department
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['program_id']);
});

test('validates SSC GPA range', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 6.0, // Invalid: exceeds max
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['ssc_gpa']);
});

test('can submit with optional fields', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'hear_about_us' => 'Website',
        'father_name' => 'Father Name',
        'mother_name' => 'Mother Name',
        'assisted_by' => 'Assistant Name',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
        'ssc_grade' => 'A+',
        'ssc_board' => 'Dhaka',
        'hsc_roll' => '1234567891',
        'hsc_registration_no' => '9876543211',
        'hsc_gpa' => 4.8,
        'honors_roll' => '1234567892',
        'honors_registration_no' => '9876543212',
        'honors_gpa' => 3.5,
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertSuccessful();
    $admission = Admission::first();
    expect($admission->hear_about_us)->toBe('Website')
        ->and($admission->father_name)->toBe('Father Name')
        ->and($admission->hsc_gpa)->toBe(4.8)
        ->and($admission->honors_gpa)->toBe(3.5);
});

test('validates hear_about_us against predefined options', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'hear_about_us' => 'Invalid Option',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['hear_about_us']);
});

test('validates email format', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'invalid-email',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

test('validates HSC GPA range when provided', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
        'hsc_gpa' => 6.0, // Invalid: exceeds max
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['hsc_gpa']);
});

test('validates Honors GPA range when provided', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => 4.5,
        'honors_gpa' => 5.0, // Invalid: exceeds max (4.0)
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['honors_gpa']);
});

test('can retrieve single admission form data', function () {
    $user = User::factory()->create();
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $admission = Admission::factory()->create([
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);

    $response = actingAs($user, 'sanctum')
        ->getJson("/api/admissions/{$admission->id}");

    $response->assertSuccessful()
        ->assertJsonStructure([
            'id',
            'semester_id',
            'department_id',
            'program_id',
            'full_name',
            'phone_number',
            'email',
            'semester' => ['id', 'name', 'year'],
            'department' => ['id', 'name', 'code'],
            'program' => ['id', 'name', 'code'],
        ])
        ->assertJson([
            'id' => $admission->id,
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
});

test('returns 404 for non-existent admission', function () {
    $user = User::factory()->create();

    $response = actingAs($user, 'sanctum')
        ->getJson('/api/admissions/99999');

    $response->assertNotFound();
});

test('requires authentication to retrieve admission', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    $admission = Admission::factory()->create([
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
    ]);

    $response = getJson("/api/admissions/{$admission->id}");

    $response->assertUnauthorized();
});
