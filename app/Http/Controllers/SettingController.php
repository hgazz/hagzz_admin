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
        $types = ['text', 'image', 'textarea'];
        $keys = [
            'logo',
            'phone',
            'whatsapp',
            'about',
            'email',
            'facebook',
            'twitter',
            'instagram',
            'telegram',
            'address',
            'snapchat',
            'youtube',
            'terms',
            'privacy'
        ];
        return view('Admin.pages.setting.create',compact('types', 'keys'));
    }

    public function store(SettingRequest $request)
    {
       $value = $this->getValueBasedOnType($request);
       $this->settingModel->create([
           'key' => $request->key,
           'type' =>$request->type,
           'value' => $value
       ]);
       session()->flash('success', trans('admin.setting.created_successfully'));
      return to_route('admin.setting.index');
    }

    public function edit(Setting $setting)
    {
        $types = ['text', 'image', 'textarea'];
        $keys = [
            'logo',
            'phone',
            'whatsapp',
            'about',
            'email',
            'facebook',
            'twitter',
            'instagram',
            'telegram',
            'address',
            'snapchat',
            'youtube',
            'terms',
            'privacy'
        ];
        return view('Admin.pages.setting.edit',compact('setting','types', 'keys'));
    }

    public function update(Setting $setting , SettingRequest $request)
    {
        $value = $this->getValueBasedOnType($request);
            $setting->update([
               'key' => $request->key,
                'value' => $value ,
                'type'=>$request->type
            ]);
        session()->flash('success','successfully Updated');
        return to_route('admin.setting.index');
    }

    public function delete(Request $request)
    {
        $setting = $this->settingModel->findOrFail($request->id);
        $setting->delete();
        if ($setting->type == 'image'){
            $this->deleteFile($this->settingModel::PATH . $setting->getRawOriginal('value'));
        }
        session()->flash('success', trans('admin.setting.'));
        return response()->json(['data' => [
            'status' => 'success',
            'model'   => trans('admin.setting.setting'),
            'message' => trans('admin.setting.deleted_successfully'),
        ]]);
    }

    private function getValueBasedOnType(Request $request)
    {
        return match ($request->type) {
            'image' => $this->upload($request->image_value, $this->settingModel::PATH),
            'text' => $request->value,
            'textarea' => $request->text_value,
            default => null,
        };
    }
}
