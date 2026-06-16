<x-admin-layout title="Consulta | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],
    [
        'name' => 'Consulta',
    ],
]">

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $appointment->patient->user->name }}</h1>
                <p class="text-sm text-gray-500">DNI: {{ $appointment->patient->user->id_number ?? 'N/A' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.patients.edit', $appointment->patient) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i>
                    Ver Historia
                </a>
                <button type="button" onclick="document.getElementById('previous-consultations-modal').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fa-solid fa-list mr-2"></i>
                    Consultas Anteriores
                </button>
            </div>
        </div>
    </div>

    @livewire('admin.consultation-manager', ['appointment' => $appointment])

    {{-- Modal de Consultas Anteriores --}}
    @php
        $previousConsultations = \App\Models\Consultation::whereHas('appointment', function ($q) use ($appointment) {
            $q->where('patient_id', $appointment->patient_id)
              ->where('id', '!=', $appointment->id);
        })->with('appointment.doctor.user')->latest()->get();
    @endphp

    <div id="previous-consultations-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('previous-consultations-modal').classList.add('hidden')"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[80vh] overflow-y-auto z-10">
                <div class="sticky top-0 bg-white px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">
                        Consultas Anteriores - {{ $appointment->patient->user->name }}
                    </h3>
                    <button onclick="document.getElementById('previous-consultations-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <div class="p-6">
                    @forelse($previousConsultations as $consultation)
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-800">
                                    {{ $consultation->appointment->date->format('d/m/Y') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Dr. {{ $consultation->appointment->doctor->user->name }}
                                </span>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm"><span class="font-medium text-gray-700">Diagn&oacute;stico:</span> {{ $consultation->diagnosis }}</p>
                                <p class="text-sm"><span class="font-medium text-gray-700">Tratamiento:</span> {{ $consultation->treatment }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-folder-open text-4xl mb-3"></i>
                            <p>No hay consultas anteriores registradas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
