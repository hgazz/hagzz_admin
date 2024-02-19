<?php

namespace App\Http\Controllers;

use App\DataTables\SettingDataTable;
use App\Http\Requests\SettingRequest;
use App\Http\Traits\FileUpload;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use  FileUpload;
    private $settingModel;
    public function __construct(Setting $setting)
    {
        $this->settingModel = $setting;
    }

    public function index(SettingDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.setting.index');
    }

    public function create()
    {
        $types = ['text', 'image'];
        return view('Admin.pages.setting.create',compact('types'));
    }

    public function store(SettingRequest $request)
    {

        ($request->type == 'image') ? $image =  $this->upload($request->file('value') , $this->settingModel::PATH ) : $value = $request->value;
       $this->settingModel->create([
           'value' => $image ?? $value,
           'key' => $request->key,
           'type' =>$request->type
       ]);
       session()->flash('success','successfully created');
      return to_route('admin.setting.index');
    }

    public function edit(Setting $setting)
    {
        $types = ['text', 'image'];
        return view('Admin.pages.setting.edit',compact('setting','types'));
    }

    public function update(Setting $setting , SettingRequest $request)
    {
       $value = ($request->type == 'image') ?  $request->hasFile('value') ?
            $this->upload($request->file('value') , $this->settingModel::PATH,  $setting->getRawOriginal('value')) : $setting->getRawOriginal('value') : $request->value;
            $setting->update([
               'key' => $request->key,
                'value' => $value ,
                'type'=>$request->type
            ]);
        session()->flash('success','successfully Updated');
        return to_route('admin.setting.index');
    }

    public function delete(Setting $setting)
    {
        $setting->delete();
        if ($setting->type == 'image'){
            $this->deleteFile($this->settingModel::PATH . $setting->getRawOriginal('value'));
        }
        session()->flash('success', trans('admin.banners.deleted_successfully'));
        return to_route('admin.setting.index');
    }
}
