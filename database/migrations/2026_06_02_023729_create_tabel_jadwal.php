<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_blocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('field_id')->constrained('fields')->cascadeOnDelete();
            $table->date('block_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['maintenance', 'closed']);
            $table->string('notes', 150)->nullable();
            $table->foreignUuid('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['field_id', 'block_date', 'start_time'], 'unique_block_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_blocks');
    }
};