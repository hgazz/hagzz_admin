<?php

namespace App\Http\Controllers;

use App\DataTables\FaqDataTable;
use App\Http\Requests\Faq\FaqRequest;
use App\Models\Faq;
use App\Services\TranslatableService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private  $faqModel;
    public function __construct(Faq $faq)
    {
        $this->faqModel = $faq;
    }

    public function index(FaqDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.faqs.index');
    }

    public function create()
    {
        return view('admin.pages.faqs.create');
    }
    public function store(FaqRequest $request)
    {
        $translatable = TranslatableService::generateTranslatableFields($this->faqModel::getTranslatableFields() , $request->validated());
        $this->faqModel->create($translatable);
        session()->flash('success',trans('admin.faq.faq created successfully'));
        return to_route('admin.faq.index');
    }

    public function edit(Faq $faq)
    {
        return view('admin.pages.faqs.edit',compact('faq'));
    }

    public function update(Faq $faq , FaqRequest $request)
    {
        $translatable = TranslatableService::generateTranslatableFields($this->faqModel::getTranslatableFields() , $request->validated());
        $faq->update($translatable);
        session()->flash('success',trans('admin.faq.faq updated successfully'));
        return to_route('admin.faq.index');
    }
    public function delete(Faq $faq)
    {
        $faq->delete();
        session()->flash('success', trans('admin.faq.faq deleted successfully'));
        return to_route('admin.faq.index');
    }
}
