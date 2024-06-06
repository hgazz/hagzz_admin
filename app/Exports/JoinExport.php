<?php

namespace App\Exports;

use App\Models\Join;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class JoinExport implements FromView
{
    protected $joins;

    public function __construct()
    {
        $joinsData = session('joinsData', []);
        if (!empty($joinsData) && count($joinsData) > 0) {
            $this->joins = $joinsData;
        } else {
            $joins = Join::get();
            $this->joins = $joins;
        }
    }


    public function view(): View
    {
       return  view('Admin.pages.joins.export',with(['joins' => $this->joins]));
    }
}
