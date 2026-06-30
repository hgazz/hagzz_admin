<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = ['name', 'iso2', 'currency_code'];
    protected $translatable = ['name'];
    public static $translatableColumns = [
        'name'=>[
            'type'=>'text',
            'is_textarea'=>false
        ],
    ];
    public static function getTranslatableFields()
    {
        return array_keys(self::$translatableColumns);
    }

    public function cities()
    {
        return $this->hasMany(City::class , 'county_id','id');
    }

    public function saasPlanPrices() { return $this->hasMany(SaasPlanPrice::class); }
}
