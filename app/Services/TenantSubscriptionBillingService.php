<?php

namespace App\Services;

use App\Models\TenantSubscription;
use App\Models\TenantSubscriptionInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TenantSubscriptionBillingService
{
    public function billingStart(TenantSubscription $subscription): Carbon
    {
        if ($subscription->billing_starts_at) {
            return $subscription->billing_starts_at->copy();
        }

        if ($subscription->trial_ends_at) {
            return $subscription->trial_ends_at->copy()->addDay();
        }

        return $subscription->starts_at->copy()->addMonthsNoOverflow((int) $subscription->free_months);
    }

    public function quote(TenantSubscription $subscription, Carbon $periodStart): array
    {
        $list = (float) ($subscription->price_amount ?? $subscription->list_price_amount ?? 0);
        $discount = 0.0;
        $discountActive = (float) $subscription->discount_value > 0
            && (!$subscription->discount_starts_at || $periodStart->gte($subscription->discount_starts_at))
            && (!$subscription->discount_ends_at || $periodStart->lte($subscription->discount_ends_at));

        if ($discountActive) {
            $discount = $subscription->discount_type === 'percentage'
                ? $list * min(100, (float) $subscription->discount_value) / 100
                : min($list, (float) $subscription->discount_value);
        }

        $subtotal = max(0, $list - $discount);
        $taxRate = (float) $subscription->tax_rate;
        if ($subscription->tax_included && $taxRate > 0) {
            $tax = $subtotal - ($subtotal / (1 + ($taxRate / 100)));
            $total = $subtotal;
        } else {
            $tax = $subtotal * $taxRate / 100;
            $total = $subtotal + $tax;
        }

        return [
            'list' => round($list, 2),
            'discount' => round($discount, 2),
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'total' => round($total, 2),
        ];
    }

    public function generateDueInvoices(?TenantSubscription $only = null, ?Carbon $through = null): int
    {
        $through ??= now()->startOfDay();
        $query = TenantSubscription::query()->where('status', 'active')->with('invoices');
        if ($only) {
            $query->whereKey($only->id);
        }

        $created = 0;
        foreach ($query->get() as $subscription) {
            $cursor = ($subscription->next_billing_at ?: $this->billingStart($subscription))->copy()->startOfDay();
            while ($cursor->lte($through) && (!$subscription->ends_at || $cursor->lte($subscription->ends_at))) {
                $periodEnd = $subscription->billing_cycle === 'annual'
                    ? $cursor->copy()->addYear()->subDay()
                    : $cursor->copy()->addMonthNoOverflow()->subDay();
                if ($subscription->ends_at && $periodEnd->gt($subscription->ends_at)) {
                    $periodEnd = $subscription->ends_at->copy();
                }
                $quote = $this->quote($subscription, $cursor);
                $invoiceNumber = 'HZS-'.$cursor->format('Ym').'-'.$subscription->id.'-'.$cursor->format('Ymd');

                DB::transaction(function () use ($subscription, $cursor, $periodEnd, $quote, $invoiceNumber, &$created) {
                    $invoice = TenantSubscriptionInvoice::firstOrCreate(
                        ['tenant_subscription_id' => $subscription->id, 'period_starts_at' => $cursor->toDateString()],
                        [
                            'academy_id' => $subscription->academy_id,
                            'invoice_number' => $invoiceNumber,
                            'period_ends_at' => $periodEnd->toDateString(),
                            'issued_at' => $cursor->toDateString(),
                            'due_at' => $cursor->copy()->addDays((int) $subscription->grace_days)->toDateString(),
                            'list_amount' => $quote['list'],
                            'discount_amount' => $quote['discount'],
                            'subtotal_amount' => $quote['subtotal'],
                            'tax_rate' => $subscription->tax_rate,
                            'tax_amount' => $quote['tax'],
                            'total_amount' => $quote['total'],
                            'currency_code' => $subscription->currency_code ?: 'EGP',
                            'status' => 'issued',
                        ]
                    );
                    if ($invoice->wasRecentlyCreated) {
                        $created++;
                    }
                });

                $cursor = $subscription->billing_cycle === 'annual'
                    ? $cursor->copy()->addYear()
                    : $cursor->copy()->addMonthNoOverflow();
            }

            $subscription->update(['next_billing_at' => $cursor->toDateString()]);
        }

        TenantSubscriptionInvoice::whereIn('status', ['issued', 'partial'])
            ->whereDate('due_at', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        return $created;
    }
}
