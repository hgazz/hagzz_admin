<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academies;
use App\Models\TenantSubscription;
use App\Models\TenantSubscriptionInvoice;
use App\Models\TenantSubscriptionPayment;
use App\Services\TenantSubscriptionBillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionRevenueController extends Controller
{
    public function __construct(private TenantSubscriptionBillingService $billing) {}

    public function index(Request $request)
    {
        $subscriptions = $this->subscriptions($request);
        $rows = $subscriptions->map(fn (TenantSubscription $subscription) => $this->row($subscription));
        if ($request->filled('billing_status')) {
            $rows = $rows->where('billing_status', $request->billing_status)->values();
        }
        if ($request->filled('offer_status')) {
            $rows = $rows->where('offer_status', $request->offer_status)->values();
        }

        $totals = $this->currencyTotals($rows);
        $counts = [
            'partners' => Academies::count(),
            'without_subscription' => Academies::doesntHave('subscriptions')->count(),
            'free_offer' => $rows->where('offer_status', 'free_offer')->count(),
            'discounted' => $rows->where('offer_status', 'discounted')->count(),
            'paying' => $rows->where('billing_status', 'paying')->count(),
            'due' => $rows->whereIn('billing_status', ['due', 'ready_to_invoice'])->count(),
            'overdue' => $rows->where('billing_status', 'overdue')->count(),
        ];

        $invoices = TenantSubscriptionInvoice::with(['academy', 'subscription.plan'])
            ->when($request->academy_id, fn ($q, $id) => $q->where('academy_id', $id))
            ->latest('issued_at')->latest('id')->limit(100)->get();
        $academies = Academies::orderBy('commercial_name')->get(['id', 'commercial_name']);

        return view('Admin.pages.subscription_revenue.index', compact('rows', 'totals', 'counts', 'invoices', 'academies'));
    }

    public function generate(Request $request)
    {
        $subscription = $request->filled('subscription_id')
            ? TenantSubscription::findOrFail($request->subscription_id)
            : null;
        $created = $this->billing->generateDueInvoices($subscription);

        return back()->with('success', trans('admin.subscription_revenue.generated', ['count' => $created]));
    }

    public function payment(Request $request, TenantSubscriptionInvoice $invoice)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'paid_at' => ['required', 'date'],
            'payment_method' => ['required', 'in:bank_transfer,cash,card,online,other'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($invoice, $validated) {
            $locked = TenantSubscriptionInvoice::lockForUpdate()->findOrFail($invoice->id);
            if ($locked->status === 'void' || (float) $validated['amount'] > $locked->balance + 0.001) {
                throw ValidationException::withMessages(['amount' => trans('admin.subscription_revenue.invalid_payment')]);
            }

            TenantSubscriptionPayment::create([
                'tenant_subscription_invoice_id' => $locked->id,
                'academy_id' => $locked->academy_id,
                'amount' => $validated['amount'],
                'currency_code' => $locked->currency_code,
                'paid_at' => $validated['paid_at'],
                'payment_method' => $validated['payment_method'],
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'recorded_by' => auth('admin')->id(),
            ]);

            $paid = (float) $locked->payments()->sum('amount');
            $isPaid = $paid + 0.001 >= (float) $locked->total_amount;
            $locked->update([
                'paid_amount' => min($paid, (float) $locked->total_amount),
                'status' => $isPaid ? 'paid' : 'partial',
                'paid_at' => $isPaid ? $validated['paid_at'] : null,
            ]);
        });

        return back()->with('success', trans('admin.subscription_revenue.payment_saved'));
    }

    public function void(TenantSubscriptionInvoice $invoice)
    {
        abort_if((float) $invoice->paid_amount > 0, 422, trans('admin.subscription_revenue.cannot_void_paid'));
        $invoice->update(['status' => 'void']);

        return back()->with('success', trans('admin.subscription_revenue.invoice_voided'));
    }

    public function export(Request $request)
    {
        $rows = $this->subscriptions($request)->map(fn (TenantSubscription $subscription) => $this->row($subscription));
        if ($request->filled('billing_status')) $rows = $rows->where('billing_status', $request->billing_status);
        if ($request->filled('offer_status')) $rows = $rows->where('offer_status', $request->offer_status);

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Partner', 'Plan', 'Cycle', 'Currency', 'List price', 'Effective price', 'Offer', 'Billing status', 'Billing starts', 'Next billing', 'Invoiced', 'Collected', 'Outstanding']);
            foreach ($rows as $row) {
                fputcsv($out, [
                    $row['academy']->commercial_name, $row['subscription']->plan?->name, $row['subscription']->billing_cycle,
                    $row['currency'], $row['list_price'], $row['effective_price'], $row['offer_status'], $row['billing_status'],
                    optional($row['billing_start'])->format('Y-m-d'), optional($row['subscription']->next_billing_at)->format('Y-m-d'),
                    $row['invoiced'], $row['collected'], $row['outstanding'],
                ]);
            }
            fclose($out);
        }, 'hagzz-partner-subscriptions-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function subscriptions(Request $request): Collection
    {
        return TenantSubscription::with(['academy.country', 'plan', 'invoices.payments'])
            ->when($request->academy_id, fn ($q, $id) => $q->where('academy_id', $id))
            ->when($request->subscription_status, fn ($q, $status) => $q->where('status', $status))
            ->orderByDesc('id')->get()->unique('academy_id')->values();
    }

    private function row(TenantSubscription $subscription): array
    {
        $today = now()->startOfDay();
        $billingStart = $this->billing->billingStart($subscription);
        $quote = $this->billing->quote($subscription, $billingStart->gt($today) ? $billingStart : $today);
        $validInvoices = $subscription->invoices->where('status', '!=', 'void');
        $outstandingInvoices = $validInvoices->filter(fn ($invoice) => (float) $invoice->total_amount > (float) $invoice->paid_amount);
        $hasOverdue = $outstandingInvoices->contains(fn ($invoice) => $invoice->due_at->lt($today));

        if (in_array($subscription->status, ['cancelled', 'suspended'], true)) $billingStatus = $subscription->status;
        elseif ($subscription->ends_at && $subscription->ends_at->lt($today)) $billingStatus = 'expired';
        elseif ($subscription->starts_at->gt($today) || $billingStart->gt($today)) $billingStatus = 'not_started';
        elseif ($hasOverdue) $billingStatus = 'overdue';
        elseif ($outstandingInvoices->isNotEmpty()) $billingStatus = 'due';
        elseif ($validInvoices->isEmpty()) $billingStatus = 'ready_to_invoice';
        else $billingStatus = 'paying';

        $discountActive = (float) $subscription->discount_value > 0
            && (!$subscription->discount_starts_at || $today->gte($subscription->discount_starts_at))
            && (!$subscription->discount_ends_at || $today->lte($subscription->discount_ends_at));
        if ($subscription->starts_at->gt($today)) $offerStatus = 'scheduled';
        elseif ($billingStart->gt($today)) $offerStatus = 'free_offer';
        elseif ($discountActive) $offerStatus = 'discounted';
        else $offerStatus = 'standard';

        return [
            'subscription' => $subscription,
            'academy' => $subscription->academy,
            'billing_start' => $billingStart,
            'billing_status' => $billingStatus,
            'offer_status' => $offerStatus,
            'currency' => $subscription->currency_code ?: 'EGP',
            'list_price' => (float) ($subscription->list_price_amount ?? $subscription->price_amount),
            'effective_price' => $quote['total'],
            'mrr' => $subscription->billing_cycle === 'annual' ? round($quote['total'] / 12, 2) : $quote['total'],
            'invoiced' => round((float) $validInvoices->sum('total_amount'), 2),
            'collected' => round((float) $validInvoices->sum('paid_amount'), 2),
            'outstanding' => round((float) $validInvoices->sum(fn ($invoice) => max(0, (float) $invoice->total_amount - (float) $invoice->paid_amount)), 2),
        ];
    }

    private function currencyTotals(Collection $rows): Collection
    {
        return $rows->groupBy('currency')->map(fn (Collection $currencyRows, string $currency) => [
            'currency' => $currency,
            'mrr' => round($currencyRows->sum('mrr'), 2),
            'arr' => round($currencyRows->sum('mrr') * 12, 2),
            'invoiced' => round($currencyRows->sum('invoiced'), 2),
            'collected' => round($currencyRows->sum('collected'), 2),
            'outstanding' => round($currencyRows->sum('outstanding'), 2),
        ])->values();
    }
}
