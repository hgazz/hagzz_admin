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
        $remember_me = $request->has('remember') ? true : false;
        $credentials = $request->only('email', 'password');
        if (auth()->guard('admin')->attempt($credentials, $remember_me)) {
            if (isset($remember_me) && ! empty($remember_me)){
                setcookie('email', $request->email, time() + (60 * 60 * 24 * 30), "/");
                setcookie('password', $request->password, time() + (60 * 60 * 24 * 30), "/");
            }
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
