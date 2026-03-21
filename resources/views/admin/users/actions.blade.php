<div class="flex items-center space-x-2">
    <a href="{{ route('admin.users.edit', $user) }}"
       class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>
