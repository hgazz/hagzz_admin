<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ["id","title", "details", "notifiable_type", "notifiable_id"];



    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
    protected $casts = [
        'details' => 'array',
    ];

}
