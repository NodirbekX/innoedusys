<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OraliqNazorat extends Model
{
    protected $table = 'oraliq_nazorat';

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'max_score',
        'assignment_file',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function submissions()
    {
        return $this->hasMany(OraliqSubmission::class, 'oraliq_id');
    }
}
