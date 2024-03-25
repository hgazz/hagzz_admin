<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = Invoice::sum('amount');
        $users = User::count();
        return view('Admin.index', get_defined_vars());
    }
}
