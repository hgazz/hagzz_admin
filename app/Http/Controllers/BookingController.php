<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Exports\InvoiceExport;
use App\Models\Invoice;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.booking.index');
    }

    public function cancelBooking(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);
        $invoice->update([
            'is_canceled' => true
        ]);

        return response()->json(['data' => [
            'status' => 'success',
            'model'   => trans('admin.bookings.bookings'),
            'message' => trans('admin.bookings.booking cancelled successfully'),
        ]]);
    }


}
