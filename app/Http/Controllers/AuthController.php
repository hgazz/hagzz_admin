<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('Admin.pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $remember_me = $request->has('remember');
        $credentials = $request->only('email', 'password');
        if (auth()->guard('admin')->attempt($credentials, true)) {
            return redirect(route('admin.index'));
        }
        return redirect()->back()->with(['error' => trans('admin.auth.invalid_email_or_password')])
            ->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        session()->invalidate();
        return redirect()->route('admin.loginPage');
    }
}
