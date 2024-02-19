<?php

namespace App\Http\Controllers;

use App\DataTables\SportDataTable;
use App\Http\Requests\SportRequest;
use App\Http\Traits\FileUpload;
use App\Models\Sport;
use App\Services\TranslatableService;
use Illuminate\Http\Request;

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
        return view('admin.pages.sport.create',compact('roles'));
    }
    public function store(SportRequest $request)
    {
        $imageName =  $this->upload($request->file('icon') , $this->sportModel::PATH );
        $translatable = TranslatableService::generateTranslatableFields($this->sportModel::getTranslatableFields() , $request->validated());
        $this->sportModel->create(array_merge($translatable , [
            'icon'=>$imageName,
            'level'=>$request->level
        ]));
        session()->flash('success','Successfully created');
        return to_route('admin.sport.index');
    }
    public function edit(Sport $sport)
    {
        $roles = ['beginner', 'intermediate', 'advanced'];
        return view('admin.pages.sport.edit', compact('roles','sport'));
    }
    public function update(Sport $sport , SportRequest $request)
    {

    }
    public function delete(Sport $sport)
    {

    }
}
