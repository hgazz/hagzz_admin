<?php

namespace App\Http\Controllers;

use App\DataTables\BannerDataTable;
use App\Http\Requests\Banner\BannerRequest;
use App\Http\Traits\FileUpload;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use FileUpload;
    private $bannerModel;

    public function __construct(Banner $banner)
    {
        $this->bannerModel = $banner;
    }

    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.banners.index');
    }

    public function create()
    {
        return view('Admin.pages.banners.create');
    }

    public function store(BannerRequest $request)
    {
        $image = $this->upload($request->file('image'), $this->bannerModel::PATH);
        $this->bannerModel->create([
            'logo' => $image,
        ]);
        session()->flash('success', trans('admin.banners.created_successfully'));
        return to_route('admin.banners.index');
    }

    public function edit(Banner$banner)
    {
        return view('Admin.pages.banners.edit', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $image = $this->upload($request->file('image'), $this->bannerModel::PATH, $banner->getRawOriginal('logo'));
        $banner->update([
            'logo' => $image,
        ]);
        session()->flash('success', trans('admin.banners.updated_successfully'));
        return to_route('admin.banners.index');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        $this->deleteFile($this->bannerModel::PATH . $banner->getRawOriginal('logo'));
        session()->flash('success', trans('admin.banners.deleted_successfully'));
        return to_route('admin.banners.index');
    }
}
