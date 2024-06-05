<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{

    protected  $data;

    public function __construct()
    {
        $invoiceData = session('invoiceData', []);
        $invoices = Invoice::with(['training','user'])->get();
        if (!empty($invoiceData) && count($invoiceData) > 0){
            $this->data = $invoiceData;
        }else{
            $this->data = $invoices;
        }
    }

    public function view(): View
    {
        return view('Admin.pages.booking.export',with(['invoices'=>$this->data]));
    }
}
