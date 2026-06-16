<x-admin-layout title="Seguros | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Seguros',
    ],
]">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Convenios de Seguro</h1>
        <a href="{{ route('admin.insurances.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-lg hover:bg-indigo-600">
            <i class="fa-solid fa-plus mr-2"></i>
            Nuevo
        </a>
    </div>

    @livewire('admin.datatables.insurance-table')

</x-admin-layout>
