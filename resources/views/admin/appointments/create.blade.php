<x-admin-layout title="Crear Cita | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <h1 class="text-2xl font-bold mb-4">Nuevo</h1>

    @livewire('admin.appointment-create')

</x-admin-layout>
