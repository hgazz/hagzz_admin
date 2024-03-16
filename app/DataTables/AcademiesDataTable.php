<?php

namespace App\DataTables;

use App\Http\Traits\DataTablesTrait;
use App\Models\Academies;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class AcademiesDataTable extends DataTable
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
            ->addColumn('commercial_name_en', fn($raw) => $raw->getTranslation('commercial_name', 'en'))
            ->addColumn('commercial_name_ar', fn($raw) => $raw->getTranslation('commercial_name', 'ar'))
            ->addColumn('sports', function ($query) {
                return $query->sports->pluck('name')->implode(', ');
            })
            ->addColumn('action', function (Academies $academies) {
                return view('Admin.pages.academies.datatable.actions', compact('academies'))->render();
            })
            ->addColumn('branch_to',function (Academies $academies){
                return $academies->academy->commercial_name ?? '';
            })
            ->rawColumns(['action', 'commercial_name_en', 'commercial_name_ar']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Academies $model): QueryBuilder
    {
        return $model->newQuery()->with('sports');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $hideButtonsArray = array_column($this->getColumns(), 'title');
        $hideButtonsArray = $this->makeHideButtons($hideButtonsArray);
        return $this->builder()
                    ->setTableId('academies-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->selectStyleSingle()
                    ->parameters([
                        'scrollX' => true,
                        'scrollY' => true,
                        'responsive' => true,
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
            ['name' => 'commercial_name_en', 'data' => 'commercial_name_en', 'title' => trans('admin.academies.commercial_name_en')],
            ['name' => 'commercial_name_ar', 'data' => 'commercial_name_ar', 'title' => trans('admin.academies.commercial_name_ar')],
            ['name' => 'email', 'data' => 'email', 'title' => trans('admin.academies.email')],
            ['name' => 'phone', 'data' => 'phone', 'title' => trans('admin.academies.phone')],
            ['name' => 'role', 'data' => 'role', 'title' => trans('admin.academies.role')],
            ['name' => 'branch_to', 'data' => 'branch_to', 'title' => trans('admin.academies.branch_to')],
            ['name' => 'trade_license_number', 'data' => 'trade_license_number', 'title' => trans('admin.academies.trade_license_number')],
            ['name' => 'trade_license_expire_date', 'data' => 'trade_license_expire_date', 'title' => trans('admin.academies.trade_license_expire_date')],
            ['name' => 'tax_number', 'data' => 'tax_number', 'title' => trans('admin.academies.tax_number')],
            ['name' => 'national_id_number', 'data' => 'national_id_number', 'title' => trans('admin.academies.national_id_number')],
            ['name' => 'address', 'data' => 'address', 'title' => trans('admin.academies.address')],
            ['name' => 'sports', 'data' => 'sports', 'title' => trans('admin.sport.sport')],
            ['name' => 'contract_number', 'data' => 'contract_number', 'title' => trans('admin.academies.contract_number')],
            ['name' => 'account_manager', 'data' => 'account_manager', 'title' => trans('admin.academies.account_manager')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Academies_' . date('YmdHis');
    }
}
