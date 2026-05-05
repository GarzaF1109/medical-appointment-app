<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'id_number' => 'nullable|string|max:255',
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'address' => 'nullable|string|max:255',
            'role' => 'required|exists:roles,id',
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $role = Role::findById($request->role);
        $user->assignRole($role);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado',
            'text' => 'El usuario ha sido creado exitosamente'
        ]);

        //Si el usuario creado es un paciente, envía al módulo pacientes
        if ($user->hasRole('Paciente')) {
            $patient = Patient::create(['user_id' => $user->id]);

            return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully.');
        }

        return redirect(route('admin.users.index'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'id_number' => 'nullable|string|max:255',
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'address' => 'nullable|string|max:255',
            'role' => 'required|exists:roles,id',
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        $role = Role::findById($request->role);
        $user->syncRoles($role);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado correctamente',
            'text' => 'El usuario ha sido actualizado correctamente'
        ]);

        return redirect(route('admin.users.edit', $user));
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes eliminarte a ti mismo'
            ]);

            return redirect(route('admin.users.index'));
        }

        if ($user->hasRole('Super administrador')) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes eliminar al Super Administrador'
            ]);

            return redirect(route('admin.users.index'));
        }

        $user->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado correctamente',
            'text' => 'El usuario ha sido eliminado correctamente'
        ]);

        return redirect(route('admin.users.index'));
    }
}
