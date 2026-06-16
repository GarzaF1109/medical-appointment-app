<div>
    <div class="flex gap-6">
        {{-- Left Panel: Search + Results --}}
        <div class="flex-1">
            {{-- Search Section --}}
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-800">Buscar disponibilidad</h2>
                <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>

                <div class="flex items-end gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="date" wire:model="search_date"
                            class="rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('search_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora</label>
                        <select wire:model="search_time"
                            class="rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccionar rango</option>
                            <option value="08:00-09:00">08:00:00 - 09:00:00</option>
                            <option value="09:00-10:00">09:00:00 - 10:00:00</option>
                            <option value="10:00-11:00">10:00:00 - 11:00:00</option>
                            <option value="11:00-12:00">11:00:00 - 12:00:00</option>
                            <option value="12:00-13:00">12:00:00 - 13:00:00</option>
                            <option value="13:00-14:00">13:00:00 - 14:00:00</option>
                            <option value="14:00-15:00">14:00:00 - 15:00:00</option>
                            <option value="15:00-16:00">15:00:00 - 16:00:00</option>
                            <option value="16:00-17:00">16:00:00 - 17:00:00</option>
                            <option value="17:00-18:00">17:00:00 - 18:00:00</option>
                        </select>
                        @error('search_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad (opcional)</label>
                        <select wire:model="search_speciality"
                            class="rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Todas</option>
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" wire:click="searchAvailability"
                        class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                        Buscar disponibilidad
                    </button>
                </div>
            </div>

            {{-- Doctor Results --}}
            @if($searched)
                <div class="space-y-6">
                    @forelse($availableDoctors as $doctor)
                        <div>
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-sm font-bold text-indigo-600">{{ $doctor['initials'] }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Dr. {{ $doctor['name'] }}</p>
                                    <p class="text-sm text-indigo-500">{{ $doctor['speciality'] }}</p>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mb-2">Horarios disponibles:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($doctor['time_slots'] as $slot)
                                    <button type="button"
                                        wire:click="selectTimeSlot({{ $doctor['id'] }}, '{{ $slot }}')"
                                        class="px-4 py-2 text-sm font-medium rounded-lg transition-colors
                                            {{ $selected_doctor_id === $doctor['id'] && $selected_time === $slot
                                                ? 'bg-indigo-700 text-white'
                                                : 'bg-indigo-500 text-white hover:bg-indigo-600' }}">
                                        {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        @if(!$loop->last)
                            <hr class="border-gray-200">
                        @endif
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-calendar-xmark text-4xl mb-3"></i>
                            <p>No se encontraron doctores disponibles.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        {{-- Right Panel: Appointment Summary --}}
        @if($selected_doctor_id)
            <div class="w-80 shrink-0">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Resumen de la cita</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Doctor:</span>
                            <span class="font-medium text-gray-800">Dr. {{ $selected_doctor_name }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Fecha:</span>
                            <span class="font-medium text-gray-800">{{ $search_date }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Horario:</span>
                            <span class="font-medium text-gray-800">{{ $selected_time }} - {{ $selected_end_time }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Duraci&oacute;n:</span>
                            <span class="font-medium text-gray-800">15 minutos</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Paciente</label>
                        <select wire:model="patient_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Seleccionar paciente</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la cita</label>
                        <textarea wire:model="reason" rows="4"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="Motivo de la consulta..."></textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" wire:click="confirmAppointment"
                        class="w-full px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                        Confirmar cita
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
