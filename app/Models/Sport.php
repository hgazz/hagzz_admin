<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Sport extends Model
{
    use HasFactory, HasTranslations;

    const  PATH = 'images/sports/';
    public function getLogoAttribute($value)
    {
        return  config('services.s3.url'). DIRECTORY_SEPARATOR . self::PATH . $value;
    }
    public $translatable = ['name'];
    protected $fillable = [
            'name',
            'icon',
            'status',
            'level',
    ];
    public static $translatableColumns = [
        'name'=>[
            'type'=>'text',
            'validations'=>'required|string|max:255',
            'is_textarea'=>false
        ]
    ];

    public static function getTranslatableFields()
    {
        return array_keys(self::$translatableColumns);
    }

    public function academy()
    {
        return $this->belongsTo(Academies::class,'academy_id');
    }
}
