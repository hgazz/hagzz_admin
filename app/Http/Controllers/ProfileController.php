<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $adminModel;
    public function __construct(Admin $admin)
    {
        $this->adminModel = $admin;
    }

    public function index()
    {
        $admin = $this->adminModel->where('id',auth('admin')->id())->first();
        return view('Admin.pages.profile.profile',compact('admin'));
    }

    public function update($id , ProfileRequest $request)
    {
        $admin = $this->adminModel->findOrFail($id);
        $admin->update($request->validated());
        session()->flash('success',trans('admin.profile.profile updated successfully'));
        return back();
    }
}
