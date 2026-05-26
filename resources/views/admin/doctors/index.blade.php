<x-admin-layout title="Doctores | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
    ],
]">

    <h1 class="text-2xl font-bold mb-4">Doctores</h1>

    @livewire('admin.datatables.doctor-table')

</x-admin-layout>
