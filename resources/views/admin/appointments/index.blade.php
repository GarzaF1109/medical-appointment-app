<x-admin-layout title="Citas | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
    ],
]">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Citas</h1>
        <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-lg hover:bg-indigo-600">
            <i class="fa-solid fa-plus mr-2"></i>
            Nuevo
        </a>
    </div>

    @livewire('admin.datatables.appointment-table')

</x-admin-layout>
