<div class="flex items-center space-x-2">
    <a href="{{ route('admin.doctors.schedules', $doctor) }}"
       class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white text-xs font-medium rounded hover:bg-green-600"
       title="Horarios">
        <i class="fa-solid fa-clock"></i>
    </a>
    <a href="{{ route('admin.doctors.edit', $doctor) }}"
       class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>
