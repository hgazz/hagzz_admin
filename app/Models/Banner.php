<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    const PATH = 'images/banners/';
    protected $fillable = [
        'logo',
        'status',
        'country'
    ];

    public function getLogoAttribute($value)
    {
        if (blank($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        $path = str_starts_with($value, self::PATH)
            ? $value
            : self::PATH . ltrim($value, '/');

        return rtrim(config('services.s3.url'), '/') . '/' . $path;
    }
}
