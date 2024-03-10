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

    }
}
