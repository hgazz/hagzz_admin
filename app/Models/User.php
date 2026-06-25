<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const PATH = 'images/users';

    public function getImageAttribute($value)
    {
        if (blank($value)) {
            return $this->defaultImageUrl();
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return rtrim(config('services.storage.url'), '/') . '/' . self::PATH . '/' . ltrim($value, '/');
    }

    public function defaultImageUrl(): string
    {
        $fileName = $this->getRawOriginal('gender') === 'female'
            ? 'default-user-female.webp'
            : 'default-user-male.webp';

        return asset('assetsAdmin/img/' . $fileName);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'gender',
        'birth_date',
        'image',
        'country_id',
        'city_id',
        'area_id',
        'language',
        'user_type',
        'country_code',
        'email',
        'child_type',
        'school_name',
        'parent_name',
        'parent_phone',
        'coach_preference',
        'frequent_attendance',
        'relation_with_child',
        'referral_source',
        'medical_condition',
        'medical_condition_details',
        'additional_information',
        'delivery_service',
        'club_member',
        'start_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function joins()
    {
        return $this->hasMany(Join::class, 'user_id');
    }

    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'user_sport', 'user_id', 'sport_id');
    }


    public function notifications(): MorphToMany
    {
        return $this->morphToMany(Notification::class, 'notificationable');
    }

    public function scopeVerificationStatus($query, $status)
    {
        return $query->where('is_verify', $status);
    }



}
