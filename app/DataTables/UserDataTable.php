<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('country',function (User $user){
              return $user->country->name;
            })
            ->addColumn('city',function (User $user){
                return $user->city->name;
            })
            ->addColumn('area',function (User $user){
                return $user->area->name;
            })
            ->addColumn('action', function (User $user) {
//                return view('Admin.pages.academies.datatable.actions', compact('user'))->render();
            })
            ->rawColumns(['action']);
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
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->scrollX()
                    ->scrollY()
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
            ['name' => 'name', 'data' => 'name', 'title' => trans('admin.academies.name')],
            ['name' => 'phone', 'data' => 'phone', 'title' => trans('admin.academies.phone')],
            ['name' => 'gender', 'data' => 'gender', 'title' => trans('admin.academies.gender')],
            ['name' => 'birth_date', 'data' => 'birth_date', 'title' => trans('admin.academies.gender')],
            ['name' => 'country', 'data' => 'country', 'title' => trans('admin.academies.country')],
            ['name' => 'city', 'data' => 'city', 'title' => trans('admin.academies.city')],
            ['name' => 'area', 'data' => 'area', 'title' => trans('admin.academies.area')],


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
