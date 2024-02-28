<?php

namespace App\Http\Controllers;

use App\DataTables\AcademiesDataTable;
use App\Http\Requests\Academies\AcademiesRequest;
use App\Models\Academies;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AcademiesController extends Controller
{
    private $academicModels, $sportModel;
    public function __construct(Academies $model, Sport $sport)
    {
        $this->academicModels = $model;
        $this->sportModel = $sport;
    }

    public function index(AcademiesDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.academies.index');
    }

    public function create()
    {
        $roles = ['manager', 'owner', 'partner'];
        $sports = $this->sportModel::get(['id', 'name']);
        return view('Admin.pages.academies.create',compact('roles', 'sports'));
    }

    public function store(AcademiesRequest $request)
    {
        $this->academicModels->create(array_merge($request->validated(),[
            'password'=> Hash::make($request->password),
            'is_registered'=>$request->has('is_registered') ? 1 :0,
        ]));
        session()->flash('success', trans('admin.academies.academies_created_successfully'));
        return to_route('admin.academies.index');
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
        return view('Admin.pages.academies.edit',compact('academies','roles', 'sports'));
    }

    public function update(Academies $academies , AcademiesRequest $request)
    {

        DB::transaction(function () use ($academies, $request) {
            $academies->update(array_merge($request->validated(),[
                'password'=> !is_null($request->password) ? Hash::make($request->password) : $academies->password,
                'is_registered'=>$request->has('is_registered') ? 1 : 0,
            ]));
            $academies->sports()->sync($request->sport_id);
            session()->flash('success',trans('admin.academies.academies updated successfully'));

        });
        return to_route('admin.academies.index');
    }

    public function delete(Request $request)
    {
        $academies = $this->academicModels->find($request->id);
        $academies->delete();

        return response()->json(['data' => [
            'status' => 'success',
            'model'   => trans('admin.academies.academies'),
            'message' => trans('admin.academies.academies deleted successfully'),
        ]]);
    }
}
