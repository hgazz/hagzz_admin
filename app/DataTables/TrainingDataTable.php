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
            ->editColumn('sport_id', function (Training $training) {
                return $training->sport->name;
            })
            ->editColumn('address_id', function (Training $training) {
                return $training->address->address;
            })
            ->editColumn('active', function (Training $training) {
                return $training->active ? trans('admin.academies.active') : trans('admin.academies.inactive');
            })
            ->addColumn('classes', function (Training $training) {
                return $training->classes->count();
            })
            ->addColumn('subscribed', function (Training $training) {
                return $training->joins->count();
            })
            ->editColumn('classes_days', function (Training $training) {
                return ! is_null($training->classes_days ) ? $training->classes_days : null;
            })
            ->editColumn('color', function (Training $training) {
                return "<div style='background-color: $training->color; width: 20px; height: 20px; border-radius: 2px'></div>";
            })
            ->addColumn('action', function (Training $training) {
                return view('Admin.pages.training.datatable.actions', compact('training'))->render();
            })
            ->rawColumns(['action', 'coach_id', 'academy_id','image','sport_id', 'classes', 'subscribed', 'active', 'classes_days', 'color']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Training $model): QueryBuilder
    {
        if ($this->query) {
            return $this->query;
        }
        return $model->newQuery()->with(['coach', 'academy', 'sport', 'classes', 'joins', 'address']);
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
            ['name' => 'name', 'data' => 'name', 'title' => trans('admin.training.name')],
            ['name' => 'price', 'data' => 'price', 'title' => trans('admin.training.price')],
            ['name' => 'academy.commercial_name', 'data' => 'academy_id', 'title' => trans('admin.training.academy')],
            ['name' => 'coach.name', 'data' => 'coach_id', 'title' => trans('admin.training.coach')],
//            ['name' => 'start_date', 'data' => 'start_date', 'title' => trans('admin.training.start_date')],
//            ['name' => 'end_date', 'data' => 'end_date', 'title' => trans('admin.training.end_date')],
            ['name' => 'age_group', 'data' => 'age_group', 'title' => trans('admin.training.age_group')],
            ['name' => 'gender', 'data' => 'gender', 'title' => trans('admin.training.gender')],
            ['name' => 'max_players', 'data' => 'max_players', 'title' => trans('admin.training.max_players')],
            ['name' => 'level', 'data' => 'level', 'title' => trans('admin.training.level')],
            ['name' => 'address.address', 'data' => 'address_id', 'title' => trans('admin.training.address')],
            ['name' => 'subscribed', 'data' => 'subscribed', 'title' => trans('admin.training.subscribed')],
            ['name' => 'active', 'data' => 'active', 'title' => trans('admin.training.active')],
            ['name' => 'description', 'data' => 'description', 'title' => trans('admin.training.description')],
            ['name' => 'sport.name', 'data' => 'sport_id', 'title' => trans('admin.training.sport')],
            ['name' => 'classes_number', 'data' => 'classes_number', 'title' => trans('admin.training.classes_number')],
            ['name' => 'classes_days', 'data' => 'classes_days', 'title' => trans('admin.training.classes_days')],
            ['name' => 'color', 'data' => 'color', 'title' => trans('admin.training.color')],
//            ['name' => 'classes', 'data' => 'classes', 'title' => trans('admin.training.classes_count')],
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
