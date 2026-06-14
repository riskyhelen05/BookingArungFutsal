<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedSlot extends Model
{
    protected $fillable = [
        'field_id',
        'block_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'created_by'
    ];

    public static function isBlocked($fieldId, $date, $start, $end)
    {
        return self::where('field_id', $fieldId)
            ->where('block_date', $date)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_time', '<=', $start)
                          ->where('end_time', '>=', $end);
                    });
            })
            ->exists();
    }
    public function field()
    {
    return $this->belongsTo(Field::class);
    }
    
public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
}