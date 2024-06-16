<?php

namespace App\DataTables;

use App\Http\Traits\DataTablesTrait;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class GalleryDataTable extends DataTable
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
            ->addColumn('image', function (Gallery $gallery) {
                return '<img src="' . $gallery->image . '" width="120" height="80" class="img-thumbnail"/>';
            })
            ->editColumn('academy.commercial_name', function (Gallery $gallery) {
                return $gallery->academy->commercial_name;
            })
            ->editColumn('active', function (Gallery $gallery) {
                return $gallery->active ? trans('admin.gallery.active') : trans('admin.gallery.not_active');
            })
            ->addColumn('action', function (Gallery $gallery) {
                return view('Admin.pages.gallery.datatable.actions', compact('gallery'))->render();
            })
            ->addColumn('checkbox',function (Gallery $gallery){
                return view('Admin.pages.gallery.datatable.checkbox',compact('gallery'));
            })
            ->filterColumn('academy.commercial_name', function ($query, $keyword) {
                $query->whereHas('academy', function ($q) use ($keyword) {
                    // Adjust the query to filter based on the JSON content
                    $q->whereRaw("JSON_SEARCH(lower(commercial_name), 'one', lower(?)) IS NOT NULL", ["%{$keyword}%"]);
                });
            })
            ->rawColumns(['action', 'image','academy.commercial_name', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Gallery $model): QueryBuilder
    {
        $query = $model->newQuery()->with('academy:id,commercial_name');
        $academy = request()->input('academy.commercial_name');
        if ($academy) {
            $query->whereHas('academy', function ($q) use ($academy) {
                $q->whereRaw("JSON_SEARCH(lower(commercial_name), 'one', lower(?)) IS NOT NULL", ["%{$academy}%"]);
            });
        }

        return $query->select('galleries.*');

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $hideButtonsArray = array_column($this->getColumns(), 'title');
        $hideButtonsArray = $this->makeHideButtons($hideButtonsArray);
        return $this->builder()
                    ->setTableId('gallery-table')
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
            ['name' => 'checkbox', 'data' => 'checkbox', 'title' => trans('admin.gallery.bulk_active'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
            ['name' => 'id', 'data' => 'id', 'title' => trans('admin.id')],
            ['name' => 'academy.commercial_name', 'data' => 'academy.commercial_name', 'title' => trans('admin.training.academy')],
            ['name' => 'image', 'data' => 'image', 'title' => trans('admin.gallery.image')],
            ['name' => 'active', 'data' => 'active', 'title' => trans('admin.gallery.active')],
            ['name' => 'action', 'data' => 'action', 'title' => trans('admin.actions'), 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Gallery_' . date('YmdHis');
    }
}
