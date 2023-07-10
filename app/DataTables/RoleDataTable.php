<?php

namespace App\DataTables;

use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class RoleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($role) {
                return view('dataTable.partials.action')->with([
                    'data' => $role,
                    'permissions' => [
                        'edit' => 'edit roles',
                        'delete' => 'delete roles',
                    ],
                    'route' => [
                        'edit' => 'role.edit',
                        'delete' => 'role.destroy',
                    ],
                ]);
            })
            ->setRowId('id')
            ->editColumn('created_at', function ($role) {
                return Carbon::parse($role->created_at)->format('d.m.Y H:i:s');
            })
            ->editColumn('updated_at', function ($role) {
                return Carbon::parse($role->updated_at)->format('d.m.Y H:i:s');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Spatie\Permission\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('roles-table')
            ->columns($this->getColumns())
            ->buttons([])
            ->language('ru.json');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name')
                ->title(__('dataTable.title')),
            Column::make('created_at')
                ->title(__('dataTable.created_at')),
            Column::make('updated_at')
                ->title(__('dataTable.updated_at')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->title(__('dataTable.action')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }
}
