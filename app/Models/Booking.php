<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'reservation_code', 'user_id', 'field_id',
        'booking_date', 'start_time', 'end_time',
        'duration_hours', 'price_per_hour', 'total_amount', 'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (empty($model->reservation_code)) {
                $model->reservation_code = 'BKK' . now()->format('YmdHis') . strtoupper(Str::random(4));
            }
        });
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending'              => ['label' => 'Menunggu', 'class' => 'badge-warning'],
            'waiting_confirmation' => ['label' => 'Menunggu Konfirmasi', 'class' => 'badge-info'],
            'confirmed'            => ['label' => 'Dikonfirmasi', 'class' => 'badge-success'],
            'cancelled'            => ['label' => 'Dibatalkan', 'class' => 'badge-error'],
            'completed'            => ['label' => 'Selesai', 'class' => 'badge-neutral'],
            default                => ['label' => $this->status, 'class' => 'badge-ghost'],
        };
    }
}
