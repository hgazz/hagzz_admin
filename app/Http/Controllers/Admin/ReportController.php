<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CoachDataTable;
use App\DataTables\InvoiceDataTable;
use App\DataTables\JoinDataTable;
use App\DataTables\SettlementDataTable;
use App\Exports\CoachExport;
use App\Exports\InvoiceExport;
use App\Exports\JoinExport;
use App\Exports\SettlementExport;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Invoice;
use App\Models\Join;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    protected array $settlementData = [];
    public function settlement(SettlementDataTable $dataTable )
    {

        return $dataTable->render('Admin.pages.settlement.index');
    }

    public function filter(Request $request, SettlementDataTable $dataTable)
    {

        $query = Settlement::query();


        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('created_at', [$startDate, $endDate]);

            $settlement = $query->get();

            session(['settlementData' => $settlement]);
        }

        return $dataTable->with('query', $query)->render('Admin.pages.settlement.index');
    }

    public function export()
    {

        return Excel::download(new SettlementExport(),'settlement.xlsx');
    }


    public function invoice(Request $request, InvoiceDataTable $dataTable)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $booking = Invoice::whereBetween('created_at', [$startDate, $endDate]);
            $invoiceData = $booking->get();

            session(['invoiceData' => $invoiceData]);
            return $dataTable->with('query', $booking)->render('Admin.pages.booking.index');
        }

        return $dataTable->render('Admin.pages.booking.index');
    }

    public function bookingExport()
    {
            return Excel::download(new InvoiceExport(), 'invoice.xlsx');
    }

    public function joins(JoinDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.joins.index');
    }

    public function joinFilter(Request $request , JoinDataTable $dataTable)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $joins = Join::whereBetween('created_at', [$startDate, $endDate]);

            $joinsData = $joins->get();

            session(['joinsData' => $joinsData]);
            return $dataTable->with('query', $joins)->render('Admin.pages.joins.index');
        }

        return $dataTable->render('Admin.pages.joins.index');
    }

    public function joinExport()
    {
        return Excel::download(new JoinExport(), 'booking.xlsx');
    }

    public function coach(CoachDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.partnerLocation.coaches');
    }

    public function coachFilter(Request $request , CoachDataTable $dataTable)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $coaches = Coach::whereBetween('created_at', [$startDate, $endDate]);

            $coachesData = $coaches->get();

            session(['coachesData' => $coachesData]);
            return $dataTable->with('query', $coaches)->render('Admin.pages.partnerLocation.coaches');
        }

        return $dataTable->render('Admin.pages.partnerLocation.coaches');
    }

    public function coachExport()
    {
        $coachesData = session('coachesData', []);
        if (!empty($coachesData) && count($coachesData) > 0) {
            return Excel::download(new CoachExport($coachesData), 'coaches.xlsx');
        } else {
            $coaches = Coach::get();
            return Excel::download(new CoachExport($coaches), 'coaches.xlsx');
        }
    }

    public function change(Settlement $settlement)
    {
        $settlement->update(['status'=> "settled"]);
        session()->flash('success','Settlement Status updated successfully');
        return back();
    }
}
