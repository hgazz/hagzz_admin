<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Training extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
        'coach_id',
        'active',
        'sport_id',
        'academy_id',
        'level',
        'gender',
        'age_group',
        'address_id'
    ];

    public  $translatable = ['name','description'];

    public function coach()
    {
        return $this->belongsTo(Coach::class, 'coach_id');
    }

    public function bookings()
    {
        return $this->hasMany(Invoice::class , 'training_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function academy()
    {
        return $this->belongsTo(Academies::class,'academy_id');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class,'sport_id');
    }

    public function classes()
    {
        return $this->hasMany(TClass::class,'training_id');
    }

    public function joins()
    {
        return $this->hasMany(Join::class,'training_id');
    }
    public function getLevelAttribute($value)
    {
        return match ($value) {
            'Any_Level' => trans('admin.training.Any_Level'),
            'Beginner' => trans('admin.training.beginner'),
            'Intermediate' => trans('admin.training.intermediate'),
            'Advanced' => trans('admin.training.advanced'),
            default => 'Unknown',
        };
    }

    public function getGenderAttribute($value)
    {
        return match ($value) {
            'All' => trans('admin.training.all'),
            'Men' => trans('admin.training.men'),
            'Women' => trans('admin.training.women'),
            default => 'Unknown',
        };
    }

    public function getAgeGroupAttribute($value)
    {
        return match ($value) {
            'All' => trans('admin.training.all'),
            'Kids' => trans('admin.training.kids'),
            'Juniors' => trans('admin.training.juniors'),
            'Adults' => trans('admin.training.adults'),
            default => 'Unknown',
        };
    }
}
