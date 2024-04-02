<?php

namespace App\Exports;

use App\Models\Academies;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class AcademiesExport implements FromView
{

    public function view(): View
    {
        $academies = Academies::with(['country','city','area','academy'])->get();
        return  view('Admin.pages.academies.export',compact('academies'));
    }
}
