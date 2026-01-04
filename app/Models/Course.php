<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'department_id',
        'code',
        'name',
        'credits',
        'description',
        'is_core',
        'prerequisites',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'credits' => 'integer',
            'is_core' => 'boolean',
            'prerequisites' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
