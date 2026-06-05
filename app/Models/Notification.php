<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'booking_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // 🔗 relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔥 TAMBAHAN (biar clean & future-proof)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function show($id)
{
    $notification = Notification::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $notification->update([
        'is_read' => true
    ]);

    return view('user.notifications.show', compact('notification'));
}
}