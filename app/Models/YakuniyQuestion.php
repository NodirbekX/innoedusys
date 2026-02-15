<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YakuniyQuestion extends Model
{
    protected $table = 'yakuniy_questions';

    protected $fillable = ['question_text', 'score'];

    public function options()
    {
        return $this->hasMany(YakuniyOption::class, 'question_id');
    }
}
