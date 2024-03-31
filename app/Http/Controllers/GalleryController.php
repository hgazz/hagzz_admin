<?php

namespace App\Http\Controllers;

use App\DataTables\GalleryDataTable;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(GalleryDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.gallery.index');
    }

    public function makeActive(Gallery $gallery)
    {
        $gallery->update(['active' => ! $gallery->active]);
        session()->flash('success', trans('admin.gallery.status_updated_successfully'));
        return back();
    }
}
