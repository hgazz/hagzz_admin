<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Academies extends Model
{
    use HasTranslations;

    const  PATH = 'images/academies';
    public function getImageAttribute($value): ?string
    {
        return $this->storageAsset($value ?: ($this->attributes['logo'] ?? null));
    }

    public function getLogoAttribute($value): ?string
    {
        return $this->storageAsset($value);
    }

    private function storageAsset(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        $path = str_starts_with(ltrim($value, '/'), self::PATH.'/')
            ? ltrim($value, '/')
            : self::PATH.'/'.ltrim($value, '/');

        return rtrim(config('services.storage.url'), '/').'/'.$path;
    }

    public $translatable = ['commercial_name','app_name'];


    protected $guarded = [];

    protected $casts = ['business_type' => 'string'];

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

    public function trainings()
    {
        return $this->hasMany(Training::class,'academy_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(TenantSubscription::class, 'academy_id');
    }

    public function currentSubscription()
    {
        return $this->hasOne(TenantSubscription::class, 'academy_id')->latestOfMany();
    }
}
