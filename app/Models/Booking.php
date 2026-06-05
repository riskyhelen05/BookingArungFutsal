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
        'cancel_reason',
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

    public function review()
    {
    return $this->hasOne(Review::class);
    }

    protected static function booted()
{
    // BOOKING BERHASIL
    static::created(function ($booking) {

        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Booking Berhasil 🎉',
            'message' => 'Booking lapangan berhasil untuk tanggal '
                . $booking->booking_date->format('d M Y'),
            'type' => 'booking_success',
            'booking_id' => $booking->id,
            'is_read' => false
        ]);

    });

    // BOOKING DIBATALKAN
    static::updated(function ($booking) {

        if ($booking->isDirty('status')
            && $booking->status === 'cancelled') {

            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking Dibatalkan ❌',
                'message' => 'Booking tanggal '
                    . $booking->booking_date->format('d M Y')
                    . ' telah dibatalkan.',
                'type' => 'booking_cancelled',
                'booking_id' => $booking->id,
                'is_read' => false
            ]);
        }

            // MINTA ULASAN
        if ($booking->isDirty('status')
            && $booking->status === 'completed') {

            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Berikan Ulasan ⭐',
                'message' => 'Terima kasih telah bermain. Yuk berikan ulasan untuk pengalamanmu.',
                'type' => 'review_request',
                'booking_id' => $booking->id,
                'is_read' => false
            ]);
        }

    });

}
}