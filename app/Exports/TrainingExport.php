<?php

namespace App\Exports;

use App\Models\Training;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TrainingExport implements FromView
{
    public function view(): View
    {
        $trainings = Training::with(['coach','address','academy','sport'])->get();
        return  view('Admin.pages.training.export',compact('trainings'));
    }
}
