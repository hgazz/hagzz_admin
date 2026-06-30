<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SaasPlan extends Model
{
    use HasTranslations;
    protected $guarded = [];
    public array $translatable = ['name'];
    protected $casts = ['features' => 'array', 'active' => 'boolean', 'monthly_price' => 'decimal:2', 'annual_price' => 'decimal:2'];
    public function subscriptions() { return $this->hasMany(TenantSubscription::class); }
}
