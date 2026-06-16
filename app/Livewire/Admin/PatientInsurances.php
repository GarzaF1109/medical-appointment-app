<?php

namespace App\Livewire\Admin;

use App\Models\Insurance;
use App\Models\Patient;
use Livewire\Component;

class PatientInsurances extends Component
{
    public Patient $patient;

    public ?int $selectedInsurance = null;
    public string $memberNumber = '';

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function addInsurance()
    {
        $this->validate([
            'selectedInsurance' => 'required|exists:insurances,id',
            'memberNumber' => 'nullable|string|max:50',
        ], [
            'selectedInsurance.required' => 'Debes seleccionar un convenio de seguro.',
            'selectedInsurance.exists' => 'El convenio seleccionado no existe.',
        ]);

        if ($this->patient->insurances()->where('insurance_id', $this->selectedInsurance)->exists()) {
            $this->addError('selectedInsurance', 'Este paciente ya tiene asignado este convenio.');
            return;
        }

        $this->patient->insurances()->attach($this->selectedInsurance, [
            'member_number' => trim($this->memberNumber) ?: null,
        ]);

        $this->selectedInsurance = null;
        $this->memberNumber = '';
        $this->patient->load('insurances');

        $this->dispatch('insurance-added');
    }

    public function removeInsurance(int $insuranceId)
    {
        $this->patient->insurances()->detach($insuranceId);
        $this->patient->load('insurances');
    }

    public function render()
    {
        $availableInsurances = Insurance::where('status', 1)
            ->whereNotIn('id', $this->patient->insurances->pluck('id'))
            ->orderBy('name')
            ->get();

        return view('livewire.admin.patient-insurances', compact('availableInsurances'));
    }
}
