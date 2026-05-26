<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = User::role('Doctor')->get();

        foreach ($doctors as $user) {
            Doctor::firstOrCreate(
                ['user_id' => $user->id],
            );
        }
    }
}
