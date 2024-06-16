<?php

namespace App\Http\Controllers;

use App\DataTables\GalleryDataTable;
use App\Models\Gallery;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

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

    public function bulkActive(Request $request)
    {
        foreach (json_decode($request->ids) as $id) {
            $gallery = Gallery::findOrFail($id);
            $gallery->update([
                'active' => 1,
            ]);
        }
        session()->flash('success', trans('admin.gallery.status_updated_successfully'));
        return back();
    }
}
