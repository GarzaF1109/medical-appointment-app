<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index()
    {
        return view('admin.insurances.index');
    }

    public function create()
    {
        return view('admin.insurances.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => trim($request->name),
            'provider' => trim($request->provider),
            'policy_number' => trim($request->policy_number),
            'phone' => $request->phone ? trim($request->phone) : null,
            'email' => $request->email ? trim($request->email) : null,
            'description' => $request->description ? trim($request->description) : null,
        ]);

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'provider' => 'required|string|min:3|max:255',
            'policy_number' => ['required', 'string', 'min:5', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:insurances,policy_number'],
            'coverage_type' => 'required|string|in:Básica,Intermedia,Completa,Premium,Dental,Oftalmológica,Maternidad',
            'coverage_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'phone' => ['nullable', 'string', 'size:10', 'regex:/^[0-9]+$/'],
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'El nombre del convenio es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'provider.required' => 'La aseguradora es obligatoria.',
            'provider.min' => 'La aseguradora debe tener al menos 3 caracteres.',
            'provider.max' => 'La aseguradora no puede exceder 255 caracteres.',
            'policy_number.required' => 'El número de póliza es obligatorio.',
            'policy_number.min' => 'El número de póliza debe tener al menos 5 caracteres.',
            'policy_number.max' => 'El número de póliza no puede exceder 50 caracteres.',
            'policy_number.regex' => 'El número de póliza solo puede contener letras, números y guiones.',
            'policy_number.unique' => 'Este número de póliza ya se encuentra registrado en el sistema.',
            'coverage_type.required' => 'El tipo de cobertura es obligatorio.',
            'coverage_type.in' => 'El tipo de cobertura seleccionado no es válido.',
            'coverage_percentage.required' => 'El porcentaje de cobertura es obligatorio.',
            'coverage_percentage.numeric' => 'El porcentaje de cobertura debe ser un valor numérico.',
            'coverage_percentage.min' => 'El porcentaje de cobertura no puede ser menor a 0%.',
            'coverage_percentage.max' => 'El porcentaje de cobertura no puede ser mayor a 100%.',
            'start_date.required' => 'La fecha de inicio de vigencia es obligatoria.',
            'start_date.date' => 'La fecha de inicio no tiene un formato válido.',
            'end_date.required' => 'La fecha de fin de vigencia es obligatoria.',
            'end_date.date' => 'La fecha de fin no tiene un formato válido.',
            'end_date.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'phone.size' => 'El teléfono debe tener exactamente 10 dígitos.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'email.email' => 'El correo electrónico ingresado no es válido.',
            'email.max' => 'El correo electrónico no puede exceder 255 caracteres.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
        ]);

        $insurance = Insurance::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Convenio registrado',
            'text' => 'El convenio de seguro ha sido registrado correctamente.',
        ]);

        return redirect()->route('admin.insurances.index');
    }

    public function show(Insurance $insurance)
    {
        $insurance->load('patients.user');
        return view('admin.insurances.show', compact('insurance'));
    }

    public function edit(Insurance $insurance)
    {
        return view('admin.insurances.edit', compact('insurance'));
    }

    public function update(Request $request, Insurance $insurance)
    {
        $request->merge([
            'name' => trim($request->name),
            'provider' => trim($request->provider),
            'policy_number' => trim($request->policy_number),
            'phone' => $request->phone ? trim($request->phone) : null,
            'email' => $request->email ? trim($request->email) : null,
            'description' => $request->description ? trim($request->description) : null,
        ]);

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'provider' => 'required|string|min:3|max:255',
            'policy_number' => ['required', 'string', 'min:5', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:insurances,policy_number,' . $insurance->id],
            'coverage_type' => 'required|string|in:Básica,Intermedia,Completa,Premium,Dental,Oftalmológica,Maternidad',
            'coverage_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'phone' => ['nullable', 'string', 'size:10', 'regex:/^[0-9]+$/'],
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
        ], [
            'name.required' => 'El nombre del convenio es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'provider.required' => 'La aseguradora es obligatoria.',
            'provider.min' => 'La aseguradora debe tener al menos 3 caracteres.',
            'provider.max' => 'La aseguradora no puede exceder 255 caracteres.',
            'policy_number.required' => 'El número de póliza es obligatorio.',
            'policy_number.min' => 'El número de póliza debe tener al menos 5 caracteres.',
            'policy_number.max' => 'El número de póliza no puede exceder 50 caracteres.',
            'policy_number.regex' => 'El número de póliza solo puede contener letras, números y guiones.',
            'policy_number.unique' => 'Este número de póliza ya se encuentra registrado en el sistema.',
            'coverage_type.required' => 'El tipo de cobertura es obligatorio.',
            'coverage_type.in' => 'El tipo de cobertura seleccionado no es válido.',
            'coverage_percentage.required' => 'El porcentaje de cobertura es obligatorio.',
            'coverage_percentage.numeric' => 'El porcentaje de cobertura debe ser un valor numérico.',
            'coverage_percentage.min' => 'El porcentaje de cobertura no puede ser menor a 0%.',
            'coverage_percentage.max' => 'El porcentaje de cobertura no puede ser mayor a 100%.',
            'start_date.required' => 'La fecha de inicio de vigencia es obligatoria.',
            'start_date.date' => 'La fecha de inicio no tiene un formato válido.',
            'end_date.required' => 'La fecha de fin de vigencia es obligatoria.',
            'end_date.date' => 'La fecha de fin no tiene un formato válido.',
            'end_date.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'phone.size' => 'El teléfono debe tener exactamente 10 dígitos.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'email.email' => 'El correo electrónico ingresado no es válido.',
            'email.max' => 'El correo electrónico no puede exceder 255 caracteres.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
        ]);

        $insurance->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Convenio actualizado',
            'text' => 'El convenio de seguro ha sido actualizado correctamente.',
        ]);

        return redirect()->route('admin.insurances.index');
    }

    public function destroy(Insurance $insurance)
    {
        $patientCount = $insurance->patients()->count();

        if ($patientCount > 0) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'No se puede eliminar',
                'text' => "Este convenio tiene {$patientCount} paciente(s) vinculado(s). Debes desvincular todos los pacientes antes de poder eliminarlo.",
            ]);

            return redirect()->route('admin.insurances.show', $insurance);
        }

        $insurance->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Convenio eliminado',
            'text' => 'El convenio de seguro ha sido eliminado correctamente.',
        ]);

        return redirect()->route('admin.insurances.index');
    }
}
