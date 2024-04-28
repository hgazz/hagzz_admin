<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory,HasTranslations;
    protected  $fillable = ['question','answer'];
    protected $translatable = ['question','answer'];
    public static $translatableColumns = [
        'question'=>[
            'type'=>'text',
            'validations'=>'required|string|max:255',
            'is_textarea'=>false
        ],
    ];

    public static function getTranslatableFields()
    {
        return array_keys(self::$translatableColumns);
    }
}
