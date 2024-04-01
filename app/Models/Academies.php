<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Academies extends Model
{
    use HasTranslations;

    public $translatable = ['commercial_name'];


    protected $fillable = [
        'email',
        'phone',
        'password',
        'status',
        'role',
        'commercial_name',
        'trade_license_number',
        'trade_license_expire_date',
        'tax_number',
        'percentage',
        'national_id_number',
        'address',
        'contract_number',
        'account_manager',
        'is_registered',
        'logo',
        'branch_to',
        'country_id',
        'city_id',
        'area_id',
    ];

    public static array $translatableColumns = [
        'commercial_name'=>[
            'type'=>'text',
            'is_textarea'=>false
        ]
    ];

    public static function getTranslatableFields()
    {
        return array_keys(self::$translatableColumns);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function sports()
    {
        return $this->belongsToMany(Sport::class,'academy_sport','academy_id','sport_id');
    }

    public function academy()
    {
        return $this->belongsTo(Academies::class , 'branch_to');
    }
}
