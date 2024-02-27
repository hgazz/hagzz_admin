<?php

namespace App\DataTables;

use App\Models\Academies;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AcademiesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('sports', function ($query) {
                return $query->sports->pluck('name')->implode(', ');
            })
            ->addColumn('action', function (Academies $academies) {
                return view('Admin.pages.academies.datatable.actions', compact('academies'))->render();
            })
            ->rawColumns(['action']);
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
        return $this->builder()
                    ->setTableId('academies-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX()
                    ->scrollY()
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
            ['name' => 'id', 'data' => 'id', 'title' => trans('admin.id')],
            ['name' => 'first_name', 'data' => 'first_name', 'title' => trans('admin.academies.first_name')],
            ['name' => 'last_name', 'data' => 'last_name', 'title' => trans('admin.academies.last_name')],
            ['name' => 'email', 'data' => 'email', 'title' => trans('admin.academies.email')],
            ['name' => 'full_name_arabic', 'data' => 'full_name_arabic', 'title' => trans('admin.academies.full_name_arabic')],
            ['name' => 'phone', 'data' => 'phone', 'title' => trans('admin.academies.phone')],
            ['name' => 'role', 'data' => 'role', 'title' => trans('admin.academies.role')],
            ['name' => 'commercial_name', 'data' => 'commercial_name', 'title' => trans('admin.academies.commercial_name')],
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
