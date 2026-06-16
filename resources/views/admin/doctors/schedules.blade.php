<x-admin-layout title="Horarios | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index'),
    ],
    [
        'name' => 'Horarios',
    ],
]">

    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                @php
                    $initials = collect(explode(' ', $doctor->user->name))->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');
                @endphp
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-lg font-bold text-blue-600">{{ $initials }}</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Dr. {{ $doctor->user->name }}</h3>
                    <p class="text-sm text-gray-500">
                        {{ $doctor->speciality->name ?? 'Sin especialidad' }} |
                        Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.doctors.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Volver
            </a>
        </div>
    </div>

    {{-- Contenido de horarios --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fa-solid fa-clock mr-2 text-green-500"></i>
                Horarios del Doctor
            </h2>
        </div>

        <div class="text-center py-12 text-gray-500">
            <i class="fa-solid fa-calendar-days text-5xl mb-4"></i>
            <p class="text-lg font-medium">M&oacute;dulo de horarios pr&oacute;ximamente</p>
            <p class="text-sm mt-2">Este m&oacute;dulo se implementar&aacute; en una fase posterior del desarrollo.</p>
        </div>
    </div>

</x-admin-layout>
