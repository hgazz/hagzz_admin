<?php

namespace App\DataTables;

use App\Http\Traits\DataTablesTrait;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
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
            ->addColumn('name.en', fn($raw) => $raw->getTranslation('name', 'en'))
            ->addColumn('name.ar', fn($raw) => $raw->getTranslation('name', 'ar'))
            ->addColumn('country.name', function (City $country) {
                return $country->country->getTranslation('name', app()->getLocale());
            })
            ->addColumn('action', function (City $city) {
                return view('Admin.pages.city.datatable.actions', compact('city'))->render();
            })
            ->filterColumn('country.name', function ($query, $keyword) {
                $query->whereHas('country', function ($q) use ($keyword) {
                    // Adjust the query to filter based on the JSON content
                    $q->whereRaw("JSON_SEARCH(lower(name), 'one', lower(?)) IS NOT NULL", ["%{$keyword}%"]);
                });
            })
            ->rawColumns(['action','country.name', 'name.en', 'name.ar']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(City $model): QueryBuilder
    {
        $query = $model->newQuery()->with('country:id,name');
        $country = request()->input('country.name');
        if ($country) {
            $query->whereHas('country', function ($q) use ($country) {
                $q->whereRaw("JSON_SEARCH(lower(name), 'one', lower(?)) IS NOT NULL", ["%{$country}%"]);
            });
        }

        return $query->select('cities.*');

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $hideButtonsArray = array_column($this->getColumns(), 'title');
        $hideButtonsArray = $this->makeHideButtons($hideButtonsArray);
        return $this->builder()
                    ->setTableId('city-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfltip')
                    ->orderBy(1)
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
            ['name' => 'name->en', 'data' => 'name.en', 'title' => trans('admin.city.name_en')],
            ['name' => 'name->ar', 'data' => 'name.ar', 'title' => trans('admin.city.name_ar')],
            ['name' => 'country.name', 'data' => 'country.name', 'title' => trans('admin.city.country')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'City_' . date('YmdHis');
    }
}
