<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();
            // Preserve history even if the administrator is deleted.
            $table->unsignedBigInteger('admin_id')->index();
            $table->string('actor_name');
            $table->string('action')->index();
            $table->string('method', 10);
            $table->json('target_ids')->nullable();
            $table->unsignedSmallInteger('response_status');
            $table->string('result', 20)->index();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('created_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_audit_logs');
    }
};
