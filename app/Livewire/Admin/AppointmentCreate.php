<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Speciality;
use Carbon\Carbon;
use Livewire\Component;

class AppointmentCreate extends Component
{
    public string $search_date = '';
    public string $search_time = '';
    public ?int $search_speciality = null;

    public array $availableDoctors = [];
    public bool $searched = false;

    public ?int $selected_doctor_id = null;
    public ?string $selected_time = null;
    public ?string $selected_doctor_name = null;
    public ?string $selected_end_time = null;

    public ?int $patient_id = null;
    public string $reason = '';

    public function searchAvailability()
    {
        $this->validate([
            'search_date' => 'required|date|after_or_equal:today',
            'search_time' => 'required',
        ], [
            'search_date.required' => 'La fecha es obligatoria.',
            'search_date.after_or_equal' => 'La fecha debe ser igual o posterior a hoy.',
            'search_time.required' => 'La hora es obligatoria.',
        ]);

        $query = Doctor::with('user', 'speciality');

        if ($this->search_speciality) {
            $query->where('speciality_id', $this->search_speciality);
        }

        $doctors = $query->get();

        $this->availableDoctors = $doctors->map(function ($doctor) {
            $initials = collect(explode(' ', $doctor->user->name))
                ->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))
                ->take(2)
                ->join('');

            $timeSlots = [];
            if ($this->search_time) {
                $parts = explode('-', $this->search_time);
                if (count($parts) === 2) {
                    $start = Carbon::parse(trim($parts[0]));
                    $end = Carbon::parse(trim($parts[1]));
                } else {
                    $start = Carbon::parse(trim($parts[0]));
                    $end = $start->copy()->addHour();
                }

                $current = $start->copy();
                while ($current->lt($end)) {
                    $timeSlots[] = $current->format('H:i:s');
                    $current->addMinutes(15);
                }
            }

            return [
                'id' => $doctor->id,
                'name' => $doctor->user->name,
                'speciality' => $doctor->speciality->name ?? 'Sin especialidad',
                'initials' => $initials,
                'time_slots' => $timeSlots,
            ];
        })->toArray();

        $this->searched = true;
        $this->selected_doctor_id = null;
        $this->selected_time = null;
        $this->selected_doctor_name = null;
        $this->selected_end_time = null;
    }

    public function selectTimeSlot(int $doctorId, string $time)
    {
        $this->selected_doctor_id = $doctorId;
        $this->selected_time = $time;

        $doctor = collect($this->availableDoctors)->firstWhere('id', $doctorId);
        $this->selected_doctor_name = $doctor ? $doctor['name'] : '';

        $start = Carbon::parse($time);
        $this->selected_end_time = $start->copy()->addMinutes(15)->format('H:i:s');
    }

    public function confirmAppointment()
    {
        $this->validate([
            'search_date' => 'required|date|after_or_equal:today',
            'selected_doctor_id' => 'required',
            'selected_time' => 'required',
            'patient_id' => 'required|exists:patients,id',
            'reason' => 'required|string',
        ], [
            'selected_doctor_id.required' => 'Debes seleccionar un doctor y horario.',
            'selected_time.required' => 'Debes seleccionar un horario disponible.',
            'patient_id.required' => 'Debes seleccionar un paciente.',
            'reason.required' => 'El motivo de la consulta es obligatorio.',
        ]);

        $startTime = Carbon::parse($this->selected_time);
        $endTime = $startTime->copy()->addMinutes(15);

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->selected_doctor_id,
            'date' => $this->search_date,
            'start_time' => $this->selected_time,
            'end_time' => $endTime->format('H:i:s'),
            'duration' => 15,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita registrada',
            'text' => 'La cita ha sido registrada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $specialities = Speciality::all();
        $patients = Patient::with('user')->get();

        return view('livewire.admin.appointment-create', compact('specialities', 'patients'));
    }
}
