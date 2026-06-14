<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Field extends Model
{
    protected $table = 'fields';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'description', 'photo_url', 'price_per_hour', 'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'field_id');
    }
    public function blockedSlots()
    {
    return $this->hasMany(BlockedSlot::class, 'field_id');
    }

    /**
     * Get slot status for a given date and hour.
     * Returns: 'penuh', 'pending', 'tersedia', 'blokir'
     */
    public function getSlotStatus(string $date, int $hour): array
    {
        $start = sprintf('%02d:00:00', $hour);
        $end   = sprintf('%02d:00:00', $hour + 1);

        // Check schedule blocks
        $blocked = BlockedSlot::where('field_id', $this->id)
            ->where('block_date', $date)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->first();

        if ($blocked) {
            return ['status' => 'blokir', 'label' => ucfirst($blocked->status)];
        }

        // Check bookings
        $booking = Booking::where('field_id', $this->id)
            ->where('booking_date', $date)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->whereNotIn('status', ['cancelled'])
            ->first();

        if (!$booking) {
            return ['status' => 'tersedia', 'label' => 'Tersedia'];
        }

        if (in_array($booking->status, ['confirmed', 'completed'])) {
            return ['status' => 'penuh', 'label' => 'Penuh'];
        }

        return ['status' => 'pending', 'label' => 'Pending'];
    }
}
