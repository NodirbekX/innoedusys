<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeacherAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'title',
        'description',
        'deadline',
        'max_score',
        'file_path',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'max_score' => 'integer',
    ];

    /**
     * Get the material that owns this assignment.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get all submissions for this assignment.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'assignment_id');
    }
}

