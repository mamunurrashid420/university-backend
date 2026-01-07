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
        ->and((float) $admission->ssc_gpa)->toEqual(4.5);
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
        'ssc_board' => 'Dhaka',
        'hsc_roll' => '1234567891',
        'hsc_registration_no' => '9876543211',
        'hsc_gpa' => 4.8,
        'honors_gpa' => 3.5,
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertSuccessful();
    $admission = Admission::first();
    expect($admission->hear_about_us)->toBe('Website')
        ->and($admission->father_name)->toBe('Father Name')
        ->and((float) $admission->hsc_gpa)->toEqual(4.8)
        ->and((float) $admission->honors_gpa)->toEqual(3.5);
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

test('can submit admission form with seeded department and program data', function () {
    // Seed the database with actual departments and programs
    $this->seed([
        \Database\Seeders\DepartmentSeeder::class,
        \Database\Seeders\ProgramSeeder::class,
    ]);

    // Get actual seeded data
    $semester = Semester::factory()->active()->create();
    $department = Department::where('code', 'CSE')->first();
    $program = Program::where('code', 'CSE')->first();

    expect($department)->not->toBeNull()
        ->and($program)->not->toBeNull()
        ->and($program->department_id)->toBe($department->id);

    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'Test Student',
        'phone_number' => '1234567890',
        'email' => 'test@example.com',
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
    expect($admission->department_id)->toBe($department->id)
        ->and($admission->program_id)->toBe($program->id)
        ->and($admission->full_name)->toBe('Test Student');
});

test('can submit admission form with multiple seeded departments and programs', function () {
    // Seed the database with actual departments and programs
    $this->seed([
        \Database\Seeders\DepartmentSeeder::class,
        \Database\Seeders\ProgramSeeder::class,
    ]);

    $semester = Semester::factory()->active()->create();

    // Test with different department-program combinations from seeded data
    $testCases = [
        ['dept_code' => 'BBA', 'prog_code' => 'BBA'],
        ['dept_code' => 'FD', 'prog_code' => 'FDT'],
        ['dept_code' => 'AM', 'prog_code' => 'AMT'],
        ['dept_code' => 'CSE', 'prog_code' => 'CSE'],
    ];

    foreach ($testCases as $index => $testCase) {
        $department = Department::where('code', $testCase['dept_code'])->first();
        $program = Program::where('code', $testCase['prog_code'])->first();

        expect($department)->not->toBeNull("Department {$testCase['dept_code']} should exist")
            ->and($program)->not->toBeNull("Program {$testCase['prog_code']} should exist")
            ->and($program->department_id)->toBe($department->id, "Program {$testCase['prog_code']} should belong to department {$testCase['dept_code']}");

        $data = [
            'semester_id' => $semester->id,
            'department_id' => $department->id,
            'program_id' => $program->id,
            'full_name' => "Test Student {$index}",
            'phone_number' => '1234567890',
            'email' => "test{$index}@example.com",
            'ssc_roll' => '1234567890',
            'ssc_registration_no' => '9876543210',
            'ssc_gpa' => 4.5,
        ];

        $response = postJson('/api/admissions', $data);

        $response->assertSuccessful()
            ->assertJson([
                'admission' => [
                    'department_id' => $department->id,
                    'program_id' => $program->id,
                    'full_name' => "Test Student {$index}",
                ],
            ]);
    }

    // Verify all admissions were created
    expect(Admission::count())->toBe(count($testCases));
});

test('accepts string numeric values for GPA fields from frontend', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    // Test with string numeric values (as they would come from frontend)
    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => '4.5', // String instead of float
        'hsc_gpa' => '4.8', // String instead of float
        'honors_gpa' => '3.5', // String instead of float
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertSuccessful();

    $admission = Admission::first();
    expect((float) $admission->ssc_gpa)->toEqual(4.5)
        ->and((float) $admission->hsc_gpa)->toEqual(4.8)
        ->and((float) $admission->honors_gpa)->toEqual(3.5);
});

test('accepts string integer values for passing year fields from frontend', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    // Test with string integer values (as they would come from frontend)
    $data = [
        'semester_id' => $semester->id,
        'department_id' => $department->id,
        'program_id' => $program->id,
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => '4.5',
        'ssc_passing_year' => '2020', // String instead of integer
        'hsc_passing_year' => '2022', // String instead of integer
        'honors_passing_year' => '2024', // String instead of integer
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertSuccessful();

    $admission = Admission::first();
    expect($admission->ssc_passing_year)->toBe(2020)
        ->and($admission->hsc_passing_year)->toBe(2022)
        ->and($admission->honors_passing_year)->toBe(2024);
});

test('accepts string numeric values for ID fields from frontend', function () {
    $semester = Semester::factory()->active()->create();
    $department = Department::factory()->create();
    $program = Program::factory()->create(['department_id' => $department->id]);

    // Test with string ID values (as they would come from frontend)
    $data = [
        'semester_id' => (string) $semester->id, // String instead of integer
        'department_id' => (string) $department->id, // String instead of integer
        'program_id' => (string) $program->id, // String instead of integer
        'full_name' => 'John Doe',
        'phone_number' => '1234567890',
        'email' => 'john@example.com',
        'ssc_roll' => '1234567890',
        'ssc_registration_no' => '9876543210',
        'ssc_gpa' => '4.5',
    ];

    $response = postJson('/api/admissions', $data);

    $response->assertSuccessful()
        ->assertJson([
            'admission' => [
                'semester_id' => $semester->id,
                'department_id' => $department->id,
                'program_id' => $program->id,
            ],
        ]);
});
