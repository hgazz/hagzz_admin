<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ["title","details","notifiable_type"];


    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'notificationable');
    }


}
