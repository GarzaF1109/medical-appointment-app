<x-admin-layout title="Pacientes | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <h2 class="text-xl font-bold text-gray-800 mb-4">Editar</h2>

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Header Card: Avatar + Name + Buttons --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @php
                        $initials = collect(explode(' ', $patient->user->name))->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');
                    @endphp
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-lg font-bold text-blue-600">{{ $initials }}</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $patient->user->name }}</h3>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Volver
                    </a>
                    <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        <i class="fa-solid fa-check mr-2"></i>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabs Card --}}
        @php
            $hasErrorsAntecedentes = $errors->hasAny(['allergies', 'chronic_conditions', 'surgical_history', 'family_history']);
            $hasErrorsGeneral = $errors->hasAny(['blood_type_id', 'observations']);
            $hasErrorsEmergencia = $errors->hasAny(['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship']);
            $errorTab = $errors->any()
                ? ($hasErrorsAntecedentes ? 'antecedentes' : ($hasErrorsGeneral ? 'general' : ($hasErrorsEmergencia ? 'emergencia' : 'personal')))
                : '';
        @endphp

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <x-tab-container defaultTab="personal" :errorTab="$errorTab">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <x-tab-button name="personal" icon="fa-solid fa-user">
                            Datos personales
                        </x-tab-button>
                        <x-tab-button name="antecedentes" icon="fa-solid fa-file-medical" :hasErrors="$hasErrorsAntecedentes">
                            Antecedentes
                        </x-tab-button>
                        <x-tab-button name="general" icon="fa-solid fa-info-circle" :hasErrors="$hasErrorsGeneral">
                            Información general
                        </x-tab-button>
                        <x-tab-button name="emergencia" icon="fa-solid fa-heart" :hasErrors="$hasErrorsEmergencia">
                            Contacto de emergencia
                        </x-tab-button>
                    </nav>
                </div>

                {{-- Tab 1: Datos personales --}}
                <x-tab-panel name="personal">
                    {{-- Info box --}}
                    <div class="flex items-center justify-between bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-users-gear text-blue-600 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Edición de cuenta de usuario</p>
                                <p class="text-sm text-blue-700">La <span class="font-semibold">información de acceso</span> (Nombre, Email y Contraseña) debe gestionarse desde la cuenta de usuario asociada.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.edit', $patient->user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 whitespace-nowrap">
                            Editar Usuario
                            <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
                        </a>
                    </div>

                    {{-- Read-only user data --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 mt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Teléfono:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $patient->user->phone ?? '-' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Email:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $patient->user->email ?? '-' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Dirección:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $patient->user->address ?? '-' }}</span>
                        </div>
                    </div>
                </x-tab-panel>

                {{-- Tab 2: Antecedentes --}}
                <x-tab-panel name="antecedentes">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="allergies" class="block text-sm font-medium mb-1 @error('allergies') text-red-600 @else text-gray-700 @enderror">Alergias conocidas</label>
                            <textarea name="allergies" id="allergies" rows="4" maxlength="255"
                                class="w-full rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('allergies') border-red-500 text-red-900 @else border-gray-300 @enderror"
                            >{{ old('allergies', $patient->allergies) }}</textarea>
                            @error('allergies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="chronic_conditions" class="block text-sm font-medium mb-1 @error('chronic_conditions') text-red-600 @else text-gray-700 @enderror">Enfermedades crónicas</label>
                            <textarea name="chronic_conditions" id="chronic_conditions" rows="4" maxlength="255"
                                class="w-full rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('chronic_conditions') border-red-500 text-red-900 @else border-gray-300 @enderror"
                            >{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                            @error('chronic_conditions')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="surgical_history" class="block text-sm font-medium mb-1 @error('surgical_history') text-red-600 @else text-gray-700 @enderror">Antecedentes quirúrgicos</label>
                            <textarea name="surgical_history" id="surgical_history" rows="4" maxlength="255"
                                class="w-full rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('surgical_history') border-red-500 text-red-900 @else border-gray-300 @enderror"
                            >{{ old('surgical_history', $patient->surgical_history) }}</textarea>
                            @error('surgical_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="family_history" class="block text-sm font-medium mb-1 @error('family_history') text-red-600 @else text-gray-700 @enderror">Antecedentes familiares</label>
                            <textarea name="family_history" id="family_history" rows="4" maxlength="255"
                                class="w-full rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('family_history') border-red-500 text-red-900 @else border-gray-300 @enderror"
                            >{{ old('family_history', $patient->family_history) }}</textarea>
                            @error('family_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-tab-panel>

                {{-- Tab 3: Información general --}}
                <x-tab-panel name="general">
                    <div>
                        <label for="blood_type_id" class="block text-sm font-medium mb-1 @error('blood_type_id') text-red-600 @else text-gray-700 @enderror">Tipo de Sangre</label>
                        <select name="blood_type_id" id="blood_type_id"
                            class="w-full rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('blood_type_id') border-red-500 @else border-gray-300 @enderror">
                            <option value="">Selecciona un tipo de sangre</option>
                            @foreach($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}" {{ old('blood_type_id', $patient->blood_type_id) == $bloodType->id ? 'selected' : '' }}>
                                    {{ $bloodType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="observations" class="block text-sm font-medium mb-1 @error('observations') text-red-600 @else text-gray-700 @enderror">Observaciones</label>
                        <textarea name="observations" id="observations" rows="5" maxlength="500"
                            class="w-full rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('observations') border-red-500 text-red-900 @else border-gray-300 @enderror"
                        >{{ old('observations', $patient->observations) }}</textarea>
                        @error('observations')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </x-tab-panel>

                {{-- Tab 4: Contacto de emergencia --}}
                <x-tab-panel name="emergencia">
                    <div class="space-y-4">
                        <div>
                            <label for="emergency_contact_name" class="block text-sm font-medium mb-1 @error('emergency_contact_name') text-red-600 @else text-gray-700 @enderror">Nombre de contacto</label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name" placeholder="Nombre del contacto de emergencia"
                                value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                maxlength="255"
                                class="w-full bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('emergency_contact_name') border-red-500 @else border-gray-300 @enderror">
                            @error('emergency_contact_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact_phone" class="block text-sm font-medium mb-1 @error('emergency_contact_phone') text-red-600 @else text-gray-700 @enderror">Teléfono de contacto</label>
                            <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" placeholder="Teléfono del contacto"
                                value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                maxlength="20"
                                class="w-full bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('emergency_contact_phone') border-red-500 @else border-gray-300 @enderror">
                            @error('emergency_contact_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="emergency_contact_relationship" class="block text-sm font-medium mb-1 @error('emergency_contact_relationship') text-red-600 @else text-gray-700 @enderror">Relación con el contacto</label>
                            <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship" placeholder="Ej. Padre, Madre, Hermano"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                                maxlength="255"
                                class="w-full bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('emergency_contact_relationship') border-red-500 @else border-gray-300 @enderror">
                            @error('emergency_contact_relationship')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-tab-panel>
            </x-tab-container>
        </div>
    </form>

</x-admin-layout>
