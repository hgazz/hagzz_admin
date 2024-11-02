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
        DB::statement("ALTER TABLE settings MODIFY COLUMN `key` ENUM('logo', 'phone', 'whatsapp', 'about', 'email', 'facebook', 'twitter', 'instagram', 'telegram', 'egypt_address', 'qatar_address', 'snapchat', 'youtube', 'terms', 'privacy')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
