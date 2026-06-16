<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'reason',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            1 => 'Pendiente',
            2 => 'Confirmada',
            3 => 'Completada',
            4 => 'Cancelada',
            default => 'Desconocido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            1 => 'yellow',
            2 => 'blue',
            3 => 'green',
            4 => 'red',
            default => 'gray',
        };
    }
}
