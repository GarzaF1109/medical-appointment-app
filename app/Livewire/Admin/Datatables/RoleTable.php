<?php

namespace App\Livewire\Admin\Datatables;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

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
                ->sortable(),
            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(function($value) {
                    return \Carbon\Carbon::parse($value)->format('d/m/Y');
                }),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.roles.actions', ['role' => $row]);
                })
        ];
    }
}
