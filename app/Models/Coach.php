<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Coach extends Model
{
    use HasFactory, HasTranslations;


    public $translatable = [
        'name',
        'description',
        'license',
        'license_type',
    ];

    const PATH = 'images/coaches';
    protected $fillable = [
        'name',
        'description',
        'image',
        'active',
        'academy_id',
        'license',
        'license_type',
        'gender',
        'birth_date'
    ];

    public function academy()
    {
        return $this->belongsTo(Academies::class, 'academy_id', 'id');
    }

    public function getActiveAttribute($value)
    {
        return $value ? trans('admin.coaches.active') : trans('admin.coaches.inactive');
    }


    public function getImageAttribute($value)
    {
        return config('services.s3.url') . DIRECTORY_SEPARATOR . self::PATH . DIRECTORY_SEPARATOR . $value;
    }

    public function getGenderAttribute($value)
    {
        return $value ? trans('admin.user.male') : trans('admin.user.female');
    }
}
