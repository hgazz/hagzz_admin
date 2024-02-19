<?php

namespace App\Http\Controllers;

use App\DataTables\AreaDataTable;
use App\Http\Requests\Area\AreaRequest;
use App\Http\Traits\CitiesTrait;
use App\Models\Area;
use App\Services\TranslatableService;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    use CitiesTrait;
    private $areaModel;
    public function __construct(Area $area)
    {
        $this->areaModel = $area;
    }

    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.area.index');
    }

    public function create()
    {
        $cities = $this->getCities();
        return view('Admin.pages.area.create', get_defined_vars());
    }

    public function store(AreaRequest $request)
    {
        $translatableFields = TranslatableService::generateTranslatableFields($this->areaModel->getTranslatableFields(), $request->validated());
        $this->areaModel->create($translatableFields + ['city_id' => $request->city_id]);
        return to_route('admin.areas.index')->with('success', trans('admin.area.created_successfully'));
    }

    public function edit(Area $area)
    {
        $cities = $this->getCities();
        return view('Admin.pages.area.edit', compact('area', 'cities'));
    }

    public function update(AreaRequest $request, Area $area)
    {
        $translatableFields = TranslatableService::generateTranslatableFields($this->areaModel->getTranslatableFields(), $request->validated());
        $area->update($translatableFields + ['city_id' => $request->city_id]);
        return to_route('admin.areas.index')->with('success', trans('admin.area.updated_successfully'));
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return to_route('admin.areas.index')->with('success', trans('admin.area.deleted_successfully'));
    }
}
