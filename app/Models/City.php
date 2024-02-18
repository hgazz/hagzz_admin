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
    protected $fillable = ['name'];


    /**
     * Get the areas associated with the city.
     *
     * @return HasMany
     */
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'city_id', 'id');
    }
}
