<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('role', ['user', 'admin'])->nullable();
            $table->string('action', 50);
            $table->string('description');
            $table->string('subject_type', 50)->nullable();
            $table->uuid('subject_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id',    'idx_log_user');
            $table->index('action',     'idx_log_action');
            $table->index('created_at', 'idx_log_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};