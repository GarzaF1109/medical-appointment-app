<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

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
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Número de ID', 'id_number')
                ->sortable(),
            Column::make('Teléfono', 'phone')
                ->sortable(),
            Column::make('Rol')
                ->label(function ($row) {
                    return $row->getRoleNames()->first() ?? 'Sin rol';
                }),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.users.actions', ['user' => $row]);
                }),
        ];
    }
}
