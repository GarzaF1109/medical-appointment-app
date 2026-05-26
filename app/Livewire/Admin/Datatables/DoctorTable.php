<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Doctor;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorTable extends DataTableComponent
{
    protected $model = Doctor::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->hideIf(true),
            Column::make('Nombre', 'user.name')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'user.email')
                ->sortable()
                ->searchable(),
            Column::make('Especialidad', 'speciality.name')
                ->sortable()
                ->searchable(),
            Column::make('Licencia médica', 'medical_license_number')
                ->sortable(),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.doctors.actions', ['doctor' => $row]);
                }),
        ];
    }
}
