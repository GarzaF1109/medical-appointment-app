<div>
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fa-solid fa-user-shield mr-2 text-indigo-500"></i>
        Pacientes con este convenio
    </h3>

    {{-- Pacientes asignados --}}
    @if($insurance->patients->count() > 0)
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Miembro</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($insurance->patients as $patient)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $patient->user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $patient->user->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $patient->user->phone ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $patient->pivot->member_number ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" wire:click="removePatient({{ $patient->id }})"
                                    wire:confirm="¿Estás seguro de que deseas quitar este paciente del convenio?"
                                    class="inline-flex items-center px-2.5 py-1.5 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600">
                                    <i class="fa-solid fa-trash mr-1"></i> Quitar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-6 mb-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
            <i class="fa-solid fa-user-slash text-3xl text-gray-300 mb-2"></i>
            <p class="text-sm text-gray-500">No hay pacientes asociados a este convenio.</p>
        </div>
    @endif

    {{-- Formulario para agregar paciente --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-gray-700 mb-3">
            <i class="fa-solid fa-plus-circle mr-1 text-blue-500"></i>
            Asignar paciente a este convenio
        </h4>

        <div class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Paciente <span class="text-red-500">*</span></label>
                <select wire:model="selectedPatient"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('selectedPatient') border-red-500 @enderror">
                    <option value="">Seleccionar paciente</option>
                    @foreach($availablePatients as $pat)
                        <option value="{{ $pat->id }}">{{ $pat->user->name }} - {{ $pat->user->email }}</option>
                    @endforeach
                </select>
                @error('selectedPatient')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">No. de miembro <span class="text-gray-400 text-xs">(opcional)</span></label>
                <input type="text" wire:model="memberNumber" maxlength="50"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    placeholder="Ej. MEM-001234">
            </div>

            <button type="button" wire:click="addPatient"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 whitespace-nowrap">
                <i class="fa-solid fa-plus mr-2"></i>
                Asignar
            </button>
        </div>
    </div>
</div>
