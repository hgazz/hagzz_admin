<?php

namespace App\DataTables;

use App\Http\Traits\DataTablesTrait;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class SettingDataTable extends DataTable
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
            ->editColumn('value', function (Setting $setting) {

                if ($setting->type == 'image'){
                    return '<img src="' . $setting->logo.$setting->value . '" width="100" height="100">';
                }
                return  substr($setting->value, 0, 100);
            })
            ->addColumn('action', function (Setting $setting) {
                return view('Admin.pages.setting.datatable.actions', compact('setting'))->render();
            })
            ->rawColumns(['value', 'action']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Setting $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $hideButtonsArray = array_column($this->getColumns(), 'title');
        $hideButtonsArray = $this->makeHideButtons($hideButtonsArray);
        return $this->builder()
                    ->setTableId('setting-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
                                    'url' => asset('datatableAr.json')
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
            ['data' => 'id', 'name' => 'id', 'title' => trans('admin.setting.ID')],
            ['data' => 'key', 'name' => 'key', 'title' => trans('admin.setting.key')],
            ['data' => 'value', 'name' => 'value', 'title' => trans('admin.setting.value')],
            ['data' => 'type', 'name' => 'type', 'title' => trans('admin.setting.type')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Setting_' . date('YmdHis');
    }
}
