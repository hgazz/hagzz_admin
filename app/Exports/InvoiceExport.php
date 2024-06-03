<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{

    protected  $data;

    public function __construct($invoices)
    {
        $this->data = $invoices;
    }

    public function view(): View
    {
        return view('Admin.pages.booking.export',with(['invoices'=>$this->data]));
    }
}
