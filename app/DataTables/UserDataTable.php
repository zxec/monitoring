<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserDataTable extends DataTable
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
            ->addColumn('action', function ($user) {
                return view('dataTable.partials.action')->with([
                    'data' => $user,
                    'permissions' => [
                        'edit' => 'edit users',
                        'delete' => 'delete users',
                    ],
                    'route' => [
                        'edit' => 'user.edit',
                        'delete' => 'user.destroy',
                    ],
                ]);
            })
            ->editColumn('department_id', function ($user) {
                return $user->department->name ?? '';
            })
            ->editColumn('position_id', function ($user) {
                return $user->position->name ?? '';
            })
            ->editColumn('gender_id', function ($user) {
                return $user->gender->name ?? '';
            })
            ->editColumn('status_id', function ($user) {
                return $user->status->name ?? '';
            })
            ->editColumn('role', function ($user) {
                return $user->getRoleNames()[0] ?? '';
            })
            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('d.m.Y H:i:s');
            })
            ->editColumn('updated_at', function ($user) {
                return Carbon::parse($user->updated_at)->format('d.m.Y H:i:s');
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
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
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
                ->title(__('dataTable.name')),
            Column::make('email'),
            Column::make('department_id')
                ->title(__('dataTable.department')),
            Column::make('position_id')
                ->title(__('dataTable.position')),
            Column::make('gender_id')
                ->title(__('dataTable.gender')),
            Column::make('status_id')
                ->title(__('dataTable.status')),
            Column::computed('role')
                ->title(__('dataTable.role')),
            Column::make('created_at')
                ->title(__('dataTable.created_at')),
            Column::make('updated_at')
                ->title(__('dataTable.updated_at')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->title(__('dataTable.action'))
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
