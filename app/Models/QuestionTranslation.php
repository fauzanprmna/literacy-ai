<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    protected $table = 'question_translations';

    protected $fillable = [
        'question_id',
        'locale',
        'header',
        'question',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
