<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'photo_url',
        'price_per_hour',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'field_id');
    }

    public function scheduleBlocks()
    {
        return $this->hasMany(ScheduleBlock::class, 'field_id');
    }
}