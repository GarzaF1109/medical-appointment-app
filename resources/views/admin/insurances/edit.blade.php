<x-admin-layout title="Editar Seguro | Healthify" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Seguros',
        'href' => route('admin.insurances.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <h2 class="text-xl font-bold text-gray-800 mb-4">Editar Convenio de Seguro</h2>

    <form action="{{ route('admin.insurances.update', $insurance) }}" method="POST" novalidate
        x-data="{
            startDate: '{{ old('start_date', $insurance->start_date->format('Y-m-d')) }}',
            endDate: '{{ old('end_date', $insurance->end_date->format('Y-m-d')) }}',
            phone: '{{ old('phone', $insurance->phone) }}',
            policyNumber: '{{ old('policy_number', $insurance->policy_number) }}',
            coveragePercentage: '{{ old('coverage_percentage', $insurance->coverage_percentage) }}',
            description: `{{ old('description', $insurance->description) }}`,
            filterPhone(e) {
                this.phone = this.phone.replace(/[^0-9]/g, '').substring(0, 10);
            },
            filterPolicyNumber(e) {
                this.policyNumber = this.policyNumber.replace(/[^A-Za-z0-9\-]/g, '').toUpperCase();
            },
            clampPercentage() {
                let val = parseFloat(this.coveragePercentage);
                if (isNaN(val)) return;
                if (val < 0) this.coveragePercentage = '0';
                if (val > 100) this.coveragePercentage = '100';
            }
        }">
        @csrf
        @method('PUT')

        {{-- Error summary --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                <div class="flex items-center mb-2">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 mr-2"></i>
                    <span class="font-semibold text-red-800">Se encontraron errores en el formulario</span>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Card --}}
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
                    <a href="{{ route('admin.insurances.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Volver
                    </a>
                    <button type="submit"
                        :disabled="startDate && endDate && endDate <= startDate"
                        :class="{ 'opacity-50 cursor-not-allowed': startDate && endDate && endDate <= startDate }"
                        class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nombre del convenio --}}
                <div>
                    <label for="name" class="block text-sm font-medium mb-1 @error('name') text-red-600 @else text-gray-700 @enderror">
                        Nombre del convenio <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $insurance->name) }}"
                        required minlength="3" maxlength="255"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @else border-gray-300 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Aseguradora --}}
                <div>
                    <label for="provider" class="block text-sm font-medium mb-1 @error('provider') text-red-600 @else text-gray-700 @enderror">
                        Aseguradora <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="provider" id="provider" value="{{ old('provider', $insurance->provider) }}"
                        required minlength="3" maxlength="255"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('provider') border-red-500 @else border-gray-300 @enderror">
                    @error('provider')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Número de póliza --}}
                <div>
                    <label for="policy_number" class="block text-sm font-medium mb-1 @error('policy_number') text-red-600 @else text-gray-700 @enderror">
                        Número de póliza <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="policy_number" id="policy_number"
                        x-model="policyNumber" @input="filterPolicyNumber"
                        required minlength="5" maxlength="50"
                        pattern="[A-Za-z0-9\-]+"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('policy_number') border-red-500 @else border-gray-300 @enderror">
                    <p class="mt-1 text-xs text-gray-400">Solo letras, números y guiones</p>
                    @error('policy_number')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo de cobertura --}}
                <div>
                    <label for="coverage_type" class="block text-sm font-medium mb-1 @error('coverage_type') text-red-600 @else text-gray-700 @enderror">
                        Tipo de cobertura <span class="text-red-500">*</span>
                    </label>
                    <select name="coverage_type" id="coverage_type" required
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('coverage_type') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Seleccionar tipo de cobertura</option>
                        @foreach(['Básica', 'Intermedia', 'Completa', 'Premium', 'Dental', 'Oftalmológica', 'Maternidad'] as $type)
                            <option value="{{ $type }}" {{ old('coverage_type', $insurance->coverage_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('coverage_type')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Porcentaje de cobertura --}}
                <div>
                    <label for="coverage_percentage" class="block text-sm font-medium mb-1 @error('coverage_percentage') text-red-600 @else text-gray-700 @enderror">
                        Porcentaje de cobertura (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="coverage_percentage" id="coverage_percentage"
                        x-model="coveragePercentage" @change="clampPercentage"
                        required min="0" max="100" step="0.01"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('coverage_percentage') border-red-500 @else border-gray-300 @enderror">
                    <p class="mt-1 text-xs text-gray-400">Valor entre 0 y 100</p>
                    @error('coverage_percentage')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label for="status" class="block text-sm font-medium mb-1 @error('status') text-red-600 @else text-gray-700 @enderror">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @else border-gray-300 @enderror">
                        <option value="1" {{ old('status', $insurance->status) == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('status', $insurance->status) == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de inicio --}}
                <div>
                    <label for="start_date" class="block text-sm font-medium mb-1 @error('start_date') text-red-600 @else text-gray-700 @enderror">
                        Fecha de inicio de vigencia <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="start_date" id="start_date"
                        x-model="startDate" required
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @else border-gray-300 @enderror">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de fin --}}
                <div>
                    <label for="end_date" class="block text-sm font-medium mb-1 @error('end_date') text-red-600 @else text-gray-700 @enderror">
                        Fecha de fin de vigencia <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="end_date" id="end_date"
                        x-model="endDate" required
                        :min="startDate"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @else border-gray-300 @enderror">
                    <template x-if="startDate && endDate && endDate <= startDate">
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>La fecha de fin debe ser posterior a la fecha de inicio.</p>
                    </template>
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label for="phone" class="block text-sm font-medium mb-1 @error('phone') text-red-600 @else text-gray-700 @enderror">
                        Teléfono de contacto <span class="text-gray-400 text-xs">(opcional)</span>
                    </label>
                    <input type="tel" name="phone" id="phone"
                        x-model="phone" @input="filterPhone"
                        minlength="10" maxlength="10"
                        pattern="[0-9]{10}"
                        inputmode="numeric"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @else border-gray-300 @enderror">
                    <p class="mt-1 text-xs text-gray-400">Exactamente 10 dígitos numéricos</p>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium mb-1 @error('email') text-red-600 @else text-gray-700 @enderror">
                        Correo electrónico <span class="text-gray-400 text-xs">(opcional)</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $insurance->email) }}"
                        maxlength="255"
                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @else border-gray-300 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium mb-1 text-gray-700">
                    Descripción del convenio <span class="text-gray-400 text-xs">(opcional)</span>
                </label>
                <textarea name="description" id="description" rows="4" maxlength="1000"
                    x-model="description"
                    class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300">{{ old('description', $insurance->description) }}</textarea>
                <p class="mt-1 text-xs text-gray-400"><span x-text="description.length">0</span> / 1000 caracteres</p>
            </div>

            <p class="mt-4 text-xs text-gray-400"><span class="text-red-500">*</span> Campos obligatorios</p>
        </div>
    </form>

</x-admin-layout>
