<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YakuniyOption extends Model
{
    protected $table = 'yakuniy_options';

    protected $fillable = ['question_id', 'option_text', 'is_correct'];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(YakuniyQuestion::class, 'question_id');
    }
}
