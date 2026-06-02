<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\BloodType;
use App\Models\Patient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        try {
            $patient->load('user', 'bloodType');
            $bloodTypes = BloodType::all();

            return view('admin.patients.edit', compact('patient', 'bloodTypes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar el formulario de edición del paciente: ' . $e->getMessage());

            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo cargar la información del paciente. Inténtalo de nuevo.',
            ]);

            return redirect()->route('admin.patients.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        try {
            $patient->update($request->validated());

            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Paciente actualizado',
                'text' => 'El paciente ha sido actualizado correctamente.',
            ]);

            return redirect()->route('admin.patients.edit', $patient);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el paciente #' . $patient->id . ': ' . $e->getMessage());

            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error inesperado al actualizar el paciente. Inténtalo de nuevo.',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();

            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Paciente eliminado',
                'text' => 'El paciente ha sido eliminado correctamente.',
            ]);

            return redirect()->route('admin.patients.index');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el paciente #' . $patient->id . ': ' . $e->getMessage());

            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el paciente. Inténtalo de nuevo.',
            ]);

            return redirect()->route('admin.patients.index');
        }
    }
}
