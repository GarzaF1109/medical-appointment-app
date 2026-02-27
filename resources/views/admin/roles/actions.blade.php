<div class="flex items-center space-x-2">
    <a href="{{ route('admin.roles.edit', $role) }}" 
       class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600">
        <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
    </a>

    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" 
          onsubmit="return confirm('¿Estás seguro de eliminar este rol?')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600">
            <i class="fa-solid fa-trash mr-1"></i> Borrar
        </button>
    </form>
</div>