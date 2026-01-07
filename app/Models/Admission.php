<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admission extends Model
{
    /** @use HasFactory<\Database\Factories\AdmissionFactory> */
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'department_id',
        'program_id',
        'full_name',
        'phone_number',
        'email',
        'hear_about_us',
        'father_name',
        'mother_name',
        'assisted_by',
        'ssc_roll',
        'ssc_registration_no',
        'ssc_gpa',
        'ssc_board',
        'ssc_passing_year',
        'hsc_roll',
        'hsc_registration_no',
        'hsc_gpa',
        'hsc_board',
        'hsc_passing_year',
        'honors_gpa',
        'honors_passing_year',
        'honors_institution',
    ];

    protected function casts(): array
    {
        return [
            'ssc_gpa' => 'decimal:2',
            'hsc_gpa' => 'decimal:2',
            'honors_gpa' => 'decimal:2',
            'ssc_passing_year' => 'integer',
            'hsc_passing_year' => 'integer',
            'honors_passing_year' => 'integer',
        ];
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
