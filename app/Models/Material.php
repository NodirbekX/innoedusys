<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['title', 'description', 'video_path', 'presentation_path', 'tests'];

    protected $casts = [
        'tests' => 'array', // Automatically converts JSON to PHP array
    ];
    /**
     * Get all assignments for this material.
     */
    public function assignments()
    {
        return $this->hasMany(TeacherAssignment::class);
    }

    /**
     * Get all user question answers for this material.
     */
    public function userQuestionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }

    /**
     * Get all video completions for this material.
     */
    public function videoCompletions()
    {
        return $this->hasMany(VideoCompletion::class);
    }

    /**
     * Get all glossary terms for this material.
     */
    public function glossaries()
    {
        return $this->hasMany(Glossary::class);
    }
}
