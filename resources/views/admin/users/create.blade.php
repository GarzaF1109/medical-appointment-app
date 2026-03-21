<x-admin-layout title="Crear Usuario" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Crear'],
]">

    <x-card>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input label="Nombre" name="name" placeholder="Nombre completo" value="{{ old('name') }}" autocomplete="off" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input label="Contraseña" name="password" type="password" placeholder="Mínimo 8 caracteres" autocomplete="new-password" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input label="Confirmar contraseña" name="password_confirmation" type="password" placeholder="Repita la contraseña" autocomplete="new-password" />
                </div>

                <div>
                    <x-input label="Número de ID" name="id_number" placeholder="Ej. 123456789" value="{{ old('id_number') }}" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input label="Teléfono" name="phone" placeholder="999999999" icon="phone" value="{{ old('phone') }}" />
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <x-input label="Dirección" name="address" placeholder="Calle 90 293" icon="map-pin" value="{{ old('address') }}" />
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <x-select label="Rol" name="role" placeholder="Seleccione un rol" hint="Define los permisos y accesos del usuario" :options="$roles->map(fn($r) => ['label' => $r->name, 'value' => $r->id])->toArray()" option-label="label" option-value="value" />
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-4">
                <x-button type="submit" blue>Guardar</x-button>
            </div>
        </form>
    </x-card>

</x-admin-layout>
