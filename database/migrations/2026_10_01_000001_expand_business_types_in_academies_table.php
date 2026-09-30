<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * توسيع business_type في لوحة السوبر أدمن
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('academies', 'business_type')) {
            DB::statement(
                "ALTER TABLE academies 
                 MODIFY COLUMN business_type VARCHAR(20) NOT NULL DEFAULT 'academy'"
            );
        }

        DB::table('academies')
            ->whereNull('business_type')
            ->orWhere('business_type', '')
            ->update(['business_type' => 'academy']);
    }

    public function down(): void
    {
        DB::table('academies')
            ->whereIn('business_type', ['gym', 'health_center'])
            ->update(['business_type' => 'academy']);
    }
};
