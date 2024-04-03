<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{

    public function view(): View
    {
        $invoices = Invoice::with(['training','user'])->get();
        return view('Admin.pages.booking.export',compact('invoices'));
    }
}
