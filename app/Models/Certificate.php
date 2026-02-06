<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\CertificateFactory> */
    use HasFactory;

    protected $fillable = [
        'roll',
        'registration_number',
        'passing_year',
        'name',
        'father_name',
        'mother_name',
        'program',
        'batch',
        'session',
        'cgpa_or_class',
    ];

    protected function casts(): array
    {
        return [
            'passing_year' => 'integer',
        ];
    }
}
