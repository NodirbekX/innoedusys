<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'published' => 'boolean',
        'total_attempts' => 'integer',
        'time_limit' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeActive($query)
    {
        return $query->where('published', true)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now());
    }

    public function scopeMidterm($query)
    {
        return $query->where('type', 'midterm');
    }

    public function scopeFinal($query)
    {
        return $query->where('type', 'final');
    }
}
