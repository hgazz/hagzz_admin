<?php

namespace App\Exports;

use App\Models\Coach;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CoachExport implements FromView
{

    private $coaches;
    public function __construct($coaches)
    {
        $this->coaches = $coaches;
    }

    public function view(): View
    {
       return  view('Admin.pages.partnerLocation.export',with(['coaches' => $this->coaches]));
    }
}
