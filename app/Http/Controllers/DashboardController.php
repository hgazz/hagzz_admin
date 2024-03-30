<?php

namespace App\Http\Controllers;

use App\Models\Academies;
use App\Models\Invoice;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = Invoice::sum('amount');
        $users = User::count();
        $academies = Academies::count();
        $sports = Sport::count();
        return view('Admin.index', get_defined_vars());
    }
}
