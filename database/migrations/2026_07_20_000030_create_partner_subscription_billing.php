<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasForeign = function (string $table, string $column): bool {
            if (Schema::getConnection()->getDriverName() !== 'mysql') {
                return false;
            }

            return DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
                ->where('TABLE_NAME', $table)
                ->where('COLUMN_NAME', $column)
                ->whereNotNull('REFERENCED_TABLE_NAME')
                ->exists();
        };
        $hasIndex = function (string $table, string $index): bool {
            if (Schema::getConnection()->getDriverName() !== 'mysql') {
                return false;
            }

            return DB::table('information_schema.STATISTICS')
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
                ->where('TABLE_NAME', $table)
                ->where('INDEX_NAME', $index)
                ->exists();
        };

        Schema::table('tenant_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('tenant_subscriptions', 'list_price_amount')) $table->decimal('list_price_amount', 12, 2)->nullable()->after('price_amount');
            if (!Schema::hasColumn('tenant_subscriptions', 'offer_name')) $table->string('offer_name')->nullable()->after('tax_included');
            if (!Schema::hasColumn('tenant_subscriptions', 'free_months')) $table->unsignedSmallInteger('free_months')->default(0)->after('offer_name');
            if (!Schema::hasColumn('tenant_subscriptions', 'discount_type')) $table->string('discount_type', 20)->nullable()->after('free_months');
            if (!Schema::hasColumn('tenant_subscriptions', 'discount_value')) $table->decimal('discount_value', 12, 2)->default(0)->after('discount_type');
            if (!Schema::hasColumn('tenant_subscriptions', 'discount_starts_at')) $table->date('discount_starts_at')->nullable()->after('discount_value');
            if (!Schema::hasColumn('tenant_subscriptions', 'discount_ends_at')) $table->date('discount_ends_at')->nullable()->after('discount_starts_at');
            if (!Schema::hasColumn('tenant_subscriptions', 'billing_starts_at')) $table->date('billing_starts_at')->nullable()->after('trial_ends_at');
            if (!Schema::hasColumn('tenant_subscriptions', 'next_billing_at')) $table->date('next_billing_at')->nullable()->after('billing_starts_at');
            if (!Schema::hasColumn('tenant_subscriptions', 'grace_days')) $table->unsignedSmallInteger('grace_days')->default(7)->after('next_billing_at');
            if (!Schema::hasColumn('tenant_subscriptions', 'billing_notes')) $table->text('billing_notes')->nullable()->after('grace_days');
        });
        if (!$hasIndex('tenant_subscriptions', 'tenant_subscriptions_billing_idx')) {
            Schema::table('tenant_subscriptions', fn (Blueprint $table) => $table->index(['status', 'next_billing_at'], 'tenant_subscriptions_billing_idx'));
        }

        if (!Schema::hasTable('tenant_subscription_revisions')) Schema::create('tenant_subscription_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_subscription_id')->constrained('tenant_subscriptions')->cascadeOnDelete();
            $table->foreignId('academy_id')->constrained('academies')->cascadeOnDelete();
            $table->json('before')->nullable();
            $table->json('after');
            $table->foreignId('changed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
            $table->index(['academy_id', 'created_at']);
        });

        if (!Schema::hasTable('tenant_subscription_invoices')) Schema::create('tenant_subscription_invoices', function (Blueprint $table) {
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

        $paymentsTableExisted = Schema::hasTable('tenant_subscription_payments');
        if (!$paymentsTableExisted) Schema::create('tenant_subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_subscription_invoice_id');
            $table->foreignId('academy_id');
            $table->decimal('amount', 12, 2);
            $table->char('currency_code', 3);
            $table->dateTime('paid_at');
            $table->string('payment_method', 30)->default('bank_transfer');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable();
            $table->timestamps();
            $table->foreign('tenant_subscription_invoice_id', 'ts_payments_invoice_fk')->references('id')->on('tenant_subscription_invoices')->cascadeOnDelete();
            $table->foreign('academy_id', 'ts_payments_academy_fk')->references('id')->on('academies')->cascadeOnDelete();
            $table->foreign('recorded_by', 'ts_payments_admin_fk')->references('id')->on('admins')->nullOnDelete();
            $table->index(['academy_id', 'paid_at'], 'ts_payments_academy_paid_idx');
        });

        if ($paymentsTableExisted && !$hasForeign('tenant_subscription_payments', 'tenant_subscription_invoice_id')) {
            Schema::table('tenant_subscription_payments', fn (Blueprint $table) => $table->foreign('tenant_subscription_invoice_id', 'ts_payments_invoice_fk')->references('id')->on('tenant_subscription_invoices')->cascadeOnDelete());
        }
        if ($paymentsTableExisted && !$hasForeign('tenant_subscription_payments', 'academy_id')) {
            Schema::table('tenant_subscription_payments', fn (Blueprint $table) => $table->foreign('academy_id', 'ts_payments_academy_fk')->references('id')->on('academies')->cascadeOnDelete());
        }
        if ($paymentsTableExisted && !$hasForeign('tenant_subscription_payments', 'recorded_by')) {
            Schema::table('tenant_subscription_payments', fn (Blueprint $table) => $table->foreign('recorded_by', 'ts_payments_admin_fk')->references('id')->on('admins')->nullOnDelete());
        }
        if ($paymentsTableExisted && !$hasIndex('tenant_subscription_payments', 'ts_payments_academy_paid_idx')) {
            Schema::table('tenant_subscription_payments', fn (Blueprint $table) => $table->index(['academy_id', 'paid_at'], 'ts_payments_academy_paid_idx'));
        }
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
