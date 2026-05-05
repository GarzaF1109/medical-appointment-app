<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Patient;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class PatientTable extends DataTableComponent
{
    protected $model = Patient::class;

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
            Column::make('Número de ID', 'user.id_number')
                ->sortable(),
            Column::make('Teléfono', 'user.phone')
                ->sortable(),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.patients.actions', ['patient' => $row]);
                }),
        ];
    }
}
