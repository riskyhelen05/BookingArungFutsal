<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'google_maps',
        'operational_hours',
    ];
}