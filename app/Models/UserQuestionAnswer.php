<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuestionAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'material_id',
        'question_index',
        'selected_answer',
        'is_correct',
        'earned_points',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'earned_points' => 'integer',
        'question_index' => 'integer',
    ];

    /**
     * Get the user who answered this question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the material this answer belongs to.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
