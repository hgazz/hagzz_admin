<?php

namespace App\Http\Controllers;

use App\DataTables\SportDataTable;
use App\Http\Requests\SportRequest;
use App\Http\Traits\FileUpload;
use App\Models\Academies;
use App\Models\Sport;
use App\Services\TranslatableService;


class SportController extends Controller
{
    use FileUpload;
    private $sportModel;
    public function __construct(Sport $sportModel)
    {
        $this->sportModel = $sportModel;
    }

    public function index(SportDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.sport.index');
    }
    public function create()
    {
        $roles = ['beginner', 'intermediate', 'advanced'];
        return view('Admin.pages.sport.create',compact('roles'));
    }
    public function store(SportRequest $request)
    {
        $imageName =  $this->upload($request->file('icon') , $this->sportModel::PATH );
        $translatable = TranslatableService::generateTranslatableFields($this->sportModel::getTranslatableFields() , $request->validated());
        $this->sportModel->create(array_merge($translatable , [
            'icon'=>$imageName,
            'level'=>$request->level,
        ]));
        session()->flash('success','Successfully created');
        return to_route('admin.sport.index');
    }
    public function edit(Sport $sport)
    {
        $roles = ['beginner', 'intermediate', 'advanced'];
        return view('Admin.pages.sport.edit', compact('roles','sport'));
    }
    public function update(Sport $sport , SportRequest $request)
    {
        $imageName = $request->hasFile('icon') ? $this->upload($request->file('icon') , $this->sportModel::PATH,  $sport->getRawOriginal('icon')) : $sport->getRawOriginal('icon');
        $translatable = TranslatableService::generateTranslatableFields($this->sportModel::getTranslatableFields() , $request->validated());
        $sport->update(array_merge($translatable,[
            'icon'=>$imageName,
            'level'=> $request->level
        ]));
        session()->flash('success','Successfully Updated');
        return to_route('admin.sport.index');
    }

    public function updateStatus(Sport $sport)
    {
        if ($sport->status == 'active'){
            $newStatus = 'inactive';
            $successMessage = trans('admin.sport.status_inactive_successfully');
        } else {
            $newStatus = 'active';
            $successMessage = trans('admin.sport.status_active_successfully');
        }

        $sport->update([
            'status' => $newStatus,
        ]);

        session()->flash('success', $successMessage);
        return redirect()->route('admin.sport.index');
    }
    public function delete(Sport $sport)
    {
        $sport->delete();
        $this->deleteFile($this->sportModel::PATH . $sport->getRawOriginal('icon'));
        session()->flash('success', trans('admin.banners.deleted_successfully'));
        return to_route('admin.sport.index');
    }
}
