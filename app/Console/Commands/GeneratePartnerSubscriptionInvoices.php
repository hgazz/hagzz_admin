<?php

namespace App\Console\Commands;

use App\Services\TenantSubscriptionBillingService;
use Illuminate\Console\Command;

class GeneratePartnerSubscriptionInvoices extends Command
{
    protected $signature = 'billing:generate-partner-invoices';
    protected $description = 'Generate all due Hagzz partner subscription invoices';

    public function handle(TenantSubscriptionBillingService $billing): int
    {
        $count = $billing->generateDueInvoices();
        $this->info("Generated {$count} partner subscription invoice(s).");

        return self::SUCCESS;
    }
}
