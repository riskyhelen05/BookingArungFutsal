<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScheduleBlock extends Model
{
    protected $table = 'schedule_blocks';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'field_id', 'block_date', 'start_time', 'end_time',
        'status', 'notes', 'created_by', 'created_at',
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

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
