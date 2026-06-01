<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'id_kategori',
        'id_answer_template',
        'type',
        'bobot',
    ];

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }

    /**
     * Question belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id');
    }

    /**
     * Question may belong to an answer template.
     */
    public function answerTemplate()
    {
        return $this->belongsTo(AnswerTemplate::class, 'id_answer_template', 'id');
    }

    /**
     * Question has many answers.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question', 'id');
    }

    /**
     * Question has many translations.
     */
    public function translations()
    {
        return $this->hasMany(QuestionTranslation::class, 'question_id', 'id');
    }

    /**
     * Question translation for the current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(QuestionTranslation::class, 'question_id', 'id')
            ->where('locale', app()->getLocale());
    }
}
