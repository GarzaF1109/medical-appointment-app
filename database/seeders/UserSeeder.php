<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('12345678'),
            'id_number' => '123456789',
            'phone' => '999999999',
            'address' => 'Calle 90 293',
        ]);
        $admin->assignRole('Administrador');

        $roles = Role::all();

        User::factory(9)->create()->each(function ($user) use ($roles) {
            $user->assignRole($roles->random());
        });
    }
}
