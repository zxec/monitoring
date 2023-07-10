<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Department;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class DepartmentDataTable extends DataTable
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
            ->addColumn('action', function ($department) {
                return view('dataTable.partials.actionAjax')->with([
                    'data' => $department,
                    'permissions' => [
                        'edit' => 'edit departments',
                        'delete' => 'delete departments',
                    ],
                    'class' => [
                        'edit' => 'editDepartment',
                        'delete' => 'deleteDepartment',
                    ],
                ]);
            })
            ->editColumn('created_at', function ($department) {
                return Carbon::parse($department->created_at)->format('d.m.Y H:i:s');
            })
            ->editColumn('updated_at', function ($department) {
                return Carbon::parse($department->updated_at)->format('d.m.Y H:i:s');
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Department $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Department $model): QueryBuilder
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
            ->setTableId('departments-table')
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
        return 'Departments_' . date('YmdHis');
    }
}
