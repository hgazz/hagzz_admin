<?php

namespace App\DataTables;

use App\Models\Sport;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', fn($raw) => $raw->name)
        ->editColumn('icon', function ($raw) {

            return '<img src="'.asset($raw->icon).'" class="img-thumbnail" width="80" height="80">';
        })
            ->addColumn('action', function (Sport $sport) {
                return view('Admin.pages.sport.datatable.actions', compact('sport'))->render();
            })
        ->rawColumns(['icon', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Sport $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sport-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => trans('admin.card.title')],
            ['data' => 'icon', 'name' => 'icon', 'title' => trans('admin.card.icon')],
            ['data' => 'level', 'name' => 'level', 'title' => trans('admin.card.level')],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Sport_' . date('YmdHis');
    }
}
