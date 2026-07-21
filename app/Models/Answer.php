<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'id_question',
        'name',
        'bobot',
        'is_correct',   // ← flag jawaban benar untuk soal pilihan ganda
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'bobot'      => 'integer',
    ];

    /**
     * Answer belongs to a question.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'id_question', 'id');
    }
    
    public function answers()
    {
        return $this->hasMany(UserAnswer::class, 'answer_id');
    }

    /**
     * Answer has many translations.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AnswerTranslation::class, 'answer_id', 'id');
    }

    /**
     * Answer translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(AnswerTranslation::class, 'answer_id', 'id')
            ->where('locale', app()->getLocale());
    }
}
