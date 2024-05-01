<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('academies', function (Blueprint $table) {
          $table->date('contract_date')->nullable();
          $table->date('start_date')->nullable();
          $table->date('end_date')->nullable();
          $table->text('first_name')->nullable();
          $table->text('last_name')->nullable();
          $table->text('app_name')->nullable();
          $table->text('image')->nullable();
          $table->text('linkedin')->nullable();
          $table->text('website')->nullable();
          $table->text('bank_account_type')->nullable();
          $table->text('bank_name')->nullable();
          $table->text('beneficiary_name')->nullable();
          $table->text('commission_percentage')->nullable();
          $table->integer('bank_account_number')->nullable();
          $table->dropForeign('academies_country_id_foreign');
          $table->dropColumn('country_id');
          $table->dropForeign('academies_city_id_foreign');
          $table->dropColumn('city_id');
          $table->dropForeign('academies_area_id_foreign');
          $table->dropColumn('area_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academies', function (Blueprint $table) {
            //
        });
    }
};
