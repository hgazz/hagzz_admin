<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userModel;
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.users.index');
    }

    public function show(User $user)
    {
       $showUser =  $user->with(['joins.training.coach','sports.academy'])->findOrFail($user->id);
      return view('Admin.pages.users.show',compact('showUser'));
    }

    public function delete(Request $request)
    {
        $country = $this->userModel->findOrFail($request->id);
        $country->delete();
        return response()->json(['data' => [
            'status' => 'success',
            'model'   => trans('admin.user.user'),
            'message' => trans('admin.user.User deleted successfully'),
        ]]);
    }
}
