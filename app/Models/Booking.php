<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Booking extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'reservation_code',
        'user_id',
        'field_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'price_per_hour',
        'total_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'booking_id');
    }

    protected static function booted()
{
    static::created(function ($booking) {

        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Booking Berhasil 🎉',
            'message' => 'Lapangan berhasil kamu booking untuk tanggal ' . $booking->booking_date,
            'type' => 'booking_success',
            'booking_id' => $booking->id,
            'is_read' => false
        ]);

    });
}
}