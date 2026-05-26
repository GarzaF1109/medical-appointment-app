<x-admin-layout title="Doctores | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <h2 class="text-xl font-bold text-gray-800 mb-4">Editar</h2>

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Header: Avatar + Name + Buttons --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                @php
                    $initials = collect(explode(' ', $doctor->user->name))->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');
                @endphp
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-lg font-bold text-blue-600">{{ $initials }}</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $doctor->user->name }}</h3>
                    <p class="text-sm text-gray-500">Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.doctors.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Volver
                </a>
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    <i class="fa-solid fa-check mr-2"></i>
                    Guardar cambios
                </button>
            </div>
        </div>

        <x-card>
            <div class="space-y-4">
                <div>
                    <label for="speciality_id" class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                    <select name="speciality_id" id="speciality_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('speciality_id') border-red-500 @enderror">
                        <option value="">Selecciona una especialidad</option>
                        @foreach($specialities as $speciality)
                            <option value="{{ $speciality->id }}" {{ old('speciality_id', $doctor->speciality_id) == $speciality->id ? 'selected' : '' }}>{{ $speciality->name }}</option>
                        @endforeach
                    </select>
                    @error('speciality_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="medical_license_number" class="block text-sm font-medium text-gray-700 mb-1">Número de licencia médica</label>
                    <input type="text" name="medical_license_number" id="medical_license_number"
                        placeholder="Ej: L-20260526-8845A"
                        value="{{ old('medical_license_number', $doctor->medical_license_number) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('medical_license_number') border-red-500 @enderror">
                    @error('medical_license_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Formato: L-YYYYMMDD-####A</p>
                    @enderror
                </div>

                <div x-data="{ count: '{{ old('biography', $doctor->biography) }}'.length }">
                    <x-textarea
                        label="Biografía"
                        name="biography"
                        placeholder="Escribe una breve biografía del doctor"
                        rows="5"
                        maxlength="1000"
                        x-on:input="count = $event.target.value.length"
                    >{{ old('biography', $doctor->biography) }}</x-textarea>
                    <div class="flex justify-between mt-1">
                        @error('biography')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @else
                            <span></span>
                        @enderror
                        <span class="text-sm text-gray-500" :class="count > 1000 && 'text-red-600'" x-text="count + ' / 1000'"></span>
                    </div>
                </div>
            </div>
        </x-card>
    </form>

</x-admin-layout>
