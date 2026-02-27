<x-admin-layout title="Crear Rol" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Roles', 'href' => route('admin.roles.index')],
    ['name' => 'Crear'],
]">
    <div class="max-w-2xl bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del rol</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Permisos</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    Crear Rol
                </button>
                <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>