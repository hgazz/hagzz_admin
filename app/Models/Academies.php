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
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getCurrencyCodeAttribute(): string
    {
        if ($this->country_id) {
            $country = $this->relationLoaded('country') ? $this->country : Country::find($this->country_id);
            if ($country && !empty($country->currency_code)) {
                return strtoupper($country->currency_code);
            }
        }
        return 'SAR';
    }

    public function getCurrencySymbolAttribute(): string
    {
        $code = $this->currency_code;
        $ar = app()->getLocale() === 'ar';

        return match ($code) {
            'EGP' => $ar ? 'ج.م' : 'EGP',
            'QAR' => $ar ? 'ر.ق' : 'QAR',
            'EUR' => '€',
            'USD' => '$',
            'AED' => $ar ? 'د.إ' : 'AED',
            'BHD' => $ar ? 'د.ب' : 'BHD',
            'KWD' => $ar ? 'د.ك' : 'KWD',
            'OMR' => $ar ? 'ر.ع' : 'OMR',
            default => $ar ? 'ر.س' : 'SAR',
        };
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

    public function users()
    {
        return $this->hasMany(PartnerUser::class, 'academy_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(PartnerActivityLog::class, 'academy_id')->latest();
    }

    public function branches()
    {
        return $this->hasMany(Academies::class, 'branch_to');
    }

    public function parentAcademy()
    {
        return $this->belongsTo(Academies::class, 'branch_to');
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

    public function subscriptionInvoices()
    {
        return $this->hasMany(TenantSubscriptionInvoice::class, 'academy_id');
    }
}
