<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Consultation;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;

    public string $diagnosis = '';
    public string $treatment = '';
    public string $notes = '';

    public array $prescriptions = [];

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;

        if ($appointment->consultation) {
            $this->diagnosis = $appointment->consultation->diagnosis ?? '';
            $this->treatment = $appointment->consultation->treatment ?? '';
            $this->notes = $appointment->consultation->notes ?? '';
            $this->prescriptions = $appointment->consultation->prescriptions ?? [];
        }

        if (empty($this->prescriptions)) {
            $this->addMedication();
        }
    }

    public function addMedication()
    {
        $this->prescriptions[] = [
            'medication' => '',
            'dosage' => '',
            'frequency' => '',
        ];
    }

    public function removeMedication(int $index)
    {
        unset($this->prescriptions[$index]);
        $this->prescriptions = array_values($this->prescriptions);

        if (empty($this->prescriptions)) {
            $this->addMedication();
        }
    }

    public function save()
    {
        $this->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'prescriptions' => 'required|array|min:1',
            'prescriptions.*.medication' => 'required|string',
            'prescriptions.*.dosage' => 'required|string',
            'prescriptions.*.frequency' => 'required|string',
        ], [
            'diagnosis.required' => 'El diagnóstico es obligatorio.',
            'treatment.required' => 'El tratamiento es obligatorio.',
            'prescriptions.*.medication.required' => 'El nombre del medicamento es obligatorio.',
            'prescriptions.*.dosage.required' => 'La dosis es obligatoria.',
            'prescriptions.*.frequency.required' => 'La frecuencia / duración es obligatoria.',
        ]);

        Consultation::updateOrCreate(
            ['appointment_id' => $this->appointment->id],
            [
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
                'notes' => $this->notes,
                'prescriptions' => $this->prescriptions,
            ]
        );

        $this->appointment->update(['status' => 3]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Consulta guardada',
            'text' => 'La consulta ha sido registrada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
