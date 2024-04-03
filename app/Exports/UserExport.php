<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{

    public function view(): View
    {
        $users = User::with(['country','city','area'])->get();
        return  view('Admin.pages.users.export',compact('users'));
    }
}
