<?php

namespace App\Http\Traits;

use App\Models\City;

trait CitiesTrait
{
    private function getCities()
    {
        return City::get(['id','name']);
    }
}
