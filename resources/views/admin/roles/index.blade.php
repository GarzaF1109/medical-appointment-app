<x-admin-layout title="Roles" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Roles', 'route' => route('admin.roles.index')],
]">
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.roles.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo Rol
        </a>
    </div>

    @livewire('admin.datatables.role-table')
</x-admin-layout>