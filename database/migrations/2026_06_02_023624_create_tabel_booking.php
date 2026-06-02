<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reservation_code', 20)->unique();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('field_id')->constrained('fields');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('duration_hours');
            $table->unsignedInteger('price_per_hour');
            $table->unsignedInteger('total_amount');
            $table->enum('status', [
                'pending',
                'waiting_confirmation',
                'confirmed',
                'cancelled',
                'completed',
            ])->default('pending');
            $table->timestamps();

            $table->unique(['field_id', 'booking_date', 'start_time'], 'unique_booking_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};