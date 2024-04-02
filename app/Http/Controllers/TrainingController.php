<?php

namespace App\Http\Controllers;

use App\DataTables\TrainingDataTable;
use App\Exports\TrainingExport;
use App\Models\Training;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    public function index(TrainingDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.training.index');
    }

    public function updateTrainingStatus(Training $training)
    {
        $training->update(['active' => ! $training->active]);
        return back()->with('success', __('admin.training.Training Status Updated'));
    }

    public function export()
    {
        return Excel::download(new TrainingExport(),'training.xlsx');
    }
}
