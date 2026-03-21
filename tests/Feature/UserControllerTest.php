<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'Administrador']);
    Role::create(['name' => 'Super administrador']);
    Role::create(['name' => 'Doctor']);
});

test('un usuario no puede eliminarse a sí mismo', function () {
    $user = User::factory()->create();
    $user->assignRole('Administrador');

    $response = $this->actingAs($user)->delete(route('admin.users.destroy', $user));

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

test('no se puede eliminar al Super Administrador', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $superAdmin = User::factory()->create();
    $superAdmin->assignRole('Super administrador');

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $superAdmin));

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', ['id' => $superAdmin->id]);
});

test('se puede eliminar un usuario normal', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $doctor = User::factory()->create();
    $doctor->assignRole('Doctor');

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $doctor));

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseMissing('users', ['id' => $doctor->id]);
});

test('store requiere validaciones estrictas', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => '',
        'email' => '',
        'password' => '',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
});

test('store valida que el nombre solo contenga letras', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $role = Role::findByName('Doctor');

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'User123',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
        'role' => $role->id,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('store valida que las contraseñas coincidan', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $role = Role::findByName('Doctor');

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Juan Pérez',
        'email' => 'juan@example.com',
        'password' => '12345678',
        'password_confirmation' => 'diferente',
        'role' => $role->id,
    ]);

    $response->assertSessionHasErrors(['password']);
});
