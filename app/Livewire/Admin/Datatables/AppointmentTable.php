<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Appointment;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AppointmentTable extends DataTableComponent
{
    protected $model = Appointment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Paciente', 'patient.user.name')
                ->sortable()
                ->searchable(),
            Column::make('Doctor', 'doctor.user.name')
                ->sortable()
                ->searchable(),
            Column::make('Fecha', 'date')
                ->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('d/m/Y')),
            Column::make('Hora', 'start_time')
                ->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('H:i')),
            Column::make('Hora Fin', 'end_time')
                ->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('H:i')),
            Column::make('Estado', 'status')
                ->sortable()
                ->format(function ($value, $row) {
                    return $row->status_label;
                }),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.appointments.actions', ['appointment' => $row]);
                }),
        ];
    }
}
