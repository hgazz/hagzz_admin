<?php

namespace App\Http\Controllers;

use App\DataTables\AcademiesDataTable;
use App\Http\Requests\AcademiesRequest;
use App\Models\Academies;
use Illuminate\Http\Request;

class AcademiesController extends Controller
{
    private $academicModels;
    public function __construct(Academies $models)
    {
        $this->academicModels = $models;
    }

    public function index(AcademiesDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.academies.index');
    }

    public function create()
    {
        return view('Admin.pages.academies.create');
    }

    public function store(AcademiesRequest $request)
    {

    }

    public function edit($academies)
    {

    }

    public function update($academies , AcademiesRequest $request)
    {

    }

    public function delete($academies)
    {

    }
}
