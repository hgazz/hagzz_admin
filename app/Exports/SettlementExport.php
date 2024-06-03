<?php

namespace App\Exports;

use App\Models\Settlement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SettlementExport implements FromView
{
    protected  $data = [];
    public function __construct($settlement)
    {
        $this->data = $settlement;
    }


    public function view(): View
    {
        return  view('Admin.pages.settlement.export',with(['settlements'=>$this->data]));
    }
}
