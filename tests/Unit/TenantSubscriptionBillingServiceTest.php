<?php

namespace Tests\Unit;

use App\Models\TenantSubscription;
use App\Services\TenantSubscriptionBillingService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TenantSubscriptionBillingServiceTest extends TestCase
{
    public function test_percentage_offer_is_applied_only_inside_its_dates(): void
    {
        $subscription = new TenantSubscription([
            'price_amount' => 1000,
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'discount_starts_at' => '2026-03-01',
            'discount_ends_at' => '2026-08-31',
            'tax_rate' => 0,
            'tax_included' => false,
        ]);
        $service = new TenantSubscriptionBillingService();

        $this->assertSame(900.0, $service->quote($subscription, Carbon::parse('2026-04-01'))['total']);
        $this->assertSame(1000.0, $service->quote($subscription, Carbon::parse('2026-09-01'))['total']);
    }

    public function test_tax_is_added_after_a_fixed_discount(): void
    {
        $subscription = new TenantSubscription([
            'price_amount' => 1000,
            'discount_type' => 'fixed',
            'discount_value' => 100,
            'tax_rate' => 15,
            'tax_included' => false,
        ]);

        $quote = (new TenantSubscriptionBillingService())->quote($subscription, Carbon::parse('2026-04-01'));

        $this->assertSame(900.0, $quote['subtotal']);
        $this->assertSame(135.0, $quote['tax']);
        $this->assertSame(1035.0, $quote['total']);
    }

    public function test_free_months_define_the_first_billing_date(): void
    {
        $subscription = new TenantSubscription([
            'starts_at' => '2026-01-15',
            'free_months' => 2,
        ]);

        $date = (new TenantSubscriptionBillingService())->billingStart($subscription);

        $this->assertSame('2026-03-15', $date->toDateString());
    }
}
