<?php

namespace App\Http\Controllers;

use App\DataTables\TrainingDataTable;
use App\Models\Training;

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
}
