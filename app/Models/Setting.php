<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value','type'];
    const PATH = 'images/setting/';

    public function getLogoAttribute($value)
    {
        return rtrim(config('services.storage.url'), '/') . '/' . self::PATH . ltrim($value, '/');
    }
}
