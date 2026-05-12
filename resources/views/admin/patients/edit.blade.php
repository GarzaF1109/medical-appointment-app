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

        {{-- Header: Avatar + Name + Buttons --}}
        <div class="flex items-center justify-between mb-4">
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

        {{-- Tabs --}}
        @php
            $hasErrorsAntecedentes = $errors->hasAny(['allergies', 'chronic_conditions', 'surgical_history', 'family_history']);
            $hasErrorsGeneral = $errors->hasAny(['blood_type_id', 'observations']);
            $hasErrorsEmergencia = $errors->hasAny(['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship']);
        @endphp

        <div x-data="{ activeTab: '{{ $errors->any() ? ($hasErrorsAntecedentes ? 'antecedentes' : ($hasErrorsGeneral ? 'general' : ($hasErrorsEmergencia ? 'emergencia' : 'personal'))) : 'personal' }}' }">
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button type="button" @click="activeTab = 'personal'"
                        :class="activeTab === 'personal' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="flex items-center whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        <i class="fa-solid fa-user mr-2"></i>
                        Datos personales
                    </button>
                    <button type="button" @click="activeTab = 'antecedentes'"
                        :class="activeTab === 'antecedentes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="flex items-center whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        <i class="fa-solid fa-file-medical mr-2"></i>
                        Antecedentes
                        @if($hasErrorsAntecedentes)
                            <span class="ml-1 w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                        @endif
                    </button>
                    <button type="button" @click="activeTab = 'general'"
                        :class="activeTab === 'general' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="flex items-center whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        <i class="fa-solid fa-info-circle mr-2"></i>
                        Información general
                        @if($hasErrorsGeneral)
                            <span class="ml-1 w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                        @endif
                    </button>
                    <button type="button" @click="activeTab = 'emergencia'"
                        :class="activeTab === 'emergencia' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="flex items-center whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        <i class="fa-solid fa-heart mr-2"></i>
                        Contacto de emergencia
                        @if($hasErrorsEmergencia)
                            <span class="ml-1 w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                        @endif
                    </button>
                </nav>
            </div>

            {{-- Tab 1: Datos personales --}}
            <div x-show="activeTab === 'personal'" x-cloak>
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
            </div>

            {{-- Tab 2: Antecedentes --}}
            <div x-show="activeTab === 'antecedentes'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="allergies" class="block text-sm font-medium text-gray-700 mb-1">Alergias conocidas</label>
                        <textarea name="allergies" id="allergies" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('allergies') border-red-500 @enderror"
                        >{{ old('allergies', $patient->allergies) }}</textarea>
                        @error('allergies')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="chronic_conditions" class="block text-sm font-medium text-gray-700 mb-1">Enfermedades crónicas</label>
                        <textarea name="chronic_conditions" id="chronic_conditions" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('chronic_conditions') border-red-500 @enderror"
                        >{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                        @error('chronic_conditions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="surgical_history" class="block text-sm font-medium text-gray-700 mb-1">Antecedentes quirúrgicos</label>
                        <textarea name="surgical_history" id="surgical_history" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('surgical_history') border-red-500 @enderror"
                        >{{ old('surgical_history', $patient->surgical_history) }}</textarea>
                        @error('surgical_history')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="family_history" class="block text-sm font-medium text-gray-700 mb-1">Antecedentes familiares</label>
                        <textarea name="family_history" id="family_history" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('family_history') border-red-500 @enderror"
                        >{{ old('family_history', $patient->family_history) }}</textarea>
                        @error('family_history')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Tab 3: Información general --}}
            <div x-show="activeTab === 'general'" x-cloak>
                <div>
                    <label for="blood_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Sangre</label>
                    <select name="blood_type_id" id="blood_type_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('blood_type_id') border-red-500 @enderror">
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
                    <label for="observations" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                    <textarea name="observations" id="observations" rows="5"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('observations') border-red-500 @enderror"
                    >{{ old('observations', $patient->observations) }}</textarea>
                    @error('observations')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tab 4: Contacto de emergencia --}}
            <div x-show="activeTab === 'emergencia'" x-cloak>
                <div class="space-y-4">
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre de contacto</label>
                        <input type="text" name="emergency_contact_name" id="emergency_contact_name" placeholder="Nombre del contacto de emergencia"
                            value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                            class="w-full bg-white border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('emergency_contact_name') border-red-500 @enderror">
                        @error('emergency_contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono de contacto</label>
                        <input type="text" name="emergency_contact_phone" id="emergency_contact_phone" placeholder="Teléfono del contacto"
                            value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                            class="w-full bg-white border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('emergency_contact_phone') border-red-500 @enderror">
                        @error('emergency_contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="emergency_contact_relationship" class="block text-sm font-medium text-gray-700 mb-1">Relación con el contacto</label>
                        <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship" placeholder="Ej. Padre, Madre, Hermano"
                            value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                            class="w-full bg-white border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('emergency_contact_relationship') border-red-500 @enderror">
                        @error('emergency_contact_relationship')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-admin-layout>
