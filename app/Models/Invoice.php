<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'training_id', 'order_number', 'status', 'amount', 'is_canceled', 'user_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function joins(): HasMany
    {
       return $this->hasMany(Join::class);
    }

    public function getStatusAttribute($value)
    {
        return match ($value) {
            'paid' => trans('admin.bookings.paid'),
            default => trans('admin.academies.pending'),
        };
    }
}
