<div>
    <form wire:submit="save">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">

            @php
                $hasErrorsConsulta = $errors->hasAny(['diagnosis', 'treatment']);
                $hasErrorsReceta = false;
                foreach ($prescriptions as $i => $p) {
                    if ($errors->hasAny(["prescriptions.{$i}.medication", "prescriptions.{$i}.dosage", "prescriptions.{$i}.frequency"])) {
                        $hasErrorsReceta = true;
                        break;
                    }
                }
                if ($errors->has('prescriptions')) $hasErrorsReceta = true;
                $errorTab = $errors->any()
                    ? ($hasErrorsConsulta ? 'consulta' : ($hasErrorsReceta ? 'receta' : 'consulta'))
                    : '';
            @endphp

            <x-tab-container defaultTab="consulta" :errorTab="$errorTab">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <x-tab-button name="consulta" icon="fa-solid fa-notes-medical" :hasErrors="$hasErrorsConsulta">
                            Consulta
                        </x-tab-button>
                        <x-tab-button name="receta" icon="fa-solid fa-prescription-bottle-medical" :hasErrors="$hasErrorsReceta">
                            Receta
                        </x-tab-button>
                    </nav>
                </div>

                {{-- Tab: Consulta --}}
                <x-tab-panel name="consulta">
                    <div class="space-y-6">
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium mb-1 @error('diagnosis') text-red-600 @else text-gray-700 @enderror">
                                Diagn&oacute;stico
                            </label>
                            <textarea wire:model="diagnosis" id="diagnosis" rows="4"
                                class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('diagnosis') border-red-500 text-red-900 @else border-gray-300 @enderror"
                                placeholder="Describa el diagn&oacute;stico del paciente aqui..."></textarea>
                            @error('diagnosis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="treatment" class="block text-sm font-medium mb-1 @error('treatment') text-red-600 @else text-gray-700 @enderror">
                                Tratamiento
                            </label>
                            <textarea wire:model="treatment" id="treatment" rows="4"
                                class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('treatment') border-red-500 text-red-900 @else border-gray-300 @enderror"
                                placeholder="Describa el tratamiento recomendado aqui..."></textarea>
                            @error('treatment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium mb-1 text-gray-700">
                                Notas
                            </label>
                            <textarea wire:model="notes" id="notes" rows="4"
                                class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300"
                                placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                        </div>
                    </div>
                </x-tab-panel>

                {{-- Tab: Receta --}}
                <x-tab-panel name="receta">
                    <div class="space-y-3">
                        {{-- Column Headers --}}
                        <div class="flex items-center gap-3">
                            <div class="flex-[2]">
                                <span class="text-sm font-medium text-gray-700">Medicamento</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">Dosis</span>
                            </div>
                            <div class="flex-[2]">
                                <span class="text-sm font-medium text-gray-700">Frecuencia / Duraci&oacute;n</span>
                            </div>
                            <div class="w-10"></div>
                        </div>

                        {{-- Medication Rows --}}
                        @foreach($prescriptions as $index => $prescription)
                            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg">
                                <div class="flex-[2]">
                                    <input type="text" wire:model="prescriptions.{{ $index }}.medication"
                                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('prescriptions.'.$index.'.medication') border-red-500 @else border-gray-300 @enderror text-sm"
                                        placeholder="Amoxicilina 500mg">
                                    @error('prescriptions.'.$index.'.medication')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex-1">
                                    <input type="text" wire:model="prescriptions.{{ $index }}.dosage"
                                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('prescriptions.'.$index.'.dosage') border-red-500 @else border-gray-300 @enderror text-sm"
                                        placeholder="1 cada 8 horas">
                                    @error('prescriptions.'.$index.'.dosage')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex-[2]">
                                    <input type="text" wire:model="prescriptions.{{ $index }}.frequency"
                                        class="w-full rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('prescriptions.'.$index.'.frequency') border-red-500 @else border-gray-300 @enderror text-sm"
                                        placeholder="Ej. cada 8 horas por 7 d&iacute;as">
                                    @error('prescriptions.'.$index.'.frequency')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-10 flex justify-center">
                                    <button type="button" wire:click="removeMedication({{ $index }})"
                                        class="w-8 h-8 inline-flex items-center justify-center bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        {{-- Add Medication Button --}}
                        <button type="button" wire:click="addMedication"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                            <i class="fa-solid fa-plus mr-2"></i>
                            A&ntilde;adir Medicamento
                        </button>
                    </div>
                </x-tab-panel>
            </x-tab-container>

            {{-- Save Button --}}
            <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Guardar Consulta
                </button>
            </div>
        </div>
    </form>
</div>
