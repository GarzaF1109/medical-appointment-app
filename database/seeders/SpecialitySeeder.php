<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    public function run(): void
    {
        $specialities = [
            'Cardiología',
            'Pediatría',
            'Dermatología',
            'Neurología',
            'Ginecología',
            'Oftalmología',
            'Traumatología',
            'Psiquiatría',
            'Medicina General',
            'Endocrinología',
        ];

        foreach ($specialities as $speciality) {
            \App\Models\Speciality::firstOrCreate(['name' => $speciality]);
        }
    }
}
