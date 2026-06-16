<div class="flex items-center space-x-2">
    <a href="{{ route('admin.appointments.consultation', $appointment) }}"
       class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white text-xs font-medium rounded hover:bg-green-600"
       title="Atender consulta">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <a href="{{ route('admin.appointments.consultation', $appointment) }}"
       class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700"
       title="Consulta">
        <i class="fa-solid fa-stethoscope"></i>
    </a>
</div>
