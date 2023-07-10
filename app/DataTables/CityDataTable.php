<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\City;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CityDataTable extends DataTable
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
            ->editColumn('region_id', function ($city) {
                return $city->region->name;
            })
            ->editColumn('created_at', function ($city) {
                return Carbon::parse($city->created_at)->format('d.m.Y H:i:s');
            })
            ->editColumn('updated_at', function ($city) {
                return Carbon::parse($city->updated_at)->format('d.m.Y H:i:s');
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\City $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(City $model): QueryBuilder
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
            ->setTableId('cities-table')
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
            Column::make('region_id')
                ->title(__('dataTable.region')),
            Column::make('created_at')
                ->title(__('dataTable.created_at')),
            Column::make('updated_at')
                ->title(__('dataTable.updated_at')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Cities_' . date('YmdHis');
    }
}
