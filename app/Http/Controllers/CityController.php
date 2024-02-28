<?php

namespace App\Http\Controllers;

use App\DataTables\CityDataTable;
use App\Http\Requests\City\CityRequest;
use App\Http\Traits\CountryTrait;
use App\Models\City;
use App\Services\TranslatableService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use  CountryTrait;
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
        $countries = $this->getCountry();
        return view('Admin.pages.city.create',compact('countries'));
    }

    public function store(CityRequest $request)
    {
        $translatableFields = TranslatableService::generateTranslatableFields($this->cityModel->getTranslatableFields(), $request->validated());
        $this->cityModel->create(array_merge($translatableFields, [
            'country_id' => $request->country_id
        ]));
        session()->flash('success',trans('admin.city.created_successfully'));
        return to_route('admin.cities.index');
    }

    public function edit(City $city)
    {
        $countries = $this->getCountry();
        return view('Admin.pages.city.edit',compact('city' , 'countries'));
    }

    public function update(CityRequest $request, City $city)
    {
        $translatableFields = TranslatableService::generateTranslatableFields($this->cityModel->getTranslatableFields(), $request->validated());
        $city->update($translatableFields + ['country_id' => $request->country_id]);
        session()->flash('success',trans('admin.city.updated_successfully'));
        return to_route('admin.cities.index');
    }

    public function destroy(Request $request)
    {
        $city = $this->cityModel->findOrFail($request->id);
        $city->delete();
        return response()->json(['data' => [
            'status' => 'success',
            'model'   => trans('admin.city.city'),
            'message' => trans('admin.city.deleted_successfully'),
        ]]);
    }
}
