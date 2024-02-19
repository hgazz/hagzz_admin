<?php

namespace App\Http\Controllers;

use App\DataTables\CityDataTable;
use App\Http\Requests\City\CityRequest;
use App\Models\City;
use App\Services\TranslatableService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private City $cityModel;

    public function __construct(City $city)
    {
        $this->cityModel = $city;
    }
    public function index(CityDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.city.index');
    }

    public function create()
    {
        return view('Admin.pages.city.create');
    }

    public function store(CityRequest $request)
    {
        $translatableFields = TranslatableService::generateTranslatableFields($this->cityModel->getTranslatableFields(), $request->validated());
        $this->cityModel->create($translatableFields);
        session()->flash('success',trans('admin.city.created_successfully'));
        return to_route('admin.cities.index');
    }

    public function edit(City $city)
    {
        return view('Admin.pages.city.edit',compact('city'));
    }

    public function update(CityRequest $request, City $city)
    {
        $translatableFields = TranslatableService::generateTranslatableFields($this->cityModel->getTranslatableFields(), $request->validated());
        $city->update($translatableFields);
        session()->flash('success',trans('admin.city.updated_successfully'));
        return to_route('admin.cities.index');
    }

    public function destroy(City $city)
    {
        $city->delete();
        session()->flash('success',trans('admin.city.deleted_successfully'));
        return to_route('admin.cities.index');
    }
}
