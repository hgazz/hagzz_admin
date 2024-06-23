<?php

namespace App\Http\Controllers;

use App\DataTables\AcademiesDataTable;
use App\DataTables\AddressDataTable;
use App\DataTables\CoachDataTable;
use App\Exports\AcademiesExport;
use App\Http\Requests\Academies\AcademiesRequest;
use App\Http\Traits\FileUpload;
use App\Models\Academies;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Sport;
use App\Services\TranslatableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AcademiesController extends Controller
{
    use FileUpload;
    private $academicModels, $sportModel, $countryModel, $cityModel, $areaModel;
    public function __construct(Academies $model, Sport $sport, Country $country, City $city, Area $area)
    {
        $this->academicModels = $model;
        $this->sportModel = $sport;
        $this->countryModel = $country;
        $this->cityModel = $city;
        $this->areaModel = $area;
    }

    public function index(AcademiesDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.academies.index');
    }

    public function create()
    {
        $roles = ['manager', 'owner', 'partner'];
        $sports = $this->sportModel::get(['id', 'name']);
        $allAcademies = $this->academicModels->where('branch_to', null)->get(['id','commercial_name']);
        $countries = $this->countryModel->get(['id', 'name']);
        $cities = $this->cityModel->get(['id', 'name']);
        $areas = $this->areaModel->get(['id', 'name']);
        return view('Admin.pages.academies.create',get_defined_vars());
    }

    public function store(AcademiesRequest $request)
    {
        try {
            DB::beginTransaction();
            $imageName =  $request->hasFile('image') ? $this->upload($request->file('image') , $this->academicModels::PATH ) : null;
            $translatableFields = TranslatableService::generateTranslatableFields($this->academicModels->getTranslatableFields(), $request->validated());
            $academy = $this->academicModels->create($translatableFields + [
                    'password'=> Hash::make($request->password),
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' => $request->role,
                    'trade_license_number' => $request->trade_license_number,
                    'trade_license_expire_date' => $request->trade_license_expire_date,
                    'tax_number' => $request->tax_number,
                    'contract_number' => $request->contract_number,
                    'account_manager' => $request->account_manager,
                    'is_registered'=>$request->has('is_registered') ? 1 :0,
                    'branch_to'=>$request->branch_to,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'facebook'=>$request->facebook,
                    'instagram'=>$request->instagram,
                    'website'=>$request->website,
                    'linkedin'=>$request->linkedin,
                    'contract_date'=>$request->contract_date,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                    'logo'=>$imageName,
                    'bank_account_type'=>$request->bank_account_type,
                    'bank_name'=>$request->bank_name,
                    'beneficiary_name'=>$request->beneficiary_name,
                    'commission_percentage'=>$request->commission_percentage,
                    'bank_account_number'=>$request->bank_account_number,
                    'name'=>$request->name,
                    'status' => $request->status,
                    'settlement_days_count' => $request->settlement_days_count,
                    'non_refund_days_count' => $request->non_refund_days_count,
                    'contract_link'=>$request->contract_link,

                ]);
            $academy->sports()->attach($request->sport_id);
            DB::commit();
            session()->flash('success', trans('admin.academies.academies_created_successfully'));
            return to_route('admin.academies.index');
        }catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return back();
        }
    }

    public function updateStatus(Academies $academies)
    {
        if ($academies->status == 'active'){
            $newStatus = 'inactive';
            $successMessage = trans('admin.academies.status_inactive_successfully');
        } else {
            $newStatus = 'active';
            $successMessage = trans('admin.academies.status_active_successfully');
        }

        $academies->update([
            'status' => $newStatus,
        ]);

        session()->flash('success', $successMessage);
        return redirect()->route('admin.academies.index');
    }
    public function edit(Academies $academies)
    {
        $roles = ['manager', 'owner', 'partner'];
        $sports = $this->sportModel->get(['id','name']);
        $allAcademies = $this->academicModels->where('id','!=',$academies->id)->get(['id','commercial_name']);
        $countries = $this->countryModel->get(['id', 'name']);
        $cities = $this->cityModel->get(['id', 'name']);
        $areas = $this->areaModel->get(['id', 'name']);
        return view('Admin.pages.academies.edit', get_defined_vars());
    }

    public function update(Academies $academies , AcademiesRequest $request)
    {
        DB::transaction(function () use ($academies, $request) {
            $imageName = $request->hasFile('image') ? $this->upload($request->file('image') , $this->academicModels::PATH,  $academies->getRawOriginal('image')) : $academies->getRawOriginal('icon');
            $translatableFields = TranslatableService::generateTranslatableFields($this->academicModels->getTranslatableFields(), $request->validated());
            $academies->update($translatableFields + [
                'password'=> !is_null($request->password) ? Hash::make($request->password) : $academies->password,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' => $request->role,
                    'trade_license_number' => $request->trade_license_number,
                    'trade_license_expire_date' => $request->trade_license_expire_date,
                    'tax_number' => $request->tax_number,
                    'contract_number' => $request->contract_number,
                    'account_manager' => $request->account_manager,
                    'is_registered'=>$request->has('is_registered') ? 1 :0,
                    'branch_to'=>$request->branch_to,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'facebook'=>$request->facebook,
                    'instagram'=>$request->instagram,
                    'website'=>$request->website,
                    'linkedin'=>$request->linkedin,
                    'contract_date'=>$request->contract_date,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                    'logo'=>$imageName,
                    'bank_account_type'=>$request->bank_account_type,
                    'bank_name'=>$request->bank_name,
                    'beneficiary_name'=>$request->beneficiary_name,
                    'commission_percentage'=>$request->commission_percentage,
                    'bank_account_number'=>$request->bank_account_number,
                    'name'=>$request->name,
                    'status' => $request->status,
                    'settlement_days_count' => $request->settlement_days_count,
                    'non_refund_days_count' => $request->non_refund_days_count,
                    'contract_link' => $request->contract_link,
            ]);
            $academies->sports()->sync($request->sport_id);
            session()->flash('success',trans('admin.academies.academies_updated_successfully'));

        });
        return to_route('admin.academies.index');
    }

    public function delete(Request $request)
    {
        $academies = $this->academicModels->findOrFail($request->id);
        $academies->delete();
        $academies->sports()->detach($request->id);
        return response()->json(['data' => [
            'status' => 'success',
            'model'   => trans('admin.academies.academies'),
            'message' => trans('admin.academies.academies deleted successfully'),
        ]]);
    }

    public function getAreaByCity($city)
    {
        $city = $this->cityModel::findOrFail($city);
        $areas = $this->areaModel::where('city_id', $city->id)->get();
        return response()->json($areas);
    }

    public function getAllCountry($country)
    {
        $country = $this->countryModel::findOrFail($country);
        $cities = $this->cityModel::where('country_id', $country->id)->get();
        return response()->json($cities);
    }

    public function show(Academies $academies)
    {
        return view('Admin.pages.academies.show',compact('academies'));
    }

    public function export()
    {
        return Excel::download(new AcademiesExport(),'academies.xlsx');
    }

    public function partnerLocation(AddressDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.partnerLocation.index');
    }

    public function partnerCoach(CoachDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.partnerLocation.coaches');
    }
}
