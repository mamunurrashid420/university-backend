<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    public function scopeCurrent($query)
    {
        $now = now();

        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }
}
