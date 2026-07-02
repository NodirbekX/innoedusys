<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OraliqSubmission extends Model
{
    protected $table = 'oraliq_submissions';

    protected $fillable = [
        'oraliq_id',
        'user_id',
        'solution_file',
        'score',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function oraliqNazorat()
    {
        return $this->belongsTo(OraliqNazorat::class, 'oraliq_id');
    }
}
