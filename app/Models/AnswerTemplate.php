<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnswerTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * AnswerTemplate has many questions.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'id_answer_template', 'id');
    }

    /**
     * AnswerTemplate has many default answers.
     */
    public function defaultAnswers()
    {
        return $this->hasMany(DefaultAnswer::class, 'id_answer_template', 'id');
    }

    /**
     * Template has many translations
     */
    public function translations()
    {
        return $this->hasMany(AnswerTemplateTranslation::class, 'answer_template_id', 'id');
    }

    /**
     * AnswerTemplate translation for the current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(AnswerTemplateTranslation::class, 'answer_template_id', 'id')
            ->where('locale', app()->getLocale());
    }
}
