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
        Schema::create('academies', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name_arabic')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role', ['manager', 'owner', 'partner']);
            $table->string('commercial_name');
            $table->string('trade_license_number');
            $table->date('trade_license_expire_date');
            $table->string('tax_number')->nullable();
            $table->unsignedBigInteger('percentage')->nullable();
            $table->string('national_id_number')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academies');
    }
};
