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
Schema::create('blocked_slots', function (Blueprint $table) {
    $table->id();

    // 🔥 UUID
    $table->char('field_id', 36);

    $table->date('block_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->enum('status', ['maintenance', 'closed']);
    $table->text('notes')->nullable();

    $table->char('created_by', 36)->nullable(); // kalau user juga UUID

    $table->timestamps();

    // 🔥 FOREIGN KEY (HARUS MATCH)
    $table->foreign('field_id')
        ->references('id')
        ->on('fields')
        ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_slots');
    }
};
