<x-admin-layout title="Detalle Seguro | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Seguros',
        'href' => route('admin.insurances.index'),
    ],
    [
        'name' => $insurance->name,
    ],
]">

    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i class="fa-solid fa-shield-halved text-xl text-indigo-600"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $insurance->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $insurance->provider }} &mdash; {{ $insurance->policy_number }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $insurance->status === 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $insurance->status_label }}
                </span>
                <a href="{{ route('admin.insurances.edit', $insurance) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('admin.insurances.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Volver
                </a>
            </div>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid fa-percent text-blue-600"></i>
                </div>
                <span class="text-sm font-medium text-gray-500">Cobertura</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $insurance->coverage_percentage }}%</p>
            <p class="text-sm text-gray-500 mt-1">{{ $insurance->coverage_type }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-check text-green-600"></i>
                </div>
                <span class="text-sm font-medium text-gray-500">Vigencia</span>
            </div>
            <p class="text-lg font-bold text-gray-800">{{ $insurance->start_date->format('d/m/Y') }}</p>
            <p class="text-sm text-gray-500 mt-1">al {{ $insurance->end_date->format('d/m/Y') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-purple-600"></i>
                </div>
                <span class="text-sm font-medium text-gray-500">Pacientes asociados</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $insurance->patients->count() }}</p>
            <p class="text-sm text-gray-500 mt-1">beneficiarios activos</p>
        </div>
    </div>

    {{-- Detalles de contacto --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fa-solid fa-address-book mr-2 text-indigo-500"></i>
            Información de contacto
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Teléfono:</span>
                <span class="text-sm font-semibold text-gray-900">{{ $insurance->phone ?? 'No registrado' }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Email:</span>
                <span class="text-sm font-semibold text-gray-900">{{ $insurance->email ?? 'No registrado' }}</span>
            </div>
        </div>
        @if($insurance->description)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <span class="text-sm text-gray-500">Descripción:</span>
                <p class="text-sm text-gray-800 mt-1">{{ $insurance->description }}</p>
            </div>
        @endif
    </div>

    {{-- Pacientes asociados (Livewire CRUD) --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        @livewire('admin.insurance-patients', ['insurance' => $insurance])
    </div>

</x-admin-layout>
