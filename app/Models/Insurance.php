<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'policy_number',
        'coverage_type',
        'coverage_percentage',
        'start_date',
        'end_date',
        'phone',
        'email',
        'description',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'coverage_percentage' => 'decimal:2',
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class)->withPivot('member_number')->withTimestamps();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            1 => 'Activo',
            0 => 'Inactivo',
            default => 'Desconocido',
        };
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 1 && $this->end_date->isFuture();
    }
}
