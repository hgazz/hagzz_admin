<?php

namespace App\Http\Traits;

use App\Models\Country;

trait CountryTrait
{
    private function getCountry()
    {
        return Country::get(['id','name']);
    }
}
