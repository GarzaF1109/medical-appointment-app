<x-admin-layout title="Editar Usuario" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Editar'],
]">

    <x-wire-card>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input label="Nombre" name="name" placeholder="Nombre completo" value="{{ old('name', $user->name) }}" autocomplete="off" />

                <x-wire-input label="Contraseña" name="password" type="password" placeholder="Dejar vacío para no cambiar" autocomplete="new-password" />

                <x-wire-input label="Confirmar contraseña" name="password_confirmation" type="password" placeholder="Repita la contraseña" autocomplete="new-password" />

                <x-wire-input label="Número de ID" name="id_number" placeholder="Ej. 123456789" value="{{ old('id_number', $user->id_number) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-wire-input label="Teléfono" name="phone" placeholder="999999999" icon="phone" value="{{ old('phone', $user->phone) }}" />
            </div>

            <div class="mt-4">
                <x-wire-input label="Dirección" name="address" placeholder="Calle 90 293" icon="map-pin" value="{{ old('address', $user->address) }}" />
            </div>

            <div class="mt-4">
                <x-wire-select label="Rol" name="role" placeholder="Seleccione un rol" hint="Define los permisos y accesos del usuario">
                    @foreach ($roles as $role)
                        <x-wire-select.option value="{{ $role->id }}" label="{{ $role->name }}" :selected="old('role', $user->roles->first()?->id) == $role->id" />
                    @endforeach
                </x-wire-select>
            </div>

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>Actualizar</x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
