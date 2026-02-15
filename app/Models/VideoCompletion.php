<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoCompletion extends Model
{
    protected $fillable = [
        'user_id',
        'material_id',
        'earned_points',
        'total_points',
        'percentage',
        'is_completed',
    ];

    protected $casts = [
        'earned_points' => 'integer',
        'total_points' => 'integer',
        'percentage' => 'decimal:2',
        'is_completed' => 'boolean',
    ];

    /**
     * Get the user who completed this video.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the material this completion belongs to.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
