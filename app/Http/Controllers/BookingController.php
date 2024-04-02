<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Exports\InvoiceExport;
use App\Models\Invoice;
use Maatwebsite\Excel\Facades\Excel;


class BookingController extends Controller
{
    public function index(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.booking.index');
    }

    public function cancelBooking(Invoice $invoice)
    {
        $invoice->update([
            'is_canceled' => true
        ]);
        session()->flash('success', __('admin.bookings.booking cancelled successfully'));
        return back();
    }

    public function export()
    {
        return Excel::download(new InvoiceExport(),'invoice.xlsx');
    }
}
