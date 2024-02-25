<?php

namespace App\Http\Controllers;

use App\DataTables\AcademiesDataTable;
use App\Http\Requests\Academies\AcademiesRequest;
use App\Models\Academies;
use Illuminate\Support\Facades\Hash;

class AcademiesController extends Controller
{
    private $academicModels;
    public function __construct(Academies $models)
    {
        $this->academicModels = $models;
    }

    public function index(AcademiesDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.academies.index');
    }

    public function create()
    {
        $roles = ['manager', 'owner', 'partner'];
        return view('Admin.pages.academies.create',compact('roles'));
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
        return view('Admin.pages.academies.edit',compact('academies','roles'));
    }

    public function update(Academies $academies , AcademiesRequest $request)
    {
        $academies->update(array_merge($request->validated(),[
            'password'=> Hash::make($request->password),
            'is_registered'=>$request->has('is_registered') ? 1 : 0,
        ]));
        session()->flash('success',trans('admin.academies.academies updated successfully'));
        return to_route('admin.academies.index');
    }

    public function delete(Academies $academies)
    {
        $academies->delete();
        session()->flash('success',trans('admin.academies.academies deleted successfully'));
        return to_route('admin.academies.index');
    }
}
