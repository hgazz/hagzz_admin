<?php

namespace App\Http\Controllers;

use App\DataTables\AcademiesDataTable;
use App\Http\Requests\AcademiesRequest;
use App\Models\Academies;
use Illuminate\Http\Request;

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
        $this->academicModels->create($request->validated());
        session()->flash('success', trans('admin.academies.academies_created_successfully'));
        return to_route('admin.academies.index');
    }

    public function updateStatus(Academies $academies)
    {
        if ($academies->status == 'active'){
            $academies->update([
                'status'=> 'inactive',
            ]);
            session()->flash('success',trans('admin.academies.status inactive_successfully'));
            return to_route('admin.academies.index');
        }
        $academies->update([
            'status'=> 'active',
        ]);
        session()->flash('success',trans('admin.academies.status active successfully'));
        return to_route('admin.academies.index');
    }
    public function edit(Academies $academies)
    {
        $roles = ['manager', 'owner', 'partner'];
        return view('Admin.pages.academies.edit',compact('academies','roles'));
    }

    public function update(Academies $academies , AcademiesRequest $request)
    {
        $academies->update($request->validated());
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
