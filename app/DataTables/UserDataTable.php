<?php

namespace App\DataTables;

use App\Http\Traits\DataTablesTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->addColumn('country',function (User $user){
              return $user?->country?->name;
            })
            ->addColumn('city',function (User $user){
                return $user?->city?->name;
            })
            ->addColumn('area',function (User $user){
                return $user?->area?->name;
            })
            ->addColumn('image', function (User $user) {
                return '<img src="'. $user->image . '" width="100" height="100">';
            })
            ->editColumn('is_verify', function (User $user) {
                return $user->is_verify == 1 ? trans('admin.user.is_verify') : trans('admin.user.not_verify');
            })
            ->filterColumn('is_verify', function ($query, $keyword) {
                $query->verificationStatus($keyword);
            })
            ->addColumn('action', function (User $user) {
                return view('Admin.pages.users.datatable.actions', compact('user'))->render();
            })
            ->rawColumns(['action','image', 'is_verify']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
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
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfltip')
                    ->scrollX()
                    ->scrollY()
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
            ['name' => 'id', 'data' => 'id', 'title' => trans('admin.id')],
            ['name' => 'image', 'data' => 'image', 'title' => trans('admin.banners.image')],
            ['name' => 'name', 'data' => 'name', 'title' => trans('admin.user.name')],
            ['name' => 'phone', 'data' => 'phone', 'title' => trans('admin.user.phone')],
            ['name' => 'gender', 'data' => 'gender', 'title' => trans('admin.user.gender')],
            ['name' => 'user_type', 'data' => 'user_type', 'title' => trans('admin.user.user_type')],
            ['name' => 'birth_date', 'data' => 'birth_date', 'title' => trans('admin.user.birth_date')],
            ['name' => 'country', 'data' => 'country', 'title' => trans('admin.user.country')],
            ['name' => 'city', 'data' => 'city', 'title' => trans('admin.user.city')],
            ['name' => 'area', 'data' => 'area', 'title' => trans('admin.user.area')],
            ['name' => 'is_verify', 'data' => 'is_verify', 'title' => trans('admin.user.is_verify')],
//            ['name' => 'fcm_token', 'data' => 'fcm_token', 'title' => trans('admin.user.fcm_token')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
