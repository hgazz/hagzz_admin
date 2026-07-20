<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSubscription extends Model
{
    protected $guarded = [];
    protected $casts = [
        'starts_at'=>'date','ends_at'=>'date','trial_ends_at'=>'date','billing_starts_at'=>'date','next_billing_at'=>'date',
        'discount_starts_at'=>'date','discount_ends_at'=>'date','auto_renew'=>'boolean','custom_price'=>'decimal:2',
        'price_amount'=>'decimal:2','list_price_amount'=>'decimal:2','discount_value'=>'decimal:2',
        'tax_rate'=>'decimal:2','tax_included'=>'boolean',
    ];
    public function academy() { return $this->belongsTo(Academies::class, 'academy_id'); }
    public function plan() { return $this->belongsTo(SaasPlan::class, 'saas_plan_id'); }
    public function planPrice() { return $this->belongsTo(SaasPlanPrice::class, 'saas_plan_price_id'); }
    public function invoices() { return $this->hasMany(TenantSubscriptionInvoice::class, 'tenant_subscription_id'); }
}
