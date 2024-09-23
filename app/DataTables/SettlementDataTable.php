<?php

namespace App\DataTables;

use App\Http\Traits\DataTablesTrait;
use App\Models\Settlement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SettlementDataTable extends DataTable
{
    use DataTablesTrait;
    protected $query;

    /**
     * Set a custom query.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return static
     */
    public function with(array|string $key, mixed $value = null): static
    {
        if (is_string($key) && $key === 'query') {
            $this->query = $value;
        }

        return $this;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('partner_commercial_name_en',function ($q){
             return $q->partner->getTranslation('commercial_name','en') ?? '';
            })
            ->addColumn('partner_commercial_name_ar',function ($q){
             return $q->partner->getTranslation('commercial_name','ar') ?? '';
            })
            ->addColumn('action',function (Settlement $settlement){
                return view('Admin.pages.settlement.action',compact('settlement'));
            })
            ->rawColumns(['partner_commercial_name_en', 'partner_commercial_name_ar','action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Settlement $model)
    {
        if ($this->query) {
            return $this->query;
        }

        return $model->newQuery()->with('partner');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $hideButtonsArray = array_column($this->getColumns(), 'title');
        $hideButtonsArray = $this->makeHideButtons($hideButtonsArray);
        return $this->builder()
                    ->setTableId('settlement-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfltip')
                    ->parameters([
                        'scrollX' => true,
                        'scrollY' => true,
                        'autoWidth' => false,
                        'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All records']],
                        'buttons' => [
                            $hideButtonsArray
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
            ['name' => 'id', 'data' => 'id', 'title' => trans('admin.id')],
            ['name' => 'partner.commercial_name', 'data' => 'partner_commercial_name_en', 'title' => trans('admin.academies.commercial_name_en'), 'searchable' => false],
            ['name' => 'partner.commercial_name', 'data' => 'partner_commercial_name_ar', 'title' => trans('admin.academies.commercial_name_ar'), 'searchable' => false],
            ['name' => 'total_amount', 'data' => 'total_amount', 'title' => trans('admin.total_amount')],
            ['name' => 'settlement_date', 'data' => 'settlement_date', 'title' => trans('admin.settlement_date')],
            ['name' => 'status', 'data' => 'status', 'title' => trans('admin.status')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Settlement_' . date('YmdHis');
    }
}
