<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YakuniyResult extends Model
{
    protected $table = 'yakuniy_results';

    protected $fillable = ['user_id', 'total_score', 'submitted_at'];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
