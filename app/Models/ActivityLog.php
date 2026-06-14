<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'role',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

  

public static function record(
    string $action,
    string $description,
    string $subjectType = null,
    string $subjectId = null,
    string $userId = null
) {
    self::create([
        'user_id' => $userId ?? auth()->id(),
        'role' => auth()->user()->role ?? null,
        'action' => $action,
        'description' => $description,
        'subject_type' => $subjectType,
        'subject_id' => $subjectId,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
}