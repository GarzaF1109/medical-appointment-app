<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index');
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user', 'speciality');
        $specialities = Speciality::all();
        return view('admin.doctors.edit', compact('doctor', 'specialities'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'speciality_id' => 'required|exists:specialities,id',
            'medical_license_number' => ['required', 'string', 'max:20', 'regex:/^L-\d{8}-\d{4}[A-Z]$/'],
            'biography' => 'nullable|string|max:1000',
        ], [
            'speciality_id.required' => 'Debes seleccionar una especialidad.',
            'medical_license_number.required' => 'El número de licencia médica es obligatorio.',
            'medical_license_number.regex' => 'El formato de licencia debe ser: L-YYYYMMDD-####A (Ej: L-20260526-8845A)',
            'medical_license_number.max' => 'La licencia no debe exceder 20 caracteres.',
            'biography.max' => 'La biografía no debe exceder 1000 caracteres.',
        ]);

        $doctor->update($request->only([
            'speciality_id',
            'medical_license_number',
            'biography',
        ]));

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Doctor actualizado',
            'text' => 'El doctor ha sido actualizado correctamente',
        ]);

        return redirect()->route('admin.doctors.edit', $doctor);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->removeRole('Doctor');
        $doctor->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Doctor eliminado',
            'text' => 'El registro de doctor y su rol han sido eliminados correctamente',
        ]);

        return redirect()->route('admin.doctors.index');
    }
}
