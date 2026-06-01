<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerTemplateTranslation extends Model
{
    protected $table = 'answer_template_translations';

    protected $fillable = [
        'answer_template_id',
        'locale',
        'name',
    ];

    public function answerTemplate()
    {
        return $this->belongsTo(AnswerTemplate::class);
    }
}
