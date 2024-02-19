<?php

namespace App\Http\Controllers;

use App\DataTables\BannerDataTable;
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

    public function store(Request $request)
    {

    }

    public function edit(Banner$banner)
    {
        return view('Admin.pages.banners.edit', compact('banner'));
    }


}
