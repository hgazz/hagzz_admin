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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->unique();
            $table->enum('child_type', ['parent', 'child','athlete'])->nullable();
            $table->string('school_name')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->enum('coach_preference', ['male', 'female', 'not_important'])->nullable();
            $table->enum('frequent_attendance', ['daily', 'weekly', 'monthly'])->nullable();
            $table->enum('relation_with_child', ['father', 'mother', 'brother', 'sister', 'guardian'])->nullable();
            $table->enum('referral_source', ['friends', 'facebook', 'hagzz_app'])->nullable();
            $table->enum('medical_condition', ['yes', 'no'])->nullable();
            $table->text('medical_condition_details')->nullable();
            $table->text('additional_information')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
