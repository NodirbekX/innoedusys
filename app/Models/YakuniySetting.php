<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YakuniySetting extends Model
{
    protected $table = 'yakuniy_settings';

    protected $fillable = ['start_time', 'end_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
