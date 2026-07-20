<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            $table->decimal('list_price_amount', 12, 2)->nullable()->after('price_amount');
            $table->string('offer_name')->nullable()->after('tax_included');
            $table->unsignedSmallInteger('free_months')->default(0)->after('offer_name');
            $table->string('discount_type', 20)->nullable()->after('free_months');
            $table->decimal('discount_value', 12, 2)->default(0)->after('discount_type');
            $table->date('discount_starts_at')->nullable()->after('discount_value');
            $table->date('discount_ends_at')->nullable()->after('discount_starts_at');
            $table->date('billing_starts_at')->nullable()->after('trial_ends_at');
            $table->date('next_billing_at')->nullable()->after('billing_starts_at');
            $table->unsignedSmallInteger('grace_days')->default(7)->after('next_billing_at');
            $table->text('billing_notes')->nullable()->after('grace_days');
            $table->index(['status', 'next_billing_at'], 'tenant_subscriptions_billing_idx');
        });

        Schema::create('tenant_subscription_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_subscription_id')->constrained('tenant_subscriptions')->cascadeOnDelete();
            $table->foreignId('academy_id')->constrained('academies')->cascadeOnDelete();
            $table->json('before')->nullable();
            $table->json('after');
            $table->foreignId('changed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
            $table->index(['academy_id', 'created_at']);
        });

        Schema::create('tenant_subscription_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_subscription_id')->constrained('tenant_subscriptions')->cascadeOnDelete();
            $table->foreignId('academy_id')->constrained('academies')->cascadeOnDelete();
            $table->string('invoice_number', 60)->unique();
            $table->date('period_starts_at');
            $table->date('period_ends_at');
            $table->date('issued_at');
            $table->date('due_at');
            $table->decimal('list_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('subtotal_amount', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->char('currency_code', 3);
            $table->string('status', 20)->default('issued');
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['tenant_subscription_id', 'period_starts_at'], 'subscription_period_unique');
            $table->index(['status', 'due_at']);
            $table->index(['academy_id', 'issued_at']);
        });

        Schema::create('tenant_subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_subscription_invoice_id')->constrained('tenant_subscription_invoices')->cascadeOnDelete();
            $table->foreignId('academy_id')->constrained('academies')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->char('currency_code', 3);
            $table->dateTime('paid_at');
            $table->string('payment_method', 30)->default('bank_transfer');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
            $table->index(['academy_id', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_subscription_payments');
        Schema::dropIfExists('tenant_subscription_invoices');
        Schema::dropIfExists('tenant_subscription_revisions');
        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            $table->dropIndex('tenant_subscriptions_billing_idx');
            $table->dropColumn([
                'list_price_amount', 'offer_name', 'free_months', 'discount_type', 'discount_value',
                'discount_starts_at', 'discount_ends_at', 'billing_starts_at', 'next_billing_at',
                'grace_days', 'billing_notes',
            ]);
        });
    }
};
