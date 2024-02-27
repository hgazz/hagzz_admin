<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];
    protected $fillable = ['name','country_id'];

    public static $translatableColumns = [
        'name'=>[
            'type'=>'text',
            'validations'=>'required|string|max:255|unique:cities,name',
            'is_textarea'=>false
        ]
    ];

    public static function getTranslatableFields()
    {
        return array_keys(self::$translatableColumns);
    }
    /**
     * Get the areas associated with the city.
     *
     * @return HasMany
     */
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'city_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
