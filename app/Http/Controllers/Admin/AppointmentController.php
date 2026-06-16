<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index');
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'reason' => 'required|string',
        ], [
            'patient_id.required' => 'Debes seleccionar un paciente.',
            'doctor_id.required' => 'Debes seleccionar un doctor.',
            'date.required' => 'La fecha es obligatoria.',
            'date.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'end_time.required' => 'La hora de fin es obligatoria.',
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'reason.required' => 'El motivo de la consulta es obligatorio.',
        ]);

        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = \Carbon\Carbon::parse($request->end_time);
        $duration = $startTime->diffInMinutes($endTime);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $duration,
            'reason' => $request->reason,
            'status' => 1,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita registrada',
            'text' => 'La cita ha sido registrada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita eliminada',
            'text' => 'La cita ha sido eliminada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function consultation(Appointment $appointment)
    {
        $appointment->load('patient.user', 'doctor.user', 'consultation');
        return view('admin.appointments.consultation', compact('appointment'));
    }
}
