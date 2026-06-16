<?php

namespace App\Livewire\Admin;

use App\Models\Insurance;
use App\Models\Patient;
use Livewire\Component;

class InsurancePatients extends Component
{
    public Insurance $insurance;

    public ?int $selectedPatient = null;
    public string $memberNumber = '';

    public function mount(Insurance $insurance)
    {
        $this->insurance = $insurance;
    }

    public function addPatient()
    {
        $this->validate([
            'selectedPatient' => 'required|exists:patients,id',
            'memberNumber' => 'nullable|string|max:50',
        ], [
            'selectedPatient.required' => 'Debes seleccionar un paciente.',
            'selectedPatient.exists' => 'El paciente seleccionado no existe.',
        ]);

        if ($this->insurance->patients()->where('patient_id', $this->selectedPatient)->exists()) {
            $this->addError('selectedPatient', 'Este paciente ya tiene asignado este convenio.');
            return;
        }

        $this->insurance->patients()->attach($this->selectedPatient, [
            'member_number' => trim($this->memberNumber) ?: null,
        ]);

        $this->selectedPatient = null;
        $this->memberNumber = '';
        $this->insurance->load('patients.user');
    }

    public function removePatient(int $patientId)
    {
        $this->insurance->patients()->detach($patientId);
        $this->insurance->load('patients.user');
    }

    public function render()
    {
        $availablePatients = Patient::with('user')
            ->whereNotIn('id', $this->insurance->patients->pluck('id'))
            ->get();

        return view('livewire.admin.insurance-patients', compact('availablePatients'));
    }
}
