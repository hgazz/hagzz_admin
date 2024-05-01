<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Academies extends Model
{
    use HasTranslations;

    const  PATH = 'images/academies';
    public function getImageAttribute($value)
    {
        return config('services.s3.url') . DIRECTORY_SEPARATOR . self::PATH . DIRECTORY_SEPARATOR . $value;
    }

    public $translatable = ['commercial_name','app_name'];


    protected $guarded = [];

    public static array $translatableColumns = [
        'commercial_name'=>[
            'type'=>'text',
            'is_textarea'=>false
        ],
        'app_name'=>[
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
