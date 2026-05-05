<x-admin-layout title="Pacientes | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
    ],
]">
    <h1 class="text-2xl font-bold mb-4">Pacientes</h1>

    @livewire('admin.datatables.patient-table')

</x-admin-layout>
