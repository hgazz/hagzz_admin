<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\TenantSubscriptionInvoice;
use Illuminate\Http\Request;

class InvoicePrintController extends Controller
{
    public function booking(Request $request, Invoice $invoice)
    {
        $invoice->loadMissing(['user', 'training.academy.country']);
        abort_unless($invoice->training && $invoice->training->academy, 404);

        $academy = $invoice->training->academy;
        $paid = $invoice->getAttribute('paid_amount');
        $paid = $paid === null ? (float) $invoice->amount : (float) $paid;
        $total = (float) $invoice->amount;

        return $this->render($request, [
            'type' => 'booking',
            'number' => $invoice->order_number ?: 'BK-' . $invoice->id,
            'issued_at' => $invoice->created_at,
            'seller' => $this->academyParty($academy),
            'buyer' => $this->party($invoice->user?->name, $invoice->user?->phone, $invoice->user?->email),
            'lines' => [[
                'description' => $invoice->training?->name ?: 'Training booking',
                'quantity' => 1,
                'unit_price' => $total,
                'total' => $total,
            ]],
            'subtotal' => $total,
            'discount' => 0,
            'tax' => 0,
            'total' => $total,
            'paid' => $paid,
            'balance' => max(0, $total - $paid),
            'currency' => $academy->country?->currency_code ?: 'EGP',
            'status' => $invoice->is_canceled ? 'cancelled' : ($paid >= $total ? 'paid' : ($paid > 0 ? 'partial' : 'unpaid')),
            'payment_method' => $invoice->getAttribute('payment_method') ?: $invoice->user_type,
        ]);
    }

    public function subscription(Request $request, TenantSubscriptionInvoice $invoice)
    {
        $invoice->loadMissing(['academy', 'subscription.plan', 'payments']);
        abort_unless($invoice->academy, 404);
        $settings = Setting::whereIn('key', ['phone', 'email', 'egypt_address', 'qatar_address'])->pluck('value', 'key');
        $plan = $invoice->subscription?->plan?->name;

        return $this->render($request, [
            'type' => 'platform_subscription',
            'number' => $invoice->invoice_number,
            'issued_at' => $invoice->issued_at,
            'due_at' => $invoice->due_at,
            'seller' => $this->party('Hagzz', $settings['phone'] ?? null, $settings['email'] ?? null, null, $settings['egypt_address'] ?? ($settings['qatar_address'] ?? null)),
            'buyer' => $this->academyParty($invoice->academy),
            'lines' => [[
                'description' => trim(($plan ?: 'Hagzz platform subscription') . ' · ' . optional($invoice->period_starts_at)->format('Y-m-d') . ' — ' . optional($invoice->period_ends_at)->format('Y-m-d')),
                'quantity' => 1,
                'unit_price' => (float) $invoice->list_amount,
                'total' => (float) $invoice->subtotal_amount,
            ]],
            'subtotal' => (float) $invoice->list_amount,
            'discount' => (float) $invoice->discount_amount,
            'tax' => (float) $invoice->tax_amount,
            'tax_rate' => (float) $invoice->tax_rate,
            'total' => (float) $invoice->total_amount,
            'paid' => (float) $invoice->paid_amount,
            'balance' => $invoice->balance,
            'currency' => $invoice->currency_code,
            'status' => $invoice->status,
            'payment_method' => $invoice->payments->sortByDesc('paid_at')->first()?->payment_method,
            'notes' => $invoice->notes,
        ]);
    }

    private function render(Request $request, array $document)
    {
        $paper = $request->validate(['paper' => ['nullable', 'in:a4,a5,pos']])['paper'] ?? 'a4';
        return view('Admin.pages.invoice_print.show', compact('document', 'paper'));
    }

    private function academyParty($academy): array
    {
        return $this->party($academy?->commercial_name, $academy?->phone, $academy?->email, $academy?->tax_number, $academy?->address);
    }

    private function party($name, $phone = null, $email = null, $taxNumber = null, $address = null): array
    {
        return compact('name', 'phone', 'email', 'taxNumber', 'address');
    }
}
