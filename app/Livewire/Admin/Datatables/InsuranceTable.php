<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Insurance;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class InsuranceTable extends DataTableComponent
{
    protected $model = Insurance::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Nombre', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Aseguradora', 'provider')
                ->sortable()
                ->searchable(),
            Column::make('No. Póliza', 'policy_number')
                ->sortable()
                ->searchable(),
            Column::make('Cobertura', 'coverage_type')
                ->sortable(),
            Column::make('Porcentaje', 'coverage_percentage')
                ->sortable()
                ->format(fn ($value) => $value . '%'),
            Column::make('Vigencia', 'end_date')
                ->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('d/m/Y')),
            Column::make('Estado', 'status')
                ->sortable()
                ->format(function ($value, $row) {
                    return $row->status_label;
                }),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.insurances.actions', ['insurance' => $row]);
                }),
        ];
    }
}
