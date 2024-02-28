<?php

namespace App\DataTables;

use App\Models\Area;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AreaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name_en', fn($raw) => $raw->getTranslation('name', 'en'))
            ->addColumn('name_ar', fn($raw) => $raw->getTranslation('name', 'ar'))
            ->addColumn('city_id', function (Area $area) {
                return $area->city->name;
            })
            ->addColumn('action', function (Area $area) {
                return view('Admin.pages.area.datatable.actions', compact('area'))->render();
            })
            ->filterColumn('city.name', function ($query, $keyword) {
                $query->whereHas('city',function ($q) use($keyword){
                    $q->whereRaw("JSON_SEARCH(lower(name), 'one', lower(?)) IS NOT NULL", ["%{$keyword}%"]);
                });
            })
            ->rawColumns(['name_en', 'name_ar','action', 'city_id', 'city_id']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Area $model): QueryBuilder
    {
        $query = $model->newQuery()->with('city');
        $city = request()->input('city.name');
        if ($city) {
            $query->whereHas('city', function ($q) use ($city) {
                // Use JSON_SEARCH to find any occurrence of $city within the JSON column, regardless of the key (locale)
                $q->whereRaw("JSON_SEARCH(lower(name), 'one', lower(?)) IS NOT NULL", ["%{$city}%"]);
            });
        }

        return $query->select('areas.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('area-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
            ['name' => 'id', 'data' => 'id', 'title' => trans('admin.id')],
            ['name' => 'name->en', 'data' => 'name_en', 'title' => trans('admin.city.name_en')],
            ['name' => 'name->ar', 'data' => 'name_ar', 'title' => trans('admin.city.name_ar')],
            ['name' => 'city.name', 'data' => 'city_id', 'title' => trans('admin.city.name')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Area_' . date('YmdHis');
    }
}
