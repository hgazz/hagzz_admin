<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    const PATH = 'images/gallery';
    protected $fillable = [
        'image',
        'academy_id',
        'active'
    ];

    public function academy()
    {
        return $this->belongsTo(Academies::class);
    }

    public function getImageAttribute($value)
    {
        return rtrim(config('services.storage.url'), '/') . '/' . self::PATH . '/' . ltrim($value, '/');
    }
}
