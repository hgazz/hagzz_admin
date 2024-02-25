<?php

namespace App\Http\Controllers;

use App\DataTables\CountryDataTable;
use App\Http\Requests\Country\CountryRequest;
use App\Models\Country;
use App\Services\TranslatableService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
   private $countryModel;
   public function __construct(Country $country)
   {
       $this->countryModel = $country;
   }

   public function index(CountryDataTable $dataTable)
   {
       return $dataTable->render('Admin.pages.country.index');
   }

    public function create()
    {
        return view('admin.pages.country.create');
    }

    public function store(CountryRequest $request)
    {
      $translatable = TranslatableService::generateTranslatableFields($this->countryModel::getTranslatableFields() , $request->validated());
      $this->countryModel->create($translatable);
      session()->flash('success', trans('admin.county.Country created successfully'));
      return to_route('admin.country.index');
    }

    public function edit(Country $country)
    {
        return view('admin.pages.country.edit',compact('country'));
    }

    public function update(Country $country , CountryRequest $request)
    {
        $translatable = TranslatableService::generateTranslatableFields($this->countryModel::getTranslatableFields() , $request->validated());
        $country->update($translatable);
        session()->flash('success', trans('admin.county.Country updated successfully'));
        return to_route('admin.country.index');
    }

    public function delete(Country $country)
    {
        $country->delete();
        session()->flash('success', trans('admin.country.Country deleted successfully'));
        return to_route('admin.country.index');
    }
}
