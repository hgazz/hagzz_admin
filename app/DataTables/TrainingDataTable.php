<?php

namespace App\DataTables;


use App\Http\Traits\DataTablesTrait;
use App\Models\Training;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class TrainingDataTable extends DataTable
{
    use DataTablesTrait;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', fn($raw) => $raw->name)
            ->editColumn('description', fn($raw) => $raw->description)
            ->editColumn('coach_id', function (Training $training) {
                return $training->coach->name;
            })
            ->editColumn('academy_id', function (Training $training) {
                return $training->academy->commercial_name;
            })
            ->addColumn('action', function (Training $training) {
                return view('Admin.pages.training.datatable.actions', compact('training'))->render();
            })
            ->rawColumns(['action', 'coach_id', 'academy_id','image','class']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Training $model): QueryBuilder
    {
        return $model->newQuery()->with(['coach', 'academy', 'sport']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $hideButtonsArray = array_column($this->getColumns(), 'title');
        $hideButtonsArray = $this->makeHideButtons($hideButtonsArray);
        return $this->builder()
                    ->setTableId('training-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX()
                    ->scrollY()
                    ->dom('Bfltip')
                    ->selectStyleSingle()
                    ->parameters([
                        'scrollX' => true,
                        'scrollY' => true,
                        'autoWidth' => false,
                        'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All records']],
                        'buttons' => [
                            $hideButtonsArray,
                        ],
                        'order' => [
                            0, 'desc'
                        ],
                        'language' =>
                            (app()->getLocale() === 'ar') ?
                                [
                                    'url' => url('//cdn.datatables.net/plug-ins/1.13.8/i18n/ar.json')
                                ] :
                                [
                                    'url' => url('//cdn.datatables.net/plug-ins/1.13.8/i18n/English.json')
                                ]

                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => trans('admin.id')],
            ['name' => 'name', 'data' => 'name', 'title' => trans('admin.training.name')],
            ['name' => 'price', 'data' => 'price', 'title' => trans('admin.training.price')],
            ['name' => 'academy.commercial_name', 'data' => 'academy_id', 'title' => trans('admin.training.academy')],
            ['name' => 'coach.name', 'data' => 'coach_id', 'title' => trans('admin.training.coach')],
            ['name' => 'start_date', 'data' => 'start_date', 'title' => trans('admin.training.start_date')],
            ['name' => 'end_date', 'data' => 'end_date', 'title' => trans('admin.training.end_date')],
            ['name' => 'description', 'data' => 'description', 'title' => trans('admin.training.description')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Training_' . date('YmdHis');
    }
}
