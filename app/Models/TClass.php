<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TClass extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['title', 'subtitle'];

    protected $fillable = [
        'title',
        'subtitle',
        'date',
        'start_time',
        'end_time',
        'training_id',
        'out_comes',
        'bring_with_me'
    ];

}
